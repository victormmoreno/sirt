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

  // /**
  //  * Retorna array con los valores de la cantidad de proyectos de incio, planeacion y ejecucion
  //  * @param Collection $proyectos Proyectos
  //  * @return array
  //  * @author dum
  //  */
  // private function ($proyectos)
  // {
  //   $inicio = 0;
  //   $planeacion = 0;
  //   foreach ($proyectos as $key => $value) {
  //     if ($value->nombre == 'Inicio') {
  //       $inicio = $value->cantidad;
  //     } else {
  //       $planeacion = $value->cantidad;
  //     }
  //   }
  //   return array('inicio' => $inicio, 'planeacion' => $planeacion);
  // }

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
   * @return array
   * @author dum
   */
  private function retornarValoresDelSeguimiento($inscritos, $trlsEsperados, $cerrados, $trlsObtenidos)
  {
    $datos = array();
    $datos['Inscritos'] = $inscritos;
    $datos['Esperado6'] = $trlsEsperados['trl6'];
    $datos['Esperado7_8'] = $trlsEsperados['trl7_8'];
    $datos['Cerrados'] = $cerrados;
    $datos['Obtenido6'] = $trlsObtenidos['trl6'];
    $datos['Obtenido7_8'] = $trlsObtenidos['trl7_8'];
    $datos['Obtenido8'] = $trlsEsperados['trl8'];
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
    $cerrados = $this->getProyectoRepository()->consultarProyectoCerradosEntreFecha('Cierre', $fecha_inicio, $fecha_fin)->where('nodos.id', $idnodo)->first()->cantidad;
    $trlObtenidos = $this->getProyectoRepository()->consultarTrl('trl_obtenido', 'fecha_cierre', $fecha_inicio, $fecha_fin)->where('nodos.id', $idnodo)->get();
    $trlEsperadosAgrupados = $this->agruparTrls($trlEsperados, 'Inicio');
    $trlObtenidosAgrupados = $this->agruparTrls($trlObtenidos, 'Cierre');
    // $articulacionGrupos = $this->getArticulacionRepository()->consultarArticulacionesFinalizadasPorFechas_Repository($fecha_inicio, $fecha_fin)->where('nodos.id', $idnodo)->where('tipo_articulacion', Articulacion::IsGrupo())->first()->cantidad;
    // $articulacionEmpresas = $this->getArticulacionRepository()->consultarArticulacionesFinalizadasPorFechas_Repository($fecha_inicio, $fecha_fin)->where('nodos.id', $idnodo)->where('tipo_articulacion', Articulacion::IsEmpresa())->first()->cantidad;
    // $articulacionEmprendedores = $this->getArticulacionRepository()->consultarArticulacionesFinalizadasPorFechas_Repository($fecha_inicio, $fecha_fin)->where('nodos.id', $idnodo)->where('tipo_articulacion', Articulacion::IsEmprendedor())->first()->cantidad;

    $datos = $this->retornarValoresDelSeguimiento($inscritos, $trlEsperadosAgrupados, $cerrados, $trlObtenidosAgrupados);

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
    $cerrados = $this->getProyectoRepository()->consultarProyectoCerradosEntreFecha('Cierre', $fecha_inicio, $fecha_fin)->where('g.id', $idgestor)->first()->cantidad;
    $trlObtenidos = $this->getProyectoRepository()->consultarTrl('trl_obtenido', 'fecha_cierre', $fecha_inicio, $fecha_fin)->where('g.id', $idgestor)->get();
    $trlEsperadosAgrupados = $this->agruparTrls($trlEsperados, 'Inicio');
    $trlObtenidosAgrupados = $this->agruparTrls($trlObtenidos, 'Cierre');
    // $articulacionGrupos = $this->getArticulacionRepository()->consultarArticulacionesFinalizadasPorFechas_Repository($fecha_inicio, $fecha_fin)->where('nodos.id', $idnodo)->where('tipo_articulacion', Articulacion::IsGrupo())->first()->cantidad;
    // $articulacionEmpresas = $this->getArticulacionRepository()->consultarArticulacionesFinalizadasPorFechas_Repository($fecha_inicio, $fecha_fin)->where('nodos.id', $idnodo)->where('tipo_articulacion', Articulacion::IsEmpresa())->first()->cantidad;
    // $articulacionEmprendedores = $this->getArticulacionRepository()->consultarArticulacionesFinalizadasPorFechas_Repository($fecha_inicio, $fecha_fin)->where('nodos.id', $idnodo)->where('tipo_articulacion', Articulacion::IsEmprendedor())->first()->cantidad;

    $datos = $this->retornarValoresDelSeguimiento($inscritos, $trlEsperadosAgrupados, $cerrados, $trlObtenidosAgrupados);

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
