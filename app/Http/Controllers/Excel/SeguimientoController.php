<?php

namespace App\Http\Controllers\Excel;

use App\Exports\Seguimiento\{SeguimientoExport};
use App\Repositories\Repository\{ProyectoRepository, ArticulacionRepository, EdtRepository};
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Articulacion;
use App\User;
use Excel;

class SeguimientoController extends Controller
{

  /**
   * Objeto para la clase ArticulacionRepository
   * @var ArticulacionRepository
   * @author dum
   */
  private $articulacionRepository;

  /**
   * Objeto para la clase EdtRepository
   * @var EdtRepository
   * @author dum
   */
  private $edtRepository;

  /**
   * Objeto para la clase ProyectoRepository
   * @var ProyectoRepository
   * @author dum
   */
  private $proyectoRepository;

  public function __construct(ProyectoRepository $proyectoRepository, ArticulacionRepository $articulacionRepository, EdtRepository $edtRepository)
  {
    $this->setArticulacionRepository($articulacionRepository);
    $this->setEdtRepository($edtRepository);
    $this->setProyectoRepository($proyectoRepository);
  }

  public function consultarSeguimientoDelNodo($id, $fecha_inicio, $fecha_fin)
  {
    $idnodo = $id;
    if ( Session::get('login_role') == User::IsDinamizador() ) {
      $idnodo = auth()->user()->dinamizador->nodo_id;
    }

    $queryInicio = $this->getProyectoRepository()->consultarProyectosPorEstados_Detalle('Inicio')->whereBetween('fecha_inicio', [$fecha_inicio, $fecha_fin])->where('nodos.id', $idnodo)->get();
    $queryPlaneacion = $this->getProyectoRepository()->consultarProyectosPorEstados_Detalle('Planeacion')->whereBetween('fecha_inicio', [$fecha_inicio, $fecha_fin])->where('nodos.id', $idnodo)->get();
    $queryEjecucion = $this->getProyectoRepository()->consultarProyectosPorEstados_Detalle('En ejecución')->whereBetween('fecha_inicio', [$fecha_inicio, $fecha_fin])->where('nodos.id', $idnodo)->get();
    $queryPF = $this->getProyectoRepository()->consultarProyectosPorEstados_Detalle('Cierre PF')->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_fin])->where('nodos.id', $idnodo)->get();
    $queryPMV = $this->getProyectoRepository()->consultarProyectosPorEstados_Detalle('Cierre PMV')->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_fin])->where('nodos.id', $idnodo)->get();
    $querySuspendidos = $this->getProyectoRepository()->consultarProyectosPorEstados_Detalle('Suspendido')->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_fin])->where('nodos.id', $idnodo)->get();
    $queryArticulacionGrupos = $this->getArticulacionRepository()->consultarArticulacionesFinalizadasPorFecha_Detalle($fecha_inicio, $fecha_fin)->where('nodos.id', $idnodo)->where('tipo_articulacion', Articulacion::IsGrupo())->get();
    $queryArticulacionEmpresas = $this->getArticulacionRepository()->consultarArticulacionesFinalizadasPorFecha_Detalle($fecha_inicio, $fecha_fin)->where('nodos.id', $idnodo)->where('tipo_articulacion', Articulacion::IsEmpresa())->get();
    $queryArticulacionEmprendedores = $this->getArticulacionRepository()->consultarArticulacionesFinalizadasPorFecha_Detalle($fecha_inicio, $fecha_fin)->where('nodos.id', $idnodo)->where('tipo_articulacion', Articulacion::IsEmprendedor())->get();

    return Excel::download(new SeguimientoExport($queryInicio, $queryPlaneacion, $queryEjecucion, $queryPF, $queryPMV, $querySuspendidos, $queryArticulacionGrupos, $queryArticulacionEmpresas, $queryArticulacionEmprendedores), 'Seguimiento.xls');
  }


  /**
   * Asigna un valor a $articulacionRepository
   * @param ArticulacionRepository
   * @return void
   * @author dum
   */
  private function setArticulacionRepository(ArticulacionRepository $articulacionRepository)
  {
    $this->articulacionRepository = $articulacionRepository;
  }

  /**
   * Retorna el valor de $articulacionRepository
   * @return ArticulacionRepository
   * @author dum
   */
  private function getArticulacionRepository()
  {
    return $this->articulacionRepository;
  }

  /**
   * Asigna un valor a $edtRepository
   * @param EdtRepository $edtRepository
   * @return void
   * @author dum
   */
  private function setEdtRepository(EdtRepository $edtRepository)
  {
    $this->edtRepository = $edtRepository;
  }

  /**
   * Retorna el valor de $edtRepository
   * @return EdtRepository
   * @author dum
   */
  private function getEdtRepository()
  {
    return $this->edtRepository;
  }

  /**
   * Asgina un valor a $proyectoRepository
   * @param ProyectoRepository $proyectoRepository
   * @return void
   * @author dum
   */
  private function setProyectoRepository(ProyectoRepository $proyectoRepository)
  {
    $this->proyectoRepository = $proyectoRepository;
  }

  /**
   * Retorna el valor de $proyectoRepository
   * @return ProyectoRepository
   * @author dum
   */
  private function getProyectoRepository()
  {
    return $this->proyectoRepository;
  }

}
