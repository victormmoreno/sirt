<?php

namespace App\Repositories\Repository;

use App\Models\{Comite, Idea, EstadoIdea, EstadoComite};
use Illuminate\Support\Facades\DB;
use App\Events\Comite\AgendamientoWasRegistered;
use Carbon\Carbon;

class ComiteRepository
{

  private $ideaRepository;

  public function __construct(IdeaRepository $ideaRepository)
  {
    $this->setIdeaRepository($ideaRepository);
  }

  /**
  * Asgina un valor a $ideaRepository
  * @param object $ideaRepository
  * @return void
  * @author dum
  */
  private function setIdeaRepository($ideaRepository)
  {
    $this->ideaRepository = $ideaRepository;
  }

  /**
  * Retorna el valor de $ideaRepository
  * @return object
  * @author dum
  */
  private function getIdeaRepository()
  {
    return $this->ideaRepository;
  }

  /**
   * Envía el correo con los datos del agendamiento
   * @param int $id Id del comité
   * @return boolean
   * @author dum
   */
  public function notificar_agendamiento(int $id)
  {
    
    $comite = Comite::findOrFail($id);
    foreach ($comite->ideas as $key => $value) {
      // echo $value->pivot->direccion.'<br>';
      event(new AgendamientoWasRegistered($value, $comite));
    }
    // exit();
    DB::beginTransaction();
    try {
      DB::commit();
      return true;
    } catch (\Throwable $th) {
      DB::rollBack();
      return false;
    }
  }

  /**
   * Cambiar el estado a las ideas de proyectos de un comite
   *
   * @param Request $request
   * @return void
   * @author dum
   */
  private function cambiarEstadoDeLasIdeas($request)
  {
    foreach($request->get('id_ideas') as $id => $value){
      if ($request->get('admitido_ideas')[$id] == 'No') {
        $this->getIdeaRepository()->updateEstadoIdea($value, 'No Admitido');
      } else {
        $this->getIdeaRepository()->updateEstadoIdea($value, 'Admitido');
      }
    }
  }

  /**
   * Retorna el array con los ideas de un comite
   *
   * @param Request $request
   * @return array
   */
   private function arrayIdeasDeComite($request)
   {
     $syncData = array();
     foreach($request->get('id_ideas') as $id => $value){
       $admitido = 0;
       $asistencia = 0;

       if ($request->get('admitido_ideas')[$id] == 'Si') {
         $admitido = 1;
       }
       if ($request->get('asistencias_ideas')[$id] == 'Si') {
         $asistencia = 1;
       }
       $syncData[$id] = array('idea_id' => $value,
       'hora' => $request->get('horas_ideas')[$id],
       'admitido' => $admitido,
       'asistencia' => $asistencia,
       'observaciones' => $request->get('observaciones_ideas')[$id]);
     }

     return $syncData;
   }

  /**
   * Modifica los datos de un agendamiento
   *
   * @param Request $request
   * @param int $id Id del comité que se modifica
   * @return boolean
   * @author dum
   */
  public function updateAgendamiento($request, $id)
  {
    DB::beginTransaction();
    try {
      $comite = Comite::find($id);
      $comite->update([
        'fechacomite' => request()->txtfechacomite_create
      ]);
      $comite->ideas()->update(['estadoidea_id' => EstadoIdea::where('nombre', 'Convocado')->first()->id]);
      $syncIdeas = $this->arraySyncIdeasAgendamiento($request);
      $comite->ideas()->sync($syncIdeas, true);
      $comite->ideas()->update(['estadoidea_id' => EstadoIdea::where('nombre', 'Agendamiento')->first()->id]);
      DB::commit();
      return true;
    } catch (\Exception $e) {
      DB::rollback();
      return false;
    }

  }

  /**
   * Método que modifica los datos del comité cuando ya se calificó
   * 
   * @param $request Request
   * @param int $id Id del comité
   * @return boolean
   * @author dum
   */
  public function updateRealizado($request, $id)
  {
    
    DB::beginTransaction();
    try {
      $comite = Comite::findOrFail($id);
      $comite->update([
        'observaciones' => $request->get('txtobservacionescomite'),
        'estado_comite_id' => EstadoComite::where('nombre', 'Realizado')->first()->id
      ]);
        
      $this->reiniciarCamposPivot($comite, $request);
      // Cambia los valores del campo asistencia a las ideas que asistieron.
      $this->updateCamposPivotBoolean($comite, $request, 'txtasistido', 'asistencia');
      // Cambia los valores del campo admitido a las ideas que fueron admitido en comité.
      $this->updateCamposPivotBoolean($comite, $request, 'txtadmitidos', 'admitido');
      // Cambiar los valores del campo observaciones a todas las ideas del comité.
      $this->updateObservacionesIdea($comite, $request);

      DB::commit();
      return true;
    } catch (\Throwable $th) {
      DB::rollBack();
      return false;
    }
  }
  
