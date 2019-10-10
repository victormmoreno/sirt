<?php

namespace App\Http\Controllers\Excel;

use App\Exports\Seguimiento\{SeguimientoExport};
use App\Repositories\Repository\{ProyectoRepository, ArticulacionRepository, EdtRepository, UserRepository\TalentoRepository, EmpresaRepository, GrupoInvestigacionRepository};
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

  /**
   * Objeto para la clase TalentoRepository
   * @var TalentoRepository
   */
  private  $talentoRepository;

  /**
   * Objeto para la clase EmpresaRepository
   *
   * @var EmpresaRepository
   */
  private $empresaRepository;

  /**
   * undocumented class variable
   *
   * @var GrupoInvestigacionRepository
   */
  private $grupoInvestigacionRepository;

  public function __construct(ProyectoRepository $proyectoRepository, ArticulacionRepository $articulacionRepository, EdtRepository $edtRepository, TalentoRepository $talentoRepository, EmpresaRepository $empresaRepository, GrupoInvestigacionRepository $grupoInvestigacionRepository)
  {
    $this->setArticulacionRepository($articulacionRepository);
    $this->setEdtRepository($edtRepository);
    $this->setProyectoRepository($proyectoRepository);
    $this->setTalentoRepository($talentoRepository);
    $this->setEmpresaRepository($empresaRepository);
    $this->setGrupoInvestigacionRepository($grupoInvestigacionRepository);
  }

  /**
   * Genera el detalle del seguimiento de un gestor
   * @param int $id Id del gestor
   * @param string $fecha_inicio Primera fecha para realizar el filtro
   * @param string $fecha_fin Segunda fecha para realizar el filtro
   * @return Excel
   * @author dum
   */
  public function consultarSeguimientoDelGestor($id, $fecha_inicio, $fecha_fin)
  {
    $idgestor = $id;
    if ( Session::get('login_role') == User::IsGestor() ) {
      $idgestor = auth()->user()->gestor->id;
    }

    $queryInicio = $this->getProyectoRepository()->consultarProyectosPorEstados_Detalle('Inicio')->whereBetween('fecha_inicio', [$fecha_inicio, $fecha_fin])->where('gestores.id', $idgestor)->get();
    $queryPlaneacion = $this->getProyectoRepository()->consultarProyectosPorEstados_Detalle('Planeacion')->whereBetween('fecha_inicio', [$fecha_inicio, $fecha_fin])->where('gestores.id', $idgestor)->get();
    $queryEjecucion = $this->getProyectoRepository()->consultarProyectosPorEstados_Detalle('En ejecución')->whereBetween('fecha_inicio', [$fecha_inicio, $fecha_fin])->where('gestores.id', $idgestor)->get();
    $queryPF = $this->getProyectoRepository()->consultarProyectosPorEstados_Detalle('Cierre PF')->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_fin])->where('gestores.id', $idgestor)->get();
    $queryPMV = $this->getProyectoRepository()->consultarProyectosPorEstados_Detalle('Cierre PMV')->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_fin])->where('gestores.id', $idgestor)->get();
    $querySuspendidos = $this->getProyectoRepository()->consultarProyectosPorEstados_Detalle('Suspendido')->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_fin])->where('gestores.id', $idgestor)->get();
    $queryArticulacionGrupos = $this->getArticulacionRepository()->consultarArticulacionesFinalizadasPorFecha_Detalle($fecha_inicio, $fecha_fin)->where('gestores.id', $idgestor)->where('tipo_articulacion', Articulacion::IsGrupo())->get();
    $queryArticulacionEmpresas = $this->getArticulacionRepository()->consultarArticulacionesFinalizadasPorFecha_Detalle($fecha_inicio, $fecha_fin)->where('gestores.id', $idgestor)->where('tipo_articulacion', Articulacion::IsEmpresa())->get();
    $queryArticulacionEmprendedores = $this->getArticulacionRepository()->consultarArticulacionesFinalizadasPorFecha_Detalle($fecha_inicio, $fecha_fin)->where('gestores.id', $idgestor)->where('tipo_articulacion', Articulacion::IsEmprendedor())->get();
    $queryEdts = $this->getEdtRepository()->consultarEdtsPorFecha_Detalle($fecha_inicio, $fecha_fin)->where('gestores.id', $idgestor)->get();
    $queryTalentos = $this->getTalentoRepository()->consultarTalentosAsociadosAProyectos($fecha_inicio, $fecha_fin)->where('gestores.id', $idgestor)->get();
    $queryEmpresas = $this->getEmpresaRepository()->consultarEmpresasAsociadosAServicios($fecha_inicio, $fecha_fin)->where('gestores.id', $idgestor)->get();
    $queryGruposInvestigacion = $this->getGrupoInvestigacionRepository()->consultarGruposInvestigacionAsociadosAServicios($fecha_inicio, $fecha_fin)->where('gestores.id', $idgestor)->get();

    return Excel::download(new SeguimientoExport($queryInicio, $queryPlaneacion, $queryEjecucion, $queryPF, $queryPMV, $querySuspendidos, $queryArticulacionGrupos, $queryArticulacionEmpresas, $queryArticulacionEmprendedores, $queryEdts, $queryTalentos, $queryEmpresas, $queryGruposInvestigacion), 'Seguimiento.xls');
  }

  /**
   * Genera el detalle del seguimiento de un nodo
   * @param int $id Id del nodo
   * @param string $fecha_inicio Primera fecha para realizar el filtro
   * @param string $fecha_fin Segunda fecha para realizar el filtro
   * @return Excel
   * @author dum
   */
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
    $queryEdts = $this->getEdtRepository()->consultarEdtsPorFecha_Detalle($fecha_inicio, $fecha_fin)->where('nodos.id', $idnodo)->get();
    $queryTalentos = $this->getTalentoRepository()->consultarTalentosAsociadosAProyectos($fecha_inicio, $fecha_fin)->where('nodos.id', $idnodo)->get();
    $queryEmpresas = $this->getEmpresaRepository()->consultarEmpresasAsociadosAServicios($fecha_inicio, $fecha_fin)->where('nodos.id', $idnodo)->get();
    $queryGruposInvestigacion = $this->getGrupoInvestigacionRepository()->consultarGruposInvestigacionAsociadosAServicios($fecha_inicio, $fecha_fin)->where('nodos.id', $idnodo)->get();

    return Excel::download(new SeguimientoExport($queryInicio, $queryPlaneacion, $queryEjecucion, $queryPF, $queryPMV, $querySuspendidos, $queryArticulacionGrupos, $queryArticulacionEmpresas, $queryArticulacionEmprendedores, $queryEdts, $queryTalentos, $queryEmpresas, $queryGruposInvestigacion), 'Seguimiento.xls');
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


  /**
  * Get the value of Objeto para la clase TalentoRepository
  * @return TalentoRepository
  */
  public function getTalentoRepository()
  {
    return $this->talentoRepository;
  }

  /**
  * Set the value of Objeto para la clase TalentoRepository
  * @param TalentoRepository talentoRepository
  */
  public function setTalentoRepository(TalentoRepository $talentoRepository)
  {
    $this->talentoRepository = $talentoRepository;
  }


  /**
  * Get the value of Objeto para la clase EmpresaRepository
  * @return EmpresaRepository
  */
  public function getEmpresaRepository()
  {
    return $this->empresaRepository;
  }

  /**
  * Set the value of Objeto para la clase EmpresaRepository
  * @param EmpresaRepository empresaRepository
  */
  public function setEmpresaRepository(EmpresaRepository $empresaRepository)
  {
    $this->empresaRepository = $empresaRepository;
  }

  /**
  * Get the value of Objeto para la clase GrupoInvestigacionRepository
  * @return GrupoInvestigacionRepository
  */
  public function getGrupoInvestigacionRepository()
  {
    return $this->grupoInvestigacionRepository;
  }

  /**
  * Set the value of Objeto para la clase GrupoInvestigacionRepository
  * @param GrupoInvestigacionRepository grupoInvestigacionRepository
  */
  public function setGrupoInvestigacionRepository(GrupoInvestigacionRepository $grupoInvestigacionRepository)
  {
    $this->grupoInvestigacionRepository = $grupoInvestigacionRepository;
  }


}
