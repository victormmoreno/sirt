<?php

namespace App\Helpers;

use App\Models\Nodo;
use App\User;

class NodoHelper
{
    public static function returnNodoUsuario()
    {
        if (\Session::get('login_role') == User::IsExperto() && isset(auth()->user()->experto->nodo_id)) {
            return User::IsExperto(). ' nodo ' . Nodo::userNodo(auth()->user()->experto->nodo_id)->first()->nombre;
        } else if (\Session::get('login_role') == User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo_id)) {
            return User::IsDinamizador(). ' nodo ' . Nodo::userNodo(auth()->user()->dinamizador->nodo_id)->first()->nombre;
        } else if (\Session::get('login_role') == User::IsInfocenter() && isset(auth()->user()->infocenter->nodo_id)) {
            return User::IsInfocenter(). ' nodo ' . Nodo::userNodo(auth()->user()->infocenter->nodo_id)->first()->nombre;
        } else if (\Session::get('login_role') == User::IsIngreso() && isset(auth()->user()->ingreso->nodo_id)) {
            return User::IsIngreso().' nodo ' . Nodo::userNodo(auth()->user()->ingreso->nodo_id)->first()->nombre;
        } else if (\Session::get('login_role') == User::IsArticulador() && isset(auth()->user()->articulador->nodo_id)) {
            return User::IsArticulador().' nodo ' . Nodo::userNodo(auth()->user()->articulador->nodo_id)->first()->nombre;
        }else if (\Session::get('login_role') == User::IsApoyoTecnico() && isset(auth()->user()->apoyotecnico->nodo_id)) {
            return User::IsApoyoTecnico(). ' nodo ' . Nodo::userNodo(auth()->user()->apoyotecnico->nodo_id)->first()->nombre;
        } else if (\Session::get('login_role') == User::IsAdministrador()) {
            return User::IsAdministrador();
        } else if (\Session::get('login_role') == User::IsActivador()) {
            return User::IsActivador();
        }else if (\Session::get('login_role') == User::IsUsuario()) {
            return User::IsUsuario();
        }else if (\Session::get('login_role') == User::IsTalento()) {
            return User::IsTalento();
        }
        else {
            return 'No hay información disponible.';
        }
    }

    public static function returnNameNodoUsuario()
    {
        if (\Session::get('login_role') == User::IsExperto() && isset(auth()->user()->experto->nodo_id)) {
            return Nodo::userNodo(auth()->user()->experto->nodo_id)->first()->nombre;
        } else if (\Session::get('login_role') == User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo_id)) {
            return Nodo::userNodo(auth()->user()->dinamizador->nodo_id)->first()->nombre;
        } else if (\Session::get('login_role') == User::IsInfocenter() && isset(auth()->user()->infocenter->nodo_id)) {
            return Nodo::userNodo(auth()->user()->infocenter->nodo_id)->first()->nombre;
        } else if (\Session::get('login_role') == User::IsIngreso() && isset(auth()->user()->ingreso->nodo_id)) {
            return Nodo::userNodo(auth()->user()->ingreso->nodo_id)->first()->nombre;
        }else if (\Session::get('login_role') == User::IsApoyoTecnico() && isset(auth()->user()->apoyotecnico->nodo_id)) {
            return Nodo::userNodo(auth()->user()->apoyotecnico->nodo_id)->first()->nombre;
        }else if (\Session::get('login_role') == User::IsTalento()) {
            return 'Talento';
        }else if (\Session::get('login_role') == User::IsArticulador() && isset(auth()->user()->articulador->nodo_id)) {
            return Nodo::userNodo(auth()->user()->articulador->nodo_id)->first()->nombre;
        }  else {
            return 'No hay información disponible.';
        }
    }

    public static function returnIdNodoUser()
    {
        if (\Session::get('login_role') == User::IsExperto() && isset(auth()->user()->experto->nodo_id)) {
            return auth()->user()->experto->nodo_id;
        } else if (\Session::get('login_role') == User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo_id)) {
            return auth()->user()->dinamizador->nodo_id;
        } else if (\Session::get('login_role') == User::IsInfocenter() && isset(auth()->user()->infocenter->nodo_id)) {
            return auth()->user()->infocenter->nodo_id;
        } else if (\Session::get('login_role') == User::IsIngreso() && isset(auth()->user()->ingreso->nodo_id)) {
            return auth()->user()->ingreso->nodo_id;
        }else if (\Session::get('login_role') == User::IsApoyoTecnico() && isset(auth()->user()->apoyotecnico->nodo_id)) {
            return auth()->user()->apoyotecnico->nodo_id;
        }else if (\Session::get('login_role') == User::IsArticulador() && isset(auth()->user()->articulador->nodo_id)) {
            return auth()->user()->articulador->nodo_id;
        }  else {
            return 0;
        }
    }
}
