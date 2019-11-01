<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Session, DB};
use App\Repositories\Repository\{ProyectoRepository, ActividadRepository, ArticulacionRepository, EdtRepository, UserRepository\TalentoRepository};
use App\User;

class IndicadorController extends Controller
{
  /**
   * ProyectoRepository
   *
   * @var ProyectoRepository
   */
  private $proyectoRepository;

  /**
   * CostoController
   *
   * @var CostoController
   */
  private $costoController;

  /**
   * ActividadRepository
   *
   * @var ActividadRepository
   */
  private $actividadRepository;

  /**
   * ArticulacionRepository
   *
   * @var ArticulacionRepository
   */
  private $articulacionRepository;

  /**
   * EdtRepository
   *
   * @var EdtRepository
   */
  private $edtRepository;

  /**
   * UserRepository
   *
   * @var TalentoRepository
   */
  private $talentoRepository;

  public function __construct(ProyectoRepository $proyectoRepository, CostoController $costoController, ActividadRepository $actividadRepository, ArticulacionRepository $articulacionRepository, EdtRepository $edtRepository, TalentoRepository $talentoRepository) {
    $this->setProyectoRepository($proyectoRepository);
    $this->setCostoController($costoController);
    $this->setActividadRepository($actividadRepository);
    $this->setArticulacionRepository($articulacionRepository);
    $this->setEdtRepository($edtRepository);
    $this->setTalentoRepository($talentoRepository);
  }
  /**
   * Index para los indicadores
   *
   * @return Response
   */
  public function index()
  {

    if ( Session::get('login_role') == User::IsDinamizador() ) {
      return view('indicadores.dinamizador.index');
    } else {
      abort('403');
    }

  }

