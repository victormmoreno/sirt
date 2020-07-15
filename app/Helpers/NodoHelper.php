<?php

namespace App\Helpers;

use App\Models\Nodo;
use App\User;

class NodoHelper
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    // Retorna el rol y el nodo al que pertenece un usuario
    public static function returnNodoUsuario()
    {
        // $value = session()->get('login_role');
        if (\Session::get('login_role') == User::IsGestor() && isset(auth()->user()->gestor->nodo_id)) {
            return 'Gestor nodo ' . Nodo::userNodo(auth()->user()->gestor->nodo_id)->first()->nombre;
        } else if (\Session::get('login_role') == User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo_id)) {
            return 'Dinamizador nodo ' . Nodo::userNodo(auth()->user()->dinamizador->nodo_id)->first()->nombre;
        } else if (\Session::get('login_role') == User::IsInfocenter() && isset(auth()->user()->infocenter->nodo_id)) {
            return 'Infocenter nodo ' . Nodo::userNodo(auth()->user()->infocenter->nodo_id)->first()->nombre;
        } else if (\Session::get('login_role') == User::IsIngreso() && isset(auth()->user()->ingreso->nodo_id)) {
            return 'Ingreso nodo ' . Nodo::userNodo(auth()->user()->ingreso->nodo_id)->first()->nombre;
        } else {
            return 'No hay información disponible.';
        }
    }

    // Retorna únicamente el nombre del nodo al que pertenece el usuario
    public static function returnNameNodoUsuario()
    {

        if (\Session::get('login_role') == User::IsGestor() && isset(auth()->user()->gestor->nodo_id)) {
            return Nodo::userNodo(auth()->user()->gestor->nodo_id)->first()->nombre;
        } else if (\Session::get('login_role') == User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo_id)) {
            return Nodo::userNodo(auth()->user()->dinamizador->nodo_id)->first()->nombre;
        } else if (\Session::get('login_role') == User::IsInfocenter() && isset(auth()->user()->infocenter->nodo_id)) {
            return Nodo::userNodo(auth()->user()->infocenter->nodo_id)->first()->nombre;
        } else if (\Session::get('login_role') == User::IsIngreso() && isset(auth()->user()->ingreso->nodo_id)) {
            return Nodo::userNodo(auth()->user()->ingreso->nodo_id)->first()->nombre;
        } else {
            return 'No hay información disponible.';
        }
    }
}
