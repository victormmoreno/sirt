<?php

namespace App\Repositories\Repository;

use App\Models\{CharlaInformativa};
use Illuminate\Support\Facades\{DB};

class CharlaInformativaRepository
{

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

}
