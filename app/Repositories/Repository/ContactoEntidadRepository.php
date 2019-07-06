<?php

namespace App\Repositories\Repository;

use Illuminate\Support\Facades\DB;
use App\Models\{Entidad, Nodo};
use Carbon\Carbon;

class ContactoEntidadRepository
{

  // Modifica un articulación
  public function update($request,  $id)
  {
    if (auth()->user()->rol()->first()->nombre == 'Gestor') {
      $idnodo = auth()->user()->gestor->nodo_id;
    }

    if (auth()->user()->rol()->first()->nombre == 'Dinamizador') {
      $idnodo = auth()->user()->dinamizador->nodo_id;
    }
    dd($idnodo);
    DB::beginTransaction();
    try {

      $entidadConsultaId = Entidad::find($id);

      $syncData = array();
      $idnodo = "";

      // dd($idnodo);
      foreach($request->get('txtnombres_contactos') as $id => $value) {
        $syncData[$id] = array(
          'nombres_contacto' => $value,
          'correo_contacto' => $request->get('txtcorreo_contacto')[$id],
          'telefono_contacto' => $request->get('txttelefono_contacto')[$id],
          'nodo_id' => $idnodo,
        );

      }
      $entidadConsultaId->nodos()->sync($syncData);

      DB::commit();
      return true;
    } catch (Exception $e) {
      DB::rollback();
      return false;
    }
  }

}
