<?php

namespace App\Http\Controllers\Excel;

use App\Exports\Articulaciones\{ArticulacionesExport, ArticulacionesNodoExport, ArticulacionesUnicaExport, ArticulacionesFinalizadasExport};
use App\Repositories\Repository\{ArticulacionRepository, EmpresaRepository, GrupoInvestigacionRepository, ArticulacionProyectoRepository};
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use Excel;

class ArticulacionController extends Controller
{

  private $articulacionProyectoRepository;
  private $grupoInvestigacionRepository;
  private $articulacionRepository;
  private $empresaRepository;

  public function __construct(ArticulacionRepository $articulacionRepository, EmpresaRepository $empresaRepository, GrupoInvestigacionRepository $grupoInvestigacionRepository, ArticulacionProyectoRepository $articulacionProyectoRepository)
  {
    $this->setArticulacionProyectoRepository($articulacionProyectoRepository);
    $this->setGrupoInvestigacionRepository($grupoInvestigacionRepository);
    $this->setArticulacionRepository($articulacionRepository);
    $this->setEmpresaRepository($empresaRepository);
  }

  /**
   * Excel que genra las articulaciones de un nodo finalizadas en un año
   *
   * @param int $id Id del nodo
   * @param string $anho Año para realizar la búsqueda de las articulaciones
   * @return Response\Excel
   * @author dum
   */
  public function excelArticulacionFinalizadasPorNodoAnho_Controller($id, $anho)
  {
    $idnodo = $id;
    if ( Session::get('login_role') == User::IsDinamizador() ) {
      $idnodo = auth()->user()->dinamizador->nodo_id;
    }
    $query = $this->getArticulacionRepository()->consultarArticulacionesFinalizadasPorNodoYAnho_Repository($idnodo, $anho);
    // dd();
    return Excel::download(new ArticulacionesFinalizadasExport($query), 'Articulaciones.xls');
  }

  /**
   * Excel para generar las articulaciones de una línea tecnológica por nodo y fecha
   * @param int $id Id del nodo
   * @param int $idlinea Id de la línea tecnológica
   * @param string $fecha_inicio Primera fecha para realizar el filtro
   * @param string $fecha_cierre Segunda fecha para realizar el filtro
   * @return Response\Excel
   * @author dum
   */
  public function excelArticulacionFinalizadasPorNodoFechaLinea_Controller($id, $idlinea, $fecha_inicio, $fecha_cierre)
  {
    $idnodo = $id;
    if ( Session::get('login_role') == User::IsDinamizador() ) {
      $idnodo = auth()->user()->dinamizador->nodo_id;
    }
    $query = $this->getArticulacionRepository()->consultarArticulacionesFinalizadasPorFechaNodoYLinea_Repository($idnodo, $idlinea, $fecha_inicio, $fecha_cierre);
    return Excel::download(new ArticulacionesFinalizadasExport($query), 'Articulaciones.xls');
  }

  /**
   * Consulta la articulaciones finalizadas por gestor y fechas
   *
   * @param int $id Id del gestor
   * @param string $fecha_inicio Primera fecha para realizar filtro
   * @param string $fecha_cierre Segunda fecha para realizar filtro
   * @return Response\Excel
   * @author dum
   */
  public function excelArticulacionFinalizadasPorGestorFecha_Controller($id, $fecha_inicio, $fecha_cierre)
  {
    $query = $this->getArticulacionRepository()->consultarArticulacionesFinalizadasPorGestorFecha_Repository($id, $fecha_inicio, $fecha_cierre);
    return Excel::download(new ArticulacionesFinalizadasExport($query), 'Articulaciones.xls');
  }

