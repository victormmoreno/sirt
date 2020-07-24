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

  // public function export(int $idnodo, string $fecha_inicio, string $fecha_fin)
  // {

  //   $datosFinales = array();
  //   array_push($datosFinales,
  //   ['Número de proyectos inscritos.', $this->getIndicadorController()->totalProyectosInscritos($idnodo, $fecha_inicio, $fecha_fin)],
  //   ['Número de proyectos en ejecución.', $this->getIndicadorController()->totalProyectosEjecucion($idnodo)],
  //   ['Número total de PFF finalizados.', $this->getIndicadorController()->totalPFFfinalizados($idnodo, $fecha_inicio, $fecha_fin)],
  //   ['Número proyectos con SENA (aprendiz, instructor) inscritos en el presente mes.', $this->getIndicadorController()->totalInscritosSena($idnodo, $fecha_inicio, $fecha_fin)],
  //   ['Número de proyectos en ejecución con SENA (Aprendiz, Instructor).', $this->getIndicadorController()->totalProyectosEnEjecucionSena($idnodo)],
  //   ['Número PFF con SENA (aprendiz, instructor) finalizados.', $this->getIndicadorController()->totalPFFSena($idnodo, $fecha_inicio, $fecha_fin)],
  //   ['Valor total de costos estimados de los PFF finalizados con SENA (Aprendiz, Instructor).', $this->getIndicadorController()->totalCostoPFFFinalizadoSena($idnodo, $fecha_inicio, $fecha_fin)],
  //   ['Número de proyectos inscritos con empresas.', $this->getIndicadorController()->totalInscritosEmpresas($idnodo, $fecha_inicio, $fecha_fin)],
  //   ['Número de proyectos en ejecución con empresas.', $this->getIndicadorController()->totalProyectosEnEjecucionEmpresas($idnodo)],
  //   ['Número de PFF finalizados empresas.', $this->getIndicadorController()->totalPFFfinalizadosConEmpresas($idnodo, $fecha_inicio, $fecha_fin)],
  //   ['Valor total de costos estimados de los PFF finalizados con empresas.', $this->getIndicadorController()->totalCostoPFFFinalizadoEmpresas($idnodo, $fecha_inicio, $fecha_fin)],
  //   ['Aprendices en asocio al desarrollo de proyectos con empresas.', $this->getIndicadorController()->totalTalentosConProyectosEnAsocioConEmpresas($idnodo, $fecha_inicio, $fecha_fin)],
  //   ['Número de proyectos inscritos con emprendedores y otros.', $this->getIndicadorController()->totalProyectosInscritosEmprendedoresInvetoresOtro($idnodo, $fecha_inicio, $fecha_fin)],
  //   ['Número de proyectos en ejecución con emprendores y otros.', $this->getIndicadorController()->totalProyectosEnEjecucionEmprendedoresInventoresOtros($idnodo)],
  //   ['Número de PFF finalizados con emprendedores y otros.', $this->getIndicadorController()->totalPFFFinalizadosEmprendedoresInvetoresOtro($idnodo, $fecha_inicio, $fecha_fin)],
  //   ['Valor total de costos estimados de los PFF finalizados con emprendedores y otros.', $this->getIndicadorController()->totalCostoPFFFinalizadoEmprendedoresOtros($idnodo, $fecha_inicio, $fecha_fin)],
  //   ['Número total de PMV finalizados.', $this->getIndicadorController()->totalPMVfinalizados($idnodo, $fecha_inicio, $fecha_fin)],
  //   ['Número PMV con SENA (aprendiz, instructor) finalizados.', $this->getIndicadorController()->totalPMVSena($idnodo, $fecha_inicio, $fecha_fin)],
  //   ['Valor total de costos estimados de los PMV finalizados con SENA (Aprendiz, Instructor).', $this->getIndicadorController()->totalCostoPMVFinalizadoSena($idnodo, $fecha_inicio, $fecha_fin)],
  //   ['Número de PMV finalizados empresas.', $this->getIndicadorController()->totalPMVfinalizadosConEmpresas($idnodo, $fecha_inicio, $fecha_fin)],
  //   ['Valor total de costos estimados de los PMV finalizados con empresas.', $this->getIndicadorController()->totalCostoPMVFinalizadoEmpresas($idnodo, $fecha_inicio, $fecha_fin)],
  //   ['Número de PMV finalizados con emprendedores y otros.', $this->getIndicadorController()->totalPMVFinalizadosEmprendedoresInvetoresOtro($idnodo, $fecha_inicio, $fecha_fin)],
  //   ['Valor total de costos estimados de los PMV finalizados con emprendedores y otros.', $this->getIndicadorController()->totalCostoPMVFinalizadoEmprendedoresOtros($idnodo, $fecha_inicio, $fecha_fin)],
  //   ['Número de proyectos articulados con Grupos de Investigación Internos.', $this->getIndicadorController()->totalProyectoConGruposInternos($idnodo, $fecha_inicio, $fecha_fin)],
  //   ['Número de proyectos articulados con Grupos de Investigación Internos finalizados.', $this->getIndicadorController()->totalProyectoConGruposInternosFinalizados($idnodo, $fecha_inicio, $fecha_fin)],
  //   ['Número de proyectos articulados con Grupos de Investigación Externos.', $this->getIndicadorController()->totalProyectoConGruposExternos($idnodo, $fecha_inicio, $fecha_fin)],
  //   ['Número de proyectos articulados con Grupos de Investigación Externos finalizados.', $this->getIndicadorController()->totalProyectoConGruposExternosFinalizados($idnodo, $fecha_inicio, $fecha_fin)],
  //   ['Número de Aprendices articulados con proyectos del Nodo y CON Apoyo de Sostenimiento activos.', $this->getIndicadorController()->totalTalentosConApoyoYProyectosAsociados($idnodo, $fecha_inicio, $fecha_fin)],
  //   ['Número de Aprendices articulados con proyectos del Nodo y SIN Apoyo de Sostenimiento activos.', $this->getIndicadorController()->totalTalentosSinApoyoYProyectosAsociados($idnodo, $fecha_inicio, $fecha_fin)],
  //   ['Asesoría I+D+i inscritas con empresas y emprendedores.', $this->getIndicadorController()->totalAsesoriasIDiEmpresasYEmprendedores($idnodo, $fecha_inicio, $fecha_fin)],
  //   ['Asesoría I+D+i en ejecución con empresas y emprendedores.', $this->getIndicadorController()->totalAsesoriasIDiEmpresasEmprendedoresEnEjecucion($idnodo)],
  //   ['Asesoría I+D+i finalizadas con empresas y emprendedores.', $this->getIndicadorController()->totalAsesoriasIDiEmpresasEmprendedoresFinalizadas($idnodo, $fecha_inicio, $fecha_fin)],
  //   ['Vigilancías Tecnológicas finalizadas con empresas y emprendedores.', $this->getIndicadorController()->totalArticulacionesEmpresasEmprendedoresPorTipoFinalizadas($idnodo, $fecha_inicio, $fecha_fin, 'Vigilancia Tecnológica.')],
  //   ['Análisis de Prospectiva finalizadas con empresas y emprendedores.', $this->getIndicadorController()->totalArticulacionesEmpresasEmprendedoresPorTipoFinalizadas($idnodo, $fecha_inicio, $fecha_fin, 'Análisis de Prospectiva.')],
  //   ['Reestructuración y diseño de planta finalizadas con empresas y emprendedores.', $this->getIndicadorController()->totalArticulacionesEmpresasEmprendedoresPorTipoFinalizadas($idnodo, $fecha_inicio, $fecha_fin, 'Reestructuración y diseño de planta.')],
  //   ['Estrategias de creación y posicionamiento de marca finalizadas con empresas y emprendedores.', $this->getIndicadorController()->totalArticulacionesEmpresasEmprendedoresPorTipoFinalizadas($idnodo, $fecha_inicio, $fecha_fin, 'Estrategias de creación y posicionamiento de marca.')],
  //   ['Acompañamiento y gestión en el desarrollo de productos de propiedad intelectual finalizadas con empresas y emprendedores.', $this->getIndicadorController()->totalArticulacionesEmpresasEmprendedoresPorTipoFinalizadas($idnodo, $fecha_inicio, $fecha_fin, 'Acompañamiento y gestión en el desarrollo de productos de propiedad intelectual')],
  //   ['Formular proyectos I+D+i para convocatorias finalizadas con empresas y emprendedores.', $this->getIndicadorController()->totalArticulacionesEmpresasEmprendedoresPorTipoFinalizadas($idnodo, $fecha_inicio, $fecha_fin, 'Formular proyectos I+D+i para convocatorias.')],
  //   ['Asesoría a empresa o emprendedor finalizadas con empresas y emprendedores.', $this->getIndicadorController()->totalArticulacionesEmpresasEmprendedoresPorTipoFinalizadas($idnodo, $fecha_inicio, $fecha_fin, 'Asesoría a empresa o emprendedor.')],
  //   ['Número de Eventos de Divulgación	Tecnológica (EDTs).', $this->getIndicadorController()->totalEdts($idnodo, $fecha_inicio, $fecha_fin)],
  //   ['Número de total de personas atendidas en EDT\'s.', $this->getIndicadorController()->totalAtendidosEnEdts($idnodo, $fecha_inicio, $fecha_fin, 'empleados+instructores+aprendices+publico')],
  //   ['Número de total de personas SENA atendidas en EDT\'s.', $this->getIndicadorController()->totalAtendidosEnEdts($idnodo, $fecha_inicio, $fecha_fin, 'instructores+aprendices')],
  //   ['Número de total de empresarios/empleados atendidas en EDT\'s.', $this->getIndicadorController()->totalAtendidosEnEdts($idnodo, $fecha_inicio, $fecha_fin, 'empleados')],
  //   ['Número de total de público general atendido en EDT\'s.', $this->getIndicadorController()->totalAtendidosEnEdts($idnodo, $fecha_inicio, $fecha_fin, 'publico')],
  //   ['Número de total de talentos.', $this->getIndicadorController()->totalTalentosEnProyecto($idnodo, $fecha_inicio, $fecha_fin)],
  //   ['Número de total talentos SENA (aprendices).', $this->getIndicadorController()->totalTalentosSenaEnProyecto($idnodo, $fecha_inicio, $fecha_fin)],
  //   ['Número de total talentos mujeres SENA (aprendices).', $this->getIndicadorController()->totalTalentosMujeresSenaEnProyecto($idnodo, $fecha_inicio, $fecha_fin)],
  //   ['Número de total talentos egresados SENA.', $this->getIndicadorController()->totalTalentosEgresadosSenaEnProyecto($idnodo, $fecha_inicio, $fecha_fin)]);

  //   return Excel::download(new IndicadoresExport($datosFinales), 'Indicadores.xls');
  // }

  

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
