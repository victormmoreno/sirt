<?php

namespace App\Repositories\Repository;

use App\Models\EstadoIdea;
// use App\Models\Idea;
use App\Models\Entrenamiento;
use App\Models\EntrenamientoIdea;
use App\Models\Nodo;
use Illuminate\Support\Facades\DB;

class EntrenamientoRepository
{
  // Consulta todos los entrenamientos por nodo
  public function consultarEntrenamientosPorNodo($id)
  {
    return Entrenamiento::select('fecha_sesion1', 'fecha_sesion2' , 'entrenamientos.id')
    ->selectRaw('IF(correos = 0, "No", "Si") AS correos')
    ->selectRaw('IF(fotos = 0, "No", "Si") AS fotos')
    ->selectRaw('IF(listado_asistencia = 0, "No", "Si") AS listado_asistencia')
    ->join('entrenamiento_idea', 'entrenamientos.id', '=', 'entrenamiento_idea.entrenamiento_id')
    ->join('ideas', 'ideas.id', '=', 'entrenamiento_idea.idea_id')
    ->where('ideas.nodo_id', $id)
    ->groupBy('entrenamientos.id')
    ->get();
  }
  // Consulta el entrenamiento por id
  public function consultarEntrenamientoPorId($id)
  {
    return Entrenamiento::select('fecha_sesion1', 'fecha_sesion2' , 'entrenamientos.id')
    ->selectRaw('IF(correos = 0, "No", "Si") AS correos')
    ->selectRaw('IF(fotos = 0, "No", "Si") AS fotos')
    ->selectRaw('IF(listado_asistencia = 0, "No", "Si") AS listado_asistencia')
    ->where('id', $id)
    ->get()
    ->last();
  }

  public function consultarIdeasDelEntrenamiento($id)
  {
    return Entrenamiento::select('nombre_proyecto', 'fecha_sesion1', 'fecha_sesion2', 'ideas.id')
    ->selectRaw('IF(confirmacion = 0,"No", "Si") AS confirmacion')
    ->selectRaw('IF(convocado_csibt = 0,"No", "Si") AS convocado')
    ->selectRaw('IF(canvas = 0,"No", "Si") AS canvas')
    ->selectRaw('IF(asistencia1 = 0,"No", "Si") AS asistencia1')
    ->selectRaw('IF(asistencia2 = 0,"No", "Si") AS asistencia2')
    ->join('entrenamiento_idea', 'entrenamiento_idea.entrenamiento_id', '=', 'entrenamientos.id')
    ->join('ideas', 'ideas.id', '=', 'entrenamiento_idea.idea_id')
    ->where('entrenamientos.id', $id)
    ->get();
  }

  // public function getSelectNodo()
  // {
  //     return Nodo::SelectNodo()->get();
  // }

  // Hace el registro del entrenamiento
  public function store($request)
  {
    return Entrenamiento::create([
      "fecha_sesion1"            => $request->input('txtfecha_sesion1'),
      "fecha_sesion2"   => $request->input('txtfecha_sesion2'),
      "correos" => $request->txtcorreos,
      "fotos" => $request->txtfotos,
      "listado_asistencia" => $request->txtlistado_asistencia,
      ]);
    }

    // Hace el registro en la tabla entrenamiento_idea
    // Se hace la validacion con operadores ternarios para evitar que el campo quede null
    public function storeEntrenamientoIdea($value, $idEntrenamiento)
    {
      return EntrenamientoIdea::create([
        "entrenamiento_id"   => $idEntrenamiento,
        "idea_id"            => $value['id'],
        "confirmacion" => isset($value['Confirm']) ? 1 : 0,
        "canvas" => isset($value['Canvas']) ? 1 : 0,
        "asistencia1" => isset($value['AssistF']) ? 1 : 0,
        "asistencia2" => isset($value['AssistS']) ? 1 : 0,
        "convocado_csibt" => isset($value['Convocado']) ? 1 : 0,
      ]);
    }

    // Consulta los entrenamientos que se hicieron en la fecha de la primera y segunda sesion
    public function consultarEntrenamientoPorFechas($nodo_id, $fecha_sesion1, $fecha_sesion2)
    {
      return Entrenamiento::select('entrenamientos.id', 'fecha_sesion1', 'fecha_sesion2')
      ->join('entrenamiento_idea', 'entrenamiento_idea.entrenamiento_id', '=', 'entrenamientos.id')
      ->join('ideas', 'ideas.id', '=', 'entrenamiento_idea.idea_id')
      ->join('nodos', 'nodos.id', '=', 'ideas.nodo_id')
      ->where('nodos.id', $nodo_id)
      ->where('fecha_sesion1', $fecha_sesion1)
      ->where('fecha_sesion2', $fecha_sesion2)
      ->get();
    }

    //
    // public function StoreIdeaEmpGI($request)
    // {
    //
    //     // dd($request->all());
    //     $idea = Idea::create([
    //       "nodo_id"            => auth()->user()->infocenter->nodo_id,
    //       "nombres_contacto"   => $request->input('txtnidcod'),
    //       "apellidos_contacto" => $request->input('txtnombreempgi'),
    //       "nombre_proyecto"    => $request->input('txtnombre_proyecto'),
    //       "tipo_idea"    => $request->txttipo_idea[1],
    //       "estadoidea_id" => 1,
    //     ]);
    //
    //     return $idea;
    // }

    // public function Update($request, $idea)
    // {
    //
    //     $idea->nodo_id            = $request->input('txtnodo_id');
    //     $idea->nombres_contacto   = $request->input('txtnombres_contacto');
    //     $idea->apellidos_contacto = $request->input('txtapellidos_contacto');
    //     $idea->correo_contacto    = $request->input('txtcorreo_contacto');
    //     $idea->telefono_contacto  = $request->input('txttelefono_contacto');
    //     $idea->nombre_proyecto    = $request->input('txtnombre_proyecto');
    //     $idea->descripcion        = $request->input('txtdescripcion');
    //     $idea->objetivo           = $request->input('txtobjetivo');
    //     $idea->alcance            = $request->input('txtalcance');
    //
    //     $idea = $idea->update();
    //     return $idea;
    // }
    //
    // public function findByid($id)
    // {
    //
    //     return Idea::findOrFail($id);
    //
    // }

  }
