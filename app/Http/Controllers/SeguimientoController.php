<?php

namespace App\Http\Controllers;

use App\Repositories\Repository\{ProyectoRepository, ArticulacionRepository, EdtRepository};
use Illuminate\Support\Facades\{Session};
use Illuminate\Http\Request;
use App\Models\{Gestor, Articulacion};
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
  /**
   * Objeto para la clade EdtRepository
   *
   * @var object
   */
  private $edtRepository;

  public function __construct(ProyectoRepository $proyectoRepository, ArticulacionRepository $articulacionRepository, EdtRepository $edtRepository)
  {
    $this->setProyectoRepository($proyectoRepository);
    $this->setArticulacionRepository($articulacionRepository);
    $this->setEdtRepository($edtRepository);
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {

    if (Session::get('login_role') == User::IsDinamizador()) {
      return view('seguimiento.dinamizador.index', [
        'gestores' => Gestor::ConsultarGestoresPorNodo(auth()->user()->dinamizador->nodo_id)->pluck('nombres_gestor', 'id'),
        // 'lineas' => $this->getLineaRepository()->getAllLineaNodo(auth()->user()->dinamizador->nodo_id)->lineas->pluck('nombre', 'id')
      ]);
    } else if (Session::get('login_role') == User::IsGestor()) {
      return view('seguimiento.gestor.index');
    } else {
      abort('403');
    }
  }

  /**
   * Retorna array con los valores de la cantidad de trl esperado/obtenido
   * @param Collection $proyectos
   * @param string $fase Indica si se van a contar los trl esperados u obtenidos
   * @return array
   * @author dum
   **/
  public function agruparTrls($proyectos, $fase)
  {
    $trl6 = 0;
    $trl7_8 = 0;
    $trl8 = 0;
    if ($fase == 'Inicio') {
      foreach ($proyectos as $key => $value) {
        if ($value->trl_esperado == 0) {
          $trl6 = $value->cantidad;
        } else {
          $trl7_8 = $value->cantidad;
        }
      }
    } else {
      foreach ($proyectos as $key => $value) {
        if ($value->trl_obtenido == 0) {
          $trl6 = $value->cantidad;
        } elseif ($value->trl_obtenido == 1) {
          $trl7_8 = $value->cantidad;
        } else {
          $trl8 = $value->cantidad;
        }
      }
    }
    return array('trl6' => $trl6, 'trl7_8' => $trl7_8, 'trl8' => $trl8);
  }

  /**
   * Retorna un array con los valores del seguimiento
   * @param int $inscritos Valor entero de proyectos inscritos
   * @param array $trlsEsperados Valor entero de agrupacion de proyectos por trls esperados
   * @param int $cerrados Valor entero de proyectos cerrados
   * @param array $trlsObtenidos Valor entero de agrupacion de proyectos por trls obtenidos
   * @param int $articulacionesInscritas Valor entero de articulaciones inscritas
   * @param int $articulacionesCerradas Valor entero de articulaciones cerradas
   * @return array
   * @author dum
   */
  private function retornarValoresDelSeguimiento($inscritos, $trlsEsperados, $cerrados, $trlsObtenidos, $articulacionesInscritas, $articulacionesCerradas)
  {
    $datos = array();
    $datos['Inscritos'] = $inscritos;
    $datos['Esperado6'] = $trlsEsperados['trl6'];
    $datos['Esperado7_8'] = $trlsEsperados['trl7_8'];
    $datos['Cerrados'] = $cerrados;
    $datos['Obtenido6'] = $trlsObtenidos['trl6'];
    $datos['Obtenido7_8'] = $trlsObtenidos['trl7_8'];
    $datos['Obtenido8'] = $trlsObtenidos['trl8'];
    $datos['ArticulacionesInscritas'] = $articulacionesInscritas;
    $datos['ArticulacionesCerradas'] = $articulacionesCerradas;
    return $datos;
  }

  /** 
   * Retorna un array con los valores del seguimiento por fase actual
   * @param int $Pinicio Cantidad de proyectos en fase inicio
   * @param int $Pplaneacion Cantidad de proyectos en fase planeacion
   * @param int $Pejecucion Cantidad de proyectos en fase ejecucion
   * @param int $Pcierre Cantidad de proyectos en fase cierre
   * @param int $
   * @param int $
   * @param int $
   * @param int $
   */
  private function retornarValoresDelSeguimientoFases(int $Pinicio, int $Pplaneacion, int $Pejecucion, int $Pcierre, int $Pfinalizado, int $Psuspendido) {
    $datos = array();
    $datos['ProyectosInicio'] = $Pinicio;
    $datos['ProyectosPlaneacion'] = $Pplaneacion;
    $datos['ProyectosEjecucion'] = $Pejecucion;
    $datos['ProyectosCierre'] = $Pcierre;
    $datos['ProyectosFinalizado'] = $Pfinalizado;
    $datos['ProyectosSuspendido'] = $Psuspendido;

    // $datos['ArticulacionesInicio'] = $Ainicio;
    // $datos['ArticulacionesPlaneacion'] = $Aplaneacion;
    // $datos['ArticulacionesEjecucion'] = $Aejecucion;
    // $datos['ArticulacionesCierre'] = $Acierre;
    return $datos;
  }

  /**
   * Consulta el seguimiento de un nodo
   * @param int $id Id del nodo
   * @param string $fecha_inicio Primera fecha para realizar el filtro del seguimiento
   * @param string $fecha_fin Segunda fecha para realizar el filtro del seguimiento
   * @return Response
   * @author dum
   */
  public function seguimientoDelNodo($id, $fecha_inicio, $fecha_fin)
  {
    $idnodo = $id;
    if (Session::get('login_role') == User::IsDinamizador()) {
      $idnodo = auth()->user()->dinamizador->nodo_id;
    }

    $datos = array();
    $trlEsperados = 0;
    $inscritos = 0;
    $cerrados = 0;
    $trlObtenidos = 0;
    $trlEsperados = $this->getProyectoRepository()->consultarTrl('trl_esperado', 'fecha_inicio', $fecha_inicio, $fecha_fin)->where('nodos.id', $idnodo)->get();
    $inscritos = $this->getProyectoRepository()->consultarProyectoInscritosEntreFecha($fecha_inicio, $fecha_fin)->where('nodos.id', $idnodo)->first()->cantidad;
    $cerrados = $this->getProyectoRepository()->consultarProyectoCerradosEntreFecha('Finalizado', $fecha_inicio, $fecha_fin)->where('nodos.id', $idnodo)->first()->cantidad;
    $trlObtenidos = $this->getProyectoRepository()->consultarTrl('trl_obtenido', 'fecha_cierre', $fecha_inicio, $fecha_fin)->where('nodos.id', $idnodo)->where('fases.nombre', 'Cierre')->get();
    $trlEsperadosAgrupados = $this->agruparTrls($trlEsperados, 'Inicio');
    $trlObtenidosAgrupados = $this->agruparTrls($trlObtenidos, 'Cierre');
    $articulacionesInscritas = $this->getArticulacionRepository()->consultarArticulacionesEntreFecha_Repository('fecha_inicio', $fecha_inicio, $fecha_fin)->where('nodos.id', $idnodo)->where('tipo_articulacion', Articulacion::IsGrupo())->first()->cantidad;
    $articulacionesCerradas = $this->getArticulacionRepository()->consultarArticulacionesEntreFecha_Repository('fecha_cierre', $fecha_inicio, $fecha_fin)->where('nodos.id', $idnodo)->where('fases.nombre', 'Cierre')->where('tipo_articulacion', Articulacion::IsGrupo())->first()->cantidad;

    $datos = $this->retornarValoresDelSeguimiento($inscritos, $trlEsperadosAgrupados, $cerrados, $trlObtenidosAgrupados, $articulacionesInscritas, $articulacionesCerradas);

    return response()->json([
      'datos' => $datos
    ]);
  }

  /**
   * Consulta el seguimiento de un nodo, por fases actuales
   * @param int $id Id del nodo
   * @return Response
   * @author dum
   **/
  public function seguimientoDelNodoFases(int $id)
  {
    $idnodo = $id;
    if (Session::get('login_role') == User::IsDinamizador()) {
      $idnodo = auth()->user()->dinamizador->nodo_id;
    }

    $datos = array();
    $Pinicio = 0;
    $Pplaneacion = 0;
    $Pejecucion = 0;
    $Pcierre = 0;
    $Psuspendido = 0;
    // Proyectos
    $Pinicio = $this->getProyectoRepository()->consultarProyectosFase('Inicio')->where('nodos.id', $idnodo)->first()->cantidad;
    $Pplaneacion = $this->getProyectoRepository()->consultarProyectosFase('Planeación')->where('nodos.id', $idnodo)->first()->cantidad;
    $Pejecucion = $this->getProyectoRepository()->consultarProyectosFase('Ejecución')->where('nodos.id', $idnodo)->first()->cantidad;
    $Pcierre = $this->getProyectoRepository()->consultarProyectosFase('Cierre')->where('nodos.id', $idnodo)->first()->cantidad;
    $Pfinalizado = $this->getProyectoRepository()->consultarProyectosFase('Finalizado')->where('nodos.id', $idnodo)->first()->cantidad;
    $Psuspendido = $this->getProyectoRepository()->consultarProyectosFase('Suspendido')->where('nodos.id', $idnodo)->first()->cantidad;

    $datos = $this->retornarValoresDelSeguimientoFases($Pinicio, $Pplaneacion, $Pejecucion, $Pcierre, $Pfinalizado, $Psuspendido);
    return response()->json([
      'datos' => $datos
    ]);
  }

  /**
   * Consulta el seguimiento de un nodo, por fases actuales
   * @param int $id Id del nodo
   * @return Response
   * @author dum
   **/
  public function seguimientoDelGestorFases(int $id)
  {
    $idgestor = $id;
    if (Session::get('login_role') == User::IsGestor()) {
      $idgestor = auth()->user()->gestor->id;
      $idnodo = auth()->user()->gestor->nodo_id;
    }
    if (Session::get('login_role') == User::IsDinamizador()) {
      $idnodo = auth()->user()->dinamizador->nodo_id;
    }

    $datos = array();
    $Pinicio = 0;
    $Pplaneacion = 0;
    $Pejecucion = 0;
    $Pcierre = 0;
    $Psuspendido = 0;
    // Proyectos
    $Pinicio = $this->getProyectoRepository()->consultarProyectosFase('Inicio')->where('g.id', $idgestor)->where('nodos.id', $idnodo)->first()->cantidad;
    $Pplaneacion = $this->getProyectoRepository()->consultarProyectosFase('Planeación')->where('g.id', $idgestor)->where('nodos.id', $idnodo)->first()->cantidad;
    $Pejecucion = $this->getProyectoRepository()->consultarProyectosFase('Ejecución')->where('g.id', $idgestor)->where('nodos.id', $idnodo)->first()->cantidad;
    $Pcierre = $this->getProyectoRepository()->consultarProyectosFase('Cierre')->where('g.id', $idgestor)->where('nodos.id', $idnodo)->first()->cantidad;
    $Pfinalizado = $this->getProyectoRepository()->consultarProyectosFase('Finalizado')->where('g.id', $idgestor)->where('nodos.id', $idnodo)->first()->cantidad;
    $Psuspendido = $this->getProyectoRepository()->consultarProyectosFase('Suspendido')->where('g.id', $idgestor)->where('nodos.id', $idnodo)->first()->cantidad;

    $datos = $this->retornarValoresDelSeguimientoFases($Pinicio, $Pplaneacion, $Pejecucion, $Pcierre, $Pfinalizado, $Psuspendido);
    return response()->json([
      'datos' => $datos
    ]);
  }

  /**
   * Consulta el seguimiento de un gestor
   *
   * @param int $id Id del gestor
   * @param string $fecha_inicio Primera fecha para realizar el filtro del seguimiento
   * @param string $fecha_fin Segunda fecha para realizar el filtro del seguimiento
   * @return Reponse
   * @author dum
   */
  public function seguimientoDelGestor($id, $fecha_inicio, $fecha_fin)
  {
    $idgestor = $id;
    if (Session::get('login_role') == User::IsGestor()) {
      $idgestor = auth()->user()->gestor->id;
    }

    $datos = array();
    $trlEsperados = 0;
    $inscritos = 0;
    $cerrados = 0;
    $trlObtenidos = 0;
    $trlEsperados = $this->getProyectoRepository()->consultarTrl('trl_esperado', 'fecha_inicio', $fecha_inicio, $fecha_fin)->where('g.id', $idgestor)->get();
    $inscritos = $this->getProyectoRepository()->consultarProyectoInscritosEntreFecha($fecha_inicio, $fecha_fin)->where('g.id', $idgestor)->first()->cantidad;
    $cerrados = $this->getProyectoRepository()->consultarProyectoCerradosEntreFecha('Finalizado', $fecha_inicio, $fecha_fin)->where('g.id', $idgestor)->first()->cantidad;
    $trlObtenidos = $this->getProyectoRepository()->consultarTrl('trl_obtenido', 'fecha_cierre', $fecha_inicio, $fecha_fin)->where('g.id', $idgestor)->where('fases.nombre', 'Cierre')->get();
    $trlEsperadosAgrupados = $this->agruparTrls($trlEsperados, 'Inicio');
    $trlObtenidosAgrupados = $this->agruparTrls($trlObtenidos, 'Cierre');
    $articulacionesInscritas = $this->getArticulacionRepository()->consultarArticulacionesEntreFecha_Repository('fecha_inicio', $fecha_inicio, $fecha_fin)->where('g.id', $idgestor)->where('tipo_articulacion', Articulacion::IsGrupo())->first()->cantidad;
    $articulacionesCerradas = $this->getArticulacionRepository()->consultarArticulacionesEntreFecha_Repository('fecha_cierre', $fecha_inicio, $fecha_fin)->where('g.id', $idgestor)->where('fases.nombre', 'Cierre')->where('tipo_articulacion', Articulacion::IsGrupo())->first()->cantidad;

    $datos = $this->retornarValoresDelSeguimiento($inscritos, $trlEsperadosAgrupados, $cerrados, $trlObtenidosAgrupados, $articulacionesInscritas, $articulacionesCerradas);

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

  /**
   * Asigna un valor a $edtRepository
   * @param object $edtRepository
   * @return void
   * @author dum
   */
  private function setEdtRepository($edtRepository)
  {
    $this->edtRepository = $edtRepository;
  }

  /**
   * Retorna el valor de $edtRepository
   * @return object
   * @author dum
   */
  private function getEdtRepository()
  {
    return $this->edtRepository;
  }
}