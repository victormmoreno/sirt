<?php

namespace App\Repositories\Repository;

use App\Models\{Comite, Idea, EstadoIdea, ComiteIdea};
use Illuminate\Support\Facades\DB;

class ComiteRepository
{

  /**
  * Consulta los archivos de un comité
  * @param int $id Id del comité
  * @return Collection
  * @author Victor Manuel Moreno Vega
  */
  public function consultarRutasArchivosDeUnComite($id)
  {
    return Comite::find($id)->rutamodel;
  }

  // Consulta un comité por su id
  public function consultarComitePorId($id)
  {
    return Comite::select('codigo', 'fechacomite', 'id', 'correos', 'listado_asistencia', 'otros')
    ->where('comites.id', $id)
    ->get();
  }

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

  //-- Consulta un comité en una fecha
  public function consultarComitePorNodoYFecha($id, $fecha)
  {
    return Comite::select('comites.id', 'fechacomite', 'codigo')
    ->join('comite_idea', 'comite_idea.comite_id', '=', 'comites.id')
    ->join('ideas', 'ideas.id', '=', 'comite_idea.idea_id')
    ->join('nodos', 'nodos.id', '=', 'ideas.nodo_id')
    ->where('fechacomite', $fecha)
    ->where('nodos.id', $id)
    ->get();
  }

  // Hace el registro de un comité
  public function store($request, $codigo)
  {
    return Comite::create([
      'codigo' => $codigo,
      'fechacomite' => $request->input('txtfechacomite_create'),
      'observaciones' => $request->input('txtobservacionescomite'),
    ]);
  }

  // Hace el registro en la tabla Comite_Idea
  public function storeComiteIdea($value, $idComite)
  {
    return ComiteIdea::create([
      "idea_id"            => $value['id'],
      "comite_id"   => $idComite,
      "hora" => $value['Hora'],
      "admitido" => $value['Admitido'],
      "asistencia" => $value['Asistencia'],
      "observaciones" => $value['Observaciones'],
    ]);
  }

  // Hace el registro en la tabla Comite_Idea
  public function updateEvidenciasComite($request, $idComite)
  {
    return Comite::where('id', $idComite)
    ->update([
      "correos"            => $request['ev_correos'],
      "listado_asistencia"   => $request['ev_listado'],
      "otros" => $request['ev_otros'],
    ]);
  }

}
