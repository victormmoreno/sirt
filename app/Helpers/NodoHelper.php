<?php
namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use App\Models\Nodo;
use App\Models\Rols;

class NodoHelper {

  public function __construct()
  {
      $this->middleware('auth');
  }

  public static function returnNodoUsuario() {
    if (auth()->user()->rol()->first()->nombre == Rols::IsGestor()) {
      return Nodo::userNodo(auth()->user()->gestor->nodo_id)->first()->nombre;
    } else if ( auth()->user()->rol()->first()->nombre == Rols::IsInfocenter() ){
      return Nodo::userNodo(auth()->user()->infocenter->nodo_id)->first()->nombre;
    } else if ( auth()->user()->rol()->first()->nombre == Rols::IsIngreso() ) {
      return Nodo::userNodo(auth()->user()->ingreso->nodo_id)->first()->nombre;
    } else if ( auth()->user()->rol()->first()->nombre == Rols::IsDinamizador() ){
      return Nodo::userNodo(auth()->user()->dinamizador->nodo_id)->first()->nombre;
    }
  }


}
