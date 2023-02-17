<?php

namespace App\Policies;

use App\User;
use Illuminate\Support\Str;
use App\Models\{CharlaInformativa};
use Illuminate\Auth\Access\HandlesAuthorization;

class CharlaInformativaPolicy
{
    use HandlesAuthorization;

    /** 
     * Determina quienes pueden ver y usar el botón de crear charlas informativas
     * 
     * @param App\User $user
     * @return bool
     * @author dum
    */
    public function create(User $user)
    {
        if (session()->get('login_role') == $user->IsAdministrador() || session()->get('login_role') == $user->IsInfocenter() || session()->get('login_role') == $user->IsArticulador()) {
            return true;
        }
        return false;
    }

    /** 
     * Determina si el usuario puede ver charlas informativas
     * 
     * @param App\User $user
     * @return bool
     * @author dum
    */
    public function index(User $user)
    {
        return (bool) Str::contains(session()->get('login_role'), [$user->IsDinamizador(), $user->IsInfocenter(), $user->IsArticulador(), $user->IsAdministrador(), $user->IsActivador()]);
    }

    /**
     * Determina si el usuario puede cambiar la información de una charla informativa
     *
     * @param App\User $user
     * @param App\Models\CharlaInformativa $user
     * @return bool
     * @author dum
     **/
    public function edit(User $user, CharlaInformativa $charla)
    {
        if (session()->get('login_role') == $user->IsAdministrador()) {
            return true;
        }
        if ( Str::contains(session()->get('login_role'), [$user->IsInfocenter(), $user->IsArticulador()]) && $charla->nodo_id == request()->user()->getNodoUser() ) {
            return true;
        }
        return false;
    }

    /**
     * Determina si el usuario puede ver la información de una charla informativa
     *
     * @param App\User $user
     * @param App\Models\CharlaInformativa $user
     * @return bool
     * @author dum
     **/
    public function show(User $user, CharlaInformativa $charla)
    {
        if (session()->get('login_role') == $user->IsAdministrador()) {
            return true;
        }
        if ( Str::contains(session()->get('login_role'), [$user->IsInfocenter(), $user->IsArticulador()]) && $charla->nodo_id == request()->user()->getNodoUser() ) {
            return true;
        }
        return false;
    }

    /**
     * Muestra el campo de los nodo para cuando el administrador va a registrar una charla informativa
     *
     * @param \App\User $user
     * @return bool
     * @author dum
     **/
    public function showNodosInput(User $user)
    {
        if (session()->get('login_role') == $user->IsAdministrador()) {
            return true;
        }
        return false;
    }

    /**
     * Muestra el campo para subir archivos de las charlas informativas
     *
     * @param \App\User $user
     * @return bool
     * @author dum
     **/
    public function showDropzone(User $user)
    {
        if (Str::contains(session()->get('login_role'), [$user->IsInfocenter(), $user->IsArticulador(), $user->IsAdministrador()])) {
            return true;
        }
        return false;
    }
}
