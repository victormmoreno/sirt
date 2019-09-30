<?php

namespace App\Repositories\Repository;

use App\Models\CostoAdministrativo;
use App\Models\Nodo;
use Illuminate\Support\Facades\DB;

class CostoAdministrativoRepository
{

    /**
     * devolver informacion de costos administrativos por nodo.
     *
     * @return array
     * @author devjul
     */
    public function getInfoCostoAdministrativoNodo()
    {
        return Nodo::select('nodos.id as nodo_id', 'entidades.slug', 'entidades.nombre as entidad', 'entidades.email_entidad', 'nodo_costoadministrativo.valor', 'nodo_costoadministrativo.anho', 'costos_administrativos.nombre as costoadministrativo', 'costos_administrativos.id')
            ->join('nodo_costoadministrativo', 'nodo_costoadministrativo.nodo_id', '=', 'nodos.id')
            ->join('costos_administrativos', 'costos_administrativos.id', '=', 'nodo_costoadministrativo.costo_administrativo_id')
            ->join('entidades', 'entidades.id', '=', 'nodos.entidad_id');

    }

    /**
     * devolver informacion de costos administrativos .
     *
     * @return array
     * @author devjul
     */
    public function getInfoCostoAdministrativo()
    {
        return CostoAdministrativo::select('nodos.id as nodo_id', 'entidades.slug', 'entidades.nombre as entidad', 'entidades.email_entidad', 'nodo_costoadministrativo.valor', 'nodo_costoadministrativo.anho', 'nodo_costoadministrativo.id as nodo_costoadministrativo_id', 'costos_administrativos.nombre as costoadministrativo', 'costos_administrativos.id')
            ->join('nodo_costoadministrativo', 'nodo_costoadministrativo.costo_administrativo_id', '=', 'costos_administrativos.id')
            ->join('nodos', 'nodos.id', '=', 'nodo_costoadministrativo.nodo_id')
            ->join('entidades', 'entidades.id', '=', 'nodos.entidad_id');

    }

    /**
     * devolve actualizacion de costos administrativos .
     *
     * @return boolean
     * @author devjul
     */
    public function update($request, $costoAdministrativo)
    {
        DB::beginTransaction();

        try {

            $costos               = Nodo::findOrFail($costoAdministrativo->nodo_id)->costoadministrativonodo()->wherePivot('id', '=', $costoAdministrativo->nodo_costoadministrativo_id)->first();
            $costos->pivot->valor = $request->txtvalor;
            $costos->pivot->update();
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollback();
            return 'false';
        }
    }
}
