<?php

namespace App\Http\Controllers\Excel;

use App\Exports\Indicadores\{IndicadoresExport};
use App\Http\Controllers\IndicadorController AS Ctrl;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use Excel;

class IndicadorController extends Controller
{

  private $indicadorController;

  public function __construct(Ctrl $indicadorController)
  {
    $this->setIndicadorController($indicadorController);
  }

  public function export(int $idnodo, string $fecha_inicio, string $fecha_fin)
  {

    $datosFinales = array();
    array_push($datosFinales,
    ['Número de proyectos inscritos.', $this->getIndicadorController()->totalProyectosInscritos($idnodo, $fecha_inicio, $fecha_fin)],
    ['Número de proyectos en ejecución.', 0],
    ['Número total de PFF finalizados.', $this->getIndicadorController()->totalPFFfinalizados($idnodo, $fecha_inicio, $fecha_fin)],
    ['Número proyectos con SENA (aprendiz, instructor) inscritos en el presente mes.', $this->getIndicadorController()->totalInscritosSena($idnodo, $fecha_inicio, $fecha_fin)],
    ['Número de proyectos en ejecución con SENA (Aprendiz, Instructor).', 0],
    ['Número PFF con SENA (aprendiz, instructor) finalizados.', $this->getIndicadorController()->totalPFFSena($idnodo, $fecha_inicio, $fecha_fin)],
    ['Valor total de costos estimados de los PFF finalizados con SENA (Aprendiz, Instructor).', $this->getIndicadorController()->totalCostoPFFFinalizadoSena($idnodo, $fecha_inicio, $fecha_fin)],
    ['Número de proyectos inscritos con empresas.', $this->getIndicadorController()->totalInscritosEmpresas($idnodo, $fecha_inicio, $fecha_fin)],
    ['Número de proyectos en ejecución con empresas.', 0],
    ['Número de PFF finalizados empresas.', $this->getIndicadorController()->totalPFFfinalizadosConEmpresas($idnodo, $fecha_inicio, $fecha_fin)],
    ['Valor total de costos estimados de los PFF finalizados con empresas.', $this->getIndicadorController()->totalCostoPFFFinalizadoEmpresas($idnodo, $fecha_inicio, $fecha_fin)],
    ['Aprendices en asocio al desarrollo de proyectos con empresas.', $this->getIndicadorController()->totalTalentosConProyectosEnAsocioConEmpresas($idnodo, $fecha_inicio, $fecha_fin)],
    ['Número de proyectos inscritos con emprendedores y otros.', $this->getIndicadorController()->totalProyectosInscritosEmprendedoresInvetoresOtro($idnodo, $fecha_inicio, $fecha_fin)],
    ['Número de proyectos en ejecución con emprendores y otros.', 0],
    ['Número de PFF finalizados con emprendedores y otros.', $this->getIndicadorController()->totalPFFFinalizadosEmprendedoresInvetoresOtro($idnodo, $fecha_inicio, $fecha_fin)],
    ['Valor total de costos estimados de los PFF finalizados con emprendedores y otros.', $this->getIndicadorController()->totalCostoPFFFinalizadoEmprendedoresOtros($idnodo, $fecha_inicio, $fecha_fin)],
    ['Número total de PMV finalizados.', $this->getIndicadorController()->totalPMVfinalizados($idnodo, $fecha_inicio, $fecha_fin)],
    ['Número PMV con SENA (aprendiz, instructor) finalizados.', $this->getIndicadorController()->totalPMVSena($idnodo, $fecha_inicio, $fecha_fin)],
    ['Valor total de costos estimados de los PMV finalizados con SENA (Aprendiz, Instructor).', $this->getIndicadorController()->totalCostoPMVFinalizadoSena($idnodo, $fecha_inicio, $fecha_fin)],
    ['Número de PMV finalizados empresas.', $this->getIndicadorController()->totalPMVfinalizadosConEmpresas($idnodo, $fecha_inicio, $fecha_fin)],
    ['Valor total de costos estimados de los PMV finalizados con empresas.', $this->getIndicadorController()->totalCostoPMVFinalizadoEmpresas($idnodo, $fecha_inicio, $fecha_fin)],
    ['Número de PMV finalizados con emprendedores y otros.', $this->getIndicadorController()->totalPMVFinalizadosEmprendedoresInvetoresOtro($idnodo, $fecha_inicio, $fecha_fin)],
    ['Valor total de costos estimados de los PMV finalizados con emprendedores y otros.', $this->getIndicadorController()->totalCostoPMVFinalizadoEmprendedoresOtros($idnodo, $fecha_inicio, $fecha_fin)],
    ['Número de proyectos articulados con Grupos de Investigación Internos.', $this->getIndicadorController()->totalProyectoConGruposInternos($idnodo, $fecha_inicio, $fecha_fin)],
    ['Número de proyectos articulados con Grupos de Investigación Internos finalizados.', $this->getIndicadorController()->totalProyectoConGruposInternosFinalizados($idnodo, $fecha_inicio, $fecha_fin)],
    ['Número de proyectos articulados con Grupos de Investigación Externos.', $this->getIndicadorController()->totalProyectoConGruposExternos($idnodo, $fecha_inicio, $fecha_fin)],
    ['Número de proyectos articulados con Grupos de Investigación Externos finalizados.', $this->getIndicadorController()->totalProyectoConGruposExternosFinalizados($idnodo, $fecha_inicio, $fecha_fin)],
    ['Número de Aprendices articulados con proyectos del Nodo y CON Apoyo de Sostenimiento activos.', $this->getIndicadorController()->totalTalentosConApoyoYProyectosAsociados($idnodo, $fecha_inicio, $fecha_fin)],
    ['Número de Aprendices articulados con proyectos del Nodo y SIN Apoyo de Sostenimiento activos.', $this->getIndicadorController()->totalTalentosSinApoyoYProyectosAsociados($idnodo, $fecha_inicio, $fecha_fin)],
    ['Asesoría I+D+i inscritas con empresas y emprendedores.', $this->getIndicadorController()->totalAsesoriasIDiEmpresasYEmprendedores($idnodo, $fecha_inicio, $fecha_fin)],
    ['Asesoría I+D+i en ejecución con empresas y emprendedores.', 0],
    ['Asesoría I+D+i finalizadas con empresas y emprendedores.', $this->getIndicadorController()->totalAsesoriasIDiEmpresasEmprendedoresFinalizadas($idnodo, $fecha_inicio, $fecha_fin)],
    ['Vigilancías Tecnológicas finalizadas con empresas y emprendedores.', $this->getIndicadorController()->totalArticulacionesEmpresasEmprendedoresPorTipoFinalizadas($idnodo, $fecha_inicio, $fecha_fin, 'Vigilancia Tecnológica.')],
    ['Análisis de Prospectiva finalizadas con empresas y emprendedores.', $this->getIndicadorController()->totalArticulacionesEmpresasEmprendedoresPorTipoFinalizadas($idnodo, $fecha_inicio, $fecha_fin, 'Análisis de Prospectiva.')],
    ['Reestructuración y diseño de planta finalizadas con empresas y emprendedores.', $this->getIndicadorController()->totalArticulacionesEmpresasEmprendedoresPorTipoFinalizadas($idnodo, $fecha_inicio, $fecha_fin, 'Reestructuración y diseño de planta.')],
    ['Estrategias de creación y posicionamiento de marca finalizadas con empresas y emprendedores.', $this->getIndicadorController()->totalArticulacionesEmpresasEmprendedoresPorTipoFinalizadas($idnodo, $fecha_inicio, $fecha_fin, 'Estrategias de creación y posicionamiento de marca.')],
    ['Acompañamiento y gestión en el desarrollo de productos de propiedad intelectual finalizadas con empresas y emprendedores.', $this->getIndicadorController()->totalArticulacionesEmpresasEmprendedoresPorTipoFinalizadas($idnodo, $fecha_inicio, $fecha_fin, 'Acompañamiento y gestión en el desarrollo de productos de propiedad intelectual')],
    ['Formular proyectos I+D+i para convocatorias finalizadas con empresas y emprendedores.', $this->getIndicadorController()->totalArticulacionesEmpresasEmprendedoresPorTipoFinalizadas($idnodo, $fecha_inicio, $fecha_fin, 'Formular proyectos I+D+i para convocatorias.')],
    ['Asesoría a empresa o emprendedor finalizadas con empresas y emprendedores.', $this->getIndicadorController()->totalArticulacionesEmpresasEmprendedoresPorTipoFinalizadas($idnodo, $fecha_inicio, $fecha_fin, 'Asesoría a empresa o emprendedor.')],
    ['Número de Eventos de Divulgación	Tecnológica (EDTs).', $this->getIndicadorController()->totalEdts($idnodo, $fecha_inicio, $fecha_fin)],
    ['Número de total de personas atendidas en EDT\'s.', $this->getIndicadorController()->totalAtendidosEnEdts($idnodo, $fecha_inicio, $fecha_fin, 'empleados+instructores+aprendices+publico')],
    ['Número de total de personas SENA atendidas en EDT\'s.', $this->getIndicadorController()->totalAtendidosEnEdts($idnodo, $fecha_inicio, $fecha_fin, 'instructores+aprendices')],
    ['Número de total de empresarios/empleados atendidas en EDT\'s.', $this->getIndicadorController()->totalAtendidosEnEdts($idnodo, $fecha_inicio, $fecha_fin, 'empleados')],
    ['Número de total de público general atendido en EDT\'s.', $this->getIndicadorController()->totalAtendidosEnEdts($idnodo, $fecha_inicio, $fecha_fin, 'publico')],
    ['Número de total de talentos.', $this->getIndicadorController()->totalTalentosEnProyecto($idnodo, $fecha_inicio, $fecha_fin)],
    ['Número de total talentos SENA (aprendices).', $this->getIndicadorController()->totalTalentosSenaEnProyecto($idnodo, $fecha_inicio, $fecha_fin)],
    ['Número de total talentos mujeres SENA (aprendices).', $this->getIndicadorController()->totalTalentosMujeresSenaEnProyecto($idnodo, $fecha_inicio, $fecha_fin)],
    ['Número de total talentos egresados SENA.', $this->getIndicadorController()->totalTalentosEgresadosSenaEnProyecto($idnodo, $fecha_inicio, $fecha_fin)]);

    return Excel::download(new IndicadoresExport($datosFinales), 'Indicadores.xls');
  }

  private function setIndicadorController($indicadorController) {
    $this->indicadorController = $indicadorController;
  }

  private function getIndicadorController() {
    return $this->indicadorController;
  }


}
