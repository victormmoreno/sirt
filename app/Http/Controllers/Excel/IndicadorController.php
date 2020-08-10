<?php

namespace App\Http\Controllers\Excel;

use App\Exports\Indicadores\Indicadores2020Export;
use App\Repositories\Repository\{ProyectoRepository, ArticulacionRepository, EmpresaRepository, UserRepository\TalentoRepository, GrupoInvestigacionRepository};
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Excel;

class IndicadorController extends Controller
{

  private $proyectoRepository;
  private $talentoRepository;

  public function __construct(ProyectoRepository $proyectoRepository, TalentoRepository $talentoRepository, ArticulacionRepository $articulacionRepository, EmpresaRepository $empresaRepository, GrupoInvestigacionRepository $grupoInvestigacionRepository)
  {
    $this->setProyectoRepository($proyectoRepository);
    $this->setTalentoRepository($talentoRepository);
    $this->setArticulacionRepository($articulacionRepository);
    $this->setEmpresaRepository($empresaRepository);
    $this->setGrupoInvestigacionRepository($grupoInvestigacionRepository);
  }

  /**
   * Genera excel con el detalle de los proyectos de tecnoparque
   * @param int $idnodo Id del nodo
   * @param string $fecha_inicio Primera fecha para relizar el filtro
   * @param string $fecha_fin Segunda fecha para realizar el filtro
   * @return Response
   * @author dum
   */
  public function exportIndicadores2020($idnodo, string $fecha_inicio, string $fecha_fin)
  {
    $query = '';
    $queryTalentos = '';
    $queryArticulacion = '';
    $queryEmpresasPropietarias = '';
    $queryGruposPropietarios = '';
    $queryTalentosPropietarios = '';

    if (Session::get('login_role') == User::IsAdministrador()) {

      if ($idnodo == 'all') {
        $query = $this->getProyectoRepository()->consultarProyectos_Repository($fecha_inicio, $fecha_fin)->get();
        $queryTalentos = $this->getTalentoRepository()->consultarTalentosAsociadosAProyectos($fecha_inicio, $fecha_fin)->get();
        $queryArticulacion = $this->getArticulacionRepository()->consultarArticulaciones_repository($fecha_inicio, $fecha_fin)->get();
        $queryEmpresasPropietarias = $this->getEmpresaRepository()->empresasPropietarias($fecha_inicio, $fecha_fin)->get();
        $queryGruposPropietarios = $this->getGrupoInvestigacionRepository()->gruposPropietarios($fecha_inicio, $fecha_fin)->get();
        $queryTalentosPropietarios = $this->getTalentoRepository()->talentosPropietarios($fecha_inicio, $fecha_fin)->get();
      } else {
        $query = $this->getProyectoRepository()->consultarProyectos_Repository($fecha_inicio, $fecha_fin)->where('nodos.id', $idnodo)->get();
        $queryTalentos = $this->getTalentoRepository()->consultarTalentosAsociadosAProyectos($fecha_inicio, $fecha_fin)->where('nodos.id', $idnodo)->get();
        $queryArticulacion = $this->getArticulacionRepository()->consultarArticulaciones_repository($fecha_inicio, $fecha_fin)->where('nodos.id', $idnodo)->get();
        $queryEmpresasPropietarias = $this->getEmpresaRepository()->empresasPropietarias($fecha_inicio, $fecha_fin)->where('nodos.id', $idnodo)->get();
        $queryGruposPropietarios = $this->getGrupoInvestigacionRepository()->gruposPropietarios($fecha_inicio, $fecha_fin)->where('nodos.id', $idnodo)->get();
        $queryTalentosPropietarios = $this->getTalentoRepository()->talentosPropietarios($fecha_inicio, $fecha_fin)->where('nodos.id', $idnodo)->get();
      }
    } else if (Session::get('login_role') == User::IsDinamizador()) {
      $query = $this->getProyectoRepository()->consultarProyectos_Repository($fecha_inicio, $fecha_fin)->where('nodos.id', auth()->user()->dinamizador->nodo_id)->get();
      $queryTalentos = $this->getTalentoRepository()->consultarTalentosAsociadosAProyectos($fecha_inicio, $fecha_fin)->where('nodos.id', auth()->user()->dinamizador->nodo_id)->get();
      $queryArticulacion = $this->getArticulacionRepository()->consultarArticulaciones_repository($fecha_inicio, $fecha_fin)->where('nodos.id', auth()->user()->dinamizador->nodo_id)->get();
      $queryEmpresasPropietarias = $this->getEmpresaRepository()->empresasPropietarias($fecha_inicio, $fecha_fin)->where('nodos.id', auth()->user()->dinamizador->nodo_id)->get();
      $queryGruposPropietarios = $this->getGrupoInvestigacionRepository()->gruposPropietarios($fecha_inicio, $fecha_fin)->where('nodos.id', auth()->user()->dinamizador->nodo_id)->get();
      $queryTalentosPropietarios = $this->getTalentoRepository()->talentosPropietarios($fecha_inicio, $fecha_fin)->where('nodos.id', auth()->user()->dinamizador->nodo_id)->get();
    } else {
      $query = $this->getProyectoRepository()->consultarProyectos_Repository($fecha_inicio, $fecha_fin)->where('gestores.id', auth()->user()->gestor->id)->get();
      $queryTalentos = $this->getTalentoRepository()->consultarTalentosAsociadosAProyectos($fecha_inicio, $fecha_fin)->where('gestores.id', auth()->user()->gestor->id)->get();
      $queryArticulacion = $this->getArticulacionRepository()->consultarArticulaciones_repository($fecha_inicio, $fecha_fin)->where('gestores.id', auth()->user()->gestor->id)->get();
      $queryEmpresasPropietarias = $this->getEmpresaRepository()->empresasPropietarias($fecha_inicio, $fecha_fin)->where('gestores.id', auth()->user()->gestor->id)->get();
      $queryGruposPropietarios = $this->getGrupoInvestigacionRepository()->gruposPropietarios($fecha_inicio, $fecha_fin)->where('gestores.id', auth()->user()->gestor->id)->get();
      $queryTalentosPropietarios = $this->getTalentoRepository()->talentosPropietarios($fecha_inicio, $fecha_fin)->where('gestores.id', auth()->user()->gestor->id)->get();
    }

    return Excel::download(new Indicadores2020Export($query, $queryTalentos, $queryArticulacion, $queryEmpresasPropietarias, $queryGruposPropietarios, $queryTalentosPropietarios), 'Indicadores.xls');
  }

  private function setEmpresaRepository($empresaRepository)
  {
    $this->empresaRepository = $empresaRepository;
  }

  private function getEmpresaRepository()
  {
    return $this->empresaRepository;
  }

  private function setArticulacionRepository($articulacionRepository)
  {
    $this->articulacionRepository = $articulacionRepository;
  }

  private function getArticulacionRepository()
  {
    return $this->articulacionRepository;
  }


  private function setProyectoRepository($proyectoRepository)
  {
    $this->proyectoRepository = $proyectoRepository;
  }

  private function getProyectoRepository()
  {
    return $this->proyectoRepository;
  }

  private function setTalentoRepository($talentoRepository)
  {
    $this->talentoRepository = $talentoRepository;
  }

  private function getTalentoRepository()
  {
    return $this->talentoRepository;
  }

  private function setGrupoInvestigacionRepository($grupoInvestigacionRepository)
  {
    $this->grupoInvestigacionRepository = $grupoInvestigacionRepository;
  }

  private function getGrupoInvestigacionRepository()
  {
    return $this->grupoInvestigacionRepository;
  }
}