  /**
   * Excel que genera las articulaciones finalizadas entre dos fechas
   *
   * @param int $id Id del nodo
   * @param string $fecha_inicio Primera fecha para filtrar la consulta
   * @param string $fecha_cierre Segunda fecha para filtrar la consulta
   * @return Response\Excel
   * @author dum
   */
  public function excelArticulacionFinalizadasPorFechaYNodo_Controller($id, $fecha_inicio, $fecha_cierre)
  {
    $idnodo = $id;
  
    if ( Session::get('login_role') == User::IsDinamizador() ) {
      $idnodo = auth()->user()->dinamizador->nodo_id;
    }
    $query = $this->getArticulacionRepository()->consultarArticulacionesFinalizadasPorFechaYNodo_Repository($idnodo, $fecha_inicio, $fecha_cierre);
    return Excel::download(new ArticulacionesFinalizadasExport($query), 'Articulaciones.xls');
  }

  /**
   * Genera el excel de las articulaciones que tiene un gestor
   * @param int $id Id del gestor
   * @return Response\Excel
   * @author dum
   */
  public function articulacionesDeUnGestor($id)
  {
    return Excel::download(new ArticulacionesExport($this->getArticulacionRepository(), $id), 'Articulaciones.xls');
  }

  /**
   * General el excel de las articulaciones de un nodo
   * @param int $id Id del nodo
   * @return Response\Excel
   * @author dum
   */
  public function articulacionesDeUnNodo($id)
  {
    return Excel::download(new ArticulacionesNodoExport($this->getArticulacionRepository(), $id), 'Articulaciones.xls');
  }

  /**
   * Genera excel con la información de una articulación por su id
   * @param int $id Id de la articulación
   * @return Response\Excel
   * @author dum
   */
  public function articulacionPorId($id)
  {
    $articulacion = $this->getArticulacionRepository()->consultarArticulacionPorId($id)->last();
    return Excel::download(new ArticulacionesUnicaExport($this->getArticulacionRepository(), $id, $articulacion, $this->getArticulacionProyectoRepository(), $this->getGrupoInvestigacionRepository(), $this->getEmpresaRepository()), 'Articulacion ' . $articulacion->codigo_articulacion . '.xls');
  }

  // /**
  //  * Genera el excel de todas las articulaciones de tecnoparque
  //  * @return Response
  //  * @author dum
  //  */
  // public function articulacionesDeTecnoparque()
  // {
  //   return Excel::download(new ArticulacionesTecnoparqueExport($this->articulacionRepository, $id, $articulaciones), 'Articulaciones de Tecnoparque.xls');
  // }

  /**
   * Retorna el valor de $empresaRepository
   *
   * @return object
   * @author dum
   */
  private function getEmpresaRepository()
  {
    return $this->empresaRepository;
  }

  /**
   * Asgina un valor a $empresaRepository
   *
   * @param object $empresaRepository
   * @return void
   * @author dum
   */
  private function setEmpresaRepository($empresaRepository)
  {
    $this->empresaRepository = $empresaRepository;
  }

  /**
   * Retorna el valor de $grupoInvestigacionRepository
   * @return object
   * @author dum
   */
  private function getGrupoInvestigacionRepository()
  {
    return $this->grupoInvestigacionRepository;
  }

  /**
   * Asgina un valor a $grupoInvestigacionRepository
   * @param object $grupoInvestigacionRepository
   * @return void
   * @author dum
   */
  private function setGrupoInvestigacionRepository($grupoInvestigacionRepository)
  {
    $this->grupoInvestigacionRepository = $grupoInvestigacionRepository;
  }

  /**
   * Retorna el valor de $articulacionProyectoRepository
   *
   * @return object
   * @author dum
   */
  private function getArticulacionProyectoRepository()
  {
    return $this->articulacionProyectoRepository;
  }

  /**
   * Asgina un valor a $articulacionProyectoRepository
   *
   * @param object $articulacionProyectoRepository
   * @return void
   * @author dum
   */
  private function setArticulacionProyectoRepository($articulacionProyectoRepository)
  {
    $this->articulacionProyectoRepository = $articulacionProyectoRepository;
  }

  /**
   * Asgina un valor a $articulacionRepository
   * @param object $articulacionRepository
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
