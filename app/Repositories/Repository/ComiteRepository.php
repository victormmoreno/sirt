<?php

namespace App\Repositories\Repository;

use App\Models\EstadoIdea;
// use App\Models\Idea;
use App\Models\Comite;
use App\Models\Idea;
use App\Models\ComiteIdea;
use Illuminate\Support\Facades\DB;

class ComiteRepository
{
  //-- Consulta los entrenamientos de un nodo
  public function consultarComitesPorNodo($id)
  {
    return Comite::select('codigo', 'fechacomite' , 'comites.observaciones', 'comites.id')
    ->join('comite_idea', 'comite_idea.comite_id', '=', 'comites.id')
    ->join('ideas', 'comite_idea.idea_id', '=', 'ideas.id')
    ->join('nodos', 'nodos.id', '=', 'ideas.nodo_id')
    ->where('nodos.id', $id)
    ->groupBy('comites.id')
    ->orderBy('comites.id', 'desc')
    ->get();
  }

  //-- Consulta las ideas que se presentaron a un csibt
  public function consultarIdeasDelComite($id)
  {
    return Comite::select('nombre_proyecto', 'fechacomite', 'comite_idea.observaciones', 'ideas.id', 'hora')
    ->selectRaw('IF(admitido = 0,"No", "Si") AS admitido')
    ->selectRaw('IF(asistencia = 0,"No", "Si") AS asistencia')
    ->join('comite_idea', 'comite_idea.comite_id', '=', 'comites.id')
    ->join('ideas', 'ideas.id', '=', 'comite_idea.idea_id')
    ->where('comites.id', $id)
    ->get();
  }


}
