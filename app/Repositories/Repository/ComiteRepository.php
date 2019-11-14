<?php

namespace App\Repositories\Repository;

use App\Models\{Comite, Idea, EstadoIdea, ComiteIdea};
use Illuminate\Support\Facades\DB;

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

       if ($request->get('admitido_ideas')[$id] == 'No') {
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
   * Modifica los datos de un comité
   *
   * @param Request $request
   * @param int $id Id del comité que se modifica
   * @return boolean
   * @author dum
   */
  public function update($request, $id)
  {
    DB::beginTransaction();
    try {
      $comite = Comite::find($id);
      $comite->update([
        'fechacomite' => request()->txtfechacomite_create,
        'observaciones' => request()->txtobservacionescomite
      ]);

      $this->cambiarEstadoDeLasIdeas($request);

      $syncData = $this->arrayIdeasDeComite($request);

      $comite->ideas()->sync($syncData, true);

      DB::commit();
      return true;
    } catch (\Exception $e) {

      DB::rollback();
      return false;
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

  // Consulta un comité por su id
  public function consultarComitePorId($id)
  {
    return Comite::select('codigo', 'fechacomite', 'id', 'correos', 'listado_asistencia', 'otros', 'observaciones')
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
