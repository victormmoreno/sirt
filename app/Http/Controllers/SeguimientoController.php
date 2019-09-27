<?php

namespace App\Http\Controllers;

use App\Repositories\Repository\{ProyectoRepository, ArticulacionRepository};
use Illuminate\Support\Facades\{Session};
use Illuminate\Http\Request;
use App\Models\Gestor;
use App\User;

class SeguimientoController extends Controller
{

  /**
   * Objeto para la clase ProyectoRepository
   * @var object
   */
  private $proyectoRepository;
  /**
   * Objeto para la clase ArticulacionRepository
   *
   * @var object
   */
  private $articulacionRepository;

  public function __construct(ProyectoRepository $proyectoRepository, ArticulacionRepository $articulacionRepository) {
    $this->setProyectoRepository($proyectoRepository);
    $this->setArticulacionRepository($articulacionRepository);
  }

  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {

    if ( Session::get('login_role') == User::IsDinamizador() ) {
      return view('seguimiento.dinamizador.index', [
        'gestores' => Gestor::ConsultarGestoresPorNodo(auth()->user()->dinamizador->nodo_id)->pluck('nombres_gestor', 'id'),
        // 'lineas' => $this->getLineaRepository()->getAllLineaNodo(auth()->user()->dinamizador->nodo_id)->lineas->pluck('nombre', 'id')
      ]);
    }

  }

  /**
   * Consulta el seguimiento de un gestor
   *
   * @param int $id Id del gestor
   * @param string $fecha_inicio Primera fecha para realizar el filtro
   * @param string $fecha_fin Segunda fecha para realizar el filtro
   * @return Reponse
   * @author dum
   */
  public function seguimientoDelGestor($id, $fecha_inicio, $fecha_fin)
  {
    $idgestor = $id;
    if ( Session::get('login_role') == User::IsGestor() ) {
      $idgestor = auth()->user()->gestor->id;
    }

    $datos = array();
    $cierrePF = 0;
    $cierrePMV = 0;
    $inicio = 0;
    $planeacion = 0;
    $ejecucion = 0;
    $cierrePF = $this->getProyectoRepository()->consultarProyectoEnEstadosDeCierreDeUnGestorEntreFechas('Cierre PF', $fecha_inicio, $fecha_fin)->where('gestores.id', $idgestor)->first()->cantidad;
    $cierrePMV = $this->getProyectoRepository()->consultarProyectoEnEstadosDeCierreDeUnGestorEntreFechas('Cierre PMV', $fecha_inicio, $fecha_fin)->where('gestores.id', $idgestor)->first()->cantidad;
    $inicios = $this->getProyectoRepository()->consultarProyectoEnEstadoDeInicioPlaneacionEjecucionEntreFecha($idgestor, $fecha_inicio, $fecha_fin)->get();
    $articulacionGrupos = $this->getArticulacionRepository()->consultarArticulacionPorGestorYFechasFinalizadas($idgestor, $fecha_inicio, $fecha_fin)->get();

    foreach ($inicios as $key => $value) {
      if ($value->nombre == 'Inicio') {
        $inicio = $value->cantidad;
      } else if ($value->nombre == 'Planeacion') {
        $planeacion = $value->cantidad;
      } else {
        $ejecucion  = $value->cantidad;
      }
    }

    $datos['CierrePF'] = $cierrePF;
    $datos['CierrePMV'] = $cierrePMV;
    $datos['Inicio'] = $inicio;
    $datos['Planeacion'] = $planeacion;
    $datos['Ejecucion'] = $ejecucion;


    return response()->json([
      'datos' => $datos
    ]);
  }

  /**
   * Asigna un valor a $proyectoRepository
   * @param object $proyectoRepository
   * @return void
   * @author dum
   */
  private function setProyectoRepository($proyectoRepository)
  {
    $this->proyectoRepository = $proyectoRepository;
  }

  /**
   * Retorna el valor de $proyectoRepository
   * @return object
   * @author dum
   */
  private function getProyectoRepository()
  {
    return $this->proyectoRepository;
  }

  /**
   * Asigna un valor a $articulacionRepository
   * @param object
   * @return void
   * @author dum
   */
  private function setArticulacionRepository($articulacionRepository)
  {
    $this->articulacionRepository = $articulacionRepository;
  }

  /**
   * Retorna el valor de $articulacionRepository
   * @return object
   * @author dum
   */
  private function getArticulacionRepository()
  {
    return $this->articulacionRepository;
  }

}
