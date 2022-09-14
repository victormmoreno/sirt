<?php

namespace App\Helpers;

use App\Models\Nodo;
use App\User;

class NodoHelper
{
    public static function returnNodoUsuario()
    {
        if (\Session::get('login_role') == User::IsGestor() && isset(auth()->user()->gestor->nodo_id)) {
            return 'Experto nodo ' . Nodo::userNodo(auth()->user()->gestor->nodo_id)->first()->nombre;
        } else if (\Session::get('login_role') == User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo_id)) {
            return User::IsDinamizador(). ' nodo ' . Nodo::userNodo(auth()->user()->dinamizador->nodo_id)->first()->nombre;
        } else if (\Session::get('login_role') == User::IsInfocenter() && isset(auth()->user()->infocenter->nodo_id)) {
            return User::IsInfocenter(). ' nodo ' . Nodo::userNodo(auth()->user()->infocenter->nodo_id)->first()->nombre;
        } else if (\Session::get('login_role') == User::IsIngreso() && isset(auth()->user()->ingreso->nodo_id)) {
            return User::IsIngreso().' nodo ' . Nodo::userNodo(auth()->user()->ingreso->nodo_id)->first()->nombre;
        } else if (\Session::get('login_role') == User::IsArticulador() && isset(auth()->user()->articulador->nodo_id)) {
            return User::IsArticulador().' nodo ' . Nodo::userNodo(auth()->user()->articulador->nodo_id)->first()->nombre;
        }else if (\Session::get('login_role') == User::IsApoyoTecnico() && isset(auth()->user()->apoyotecnico->nodo_id)) {
            return User::IsApoyoTecnico(). ' del nodo ' . Nodo::userNodo(auth()->user()->apoyotecnico->nodo_id)->first()->nombre;
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
        }else if (\Session::get('login_role') == User::IsApoyoTecnico() && isset(auth()->user()->apoyotecnico->nodo_id)) {
            return Nodo::userNodo(auth()->user()->apoyotecnico->nodo_id)->first()->nombre;
        }else if (\Session::get('login_role') == User::IsArticulador() && isset(auth()->user()->articulador->nodo_id)) {
            return Nodo::userNodo(auth()->user()->articulador->nodo_id)->first()->nombre;
        }  else {
            return 'No hay información disponible.';
        }
    }

    public static function returnIdNodoUser()
    {
        if (\Session::get('login_role') == User::IsGestor() && isset(auth()->user()->gestor->nodo_id)) {
            return auth()->user()->gestor->nodo_id;
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
