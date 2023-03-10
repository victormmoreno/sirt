<?php

namespace App\Imports;

use App\Models\{Equipo, LineaTecnologica, Nodo};
use App\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\{DB};
use Maatwebsite\Excel\Concerns\ToCollection;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\{WithHeadingRow};
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use PhpOffice\PhpSpreadsheet\Shared\Date;

HeadingRowFormatter::default('slug');

class EquipoImport implements ToCollection, WithHeadingRow
{
    public $nodo;
    public $session;
    public $carbon;
    public $date;
    public $validaciones;
    public $hoja = 'Equipos';
    public $encabezado = [
        'nodo',
        'linea_tecnologica',
        'codigo_del_equipo',
        'equipo',
        'referencia',
        'marca',
        'costo_adquisicion',
        'vida_util_anos',
        'promedio_horas_uso_al_ano',
        'ano_de_compra',
        'estado'
    ];

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
        foreach ($this->encabezado as $key => $columna) {
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
        try {
            if (!$this->validar_encabezado($rows->first())) {
                return false;
            } 
            foreach ($rows as $key => $row) {
                // Quitar espacios a los campos que no los necesita
                $row['nodo'] = ltrim(rtrim($row['nodo']));
                $row['linea_tecnologica'] = ltrim(rtrim($row['linea_tecnologica']));
                $row['codigo_del_equipo'] = ltrim(rtrim( $row['codigo_del_equipo']));
                $row['equipo'] = ltrim(rtrim( $row['equipo']));
                $row['referencia'] = ltrim(rtrim($row['referencia']));
                $row['marca'] = ltrim(rtrim($row['marca']));
                $row['costo_adquisicion'] = ltrim(rtrim($row['costo_adquisicion']));
                $row['vida_util_anos'] = ltrim(rtrim($row['vida_util_anos']));
                $row['promedio_horas_uso_al_ano'] = ltrim(rtrim($row['promedio_horas_uso_al_ano']));
                $row['ano_de_compra'] = ltrim(rtrim($row['ano_de_compra']));
                $row['estado'] = ltrim(rtrim($row['estado']));

                if ($this->session == User::IsAdministrador()) {
                    $nodo = Nodo::select('nodos.id')->join('entidades as e', 'e.id', '=', 'nodos.entidad_id')->where('nombre', $row['nodo'])->first();
                    $validacion = $this->validaciones->validarQuery($nodo, $row['nodo'], $key, 'nodo', $this->hoja);
                    if (!$validacion) {
                        return $validacion;
                    }
                    $this->nodo = $nodo->id;
                }

                // Validar linea
                $linea = LineaTecnologica::where('nombre', $row['linea_tecnologica'])->first();
                $validacion = $this->validaciones->validarQuery($linea, $row['linea_tecnologica'], $key, 'linea', $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }
                
                $validacion = $this->validaciones->validarCelda($row['equipo'], $key, 'nombre de equipo', $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }

                $validacion = $this->validaciones->validarTamanhoCelda($row['equipo'], $key, 'nombre de equipo', 200, $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }

                $validacion = $this->validaciones->validarCelda($row['costo_adquisicion'], $key, 'costo de aquisición', $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }

                $validacion = $this->validaciones->validarTamanhoCelda($row['costo_adquisicion'], $key, 'costo de aquisición', 45, $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }

                $validacion = $this->validaciones->validarNumero($row['costo_adquisicion'], $key, 'costo de aquisición', $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }

                $validacion = $this->validaciones->validarCelda($row['ano_de_compra'], $key, 'año de compra', $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }

                $validacion = $this->validaciones->validarTamanhoCelda($row['ano_de_compra'], $key, 'año de compra', 4, $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }

                $validacion = $this->validaciones->validarNumero($row['ano_de_compra'], $key, 'año de compra', $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }

                $validacion = $this->validaciones->validarCelda($row['promedio_horas_uso_al_ano'], $key, 'promedio de horas de uso al año', $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }

                $validacion = $this->validaciones->validarTamanhoCelda($row['promedio_horas_uso_al_ano'], $key, 'promedio de horas de uso al año', 4, $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }
                
                $validacion = $this->validaciones->validarCelda($row['vida_util_anos'], $key, 'vida útil', $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }

                $validacion = $this->validaciones->validarTamanhoCelda($row['vida_util_anos'], $key, 'vida útil', 4, $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }

                $validacion = $this->validaciones->validarNumero($row['vida_util_anos'], $key, 'vida útil', $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }

                $validacion = $this->validaciones->validarDosOpciones($row['estado'], $key, 'estado', $this->hoja, 'Habilitado', 'Inhabilitado');
                if (!$validacion) {
                    return $validacion;
                }

                $equipo = Equipo::where('codigo', $row['codigo_del_equipo'])->first();
                if ($equipo == null) {
                    $codigo = $this->generarCodigo($row, $linea->id);
                    $equipo = $this->registrarEquipo($codigo, $row, $linea->id);
                } else {
                    if ($row['estado'] == 'Inhabilitado') {
                        $equipo->delete();
                    }
                    // En caso de actualizar
                    if ($this->session == User::IsAdministrador()) {
                        $this->updateEquipo($equipo, $row, $linea->id);
                    } else {
                        if ($this->nodo != $equipo->nodo_id) {
                            session()->put('errorMigracion', 'Error en la hoja de "'.$this->hoja.'": El código de equipo '.$row['codigo'].' en el registro de la fila #' . ($key+2) . ' no pertenece a tu nodo');
                            return false;
                        } else {
                            $this->updateEquipo($equipo, $row, $linea->id);
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


    /**
     * Genera el código para el equipo existente
     *
     * @return string
     * @author dum
     **/
    private function generarCodigo($row, $linea)
    {
        $codigo = null;
        $prefix = 'EQ';
        $anho = $row['ano_de_compra'];
        $nodo = sprintf("%02d", $this->nodo);
        $linea = sprintf("%02d", $linea);
        $id = sprintf("%06d", Equipo::selectRaw('MAX(id+1) AS max')->get()->last()->max);
        $codigo = $prefix . $anho . '-' . $nodo . $linea . '-' . $id; 
        return $codigo;
    }

    private function registrarEquipo($code, $row, $linea)
    {
        return Equipo::create([
            'nodo_id' => $this->nodo,
            'lineatecnologica_id' => $linea,
            'codigo' => $code,
            'referencia' => $row['referencia'],
            'nombre' => $row['equipo'],
            'marca' => $row['marca'],
            'costo_adquisicion' => $row['costo_adquisicion'],
            'vida_util' => $row['vida_util_anos'],
            'anio_compra' => $row['ano_de_compra'],
            'horas_uso_anio' => $row['promedio_horas_uso_al_ano']
        ]);
    }

    private function updateEquipo($equipo, $row, $linea)
    {
        return $equipo->update([
            'lineatecnologica_id' => $linea,
            'referencia' => $row['referencia'],
            'nombre' => $row['equipo'],
            'marca' => $row['marca'],
            'costo_adquisicion' => $row['costo_adquisicion'],
            'vida_util' => $row['vida_util_anos'],
            'anio_compra' => $row['ano_de_compra'],
            'horas_uso_anio' => $row['promedio_horas_uso_al_ano']
        ]);
    }
}
