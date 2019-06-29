<?php

namespace App\Repositories\Repository;

use Illuminate\Support\Facades\DB;
// use App\Models\ArchivoComite;
use App\Models\Articulacion;
use App\Models\Entidad;
use Carbon\Carbon;

class ArticulacionRepository
{

  public function consultarArticulacionesDeUnGestor($id)
  {
    return Articulacion::select('codigo_articulacion', 'articulaciones.nombre', 'articulaciones.id')
    ->selectRaw('IF(tipo_articulacion = '.Articulacion::IsGrupo().', "Grupo de Investigación", IF(tipo_articulacion = '.Articulacion::IsEmpresa().', "Empresa", "Emprendedor(es)") ) AS tipo_articulacion')
    ->selectRaw('IF(estado = '.Articulacion::IsInicio().', "Inicio", IF(estado = '.Articulacion::IsEjecucion().', "Ejecución", "Cierre") ) AS estado')
    ->selectRaw('IF(revisado_final = '.Articulacion::IsPorEvaluar().', "Por Evaluar", IF(revisado_final = '.Articulacion::IsAprobado().', "Aprobado", "No Aprobado") ) AS revisado_final')
    ->where('articulaciones.gestor_id', $id)
    ->get();
  }

  // Crea un articulación
  public function create($request)
  {
    // dd($request->get('talentos'));

    // dd($request->get('radioTalentoLider'));
    DB::beginTransaction();
    try {
      $anho = Carbon::now()->isoFormat('YYYY');
      $tecnoparque = sprintf("%02d", auth()->user()->gestor->nodo_id);
      $linea = auth()->user()->gestor->lineatecnologica_id;
      $gestor = sprintf("%03d", auth()->user()->gestor->id);
      $idArticulacion = Articulacion::selectRaw('MAX(id+1) AS max')->get()->last();
      $idArticulacion->max == null ? $idArticulacion->max = 1 : $idArticulacion->max = $idArticulacion->max;
      $idArticulacion->max = sprintf("%04d", $idArticulacion->max);
      $fechaEjecucion = request()->txtfecha_inicio;

      // dd($anho);
      $codigo = 'A'. $anho . '-' . $tecnoparque . $linea . $gestor . '-' . $idArticulacion->max;
      if (request()->group1 == Articulacion::IsGrupo())
      request()->entidad_id = request()->txtgrupo_id;

      if (request()->group1 == Articulacion::IsEmpresa())
      request()->entidad_id = request()->txtempresa_id;

      if (request()->group1 == Articulacion::IsEmprendedor())
      request()->entidad_id = Entidad::all()->where('nombre', 'No Aplica')->last()->id;

      if (request()->txtestado == Articulacion::IsEjecucion()) {
        $fechaEjecucion = Carbon::now()->toDateString();
      }
      $articulacion = Articulacion::create([
        'entidad_id' => request()->entidad_id,
        'tipoarticulacion_id' => request()->txttipoarticulacion_id,
        'gestor_id' => auth()->user()->gestor->id,
        'codigo_articulacion' => $codigo,
        'nombre' => request()->txtnombre,
        'tipo_articulacion' => request()->group1,
        'fecha_inicio' => request()->txtfecha_inicio,
        'fecha_ejecucion' => $fechaEjecucion,
        'observaciones' => request()->txtobservaciones,
        'estado' => request()->txtestado,
      ]);

      if (request()->group1 == Articulacion::IsEmprendedor()) {
        $syncData = array();
        foreach($request->get('talentos') as $id => $value){
          if ($value == request()->get('radioTalentoLider')) {
            $syncData[$id] = array('talento_lider' => 1, 'talento_id' => $value);
          } else {
            $syncData[$id] = array('talento_lider' => 0, 'talento_id' => $value);
          }
        }
        $articulacion->talentos()->sync($syncData, false);
      }

      DB::commit();
      return true;
    } catch (Exception $e) {
      DB::rollback();
      return false;
    }

  }

}
