<?php

namespace App\Repositories\Repository;


use App\Models\{Proyecto, Entidad, Fase, Actividad, ArticulacionProyecto, ArchivoArticulacionProyecto, Movimiento, UsoInfraestructura, Role};
use Illuminate\Support\Facades\{DB, Notification, Storage, Session};
use App\Notifications\Proyecto\{ProyectoCierreAprobado, ProyectoAprobarInicio, ProyectoAprobarPlaneacion, ProyectoAprobarEjecucion, ProyectoAprobarCierre, ProyectoAprobarSuspendido, ProyectoSuspendidoAprobado};
use Carbon\Carbon;
use App\User;
use App\Repositories\Repository\UserRepository\DinamizadorRepository;

class ProyectoRepository
{

  private $ideaRepository;

  public function __construct(IdeaRepository $ideaRepository)
  {
    $this->setIdeaRepository($ideaRepository);
  }

  /**
   * Método para traducir los meses que genera algunos querys
   *
   * @return void
   * @author dum
   */
  private function traducirMeses()
  {
    DB::statement("SET lc_time_names = 'es_ES'");
  }

  /**
   * Asgina un valor a $ideaRepository
   * @param object $ideaRepository
   * @return void
   * @author dum
   */
  private function setIdeaRepository($ideaRepository)
  {
    $this->ideaRepository = $ideaRepository;
  }

  /**
   * Retorna el valor de $ideaRepository
   * @return object
   * @author dum
   */
  private function getIdeaRepository()
  {
    return $this->ideaRepository;
  }

  /**
   * Método que retorna el directorio de los archivos que tiene un proyecto en el servidor
   * @param int $id Id de la articulacion_proyecto
   * @return mixed
   * @author dum
   */
  private function returnDirectoryProyectoFiles($id)
  {
    // consulta los archivos de un proyecto (registro de la base de datos)
    $tempo = ArchivoArticulacionProyecto::where('articulacion_proyecto_id', $id)->first();

    if ($tempo == null) {
      return false;
    } else {
      // Función para dividir la cadena en un array (Partiendolos con el delimitador /)
      $route = preg_split("~/~", $tempo->ruta, 9);
      // Extrae el último elemento del array
      array_pop($route);
      // Une el array en un string, dicho string se separa por /
      $route = implode("/", $route);
      // Reemplaza storage por public en la routa
      $route = str_replace('storage', 'public', $route);
      return $route;
    }
  }

  /**
   * Elimina los datos de un proyectos
   * @param int $id id del proyecto que se va a eliminar
   * @return boolean
   * @author dum
   */
  public function eliminarProyecto_Repository($id)
  {

    DB::beginTransaction();
    try {
      $proyecto = Proyecto::find($id);
      $padre = $proyecto->articulacion_proyecto->actividad;
      // Se usa el método sync sin nada para eliminar los datos de las relaciones muchos a muchos
      // Elimina los datos de la tabla articulacion_proyecto_talento relacionados con el proyecto
      $proyecto->articulacion_proyecto->talentos()->sync([]);
      // Elimina los datos de la tabla aprobaciones relacionados con el proyecto
      $proyecto->users()->sync([]);
      // Elimina el registro de la tabla de proyecto
      $padre->articulacion_proyecto->proyecto()->delete();
      // Directorio del proyecto
      $directory = $this->returnDirectoryProyectoFiles($padre->articulacion_proyecto->id);
      if ($directory != false) {
        // Elimina los archivos del servidor
        Storage::deleteDirectory($directory);
        // Elimina los registros de la tabla de archivos_articulacion_proyecto
        ArchivoArticulacionProyecto::where('articulacion_proyecto_id', $padre->articulacion_proyecto->id)->delete();
      }
      // Elimina el registro de la tabla la tabla de articulacion_proyecto
      $padre->articulacion_proyecto()->delete();
      // Elimina los registros de la tabla material_uso
      UsoInfraestructura::deleteUsoMateriales($padre);
      // $this->deleteUsoMateriales($padre);
      // Elimina los registros de la tabla uso_talentos
      UsoInfraestructura::deleteUsoTalentos($padre);
      // Elimina los registros de la tabla gestor_uso
      UsoInfraestructura::deleteUsoGestores($padre);
      // Elimina los registros de la tabla equipo_uso
      UsoInfraestructura::deleteUsoEquipos($padre);
      // Elimina los registros de la tabla usoinfraestructuras
      $padre->usoinfraestructuras()->delete();
      // Elimina la tabla de actividades
      $padre->delete();

      DB::commit();
      return true;
    } catch (\Exception $e) {
      DB::rollback();
      return false;
    }
  }

