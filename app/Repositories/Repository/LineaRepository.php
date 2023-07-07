<?php

namespace App\Repositories\Repository;

use App\Models\LineaTecnologica;
use App\Models\Nodo;

class LineaRepository
{

    public function getAllLineaNodo($nodo)
    {
        return Nodo::allLineasPorNodo($nodo);
    }


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
        return LineaTecnologica::with(['nodos', 'nodos.entidad', 'nodos.entidad.centro', 'nodos.entidad.ciudad', 'nodos.entidad.ciudad.departamento', 'sublineas'])->select('id', 'abreviatura', 'nombre', 'created_at')->findOrFailLinea($linea);
    }

    /**
     * retorna consulta de lineas con relaciones
     *
     * @author julian londoño
     * @param array $relations
     */

    public function lineasWithRelations($relations)
    {
        return LineaTecnologica::with($relations);
    }

    /**
     * metodo para guardar una nueva linea
     * @param $request
     * @author julian londoño
     */
    public function store($request)
    {
        return LineaTecnologica::create([
            "abreviatura" => $request->input('txtabreviatura'),
            "nombre"      => $request->input('txtnombre'),
            "slug"        => str_slug($request->input('txtnombre'), '-'),
        ]);
    }

    /**
     * metodo para actualizar una nueva linea
     * @param $lineatecnologica
     * @param $request
     * @author julian londoño
     */
    public function update($lineatecnologica, $request)
    {
        $lineatecnologica->update([
            "abreviatura" => $request->input('txtabreviatura'),
            "nombre"      => $request->input('txtnombre'),
            "slug"        => str_slug($request->input('txtnombre'), '-'),
        ]);

        return $lineatecnologica;
    }
}
