<?php

namespace App\Imports;

use App\Models\Nodo;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('slug');

class CostoAdministrativoImport implements ToCollection, WithHeadingRow
{
    public $nodo;
    public $validaciones;
    public $hoja = 'Costos';

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
        $year = Carbon::now()->year;
        try {
            foreach ($rows as $key => $row) {
                $row['valor'] = ltrim(rtrim($row['valor']));

                // Validar valor
                $validacion = $this->validaciones->validarCelda($row['valor'], $key, 'valor', $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }

                $validacion = $this->validaciones->validarTamanhoCelda($row['valor'], $key, 'valor', 200, $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }

                // Validar nombre_costo
                $validacion = $this->validaciones->validarCelda($row['nombre_costo'], $key, 'nombre costo', $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }

                $validacion = $this->validaciones->validarTamanhoCelda($row['nombre_costo'], $key, 'nombre costo', 200, $this->hoja);
                if (!$validacion) {
                    return $validacion;
                }
                $costoAdministrativo = \App\Models\CostoAdministrativo::select('nodos.id as nodo_id', 'entidades.slug', 'entidades.nombre as entidad', 'entidades.email_entidad', 'nodo_costoadministrativo.valor', 'nodo_costoadministrativo.anho', 'nodo_costoadministrativo.id as nodo_costoadministrativo_id', 'costos_administrativos.nombre as costoadministrativo', 'costos_administrativos.id')
                ->join('nodo_costoadministrativo', 'nodo_costoadministrativo.costo_administrativo_id', '=', 'costos_administrativos.id')
                ->join('nodos', 'nodos.id', '=', 'nodo_costoadministrativo.nodo_id')
                ->join('entidades', 'entidades.id', '=', 'nodos.entidad_id')
        ->where('costos_administrativos.nombre', $row['nombre_costo'])
        ->where('nodos.id', $this->nodo)
        ->where('nodo_costoadministrativo.anho', $year)
        ->first();


                if (isset($costoAdministrativo) && $costoAdministrativo != null) {
                    if ($this->nodo == $costoAdministrativo->nodo_id) {
                        $this->updateCosto(
                            $costoAdministrativo,
                            $row
                        );
                    } else {
                        session()->put('errorMigracion', 'Error en la hoja de "'.$this->hoja.'": El equipo '.$row['nombre_equipo'].' en el registro de la fila #' . ($key+2) . ' ya se encuentra registrado en un equipo del nodo '.$costoAdministrativo->nodocostosadministrativos->nodo->entidad->nombre);
                    }
                } else {
                    session()->put('errorMigracion', 'Error en la hoja de "'.$this->hoja.'": El costo administrativo '.$row['nombre_costo'].' no es permitido. revisa la fila #' . ($key+2));
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


    private function updateCosto($costoAdministrativo, $row)
    {
        $costos               = Nodo::findOrFail($this->nodo)->costoadministrativonodo()->wherePivot('id', '=', $costoAdministrativo->nodo_costoadministrativo_id)->first();
        $costos->pivot->valor = $row["valor"];
        $costos->pivot->update();
        return $costos;
    }
}
