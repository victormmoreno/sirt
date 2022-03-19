<?php

namespace App\Imports;

use App\Models\Equipo;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('slug');
class EquipoImport implements ToCollection, WithHeadingRow
{
    public $nodo;
    public $validaciones;
    public $hoja = 'Equipos';

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
                $row['linea'] = ltrim(rtrim($row['linea']));
                $row['referencia'] = ltrim(rtrim($row['referencia']));
                $row['nombre_equipo'] = ltrim(rtrim($row['nombre_equipo']));
                $row['marca'] = ltrim(rtrim( $row['marca']));
                $row['costo_adquisicion'] = ltrim(rtrim( $row['costo_adquisicion']));
                $row['vida_util'] = ltrim(rtrim($row['vida_util']));
                $row['anio_compra'] = ltrim(rtrim($row['anio_compra']));
                $row['promedio_horas_uso'] = ltrim(rtrim($row['promedio_horas_uso']));

                // Validar linea
                $linea = \App\Models\LineaTecnologica::where('nombre', $row['linea'])->first();
                $validacion = $this->validaciones->validarQuery($linea, $row['linea'], $key, 'linea', $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }

                // Validar referencia
                $validacion = $this->validaciones->validarCelda($row['referencia'], $key, 'referencia', $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }

                $validacion = $this->validaciones->validarTamanhoCelda($row['referencia'], $key, 'referencia', 200, $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }

                // Validar nombre
                $validacion = $this->validaciones->validarCelda($row['nombre_equipo'], $key, 'nombre equipo', $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }

                $validacion = $this->validaciones->validarTamanhoCelda($row['nombre_equipo'], $key, 'nombre equipo', 200, $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }
                // Validar marca
                $validacion = $this->validaciones->validarCelda($row['marca'], $key, 'marca', $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }

                $validacion = $this->validaciones->validarTamanhoCelda($row['marca'], $key, 'marca', 200, $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }

                // Validar costo_adquisicion
                $validacion = $this->validaciones->validarCelda($row['costo_adquisicion'], $key, 'costo adquisición', $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }

                $validacion = $this->validaciones->validarTamanhoCelda($row['costo_adquisicion'], $key, 'costo_adquisicion', 45, $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }

                // Validar vida_util
                $validacion = $this->validaciones->validarCelda($row['vida_util'], $key, 'vida util', $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }

                $validacion = $this->validaciones->validarTamanhoCelda($row['vida_util'], $key, 'vida_util', 11, $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }

                // Validar anio_compra
                $validacion = $this->validaciones->validarCelda($row['anio_compra'], $key, 'año compra', $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }

                // Validar promedio_horas_uso
                $validacion = $this->validaciones->validarCelda($row['promedio_horas_uso'], $key, 'promedio horas de uso', $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }

                $validacion = $this->validaciones->validarTamanhoCelda($row['promedio_horas_uso'], $key, 'promedio horas de uso', 11, $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }
                $equipo = Equipo::where('nombre', $row['nombre_equipo'])
                ->where('nodo_id', $this->nodo)
                                ->first();
                if (!isset($equipo) && $equipo == null) {
                    $equipo = $this->registerEquipo(
                        $params = [
                            'line' => $linea->id
                        ],
                        $row
                    );
                } else {
                    if ($this->nodo == $equipo->nodo_id) {
                        $this->updateEquipo(
                            $equipo,
                            $params = [
                                'line' => $linea->id
                            ],
                            $row
                        );
                    } else {
                        session()->put('errorMigracion', 'Error en la hoja de "'.$this->hoja.'": El equipo '.$row['nombre_equipo'].' en el registro de la fila #' . ($key+2) . ' ya se encuentra registrado en un equipo del nodo '.$equipo->nodo->entidad->nombre);
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

    private function registerEquipo($params = [], $row)
    {
        return Equipo::create([
            'nodo_id'               => $this->nodo,
            'lineatecnologica_id'   => $params['line'],
            'referencia'            => $row['referencia'],
            'nombre'                => $row['nombre_equipo'],
            'marca'                 => $row['marca'],
            'costo_adquisicion'     => $row['costo_adquisicion'],
            'vida_util'             => $row['vida_util'],
            'anio_compra'           => Carbon::parse($row['anio_compra'])->format('Y'),
            'horas_uso_anio'        => $row['promedio_horas_uso'],
        ]);
    }

    private function updateEquipo($equipo,$params = [], $row)
    {
        return $equipo->update([
            'nodo_id'               => $this->nodo,
            'lineatecnologica_id'   => $params['line'],
            'referencia'            => $row['referencia'],
            'nombre'                => $row['nombre_equipo'],
            'marca'                 => $row['marca'],
            'costo_adquisicion'     => $row['costo_adquisicion'],
            'vida_util'             => $row['vida_util'],
            'anio_compra'           => Carbon::parse($row['anio_compra'])->format('Y'),
            'horas_uso_anio'        => $row['promedio_horas_uso'],
        ]);
    }
}
