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
                'lineatecnologica_id' => $request->input('txtlineatecnologica'),
                'equipo_id'           => $request->input('txtequipo'),
                'anio'                => $request->input('txtanio'),
                'valor'               => $request->input('txtvalor'),

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
        return EquipoMantenimiento::
            join('equipos', 'equipos.id', '=', 'equipo_mantenimiento.equipo_id')
            ->join('lineastecnologicas', 'lineastecnologicas.id', 'equipos.lineatecnologica_id')
            ->join('lineastecnologicas_nodos', 'lineastecnologicas_nodos.linea_tecnologica_id', '=', 'lineastecnologicas.id')
            ->join('nodos', 'nodos.id', '=', 'lineastecnologicas_nodos.nodo_id')
            ->join('entidades', 'entidades.id', '=', 'nodos.entidad_id')
            ->select('equipos.id as equipo_id', 'equipos.nombre as equipo_nombre', 'equipos.referencia', 'equipos.marca', 'equipos.costo_adquisicion', 'equipos.vida_util', 'equipos.anio_compra', 'equipo_mantenimiento.anio as anio_mantenimiento', 'equipo_mantenimiento.id','equipo_mantenimiento.created_at',  'equipo_mantenimiento.valor as valor_mantenimiento', 'lineastecnologicas.id as lineatecnologica_id', 'lineastecnologicas.nombre as lineatecnologica_nombre', 'lineastecnologicas.abreviatura as lineatecnologica_abreviatura', 'nodos.id as nodo_id', 'nodos.direccion as nodo_direccion', 'nodos.telefono as nodo_telefono', 'entidades.nombre as entidad_nombre', 'entidades.email_entidad');
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
                'lineatecnologica_id' => $request->input('txtlineatecnologica'),
                'equipo_id'           => $request->input('txtequipo'),
                'anio'                => $request->input('txtanio'),
                'valor'               => $request->input('txtvalor'),
            ]);
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollback();
            return false;
        }
    }
}
