<?php

namespace App\Repositories\Repository;

use App\Models\{Proyecto, Entidad, EstadoPrototipo, TipoArticulacionProyecto, EstadoProyecto, Actividad, ArticulacionProyecto, Talento, Role, Nodo, Idea};
use Illuminate\Support\Facades\{DB, Session, Notification};
use App\Notifications\Proyecto\ProyectoPendiente;
use Carbon\Carbon;
use App\User;

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
  * Cambia el estado de la aprobacion de un proyecto de un usuario y rol
  * @param Request
  * @param int $id Id del proyecto
  * @return boolean
  * @author dum
  */
  public function updateAprobacionUsuario($request, $id)
  {
    DB::beginTransaction();
    try {
      if ( $request->txtaprobacion != Proyecto::IsAceptado() && $request->txtaprobacion != Proyecto::IsNoAceptado() ) {
        DB::rollback();
        return false;
      }
      $user = auth()->user()->id;
      $role = Session::get('login_role');
      $role = $this->pivotAprobacionesUnica($id, $user, $role)->role_id;
      $update = DB::update("UPDATE aprobaciones SET aprobacion = $request->txtaprobacion WHERE proyecto_id = $id AND user_id = $user AND role_id = $role");
      $some = $this->pivotAprobaciones($id)->where('aprobacion', 0)->get();
      if ( count($some) == 0 ) {
        $aprobados = $this->pivotAprobacion($id)->where('aprobacion', 1)->get();
        $proyecto = Proyecto::find($id);
        if ( count($aprobados) == 3 ) {
          // En caso de que TODOS (Dinamizador, Gestor, Talento Líder) hayan aprobado el proyecto

          // Espacio para generar el pdf del acuerdo de confidencialidad y compromiso
          // code...

          // Cambia el estado de aprobacion del proyecto a aceptado
          $proyecto->update([
            'estado_aprobacion' => Proyecto::IsAceptado(),
            'acc' => 1
          ]);
        } else {
          // En caso de que UNO SOLO no haya aprobado el proyecto
          //Cambiar el estado de la idea de proyecto según el tipo de idea de proyecto (Si es con empresa o grupo cambia a Inicio, si es con Emprendedor cambia a Admitido)
          $idea = $proyecto->idea;
          if ( $idea->tipo_idea == Idea::IsEmpresa() || $idea->tipo_idea == Idea::IsGrupoInvestigacion() ) {
            $this->getIdeaRepository()->updateEstadoIdea($idea->id, 'Inicio');
          } else {
            $this->getIdeaRepository()->updateEstadoIdea($idea->id, 'Admitido');
          }
          $padre = $proyecto->articulacion_proyecto->actividad;
          // Elimina los datos de la tabla articulacion_proyecto_talento relacionados con el proyecto
          $proyecto->articulacion_proyecto->articulacion_proyecto_talento()->delete();
          // Elimina los datos de la tabla aprobaciones relacionados con el proyecto
          $proyecto->users()->delete();
          // Elimina el registro de la tabla de proyecto
          $padre->articulacion_proyecto->proyecto()->delete();
          // Elimina el registro de la tabla la tabla de articulacion_proyecto
          $padre->articulacion_proyecto()->delete();
          // Elimina la tabla de actividades
          $padre->delete();
        }
      }
      DB::commit();
      return true;
    } catch (\Exception $e) {
      DB::rollback();
      return false;
    }

  }

  /**
   * Consulta un único registro de la tabla pivot (aprobaciones)
   *
   * @param int $id Id del proyecto
   * @param int $user Id del usuario
   * @param string
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
    return Proyecto::select('roles.name')
    ->selectRaw('concat(users.nombres, " ", users.apellidos) AS usuario')
    ->selectRaw('IF(aprobacion = 0, "Pendiente", IF(aprobacion = 1, "Aprobado", "No Aprobado")) AS aprobacion')
    ->join('aprobaciones', 'aprobaciones.proyecto_id', '=', 'proyectos.id')
    ->join('users', 'users.id', '=', 'aprobaciones.user_id')
    ->join('roles', 'roles.id', '=', 'aprobaciones.role_id')
    ->where('proyectos.id', $id);
  }
  /**
   * undocumented function summary
   *
   * Undocumented function long description
   *
   * @param int $id Id del usuario
   * @return Collection
   * @author dum
   */
  public function proyectosPendientesDeAprobacion_Repository($id)
  {
    return Proyecto::select('proyectos.id')
    ->selectRaw('concat(codigo_idea, " - ", nombre_proyecto) AS nombre_idea')
    ->selectRaw('concat("Tecnoparque nodo ", entidades.nombre) AS nombre_nodo')
    ->selectRaw('IF(estado_aprobacion = '.Proyecto::IsPendiente().', "Pendiente", IF(estado_aprobacion = '.Proyecto::IsAceptado().', "Aprobado", "No Aprobado")) AS estado_aprobacion')
    ->selectRaw('concat(gestor_user.nombres, " ", gestor_user.apellidos) AS nombre_gestor')
    ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'proyectos.articulacion_proyecto_id')
    ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
    ->join('nodos', 'nodos.id', '=', 'actividades.nodo_id')
    ->join('gestores', 'gestores.id', '=', 'actividades.gestor_id')
    ->join('entidades', 'entidades.id', '=', 'nodos.entidad_id')
    ->join('ideas', 'ideas.id', '=', 'proyectos.idea_id')
    ->join('users AS gestor_user', 'gestor_user.id', '=', 'gestores.user_id')
    ->join('aprobaciones', 'aprobaciones.proyecto_id', '=', 'proyectos.id')
    ->join('users', 'users.id', '=', 'aprobaciones.user_id')
    ->join('roles', 'roles.id', '=', 'aprobaciones.role_id')
    ->where('users.id', $id)
    ->where('roles.name', Session::get('login_role'))
    ->where('estado_aprobacion', '!=', Proyecto::IsAceptado())
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
    return Proyecto::select('fecha_inicio',
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
    'actividades.nombre')
    ->selectRaw('concat(ideas.codigo_idea, " - ", ideas.nombre_proyecto) AS nombre_idea')
    ->selectRaw('GROUP_CONCAT(users.documento, " - ", users.nombres, " ", users.apellidos SEPARATOR "; ") AS talentos')
    ->selectRaw('IF(art_cti = 1, nom_act_cti, "No Aplica") AS nom_act_cti')
    ->selectRaw('IF(video_tutorial = 1, url_videotutorial, "No Aplica") AS url_videotutorial')
    ->selectRaw('IF(revisado_final = '. ArticulacionProyecto::IsPorEvaluar() .', "Por Evaluar", IF(revisado_final = '. ArticulacionProyecto::IsAprobado() .', "Aprobado", "No Aprobado")) AS revisado_final')
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
    ->join('articulacion_proyecto_talento', 'articulacion_proyecto_talento.articulacion_proyecto_id', '=', 'articulacion_proyecto.id')
    ->join('talentos', 'talentos.id', '=', 'articulacion_proyecto_talento.talento_id')
    ->join('users', 'users.id', '=', 'talentos.user_id')
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
  public function consultarProyectosInscritosPorAnhoYNodo_Repository($id, $anho) {
    return Proyecto::select('fecha_inicio',
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
    'actividades.nombre')
    ->selectRaw('concat(ideas.codigo_idea, " - ", ideas.nombre_proyecto) AS nombre_idea')
    ->selectRaw('GROUP_CONCAT(users.documento, " - ", users.nombres, " ", users.apellidos SEPARATOR "; ") AS talentos')
    ->selectRaw('IF(art_cti = 1, nom_act_cti, "No Aplica") AS nom_act_cti')
    ->selectRaw('IF(video_tutorial = 1, url_videotutorial, "No Aplica") AS url_videotutorial')
    ->selectRaw('IF(revisado_final = '. ArticulacionProyecto::IsPorEvaluar() .', "Por Evaluar", IF(revisado_final = '. ArticulacionProyecto::IsAprobado() .', "Aprobado", "No Aprobado")) AS revisado_final')
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
    ->join('articulacion_proyecto_talento', 'articulacion_proyecto_talento.articulacion_proyecto_id', '=', 'articulacion_proyecto.id')
    ->join('talentos', 'talentos.id', '=', 'articulacion_proyecto_talento.talento_id')
    ->join('users', 'users.id', '=', 'talentos.user_id')
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
   * Consulta la cantidad de proyectos que se inscriben por mes de un año y un nodo
   *
   * @param int $id Id del nodo
   * @param string $anho Año para filtrar
   * @return Collection
   */
  public function proyectosInscritosPorMesDeUnNodo_Repository($id, $anho)
  {
    $this->traducirMeses();
    return Proyecto::selectRaw('count(proyectos.id) AS cantidad')
    ->selectRaw('MONTH(actividades.fecha_inicio) AS meses')
    ->selectRaw('CONCAT(UPPER(LEFT(date_format(actividades.fecha_inicio, "%M"), 1)), LOWER(SUBSTRING(date_format(actividades.fecha_inicio, "%M"), 2))) AS mes')
    ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'proyectos.articulacion_proyecto_id')
    ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
    ->join('nodos', 'nodos.id', '=', 'actividades.nodo_id')
    ->whereYear('fecha_inicio', $anho)
    ->where('nodos.id', $id)
    ->where('estado_aprobacion', Proyecto::IsAceptado())
    ->groupBy('meses', 'mes')
    ->orderBy('meses')
    ->get();
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
    foreach($request->get('talentos') as $id => $value){
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

    DB::beginTransaction();
    try {

      $entidad_id = "";
      $otro_tipoarticulacion = "";
      $universidad_proyecto = "";
      $economia_naranja = 1;
      $art_cti = 1;
      $diri_ar_emp = 1;
      $reci_ar_emp = 1;
      $dine_reg = 1;
      $nom_act_cti = "";

      if (
        request()->txttipoarticulacionproyecto_id == TipoArticulacionProyecto::where('nombre', 'Otro')->first()->id ||
        request()->txttipoarticulacionproyecto_id == TipoArticulacionProyecto::where('nombre', 'Proyecto financiado por SENNOVA')->first()->id ||
        request()->txttipoarticulacionproyecto_id == TipoArticulacionProyecto::where('nombre', 'Emprendedor')->first()->id ||
        request()->txttipoarticulacionproyecto_id == TipoArticulacionProyecto::where('nombre', 'Universidades')->first()->id
      ) {
        $entidad_id = Entidad::all()->where('nombre', 'No Aplica')->last()->id;
      } else {
        $entidad_id = request()->txtentidad_proyecto_id;
      }

      if (request()->txttipoarticulacionproyecto_id == TipoArticulacionProyecto::where('nombre', 'Otro')->first()->id) {
        $otro_tipoarticulacion = request()->txtotro_tipoarticulacion;
      }

      if (request()->txttipoarticulacionproyecto_id == TipoArticulacionProyecto::where('nombre', 'Universidades')->first()->id) {
        $universidad_proyecto = request()->txtuniversidad_proyecto;
      }

      if (!isset(request()->txteconomia_naranja)) {
        $economia_naranja = 0;
      }

      if (!isset(request()->txtarti_cti)) {
        $art_cti = 0;
      }

      if (!isset(request()->txtdiri_ar_emp)) {
        $diri_ar_emp = 0;
      }

      if (!isset(request()->txtreci_ar_emp)) {
        $reci_ar_emp = 0;
      }

      if (!isset(request()->txtdine_rega)) {
        $dine_reg = 0;
      }

      if ($art_cti == 1) {
        $nom_act_cti = request()->txtnom_act_cti;
      }


      /**
      * Array con los datos que se van a modificar de un proyecto, aplica para todos los estado de proyecto
      */
      $dataUpdateProyecto = array();
      $dataActividad2 = array();
      $dataProyecto2 = array();
      $data2 = array();
      /**
      * Array con los datos que se modifican de la tabla de actividades
      */
      $dataActividad = array('nombre' => request()->txtnombre, 'fecha_inicio' => request()->txtfecha_inicio);

      /**
      * Array con los datos que se modifican de la tabla articulacion_proyecto
      */
      $dataUpdateArticulacionProyecto = array('entidad_id' => $entidad_id);

      /**
      * Array con los datos que se modifican de la tabla proyectos
      */
      $dataProyecto = array( 'sector_id' => request()->txtsector_id,
      'sublinea_id' => request()->txtsublinea_id,
      'areaconocimiento_id' => request()->txtareaconocimiento_id,
      'estadoproyecto_id' => request()->txtestadoproyecto_id,
      'tipoarticulacionproyecto_id' => request()->txttipoarticulacionproyecto_id,
      'otro_tipoarticulacion' => $otro_tipoarticulacion,
      'universidad_proyecto' => $universidad_proyecto,
      'observaciones_proyecto' => request()->txtobservaciones_proyecto,
      'impacto_proyecto' => request()->txtimpacto_proyecto,
      'economia_naranja' => $economia_naranja,
      'art_cti' => $art_cti,
      'nom_act_cti' => $nom_act_cti,
      'diri_ar_emp' => $diri_ar_emp,
      'reci_ar_emp' => $reci_ar_emp,
      'dine_reg' => $dine_reg );

      if ( $request->txtestadoproyecto_id == EstadoProyecto::where('nombre', 'Cierre PF')->first()->id || $request->txtestadoproyecto_id == EstadoProyecto::where('nombre', 'Cierre PMV')->first()->id || $request->txtestadoproyecto_id == EstadoProyecto::where('nombre', 'Suspendido')->first()->id ) {
        /**
        * Se añaden al array los campos que se van a modificar si el proyecto se va a cerrar
        */
        $dataActividad2 = array('fecha_cierre' => request()->txtfecha_fin);
        $dataProyecto2 = array('estadoprototipo_id' => request()->txtestadoprototipo_id,
        'otro_estadoprototipo' => request()->txtotro_estadoprototipo,
        'resultado_proyecto' => request()->txtresultado_proyecto);

      }

      $dataUpdateActividad = array_merge($dataActividad, $dataActividad2);

      $dataUpdateProyecto = array_merge($dataProyecto, $dataProyecto2);

      $proyecto = Proyecto::find($id);
      /**
      * Update para la tabla de actividades
      */
      $proyecto->articulacion_proyecto->actividad()->update($dataUpdateActividad);

      /**
      * Update para la tabla de articulacion_proyecto
      */
      $proyecto->articulacion_proyecto()->update(['entidad_id' => $entidad_id]);

      /**
      * Update para la tabla de proyectos
      */
      $proyecto->update($dataUpdateProyecto);

      $syncData = $this->arraySyncTalentosDeUnProyecto($request);

      $proyecto->articulacion_proyecto->talentos()->sync($syncData, true);
      DB::commit();
      return true;
    } catch (\Exception $e) {
      DB::rollback();
      return false;
    }

  }

  /**
  * Modifica el revisado final de un proyecto (Lo hace el dinamizador)
  * @param Request $request
  * @param int $id Id del proyecto
  * @return boolean
  * @author dum
  */
  public function updateRevisadoFinalProyectoRepository($request, $id)
  {
    DB::beginTransaction();
    try {
      $proyectoFindById = Proyecto::find($id);
      $proyectoFindById->articulacion_proyecto()->update([
      'revisado_final' => $request->txtrevisado_final
      ]);

      DB::commit();
      return true;
    } catch (Exception $e) {
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
  public function updateEntregablesProyectoRepository($request, $id)
  {
    DB::beginTransaction();
    try {
      $acc = 1;
      $manual_uso_inf = 1;
      $acta_inicio = 1;
      $estado_arte = 1;
      $actas_seguimiento = 1;
      $video_tutorial = 1;
      $url_videotutorial = "";
      $ficha_caracterizacion = 1;
      $acta_cierre = 1;
      $encuesta = 1;

      if ( !isset($request->txtacc) ) {
        $acc = 0;
      }

      if ( !isset($request->txtmanual_uso_inf) ) {
        $manual_uso_inf = 0;
      }

      if ( !isset($request->txtacta_inicio) ) {
        $acta_inicio = 0;
      }

      if ( !isset($request->txtestado_arte) ) {
        $estado_arte = 0;
      }

      if ( !isset($request->txtactas_seguimiento) ) {
        $actas_seguimiento = 0;
      }

      if ( !isset($request->txtvideo_tutorial) ) {
        $video_tutorial = 0;
      }

      if ( !isset($request->txtficha_caracterizacion) ) {
        $ficha_caracterizacion = 0;
      }

      if ( !isset($request->txtacta_cierre) ) {
        $acta_cierre = 0;
      }

      if ( !isset($request->txtencuesta) ) {
        $encuesta = 0;
      }

      if ( $video_tutorial == 1 ) {
        $url_videotutorial = $request->txturl_videotutorial;
      }

      $proyectoFindById = Proyecto::find($id);

      /**
      * Modifica los datos de la tabla articulacion_proyecto
      */
      $proyectoFindById->articulacion_proyecto()->update([
        'acta_inicio' => $acta_inicio,
        'actas_seguimiento' => $actas_seguimiento,
        'acta_cierre' => $acta_cierre
      ]);

      /**
      * Modifica los datos de la tabla proyectos
      */
      $proyectoFindById->update([
      'acc' => $acc,
      'manual_uso_inf' => $manual_uso_inf,
      'estado_arte' => $estado_arte,
      'video_tutorial' => $video_tutorial,
      'url_videotutorial' => $url_videotutorial,
      'ficha_caracterizacion' => $ficha_caracterizacion,
      'encuesta' => $encuesta
      ]);

      DB::commit();
      return true;
    } catch (Exception $e) {
      DB::rollback();
      return false;
    }
  }

  /**
  * Consulta los entregables de un proyecto
  * @param int $id Id del proyecto
  * @return Collection
  * @author dum
  */
  public function consultarEntregablesDeUnProyectoRepository($id)
  {
    return Proyecto::select('acc',
    'manual_uso_inf',
    // Fase de planeación
    'acta_inicio',
    'estado_arte',
    // Fase de ejecución
    'actas_seguimiento',
    'video_tutorial',
    // Fase de Cierre
    'ficha_caracterizacion',
    'acta_cierre',
    'encuesta',
    'lecciones_aprendidas')
    ->where('proyectos.id', $id)
    ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'proyectos.articulacion_proyecto_id')
    ->get()
    ->last();
  }

  /**
  * Modifica el gestor a cargo de un proyecto (Lo hace el dinamizador)
  * @param Request $request
  * @param int $id Id del Proyectos
  * @return boolean
  * @author dum
  */
  public function updateProyectoDinamizadorRepository($request, $id)
  {
    DB::beginTransaction();
    try {
      $proyectoFindById = Proyecto::find($id);
      $proyectoFindById->articulacion_proyecto->actividad()->update([
      'gestor_id' => request()->txtgestor_id,
      ]);
      DB::commit();
      return true;
    } catch (Exception $e) {
      DB::rollback();
      return false;
    }
  }

  /**
  * Consulta los proyectos que tiene un nodo por años
  * @param int $idnodo Id del nodo
  * @param string $anho Año para fitrar la búsqueda
  * @return Collection
  * @author dum
  */
  public function ConsultarProyectosPorNodoYPorAnho($idnodo, $anho)
  {
    return Proyecto::select('actividades.codigo_actividad AS codigo_proyecto',
    'actividades.nombre',
    'sublineas.nombre AS sublinea_nombre',
    'estadosproyecto.nombre AS estado_nombre',
    'areasconocimiento.nombre AS nombre_areaconocimiento',
    'tiposarticulacionesproyectos.nombre AS nombre_tipoarticulacion',
    'actividades.fecha_cierre AS fecha_fin',
    'articulacion_proyecto.id AS articulacion_proyecto_id',
    'lineastecnologicas.nombre AS nombre_linea',
    'sectores.nombre AS nombre_sector',
    'fecha_inicio',
    'fecha_cierre',
    'observaciones_proyecto',
    'impacto_proyecto',
    'resultado_proyecto',
    'economia_naranja',
    'art_cti',
    'diri_ar_emp',
    'reci_ar_emp',
    'dine_reg',
    'acc',
    'manual_uso_inf',
    'acta_inicio',
    'estado_arte',
    'actas_seguimiento',
    'video_tutorial',
    'url_videotutorial',
    'ficha_caracterizacion',
    'acta_cierre',
    'estado_aprobacion',
    'encuesta',
    'proyectos.id')
    ->selectRaw('IF(revisado_final = ' . ArticulacionProyecto::IsPorEvaluar() . ', "Por Evaluar", IF(revisado_final = ' . ArticulacionProyecto::IsAprobado() . ', "Aprobado", "No Aprobado") ) AS revisado_final')
    ->selectRaw('CONCAT(users.nombres, " ", users.apellidos) AS gestor')
    ->selectRaw('CONCAT(ideas.codigo_idea, " - ", ideas.nombre_proyecto) AS nombre_idea')
    ->selectRaw('GROUP_CONCAT(user_talento.documento, " - ", user_talento.nombres, " ", user_talento.apellidos SEPARATOR "; ") AS talentos')
    ->selectRaw('IF(art_cti = 1, nom_act_cti, "No Aplica") AS nom_act_cti')
    ->join('articulacion_proyecto', 'articulacion_proyecto.id', 'proyectos.articulacion_proyecto_id')
    ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
    ->join('gestores', 'gestores.id', '=', 'actividades.gestor_id')
    ->join('estadosproyecto', 'estadosproyecto.id', '=', 'proyectos.estadoproyecto_id')
    ->join('sublineas', 'sublineas.id', '=', 'proyectos.sublinea_id')
    ->join('users', 'users.id', '=', 'gestores.user_id')
    ->join('nodos', 'nodos.id', '=', 'actividades.nodo_id')
    ->join('ideas', 'ideas.id', '=', 'proyectos.idea_id')
    ->join('sectores', 'sectores.id', '=', 'proyectos.sector_id')
    ->join('lineastecnologicas', 'lineastecnologicas.id', '=', 'sublineas.lineatecnologica_id')
    ->join('articulacion_proyecto_talento', 'articulacion_proyecto_talento.articulacion_proyecto_id', '=', 'articulacion_proyecto.id')
    ->join('talentos', 'talentos.id', '=', 'articulacion_proyecto_talento.talento_id')
    ->join('users AS user_talento', 'user_talento.id', '=', 'talentos.user_id')
    ->join('areasconocimiento', 'areasconocimiento.id', '=', 'proyectos.areaconocimiento_id')
    ->join('tiposarticulacionesproyectos', 'tiposarticulacionesproyectos.id', '=', 'proyectos.tipoarticulacionproyecto_id')
    ->where('nodos.id', $idnodo)
    ->where('estado_aprobacion', Proyecto::IsAceptado())
    ->where(function($q) use ($anho) {
      $q->where(function($query) use ($anho) {
        $query->whereYear('actividades.fecha_cierre', '=', $anho)
        ->whereIn('estadosproyecto.nombre', ['Cierre PF', 'Cierre PMV', 'Suspendido']);
      })
      ->orWhere(function($query) {
        $query->whereIn('estadosproyecto.nombre', ['Inicio', 'Planeacion', 'En ejecución']);
      });
    })
    ->groupBy('proyectos.id')
    ->get();
  }

  /**
  * Consulta los detalle de un proyecto por su id
  * @param int $id Id del proyecto
  * @return Collection
  * @author dum
  */
  public function consultarDetallesDeUnProyectoRepository($id)
  {
    return Proyecto::select('sectores.nombre AS nombre_sector',
    'areasconocimiento.nombre AS nombre_areaconocimiento',
    'estadosproyecto.nombre AS nombre_estadoproyecto',
    'tiposarticulacionesproyectos.nombre AS nombre_tipoarticulacion',
    'actividades.nombre',
    'actividades.codigo_actividad AS codigo_proyecto',
    'proyectos.observaciones_proyecto',
    'proyectos.id',
    'proyectos.impacto_proyecto',
    'proyectos.resultado_proyecto',
    'actividades.fecha_inicio',
    'entidades.id AS id_entidad',
    'proyectos.sector_id',
    'proyectos.sublinea_id',
    'proyectos.areaconocimiento_id',
    'proyectos.estadoproyecto_id',
    'articulacion_proyecto.entidad_id',
    'proyectos.tipoarticulacionproyecto_id',
    'proyectos.articulacion_proyecto_id',
    'proyectos.otro_tipoarticulacion',
    'actividades.gestor_id',
    'proyectos.estadoprototipo_id',
    'entidades.nombre AS nombreentidad_edit',
    'proyectos.universidad_proyecto AS universidad_proyecto_edit',
    'proyectos.tipo_ideaproyecto',
    'lineastecnologicas.nombre AS nombre_linea',
    'proyectos.idea_id',
    'proyectos.url_videotutorial',
    'sublineas.lineatecnologica_id',
    'proyectos.estado_aprobacion',
    'nodoentidad.nombre AS nombre_nodo')
    ->selectRaw('CONCAT(lineastecnologicas.abreviatura, " - ", sublineas.nombre) AS nombre_sublinea')
    ->selectRaw('CONCAT(ideas.codigo_idea, " - ", ideas.nombre_proyecto) AS nombre_idea')
    ->selectRaw('CONCAT(users.nombres, " ", users.apellidos) AS nombre_gestor')
    ->selectRaw('IF(tiposarticulacionesproyectos.nombre = "Universidades", proyectos.universidad_proyecto,
    IF(tiposarticulacionesproyectos.nombre NOT IN("Emprendedor", "Proyecto financiado por SENNOVA", "Otro"), entidades.nombre, "")) AS nombre_entidad')
    ->selectRaw('IF(estadosprototipos.nombre = "Otro.", otro_estadoprototipo, estadosprototipos.nombre) AS nombre_estadoprototipo')
    ->selectRaw('IF(economia_naranja = 1, "Si", "No") AS economia_naranja')
    ->selectRaw('IF(revisado_final = '.ArticulacionProyecto::IsPorEvaluar().', "Por Evaluar", IF(revisado_final = '.ArticulacionProyecto::IsAprobado().', "Aprobado", "No Aprobado") ) AS revisado_final')
    ->selectRaw('IF(estadosproyecto.nombre IN("Inicio", "Planeacion", "En ejecución"), "El Proyecto aún se está desarrollando", actividades.fecha_cierre) AS fecha_cierre')
    ->selectRaw('IF(art_cti = 1, "Si", "No") AS art_cti')
    ->selectRaw('IF(art_cti = 1, nom_act_cti, "") AS nom_act_cti')
    ->selectRaw('IF(diri_ar_emp = 1, "Si", "No") AS diri_ar_emp')
    ->selectRaw('IF(reci_ar_emp = 1, "Si", "No") AS reci_ar_emp')
    ->selectRaw('IF(dine_reg = 1, "Si", "No") AS dine_reg')
    ->join('ideas', 'ideas.id', '=', 'proyectos.idea_id')
    ->join('sectores', 'sectores.id', '=', 'proyectos.sector_id')
    ->join('sublineas', 'sublineas.id', '=', 'proyectos.sublinea_id')
    ->join('areasconocimiento', 'areasconocimiento.id', '=', 'proyectos.areaconocimiento_id')
    ->join('estadosproyecto', 'estadosproyecto.id', '=', 'proyectos.estadoproyecto_id')
    ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'proyectos.articulacion_proyecto_id')
    ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
    ->join('gestores', 'gestores.id', '=', 'actividades.gestor_id')
    ->join('entidades', 'entidades.id', '=', 'articulacion_proyecto.entidad_id')
    ->join('tiposarticulacionesproyectos', 'tiposarticulacionesproyectos.id', '=', 'proyectos.tipoarticulacionproyecto_id')
    ->join('estadosprototipos', 'estadosprototipos.id', '=', 'proyectos.estadoprototipo_id')
    ->join('users', 'users.id', '=', 'gestores.user_id')
    ->join('nodos', 'nodos.id', '=', 'gestores.nodo_id')
    ->join('entidades AS nodoentidad', 'nodoentidad.id', '=', 'nodos.entidad_id')
    ->join('lineastecnologicas', 'lineastecnologicas.id', '=', 'sublineas.lineatecnologica_id')
    ->where('proyectos.id', $id)
    ->get()
    ->last();
  }

  /**
  * Consulta los proyectos que tiene un gestor por año
  * @param int $idgestor Id del gestor
  * @param string $anho Año por el que se filtra la consulta
  * @return Collection
  * @author dum
  */
  public function ConsultarProyectosPorGestorYPorAnho($idgestor, $anho)
  {
    return Proyecto::select('actividades.codigo_actividad AS codigo_proyecto',
    'actividades.nombre',
    'areasconocimiento.nombre AS nombre_areaconocimiento',
    'sublineas.nombre AS sublinea_nombre',
    'tiposarticulacionesproyectos.nombre AS nombre_tipoarticulacion',
    'estadosproyecto.nombre AS estado_nombre',
    'articulacion_proyecto.id AS articulacion_proyecto_id',
    'actividades.fecha_cierre AS fecha_fin',
    'lineastecnologicas.nombre AS nombre_linea',
    'sectores.nombre AS nombre_sector',
    'fecha_inicio',
    'fecha_cierre',
    'observaciones_proyecto',
    'impacto_proyecto',
    'resultado_proyecto',
    'economia_naranja',
    'art_cti',
    'diri_ar_emp',
    'reci_ar_emp',
    'dine_reg',
    'acc',
    'manual_uso_inf',
    'acta_inicio',
    'estado_arte',
    'actas_seguimiento',
    'video_tutorial',
    'url_videotutorial',
    'ficha_caracterizacion',
    'estado_aprobacion',
    'acta_cierre',
    'encuesta',
    'proyectos.id')
    ->selectRaw('IF(revisado_final = '.ArticulacionProyecto::IsPorEvaluar().', "Por Evaluar", IF(revisado_final = '.ArticulacionProyecto::IsAprobado().', "Aprobado", "No Aprobado") ) AS revisado_final')
    ->selectRaw('concat(users.documento, " - ", users.nombres, " ", users.apellidos) AS gestor')
    ->selectRaw('concat(ideas.codigo_idea, " - ", ideas.nombre_proyecto) as nombre_idea')
    ->selectRaw('GROUP_CONCAT(user_talento.documento, " - ", user_talento.nombres, " ", user_talento.apellidos SEPARATOR "; ") AS talentos')
    ->selectRaw('IF(art_cti = 1, nom_act_cti, "No Aplica") AS nom_act_cti')
    ->join('estadosproyecto', 'estadosproyecto.id', '=', 'proyectos.estadoproyecto_id')
    ->join('sublineas', 'sublineas.id', '=', 'proyectos.sublinea_id')
    ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'proyectos.articulacion_proyecto_id')
    ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
    ->join('gestores', 'gestores.id', '=', 'actividades.gestor_id')
    ->join('sectores', 'sectores.id', '=', 'proyectos.sector_id')
    ->join('users', 'users.id', '=', 'gestores.user_id')
    ->join('ideas', 'ideas.id', '=', 'proyectos.idea_id')
    ->join('lineastecnologicas', 'lineastecnologicas.id', '=', 'sublineas.lineatecnologica_id')
    ->join('articulacion_proyecto_talento', 'articulacion_proyecto_talento.articulacion_proyecto_id', '=', 'articulacion_proyecto.id')
    ->join('talentos', 'talentos.id', '=', 'articulacion_proyecto_talento.talento_id')
    ->join('users AS user_talento', 'user_talento.id', '=', 'talentos.user_id')
    ->join('areasconocimiento', 'areasconocimiento.id', '=', 'proyectos.areaconocimiento_id')
    ->join('tiposarticulacionesproyectos', 'tiposarticulacionesproyectos.id', '=', 'proyectos.tipoarticulacionproyecto_id')
    ->where('gestores.id', $idgestor)
    ->where('estado_aprobacion', Proyecto::IsAceptado())
    ->where(function($q) use ($anho) {
      $q->where(function($query) use ($anho) {
        $query->whereYear('actividades.fecha_cierre', '=', $anho)
        ->whereIn('estadosproyecto.nombre', ['Cierre PF', 'Cierre PMV', 'Suspendido']);
      })
      ->orWhere(function($query) {
        $query->whereIn('estadosproyecto.nombre', ['Inicio', 'Planeacion', 'En ejecución']);
      });
    })
    ->groupBy('proyectos.id')
    ->get();
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
      $anho = Carbon::now()->isoFormat('YYYY');
      $tecnoparque = sprintf("%02d", auth()->user()->gestor->nodo_id);
      $linea = auth()->user()->gestor->lineatecnologica_id;
      $gestor = sprintf("%03d", auth()->user()->gestor->id);
      $idProyecto = Proyecto::selectRaw('MAX(id+1) AS max')->get()->last();
      $idProyecto->max == null ? $idProyecto->max = 1 : $idProyecto->max = $idProyecto->max;
      $idProyecto->max = sprintf("%04d", $idProyecto->max);
      $otro_tipoarticulacion = "";
      $entidad_id = "";
      $estadoprototipo_id = EstadoPrototipo::all()->where('nombre', 'En desarrollo.')->last()->id;
      $universidad_proyecto = "";
      $economia_naranja = 1;
      $art_cti = 1;
      $diri_ar_emp = 1;
      $reci_ar_emp = 1;
      $dine_reg = 1;
      $tipo_ideaproyecto = 1;

      $this->getIdeaRepository()->updateEstadoIdea(request()->txtidea_id, 'En Proyecto');

      if (!isset(request()->txttipo_ideaproyecto)) {
        $tipo_ideaproyecto = 0;
      }

      if (!isset(request()->txteconomia_naranja)) {
        $economia_naranja = 0;
      }

      if (!isset(request()->txtarti_cti)) {
        $art_cti = 0;
      }

      if (!isset(request()->txtdiri_ar_emp)) {
        $diri_ar_emp = 0;
      }

      if (!isset(request()->txtreci_ar_emp)) {
        $reci_ar_emp = 0;
      }

      if (!isset(request()->txtdine_rega)) {
        $dine_reg = 0;
      }

      if (request()->txttipoarticulacionproyecto_id == TipoArticulacionProyecto::where('nombre', 'Universidades')->first()->id) {
        $universidad_proyecto = request()->txtuniversidad_proyecto;
      }

      if (request()->txttipoarticulacionproyecto_id == TipoArticulacionProyecto::where('nombre', 'Otro')->first()->id) {
        $otro_tipoarticulacion = request()->txtotro_tipoarticulacion;
      }

      if (
      request()->txttipoarticulacionproyecto_id == TipoArticulacionProyecto::where('nombre', 'Otro')->first()->id ||
      request()->txttipoarticulacionproyecto_id == TipoArticulacionProyecto::where('nombre', 'Proyecto financiado por SENNOVA')->first()->id ||
      request()->txttipoarticulacionproyecto_id == TipoArticulacionProyecto::where('nombre', 'Emprendedor')->first()->id ||
      request()->txttipoarticulacionproyecto_id == TipoArticulacionProyecto::where('nombre', 'Universidades')->first()->id
      ) {
        $entidad_id = Entidad::all()->where('nombre', 'No Aplica')->last()->id;
      } else {
        $entidad_id = request()->txtentidad_proyecto_id;
      }


      // dd($anho);
      $codigo = 'P'. $anho . '-' . $tecnoparque . $linea . $gestor . '-' . $idProyecto->max;

      $actividad = Actividad::create([
      'gestor_id' => auth()->user()->gestor->id,
      'nodo_id' => auth()->user()->gestor->nodo_id,
      'codigo_actividad' => $codigo,
      'nombre' => request()->txtnombre,
      'fecha_inicio' => request()->txtfecha_inicio
      ]);

      $articulacion_proyecto = ArticulacionProyecto::create([
      'entidad_id' => $entidad_id,
      'actividad_id' => $actividad->id
      ]);

      $proyecto = Proyecto::create([
      'articulacion_proyecto_id' => $articulacion_proyecto->id,
      'idea_id' => request()->txtidea_id,
      'sector_id' => request()->txtsector_id,
      'sublinea_id' => request()->txtsublinea_id,
      'areaconocimiento_id' => request()->txtareaconocimiento_id,
      'estadoproyecto_id' => request()->txtestadoproyecto_id,
      'tipoarticulacionproyecto_id' => request()->txttipoarticulacionproyecto_id,
      'estadoprototipo_id' => $estadoprototipo_id,
      'tipo_ideaproyecto' => $tipo_ideaproyecto,
      'otro_tipoarticulacion' => $otro_tipoarticulacion,
      'universidad_proyecto' => $universidad_proyecto,
      'observaciones_proyecto' => request()->txtobservaciones_proyecto,
      'impacto_proyecto' => request()->txtimpacto_proyecto,
      'economia_naranja' => $economia_naranja,
      'cedula_acudiente' => request()->txtcedula_acudiente,
      'nombre_acudiente' => request()->txtnombre_acudiente,
      'art_cti' => $art_cti,
      'nom_act_cti' => request()->txtnom_act_cti,
      'diri_ar_emp' => $diri_ar_emp,
      'reci_ar_emp' => $reci_ar_emp,
      'dine_reg' => $dine_reg
      ]);

      $syncData = array();
      $dataAprobacion = array();

      // Array con el gestor del proyecto
      $dataAprobacion[0] = array('user_id' => auth()->user()->id,
      'role_id' => Role::findByName('Gestor')->id,
      'aprobacion' => 0);

      // Array con el talento líder del proyecto
      $dataAprobacion[1] = array('user_id' => Talento::find(request()->get('radioTalentoLider'))->user->id,
      'role_id' => Role::findByName('Talento')->id,
      'aprobacion' => 0);

      // Array con el dinamizador del nodo
      $dataAprobacion[2] = array('user_id' => Nodo::find( auth()->user()->gestor->nodo_id )->dinamizador->id,
      'role_id' => Role::findByName('Dinamizador')->id,
      'aprobacion' => 0);

      $syncData = $this->arraySyncTalentosDeUnProyecto($request);

      $proyecto->users()->sync($dataAprobacion, false);
      $articulacion_proyecto->talentos()->sync($syncData, false);

      $idUsers = array();
      for ($i=0; $i < 2 ; $i++) {
        $idUsers[$i] = $dataAprobacion[$i]['user_id'];
      }

      $idUsers = array_unique($idUsers);

      for ($i=0; $i < count($idUsers) ; $i++) {
        Notification::send(User::find($idUsers[$i]), new ProyectoPendiente($proyecto));
      }

      DB::commit();
      return true;
    } catch (Exception $e) {
      DB::rollback();
      return false;
    }

  }

  /*========================================================================
  =            metodo para consultar los proyectos de un gestor            =
  ========================================================================*/

  public function getProjectsForGestor($id, array $estado = [])
  {
    return Proyecto::projectsForEstado($estado)->where('gestor_id', $id)->orderby('nombre')->get();
  }


  /*=====  End of metodo para consultar los proyectos de un gestor  ======*/

}
