<?php

namespace App\Repositories\Repository;

use Illuminate\Support\Facades\DB;
use App\Models\{Proyecto, Entidad, EstadoPrototipo, TipoArticulacionProyecto};
use Carbon\Carbon;

class ProyectoRepository
{

  public $ideaRepository;

  public function __construct(IdeaRepository $ideaRepository)
  {
    $this->ideaRepository = $ideaRepository;
  }

  /**
   * Método el cuál actualiza ALGUNOS campos de la tabla de proyecto
   *
   * @param int id - Id del proyecto que se va a modificar
   * @param request request Request con los datos del formulario
   * @return return boolean
   */
  public function update($request, $id)
  {
    DB::beginTransaction();
    try {
      $proyecto = Proyecto::find($id);
      $proyecto->update([

      ]);
      DB::commit();
      return true;
    } catch (\Exception $e) {
      DB::rollback();
      return false;
    }

  }

  public function updateRevisadoFinalProyectoRepository($request, $id)
  {
    DB::beginTransaction();
    try {
      $proyectoFindById = Proyecto::find($id);
      $proyectoFindById->update([
        'revisado_final' => $request->txtrevisado_final
      ]);

      DB::commit();
      return true;
    } catch (Exception $e) {
      DB::rollback();
      return false;
    }
  }

  // Modifica los entregables de un proyecto
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

      $proyectoFindById = Proyecto::find($id);
      $proyectoFindById->update([
        'acc' => $acc,
        'manual_uso_inf' => $manual_uso_inf,
        'acta_inicio' => $acta_inicio,
        'estado_arte' => $estado_arte,
        'actas_seguimiento' => $actas_seguimiento,
        'video_tutorial' => $video_tutorial,
        'ficha_caracterizacion' => $ficha_caracterizacion,
        'acta_cierre' => $acta_cierre,
        'encuesta' => $encuesta,
      ]);

