<?php

namespace App\Repositories\Repository;

use App\Models\EquipoMantenimiento;
use Illuminate\Support\Facades\DB;

class MantenimientoRepository
{

    /**
     * devolve registro de mantenimientos de equipos .
     * @return array
     * @author devjul
     * @param array $request
     */
    public function storeMantenimiento($request)
    {
        DB::beginTransaction();

        try {
            EquipoMantenimiento::create([
                'equipo_id'                 => $request->input('txtequipo'),
                'ultimo_anio_mantenimiento' => $request->input('txtanio'),
                'valor_mantenimiento'       => $request->input('txtvalor'),
            ]);
            DB::commit();
            return [
                'state' => true,
                'msj' => 'El mantenimiento se ha registrado',
                'title' => 'Registro exitoso'
            ];
        } catch (\Exception $e) {
            DB::rollback();
            return [
                'state' => false,
                'msj' => $e->getMessage(),
                'title' => 'Registro erróneo'
            ];
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
     * @return array
     * @author devjul
     * @param array $request
     * @param array $mantenimiento
     */
    public function updateMantenimiento($request, $mantenimiento)
    {
        DB::beginTransaction();
        try {
            $mantenimiento->update([
                'equipo_id'                 => $request->input('txtequipo'),
                'ultimo_anio_mantenimiento' => $request->input('txtanio'),
                'valor_mantenimiento'       => $request->input('txtvalor'),
            ]);
            DB::commit();
            return [
                'state' => true,
                'msj' => 'El mantenimiento se ha modificado',
                'title' => 'Modificación exitosa'
            ];
        } catch (\Exception $e) {
            DB::rollback();
            return [
                'state' => false,
                'msj' => $e->getPrevious()->getMessage(),
                'title' => 'Modificación errónea'
            ];
        }
    }
}
