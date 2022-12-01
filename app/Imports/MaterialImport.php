<?php

namespace App\Imports;

use App\Models\Material;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\{DB};
use Maatwebsite\Excel\Concerns\ToCollection;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('slug');

class MaterialImport implements ToCollection, WithHeadingRow
{
    public $nodo;
    public $ideaRepository;
    public $validaciones;
    public $hoja = 'Materiales';

    public function __construct($nodo)
    {
        $this->nodo = $nodo;
        $this->validaciones = new ValidacionesImport;
    }

    /**
     * Validar encabezado
     *
     * @param Collection $row
     * @return bool
     * @author dum
     **/
    public function validar_encabezado(Collection $row)
    {
        $encabezado = [
            'codigo_de_material',
            'linea',
            'nodo',
            'nombre',
            'fecha_de_adquisicion',
            'tipo_de_material',
            'categoria',
            'presentacion',
            'medida',
            'cantidad',
            'valor_de_compra',
            'proveedor',
            'marca'
        ];
        // foreach
        // if () {

        // }
    }

    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        DB::beginTransaction();
        $validacion = null;
        try {
            $this->validar_encabezado($rows->first());
            foreach ($rows as $key => $row) {
                // quitar espacios a los campos que no los necesita
                // codigo_de_material
                // linea
                // nodo
                // nombre
                // fecha_de_adquisicion
                // tipo_de_material
                // categoria
                // presentacion
                // medida
                // cantidad
                // valor_de_compra
                // proveedor
                // marca
                $row['linea'] = ltrim(rtrim($row['linea']));
                $row['tipo_material'] = ltrim(rtrim($row['tipo_material']));
                $row['categoria_material'] = ltrim(rtrim($row['categoria_material']));
                $row['presentacion'] = ltrim(rtrim( $row['presentacion']));
                $row['medida'] = ltrim(rtrim( $row['medida']));
                $row['nombre'] = ltrim(rtrim($row['nombre']));
                $row['cantidad'] = ltrim(rtrim($row['cantidad']));
                $row['valor_compra'] = ltrim(rtrim(str_slug($row['valor_compra'], '_')));
                $row['proveedor'] = ltrim(rtrim($row['proveedor']));
                $row['marca'] = ltrim(rtrim($row['marca']));
                // Mayúsculas

                $row['nombre'] = strtoupper($row['nombre']);
                $row['cantidad'] = strtoupper($row['cantidad']);
                $row['valor_compra'] = strtoupper(str_slug($row['valor_compra'], '_'));
                $row['proveedor'] = strtoupper($row['proveedor']);
                $row['marca'] = strtoupper($row['marca']);


                // Validar linea
                $linea = \App\Models\LineaTecnologica::where('nombre', $row['linea'])->first();
                $validacion = $this->validaciones->validarQuery($linea, $row['linea'], $key, 'linea', $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }

                // Validar tipo_material
                $tipoMaterial = \App\Models\TipoMaterial::where('nombre', $row['tipo_material'])->first();
                if ($tipoMaterial == null) {
                    $tipoMaterial = \App\Models\TipoMaterial::create([
                        'nombre' => ltrim(rtrim($row['tipo_material']))
                    ]);
                }

                // Validar categoria_material
                $categoria = \App\Models\CategoriaMaterial::where('nombre', $row['categoria_material'])->first();
                if ($categoria == null) {
                    $categoria = \App\Models\CategoriaMaterial::create([
                        'nombre' => ltrim(rtrim($row['categoria_material']))
                    ]);
                }
                // Validar presentacion
                $presentacion = \App\Models\Presentacion::where('nombre', $row['presentacion'])->first();
                if ($presentacion == null) {
                    $presentacion = \App\Models\Presentacion::create([
                        'nombre' => ltrim(rtrim($row['presentacion']))
                    ]);
                }

                // Validar Medida
                $medida = \App\Models\Medida::where('nombre', $row['medida'])->first();
                if ($medida == null) {
                    $medida = \App\Models\Medida::create([
                        'nombre' => ltrim(rtrim($row['medida']))
                    ]);
                }
                $validacion = $this->validaciones->validarCelda($row['fecha'], $key, 'Fecha', $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }
                // Validar nombre
                $validacion = $this->validaciones->validarCelda($row['nombre'], $key, 'Nombre', $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }
                // Validar cantidad
                $validacion = $this->validaciones->validarCelda($row['cantidad'], $key, 'cantidad', $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }

                // Validar valor_compra
                $validacion = $this->validaciones->validarCelda(str_slug($row['valor_compra'], '_'), $key, 'valor compra', $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }

                $validacion = $this->validaciones->validarTamanhoCelda($row['nombre'], $key, 'nombre', 1000, $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }

                $validacion = $this->validaciones->validarTamanhoCelda($row['proveedor'], $key, 'proveedor', 100, $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }
                $validacion = $this->validaciones->validarTamanhoCelda($row['marca'], $key, 'marca', 45, $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }

                $material = Material::where('codigo_material', $row['codigo_material'])
                ->where('nodo_id', $this->nodo)
                ->first();
                if (!isset($material) && $material == null) {

                    $codeMaterial = $this->generateCodigoMaterial($linea->id);
                    $material = $this->registerMaterial(
                        $codeMaterial,
                        $params = [
                            'line' => $linea->id,
                            'tipomaterial' => $tipoMaterial->id,
                            'categoria' => $categoria->id,
                            'presentacion' => $presentacion->id,
                            'medida' => $medida->id,
                        ],
                        $row
                    );
                } else {
                    if ($this->nodo == $material->nodo_id) {
                        $this->updateMaterial(
                            $material,
                            $params = [
                                'line' => $linea->id,
                                'tipomaterial' => $tipoMaterial->id,
                                'categoria' => $categoria->id,
                                'presentacion' => $presentacion->id,
                                'medida' => $medida->id,
                            ],
                            $row
                        );
                    } else {
                        session()->put('errorMigracion', 'Error en la hoja de "'.$this->hoja.'": El código de proyecto '.$row['codigo_material'].' en el registro de la fila #' . ($key+2) . ' ya se encuentra registrado en un material del nodo '.$material->nodo->entidad->nombre.'
                        (Se recomienda cambiar el código de los proyecto, ya que la base de datos no permite códigos duplicados).');
                    }
                }
            }
            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
            return false;
        }
    }



