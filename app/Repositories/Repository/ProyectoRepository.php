<?php

namespace App\Repositories\Repository;


use App\Models\{Proyecto, Entidad, Fase, Actividad, ArticulacionProyecto, ArchivoArticulacionProyecto, Movimiento, UsoInfraestructura, Role, Idea, EstadoIdea};
use Illuminate\Support\Facades\{DB, Notification, Storage, Session};
use App\Notifications\Proyecto\{ProyectoCierreAprobado, ProyectoAprobarInicio, ProyectoAprobarPlaneacion, ProyectoAprobarEjecucion, ProyectoAprobarCierre, ProyectoAprobarInicioDinamizador, ProyectoAprobarSuspendido, ProyectoSuspendidoAprobado, ProyectoNoAprobarFase};
use Carbon\Carbon;
use App\Events\Proyecto\{ProyectoWasntApproved, ProyectoWasApproved, ProyectoApproveWasRequested};
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
   * Consulta la cantidad de proyectos por fecha de inicio y estados diferente a los de cierre
   * @param string $fecha_inicio Primera fecha para realizar el fitro
   * @param string $fecha_fin Segunda fecha para realizar el filtro
   * @return Builder
   * @author dum
   */
  public function consultarProyectoInscritosEntreFecha($fecha_inicio, $fecha_fin)
  {
    return Proyecto::selectRaw('count(proyectos.id) AS cantidad')
      ->join('fases AS f', 'f.id', '=', 'proyectos.fase_id')
      ->join('articulacion_proyecto AS ap', 'ap.id', '=', 'proyectos.articulacion_proyecto_id')
      ->join('actividades AS a', 'a.id', '=', 'ap.actividad_id')
      ->join('gestores AS g', 'g.id', '=', 'a.gestor_id')
      ->join('nodos', 'nodos.id', '=', 'a.nodo_id')
      ->whereBetween('fecha_inicio', [$fecha_inicio, $fecha_fin]);
  }

  /**
   * Consulta trls esperado entre fechas de inicio
   * @param string $field Trl que se va a consultar
   * @param string $field_date Campo por el que se va a filtrar (fecha)
   * @param string $fecha_inicio
   * @param string $fecha_cierre
   * @return Builder
   * @author dum
   **/
  public function consultarTrl(string $field, string $field_date, string $fecha_inicio, string $fecha_cierre)
  {
    return Proyecto::select($field)
    ->selectRaw('count(proyectos.id) AS cantidad')
    ->join('articulacion_proyecto AS ap', 'ap.id', '=', 'proyectos.articulacion_proyecto_id')
    ->join('actividades AS a', 'a.id', '=', 'ap.actividad_id')
    ->join('gestores AS g', 'g.id', '=', 'a.gestor_id')
    ->join('nodos', 'nodos.id', '=', 'a.nodo_id')
    ->join('fases', 'fases.id', '=', 'proyectos.fase_id')
    ->whereBetween($field_date, [$fecha_inicio, $fecha_cierre])
    ->groupBy($field);
  }

  /**
   * Consulta cantidad de proyectos por fechas de cierre
   * @param string $fase Estado del proyecto que se quiere buscar
   * @param string $fecha_inicio Primera fecha oara realizar el filtro
   * @param string $fecha_fin Segunda fecha para realizar el filtro
   * @return Builder
   * @author dum
   */
  public function consultarProyectoCerradosEntreFecha(string $fase, string $fecha_inicio, string $fecha_fin)
  {
    return Proyecto::selectRaw('count(proyectos.id) as cantidad')
      ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'proyectos.articulacion_proyecto_id')
      ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
      ->join('gestores AS g', 'g.id', '=', 'actividades.gestor_id')
      ->join('fases', 'fases.id', '=', 'proyectos.fase_id')
      ->join('nodos', 'nodos.id', '=', 'actividades.nodo_id')
      ->where('fases.nombre', $fase)
      ->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_fin]);
  }

  /**
   * Consulta cantidad de proyecto por fase
   * @param string $fase Fase que se va a filtrar
   * @return Builder
   * @author dum
   **/
  public function consultarProyectosFase()
  {
    return Proyecto::selectRaw('count(proyectos.id) as cantidad')
    ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'proyectos.articulacion_proyecto_id')
    ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
    ->join('gestores AS g', 'g.id', '=', 'actividades.gestor_id')
    ->join('fases', 'fases.id', '=', 'proyectos.fase_id')
    ->join('nodos', 'nodos.id', '=', 'actividades.nodo_id')
    ->whereIn('fases.nombre', ['Inicio', 'Planeación', 'Ejecución', 'Cierre'])
    ->groupBy('fases.nombre');
  }

  /**
   * Consulta cantidad de proyecto por fase
   * @param string $fase Fase que se va a filtrar
   * @return Builder
   * @author dum
   **/
  public function proyectosSeguimientoCerrados($year)
  {
    return Proyecto::select('fases.nombre AS fase', 'proyectos.id')
    ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'proyectos.articulacion_proyecto_id')
    ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
    ->join('gestores AS g', 'g.id', '=', 'actividades.gestor_id')
    ->join('fases', 'fases.id', '=', 'proyectos.fase_id')
    ->join('sublineas', 'sublineas.id', '=', 'proyectos.sublinea_id')
    ->join('lineastecnologicas', 'lineastecnologicas.id', '=', 'sublineas.lineatecnologica_id')
    ->join('nodos', 'nodos.id', '=', 'actividades.nodo_id')
    ->whereIn('fases.nombre', ['Finalizado', 'Suspendido'])
    ->whereYear('fecha_cierre', $year);
  }


  public function proyectosInscritosPorMes($year)
  {
    $this->traducirMeses();
    return Proyecto::selectRaw('MONTH(fecha_inicio) AS mes, COUNT(proyectos.id) AS cantidad, DATE_FORMAT(fecha_inicio, "%M") AS nombre_mes')
    ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'proyectos.articulacion_proyecto_id')
    ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
    ->join('gestores AS g', 'g.id', '=', 'actividades.gestor_id')
    ->join('fases', 'fases.id', '=', 'proyectos.fase_id')
    ->join('sublineas', 'sublineas.id', '=', 'proyectos.sublinea_id')
    ->join('lineastecnologicas', 'lineastecnologicas.id', '=', 'sublineas.lineatecnologica_id')
    ->join('nodos', 'nodos.id', '=', 'actividades.nodo_id')
    ->whereYear('fecha_inicio', $year)
    ->groupBy("mes", "nombre_mes")
    ->orderBy("mes");
  }

  public function proyectosSeguimientoAbiertos()
  {
    return Proyecto::select('trl_esperado', 'fases.nombre AS fase')
    ->join('articulacion_proyecto AS ap', 'ap.id', '=', 'proyectos.articulacion_proyecto_id')
    ->join('actividades AS a', 'a.id', '=', 'ap.actividad_id')
    ->join('gestores AS g', 'g.id', '=', 'a.gestor_id')
    ->join('nodos', 'nodos.id', '=', 'a.nodo_id')
    ->join('sublineas', 'sublineas.id', '=', 'proyectos.sublinea_id')
    ->join('lineastecnologicas', 'lineastecnologicas.id', '=', 'sublineas.lineatecnologica_id')
    ->join('fases', 'fases.id', '=', 'proyectos.fase_id')
    ->whereIn('fases.nombre', ['Inicio', 'Planeación', 'Ejecución', 'Cierre']);
  }

  public function proyectosIndicadores_Repository(string $fecha_inicio, string $fecha_cierre)
  {
      return Proyecto::with([
          'users_propietarios',
          'gruposinvestigacion',
          'gruposinvestigacion.clasificacioncolciencias',
          'gruposinvestigacion.entidad',
          'sedes',
          'sedes.empresa',
          'sedes.empresa.tamanhoempresa',
          'sedes.empresa.tipoempresa',
          'sedes.empresa',
          'sublinea',
          'sublinea.linea',
          'areaconocimiento',
          'fase',
          'articulacion_proyecto',
          'articulacion_proyecto.talentos',
          'articulacion_proyecto.talentos.user' => function($query) {
            $query->withTrashed();
          },
          'articulacion_proyecto.talentos.user.grupoSanguineo',
          'articulacion_proyecto.talentos.user.eps',
          'articulacion_proyecto.talentos.user.etnia',
          'articulacion_proyecto.talentos.user.gradoescolaridad',
          'articulacion_proyecto.talentos.user.ciudad',
          'articulacion_proyecto.talentos.user.ciudad.departamento',
          'articulacion_proyecto.actividad',
          'articulacion_proyecto.actividad.gestor',
          'articulacion_proyecto.actividad.gestor.user' => function($query) {
            $query->withTrashed();
          },
          'articulacion_proyecto.actividad.nodo',
          'articulacion_proyecto.actividad.nodo.entidad',
          'articulacion_proyecto.proyecto',
          'articulacion_proyecto.proyecto.fase',
          'articulacion_proyecto.proyecto.idea',
        ])->where(function($q) use ($fecha_inicio, $fecha_cierre) {
          $q->whereHas('articulacion_proyecto.actividad', function($query) use ($fecha_inicio, $fecha_cierre) {
            $query->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_cierre]);
          })
          ->orWhere(function($query) use ($fecha_inicio, $fecha_cierre) {
            $query->whereHas('articulacion_proyecto.actividad', function($query) use ($fecha_inicio, $fecha_cierre) {
              $query->whereBetween('fecha_inicio', [$fecha_inicio, $fecha_cierre]);
            })
            ->orWhereHas('articulacion_proyecto.proyecto.fase', function ($query) {
              $query->whereIn('fases.nombre', ['Inicio', 'Planeación', 'Ejecución', 'Cierre']);
            });
          });
        });
  }
  public function proyectosIndicadoresSeparados_Repository()
  {
      return Proyecto::with([
          'users_propietarios',
          'gruposinvestigacion',
          'gruposinvestigacion.clasificacioncolciencias',
          'gruposinvestigacion.entidad',
          'sedes',
          'sedes.empresa',
          'sedes.empresa.tamanhoempresa',
          'sedes.empresa.tipoempresa',
          'sedes.empresa',
          'sublinea',
          'sublinea.linea',
          'areaconocimiento',
          'fase',
          'articulacion_proyecto',
          'articulacion_proyecto.talentos',
          'articulacion_proyecto.talentos.user' => function($query) {
            $query->withTrashed();
          },
          'articulacion_proyecto.talentos.user.grupoSanguineo',
          'articulacion_proyecto.talentos.user.eps',
          'articulacion_proyecto.talentos.user.etnia',
          'articulacion_proyecto.talentos.user.gradoescolaridad',
          'articulacion_proyecto.talentos.user.ciudad',
          'articulacion_proyecto.talentos.user.ciudad.departamento',
          'articulacion_proyecto.actividad',
          'articulacion_proyecto.actividad.gestor',
          'articulacion_proyecto.actividad.gestor.user' => function($query) {
            $query->withTrashed();
          },
          'articulacion_proyecto.actividad.nodo',
          'articulacion_proyecto.actividad.nodo.entidad',
          'articulacion_proyecto.proyecto',
          'articulacion_proyecto.proyecto.fase',
          'articulacion_proyecto.proyecto.idea',
        ]);
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
      ->groupBy('meses', 'mes')
      ->orderBy('meses');
  }

  /**
   * Consulta los proyectos
   * @param string $fecha_inicio
   * @param string $fecha_cierre
   * @return Builder
   * @author dum
   */
  public function consultarProyectos_Repository(string $fecha_inicio = '', string $fecha_cierre = '')
  {
    return Proyecto::select(
      'entidades.nombre AS nodo',
      'actividades.codigo_actividad',
      'actividades.nombre',
      'lineastecnologicas.nombre AS nombre_linea',
      'sublineas.nombre AS nombre_sublinea',
      'areasconocimiento.nombre AS nombre_areaconocimiento',
      'fecha_inicio',
      'fases.nombre AS nombre_fase'
    )
      ->selectRaw('GROUP_CONCAT(propietarios.propietario_type SEPARATOR ",") AS propietarios')
      ->selectRaw('concat(ideas.codigo_idea, " - ", ideas.nombre_proyecto) AS nombre_idea')
      ->selectRaw('concat(users.documento, " - ", users.nombres, " ", users.apellidos) AS gestor')
      ->selectRaw('IF(trl_esperado = '.Proyecto::IsTrl6Esperado().', "TRL 6", "TRL 7 - TRL 8") AS trl_esperado')
      ->selectRaw('IF(fases.nombre = "Finalizado", IF(trl_obtenido = 0, "TRL 6", IF(trl_obtenido = 1, "TRL 7", "TRL 8")), "El proyecto no se ha cerrado") AS trl_obtenido')
      ->selectRaw('IF(fases.nombre = "Finalizado" || fases.nombre = "Suspendido", fecha_cierre, "El proyecto no se ha cerrado") AS fecha_cierre')
      ->selectRaw('IF(areasconocimiento.nombre = "Otro", otro_areaconocimiento, "No aplica") AS otro_areaconocimiento')
      ->selectRaw('IF(fabrica_productividad = 0, "No", "Si") AS fabrica_productividad')
      ->selectRaw('IF(reci_ar_emp = 0, "No", "Si") AS reci_ar_emp')
      ->selectRaw('IF(economia_naranja = 0, "No", "Si") AS economia_naranja')
      ->selectRaw('IF(economia_naranja = 0, "No aplica", tipo_economianaranja) AS tipo_economianaranja')
      ->selectRaw('IF(dirigido_discapacitados = 0, "No", "Si") AS dirigido_discapacitados')
      ->selectRaw('IF(dirigido_discapacitados = 0, "No aplica", tipo_discapacitados) AS tipo_discapacitados')
      ->selectRaw('IF(art_cti = 0, "No", "Si") AS art_cti')
      ->selectRaw('IF(art_cti = 0, "No aplica", nom_act_cti) AS nom_act_cti')
      ->selectRaw('IF(fases.nombre = "Cierre", IF(diri_ar_emp = 0, "No", "Si"), "El proyecto no se ha cerrado") AS diri_ar_emp')
      ->selectRaw('DATE_FORMAT(fecha_cierre, "%Y") AS anho')
      ->selectRaw('DATE_FORMAT(fecha_cierre, "%m") AS mes')
      ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'proyectos.articulacion_proyecto_id')
      ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
      ->join('nodos', 'nodos.id', '=', 'actividades.nodo_id')
      ->join('entidades', 'entidades.id', '=', 'nodos.entidad_id')
      ->join('ideas', 'ideas.id', '=', 'proyectos.idea_id')
      ->join('sublineas', 'sublineas.id', '=', 'proyectos.sublinea_id')
      ->join('lineastecnologicas', 'lineastecnologicas.id', '=', 'sublineas.lineatecnologica_id')
      ->join('areasconocimiento', 'areasconocimiento.id', '=', 'proyectos.areaconocimiento_id')
      ->join('fases', 'fases.id', '=', 'proyectos.fase_id')
      ->join('gestores', 'gestores.id', '=', 'actividades.gestor_id')
      ->join('users', 'users.id', '=', 'gestores.user_id')
      ->leftJoin('propietarios', 'propietarios.proyecto_id', '=', 'proyectos.id')
      ->where(function($q) use ($fecha_inicio, $fecha_cierre) {
        $q->where(function($query) use ($fecha_inicio, $fecha_cierre) {
          $query->whereBetween('fecha_cierre', [$fecha_inicio, $fecha_cierre]);
        })
        ->orWhere(function($query) use ($fecha_inicio, $fecha_cierre) {
          $query->where(function($query) use ($fecha_inicio, $fecha_cierre) {
          $query->whereBetween('fecha_inicio', [$fecha_inicio, $fecha_cierre]);
          $query->orWhere(function ($query) {
            $query->whereIn('fases.nombre', ['Inicio', 'Planeación', 'Ejecución', 'Cierre']);
          });
        });
        });
      })
      ->groupBy('codigo_actividad', 'actividades.nombre')
      ->orderBy('entidades.nombre');
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

      ArticulacionProyecto::habilitarTalentos($proyecto->articulacion_proyecto);

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
      $proyecto->sedes()->detach();
      $proyecto->gruposinvestigacion()->detach();

      $proyecto->users_propietarios()->attach(request()->propietarios_user);
      $proyecto->sedes()->attach(request()->propietarios_sedes);
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
   * Cambia el experto de un proyecto
   *
   * @param Request $request
   * @param int $id id del proyecto
   * @return boolean
   * @author dum
   **/
  public function updateGestor($request, $id)
  {
    DB::beginTransaction();
    try {
      $proyecto = Proyecto::findOrFail($id);

      if ($proyecto->articulacion_proyecto->actividad->gestor_id != $request->txtgestor_id) {
        $proyecto->articulacion_proyecto->actividad->movimientos()->attach(Movimiento::where('movimiento', 'Cambió')->first(), [
          'actividad_id' => $proyecto->articulacion_proyecto->actividad->id,
          'user_id' => auth()->user()->id,
          'fase_id' => $proyecto->fase_id,
          'role_id' => Role::where('name', Session::get('login_role'))->first()->id
        ]);
      }


      $proyecto->articulacion_proyecto->actividad()->update([
        'gestor_id' => $request->txtgestor_id 
      ]);

      DB::commit();
      return true;
    } catch (\Throwable $th) {
      DB::rollBack();
      return false;
    }
  }

  /**
   * Reversa la fase de un proyecto
   *
   * @param Proyecto $proyecto Proyecto
   * @param string $fase Fase a la que se reversa el proyecto
   * @return boolean
   * @author dum
   **/
  public function reversarProyecto(Proyecto $proyecto, string $fase)
  {
    DB::beginTransaction();
    try {

      $proyecto->articulacion_proyecto->actividad->movimientos()->attach(Movimiento::where('movimiento', 'Reversó')->first(), [
        'actividad_id' => $proyecto->articulacion_proyecto->actividad->id,
        'user_id' => auth()->user()->id,
        'fase_id' => $proyecto->fase_id,
        'role_id' => Role::where('name', Session::get('login_role'))->first()->id,
        'comentarios' => $fase
      ]);

      $proyecto->update([
        'fase_id' => Fase::where('nombre', $fase)->first()->id
      ]);

      $proyecto->articulacion_proyecto()->update([
        'aprobacion_dinamizador_suspender' => 0
      ]);

      if ($fase == 'Inicio' || $fase == 'Planeación' || $fase == 'Ejecución') {
        $this->reversarAInicioPlaneacionEjecucion($proyecto);
      }

      DB::commit();
      return true;
    } catch (\Throwable $th) {
      DB::rollBack();
      return false;
    }
  }

  /**
   * Reversa un proyecto a la fase de inicio ó planeación
   *
   * @param Proyecto $proyecto
   * @return void
   * @author dum
   **/
  private function reversarAInicioPlaneacionEjecucion(Proyecto $proyecto)
  {
    $proyecto->articulacion_proyecto()->update([
      'aprobacion_dinamizador_ejecucion' => 0
    ]);

    $proyecto->articulacion_proyecto->actividad()->update([
      'aprobacion_dinamizador' => 0
    ]);
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
   * Envia notificación y correo cuando el dinamizador no aprueba una fase del proyecto.
   *
   * @param Request $request
   * @param int $id Id del proyecto
   * @param string $fase Fase que no se está aprobando
   * @return boolean
   * @author dum
   **/
  public function noAprobarFaseProyecto($request, int $id, string $fase)
  {
    $proyecto = Proyecto::findOrFail($id);
    $proyecto->articulacion_proyecto->actividad->movimientos()->attach(Movimiento::where('movimiento', 'no aprobó')->first(), [
      'actividad_id' => $proyecto->articulacion_proyecto->actividad->id,
      'user_id' => auth()->user()->id,
      'fase_id' => Fase::where('nombre', $fase)->first()->id,
      'role_id' => Role::where('name', Session::get('login_role'))->first()->id,
      'comentarios' => $request->motivosNoAprueba
    ]);
  
    $movimiento = Actividad::consultarHistoricoActividad($proyecto->articulacion_proyecto->actividad->id)->get()->last();
    event(new ProyectoWasntApproved($proyecto, $movimiento));
    Notification::send($proyecto->articulacion_proyecto->actividad->gestor->user, new ProyectoNoAprobarFase($proyecto, $movimiento));
    DB::beginTransaction();
    try {

      DB::commit();
      return true;
    } catch (\Throwable $th) {
      DB::rollBack();
      return false;
    }
  }

  /**
   * Aprueba la fase según el rol y fase que se está aprobando
   * 
   * @param $request
   * @param $id Id del proyecto
   * @param $fase Fase que se está aprobando
   */
  public function aprobacionFaseInicio($request, $id, $fase)
  {
    try {
      
      $comentario = null;
      $movimiento = null;
      $mensaje = null;
      $title = null;
  
      $proyecto = Proyecto::findOrFail($id);
      $dinamizadorRepository = new DinamizadorRepository;
      $dinamizadores = $dinamizadorRepository->getAllDinamizadoresPorNodo($proyecto->articulacion_proyecto->actividad->nodo_id)->get();
      $destinatarios = $dinamizadorRepository->getAllDinamizadorPorNodoArray($dinamizadores);
      array_push($destinatarios, ['email' => $proyecto->articulacion_proyecto->actividad->gestor->user->email]);
      $talento_lider = $proyecto->articulacion_proyecto->talentos()->wherePivot('talento_lider', 1)->first();
      $talento_lider = $talento_lider->user;
      
      if ($request->decision == 'rechazado') {
        $title = 'Aprobación rechazada!';
        $mensaje = 'Se le han notificado al experto los motivos por los cuales no se aprueba el cambio de fase del proyecto';
        $comentario = $request->motivosNoAprueba;
        $movimiento = Movimiento::IsNoAprobar();
        
        $this->crearMovimiento($proyecto, $fase, $movimiento, $comentario);
        // Recuperar el útlimo registro de movimientos ya que el método attach no retorna nada
        $regMovimiento = Actividad::consultarHistoricoActividad($proyecto->articulacion_proyecto->actividad->id)->get()->last();
        // Envio de un correo informando porque no se aprobó el cambio de fase
        event(new ProyectoWasntApproved($proyecto, $regMovimiento));
        Notification::send($proyecto->articulacion_proyecto->actividad->gestor->user, new ProyectoNoAprobarFase($proyecto, $regMovimiento));
        
      } else {
        $title = 'Aprobación Exitosa!';
        $mensaje = 'Se ha aprobado la fase de ' . $fase . ' de este proyecto';
        $movimiento = Movimiento::IsAprobar();
  
        $this->crearMovimiento($proyecto, $fase, $movimiento, $comentario);
        $regMovimiento = Actividad::consultarHistoricoActividad($proyecto->articulacion_proyecto->actividad->id)->get()->last();
        
        event(new ProyectoWasApproved($proyecto, $regMovimiento, $destinatarios));
        if (Session::get('login_role') == User::IsTalento()) {
          Notification::send($dinamizadores, new ProyectoAprobarInicioDinamizador($proyecto, $talento_lider, $regMovimiento));
        }
        if (Session::get('login_role') == User::IsDinamizador() && $fase == "Inicio") {
          // Cambiar el proyecto de fase
          $proyecto->update([
            'fase_id' => Fase::where('nombre', 'Planeación')->first()->id
          ]);
        }
        if (Session::get('login_role') == User::IsDinamizador() && $fase == "Planeación") {
          // Cambiar el proyecto de fase
          $proyecto->update([
            'fase_id' => Fase::where('nombre', 'Ejecución')->first()->id
          ]);
        }
        if (Session::get('login_role') == User::IsDinamizador() && $fase == "Ejecución") {
          // Cambiar el proyecto de fase
          $proyecto->update([
            'fase_id' => Fase::where('nombre', 'Cierre')->first()->id
          ]);
        }
        if (Session::get('login_role') == User::IsDinamizador() && $fase == "Cierre") {
          // Cambiar el proyecto de fase
          $proyecto->update([
            'fase_id' => Fase::where('nombre', 'Finalizado')->first()->id
          ]);
          // Asignar la fecha de cierre el día actuyal
          $proyecto->articulacion_proyecto->actividad()->update([
            'fecha_cierre' => Carbon::now()
          ]);
          // Crear el movimiento con el cierre del proyecto
          $this->crearMovimiento($proyecto, 'Finalizado', 'Cerró', null);
        }
      }
      DB::commit();
      return [
        'state' => true,
        'mensaje' => $mensaje,
        'title' => $title
      ];
    } catch (\Throwable $th) {
      DB::rollBack();
      return [
        'state' => false,
        'mensaje' => 'No se ha aprobado la fase de inicio del proyecto',
        'title' => 'Aprobación errónea'
      ];
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

  private function crearMovimiento($proyecto, $fase, $movimiento, $comentario)
  {
    $proyecto->articulacion_proyecto->actividad->movimientos()->attach(Movimiento::where('movimiento', $movimiento)->first(), [
      'actividad_id' => $proyecto->articulacion_proyecto->actividad->id,
      'user_id' => auth()->user()->id,
      'fase_id' => Fase::where('nombre', $fase)->first()->id,
      'role_id' => Role::where('name', Session::get('login_role'))->first()->id,
      'comentarios' => $comentario
    ]);
  }

  /**
   * Notifica al dinamizador para que apruebe el proyecto en la fase de inicio
   * 
   * @param int $id Id del proyecto
   * @return boolean
   * @author dum
   */
  public function notificarAlTalento_Inicio(int $id, string $fase)
  {
    DB::beginTransaction();
    try {
      $proyecto = Proyecto::findOrFail($id);
      $talento_lider = $proyecto->articulacion_proyecto->talentos()->wherePivot('talento_lider', 1)->first();
      Notification::send($talento_lider->user, new ProyectoAprobarInicio($proyecto, $fase));
      $this->crearMovimiento($proyecto, $fase, 'solicitó al talento', null);
      $movimiento = Actividad::consultarHistoricoActividad($proyecto->articulacion_proyecto->actividad->id)->get()->last();
      event(new ProyectoApproveWasRequested($proyecto, $talento_lider->user, $movimiento));
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
   * Consulta los proyectos que tiene un experto por año
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
      'proyectos.id',
      'actividades.id AS actividad_id'
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
            ->whereIn('fases.nombre', ['Finalizado', 'Suspendido']);
        })
          ->orWhere(function ($query) {
            $query->whereIn('fases.nombre', ['Inicio', 'Planeación', 'Ejecución', 'Cierre']);
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
  
      $idea = Idea::find(request()->txtidea_id);
      $idea->update([
        'estadoidea_id' => EstadoIdea::where('nombre', EstadoIdea::IsPBT())->first()->id
      ]);
  
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
      $proyecto->sedes()->attach(request()->propietarios_sedes);
      $proyecto->gruposinvestigacion()->attach(request()->propietarios_grupos);
      $proyecto->idea->registrarHistorialIdea(Movimiento::IsRegistrar(), Session::get('login_role'), null, 'como un PBT asociado con el código ' . $actividad->codigo_actividad);

      DB::commit();
      return true;
    } catch (\Exception $e) {
      DB::rollback();
      return false;
    }
  }

  /*========================================================================
  =            metodo para consultar los proyectos de un ususario experto talento         =
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

  public function getProjectsForFaseById(array $relations, array $fase = [])
  {
    return Proyecto::with($relations)->whereHas(
      'fase',
      function ($query) use ($fase) {
        $query->whereIn('id', $fase);
      }
    );
  }
}
