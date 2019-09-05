<?php

namespace App\Repositories\Repository;

use App\Models\LineaTecnologica;
use App\Models\Nodo;

class LineaRepository
{
	 /*=================================================================
    =            metodo para consultar las lineas por nodo            =
    =================================================================*/
    
    public function getAllLineaNodo($nodo)
    {
        return Nodo::allLineasPorNodo($nodo);
    }
    
    
    /*=====  End of metodo para consultar las lineas por nodo  ======*/


    /**
     * metodo para consular el id y nombre de las linas
     *
     * @param  int $nodo
     * @author julian londoño
     * @return collection
     */
    public function findLineasByIdNameForNodo($nodo)
    {
        return Nodo::getLineasForNodoIdsNames($nodo);
    }

    /**
     * metodo para consular el id y nombre de las linas
     *
     * @author julian londoño
     * @return collection
     */
    public function findLineaForShow($linea)
    {
        return LineaTecnologica::with(['nodos','nodos.entidad','nodos.entidad.centro','nodos.entidad.ciudad','nodos.entidad.ciudad.departamento','sublineas'])->select('id', 'abreviatura', 'nombre', 'descripcion', 'created_at')->findOrFailLinea($linea);
        // return LineaTecnologica::findLinea($linea);
    }



   
    
}