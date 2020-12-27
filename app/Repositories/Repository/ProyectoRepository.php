<?php

namespace App\Repositories\Repository;


use App\Models\{Proyecto, Entidad, Fase, Actividad, ArticulacionProyecto, ArchivoArticulacionProyecto, Movimiento, UsoInfraestructura, Role};
use Illuminate\Support\Facades\{DB, Notification, Storage, Session};
use App\Notifications\Proyecto\{ProyectoCierreAprobado, ProyectoAprobarInicio, ProyectoAprobarPlaneacion, ProyectoAprobarEjecucion, ProyectoAprobarCierre, ProyectoAprobarSuspendido, ProyectoSuspendidoAprobado, ProyectoNoAprobarFase};
use Carbon\Carbon;
use App\Events\Proyecto\ProyectoWasntApproved;
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
  public function consultarProyectosFase(string $fase)
  {
    return Proyecto::selectRaw('count(proyectos.id) as cantidad')
    ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'proyectos.articulacion_proyecto_id')
    ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
    ->join('gestores AS g', 'g.id', '=', 'actividades.gestor_id')
    ->join('fases', 'fases.id', '=', 'proyectos.fase_id')
    ->join('nodos', 'nodos.id', '=', 'actividades.nodo_id')
    ->where('fases.nombre', $fase)
    ->where(function ($q) {
      $q->where(function ($query) {
        $query->whereYear('actividades.fecha_cierre', Carbon::now()->isoFormat('YYYY'));
      })
        ->orWhere(function ($query) {
          $query->whereYear('actividades.fecha_inicio', Carbon::now()->isoFormat('YYYY'));
        });
    });
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
      ->selectRaw('IF(fases.nombre = "Cierre", IF(trl_obtenido = 0, "TRL 6", IF(trl_obtenido = 1, "TRL 7", "TRL 8")), "El proyecto no se ha cerrado") AS trl_obtenido')
      ->selectRaw('IF(fases.nombre = "Cierre" || fases.nombre = "Suspendido", fecha_cierre, "El proyecto no se ha cerrado") AS fecha_cierre')
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
          $query->whereBetween('fecha_inicio', [$fecha_inicio, $fecha_cierre]);
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
   * Cambia el gestor de un proyecto
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
