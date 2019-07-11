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
  // IsPorEvaluar
  // IsAprobado
  // IsNoAprobado
  // Consulta lo proyectos de un gestor por año
  public function ConsultarProyectosPorGestorYPorAnho($idgestor, $anho)
  {
    return Proyecto::select(
      'proyectos.codigo_proyecto',
      'proyectos.nombre',
      'sublineas.nombre AS sublinea_nombre'
      )
      ->selectRaw('IF(revisado_final = '.Proyecto::IsPorEvaluar().', "Por Evaluar", IF(revisado_final = '.Proyecto::IsAprobado().', "Aprobado", "No Aprobado") ) AS revisado_final')
      ->join('gestores', 'gestores.id', '=', 'proyectos.gestor_id')
      ->join('estadosproyecto', 'estadosproyecto.id', '=', 'proyectos.estadoproyecto_id')
      ->join('sublineas', 'sublineas.id', '=', 'proyectos.sublinea_id')
      ->where([
        ['gestores.id', $idgestor],
      ])
      ->whereIn('estadosproyecto.nombre', ['Inicio', 'Planeacion', 'En ejecucion'])
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

      $this->ideaRepository->updateEstadoIdea(request()->txtidea_id, 'En Proyecto');

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
        'otro_tipoarticulacion' => request()->$otro_tipoarticulacion,
        'universidad_proyecto' => request()->$universidad_proyecto,
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
