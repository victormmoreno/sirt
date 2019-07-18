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

  // Retorna el rol y el nodo al que pertenece un usuario
  public static function returnNodoUsuario() {
    // $value = session()->get('login_role');
    if (\Session::get('login_role') == User::IsGestor()) {
      return 'Gestor nodo ' . Nodo::userNodo(auth()->user()->gestor->nodo_id)->first()->nombre;
    } else if (\Session::get('login_role') == User::IsDinamizador()) {
      return 'Dinamizador nodo ' . Nodo::userNodo(auth()->user()->dinamizador->nodo_id)->first()->nombre;
    } else if (\Session::get('login_role') == User::IsInfocenter()) {
      return 'Infocenter nodo ' . Nodo::userNodo(auth()->user()->infocenter->nodo_id)->first()->nombre;
    } else if (\Session::get('login_role') == User::IsIngreso()) {
      return 'Ingreso nodo ' . Nodo::userNodo(auth()->user()->ingreso->nodo_id)->first()->nombre;
    } else {
      return 'No hay información disponible.';
    }
  }


  // Retorna únicamente el nombre del nodo al que pertenece el usuario
  public static function returnNameNodoUsuario() {
    // $value = session()->get('login_role');
    if (\Session::get('login_role') == User::IsGestor()) {
      return Nodo::userNodo(auth()->user()->gestor->nodo_id)->first()->nombre;
    } else if (\Session::get('login_role') == User::IsDinamizador()) {
      return Nodo::userNodo(auth()->user()->dinamizador->nodo_id)->first()->nombre;
    } else if (\Session::get('login_role') == User::IsInfocenter()) {
      return Nodo::userNodo(auth()->user()->infocenter->nodo_id)->first()->nombre;
    } else if (\Session::get('login_role') == User::IsIngreso()) {
      return Nodo::userNodo(auth()->user()->ingreso->nodo_id)->first()->nombre;
    } else {
      return 'No hay información disponible.';
    }
  }


}