    private function generateCodigoMaterial( $line)
    {

            $anho = Carbon::now()->isoFormat('YYYY');
            $tecnoparque = sprintf("%02d", $this->nodo);
            $material = Material::selectRaw('MAX(id+1) AS max')->get()->last();
            $material->max == null ? $material->max = 1 : $material->max = $material->max;
            $material->max = sprintf("%04d", $material->max);

            return 'MAT' . $anho . '-' . $tecnoparque .sprintf("%02d", $line)  . '-' . $material->max;
    }
    private function registerMaterial($code, $params = [], $row)
    {
        return Material::create([
            'nodo_id' => $this->nodo,
            'lineatecnologica_id'   => $params['line'],
            'tipomaterial_id'       => $params['tipomaterial'],
            'categoria_material_id' => $params['categoria'],
            'presentacion_id'       => $params['presentacion'],
            'medida_id'             => $params['medida'],
            'codigo_material'       => $code,
            'fecha'                 => Carbon::parse($row['fecha'])->format('Y-m-d'),
            'nombre'                => $row['nombre'],
            'cantidad'              => $row['cantidad'],
            'valor_compra'          => $row['valor_compra'],
            'proveedor'             => $row['proveedor'],
            'marca'                 => $row['marca'],
        ]);
    }

    private function updateMaterial($material,$params = [], $row)
    {
        return $material->update([
            'lineatecnologica_id'   => $params['line'],
            'tipomaterial_id'       => $params['tipomaterial'],
            'categoria_material_id' => $params['categoria'],
            'presentacion_id'       => $params['presentacion'],
            'medida_id'             => $params['medida'],
            'fecha'                 => Carbon::parse($row['fecha'])->format('Y-m-d'),
            'nombre'                => $row['nombre'],
            'cantidad'              => $row['cantidad'],
            'valor_compra'          => $row['valor_compra'],
            'proveedor'             => $row['proveedor'],
            'marca'                 => $row['marca'],
        ]);
    }
}