  /**
   * Consulta cantidades de proyectos
   *
   * @return Builder
   * @author dum
   */
  public function consultarTotalProyectos()
  {
    return Proyecto::selectRaw('count(proyectos.id) AS cantidad')
      ->join('estadosproyecto', 'estadosproyecto.id', '=', 'proyectos.estadoproyecto_id')
      ->join('tiposarticulacionesproyectos', 'tiposarticulacionesproyectos.id', '=', 'proyectos.tipoarticulacionproyecto_id')
      ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'proyectos.articulacion_proyecto_id')
      ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
      ->join('nodos', 'nodos.id', '=', 'actividades.nodo_id');
  }

  /**
   * Consulta la cantidad de proyectos por fecha de inicio y estados diferente a los de cierre
   * @param string $fecha_inicio Primera fecha para realizar el fitro
   * @param string $fecha_fin Segunda fecha para realizar el filtro
   * @return Collection
   * @author dum
   */
  public function consultarProyectoEnEstadoDeInicioPlaneacionEntreFecha($fecha_inicio, $fecha_fin)
  {
    return Proyecto::select('ep.nombre')
      ->selectRaw('count(proyectos.id) AS cantidad')
      ->join('estadosproyecto AS ep', 'ep.id', '=', 'proyectos.estadoproyecto_id')
      ->join('articulacion_proyecto AS ap', 'ap.id', '=', 'proyectos.articulacion_proyecto_id')
      ->join('actividades AS a', 'a.id', '=', 'ap.actividad_id')
      ->join('gestores AS g', 'g.id', '=', 'a.gestor_id')
      ->join('nodos', 'nodos.id', '=', 'a.nodo_id')
      ->where('proyectos.estado_aprobacion', Proyecto::IsAceptado())
      ->whereBetween('fecha_inicio', [$fecha_inicio, $fecha_fin])
      ->whereIn('ep.nombre', ['Inicio', 'Planeacion'])
      ->groupBy('ep.nombre');
  }

  /**
   * Consulta cantidad de proyectos por fechas de cierre
   * @param string $estadoProyecto Estado del proyecto que se quiere buscar
   * @param string $fecha_inicio Primera fecha oara realizar el filtro
   * @param string $fecha_fin Segunda fecha para realizar el filtro
   * @return Collection
   * @author dum
   */
  public function consultarProyectoEnEstadosDeCierreDeEntreFechas($estadoProyecto, $fecha_inicio, $fecha_fin)
  {
    return Proyecto::selectRaw('count(proyectos.id) as cantidad')
      ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'proyectos.articulacion_proyecto_id')
      ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
      ->join('gestores', 'gestores.id', '=', 'actividades.gestor_id')
      ->join('estadosproyecto', 'estadosproyecto.id', '=', 'proyectos.estadoproyecto_id')
      ->join('nodos', 'nodos.id', '=', 'actividades.nodo_id')
      ->where('estadosproyecto.nombre', $estadoProyecto)
      ->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_fin]);
  }

  /**
   * Consulta la información de los proyectos por un estado de proyecto especfico
   * @param string $estadoProyecto
   * @return Builder
   * @author dum
   */
  public function consultarProyectosPorEstados_Detalle($estadoProyecto)
  {
    return Proyecto::select(
      'codigo_actividad',
      'actividades.nombre AS nombre_proyecto',
      'sectores.nombre AS nombre_sector',
      'lineastecnologicas.nombre AS nombre_linea',
      'sublineas.nombre AS nombre_sublinea',
      'areasconocimiento.nombre AS nombre_areaconocimiento',
      'estadosproyecto.nombre AS nombre_estado',
      'tiposarticulacionesproyectos.nombre AS nombre_tipoproyecto',
      'fecha_inicio',
      'fecha_cierre',
      'observaciones_proyecto',
      'impacto_proyecto',
      'resultado_proyecto',
      'economia_naranja',
      'art_cti',
      'nom_act_cti',
      'diri_ar_emp',
      'reci_ar_emp',
      'dine_reg',
      'acc',
      'manual_uso_inf',
      'acta_inicio',
      'estado_arte',
      'actas_seguimiento',
      'video_tutorial',
      'ficha_caracterizacion',
      'acta_cierre',
      'encuesta'
    )
      ->selectRaw('CONCAT(ideas.codigo_idea, " - ", ideas.nombre_proyecto) AS nombre_idea')
      ->selectRaw('CONCAT(users.nombres, " ", users.apellidos) AS nombre_gestor')
      ->selectRaw('IF(video_tutorial = 1, url_videotutorial, "No Aplica") AS url_videotutorial')
      ->selectRaw('IF(revisado_final = ' . ArticulacionProyecto::IsPorEvaluar() . ', "Por Evaluar", IF(revisado_final = ' . ArticulacionProyecto::IsAprobado() . ', "Aprobado", "No Aprobado")) AS revisado_final')
      ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'proyectos.articulacion_proyecto_id')
      ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
      ->join('gestores', 'gestores.id', '=', 'actividades.gestor_id')
      ->join('users', 'users.id', '=', 'gestores.user_id')
      ->join('estadosproyecto', 'estadosproyecto.id', '=', 'proyectos.estadoproyecto_id')
      ->join('nodos', 'nodos.id', '=', 'actividades.nodo_id')
      ->join('ideas', 'ideas.id', '=', 'proyectos.idea_id')
      ->join('sectores', 'sectores.id', '=', 'proyectos.sector_id')
      ->join('sublineas', 'sublineas.id', '=', 'proyectos.sublinea_id')
      ->join('lineastecnologicas', 'lineastecnologicas.id', '=', 'sublineas.lineatecnologica_id')
      ->join('areasconocimiento', 'areasconocimiento.id', '=', 'proyectos.areaconocimiento_id')
      ->join('tiposarticulacionesproyectos', 'tiposarticulacionesproyectos.id', '=', 'proyectos.tipoarticulacionproyecto_id')
      ->where('proyectos.estado_aprobacion', Proyecto::IsAceptado())
      ->where('estadosproyecto.nombre', $estadoProyecto);
  }

  /**
   * Consulta la cantidad de proyectos que se finalizaron por mes de un nodo
   *
   * @param int $id Id del nodo
   * @return Collection
   * @author dum
   */
  public function proyectosFinalizadosPorMesDeUnNodo_Repository($id)
  {
    $this->traducirMeses();
    return Proyecto::selectRaw('count(proyectos.id) AS cantidad')
      ->selectRaw('MONTH(actividades.fecha_cierre) AS meses')
      ->selectRaw('CONCAT(UPPER(LEFT(date_format(actividades.fecha_cierre, "%M"), 1)), LOWER(SUBSTRING(date_format(actividades.fecha_cierre, "%M"), 2))) AS mes')
      ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'proyectos.articulacion_proyecto_id')
      ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
      ->join('nodos', 'nodos.id', '=', 'actividades.nodo_id')
      ->where('nodos.id', $id)
      ->where('estado_aprobacion', Proyecto::IsAceptado())
      ->groupBy('meses', 'mes')
      ->orderBy('meses');
  }

  /**
   * Consulta los proyectos
   * @return Collection
   * @author dum
   */
  public function consultarProyectos_Repository()
  {
    return Proyecto::select(
      'fecha_inicio',
      'sectores.nombre AS nombre_sector',
      'lineastecnologicas.nombre AS nombre_linea',
      'sublineas.nombre AS nombre_sublinea',
      'areasconocimiento.nombre AS nombre_areaconocimiento',
      'estadosproyecto.nombre AS nombre_estadoproyecto',
      'tiposarticulacionesproyectos.nombre AS nombre_tipoproyecto',
      'observaciones_proyecto',
      'fecha_cierre',
      'impacto_proyecto',
      'economia_naranja',
      'art_cti',
      'diri_ar_emp',
      'reci_ar_emp',
      'dine_reg',
      'acc',
      'manual_uso_inf',
      'acta_inicio',
      // 'aval_empresa_grupo',
      'estado_arte',
      'actas_seguimiento',
      'video_tutorial',
      'ficha_caracterizacion',
      'acta_cierre',
      'encuesta',
      'lecciones_aprendidas',
      'actividades.codigo_actividad',
      'actividades.nombre'
    )
      ->selectRaw('concat(ideas.codigo_idea, " - ", ideas.nombre_proyecto) AS nombre_idea')
      ->selectRaw('concat(g.documento, " - ", g.nombres, " ", g.apellidos) AS gestor')
      // ->selectRaw('GROUP_CONCAT(users.documento, " - ", users.nombres, " ", users.apellidos SEPARATOR "; ") AS talentos')
      ->selectRaw('IF(art_cti = 1, nom_act_cti, "No Aplica") AS nom_act_cti')
      ->selectRaw('IF(video_tutorial = 1, url_videotutorial, "No Aplica") AS url_videotutorial')
      ->selectRaw('IF(revisado_final = ' . ArticulacionProyecto::IsPorEvaluar() . ', "Por Evaluar", IF(revisado_final = ' . ArticulacionProyecto::IsAprobado() . ', "Aprobado", "No Aprobado")) AS revisado_final')
      ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'proyectos.articulacion_proyecto_id')
      ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
      ->join('nodos', 'nodos.id', '=', 'actividades.nodo_id')
      ->join('ideas', 'ideas.id', '=', 'proyectos.idea_id')
      ->join('sectores', 'sectores.id', '=', 'proyectos.sector_id')
      ->join('sublineas', 'sublineas.id', '=', 'proyectos.sublinea_id')
      ->join('lineastecnologicas', 'lineastecnologicas.id', '=', 'sublineas.lineatecnologica_id')
      ->join('areasconocimiento', 'areasconocimiento.id', '=', 'proyectos.areaconocimiento_id')
      ->join('tiposarticulacionesproyectos', 'tiposarticulacionesproyectos.id', '=', 'proyectos.tipoarticulacionproyecto_id')
      // ->join('articulacion_proyecto_talento', 'articulacion_proyecto_talento.articulacion_proyecto_id', '=', 'articulacion_proyecto.id')
      // ->join('talentos', 'talentos.id', '=', 'articulacion_proyecto_talento.talento_id')
      // ->join('users', 'users.id', '=', 'talentos.user_id')
      ->join('gestores', 'gestores.id', '=', 'actividades.gestor_id')
      ->join('users AS g', 'g.id', '=', 'gestores.user_id')
      ->join('estadosproyecto', 'estadosproyecto.id', '=', 'proyectos.estadoproyecto_id')
      ->where('estado_aprobacion', Proyecto::IsAceptado());
  }

  /**
   * Consulta la cantidad de proyectos que se finalizaron entre dos fechas por nodo y tipos de poyecto
   * @param int $id Id del nodo
   * @param string $fecha_inicio Primera fecha para realizar el filtro
   * @param string $fecha_fin Segunda fecha para realizar el filtro
   * @return Collection
   * @author dum
   */
  public function consultarCantidadDeProyectosFinalizadosPorTipoProyecto_Repository($id, $fecha_inicio, $fecha_fin)
  {
    return Proyecto::select('tiposarticulacionesproyectos.nombre')
      ->selectRaw('COUNT(proyectos.id) AS cantidad')
      ->join('tiposarticulacionesproyectos', 'tiposarticulacionesproyectos.id', '=', 'proyectos.tipoarticulacionproyecto_id')
      ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'proyectos.articulacion_proyecto_id')
      ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
      ->join('nodos', 'nodos.id', '=', 'actividades.nodo_id')
      ->join('estadosproyecto', 'estadosproyecto.id', '=', 'proyectos.estadoproyecto_id')
      ->where('nodos.id', $id)
      ->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_fin])
      ->where('proyectos.estado_aprobacion', 1)
      ->whereIn('estadosproyecto.nombre', ['Cierre PF', 'Cierre PMV'])
      ->groupBy('proyectos.tipoarticulacionproyecto_id');
  }

  /**
   * Consulta la cantidad de proyectos que se inscribieron entre dos fechas por nodo y tipos de poyecto
   * @param int $id Id del nodo
   * @param string $fecha_inicio Primera fecha para realizar el filtro
   * @param string $fecha_fin Segunda fecha para realizar el filtro
   * @return Collection
   * @author dum
   */
  public function consultarCantidadDeProyectosInscritosPorTipoProyecto_Repository($id, $fecha_inicio, $fecha_fin)
  {
    return Proyecto::select('tiposarticulacionesproyectos.nombre')
      ->selectRaw('COUNT(proyectos.id) AS cantidad')
      ->join('tiposarticulacionesproyectos', 'tiposarticulacionesproyectos.id', '=', 'proyectos.tipoarticulacionproyecto_id')
      ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'proyectos.articulacion_proyecto_id')
      ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
      ->join('nodos', 'nodos.id', '=', 'actividades.nodo_id')
      ->where('nodos.id', $id)
      ->whereBetween('fecha_inicio', [$fecha_inicio, $fecha_fin])
      ->where('proyectos.estado_aprobacion', 1)
      ->groupBy('proyectos.tipoarticulacionproyecto_id');
  }

  /**
   * Consulta el talento líder de un proyecto
   * @param int $id Id del proyecto
   * @return Collection
   * @author dum
   */
  public function consultarTalentoLiderDeUnProyecto($id)
  {
    return Proyecto::select('users.documento', 'tiposdocumentos.nombre AS nombre_documento', 'fechanacimiento')
      ->selectRaw('concat(users.nombres, " ", users.apellidos) AS nombre_talento')
      ->selectRaw('concat(ciudades.nombre, " - ", departamentos.nombre) AS ciudad_expedicion')
      ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'proyectos.articulacion_proyecto_id')
      ->join('articulacion_proyecto_talento', 'articulacion_proyecto_talento.articulacion_proyecto_id', '=', 'articulacion_proyecto.id')
      ->join('talentos', 'talentos.id', '=', 'articulacion_proyecto_talento.talento_id')
      ->join('users', 'users.id', '=', 'talentos.user_id')
      ->join('tiposdocumentos', 'tiposdocumentos.id', '=', 'users.tipodocumento_id')
      ->join('ciudades', 'ciudades.id', '=', 'users.ciudad_expedicion_id')
      ->join('departamentos', 'departamentos.id', '=', 'ciudades.departamento_id')
      ->where('proyectos.id', $id);
  }

  // /**
  // * Cambia el estado de la aprobacion de un proyecto de un usuario y rol
  // * @param Request
  // * @param int $id Id del proyecto
  // * @return boolean
  // * @author dum
  // */
  // public function updateAprobacionUsuario($request, $id)
  // {
  //
  //   DB::beginTransaction();
  //   try {
  //     if ( $request->txtaprobacion != Proyecto::IsAceptado() && $request->txtaprobacion != Proyecto::IsNoAceptado() ) {
  //       DB::rollback();
  //       return false;
  //     }
  //     $user = auth()->user()->id;
  //     $role = Session::get('login_role');
  //     $role = $this->pivotAprobacionesUnica($id, $user, $role)->role_id;
  //     $update = DB::update("UPDATE aprobaciones SET aprobacion = $request->txtaprobacion WHERE proyecto_id = $id AND user_id = $user AND role_id = $role");
  //     $some = $this->pivotAprobaciones($id)->where('aprobacion', 0)->get();
  //     if ( count($some) == 0 ) {
  //       $aprobados = $this->pivotAprobaciones($id)->where('aprobacion', 1)->get();
  //       $proyecto = Proyecto::find($id);
  //       if ( count($aprobados) == 3 ) {
  //         // En caso de que TODOS (Dinamizador, Gestor, Talento Líder) hayan aprobado el proyecto
  //
  //         // Instancia de la clase ArchivoRepository
  //         $archivoRepo = new ArchivoRepository();
  //
  //         // Generar guardar el pdf del acuerdo de confidencialidad y compromiso en el servidor
  //         $outputPdf = PdfProyectoController::printAcuerdoConfidencialidadCompromiso($this, $id);
  //
  //         // Guarda la ruta de los archivos en la base de datos
  //         $fileStoraged = $archivoRepo->storeFileArticulacionProyecto($outputPdf['articulacion_proyecto_id'], $outputPdf['fase_id'], $outputPdf['ruta']);
  //
  //         // Cambia el estado de aprobacion del proyecto a aceptado y actualiza en acc en la base de datos
  //         $proyecto->update([
  //           'estado_aprobacion' => Proyecto::IsAceptado(),
  //           'acc' => 1
  //         ]);
  //       } else {
  //         // En caso de que UNO SOLO no haya aprobado el proyecto
  //
  //         //Cambiar el estado de la idea de proyecto según el tipo de idea de proyecto (Si es con empresa o grupo cambia a Inicio, si es con Emprendedor cambia a Admitido)
  //         $idea = $proyecto->idea;
  //         if ( $idea->tipo_idea == Idea::IsEmpresa() || $idea->tipo_idea == Idea::IsGrupoInvestigacion() ) {
  //           $this->getIdeaRepository()->updateEstadoIdea($idea->id, 'Inicio');
  //         } else {
  //           $this->getIdeaRepository()->updateEstadoIdea($idea->id, 'Admitido');
  //         }
  //         $padre = $proyecto->articulacion_proyecto->actividad;
  //         // Se usa el método sync sin nada para eliminar los datos de las relaciones muchos a muchos
  //         // Elimina los datos de la tabla articulacion_proyecto_talento relacionados con el proyecto
  //         $proyecto->articulacion_proyecto->talentos()->sync([]);
  //         // Elimina los datos de la tabla aprobaciones relacionados con el proyecto
  //         $proyecto->users()->sync([]);
  //         // Elimina el registro de la tabla de proyecto
  //         $padre->articulacion_proyecto->proyecto()->delete();
  //         // Elimina el registro de la tabla la tabla de articulacion_proyecto
  //         $padre->articulacion_proyecto()->delete();
  //         // Elimina la tabla de actividades
  //         $padre->delete();
  //
  //       }
  //     }
  //     DB::commit();
  //     return true;
  //   } catch (\Exception $e) {
  //     DB::rollback();
  //     return false;
  //   }
  //
  // }

  /**
   * Consulta un único registro de la tabla pivot (aprobaciones)
   *
   * @param int $id Id del proyecto
   * @param int $user Id del usuario
   * @param string $role Nombre del rol
   */
  public function pivotAprobacionesUnica($id, $user, $role)
  {
    return Proyecto::select('roles.name', 'role_id', 'aprobacion AS aprobacion_value')
      ->selectRaw('concat(users.nombres, " ", users.apellidos) AS usuario')
      ->selectRaw('IF(aprobacion = 0, "Pendiente", IF(aprobacion = 1, "Aprobado", "No Aprobado")) AS aprobacion')
      ->join('aprobaciones', 'aprobaciones.proyecto_id', '=', 'proyectos.id')
      ->join('users', 'users.id', '=', 'aprobaciones.user_id')
      ->join('roles', 'roles.id', '=', 'aprobaciones.role_id')
      ->where('proyectos.id', $id)
      ->where('roles.name', $role)
      ->where('users.id', $user)
      ->first();
  }

  /**
   * Consulta los datos de la tabla pivot (aprobaciones)
   *
   * @param int $id
   * @return Collection
   * @author dum
   */
  public function pivotAprobaciones($id)
  {
    return Proyecto::select('roles.name', 'users.documento', 'users.id AS user_id')
      ->selectRaw('concat(users.nombres, " ", users.apellidos) AS usuario')
      ->selectRaw('IF(aprobacion = 0, "Pendiente", IF(aprobacion = 1, "Aprobado", "No Aprobado")) AS aprobacion')
      ->join('aprobaciones', 'aprobaciones.proyecto_id', '=', 'proyectos.id')
      ->join('users', 'users.id', '=', 'aprobaciones.user_id')
      ->join('roles', 'roles.id', '=', 'aprobaciones.role_id')
      ->where('proyectos.id', $id);
  }
  /**
   * Consulta los proyectos del talento
   *
   * @param int $id Id del usuario
   * @return Collection
   * @author dum
   */
  public function proyectosDelTalento($id)
  {
    return Proyecto::select('proyectos.id', 'actividades.codigo_actividad AS codigo_proyecto', 'actividades.nombre', 'fases.nombre AS nombre_fase')
      ->selectRaw('concat(codigo_idea, " - ", nombre_proyecto) AS nombre_idea')
      ->selectRaw('concat(users.nombres, " ", users.apellidos) AS nombre_gestor')
      ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'proyectos.articulacion_proyecto_id')
      ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
      ->join('nodos', 'nodos.id', '=', 'actividades.nodo_id')
      ->join('ideas', 'ideas.id', '=', 'proyectos.idea_id')
      ->join('gestores', 'gestores.id', '=', 'actividades.gestor_id')
      ->join('users', 'users.id', '=', 'gestores.user_id')
      ->join('fases', 'fases.id', '=', 'proyectos.fase_id')
      ->join('articulacion_proyecto_talento', 'articulacion_proyecto_talento.articulacion_proyecto_id', '=', 'articulacion_proyecto.id')
      ->join('talentos', 'talentos.id', '=', 'articulacion_proyecto_talento.talento_id')
      ->join('users AS user_talento', 'user_talento.id', '=', 'talentos.id')
      ->where('talentos.id', $id)
      ->get();
  }

  /**
   * Consulta los proyectos que se inscribieron con empresas por nodo y año
   *
   * @param int $id Id del nodo
   * @param string $anho Año para filtrar la consulta
   * @return Collection
   * @author dum
   */
  public function consultarProyectosInscritosConEmpresasPorAnhoYAnho_Repository($id, $anho)
  {
    return Proyecto::select(
      'fecha_inicio',
      'sectores.nombre AS nombre_sector',
      'lineastecnologicas.nombre AS nombre_linea',
      'sublineas.nombre AS nombre_sublinea',
      'areasconocimiento.nombre AS nombre_areaconocimiento',
      'estadosproyecto.nombre AS nombre_estadoproyecto',
      'tiposarticulacionesproyectos.nombre AS nombre_tipoproyecto',
      'observaciones_proyecto',
      'fecha_cierre',
      'impacto_proyecto',
      'economia_naranja',
      'art_cti',
      'diri_ar_emp',
      'reci_ar_emp',
      'dine_reg',
      'acc',
      'manual_uso_inf',
      'acta_inicio',
      // 'aval_empresa_grupo',
      'estado_arte',
      'actas_seguimiento',
      'video_tutorial',
      'ficha_caracterizacion',
      'acta_cierre',
      'encuesta',
      'lecciones_aprendidas',
      'actividades.codigo_actividad',
      'actividades.nombre'
    )
      ->selectRaw('concat(ideas.codigo_idea, " - ", ideas.nombre_proyecto) AS nombre_idea')
      ->selectRaw('concat(g.documento, " - ", g.nombres, " ", g.apellidos) AS gestor')
      // ->selectRaw('GROUP_CONCAT(users.documento, " - ", users.nombres, " ", users.apellidos SEPARATOR "; ") AS talentos')
      ->selectRaw('IF(art_cti = 1, nom_act_cti, "No Aplica") AS nom_act_cti')
      ->selectRaw('IF(video_tutorial = 1, url_videotutorial, "No Aplica") AS url_videotutorial')
      ->selectRaw('IF(revisado_final = ' . ArticulacionProyecto::IsPorEvaluar() . ', "Por Evaluar", IF(revisado_final = ' . ArticulacionProyecto::IsAprobado() . ', "Aprobado", "No Aprobado")) AS revisado_final')
      ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'proyectos.articulacion_proyecto_id')
      ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
      ->join('nodos', 'nodos.id', '=', 'actividades.nodo_id')
      ->join('ideas', 'ideas.id', '=', 'proyectos.idea_id')
      ->join('sectores', 'sectores.id', '=', 'proyectos.sector_id')
      ->join('sublineas', 'sublineas.id', '=', 'proyectos.sublinea_id')
      ->join('lineastecnologicas', 'lineastecnologicas.id', '=', 'sublineas.lineatecnologica_id')
      ->join('areasconocimiento', 'areasconocimiento.id', '=', 'proyectos.areaconocimiento_id')
      ->join('estadosproyecto', 'estadosproyecto.id', '=', 'proyectos.estadoproyecto_id')
      ->join('tiposarticulacionesproyectos', 'tiposarticulacionesproyectos.id', '=', 'proyectos.tipoarticulacionproyecto_id')
      // ->join('articulacion_proyecto_talento', 'articulacion_proyecto_talento.articulacion_proyecto_id', '=', 'articulacion_proyecto.id')
      // ->join('talentos', 'talentos.id', '=', 'articulacion_proyecto_talento.talento_id')
      // ->join('users', 'users.id', '=', 'talentos.user_id')
      ->join('gestores', 'gestores.id', '=', 'actividades.gestor_id')
      ->join('users AS g', 'g.id', '=', 'gestores.user_id')
      ->whereYear('fecha_inicio', $anho)
      ->where('nodos.id', $id)
      ->where('tiposarticulacionesproyectos.nombre', 'Empresas')
      ->groupBy('proyectos.id')
      ->orderBy('fecha_inicio')
      ->get();
  }

  /**
   * Consulta los proyectos que se inscribieron por nodo y año
   *
   * @param int $id Id del nodo
   * @param string $anho Año
   * @return Collection
   * @author dum
   */
  public function consultarProyectosInscritosPorAnhoYNodo_Repository($id, $anho)
  {
    return Proyecto::select(
      'fecha_inicio',
      'sectores.nombre AS nombre_sector',
      'lineastecnologicas.nombre AS nombre_linea',
      'sublineas.nombre AS nombre_sublinea',
      'areasconocimiento.nombre AS nombre_areaconocimiento',
      'estadosproyecto.nombre AS nombre_estadoproyecto',
      'tiposarticulacionesproyectos.nombre AS nombre_tipoproyecto',
      'observaciones_proyecto',
      'impacto_proyecto',
      'economia_naranja',
      'art_cti',
      'diri_ar_emp',
      'reci_ar_emp',
      'dine_reg',
      'acc',
      'manual_uso_inf',
      'acta_inicio',
      // 'aval_empresa_grupo',
      'estado_arte',
      'actas_seguimiento',
      'video_tutorial',
      'ficha_caracterizacion',
      'acta_cierre',
      'encuesta',
      'lecciones_aprendidas',
      'actividades.codigo_actividad',
      'estado_aprobacion',
      'fecha_cierre',
      'actividades.nombre'
    )
      ->selectRaw('concat(ideas.codigo_idea, " - ", ideas.nombre_proyecto) AS nombre_idea')
      ->selectRaw('CONCAT(g.documento, " - ", g.nombres, " ", g.apellidos) AS gestor')
      // ->selectRaw('GROUP_CONCAT(users.documento, " - ", users.nombres, " ", users.apellidos SEPARATOR "; ") AS talentos')
      ->selectRaw('IF(art_cti = 1, nom_act_cti, "No Aplica") AS nom_act_cti')
      ->selectRaw('IF(video_tutorial = 1, url_videotutorial, "No Aplica") AS url_videotutorial')
      ->selectRaw('IF(revisado_final = ' . ArticulacionProyecto::IsPorEvaluar() . ', "Por Evaluar", IF(revisado_final = ' . ArticulacionProyecto::IsAprobado() . ', "Aprobado", "No Aprobado")) AS revisado_final')
      ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'proyectos.articulacion_proyecto_id')
      ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
      ->join('nodos', 'nodos.id', '=', 'actividades.nodo_id')
      ->join('ideas', 'ideas.id', '=', 'proyectos.idea_id')
      ->join('sectores', 'sectores.id', '=', 'proyectos.sector_id')
      ->join('sublineas', 'sublineas.id', '=', 'proyectos.sublinea_id')
      ->join('lineastecnologicas', 'lineastecnologicas.id', '=', 'sublineas.lineatecnologica_id')
      ->join('areasconocimiento', 'areasconocimiento.id', '=', 'proyectos.areaconocimiento_id')
      ->join('estadosproyecto', 'estadosproyecto.id', '=', 'proyectos.estadoproyecto_id')
      ->join('tiposarticulacionesproyectos', 'tiposarticulacionesproyectos.id', '=', 'proyectos.tipoarticulacionproyecto_id')
      // ->join('articulacion_proyecto_talento', 'articulacion_proyecto_talento.articulacion_proyecto_id', '=', 'articulacion_proyecto.id')
      // ->join('talentos', 'talentos.id', '=', 'articulacion_proyecto_talento.talento_id')
      // ->join('users', 'users.id', '=', 'talentos.user_id')
      ->join('gestores', 'gestores.id', '=', 'actividades.gestor_id')
      ->join('users AS g', 'g.id', '=', 'gestores.user_id')
      ->whereYear('fecha_inicio', $anho)
      ->where('nodos.id', $id)
      ->where('estado_aprobacion', Proyecto::IsAceptado())
      ->groupBy('proyectos.id')
      ->orderBy('fecha_inicio')
      ->get();
  }

  /**
   * Consulta la cantidad de proyectos con empresas que se inscriben por mes de un año y un nodo
   *
   * @param int $id Id del nodo
   * @param string $anho Año para filtrar
   * @return Collection
   */
  public function proyectosInscritosConEmpresasPorMesDeUnNodo_Repository($id, $anho)
  {
    $this->traducirMeses();
    return Proyecto::selectRaw('count(proyectos.id) AS cantidad')
      ->selectRaw('MONTH(actividades.fecha_inicio) AS meses')
      ->selectRaw('CONCAT(UPPER(LEFT(date_format(actividades.fecha_inicio, "%M"), 1)), LOWER(SUBSTRING(date_format(actividades.fecha_inicio, "%M"), 2))) AS mes')
      ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'proyectos.articulacion_proyecto_id')
      ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
      ->join('nodos', 'nodos.id', '=', 'actividades.nodo_id')
      ->join('tiposarticulacionesproyectos', 'tiposarticulacionesproyectos.id', '=', 'proyectos.tipoarticulacionproyecto_id')
      ->whereYear('fecha_inicio', $anho)
      ->where('nodos.id', $id)
      ->where('tiposarticulacionesproyectos.nombre', 'Empresas')
      ->groupBy('meses', 'mes')
      ->orderBy('meses')
      ->get();
  }

  /**
   * Consulta la cantidad de proyectos que se inscriben por mes de un nodo
   *
   * @param int $id Id del nodo
   * @return Collection
   */
  public function proyectosInscritosPorMesDeUnNodo_Repository($id)
  {
    $this->traducirMeses();
    return Proyecto::selectRaw('count(proyectos.id) AS cantidad')
      ->selectRaw('MONTH(actividades.fecha_inicio) AS meses')
      ->selectRaw('CONCAT(UPPER(LEFT(date_format(actividades.fecha_inicio, "%M"), 1)), LOWER(SUBSTRING(date_format(actividades.fecha_inicio, "%M"), 2))) AS mes')
      ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'proyectos.articulacion_proyecto_id')
      ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
      ->join('nodos', 'nodos.id', '=', 'actividades.nodo_id')
      // ->whereYear('fecha_inicio', $anho)
      ->where('nodos.id', $id)
      ->where('estado_aprobacion', Proyecto::IsAceptado())
      ->groupBy('meses', 'mes')
      ->orderBy('meses');
  }

  /**
   * Método que retorna los talentos en un array, para usarlo junto a la funcion sync de laravel
   * @param \Illuminate\Http\Request  $request
   * @return array
   * @author dum
   */
  private function arraySyncTalentosDeUnProyecto($request)
  {
    $syncData = array();
    foreach ($request->get('talentos') as $id => $value) {
      if ($value == request()->get('radioTalentoLider')) {
        $syncData[$id] = array('talento_lider' => 1, 'talento_id' => $value);
      } else {
        $syncData[$id] = array('talento_lider' => 0, 'talento_id' => $value);
      }
    }
    return $syncData;
  }

  /**
   * Método el cuál actualiza ALGUNOS campos de la tabla de proyecto
   *
   * @param Request request Request con los datos del formulario
   * @param int id - Id del proyecto que se va a modificar
   * @return boolean
   * @author dum
   */
  public function update($request, $id)
  {
    $proyecto = Proyecto::find($id);
    // dd($proyecto->articulacion_proyecto->actividad->objetivos_especificos->get(1)->update(['objetivo' => 'biribiri']));
    DB::beginTransaction();
    try {
      $proyecto = Proyecto::find($id);

      $trl_esperado = 1;
      $reci_ar_emp = 1;
      $economia_naranja = 1;
      $dirigido_discapacitados = 1;
      $art_cti = 1;
      $fabrica_productividad = 1;

      if (!isset(request()->trl_esperado)) {
        $trl_esperado = 0;
      }

      if (!isset(request()->txtreci_ar_emp)) {
        $reci_ar_emp = 0;
      }

      if (!isset(request()->txteconomia_naranja)) {
        $economia_naranja = 0;
      }

      if (!isset(request()->txtdirigido_discapacitados)) {
        $dirigido_discapacitados = 0;
      }

      if (!isset(request()->txtarti_cti)) {
        $art_cti = 0;
      }

      if (!isset(request()->txtfabrica_productividad)) {
        $fabrica_productividad = 0;
      }

      $proyecto->articulacion_proyecto->actividad()->update([
        'nombre' => request()->txtnombre,
        'objetivo_general' => request()->txtobjetivo
      ]);

      $proyecto->update([
        'areaconocimiento_id' => request()->txtareaconocimiento_id,
        'otro_areaconocimiento' => request()->txtotro_areaconocimiento,
        'sublinea_id' => request()->txtsublinea_id,
        'trl_esperado' => $trl_esperado,
        'reci_ar_emp' => $reci_ar_emp,
        'economia_naranja' => $economia_naranja,
        'tipo_economianaranja' => request()->txttipo_economianaranja,
        'dirigido_discapacitados' => $dirigido_discapacitados,
        'tipo_discapacitados' => request()->txttipo_discapacitados,
        'art_cti' => $art_cti,
        'nom_act_cti' => request()->txtnom_act_cti,
        'alcance_proyecto' => request()->txtalcance_proyecto,
        'fabrica_productividad' => $fabrica_productividad
      ]);


      $syncData = array();
      $syncData = $this->arraySyncTalentosDeUnProyecto($request);
      $proyecto->articulacion_proyecto->talentos()->sync($syncData, true);

      $proyecto->articulacion_proyecto->actividad->objetivos_especificos->get(0)->update([
        'objetivo' => request()->txtobjetivo_especifico1
      ]);

      $proyecto->articulacion_proyecto->actividad->objetivos_especificos->get(1)->update([
        'objetivo' => request()->txtobjetivo_especifico2
      ]);

      $proyecto->articulacion_proyecto->actividad->objetivos_especificos->get(2)->update([
        'objetivo' => request()->txtobjetivo_especifico3
      ]);

      $proyecto->articulacion_proyecto->actividad->objetivos_especificos->get(3)->update([
        'objetivo' => request()->txtobjetivo_especifico4
      ]);

      $proyecto->users_propietarios()->detach();
      $proyecto->empresas()->detach();
      $proyecto->gruposinvestigacion()->detach();

      $proyecto->users_propietarios()->attach(request()->propietarios_user);
      $proyecto->empresas()->attach(request()->propietarios_empresas);
      $proyecto->gruposinvestigacion()->attach(request()->propietarios_grupos);

      DB::commit();
      return true;
    } catch (\Exception $e) {
      DB::rollback();
      return false;
    }
  }

  /**
   * Cambia el estado del proyecto a Cierre y asigna un fecha de cierre al proyecto
   * @param Request $request
   * @param Proyecto $proyecto
   * @return boolean
   * @author dum
   */
  public function cerrarProyecto($request, $proyecto)
  {
    DB::beginTransaction();
    try {

      $proyecto->articulacion_proyecto->actividad->movimientos()->attach(Movimiento::where('movimiento', 'Cerró')->first(), [
        'actividad_id' => $proyecto->articulacion_proyecto->actividad->id,
        'user_id' => auth()->user()->id,
        'fase_id' => Fase::where('nombre', 'Finalizado')->first()->id,
        'role_id' => Role::where('name', Session::get('login_role'))->first()->id
      ]);

      $proyecto->update([
        'fase_id' => Fase::where('nombre', 'Cierre')->first()->id
      ]);

      $proyecto->articulacion_proyecto->actividad()->update([
        'fecha_cierre' => $request->txtfecha_cierre
      ]);



      DB::commit();
      return true;
    } catch (\Throwable $th) {
      DB::rollback();
      return false;
    }
  }

  /**
   * Suspende un proyecto
   * @param Request $request 
   * @param int $id Id del proyecto
   * @return boolean
   * @author dum
   **/
  public function suspenderProyecto($request, $proyecto)
  {
    DB::beginTransaction();
    try {
      $proyecto->update([
        'fase_id' => Fase::where('nombre', 'Suspendido')->first()->id
      ]);

      $proyecto->articulacion_proyecto->actividad()->update([
        'fecha_cierre' => $request->txtfecha_cierre
      ]);
      DB::commit();
      return true;
    } catch (\Throwable $th) {
      DB::rollBack();
      return false;
    }
  }

  /**
   * Modifica los datos de cierre de un proyecto
   * 
   * @param Request $request
   * @param int $id Id del proyecto
   * @return boolean
   * @author dum
   */
  public function updateCierreProyectoRepository($request, $id)
  {
    DB::beginTransaction();
    try {
      $objetivo1_alcanzado = 1;
      $objetivo2_alcanzado = 1;
      $objetivo3_alcanzado = 1;
      $objetivo4_alcanzado = 1;
      $proyecto = Proyecto::findOrFail($id);

      if (!isset($request->txtobjetivo1_alcanzado)) {
        $objetivo1_alcanzado = 0;
      }

      if (!isset($request->txtobjetivo2_alcanzado)) {
        $objetivo2_alcanzado = 0;
      }

      if (!isset($request->txtobjetivo3_alcanzado)) {
        $objetivo3_alcanzado = 0;
      }

      if (!isset($request->txtobjetivo4_alcanzado)) {
        $objetivo4_alcanzado = 0;
      }

      $proyecto->update([
        'trl_obtenido' => $request->trl_obtenido,
        'diri_ar_emp' => $request->txtdiri_ar_emp,
        'trl_prototipo' => $request->txttrl_prototipo,
        'trl_pruebas' => $request->txttrl_pruebas,
        'trl_modelo' => $request->txttrl_modelo,
        'trl_normatividad' => $request->txttrl_normatividad
      ]);

      $proyecto->articulacion_proyecto->actividad()->update([
        'conclusiones' => $request->txtconclusiones
      ]);

      $proyecto->articulacion_proyecto->actividad->objetivos_especificos->get(0)->update([
        'cumplido' => $objetivo1_alcanzado
      ]);

      $proyecto->articulacion_proyecto->actividad->objetivos_especificos->get(1)->update([
        'cumplido' => $objetivo2_alcanzado
      ]);

      $proyecto->articulacion_proyecto->actividad->objetivos_especificos->get(2)->update([
        'cumplido' => $objetivo3_alcanzado
      ]);

      $proyecto->articulacion_proyecto->actividad->objetivos_especificos->get(3)->update([
        'cumplido' => $objetivo4_alcanzado
      ]);


      DB::commit();
      return true;
    } catch (\Throwable $th) {
      DB::rollback();
      return false;
    }
  }

  /**
   * Modifica los entregables de un proyecto
   * @param Request $request
   * @param int $id Id del proyecto
   * @return boolean
   * @author dum
   */
  public function updateEntregablesInicioProyectoRepository($request, $id)
  {
    DB::beginTransaction();
    try {
      $acc = 1;
      $manual_uso_inf = 1;
      $doc_titular = 1;
      $formulario_inicio = 1;

      if (!isset($request->txtacc)) {
        $acc = 0;
      }

      if (!isset($request->txtmanual_uso_inf)) {
        $manual_uso_inf = 0;
      }

      if (!isset($request->txtdoc_titular)) {
        $doc_titular = 0;
      }

      if (!isset($request->txtformulario_inicio)) {
        $formulario_inicio = 0;
      }

      $proyecto = Proyecto::find($id);

      /**
       * Modifica los datos de la tabla proyectos
       */
      $proyecto->update([
        'acc' => $acc,
        'manual_uso_inf' => $manual_uso_inf,
        'doc_titular' => $doc_titular
      ]);

      $proyecto->articulacion_proyecto->actividad()->update([
        'formulario_inicio' => $formulario_inicio
      ]);

      DB::commit();
      return true;
    } catch (\Exception $e) {
      DB::rollback();
      return false;
    }
  }

  public function setPostCierreProyectoRepository(int $id)
  {
    DB::beginTransaction();
    try {
      $proyecto = Proyecto::findOrFail($id);

      $proyecto->articulacion_proyecto->actividad->movimientos()->attach(Movimiento::where('movimiento', 'Aprobó')->first(), [
        'actividad_id' => $proyecto->articulacion_proyecto->actividad->id,
        'user_id' => auth()->user()->id,
        'fase_id' => Fase::where('nombre', 'Ejecución')->first()->id,
        'role_id' => Role::where('name', Session::get('login_role'))->first()->id
      ]);

      $proyecto->articulacion_proyecto()->update([
        'aprobacion_dinamizador_ejecucion' => 1
      ]);
      DB::commit();
      return true;
    } catch (\Throwable $th) {
      DB::rollback();
      return false;
    }
  }


  /** 
   * Cambia un proyecto de fase
   * 
   * @param int $id Id del proyecto
   * @param string $fase nombre de la fase a la que se va a cambiar el proyecto
   * @return boolean
   * @author dum
   */
  public function updateFaseProyecto($id, $fase)
  {
    DB::beginTransaction();
    try {

      $proyecto = Proyecto::findOrFail($id);

      $fase_aprobada = -1;
      if ($fase == 'Planeación') {
        $fase_aprobada = Fase::where('nombre', 'Inicio')->first()->id;
      } else {
        $fase_aprobada = Fase::where('nombre', 'Planeación')->first()->id;
      }

      $proyecto->articulacion_proyecto->actividad->movimientos()->attach(Movimiento::where('movimiento', 'Aprobó')->first(), [
        'actividad_id' => $proyecto->articulacion_proyecto->actividad->id,
        'user_id' => auth()->user()->id,
        'fase_id' => $fase_aprobada,
        'role_id' => Role::where('name', Session::get('login_role'))->first()->id
      ]);
      $proyecto->update([
        'fase_id' => Fase::where('nombre', $fase)->first()->id
      ]);
      DB::commit();
      return true;
    } catch (\Exception $e) {
      DB::rollback();
      return false;
    }
  }

  /**
   * Modifica los entregables de la fase de planeación de un proyecto
   * @param int $id Id del proyecto
   * @author dum
   * @return boolean
   * @author dum
   */
  public function updateEntregablesPlaneacionProyectoRepository($request, $id)
  {
    DB::beginTransaction();
    try {

      $cronograma = 1;
      $estado_arte = 1;

      if (!isset($request->txtcronograma)) {
        $cronograma = 0;
      }

      if (!isset($request->txtestado_arte)) {
        $estado_arte = 0;
      }

      $proyecto = Proyecto::findOrFail($id);
      $proyecto->update([
        'estado_arte' => $estado_arte
      ]);

      $proyecto->articulacion_proyecto->actividad()->update([
        'cronograma' => $cronograma
      ]);

      DB::commit();
      return true;
    } catch (\Throwable $th) {
      DB::rollback();
      return false;
    }
  }

  /**
   * Modifica los entregables de la fase de cierre
   * 
   * @param Request $request
   * @param int $id Id del proyecto
   * @return boolean
   * @author dum
   */
  public function updateEntregableCierreProyectoRepository($request, $id)
  {
    DB::beginTransaction();
    try {
      $evidencia_trl = 1;
      $formulario_final = 1;
      $proyecto = Proyecto::findOrFail($id);

      if (!isset($request->txtevidencia_trl)) {
        $evidencia_trl = 0;
      }

      if (!isset($request->txtformulario_final)) {
        $formulario_final = 0;
      }


      $proyecto->update([
        'evidencia_trl' => $evidencia_trl
      ]);

      $proyecto->articulacion_proyecto->actividad()->update([
        'formulario_final' => $formulario_final
      ]);
      DB::commit();
      return true;
    } catch (\Throwable $th) {
      DB::rollback();
      return false;
    }
  }

  /**
   * Notifica al dinamizador para que apruebe el proyecto en la fase de inicio
   * 
   * @param int $id Id del proyecto
   * @return boolean
   * @author dum
   */
  public function notificarAlDinamziador_Inicio(int $id)
  {
    DB::beginTransaction();
    try {
      $dinamizadorRepository = new DinamizadorRepository;
      $proyecto = Proyecto::findOrFail($id);
      $dinamizadores = $dinamizadorRepository->getAllDinamizadoresPorNodo($proyecto->articulacion_proyecto->actividad->nodo_id)->get();
      Notification::send($dinamizadores, new ProyectoAprobarInicio($proyecto));
      DB::commit();
      return true;
    } catch (\Throwable $th) {
      DB::rollBack();
      return false;
    }
  }

  /**
   * Notifica al dinamizador para que apruebe el proyecto en la fase de cierre
   * 
   * @param int $id Id del proyecto
   * @return boolean
   * @author dum
   */
  public function notificarAlDinamziador_Cierre(int $id)
  {
    DB::beginTransaction();
    try {
      $dinamizadorRepository = new DinamizadorRepository;
      $proyecto = Proyecto::findOrFail($id);
      $dinamizadores = $dinamizadorRepository->getAllDinamizadoresPorNodo($proyecto->articulacion_proyecto->actividad->nodo_id)->get();
      Notification::send($dinamizadores, new ProyectoAprobarCierre($proyecto));
      DB::commit();
      return true;
    } catch (\Throwable $th) {
      DB::rollBack();
      return false;
    }
  }

  /**
   * Notifica al dinamizador para que apruebe el proyecto en la fase de suspendido
   * 
   * @param int $id Id del proyecto
   * @return boolean
   * @author dum
   */
  public function notificarAlDinamziador_Suspendido(int $id)
  {
    DB::beginTransaction();
    try {
      $dinamizadorRepository = new DinamizadorRepository;
      $proyecto = Proyecto::findOrFail($id);
      $dinamizadores = $dinamizadorRepository->getAllDinamizadoresPorNodo($proyecto->articulacion_proyecto->actividad->nodo_id)->get();
      Notification::send($dinamizadores, new ProyectoAprobarSuspendido($proyecto));
      DB::commit();
      return true;
    } catch (\Throwable $th) {
      DB::rollBack();
      return false;
    }
  }

  /**
   * Notifica al talento interlocutor para que apruebe la fase de planeación
   * 
   * @param int $id Id del proyecto
   * @return boolean
   * @author dum
   */
  public function notificarAlDinamizador_Planeacion(int $id)
  {
    DB::beginTransaction();
    try {
      $dinamizadorRepository = new DinamizadorRepository;
      $proyecto = Proyecto::findOrFail($id);
      $dinamizadores = $dinamizadorRepository->getAllDinamizadoresPorNodo($proyecto->articulacion_proyecto->actividad->nodo_id)->get();
      Notification::send($dinamizadores, new ProyectoAprobarPlaneacion($proyecto));
      DB::commit();
      return true;
    } catch (\Throwable $th) {
      DB::rollBack();
      return false;
    }
  }

  public function notificarAlDinamizador_Ejecucion(int $id)
  {
    DB::beginTransaction();
    try {
      $dinamizadorRepository = new DinamizadorRepository;
      $proyecto = Proyecto::findOrFail($id);
      $dinamizadores = $dinamizadorRepository->getAllDinamizadoresPorNodo($proyecto->articulacion_proyecto->actividad->nodo_id)->get();
      Notification::send($dinamizadores, new ProyectoAprobarEjecucion($proyecto));
      DB::commit();
      return true;
    } catch (\Throwable $th) {
      DB::rollBack();
      return false;
    }
  }

  /**
   * Cambia el estado de aprobacion_dinamizador, para permitirle al gestor cerrar el proyecto
   */
  public function updateAprobacionDinamizador(int $id)
  {
    DB::beginTransaction();
    try {
      $proyecto = Proyecto::findOrFail($id);

      $proyecto->articulacion_proyecto->actividad->movimientos()->attach(Movimiento::where('movimiento', 'Aprobó')->first(), [
        'actividad_id' => $proyecto->articulacion_proyecto->actividad->id,
        'user_id' => auth()->user()->id,
        'fase_id' => Fase::where('nombre', 'Cierre')->first()->id,
        'role_id' => Role::where('name', Session::get('login_role'))->first()->id
      ]);

      Notification::send(User::find($proyecto->articulacion_proyecto->actividad->gestor->user->id), new ProyectoCierreAprobado($proyecto));
      $proyecto->articulacion_proyecto->actividad()->update([
        'aprobacion_dinamizador' => 1
      ]);
      DB::commit();
      return true;
    } catch (\Throwable $th) {
      DB::rollback();
      return false;
    }
  }

  /**
   * Cambia el estado de aprobacion_dinamizador_suspender para que el gestor pueda suspender un proyecto
   * @param int $id
   * @return boolean
   * @author dum
   **/
  public function updateAprobacionSuspendido(int $id)
  {
    DB::beginTransaction();
    try {
      $proyecto = Proyecto::findOrFail($id);
      $proyecto->articulacion_proyecto()->update([
        'aprobacion_dinamizador_suspender' => 1
      ]);
      Notification::send(User::findOrFail($proyecto->articulacion_proyecto->actividad->gestor->user->id), new ProyectoSuspendidoAprobado($proyecto));
      // dd($n);
      DB::commit();
      return true;
    } catch (\Throwable $th) {
      DB::rollback();
      return false;
    }
  }

  /**
   * Modifica los entregables de un proyecto en la fase de ejecución
   * 
   * @param Request $request
   * @param int $id Id de proyecto
   * @return boolean
   * @author dum
   */
  public function updateEntregablesEjecucionProyectoRepository($request, $id)
  {
    DB::beginTransaction();
    try {
      $proyecto = Proyecto::findOrFail($id);
      $seguimiento = 1;
      if (!isset($request->txtseguimiento)) {
        $seguimiento = 0;
      }
      $proyecto->articulacion_proyecto->actividad()->update([
        'seguimiento' => $seguimiento
      ]);
      DB::commit();
      return true;
    } catch (\Throwable $th) {
      DB::rollback();
      return false;
    }
  }

  /**
   * Consulta los proyectos que tiene un gestor por año
   * @param int $idgestor Id del gestor
   * @param string $anho Año por el que se filtra la consulta
   * @return Collection
   * @author dum
   */
  public function ConsultarProyectosPorAnho($anho)
  {
    return Proyecto::select(
      'actividades.codigo_actividad AS codigo_proyecto',
      'actividades.nombre',
      'areasconocimiento.nombre AS nombre_areaconocimiento',
      'sublineas.nombre AS sublinea_nombre',
      'articulacion_proyecto.id AS articulacion_proyecto_id',
      'actividades.fecha_cierre AS fecha_fin',
      'lineastecnologicas.nombre AS nombre_linea',
      'fecha_inicio',
      'fecha_cierre',
      'economia_naranja',
      'fases.nombre AS nombre_fase',
      'proyectos.id'
    )
      ->selectRaw('concat(users.documento, " - ", users.nombres, " ", users.apellidos) AS gestor')
      ->selectRaw('concat(ideas.codigo_idea, " - ", ideas.nombre_proyecto) as nombre_idea')
      ->join('sublineas', 'sublineas.id', '=', 'proyectos.sublinea_id')
      ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'proyectos.articulacion_proyecto_id')
      ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
      ->join('gestores', 'gestores.id', '=', 'actividades.gestor_id')
      ->join('users', 'users.id', '=', 'gestores.user_id')
      ->join('ideas', 'ideas.id', '=', 'proyectos.idea_id')
      ->join('lineastecnologicas', 'lineastecnologicas.id', '=', 'sublineas.lineatecnologica_id')
      ->join('areasconocimiento', 'areasconocimiento.id', '=', 'proyectos.areaconocimiento_id')
      ->leftJoin('fases', 'fases.id', '=', 'proyectos.fase_id')
      ->join('nodos', 'nodos.id', '=', 'actividades.nodo_id')
      ->where(function ($q) use ($anho) {
        $q->where(function ($query) use ($anho) {
          $query->whereYear('actividades.fecha_cierre', '=', $anho)
            ->whereIn('fases.nombre', ['Cierre', 'Suspendido']);
        })
          ->orWhere(function ($query) {
            $query->whereIn('fases.nombre', ['Inicio', 'Planeación', 'Ejecución']);
          });
      })
      ->groupBy('proyectos.id');
  }

  /**
   * Genera un código para le proyecto
   * @return string
   * @author dum
   */
  private function generarCodigoDeProyecto()
  {
    $anho = Carbon::now()->isoFormat('YYYY');
    $tecnoparque = sprintf("%02d", auth()->user()->gestor->nodo_id);
    $linea = auth()->user()->gestor->lineatecnologica_id;
    $gestor = sprintf("%03d", auth()->user()->gestor->id);
    $idProyecto = Proyecto::selectRaw('MAX(id+1) AS max')->get()->last();
    $idProyecto->max == null ? $idProyecto->max = 1 : $idProyecto->max = $idProyecto->max;
    $idProyecto->max = sprintf("%04d", $idProyecto->max);

    return 'P' . $anho . '-' . $tecnoparque . $linea . $gestor . '-' . $idProyecto->max;
  }

  /**
   * Registra un nuevo proyecto en la base de datos
   * @param Request $request Datos del formulario
   * @return boolean
   * @author dum
   */
  public function store($request)
  {
    DB::beginTransaction();
    try {
      $codigo_actividad = $this->generarCodigoDeProyecto();
      $entidad_id = Entidad::all()->where('nombre', 'No Aplica')->last()->id;

      $trl_esperado = 1;
      $reci_ar_emp = 1;
      $economia_naranja = 1;
      $dirigido_discapacitados = 1;
      $art_cti = 1;
      $fabrica_productividad = 1;


      $this->getIdeaRepository()->updateEstadoIdea(request()->txtidea_id, 'En Proyecto');

      if (!isset(request()->trl_esperado)) {
        $trl_esperado = 0;
      }

      if (!isset(request()->txtreci_ar_emp)) {
        $reci_ar_emp = 0;
      }

      if (!isset(request()->txteconomia_naranja)) {
        $economia_naranja = 0;
      }

      if (!isset(request()->txtdirigido_discapacitados)) {
        $dirigido_discapacitados = 0;
      }

      if (!isset(request()->txtarti_cti)) {
        $art_cti = 0;
      }

      if (!isset(request()->txtfabrica_productividad)) {
        $fabrica_productividad = 0;
      }

      $actividad = Actividad::create([
        'gestor_id' => auth()->user()->gestor->id,
        'nodo_id' => auth()->user()->gestor->nodo_id,
        'codigo_actividad' => $codigo_actividad,
        'nombre' => request()->txtnombre,
        'fecha_inicio' => Carbon::now()->isoFormat('YYYY-MM-DD'),
        'objetivo_general' => request()->txtobjetivo
      ]);

      $articulacion_proyecto = ArticulacionProyecto::create([
        'entidad_id' => $entidad_id,
        'actividad_id' => $actividad->id
      ]);

      $proyecto = Proyecto::create([
        'articulacion_proyecto_id' => $articulacion_proyecto->id,
        'fase_id' => Fase::where('nombre', 'Inicio')->first()->id,
        'idea_id' => request()->txtidea_id,
        'areaconocimiento_id' => request()->txtareaconocimiento_id,
        'otro_areaconocimiento' => request()->txtotro_areaconocimiento,
        'sublinea_id' => request()->txtsublinea_id,
        'trl_esperado' => $trl_esperado,
        'reci_ar_emp' => $reci_ar_emp,
        'economia_naranja' => $economia_naranja,
        'tipo_economianaranja' => request()->txttipo_economianaranja,
        'dirigido_discapacitados' => $dirigido_discapacitados,
        'tipo_discapacitados' => request()->txttipo_discapacitados,
        'art_cti' => $art_cti,
        'nom_act_cti' => request()->txtnom_act_cti,
        'alcance_proyecto' => request()->txtalcance_proyecto,
        'fabrica_productividad' => $fabrica_productividad
      ]);


      $syncData = array();
      $syncData = $this->arraySyncTalentosDeUnProyecto($request);
      $articulacion_proyecto->talentos()->sync($syncData, false);

      ArticulacionProyecto::habilitarTalentos($articulacion_proyecto);

      $actividad->objetivos_especificos()->create([
        'objetivo' => request()->txtobjetivo_especifico1
      ]);

      $actividad->objetivos_especificos()->create([
        'objetivo' => request()->txtobjetivo_especifico2
      ]);

      $actividad->objetivos_especificos()->create([
        'objetivo' => request()->txtobjetivo_especifico3
      ]);

      $actividad->objetivos_especificos()->create([
        'objetivo' => request()->txtobjetivo_especifico4
      ]);

      $proyecto->users_propietarios()->attach(request()->propietarios_user);
      $proyecto->empresas()->attach(request()->propietarios_empresas);
      $proyecto->gruposinvestigacion()->attach(request()->propietarios_grupos);

      DB::commit();
      return true;
    } catch (\Exception $e) {
      DB::rollback();
      return false;
    }
  }

  /*========================================================================
  =            metodo para consultar los proyectos de un ususario gestor talento         =
  ========================================================================*/
  public function getProjectsForUser(array $relations, array $estado = [])
  {
    return Proyecto::estadoOfProjects($relations, $estado);
  }

  public function getProjectsActivesByUser(array $relations, array $fase = [])
  {
    return Proyecto::with($relations)->whereHas(
      'fase',
      function ($query) use ($fase) {
        $query->whereIn('nombre', $fase);
      }
    );
  }
}
