<?php

namespace App\Http\Controllers;

use App\Repositories\Repository\{ProyectoRepository, ArticulacionRepository, EdtRepository, LineaRepository};
use Illuminate\Support\Facades\{Session};
use Illuminate\Http\Request;
use App\Models\{Gestor, Articulacion};
use App\User;
use Carbon\Carbon;

class SeguimientoController extends Controller
{

  /**
   * Objeto para la clase ProyectoRepository
   * @var object
   */
  private $proyectoRepository;
  /**
   * Objeto para la clade LineaRepository
   *
   * @var object
   */
  private $lineaRepository;

  public function __construct(ProyectoRepository $proyectoRepository, LineaRepository $lineaRepository)
  {
    $this->setProyectoRepository($proyectoRepository);
    $this->setLineaRepository($lineaRepository);
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
        'lineas' => $this->getLineaRepository()->getAllLineaNodo(auth()->user()->dinamizador->nodo_id)->lineas->pluck('nombre', 'id')
      ]);
    } else if (Session::get('login_role') == User::IsGestor()) {
      return view('seguimiento.gestor.index');
    } else {
      abort('403');
    }
  }

  /**
   * Agreupa por fases la cantidad de proyectos
   *
   * @param Builder $Pabiertos Query de los proyectos por fases (Inicio, Planeación, Ejecución, Cierre)
   * @return type
   * @throws conditon
   **/
  public function agruparProyectosAbiertos($Pabiertos)
  {
    $inicio = 0;
    $planeacion = 0;
    $ejecucion = 0;
    $cierre = 0;
    $total = 0;
    foreach ($Pabiertos as $proyecto) {
      switch ($proyecto->fase) {
        case 'Inicio':
          $inicio++;
          break;
          case 'Planeación':
          $planeacion++;
          break;
        case 'Ejecución':
          $ejecucion++;
          break;
        case 'Cierre':
          $cierre++;
          break;
      }
      $total++;
    }
    return array('inicio' => $inicio, 'planeacion' => $planeacion, 'ejecucion' => $ejecucion, 'cierre' => $cierre, 'total' => $total);
  }

  /**
   * Agreupa por fases la cantidad de proyectos
   *
   * @param Builder $Pfinalizados Query de los proyectos por fases (Finalizado, Suspendido)
   * @return type
   * @throws conditon
   **/
  public function agruparProyectosCerrados($Pfinalizados)
  {
    $finalizado = 0;
    $suspendido = 0;
    $total = 0;
    foreach ($Pfinalizados as $proyecto) {
      switch ($proyecto->fase) {
        case 'Finalizado':
          $finalizado++;
          break;
        case 'Suspendido':
          $suspendido++;
          break;
      }
      $total++;
    }
    return array('finalizado' => $finalizado, 'suspendido' => $suspendido, 'total' => $total);
  }

  /**
   * Retorna array con los valores de la cantidad de trl esperado/obtenido
   * @param Collection $proyectos
   * @param string $trl Indica si se van a contar los trl esperados u obtenidos
   * @return array
   * @author dum
   **/
  public function agruparTrls($proyectos, $trl)
  {
    $total = 0;
    $trl6 = 0;
    $trl7_8 = 0;
    $trl8 = 0;
    if ($trl == 'esperados') {
      foreach ($proyectos as $key => $value) {
        if ($value->trl_esperado == 0) {
          $trl6++;
        } else {
          $trl7_8++;
        }
        $total++;
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
    return array('trl6' => $trl6, 'trl7_8' => $trl7_8, 'trl8' => $trl8, 'total' => $total);
  }

  /**
   * Retorna un array con los valores del seguimiento
   * @param array $trlsEsperados Valor entero de agrupacion de proyectos por trls esperados
   * @return array
   * @author dum
   */
  private function retornarValoresDelSeguimientoEsperados($trlsEsperados)
  {
    $datos = array();
    $datos['Activos'] = $trlsEsperados['total'];
    $datos['Esperado6'] = $trlsEsperados['trl6'];
    $datos['Esperado7_8'] = $trlsEsperados['trl7_8'];
    return $datos;
  }

  /** 
   * Retorna un array con los valores del seguimiento por fase actual
   * @param array $abiertos Array con los totales de proyectos activos
   * @param array $cerrados Array con los totales de proyectos cerrados
   * @return array
   */
  private function retornarValoresDelSeguimientoPorFases($abiertos, $cerrados) {
    $datos = array();
    $datos['Inicio'] = $abiertos['inicio'];
    $datos['Planeacion'] = $abiertos['planeacion'];
    $datos['Ejecucion'] = $abiertos['ejecucion'];
    $datos['Cierre'] = $abiertos['cierre'];
    $datos['Finalizado'] = $cerrados['finalizado'];
    $datos['Suspendido'] = $cerrados['suspendido'];
    $datos['Total'] = $abiertos['total'] + $cerrados['total'];
    return $datos;
  }

  /**
   * Consulta el seguimiento de una línea de un nodo
   *
   * @param int $linea Id de la linea_tecnologica
   * @param string $fecha_inicio Primera fecha para realizar el filtro del seguimiento
   * @param string $fecha_fin Segunda fecha para realizar el filtro del seguimiento
   * @return Reponse
   * @author dum
   */
  public function seguimientoEsperadoDeLaLinea($idlinea, $idnodo)
  {
    if (Session::get('login_role') == User::IsDinamizador()) {
      $idnodo = auth()->user()->dinamizador->nodo_id;
    }
    if (Session::get('login_role') == User::IsGestor()) {
      $idnodo = auth()->user()->gestor->nodo_id;
    }

    $datos = array();
    $trlEsperados = 0;
    $trlEsperados = $this->getProyectoRepository()->proyectosSeguimientoAbiertos('trl_esperado')->where('lineastecnologicas.id', $idlinea)->where('nodos.id', $idnodo)->get();
    $trlEsperadosAgrupados = $this->agruparTrls($trlEsperados, 'esperados');

    $datos = $this->retornarValoresDelSeguimientoEsperados($trlEsperadosAgrupados);

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
  public function seguimientoEsperadoDelGestor($id)
  {
    $gestor = Gestor::find($id);
    $idgestor = $gestor->id;
    $idnodo = $gestor->nodo_id;

    $datos = array();
    $trlEsperados = 0;
    $trlEsperados = $this->getProyectoRepository()->proyectosSeguimientoAbiertos('trl_esperado')->where('g.id', $idgestor)->where('nodos.id', $idnodo)->get();
    $trlEsperadosAgrupados = $this->agruparTrls($trlEsperados, 'esperados');

    $datos = $this->retornarValoresDelSeguimientoEsperados($trlEsperadosAgrupados);

    return response()->json([
      'datos' => $datos
    ]);
  }

  /**
   * Consulta el seguimiento de un nodo
   * @param int $id Id del nodo
   * @param string $fecha_inicio Primera fecha para realizar el filtro del seguimiento
   * @param string $fecha_fin Segunda fecha para realizar el filtro del seguimiento
   * @return Response
   * @author dum
   */
  public function seguimientoEsperadoDelNodo($id)
  {
    $idnodo = $id;
    if (Session::get('login_role') == User::IsDinamizador()) {
      $idnodo = auth()->user()->dinamizador->nodo_id;
    }

    $datos = array();
    $trlEsperados = 0;
    $trlEsperados = $this->getProyectoRepository()->proyectosSeguimientoAbiertos('trl_esperado')->where('nodos.id', $idnodo)->get();
    $trlEsperadosAgrupados = $this->agruparTrls($trlEsperados, 'esperados');

    $datos = $this->retornarValoresDelSeguimientoEsperados($trlEsperadosAgrupados);

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
    $Pabiertos = 0;
    $Pfinalizados = 0;
    // Proyectos
    $Pabiertos = $this->getProyectoRepository()->proyectosSeguimientoAbiertos()->where('nodos.id', $idnodo)->get();
    $Pfinalizados = $this->getProyectoRepository()->proyectosSeguimientoCerrados(Carbon::now()->isoFormat('YYYY'))->where('nodos.id', $idnodo)->get();

    $abiertosAgrupados = $this->agruparProyectosAbiertos($Pabiertos);
    $cerradosAgrupados = $this->agruparProyectosCerrados($Pfinalizados);
    $datos = $this->retornarValoresDelSeguimientoPorFases($abiertosAgrupados, $cerradosAgrupados);
    return response()->json([
      'datos' => $datos
    ]);
  }

  /**
   * Consulta el seguimiento de un experto, por fases actuales
   * @param int $id Id del experto
   * @return Response
   * @author dum
   **/
  public function seguimientoActualDelGestor(int $id)
  {
    $gestor = Gestor::find($id);
    $idgestor = $gestor->id;
    $idnodo = $gestor->nodo_id;

    $datos = array();
    $Pabiertos = 0;
    $Pfinalizados = 0;
    // Proyectos
    $Pabiertos = $this->getProyectoRepository()->proyectosSeguimientoAbiertos()->where('g.id', $idgestor)->where('nodos.id', $idnodo)->get();
    $Pfinalizados = $this->getProyectoRepository()->proyectosSeguimientoCerrados(Carbon::now()->isoFormat('YYYY'))->where('g.id', $idgestor)->where('nodos.id', $idnodo)->get();

    $abiertosAgrupados = $this->agruparProyectosAbiertos($Pabiertos);
    $cerradosAgrupados = $this->agruparProyectosCerrados($Pfinalizados);

    $datos = $this->retornarValoresDelSeguimientoPorFases($abiertosAgrupados, $cerradosAgrupados);
    return response()->json([
      'datos' => $datos
    ]);
  }

  /**
   * Consulta el seguimiento de una línea de un nodo, por fases actuales
   * @param int $idlinea Id de la línea
   * @param int $idnodo Id del nodo
   * @return Response
   * @author dum
   **/
  public function seguimientoActualDeLaLinea($idlinea, $idnodo)
  {
    if (Session::get('login_role') == User::IsDinamizador()) {
      $idnodo = auth()->user()->dinamizador->nodo_id;
    }
    if (Session::get('login_role') == User::IsGestor()) {
      $idnodo = auth()->user()->gestor->nodo_id;
    }

    $datos = array();
    $Pabiertos = 0;
    $Pfinalizados = 0;
    // Proyectos
    $Pabiertos = $this->getProyectoRepository()->proyectosSeguimientoAbiertos()->where('lineastecnologicas.id', $idlinea)->where('nodos.id', $idnodo)->get();
    $Pfinalizados = $this->getProyectoRepository()->proyectosSeguimientoCerrados(Carbon::now()->isoFormat('YYYY'))->where('lineastecnologicas.id', $idlinea)->where('nodos.id', $idnodo)->get();

    $abiertosAgrupados = $this->agruparProyectosAbiertos($Pabiertos);
    $cerradosAgrupados = $this->agruparProyectosCerrados($Pfinalizados);

    $datos = $this->retornarValoresDelSeguimientoPorFases($abiertosAgrupados, $cerradosAgrupados);
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
   * Asigna un valor a $lineaRepository
   * @param object
   * @return void
   * @author dum
   */
  private function setLineaRepository($lineaRepository)
  {
    $this->lineaRepository = $lineaRepository;
  }

  /**
   * Retorna el valor de $lineaRepository
   * @return object
   * @author dum
   */
  private function getLineaRepository()
  {
    return $this->lineaRepository;
  }

}