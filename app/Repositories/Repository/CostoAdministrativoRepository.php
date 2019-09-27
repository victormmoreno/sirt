<?php

namespace App\Repositories\Repository;

use App\Models\Nodo;
use Carbon\Carbon;

class CostoAdministrativoRepository
{

	/**
     * devolver informacion de costos administrativos.
     *
     * @return array
     * @author devjul
     */
    public function getInfoCostoAdministrativo()
    {
        return Nodo::select('nodos.id', 'entidades.slug', 'entidades.nombre as entidad', 'entidades.email_entidad', 'nodo_costoadministrativo.valor', 'nodo_costoadministrativo.anho', 'costos_administrativos.nombre as costoadministrativo')
            ->join('nodo_costoadministrativo', 'nodo_costoadministrativo.nodo_id', '=', 'nodos.id')
            ->join('costos_administrativos', 'costos_administrativos.id', '=', 'nodo_costoadministrativo.costo_administrativo_id')
            ->join('entidades', 'entidades.id', '=', 'nodos.entidad_id');
            
            
    }
}
