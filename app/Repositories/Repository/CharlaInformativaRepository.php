<?php

namespace App\Repositories\Repository;

use App\Models\{CharlaInformativa};
use Illuminate\Support\Facades\{DB};
use Carbon\Carbon;

class CharlaInformativaRepository
{
  /**
  * consulta los archivos de una edt
  * @param int $id Id de la EDT por el cual se consultaran sus archivos
  * @return Collection
  * @author Victor Manuel Moreno Vega
  */
  public function consultarArchivosDeUnaCharlaInformativaRepository($id)
  {
    return CharlaInformativa::find($id)->rutamodel;
  }

  /**
   * Consulta la informacion de una charla informativa
   * @param int $id Id de la charla informativa
   * @return Collection
   * @author Victor Manuel Moreno Vega
   */
  public function consultarInformacionDeUnaCharlaInformativaRepository($id)
  {
    return CharlaInformativa::select('codigo_charla',
    'encargado',
    'charlasinformativas.id',
    'entidades.nombre AS nodo',
    'nro_asistentes',
    'observacion',
    'fecha')
    ->selectRaw('IF(listado_asistentes = 1, "Si", "No") AS listado_asistentes')
    ->selectRaw('IF(evidencia_fotografica = 1, "Si", "No") AS evidencia_fotografica')
    ->selectRaw('IF(programacion = 1, "Si", "No") AS programacion')
    ->join('nodos', 'nodos.id', '=', 'charlasinformativas.nodo_id')
    ->join('entidades', 'entidades.id', '=', 'nodos.entidad_id')
    ->where('charlasinformativas.id', $id)
    ->get()
    ->last();
  }

  /**
   * Consulta las charlas informativas de un nodo
   * @param int $id Id del nodo
   * @return Collection
   */
  public function consultarCharlasInformativasDeUnNodoRepository($id)
  {
    return CharlaInformativa::select('codigo_charla',
    'entidades.nombre AS nodo',
    'nro_asistentes',
    'encargado',
    'charlasinformativas.id',
    'fecha')
    ->selectRaw('IF(charlasinformativas.estado = '.CharlaInformativa::IsActive().', "Activa", "Inactiva") AS estado')
    ->join('nodos', 'nodos.id', '=', 'charlasinformativas.nodo_id')
    ->join('entidades', 'entidades.id', '=', 'nodos.entidad_id')
    ->where('nodos.id', $id)
    ->get();
  }

  /**
   * Registra una nueva charla informativa
   * @param Request $request
   * @return boolean
   */
  public function storeCharlaInformativaRepository($request)
  {
    $codigo_charla = "CI";
    $anho = Carbon::now()->isoFormat('YYYY');
    $tecnoparque = sprintf("%02d", auth()->user()->infocenter->nodo_id);
    $idcharla = CharlaInformativa::selectRaw('MAX(id+1) AS max')->get()->last();
    $idcharla->max == null ? $idcharla->max = 1 : $idcharla->max = $idcharla->max;
    $idcharla->max = sprintf("%04d", $idcharla->max);
    $codigo_charla = $codigo_charla . $anho . '-' . $tecnoparque . $idcharla->max;
    $charla = CharlaInformativa::create([
      'nodo_id' => auth()->user()->infocenter->nodo_id,
      'codigo_charla' => $codigo_charla,
      'fecha' => $request->txtfecha,
      'nro_asistentes' => $request->txtnro_asistentes,
      'encargado' => $request->txtencargado,
      'observacion' => $request->txtobservacion
    ]);

    if ($charla == null) {
      return false;
    } else {
      return true;
    }
  }

  /**
   * Modifica una charla informativa
   * @param Request $request
   * @param int $id Id de la charla inforamtiva
   * @return boolean
   */
  public function updateCharlaInformativaRepository($request, $id)
  {
    $charla = CharlaInformativa::findOrFail($id);
    $charla->update([
      'fecha' => $request->txtfecha,
      'nro_asistentes' => $request->txtnro_asistentes,
      'encargado' => $request->txtencargado,
      'observacion' => $request->txtobservacion
    ]);
    if ($charla != null) {
      return true;
    } else {
      return false;
    }
  }

  /**
   * Modifica las evidencias de una charla informativa
   * @param Request $request
   * @param int $id
   * @return boolean
   */
  public function updateEvidenciasRepository($request, $id)
  {
    $charla = CharlaInformativa::findOrFail($id);

    $programacion = 1;
    $evidencia_fotografica = 1;
    $listado_asistentes = 1;

    if ( !isset($request->txtprogramacion) ) {
      $programacion = 0;
    }

    if ( !isset($request->txtevidencia_fotografica) ) {
      $evidencia_fotografica = 0;
    }

    if ( !isset($request->txtlistado_asistentes) ) {
      $listado_asistentes = 0;
    }

    $charla->update([
      'programacion' => $programacion,
      'evidencia_fotografica' => $evidencia_fotografica,
      'listado_asistentes' => $listado_asistentes
    ]);

    if ($charla != null) {
      return true;
    } else {
      return false;
    }

  }

}
