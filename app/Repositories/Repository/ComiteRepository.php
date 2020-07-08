<?php

namespace App\Repositories\Repository;

use App\Repositories\Repository\UserRepository\DinamizadorRepository;
use App\Models\{Comite, Infocenter, EstadoIdea, EstadoComite};
use App\Events\Comite\{AgendamientoWasRegistered, ComiteWasRegistered};
use Illuminate\Support\Facades\{DB, Notification};
use App\Notifications\Comite\ComiteRealizado;
use App\Http\Controllers\PDF\PdfComiteController;
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
    
    DB::beginTransaction();
    try {
      $comite = Comite::findOrFail($id);
      foreach ($comite->ideas as $key => $value) {
        event(new AgendamientoWasRegistered($value, $comite));
      }
      DB::commit();
      return true;
    } catch (\Throwable $th) {
      DB::rollBack();
      return false;
    }
  }

  public function notificar_realizado(int $id)
  {
    DB::beginTransaction();
    try {
      $comite = Comite::findOrFail($id);
      $dinamizadorRepository = new DinamizadorRepository;
      $dinamizadores = $dinamizadorRepository->getAllDinamizadoresPorNodo(auth()->user()->infocenter->nodo_id)->get();
      $infocenter = auth()->user()->nombres . " " . auth()->user()->apellidos;
      Notification::send($dinamizadores, new ComiteRealizado($comite, $infocenter));
      DB::commit();
      return true;
    } catch (\Throwable $th) {
      DB::rollBack();
      return false;
    }
  }

  /**
   * Envia un email con un archivo adjunto de los resultados del comité a la persona que registra la idea.
   * @param int $id Id de la idea
   * @param int $idComite Id del comité
   * @return boolean
   * @author dum
   */
  public function notificar_resultados(int $id, int $idComite)
  {
    DB::beginTransaction();
    try {
      $extensiones = "";
      $comite = Comite::findOrFail($idComite);
      $idea = $comite->ideas()->wherePivot('idea_id', $id)->first();
      $infocenters = $idea->nodo->infocenter;
      foreach ($infocenters as $key => $value) {
        $extensiones = $extensiones . $value->extension . ", ";
      }
      if ($idea->pivot->admitido == 1) {
        $pdf = PdfComiteController::printPDF($idea, $comite);
      } else {
        $pdf = PdfComiteController::printPDFNoAceptado($idea, $comite, $extensiones);
      }
      event(new ComiteWasRegistered($idea, $pdf, $extensiones));
      DB::commit();
      return true;
    } catch (\Throwable $th) {
      DB::rollBack();
      return false;
    }
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
      $comite->ideas()->update(['estadoidea_id' => EstadoIdea::where('nombre', 'Programado')->first()->id]);
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
      // Cambia el estado de las ideas de proyecto
      $this->updateEstadoIdeas($comite, $request);

      DB::commit();
      return true;
    } catch (\Throwable $th) {
      DB::rollBack();
      return false;
    }
  }

  /**
   * Asignar gestores a cargo de ideas de proyecto
   * @param $request
   * @param int $id
   * @return boolean
   * @author dum
   */
  public function updateAsignar($request, int $id)
  {
    DB::beginTransaction();
    try {
      $comite = Comite::findOrFail($id);
      $comite->update(['estado_comite_id' => EstadoComite::where('nombre', 'Proyectos asignados')->first()->id]);
      $this->asignarIdeasAGestores($comite, $request);
      DB::commit();
      return true;
    } catch (\Throwable $th) {
      DB::rollBack();
      return false;
    }
  }

  /**
   * Asigna a los gestores las ideas de proyectos que se aprobaron en el comité
   * @param Comite $comite
   * @param $request
   * @return void
   * @author dum
   */
  private function asignarIdeasAGestores(Comite $comite, $request)
  {
    foreach ($comite->ideas as $key => $value) {
      if ($value->pivot->admitido == 1) {
        $value->update(['gestor_id' => $request->txtgestores[$key]]);
      }
    }
  }

  /**
   * Cambia el estado de las ideas de proyecto según el caso.
   * @param Comite $comite
   * @param $request Request
   * @return void
   * @author dum
   */
  private function updateEstadoIdeas(Comite $comite, $request)
  {
    foreach ($comite->ideas as $key => $value) {
      $value->update([ 'estadoidea_id' => EstadoIdea::where('nombre', $request->get('txtestadoidea')[$key])->first()->id ]);
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
        'estado_comite_id' => EstadoComite::where('nombre', 'Programado')->first()->id
      ]);
      $syncIdeas = $this->arraySyncIdeasAgendamiento($request);
      $comite->ideas()->sync($syncIdeas, false);
      $comite->ideas()->update(['estadoidea_id' => EstadoIdea::where('nombre', 'Programado')->first()->id]);
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