      DB::commit();
      return true;
    } catch (Exception $e) {
      DB::rollback();
      return false;
    }
  }

  // Consulta los entregables de un proyecto (Si/No)
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
    ->where('id', $id)
    ->get()
    ->last();
  }

  // Modifica el gestor a cargo del proyecto
  public function updateProyectoDinamizadorRepository($request, $id)
  {
    DB::beginTransaction();
    try {
      $proyectoFindById = Proyecto::find($id);
      $proyectoFindById->update([
        'gestor_id' => request()->txtgestor_id,
      ]);
      DB::commit();
      return true;
    } catch (Exception $e) {
      DB::rollback();
      return false;
    }
  }

  // Consulta los proyectos de un nodo por año
  public function ConsultarProyectosPorNodoYPorAnho($idnodo, $anho)
  {
    return Proyecto::select('proyectos.codigo_proyecto',
    'proyectos.nombre',
    'sublineas.nombre AS sublinea_nombre',
    'estadosproyecto.nombre AS estado_nombre',
    'proyectos.fecha_fin',
    'proyectos.id')
    ->selectRaw('IF(revisado_final = '.Proyecto::IsPorEvaluar().', "Por Evaluar", IF(revisado_final = '.Proyecto::IsAprobado().', "Aprobado", "No Aprobado") ) AS revisado_final')
    ->selectRaw('CONCAT(users.nombres, " ", users.apellidos) AS gestor')
    ->join('gestores', 'gestores.id', '=', 'proyectos.gestor_id')
    ->join('estadosproyecto', 'estadosproyecto.id', '=', 'proyectos.estadoproyecto_id')
    ->join('sublineas', 'sublineas.id', '=', 'proyectos.sublinea_id')
    ->join('users', 'users.id', '=', 'gestores.user_id')
    ->where('proyectos.nodo_id', $idnodo)
    ->where(function($q) use ($anho) {
      $q->where(function($query) use ($anho) {
        $query->whereYear('proyectos.fecha_fin', '=', $anho)
        ->whereIn('estadosproyecto.nombre', ['Cierre PF', 'Cierre PMV', 'Suspendido']);
      })
      ->orWhere(function($query) {
        $query->whereIn('estadosproyecto.nombre', ['Inicio', 'Planeacion', 'En ejecución']);
      });
    })
    ->get();
  }

  // COnsulta la información de un proyecto
  public function consultarDetallesDeUnProyectoRepository($id)
  {
    return Proyecto::select('sectores.nombre AS nombre_sector',
    'areasconocimiento.nombre AS nombre_areaconocimiento',
    'estadosproyecto.nombre AS nombre_estadoproyecto',
    'tiposarticulacionesproyectos.nombre AS nombre_tipoarticulacion',
    'proyectos.nombre',
    'proyectos.codigo_proyecto',
    'proyectos.observaciones_proyecto',
    'proyectos.id',
    'proyectos.impacto_proyecto',
    'proyectos.resultado_proyecto',
    'proyectos.fecha_inicio',
    'entidades.id AS id_entidad',
    'proyectos.sector_id',
    'proyectos.sublinea_id',
    'proyectos.areaconocimiento_id',
    'proyectos.estadoproyecto_id',
    'proyectos.entidad_id',
    'proyectos.tipoarticulacionproyecto_id',
    'proyectos.otro_tipoarticulacion',
    'proyectos.gestor_id',
    'proyectos.estadoprototipo_id',
    'entidades.nombre AS nombreentidad_edit',
    'proyectos.universidad_proyecto AS universidad_proyecto_edit',
    'proyectos.tipo_ideaproyecto',
    'lineastecnologicas.nombre AS nombre_linea',
    'proyectos.idea_id',
    'sublineas.lineatecnologica_id',
    'nodoentidad.nombre AS nombre_nodo')
    ->selectRaw('CONCAT(lineastecnologicas.abreviatura, " - ", sublineas.nombre) AS nombre_sublinea')
    ->selectRaw('CONCAT(ideas.id, " - ", ideas.nombre_proyecto) AS nombre_idea')
    ->selectRaw('CONCAT(users.nombres, " ", users.apellidos) AS nombre_gestor')
    ->selectRaw('IF(tiposarticulacionesproyectos.nombre = "Universidades", proyectos.universidad_proyecto,
    IF(tiposarticulacionesproyectos.nombre NOT IN("Emprendedor", "Proyecto financiado por SENNOVA", "Otro"), entidades.nombre, "")) AS nombre_entidad')
    ->selectRaw('IF(estadosprototipos.nombre = "Otro.", otro_estadoprototipo, estadosprototipos.nombre) AS nombre_estadoprototipo')
    ->selectRaw('IF(economia_naranja = 1, "Si", "No") AS economia_naranja')
    ->selectRaw('IF(revisado_final = '.Proyecto::IsPorEvaluar().', "Por Evaluar", IF(revisado_final = '.Proyecto::IsAprobado().', "Aprobado", "No Aprobado") ) AS revisado_final')
    ->selectRaw('IF(estadosproyecto.nombre IN("Inicio", "Planeacion", "En ejecución"), "El Proyecto aún se está desarrollando", proyectos.fecha_fin) AS fecha_cierre')
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
    ->join('gestores', 'gestores.id', '=', 'proyectos.gestor_id')
    ->join('entidades', 'entidades.id', '=', 'proyectos.entidad_id')
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

  // Consulta los talentos que estan asociados a un proyecto
  public function consultarTalentosDeUnProyectoRepository($id)
  {
    return Proyecto::select('proyectos.codigo_proyecto',
    'proyecto_talento.talento_lider',
    'proyecto_talento.talento_id')
    ->selectRaw('concat(users.documento, " - ", users.nombres, " ", users.apellidos) AS talento')
    ->selectRaw('IF(proyecto_talento.talento_lider = 1, "Talento Líder", "Autor") AS rol')
    ->join('proyecto_talento', 'proyecto_talento.proyecto_id', '=', 'proyectos.id')
    ->join('talentos', 'talentos.id', '=', 'proyecto_talento.talento_id')
    ->join('users', 'users.id', '=', 'talentos.user_id')
    ->where('proyectos.id', $id)
    ->get();
  }

  // Consulta lo proyectos de un gestor por año
  public function ConsultarProyectosPorGestorYPorAnho($idgestor, $anho)
  {
    return
    Proyecto::select('proyectos.codigo_proyecto',
    'proyectos.nombre',
    'sublineas.nombre AS sublinea_nombre',
    'estadosproyecto.nombre AS estado_nombre',
    'proyectos.fecha_fin',
    'proyectos.id')
    ->selectRaw('IF(revisado_final = '.Proyecto::IsPorEvaluar().', "Por Evaluar", IF(revisado_final = '.Proyecto::IsAprobado().', "Aprobado", "No Aprobado") ) AS revisado_final')
    ->selectRaw('concat(users.documento, " - ", users.nombres, " ", users.apellidos) AS gestor')
    ->join('gestores', 'gestores.id', '=', 'proyectos.gestor_id')
    ->join('estadosproyecto', 'estadosproyecto.id', '=', 'proyectos.estadoproyecto_id')
    ->join('sublineas', 'sublineas.id', '=', 'proyectos.sublinea_id')
    ->join('users', 'users.id', '=', 'gestores.user_id')
    ->where('gestores.id', $idgestor)
    ->where(function($q) use ($anho) {
      $q->where(function($query) use ($anho) {
        $query->whereYear('proyectos.fecha_fin', '=', $anho)
        ->whereIn('estadosproyecto.nombre', ['Cierre PF', 'Cierre PMV', 'Suspendido']);
      })
      ->orWhere(function($query) {
        $query->whereIn('estadosproyecto.nombre', ['Inicio', 'Planeacion', 'En ejecución']);
      });
    })
    ->get();
  }

  // Crea un articulación
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

      $this->ideaRepository->updateEstadoIdea(request()->txtidea_id, 'En Proyecto');

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

      $proyecto = Proyecto::create([
        'idea_id' => request()->txtidea_id,
        'sector_id' => request()->txtsector_id,
        'sublinea_id' => request()->txtsublinea_id,
        'areaconocimiento_id' => request()->txtareaconocimiento_id,
        'estadoproyecto_id' => request()->txtestadoproyecto_id,
        'gestor_id' => auth()->user()->gestor->id,
        'entidad_id' => $entidad_id,
        'nodo_id' => auth()->user()->gestor->nodo_id,
        'tipoarticulacionproyecto_id' => request()->txttipoarticulacionproyecto_id,
        'estadoprototipo_id' => $estadoprototipo_id,
        'tipo_ideaproyecto' => $tipo_ideaproyecto,
        'otro_tipoarticulacion' => $otro_tipoarticulacion,
        'universidad_proyecto' => $universidad_proyecto,
        'codigo_proyecto' => $codigo,
        'nombre' => request()->txtnombre,
        'observaciones_proyecto' => request()->txtobservaciones_proyecto,
        'impacto_proyecto' => request()->txtimpacto_proyecto,
        'economia_naranja' => $economia_naranja,
        'fecha_inicio' => request()->txtfecha_inicio,
        'art_cti' => $art_cti,
        'nom_act_cti' => request()->txtnom_act_cti,
        'diri_ar_emp' => $diri_ar_emp,
        'reci_ar_emp' => $reci_ar_emp,
        'dine_reg' => $dine_reg
      ]);

      // dd($proyecto->nombre);
      $syncData = array();
      foreach($request->get('talentos') as $id => $value){
        if ($value == request()->get('radioTalentoLider')) {
          $syncData[$id] = array('talento_lider' => 1, 'talento_id' => $value);
        } else {
          $syncData[$id] = array('talento_lider' => 0, 'talento_id' => $value);
        }
      }
      $proyecto->talentos()->sync($syncData, false);

      DB::commit();
      return true;
    } catch (Exception $e) {
      DB::rollback();
      return false;
    }

  }

}
