<?php
namespace App\Helpers;

use App\Models\Nodo;
use App\Models\Rols;
use App\User;
use Illuminate\Support\Facades\DB;

class NodoHelper {

  public function __construct()
  {
      $this->middleware('auth');
  }

  public static function returnNodoUsuario() {
    // $value = session()->get('login_role');
    if (collect(auth()->user()->getRoleNames())->contains(User::IsAdministrador()) && session()->get('login_role') == User::IsAdministrador()) {
      return collect(auth()->user()->roles)->firstWhere('name', User::IsAdministrador())->name .' '. config('app.name') ;
    }

    if (collect(auth()->user()->getRoleNames())->contains(User::IsTalento()) && session()->get('login_role') == User::IsTalento()) {
      return collect(auth()->user()->roles)->firstWhere('name', User::IsTalento())->name .' '. config('app.name') ;
    }
    else if(collect(auth()->user()->getRoleNames())->contains(User::IsGestor())) {
      
      return 'Gestor Nodo' . Nodo::userNodo(auth()->user()->gestor->nodo_id)->first()->nombre;
    } else if ( auth()->user()->rol()->first()->nombre == Rols::IsInfocenter() ){
      return Nodo::userNodo(auth()->user()->infocenter->nodo_id)->first()->nombre;
    } else if ( auth()->user()->rol()->first()->nombre == Rols::IsIngreso() ) {
      return Nodo::userNodo(auth()->user()->ingreso->nodo_id)->first()->nombre;
    } else if ( auth()->user()->rol()->first()->nombre == Rols::IsDinamizador() ){
      return Nodo::userNodo(auth()->user()->dinamizador->nodo_id)->first()->nombre;
    }
  }


}
