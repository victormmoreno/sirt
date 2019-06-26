<?php

namespace Repositories\Repository;

use App\Models\Centro;
use App\Models\LineaTecnologica;
use App\Models\Nodo;
use App\Models\Regional;
use Illuminate\Support\Facades\DB;

class NodoRepository
{
    public function getAlltNodo()
    {
        return Nodo::select('nodos.id', DB::raw("CONCAT('Tecnoparque Nodo ',nodos.nombre) as nodos"), "nodos.direccion", DB::raw("CONCAT(centros.codigo_centro,' -  ',entidades.nombre) as centro"), DB::raw("CONCAT(ciudades.nombre,' (',departamentos.nombre,') ') as ubicacion"))
            ->join('centros', 'centros.id', '=', 'nodos.centro_id')
            ->join('entidades', 'entidades.id', '=', 'centros.entidad_id')
            ->join('ciudades', 'ciudades.id', '=', 'entidades.ciudad_id')
            ->join('departamentos', 'departamentos.id', '=', 'ciudades.departamento_id')
            ->get();
    }

    public function findByid($id)
    {
        return Nodo::findOrFail($id);
    }

    /*=================================================================================
    =            metodo para consultar todos los centros de formacion SENA            =
    =================================================================================*/

    public function getAllCentros()
    {
        return Centro::allCentros()->pluck('nombre','id');
    }

    /*=====  End of metodo para consultar todos los centros de formacion SENA  ======*/

    /*================================================================
    =            metaodo para consultar todas las lineas             =
    ================================================================*/
    
    public function getAllLineas()
    {
        return LineaTecnologica::AllLineas()->pluck('nombre','id');
    }
    
    /*=====  End of metaodo para consultar todas las lineas   ======*/

    /*===========================================================================
    =            metodo para consultar todos las regionales del pais            =
    ===========================================================================*/
    
    public function getAllRegionales()
    {
        return Regional::allRegionales()->pluck('nombre','id');
    }
    
    
    /*=====  End of metodo para consultar todos las regionales del pais  ======*/
    
    

}
