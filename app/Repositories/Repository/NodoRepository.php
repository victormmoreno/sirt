<?php

namespace App\Repositories\Repository;

use App\Models\Nodo;
use App\Models\Departamento;
use Illuminate\Support\Facades\DB;

class NodoRepository
{
    public function getAlltNodo()
    {
        return Nodo::select('nodos.id',DB::raw("CONCAT('Tecnoparque Nodo ',nodos.nombre) as nodos"),"nodos.direccion",DB::raw("CONCAT(centros.codigo_centro,' -  ',entidades.nombre) as centro"),DB::raw("CONCAT(ciudades.nombre,' (',departamentos.nombre,') ') as ubicacion"))
        			->join('centros', 'centros.id', '=', 'nodos.centro_id')
        			->join('ciudades', 'ciudades.id', '=', 'centros.ciudad_id')
        			->join('departamentos', 'departamentos.id', '=', 'ciudades.departamento_id')
        			->join('entidades', 'entidades.id', '=', 'centros.entidad_id')
        			->get();
    }

    public function getAllDepartamentos()
    {
    	return Departamento::allDepartamentos()->pluck('id','nombre');
    }

    public function findByid($id)
    {
        return Nodo::findOrFail($id);
    }
}
