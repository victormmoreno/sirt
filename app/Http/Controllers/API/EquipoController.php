<?php

namespace App\Http\Controllers\API;

use App\Models\Equipo;
use Illuminate\Http\Request;

class EquipoController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     */
    public function __invoke(Request $request)
    {
        // if($request->expectsJson()){
            $equipos =  Equipo::query()
                ->join('nodos', 'nodos.id', 'equipos.nodo_id')
                ->join('entidades', 'entidades.id', 'nodos.entidad_id')
                ->join('lineastecnologicas', 'lineastecnologicas.id', 'equipos.lineatecnologica_id')
                ->select('equipos.nombre', 'entidades.nombre as nodo', 'lineastecnologicas.nombre as linea')
                ->where('destacado', 1)->get();
            return  $this->showAll($equipos);
        // }
        // return $this->errorResponse('No permitido', 403);

    }
}
