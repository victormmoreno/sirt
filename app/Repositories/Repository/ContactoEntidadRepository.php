<?php

namespace App\Repositories\Repository;

use Illuminate\Support\Facades\{DB, Session};
use App\Models\{Entidad, Nodo, ContactoEntidad};
use App\User;
use Carbon\Carbon;

class ContactoEntidadRepository
{

  // Modifica un articulación
  public function update($request,  $id)
  {
    DB::beginTransaction();
    try {

      if ( Session::get('login_role') == User::IsExperto() ) {
        $idnodo = auth()->user()->gestor->nodo_id;
      }

      if ( Session::get('login_role') == User::IsDinamizador() ) {
        $idnodo = auth()->user()->dinamizador->nodo_id;
      }

      $delete = ContactoEntidad::where('entidad_id', $id)->where('nodo_id', $idnodo)->delete();
      if ( isset($request->txtnombres_contactos) ) {
        for ($i=0; $i < count($request->get('txtnombres_contactos')) ; $i++) {
          ContactoEntidad::create([
            'entidad_id' => $id,
            'nodo_id' => $idnodo,
            'nombres_contacto' => $request->get('txtnombres_contactos')[$i],
            'correo_contacto' => $request->get('txtcorreo_contacto')[$i],
            'telefono_contacto' => $request->get('txttelefono_contacto')[$i],
          ]);
        }
      }

      DB::commit();
      return true;
    } catch (Exception $e) {
      DB::rollback();
      return false;
    }
  }

}
