<?php

namespace App\Repositories\Repository;

use App\Models\{Entrenamiento, EntrenamientoIdea, Nodo, EstadoIdea};
use Illuminate\Support\Facades\DB;

class EntrenamientoRepository
{

  /**
  * undocumented function summary
  * @param int id Id del entrenamiento por el cual se consultaran sus archivos
  * @return return Collection
  */
  public function consultarArchivosDeUnEntrenamiento($id)
  {
    return Entrenamiento::select('ruta', 'entrenamiento_id', 'archivosentrenamiento.id')
    ->join('archivosentrenamiento', 'archivosentrenamiento.entrenamiento_id', '=', 'entrenamientos.id')
    ->where('entrenamientos.id', $id)
    ->get();
  }

  // Consulta todos los entrenamientos por nodo
  public function consultarEntrenamientosPorNodo($id)
  {
    return Entrenamiento::select('fecha_sesion1', 'fecha_sesion2' , 'entrenamientos.id', 'entrenamientos.codigo_entrenamiento')
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
    return Entrenamiento::select('fecha_sesion1', 'fecha_sesion2' , 'entrenamientos.id', 'entrenamientos.codigo_entrenamiento')
    ->selectRaw('IF(correos = 0, "No", "Si") AS correos')
    ->selectRaw('IF(fotos = 0, "No", "Si") AS fotos')
    ->selectRaw('IF(listado_asistencia = 0, "No", "Si") AS listado_asistencia')
    ->where('id', $id)
    ->get()
    ->last();
  }

  public function consultarIdeasDelEntrenamiento($id)
  {
    return Entrenamiento::select('nombre_proyecto', 'fecha_sesion1', 'fecha_sesion2', 'ideas.id', 'ideas.codigo_idea')
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

  /**
   * genera un código de entrenamiento
   * @return return string
   */
  public function generarCodigoEntrenamiento()
  {
    $anho = Carbon::now()->isoFormat('YYYY');
    $tecnoparque = sprintf("%02d", auth()->user()->infocenter->nodo_id);
    $id = Entrenamiento::selectRaw('MAX(id+1) AS max')->get()->last();
    $id->max == null ? $id->max = 1 : $id->max = $id->max;
    $id->max = sprintf("%04d", $id->max);
    $infocenter = sprintf("%03d", auth()->user()->infocenter->id);
    $codigo_entrenamiento = 'E' . $anho . '-' . $tecnoparque . $infocenter . '-' . $id->max;
    return $codigo_entrenamiento;
  }

  // Hace el registro del entrenamiento
  public function store($request)
  {
    $codigo_entrenamiento = $this->generarCodigoEntrenamiento();
    return Entrenamiento::create([
      "fecha_sesion1" => $request->input('txtfecha_sesion1'),
      "fecha_sesion2" => $request->input('txtfecha_sesion2'),
      "codigo_entrenamiento" => $codigo_entrenamiento,
      ]);
    }

    // Hace el registro en la tabla entrenamiento_idea
    // Se hace la validacion con operadores ternarios para evitar que el campo quede null
    public function storeEntrenamientoIdea($value, $idEntrenamiento)
    {
      return EntrenamientoIdea::create([
        "entrenamiento_id" => $idEntrenamiento,
        "idea_id" => $value['id'],
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
      return Entrenamiento::select('entrenamientos.id', 'fecha_sesion1', 'fecha_sesion2', 'codigo_entrenamiento')
      ->join('entrenamiento_idea', 'entrenamiento_idea.entrenamiento_id', '=', 'entrenamientos.id')
      ->join('ideas', 'ideas.id', '=', 'entrenamiento_idea.idea_id')
      ->join('nodos', 'nodos.id', '=', 'ideas.nodo_id')
      ->where('nodos.id', $nodo_id)
      ->where('fecha_sesion1', $fecha_sesion1)
      ->where('fecha_sesion2', $fecha_sesion2)
      ->get();
    }

  }
