<?php

namespace App\Imports;

use App\Models\{Material, LineaTecnologica, TipoMaterial, CategoriaMaterial, Presentacion, Medida, Nodo};
use App\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\{DB};
use Maatwebsite\Excel\Concerns\ToCollection;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\{WithHeadingRow};
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use PhpOffice\PhpSpreadsheet\Shared\Date;

HeadingRowFormatter::default('slug');

class MaterialImport implements ToCollection, WithHeadingRow
{
    public $nodo;
    public $session;
    public $carbon;
    public $date;
    public $ideaRepository;
    public $validaciones;
    public $hoja = 'Materiales';

    public function __construct($nodo)
    {
        $this->session = session()->get('login_role');
        $this->nodo = $nodo;
        $this->carbon = new Carbon();
        $this->date = new Date();
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
            // 'tipo_de_material',
            'categoria',
            'presentacion',
            'medida',
            'cantidad',
            'valor_de_compra',
            'proveedor',
            'marca'
        ];
        foreach ($encabezado as $key => $columna) {
            if (!isset($row[$columna])) {
                session()->put('errorMigracion', 'No se encontró la columna ' . $columna . ', revisa el contenido del archivo.');
                return false;
            }
        }
        return true;
        
    }

    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        DB::beginTransaction();
        $validacion = null;
        // $carbon = new Carbon();
        try {
            if (!$this->validar_encabezado($rows->first())) {
                return false;
            } 
            foreach ($rows as $key => $row) {
                // $fecha = Carbon::instance(Date::excelToDateTimeObject($row['fecha_de_adquisicion']));
                if (is_numeric($row['fecha_de_adquisicion'])) {
                    $fecha = $this->carbon->instance($this->date->excelToDateTimeObject($row['fecha_de_adquisicion']))->toDateString();
                } else {
                    $fecha = $row['fecha_de_adquisicion'];
                }
                // dd( $fecha );
                // Quitar espacios a los campos que no los necesita
                $row['linea'] = ltrim(rtrim($row['linea']));
                // $row['tipo_de_material'] = ltrim(rtrim($row['tipo_de_material']));
                $row['categoria'] = ltrim(rtrim($row['categoria']));
                $row['presentacion'] = ltrim(rtrim( $row['presentacion']));
                $row['medida'] = ltrim(rtrim( $row['medida']));
                $row['nombre'] = ltrim(rtrim($row['nombre']));
                $row['cantidad'] = ltrim(rtrim($row['cantidad']));
                $row['valor_de_compra'] = ltrim(rtrim($row['valor_de_compra']));
                $row['proveedor'] = ltrim(rtrim($row['proveedor']));
                $row['marca'] = ltrim(rtrim($row['marca']));

                if ($this->session == User::IsAdministrador()) {
                    $nodo = Nodo::select('nodos.id')->join('entidades as e', 'e.id', '=', 'nodos.entidad_id')->where('nombre', $row['nodo'])->first();
                    $validacion = $this->validaciones->validarQuery($nodo, $row['nodo'], $key, 'nodo', $this->hoja);
                    if (!$validacion) {
                        return $validacion;
                    }
                    $this->nodo = $nodo->id;
                }

                // Validar linea
                $linea = LineaTecnologica::where('nombre', $row['linea'])->first();
                $validacion = $this->validaciones->validarQuery($linea, $row['linea'], $key, 'linea', $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }

                // Validar tipo_de_material
                $tipoMaterial = TipoMaterial::where('nombre', 'Material Directo')->first();

                // Validar categoria
                $categoria = CategoriaMaterial::where('nombre', $row['categoria'])->first();
                if ($categoria == null) {
                    $categoria = CategoriaMaterial::create([
                        'nombre' => ltrim(rtrim($row['categoria']))
                    ]);
                }

                // Validar presentacion
                $presentacion = Presentacion::where('nombre', $row['presentacion'])->first();
                if ($presentacion == null) {
                    $presentacion = Presentacion::create([
                        'nombre' => ltrim(rtrim($row['presentacion']))
                    ]);
                }

                // Validar Medida
                $medida = Medida::where('nombre', $row['medida'])->first();
                if ($medida == null) {
                    $medida = Medida::create([
                        'nombre' => ltrim(rtrim($row['medida']))
                    ]);
                }
                
                $validacion = $this->validaciones->validarCelda($row['presentacion'], $key, 'presentación', $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }
                
                $validacion = $this->validaciones->validarCelda($row['medida'], $key, 'Fecha', $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }
                
                $validacion = $this->validaciones->validarCelda($row['fecha_de_adquisicion'], $key, 'Fecha', $this->hoja);
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

                // Validar valor_de_compra
                $validacion = $this->validaciones->validarCelda($row['valor_de_compra'], $key, 'valor compra', $this->hoja);
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

                $material = Material::where('codigo_material', $row['codigo_de_material'])->first();
                $params = [
                    'line' => $linea->id,
                    'tipomaterial' => $tipoMaterial->id,
                    'categoria' => $categoria->id,
                    'presentacion' => $presentacion->id,
                    'medida' => $medida->id,
                    'fecha' => $fecha
                ];
                if ($material == null) {
                    $codeMaterial = $this->generateCodigoMaterial($linea->id);
                    $material = $this->registerMaterial($codeMaterial, $params, $row);
                } else {
                    // En caso de actualizar
                    if ($this->session == User::IsAdministrador()) {
                        $this->updateMaterial($material, $params, $row);
                    } else {
                        if ($this->nodo != $material->nodo_id) {
                            session()->put('errorMigracion', 'Error en la hoja de "'.$this->hoja.'": El código de material '.$row['codigo_de_material'].' en el registro de la fila #' . ($key+2) . ' no pertenece a tu nodo');
                            return false;
                        } else {
                            $this->updateMaterial($material, $params, $row);
                        }
                    }
                }
            }
            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollback();
            session()->put('errorMigracion', $th->getMessage());
            return false;
        }
    }



    private function generateCodigoMaterial($line)
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
            'nodo_id'               => $this->nodo,
            'lineatecnologica_id'   => $params['line'],
            'tipomaterial_id'       => $params['tipomaterial'],
            'categoria_material_id' => $params['categoria'],
            'presentacion_id'       => $params['presentacion'],
            'medida_id'             => $params['medida'],
            'codigo_material'       => $code,
            'fecha'                 => $params['fecha'],
            'nombre'                => $row['nombre'],
            'cantidad'              => $row['cantidad'],
            'valor_compra'          => $row['valor_de_compra'],
            'proveedor'             => $row['proveedor'],
            'marca'                 => $row['marca'],
        ]);
    }

    private function updateMaterial($material, $params = [], $row)
    {
        return $material->update([
            'lineatecnologica_id'   => $params['line'],
            'tipomaterial_id'       => $params['tipomaterial'],
            'categoria_material_id' => $params['categoria'],
            'presentacion_id'       => $params['presentacion'],
            'medida_id'             => $params['medida'],
            'fecha'                 => $params['fecha'],
            'nombre'                => $row['nombre'],
            'cantidad'              => $row['cantidad'],
            'valor_compra'          => $row['valor_de_compra'],
            'proveedor'             => $row['proveedor'],
            'marca'                 => $row['marca'],
        ]);
    }
}