  /**
   * Cambia el valor de los campos de la tabla pivot comite_idea
   * @param $comite Comité
   * @param $request
   * @param $value Campo del formulario
   * @param $field Campo de la base de datos que se va a cambiar
   * @return void
   * @author dum
   */
  private function updateCamposPivotBoolean($comite, $request, $value, $field)
  {
    if ($request->get($value) != null) {
      $comite->ideas()->updateExistingPivot($request->get($value), [$field => 1]);
    }
  }

  /**
   * Reinicia los valores de los campos de la tabla comite_idea
   * @param $comite Comite
   * @param $request Request
   * @return void
   * @author dum
   */
  private function reiniciarCamposPivot($comite, $request)
  {
    $comite->ideas()->updateExistingPivot($request->get('ideas'), ['admitido' => 0, 'asistencia' => 0, 'observaciones' => null]);
  }

  /**
   * Cambia los valores del campo observaciones a las ideas de proyecto
   * @param $comite Comité
   * @param $request Request
   * @return void
   * @author dum
   */
  private function updateObservacionesIdea($comite, $request)
  {
    foreach ($request->get('ideas') as $key => $value) {
      $comite->ideas()->updateExistingPivot($value, ['observaciones' => $request->get('txtobservacionesidea')[$key]]);
    }
  }

  /**
  * Consulta los archivos de un comité
  * @param int $id Id del comité
  * @return Collection
  * @author dum
  */
  public function consultarRutasArchivosDeUnComite($id)
  {
    return Comite::find($id)->rutamodel;
  }


  //-- Consulta los entrenamientos de un nodo
  public function consultarComitesPorNodo($id)
  {
    return Comite::select('codigo', 'fechacomite' , 'comites.observaciones', 'comites.id', 'estados_comite.nombre AS estadocomite')
    ->join('comite_idea', 'comite_idea.comite_id', '=', 'comites.id')
    ->join('ideas', 'comite_idea.idea_id', '=', 'ideas.id')
    ->join('nodos', 'nodos.id', '=', 'ideas.nodo_id')
    ->leftJoin('estados_comite', 'estados_comite.id', '=', 'comites.estado_comite_id')
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

  /**
   * Genera un código al csibt
   * @param $request Datos del formulario
   * @return string
   * @author dum
   */
  private function generarCodigoComite($request)
  {
    $codigoComite = '';
    $codigoComite = Carbon::parse($request['txtfechacomite_create']);
    $nodo = sprintf("%02d", auth()->user()->infocenter->nodo_id);
    $infocenter = sprintf("%03d", auth()->user()->infocenter->id);
    $idComite = Comite::selectRaw('MAX(id+1) AS max')->get()->last();
    $idComite->max == null ? $idComite->max = 1 : $idComite->max = $idComite->max;
    $idComite->max = sprintf("%04d", $idComite->max);
    $codigoComite = 'C' . $nodo . $infocenter . '-' . $codigoComite->isoFormat('YYYY') . '-' .$idComite->max;
    return $codigoComite;
  }
  
  public function store($request) {
    DB::beginTransaction();
    try {
      $syncIdeas = array();
      $codigo_comite = $this->generarCodigoComite($request);
      $comite = Comite::create([
        'codigo' => $codigo_comite,
        'fechacomite' => $request->input('txtfechacomite_create'),
        'estado_comite_id' => EstadoComite::where('nombre', 'Agendamiento')->first()->id
      ]);
      $syncIdeas = $this->arraySyncIdeasAgendamiento($request);
      $comite->ideas()->sync($syncIdeas, false);
      $comite->ideas()->update(['estadoidea_id' => EstadoIdea::where('nombre', 'Agendamiento')->first()->id]);
      DB::commit();
      return true;
    } catch (\Throwable $th) {
      DB::rollback();
      return false;
    }
  }
  
  /**
   * Retorna array con los datos que se van a registrar en la tabla intermedia
   * @param $request Datos del formulario
   * @return array
   * @author dum
   */
  private function arraySyncIdeasAgendamiento($request)
  {
    $syncData = array();
    foreach ($request->get('ideas') as $id => $value) {
      $syncData[$id] = array('hora' => $request->horas[$id] ,'direccion' => $request->direcciones[$id], 'idea_id' => $value);
    }
    return $syncData;
  }

  // Hace el registro de un comité
  // public function store($request, $codigo)
  // {
  //   return Comite::create([
  //   'codigo' => $codigo,
  //   'fechacomite' => $request->input('txtfechacomite_create'),
  //   'observaciones' => $request->input('txtobservacionescomite'),
  //   ]);
  // }

  // // Hace el registro en la tabla Comite_Idea
  // public function storeComiteIdea($value, $idComite)
  // {
  //   return ComiteIdea::create([
  //   "idea_id"            => $value['id'],
  //   "comite_id"   => $idComite,
  //   "hora" => $value['Hora'],
  //   "admitido" => $value['Admitido'],
  //   "asistencia" => $value['Asistencia'],
  //   "observaciones" => $value['Observaciones'],
  //   ]);
  // }

  // Modifica las evidencias del comité
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
