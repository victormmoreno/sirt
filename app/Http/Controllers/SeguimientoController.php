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

  public function __construct(ProyectoRepository $proyectoRepository, ArticulacionRepository $articulacionRepository, EdtRepository $edtRepository) {
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

    if ( Session::get('login_role') == User::IsDinamizador() ) {
      return view('seguimiento.dinamizador.index', [
        'gestores' => Gestor::ConsultarGestoresPorNodo(auth()->user()->dinamizador->nodo_id)->pluck('nombres_gestor', 'id'),
        // 'lineas' => $this->getLineaRepository()->getAllLineaNodo(auth()->user()->dinamizador->nodo_id)->lineas->pluck('nombre', 'id')
      ]);
    } else if ( Session::get('login_role') == User::IsGestor() ) {
      return view('seguimiento.gestor.index');
    } else {
      abort('403');
    }

  }

  /**
   * Retorna array con los valores de la cantidad de proyectos de incio, planeacion y ejecucion
   * @param Collection $proyecto Proyectos
   * @return array
   * @author dum
   */
  private function agruparProyectosEnInicioPlaneacionEjecucion($proyectos)
  {
    $inicio = 0;
    $planeacion = 0;
    $ejecucion = 0;
    foreach ($proyectos as $key => $value) {
      if ($value->nombre == 'Inicio') {
        $inicio = $value->cantidad;
      } else if ($value->nombre == 'Planeacion') {
        $planeacion = $value->cantidad;
      } else {
        $ejecucion = $value->cantidad;
      }
    }
    return array('inicio' => $inicio, 'planeacion' => $planeacion, 'ejecucion' => $ejecucion);
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
    $articulacionGrupos = 0;
    $articulacionEmpresas = 0;
    $edts = 0;
    $cierrePF = $this->getProyectoRepository()->consultarProyectoEnEstadosDeCierreDeUnGestorEntreFechas('Cierre PF', $fecha_inicio, $fecha_fin)->where('gestores.id', $idgestor)->first()->cantidad;
    $cierrePMV = $this->getProyectoRepository()->consultarProyectoEnEstadosDeCierreDeUnGestorEntreFechas('Cierre PMV', $fecha_inicio, $fecha_fin)->where('gestores.id', $idgestor)->first()->cantidad;
    $inicios = $this->getProyectoRepository()->consultarProyectoEnEstadoDeInicioPlaneacionEjecucionEntreFecha($idgestor, $fecha_inicio, $fecha_fin)->get();
    $articulacionGrupos = $this->getArticulacionRepository()->consultarArticulacionesFinalizadasPorGestorYFechas_Repository($idgestor, $fecha_inicio, $fecha_fin)->where('tipo_articulacion', Articulacion::IsGrupo())->first()->cantidad;
    $articulacionEmpresas = $this->getArticulacionRepository()->consultarArticulacionesFinalizadasPorGestorYFechas_Repository($idgestor, $fecha_inicio, $fecha_fin)->where('tipo_articulacion', Articulacion::IsEmpresa())->first()->cantidad;
    $agrupacion = $this->agruparProyectosEnInicioPlaneacionEjecucion($inicios);
    $edts = $this->getEdtRepository()->consultaEdtsDeUnGestorPorFechas_Respository($fecha_inicio, $fecha_fin)->where('gestores.id', $idgestor)->first()->cantidad;

    $datos['CierrePF'] = $cierrePF;
    $datos['CierrePMV'] = $cierrePMV;
    $datos['Inicio'] = $agrupacion['inicio'];
    $datos['Planeacion'] = $agrupacion['planeacion'];
    $datos['Ejecucion'] = $agrupacion['ejecucion'];
    $datos['ArticulacionesGI'] = $articulacionGrupos;
    $datos['ArticulacionesEmp'] = $articulacionEmpresas;
    $datos['Edts'] = $edts;

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
