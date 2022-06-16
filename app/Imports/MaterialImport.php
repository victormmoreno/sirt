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
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        $validacion = null;
        try {
            foreach ($rows as $key => $row) {
                // quitar espacios a los campos que no los necesita
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
                $validacion = $this->validaciones->validarQuery($tipoMaterial, str_slug($row['tipo_material'], '_'), $key, 'tipo material', $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }

                // Validar categoria_material
                $categoria = \App\Models\CategoriaMaterial::where('nombre', $row['categoria_material'])->first();
                $validacion = $this->validaciones->validarQuery($categoria, $row['categoria_material'], $key, 'categoria material', $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }

                // Validar presentacion
                $presentacion = \App\Models\Presentacion::where('nombre', $row['presentacion'])->first();
                $validacion = $this->validaciones->validarQuery($presentacion, $row['presentacion'], $key, 'presentacion', $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }
                // Validar Medida
                $medida = \App\Models\Medida::where('nombre', $row['medida'])->first();
                $validacion = $this->validaciones->validarQuery($medida, $row['medida'], $key, 'medida', $this->hoja);
                if (!$validacion) {
                    return $validacion;
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

                $material = Material::where('codigo_material', str_slug($row['codigo_material'], '_'))->first();
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