  /**
   * Retorna el total de talentos en proyecto
   *
   * @param int $id Id del nodo
   * @param string $fecha_inicio Primera fecha para realizar el filtro
   * @param string $fecha_fin Segunda fecha para realizar el filtro
   * @return Resposne
   * @author dum
   */
  public function totalTalentosEnProyecto(int $idnodo, string $fecha_inicio, string $fecha_fin)
  {
    $idnodo = $this->setIdNodo($idnodo);
    $total = $this->getTalentoRepository()->totalTalentosEnProyectos()
    ->where('nodos.id', $idnodo)
    ->where(function($q) use ($fecha_inicio, $fecha_fin) {
      $q->where(function($query) use ($fecha_inicio, $fecha_fin) {
        $query->whereBetween('fecha_inicio', [$fecha_inicio, $fecha_fin]);
      })
      ->orWhere(function($query) use ($fecha_inicio, $fecha_fin) {
        $query->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_fin]);
      });
    })
    ->dd()
    ->count();
    return response()->json($total);
  }

  /**
   * Retorna el total de personas atendidas en edts
   *
   * @param int $id Id del nodo
   * @param string $fecha_inicio Primera fecha para realizar el filtro
   * @param string $fecha_fin Segunda fecha para realizar el filtro
   * @param string $campos_suma CAmpos que se van a sumar
   * @return Resposne
   * @author dum
   */
  public function totalAtendidosEnEdts(int $idnodo, string $fecha_inicio, string $fecha_fin, string $campos_suma)
  {
    $idnodo = $this->setIdNodo($idnodo);
    $total = $this->getEdtRepository()->consultaEdtsPorFechas_Respository($fecha_inicio, $fecha_fin)->select(DB::raw('sum('.$campos_suma.') AS total'))->where('nodos.id', $idnodo)->first()->total;
    // $total = $this->getEdtRepository()->consultaEdtsPorFechas_Respository($fecha_inicio, $fecha_fin)->select(DB::raw('sum(empleados+instructores+aprendices+publico) AS total'))->where('nodos.id', $idnodo)->first()->total;
    return response()->json($total == null ? 0 : $total);
  }

  /**
   * Retorna el total de edts
   *
   * @param int $id Id del nodo
   * @param string $fecha_inicio Primera fecha para realizar el filtro
   * @param string $fecha_fin Segunda fecha para realizar el filtro
   * @return Resposne
   * @author dum
   */
  public function totalEdts(int $idnodo, string $fecha_inicio, string $fecha_fin)
  {
    $idnodo = $this->setIdNodo($idnodo);
    $total = $this->getEdtRepository()->consultaEdtsPorFechas_Respository($fecha_inicio, $fecha_fin)->where('nodos.id', $idnodo)->first()->cantidad;
    return response()->json($total);
  }

  /**
   * Retorna el total de asesorias I+D+i con empresas y emprendedores finalizadas según el tipo de articulación
   *
   * @param int $id Id del nodo
   * @param string $fecha_inicio Primera fecha para realizar el filtro
   * @param string $fecha_fin Segunda fecha para realizar el filtro
   * @param string $nombre_tipo_articulacion Nombre del tipo de articulación por el cuál se va a filtrar
   * @return Resposne
   * @author dum
   */
  public function totalArticulacionesEmpresasEmprendedoresPorTipoFinalizadas(int $idnodo, string $fecha_inicio, string $fecha_fin, string $nombre_tipo_articulacion)
  {
    $idnodo = $this->setIdNodo($idnodo);
    $total = $this->getArticulacionRepository()->consultarTotalDeArticulacionesEmpresasEmprendedores()
    ->where('nodos.id', $idnodo)
    ->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_fin])
    ->where('tiposarticulaciones.nombre', $nombre_tipo_articulacion)
    ->first()
    ->cantidad;
    return response()->json($total);
  }

  /**
   * Retorna el total de asesorias I+D+i con empresas y emprendedores finalizadas
   *
   * @param int $id Id del nodo
   * @param string $fecha_inicio Primera fecha para realizar el filtro
   * @param string $fecha_fin Segunda fecha para realizar el filtro
   * @return Resposne
   * @author dum
   */
  public function totalAsesoriasIDiEmpresasEmprendedoresFinalizadas(int $idnodo, string $fecha_inicio, string $fecha_fin)
  {
    $idnodo = $this->setIdNodo($idnodo);
    $total = $this->getArticulacionRepository()->consultarTotalDeArticulacionesEmpresasEmprendedores()
    ->where('nodos.id', $idnodo)
    ->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_fin])
    ->first()
    ->cantidad;
    return response()->json($total);
  }

  /**
   * Retorna el total de asesorias I+D+i con empresas y emprendedores en ejecución (que hayan cerrado o iniciado entre las fechas)
   *
   * @param int $id Id del nodo
   * @param string $fecha_inicio Primera fecha para realizar el filtro
   * @param string $fecha_fin Segunda fecha para realizar el filtro
   * @return Resposne
   * @author dum
   */
  public function totalAsesoriasIDiEmpresasEmprendedoresEnEjecucion(int $idnodo, string $fecha_inicio, string $fecha_fin)
  {
    $idnodo = $this->setIdNodo($idnodo);
    $total = $this->getArticulacionRepository()->consultarTotalDeArticulacionesEmpresasEmprendedores()
    ->where('nodos.id', $idnodo)
    ->where(function($q) use ($fecha_inicio, $fecha_fin) {
      $q->where(function($query) use ($fecha_inicio, $fecha_fin) {
        $query->whereBetween('fecha_inicio', [$fecha_inicio, $fecha_fin]);
      })
      ->orWhere(function($query) use ($fecha_inicio, $fecha_fin) {
        $query->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_fin]);
      });
    })
    ->first()
    ->cantidad;
    return response()->json($total);
  }

  /**
   * Retorna el total de asesorias I+D+i con empresas y emprendedores inscritas
   *
   * @param int $id Id del nodo
   * @param string $fecha_inicio Primera fecha para realizar el filtro
   * @param string $fecha_fin Segunda fecha para realizar el filtro
   * @return Resposne
   * @author dum
   */
  public function totalAsesoriasIDiEmpresasYEmprendedores(int $idnodo, string $fecha_inicio, string $fecha_fin)
  {
    $idnodo = $this->setIdNodo($idnodo);
    $total = $this->getArticulacionRepository()->consultarTotalDeArticulacionesEmpresasEmprendedores()->where('nodos.id', $idnodo)->whereBetween('fecha_inicio', [$fecha_inicio, $fecha_fin])->first()->cantidad;
    return response()->json($total);
  }


  /**
  * Retorna la cantidad total de talentos con proyectos del nodo y sin apoyo de sostenimiento
  *
  * @param int $idnodo Id del nodo
  * @param string $fecha_inicio Primera fecha para realizar el filtro
  * @param string $fecha_fin Segunda fecha para realizar el filtro
  * @return Response
  */
  public function totalTalentosSinApoyoYProyectosAsociados(int $idnodo, string $fecha_inicio, string $fecha_fin)
  {
    $idnodo = $this->setIdNodo($idnodo);
    $total = $this->getProyectoRepository()->consultarTotalProyectos()->select(DB::raw('talentos.id'))
    ->join('articulacion_proyecto_talento', 'articulacion_proyecto_talento.articulacion_proyecto_id', '=', 'articulacion_proyecto.id')
    ->join('talentos', 'talentos.id', '=', 'articulacion_proyecto_talento.talento_id')
    ->join('perfiles', 'perfiles.id', '=', 'talentos.perfil_id')
    ->where('nodos.id', $idnodo)
    ->where('perfiles.nombre', 'Aprendiz SENA sin apoyo de sostenimiento')
    ->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_fin])
    ->groupBy('talentos.id')
    ->get()
    ->count();
    return response()->json($total);
  }


  /**
  * Retorna la cantidad total de talentos con proyectos del nodo y con apoyo de sostenimiento
  *
  * @param int $idnodo Id del nodo
  * @param string $fecha_inicio Primera fecha para realizar el filtro
  * @param string $fecha_fin Segunda fecha para realizar el filtro
  * @return Response
  */
  public function totalTalentosConApoyoYProyectosAsociados(int $idnodo, string $fecha_inicio, string $fecha_fin)
  {
    $idnodo = $this->setIdNodo($idnodo);
    $total = $this->getProyectoRepository()->consultarTotalProyectos()->select(DB::raw('talentos.id'))
    ->join('articulacion_proyecto_talento', 'articulacion_proyecto_talento.articulacion_proyecto_id', '=', 'articulacion_proyecto.id')
    ->join('talentos', 'talentos.id', '=', 'articulacion_proyecto_talento.talento_id')
    ->join('perfiles', 'perfiles.id', '=', 'talentos.perfil_id')
    ->where('nodos.id', $idnodo)
    ->where('perfiles.nombre', 'Aprendiz SENA con apoyo de sostenimiento')
    ->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_fin])
    ->groupBy('talentos.id')
    ->get()
    ->count();
    return response()->json($total);
  }

  /**
  * Retorna la cantidad de proyectos inscritos con grupos de investigación externos finalizados
  *
  * @param int $idnodo Id del nodo
  * @param string $fecha_inicio Primera fecha para realizar el filtro
  * @param string $fecha_fin Segunda fecha para realizar el filtro
  * @return Response
  * @author dum
  */
  public function totalProyectoConGruposExternosFinalizados(int $idnodo, string $fecha_inicio, string $fecha_fin)
  {
    $idnodo = $this->setIdNodo($idnodo);
    $total = $this->getProyectoRepository()->consultarTotalProyectos()
    ->where('nodos.id', $idnodo)
    ->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_fin])
    ->where('tiposarticulacionesproyectos.nombre', 'Grupos y Semilleros Externos')
    ->first()
    ->cantidad;
    return response()->json($total);
  }

  /**
  * Retorna la cantidad de proyectos inscritos con grupos de investigación externos
  *
  * @param int $idnodo Id del nodo
  * @param string $fecha_inicio Primera fecha para realizar el filtro
  * @param string $fecha_fin Segunda fecha para realizar el filtro
  * @return Response
  * @author dum
  */
  public function totalProyectoConGruposExternos(int $idnodo, string $fecha_inicio, string $fecha_fin)
  {
    $idnodo = $this->setIdNodo($idnodo);
    $total = $this->getProyectoRepository()->consultarTotalProyectos()
    ->where('nodos.id', $idnodo)
    ->whereBetween('fecha_inicio', [$fecha_inicio, $fecha_fin])
    ->where('tiposarticulacionesproyectos.nombre', 'Grupos y Semilleros Externos')
    ->first()
    ->cantidad;
    return response()->json($total);
  }

  /**
  * Retorna la cantidad de proyectos inscritos con grupos de investigación internos finalizados
  *
  * @param int $idnodo Id del nodo
  * @param string $fecha_inicio Primera fecha para realizar el filtro
  * @param string $fecha_fin Segunda fecha para realizar el filtro
  * @return Response
  * @author dum
  */
  public function totalProyectoConGruposInternosFinalizados(int $idnodo, string $fecha_inicio, string $fecha_fin)
  {
    $idnodo = $this->setIdNodo($idnodo);
    $total = $this->getProyectoRepository()->consultarTotalProyectos()
    ->where('nodos.id', $idnodo)
    ->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_fin])
    ->where('tiposarticulacionesproyectos.nombre', 'Grupos y Semilleros del SENA')
    ->first()
    ->cantidad;
    return response()->json($total);
  }

  /**
  * Retorna la cantidad de proyectos inscritos con grupos de investigación internos
  *
  * @param int $idnodo Id del nodo
  * @param string $fecha_inicio Primera fecha para realizar el filtro
  * @param string $fecha_fin Segunda fecha para realizar el filtro
  * @return Response
  * @author dum
  */
  public function totalProyectoConGruposInternos(int $idnodo, string $fecha_inicio, string $fecha_fin)
  {
    $idnodo = $this->setIdNodo($idnodo);
    $total = $this->getProyectoRepository()->consultarTotalProyectos()
    ->where('nodos.id', $idnodo)
    ->whereBetween('fecha_inicio', [$fecha_inicio, $fecha_fin])
    ->where('tiposarticulacionesproyectos.nombre', 'Grupos y Semilleros del SENA')
    ->first()
    ->cantidad;
    return response()->json($total);
  }

  /**
   * Retorna el costos total de proyectos con cierre PF con Emprendedores u Otros
   *
   * @param int $idnodo Id del nodo
   * @param string $fecha_inicion Primera fecha para realizar el filtro
   * @param string $fecha_fin Segunda fecha para realizar el filtro
   * @return int
   * @author dum
   */
  public function totalCostoPMVFinalizadoEmprendedoresOtros(int $idnodo, string $fecha_inicio, string $fecha_fin)
  {
    // dd($this->getCostoController());
    $idnodo = $this->setIdNodo($idnodo);

    $proyectos = $this->getProyectoRepository()->consultarProyectosPorEstados_Detalle('Cierre PMV')->select('actividades.id')
    ->where('nodos.id', $idnodo)
    ->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_fin])
    ->whereIn('tiposarticulacionesproyectos.nombre', ['Emprendedor', 'Otros'])
    ->groupBy('actividades.id')
    ->get();

    $costosEquipos = 0;
    $costosAsesorias = 0;
    $costosAdministrativos = 0;
    $costosMateriales = 0;

    foreach ($proyectos as $key => $proyecto) {
      $actividad = $this->getActividadRepository()->getActividad_Repository($proyecto->id);
      // Usos de infraestructuras de la actividad
      $usos = $actividad->usoinfraestructuras;
      // Costos en pesos
      $costosEquipos += $this->getCostoController()->calcularCostosDeEquipos($usos);
      $costosAsesorias += $this->getCostoController()->calcularCostosDeAsesorias($usos);
      $costosAdministrativos += $this->getCostoController()->calcularCostosAdministrativos($usos);
      $costosMateriales += $this->getCostoController()->calcularCostosDeMateriales($usos);
    }

    // Suma de la sumatoria de todos los costos
    $costosTotales = $this->getCostoController()->calcularCostosTotales($costosEquipos, $costosAsesorias, $costosAdministrativos, $costosMateriales);
    return response()->json($costosTotales);

  }

  /**
  * Retorna la cantidad de PMV finalizados con emprendedores u otros inscritos
  *
  * @param int $idnodo Id del nodo
  * @param string $fecha_inicio Primera fecha para realizar el filtro
  * @param string $fecha_fin Segunda fecha para realizar el filtro
  * @return Response
  * @author dum
  */
  public function totalPMVFinalizadosEmprendedoresInvetoresOtro(int $idnodo, string $fecha_inicio, string $fecha_fin)
  {
    $idnodo = $this->setIdNodo($idnodo);
    $total = $this->getProyectoRepository()->consultarTotalProyectos()->where('nodos.id', $idnodo)->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_fin])->whereIn('tiposarticulacionesproyectos.nombre', ['Emprendedor', 'Otro'])->where('estadosproyecto.nombre', 'Cierre PMV')->first()->cantidad;
    return response()->json($total);
  }

  /**
  * Retorna el costos total de proyectos con cierre PF con empresas
  *
  * @param int $idnodo Id del nodo
  * @param string $fecha_inicion Primera fecha para realizar el filtro
  * @param string $fecha_fin Segunda fecha para realizar el filtro
  * @return int
  * @author dum
  */
  public function totalCostoPMVFinalizadoEmpresas(int $idnodo, string $fecha_inicio, string $fecha_fin)
  {
    // dd($this->getCostoController());
    $idnodo = $this->setIdNodo($idnodo);

    $proyectos = $this->getProyectoRepository()->consultarProyectosPorEstados_Detalle('Cierre PMV')->select('actividades.id')
    ->where('nodos.id', $idnodo)
    ->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_fin])
    ->where('tiposarticulacionesproyectos.nombre', 'Empresas')
    ->get();

    $costosEquipos = 0;
    $costosAsesorias = 0;
    $costosAdministrativos = 0;
    $costosMateriales = 0;

    foreach ($proyectos as $key => $proyecto) {
      $actividad = $this->getActividadRepository()->getActividad_Repository($proyecto->id);
      // Usos de infraestructuras de la actividad
      $usos = $actividad->usoinfraestructuras;
      // Costos en pesos
      $costosEquipos += $this->getCostoController()->calcularCostosDeEquipos($usos);
      $costosAsesorias += $this->getCostoController()->calcularCostosDeAsesorias($usos);
      $costosAdministrativos += $this->getCostoController()->calcularCostosAdministrativos($usos);
      $costosMateriales += $this->getCostoController()->calcularCostosDeMateriales($usos);
    }

    // Suma de la sumatoria de todos los costos
    $costosTotales = $this->getCostoController()->calcularCostosTotales($costosEquipos, $costosAsesorias, $costosAdministrativos, $costosMateriales);
    return response()->json($costosTotales);

  }

  /**
  * Retorna la cantidad de PMV finalizados con empresas
  *
  * @param int $idnodo Id del nodo
  * @param string $fecha_inicio Primera fecha para realizar el filtro
  * @param string $fecha_fin Segunda fecha para realizar el filtro
  * @return Response
  * @author dum
  */
  public function totalPMVfinalizadosConEmpresas(int $idnodo, string $fecha_inicio, string $fecha_fin)
  {
    $idnodo = $this->setIdNodo($idnodo);
    $total = $this->getProyectoRepository()->consultarTotalProyectos()->where('nodos.id', $idnodo)->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_fin])->where('tiposarticulacionesproyectos.nombre', 'Empresas')->where('estadosproyecto.nombre', 'Cierre PMV')->first()->cantidad;
    return response()->json($total);
  }

  /**
  * Retorna el costos total de proyectos con cierre PMV con talentos SENA
  *
  * @param int $idnodo Id del nodo
  * @param string $fecha_inicion Primera fecha para realizar el filtro
  * @param string $fecha_fin Segunda fecha para realizar el filtro
  * @return int
  * @author dum
  */
  public function totalCostoPMVFinalizadoSena(int $idnodo, string $fecha_inicio, string $fecha_fin)
  {
    // dd($this->getCostoController());
    $idnodo = $this->setIdNodo($idnodo);

    $proyectos = $this->getProyectoRepository()->consultarProyectosPorEstados_Detalle('Cierre PMV')->select('actividades.id')
    ->join('articulacion_proyecto_talento', 'articulacion_proyecto_talento.articulacion_proyecto_id', '=', 'articulacion_proyecto.id')
    ->join('talentos', 'talentos.id', '=', 'articulacion_proyecto_talento.talento_id')
    ->join('perfiles', 'perfiles.id', '=', 'talentos.perfil_id')
    ->where('nodos.id', $idnodo)
    ->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_fin])
    ->whereIn('perfiles.nombre', ['Aprendiz SENA sin apoyo de sostenimiento', 'Aprendiz SENA con apoyo de sostenimiento'])
    ->groupBy('actividades.id')
    ->get();

    // dd($proyectos);

    $costosEquipos = 0;
    $costosAsesorias = 0;
    $costosAdministrativos = 0;
    $costosMateriales = 0;

    foreach ($proyectos as $key => $proyecto) {
      $actividad = $this->getActividadRepository()->getActividad_Repository($proyecto->id);
      // Usos de infraestructuras de la actividad
      $usos = $actividad->usoinfraestructuras;
      // Costos en pesos
      $costosEquipos += $this->getCostoController()->calcularCostosDeEquipos($usos);
      $costosAsesorias += $this->getCostoController()->calcularCostosDeAsesorias($usos);
      $costosAdministrativos += $this->getCostoController()->calcularCostosAdministrativos($usos);
      $costosMateriales += $this->getCostoController()->calcularCostosDeMateriales($usos);
    }

    // Suma de la sumatoria de todos los costos
    $costosTotales = $this->getCostoController()->calcularCostosTotales($costosEquipos, $costosAsesorias, $costosAdministrativos, $costosMateriales);
    return response()->json($costosTotales);

  }

  /**
  * Retorna la cantidad de PMV finalizados con SENA
  *
  * @param int $idnodo Id del nodo
  * @param string $fecha_inicio Primera fecha para realizar el filtro
  * @param string $fecha_fin Segunda fecha para realizar el filtro
  * @return Response
  * @author dum
  */
  public function totalPMVSena(int $idnodo, string $fecha_inicio, string $fecha_fin)
  {
    $idnodo = $this->setIdNodo($idnodo);
    $total = $this->getProyectoRepository()->consultarTotalProyectos()->select('proyectos.id')
    ->join('articulacion_proyecto_talento', 'articulacion_proyecto_talento.articulacion_proyecto_id', '=', 'articulacion_proyecto.id')
    ->join('talentos', 'talentos.id', '=', 'articulacion_proyecto_talento.talento_id')
    ->join('perfiles', 'perfiles.id', '=', 'talentos.perfil_id')
    ->where('nodos.id', $idnodo)
    ->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_fin])
    ->whereIn('perfiles.nombre', ['Aprendiz SENA sin apoyo de sostenimiento', 'Aprendiz SENA con apoyo de sostenimiento'])
    ->where('estadosproyecto.nombre', 'Cierre PMV')
    ->groupBy('proyectos.id')
    ->get()
    ->count();
    return response()->json($total);
  }

  /**
  * Retorna la cantidad de proyectos finalizados PMV entre dos fechas
  *
  * @param int $idnodo Id del nodo
  * @param string $fecha_inicio Primera fecha para realizar el filtro
  * @param string $fecha_fin Segunda fecha para realizar el filtro
  * @return Response
  * @author dum
  */
  public function totalPMVfinalizados(int $idnodo, string $fecha_inicio, string $fecha_fin)
  {
    $idnodo = $this->setIdNodo($idnodo);
    $total = $this->getProyectoRepository()->consultarTotalProyectos()->where('nodos.id', $idnodo)->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_fin])->where('estadosproyecto.nombre', 'Cierre PMV')->first()->cantidad;
    return response()->json($total);
  }

  /**
   * Retorna el costos total de proyectos con cierre PF con Emprendedores u Otros
   *
   * @param int $idnodo Id del nodo
   * @param string $fecha_inicion Primera fecha para realizar el filtro
   * @param string $fecha_fin Segunda fecha para realizar el filtro
   * @return int
   * @author dum
   */
  public function totalCostoPFFFinalizadoEmprendedoresOtros(int $idnodo, string $fecha_inicio, string $fecha_fin)
  {
    // dd($this->getCostoController());
    $idnodo = $this->setIdNodo($idnodo);

    $proyectos = $this->getProyectoRepository()->consultarProyectosPorEstados_Detalle('Cierre PF')->select('actividades.id')
    ->where('nodos.id', $idnodo)
    ->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_fin])
    ->whereIn('tiposarticulacionesproyectos.nombre', ['Emprendedor', 'Otros'])
    ->groupBy('actividades.id')
    ->get();

    $costosEquipos = 0;
    $costosAsesorias = 0;
    $costosAdministrativos = 0;
    $costosMateriales = 0;

    foreach ($proyectos as $key => $proyecto) {
      $actividad = $this->getActividadRepository()->getActividad_Repository($proyecto->id);
      // Usos de infraestructuras de la actividad
      $usos = $actividad->usoinfraestructuras;
      // Costos en pesos
      $costosEquipos += $this->getCostoController()->calcularCostosDeEquipos($usos);
      $costosAsesorias += $this->getCostoController()->calcularCostosDeAsesorias($usos);
      $costosAdministrativos += $this->getCostoController()->calcularCostosAdministrativos($usos);
      $costosMateriales += $this->getCostoController()->calcularCostosDeMateriales($usos);
    }

    // Suma de la sumatoria de todos los costos
    $costosTotales = $this->getCostoController()->calcularCostosTotales($costosEquipos, $costosAsesorias, $costosAdministrativos, $costosMateriales);
    return response()->json($costosTotales);

  }

  /**
  * Retorna la cantidad total de proyectos en ejecución con Emprendedores, Inventores y Otros
  *
  * @param int $idnodo Id del nodo
  * @return Response
  */
  public function totalProyectosEnEjecucionEmprendedoresInventoresOtros(int $idnodo)
  {
    $idnodo = $this->setIdNodo($idnodo);
    $total = $this->getProyectoRepository()->consultarTotalProyectos()->where('nodos.id', $idnodo)->where('estadosproyecto.nombre', 'En ejecución')->whereIn('tiposarticulacionesproyectos.nombre', ['Emprendedor', 'Otros'])->first()->cantidad;
    return response()->json($total);
  }

  /**
  * Retorna la cantidad de PFF finalizados con emprendedores u otros inscritos
  *
  * @param int $idnodo Id del nodo
  * @param string $fecha_inicio Primera fecha para realizar el filtro
  * @param string $fecha_fin Segunda fecha para realizar el filtro
  * @return Response
  * @author dum
  */
  public function totalPFFFinalizadosEmprendedoresInvetoresOtro(int $idnodo, string $fecha_inicio, string $fecha_fin)
  {
    $idnodo = $this->setIdNodo($idnodo);
    $total = $this->getProyectoRepository()->consultarTotalProyectos()->where('nodos.id', $idnodo)->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_fin])->whereIn('tiposarticulacionesproyectos.nombre', ['Emprendedor', 'Otro'])->where('estadosproyecto.nombre', 'Cierre PF')->first()->cantidad;
    return response()->json($total);
  }

  /**
  * Retorna la cantidad de proyectos con emprendedores u otros inscritos
  *
  * @param int $idnodo Id del nodo
  * @param string $fecha_inicio Primera fecha para realizar el filtro
  * @param string $fecha_fin Segunda fecha para realizar el filtro
  * @return Response
  * @author dum
  */
  public function totalProyectosInscritosEmprendedoresInvetoresOtro(int $idnodo, string $fecha_inicio, string $fecha_fin)
  {
    $idnodo = $this->setIdNodo($idnodo);
    $total = $this->getProyectoRepository()->consultarTotalProyectos()->where('nodos.id', $idnodo)->whereBetween('fecha_inicio', [$fecha_inicio, $fecha_fin])->whereIn('tiposarticulacionesproyectos.nombre', ['Emprendedor', 'Otro'])->first()->cantidad;
    return response()->json($total);
  }

  /**
  * Retorna la cantidad de PFF finalizados con empresas
  *
  * @param int $idnodo Id del nodo
  * @param string $fecha_inicio Primera fecha para realizar el filtro
  * @param string $fecha_fin Segunda fecha para realizar el filtro
  * @return Response
  * @author dum
  */
  public function totalPFFfinalizadosConEmpresas(int $idnodo, string $fecha_inicio, string $fecha_fin)
  {
    $idnodo = $this->setIdNodo($idnodo);
    $total = $this->getProyectoRepository()->consultarTotalProyectos()->where('nodos.id', $idnodo)->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_fin])->where('tiposarticulacionesproyectos.nombre', 'Empresas')->where('estadosproyecto.nombre', 'Cierre PF')->first()->cantidad;
    return response()->json($total);
  }

  /**
  * Retorna la cantidad de proyectos inscritos con empresas
  *
  * @param int $idnodo Id del nodo
  * @param string $fecha_inicio Primera fecha para realizar el filtro
  * @param string $fecha_fin Segunda fecha para realizar el filtro
  * @return Response
  * @author dum
  */
  public function totalInscritosEmpresas(int $idnodo, string $fecha_inicio, string $fecha_fin)
  {
    $idnodo = $this->setIdNodo($idnodo);
    $total = $this->getProyectoRepository()->consultarTotalProyectos()->where('nodos.id', $idnodo)->whereBetween('fecha_inicio', [$fecha_inicio, $fecha_fin])->where('tiposarticulacionesproyectos.nombre', 'Empresas')->first()->cantidad;
    return response()->json($total);
  }

  /**
   * Retorna el costos total de proyectos con cierre PF con talentos SENA
   *
   * @param int $idnodo Id del nodo
   * @param string $fecha_inicion Primera fecha para realizar el filtro
   * @param string $fecha_fin Segunda fecha para realizar el filtro
   * @return int
   * @author dum
   */
  public function totalCostoPFFFinalizadoSena(int $idnodo, string $fecha_inicio, string $fecha_fin)
  {
    // dd($this->getCostoController());
    $idnodo = $this->setIdNodo($idnodo);

    $proyectos = $this->getProyectoRepository()->consultarProyectosPorEstados_Detalle('Cierre PF')->select('actividades.id')
    ->join('articulacion_proyecto_talento', 'articulacion_proyecto_talento.articulacion_proyecto_id', '=', 'articulacion_proyecto.id')
    ->join('talentos', 'talentos.id', '=', 'articulacion_proyecto_talento.talento_id')
    ->join('perfiles', 'perfiles.id', '=', 'talentos.perfil_id')
    ->where('nodos.id', $idnodo)
    ->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_fin])
    ->whereIn('perfiles.nombre', ['Aprendiz SENA sin apoyo de sostenimiento', 'Aprendiz SENA con apoyo de sostenimiento'])
    ->groupBy('actividades.id')
    ->get();

    $costosEquipos = 0;
    $costosAsesorias = 0;
    $costosAdministrativos = 0;
    $costosMateriales = 0;

    foreach ($proyectos as $key => $proyecto) {
      $actividad = $this->getActividadRepository()->getActividad_Repository($proyecto->id);
      // Usos de infraestructuras de la actividad
      $usos = $actividad->usoinfraestructuras;
      // Costos en pesos
      $costosEquipos += $this->getCostoController()->calcularCostosDeEquipos($usos);
      $costosAsesorias += $this->getCostoController()->calcularCostosDeAsesorias($usos);
      $costosAdministrativos += $this->getCostoController()->calcularCostosAdministrativos($usos);
      $costosMateriales += $this->getCostoController()->calcularCostosDeMateriales($usos);
    }

    // Suma de la sumatoria de todos los costos
    $costosTotales = $this->getCostoController()->calcularCostosTotales($costosEquipos, $costosAsesorias, $costosAdministrativos, $costosMateriales);
    return response()->json($costosTotales);

  }

  /**
   * Retorna el costos total de proyectos con cierre PF con empresas
   *
   * @param int $idnodo Id del nodo
   * @param string $fecha_inicion Primera fecha para realizar el filtro
   * @param string $fecha_fin Segunda fecha para realizar el filtro
   * @return int
   * @author dum
   */
  public function totalCostoPFFFinalizadoEmpresas(int $idnodo, string $fecha_inicio, string $fecha_fin)
  {
    // dd($this->getCostoController());
    $idnodo = $this->setIdNodo($idnodo);

    $proyectos = $this->getProyectoRepository()->consultarProyectosPorEstados_Detalle('Cierre PF')->select('actividades.id')
    ->where('nodos.id', $idnodo)
    ->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_fin])
    ->where('tiposarticulacionesproyectos.nombre', 'Empresas')
    ->get();

    $costosEquipos = 0;
    $costosAsesorias = 0;
    $costosAdministrativos = 0;
    $costosMateriales = 0;

    foreach ($proyectos as $key => $proyecto) {
      $actividad = $this->getActividadRepository()->getActividad_Repository($proyecto->id);
      // Usos de infraestructuras de la actividad
      $usos = $actividad->usoinfraestructuras;
      // Costos en pesos
      $costosEquipos += $this->getCostoController()->calcularCostosDeEquipos($usos);
      $costosAsesorias += $this->getCostoController()->calcularCostosDeAsesorias($usos);
      $costosAdministrativos += $this->getCostoController()->calcularCostosAdministrativos($usos);
      $costosMateriales += $this->getCostoController()->calcularCostosDeMateriales($usos);
    }

    // Suma de la sumatoria de todos los costos
    $costosTotales = $this->getCostoController()->calcularCostosTotales($costosEquipos, $costosAsesorias, $costosAdministrativos, $costosMateriales);
    return response()->json($costosTotales);

  }

  /**
   * Retorna la cantidad total de proyectos en ejecución con SENA (aprendiz, instructos)
   *
   * @param int $idnodo Id del nodo
   * @param string $fecha_inicio Primera fecha para realizar el filtro
   * @param string $fecha_fin Segunda fecha para realizar el filtro
   * @return Response
   */
  public function totalTalentosConProyectosEnAsocioConEmpresas(int $idnodo, string $fecha_inicio, string $fecha_fin)
  {
    $idnodo = $this->setIdNodo($idnodo);
    $total = $this->getProyectoRepository()->consultarTotalProyectos()->select(DB::raw('count(talentos.id) AS cantidad'))
    ->join('articulacion_proyecto_talento', 'articulacion_proyecto_talento.articulacion_proyecto_id', '=', 'articulacion_proyecto.id')
    ->join('talentos', 'talentos.id', '=', 'articulacion_proyecto_talento.talento_id')
    ->join('perfiles', 'perfiles.id', '=', 'talentos.perfil_id')
    ->where('nodos.id', $idnodo)
    ->whereIn('perfiles.nombre', ['Aprendiz SENA sin apoyo de sostenimiento', 'Aprendiz SENA con apoyo de sostenimiento'])
    ->whereBetween('fecha_inicio', [$fecha_inicio, $fecha_fin])
    ->first()->cantidad;
    return response()->json($total);
  }

  /**
   * Retorna la cantidad total de proyectos en ejecución con SENA (aprendiz, instructos)
   *
   * @param int $idnodo Id del nodo
   * @return Response
   */
  public function totalProyectosEnEjecucionSena(int $idnodo)
  {
    $idnodo = $this->setIdNodo($idnodo);
    $total = $this->getProyectoRepository()->consultarTotalProyectos()->select('proyectos.id')
    ->join('articulacion_proyecto_talento', 'articulacion_proyecto_talento.articulacion_proyecto_id', '=', 'articulacion_proyecto.id')
    ->join('talentos', 'talentos.id', '=', 'articulacion_proyecto_talento.talento_id')
    ->join('perfiles', 'perfiles.id', '=', 'talentos.perfil_id')
    ->where('nodos.id', $idnodo)
    ->where('estadosproyecto.nombre', 'En ejecución')
    ->whereIn('perfiles.nombre', ['Aprendiz SENA sin apoyo de sostenimiento', 'Aprendiz SENA con apoyo de sostenimiento'])
    ->groupBy('proyectos.id')
    ->get()
    ->count();
    return response()->json($total);
  }

  /**
   * Retorna la cantidad total de proyectos en ejecución con Empresas
   *
   * @param int $idnodo Id del nodo
   * @return Response
   */
  public function totalProyectosEnEjecucionEmpresas(int $idnodo)
  {
    $idnodo = $this->setIdNodo($idnodo);
    $total = $this->getProyectoRepository()->consultarTotalProyectos()->where('nodos.id', $idnodo)->where('estadosproyecto.nombre', 'En ejecución')->where('tiposarticulacionesproyectos.nombre', 'Empresas')->first()->cantidad;
    return response()->json($total);
  }

  /**
   * Retorna la cantidad total de proyectos en ejecución
   *
   * @param int $idnodo Id del nodo
   * @return Response
   */
  public function totalProyectosEjecucion(int $idnodo)
  {
    $idnodo = $this->setIdNodo($idnodo);
    $total = $this->getProyectoRepository()->consultarTotalProyectos()->where('nodos.id', $idnodo)->where('estadosproyecto.nombre', 'En ejecución')->first()->cantidad;
    return response()->json($total);
  }

  /**
   * Retorna la cantidad de proyectos inscritos con SENA
   *
   * @param int $idnodo Id del nodo
   * @param string $fecha_inicio Primera fecha para realizar el filtro
   * @param string $fecha_fin Segunda fecha para realizar el filtro
   * @return Response
   * @author dum
   */
  public function totalInscritosSena(int $idnodo, string $fecha_inicio, string $fecha_fin)
  {
    $idnodo = $this->setIdNodo($idnodo);
    $total = $this->getProyectoRepository()->consultarTotalProyectos()->select('proyectos.id')
    ->join('articulacion_proyecto_talento', 'articulacion_proyecto_talento.articulacion_proyecto_id', '=', 'articulacion_proyecto.id')
    ->join('talentos', 'talentos.id', '=', 'articulacion_proyecto_talento.talento_id')
    ->join('perfiles', 'perfiles.id', '=', 'talentos.perfil_id')
    ->where('nodos.id', $idnodo)
    ->whereBetween('fecha_inicio', [$fecha_inicio, $fecha_fin])
    ->whereIn('perfiles.nombre', ['Aprendiz SENA sin apoyo de sostenimiento', 'Aprendiz SENA con apoyo de sostenimiento'])
    ->groupBy('proyectos.id')
    ->get()
    ->count();
    return response()->json($total);
  }

  /**
   * Retorna la cantidad de PFF finalizados con SENA
   *
   * @param int $idnodo Id del nodo
   * @param string $fecha_inicio Primera fecha para realizar el filtro
   * @param string $fecha_fin Segunda fecha para realizar el filtro
   * @return Response
   * @author dum
   */
  public function totalPFFSena(int $idnodo, string $fecha_inicio, string $fecha_fin)
  {
    $idnodo = $this->setIdNodo($idnodo);
    $total = $this->getProyectoRepository()->consultarTotalProyectos()->select('proyectos.id')
    ->join('articulacion_proyecto_talento', 'articulacion_proyecto_talento.articulacion_proyecto_id', '=', 'articulacion_proyecto.id')
    ->join('talentos', 'talentos.id', '=', 'articulacion_proyecto_talento.talento_id')
    ->join('perfiles', 'perfiles.id', '=', 'talentos.perfil_id')
    ->where('nodos.id', $idnodo)
    ->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_fin])
    ->whereIn('perfiles.nombre', ['Aprendiz SENA sin apoyo de sostenimiento', 'Aprendiz SENA con apoyo de sostenimiento'])
    ->where('estadosproyecto.nombre', 'Cierre PF')
    ->groupBy('proyectos.id')
    ->get()
    ->count();
    return response()->json($total);
  }

  /**
   * Retorna la cantidad de proyectos finalizados PF entre dos fechas
   *
   * @param int $idnodo Id del nodo
   * @param string $fecha_inicio Primera fecha para realizar el filtro
   * @param string $fecha_fin Segunda fecha para realizar el filtro
   * @return Response
   * @author dum
   */
  public function totalPFFfinalizados(int $idnodo, string $fecha_inicio, string $fecha_fin)
  {
    $idnodo = $this->setIdNodo($idnodo);
    $total = $this->getProyectoRepository()->consultarTotalProyectos()->where('nodos.id', $idnodo)->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_fin])->where('estadosproyecto.nombre', 'Cierre PF')->first()->cantidad;
    return response()->json($total);
  }

  /**
   * Retorna la cantidad de proyectos inscritos entre dos fechas
   *
   * @param int $idnodo Id del nodo
   * @param string $fecha_inicio Primera fecha para realizar el filtro
   * @param string $fecha_fin Segunda fecha para realizar el filtro
   * @return Response
   * @author dum
   */
  public function totalProyectosInscritos(int $idnodo, string $fecha_inicio, string $fecha_fin)
  {
    $idnodo = $this->setIdNodo($idnodo);
    $total = $this->getProyectoRepository()->consultarTotalProyectos()->where('nodos.id', $idnodo)->whereBetween('fecha_inicio', [$fecha_inicio, $fecha_fin])->first()->cantidad;
    return response()->json($total);
  }

  /**
   * Asgian un valor al id del nodo según el rol
   *
   * @param type var Description
   * @return int
   * @author dum
   */
  private function setIdNodo(int $idnodo)
  {
    $id = $idnodo;
    if ( Session::get('login_role') == User::IsDinamizador() ) {
      $id = auth()->user()->dinamizador->nodo_id;
    }
    return $id;
  }

  /**
   * Asigna un valor a $proyectoRepository
   *
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
   *
   * @return ProyectoRepository
   * @author dum
   */
  private function getProyectoRepository()
  {
    return $this->proyectoRepository;
  }

  /**
   * Asigna un valor a $costoController
   *
   * @param CostoController $costoController
   * @return void
   */
  private function setCostoController(CostoController $costoController)
  {
    $this->costoController = $costoController;
  }

  /**
   * Retorna el valor de $costoController
   *
   * @return CostoController
   * @author dum
   */
  private function getCostoController()
  {
    return $this->costoController;
  }

  /**
   * Asigna un valor a $actividadRepository
   *
   * @param ActividadRepository $actividadRepository
   * @return void
   */
  private function setActividadRepository(ActividadRepository $actividadRepository)
  {
    $this->actividadRepository = $actividadRepository;
  }

  /**
   * Retorna el valor de $actividadRepository
   *
   * @return ActividadRepository
   * @author dum
   */
  private function getActividadRepository()
  {
    return $this->actividadRepository;
  }

  /**
   * Asigna un valor a $articulacionRepository
   *
   * @param ArticulacionRepository $articulacionRepository
   * @return void
   * @author dum
   */
  private function setArticulacionRepository(ArticulacionRepository $articulacionRepository)
  {
    $this->articulacionRepository = $articulacionRepository;
  }

  /**
   * Retorna el valor de $articulacionRepository
   *
   * @return ArticulacionRepository
   * @author dum
   */
  private function getArticulacionRepository()
  {
    return $this->articulacionRepository;
  }

  /**
   * Asigna un valor a $edtRepository
   *
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
   * Asigna un valor a $talentoRepository
   *
   * @param TalentoRepository $talentoRepository
   * @return void
   * @author dum
   */
  private function setTalentoRepository(TalentoRepository $talentoRepository)
  {
    $this->talentoRepository = $talentoRepository;
  }

  /**
   * Retorna el valor de $talentoRepository
   *
   * @return TalentoRepository
   * @author dum
   */
  private function getTalentoRepository()
  {
    return $this->talentoRepository;
  }

}
