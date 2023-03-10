<?php

namespace App\Policies\Equipo;

use Illuminate\Support\Str;
use App\Models\Equipo;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EquipoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can wiew all usos de infraestructura.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function view(User $user)
    {
        return (bool) Str::contains(session()->get('login_role'), [$user->IsDinamizador(), $user->IsExperto(), $user->IsAdministrador(), $user->IsInfocenter(), $user->IsActivador()]);
    }

    /**
     * Determine whether the user can create equipos.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return (bool) Str::contains(session()->get('login_role'), [$user->IsDinamizador(), $user->IsInfocenter(), $user->IsAdministrador()]);
    }

    /**
     * Determine whether the user can show equipos.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function show(User $user, Equipo $equipo)
    {
        if (session()->get('login_role') == $user->IsAdministrador() || session()->get('login_role') == $user->IsActivador()) {
            return true;
        }
        if (session()->get('login_role') == $user->IsDinamizador() && $equipo->nodo_id == request()->user()->dinamizador->nodo_id) {
            return true;
        }
        if (session()->get('login_role') == $user->IsExperto() && $equipo->nodo_id == request()->user()->gestor->nodo_id && $equipo->lineatecnologica_id == request()->user()->gestor->lineatecnologica_id) {
            return true;
        }
        if (session()->get('login_role') == $user->IsInfocenter() && $equipo->nodo_id == request()->user()->infocenter->nodo_id) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can edit usos de infraestructura.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Equipo  $uso
     * @return bool
     */
    public function edit(User $user, $equipo)
    {
        if (session()->get('login_role') == $user->IsAdministrador() || session()->get('login_role') == $user->IsActivador()) {
            return true;
        }
        if (session()->get('login_role') == $user->IsDinamizador() && $equipo->nodo_id == request()->user()->dinamizador->nodo_id) {
            return true;
        }
        if (session()->get('login_role') == $user->IsInfocenter() && $equipo->nodo_id == request()->user()->infocenter->nodo_id) {
            return true;
        }
        return false;
    }

    /**
     * True para las opciones que pueden realizar los administrador
     *
     * @param User $user
     * @return bool
     * @author dum
     **/
    public function showOptionsForAdmin(User $user)
    {
        if (session()->get('login_role') == $user->IsAdministrador() || session()->get('login_role') == $user->IsActivador()) {
            return true;
        }
        return false;
    }

    /**
     * Indica quienes pueden realizar registros de equipos
     *
     * @param User $user
     * @return bool
     * @author dum
     **/
    public function showCreateButton(User $user)
    {
        if (session()->get('login_role') == $user->IsAdministrador() || session()->get('login_role') == $user->IsDinamizador()) {
            return true;
        }
        return false;
    }

    /**
     * Valida que el usuario sea administrador para mostrar el input del nodo y línea tecnológica
     *
     * @param \App\User $user
     * @return bool
     * @author dum
     **/
    public function showInputsForAdmin(User $user)
    {
        if (session()->get('login_role') == $user->IsAdministrador()) {
            return true;
        }
        return false;
    }

    /**
     * Valida que el usuario sea administrador para mostrar el input del nodo y línea tecnológica
     *
     * @param \App\User $user
     * @return bool
     * @author dum
     **/
    public function showInputsForDinamizador(User $user)
    {
        if (session()->get('login_role') == $user->IsDinamizador() || session()->get('login_role') == $user->IsInfocenter()) {
            return true;
        }
        return false;
    }

    /**
     * Determina si el usuario puede destacar un equipo
     *
     * @param User $user
     * @param Equipo $equipo
     * @return bool
     * @author dum
     **/
    public function destacar(User $user, Equipo $equipo)
    {
        if (Str::contains(session()->get('login_role'), [$user->IsAdministrador()])) {
            return true;
        }
        if (Str::contains(session()->get('login_role'), [$user->IsDinamizador(), $user->IsInfocenter()]) && $equipo->nodo_id == $user->getNodoUser()) {
            return true;
        }
        return false;
    }

    /**
     * Determina si el usuario puede importar información de equipos
     *
     * @param User $user
     * @return type
     * @throws conditon
     **/
    public function import(User $user)
    {
        return (bool) Str::contains(session()->get('login_role'), [$user->IsDinamizador(), $user->IsInfocenter(), $user->IsAdministrador()]);
    }

}
