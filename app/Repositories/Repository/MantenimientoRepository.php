<?php

namespace App\Repositories\Repository;

use App\Models\EquipoMantenimiento;
use Illuminate\Support\Facades\DB;

class MantenimientoRepository
{

    /**
     * devolve registro de mantenimientos de equipos .
     * @return boolean
     * @author devjul
     * @param array $request
     */
    public function storeMantenimiento($request)
    {
        DB::beginTransaction();

        try {
            EquipoMantenimiento::create([
                'lineatecnologica_id'       => $request->input('txtlineatecnologica'),
                'equipo_id'                 => $request->input('txtequipo'),
                'ultimo_anio_mantenimiento' => $request->input('txtanio'),
                'vida_util_mantenimiento'   => $request->input('txtvidautil'),
                'horas_uso_anio'            => $request->get('txthorasuso'),
                'valor_mantenimiento'       => $request->input('txtvalor'),
            ]);
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollback();
            return false;
        }
    }

    /**
     * devolve consulta de los mantenimientos de los equipos .
     * @return boolean
     * @author devjul
     */
    public function findInfoMantenimiento()
    {
        return EquipoMantenimiento::with([
            'equipo',
            'equipo.lineatecnologica',
            'equipo.nodo',
            'equipo.nodo.entidad',
        ]);
    }

    /**
     * devolve actualizacion de mantenimientos de equipos .
     * @return boolean
     * @author devjul
     * @param array $request
     * @param array $mantenimiento
     */
    public function updateMantenimiento($request, $mantenimiento)
    {

        DB::beginTransaction();

        try {
            $mantenimiento->update([
                'lineatecnologica_id'       => $request->input('txtlineatecnologica'),
                'equipo_id'                 => $request->input('txtequipo'),
                'ultimo_anio_mantenimiento' => $request->input('txtanio'),
                'vida_util_mantenimiento'   => $request->input('txtvidautil'),
                'horas_uso_anio'            => $request->get('txthorasuso'),
                'valor_mantenimiento'       => $request->input('txtvalor'),
            ]);
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollback();
            return false;
        }
    }
}
