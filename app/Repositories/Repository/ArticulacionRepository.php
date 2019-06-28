<?php

namespace App\Repositories\Repository;

use Illuminate\Support\Facades\DB;
// use App\Models\ArchivoComite;
use App\Models\Articulacion;
use Carbon\Carbon;

class ArticulacionRepository
{

  // Crea un articulación
  public function create($request)
  {
    $anho = Carbon::now()->isoFormat('YYYY');
    $tecnoparque = sprintf("%02d", auth()->user()->gestor->nodo_id);
    $linea = auth()->user()->gestor->lineatecnologica_id;
    $gestor = sprintf("%03d", auth()->user()->gestor->id);
    $idArticulacion = Articulacion::selectRaw('MAX(id+1) AS max')->get()->last();
    $idArticulacion->max == null ? $idArticulacion->max = 1 : $idArticulacion->max = $idArticulacion->max;
    $idArticulacion->max = sprintf("%04d", $idArticulacion->max);

    // dd($anho);
    $codigo = 'A'. $anho . '-' . $tecnoparque . $linea . $gestor . '-' . $idArticulacion->max;

    // dd($linea);
    DB::beginTransaction();
    try {
      // 'entidad_id' => request()->
      // 'tipoarticulacion_id' => request()->
      // 'gestor_id' => request()->
      // 'tipogrupo' => request()->
      // 'codigo_articulacion' => request()->
      // 'nombre' => request()->
      // 'tipo_articulacion' => request()->
      // 'fecha_inicio' => request()->
      // 'fecha_ejecucion' => request()->
      // 'fecha_cierre' => request()->
      // 'observaciones' => request()->
      // 'estado' => request()->
      $nodo = Articulacion::create([
        'centro_id' => $request->input('txtcentro'),
        'nombre' => $request->input('txtnombre'),
        'direccion' => $request->input('txtdireccion'),
        'anho_inicio' => Carbon::now()->format('Y'),
      ]);
      $nodo->lineas()->sync($request->get('txtlineas'), false);

      DB::commit();
      return true;
    } catch (Exception $e) {
      DB::rollback();
      return false;
    }

  }

}
