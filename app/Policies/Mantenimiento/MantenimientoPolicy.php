<?php

namespace App\Policies\Mantenimiento;

use App\User;
use Illuminate\Support\Str;
use Illuminate\Auth\Access\HandlesAuthorization;

class MantenimientoPolicy
{
    use HandlesAuthorization;


    /**
     * Valida que el usuario sea administrador para mostrar los inputs correspondientes a este
     *
     * @param User $user
     * @return bool
     * @author dum
     **/
    public function showInputAdmin(User $user)
    {
        if (session()->get('login_role') == $user->IsAdministrador()) {
            return true;
        }
        return false;
    }
    /**
     * Valida el index a mostrar para el administador/activador
     *
     * @param User $user
     * @return bool
     * @author dum
     */
    public function showIndexForAdmin(User $user)
    {
        if (session()->get('login_role') == $user->IsAdministrador() || session()->get('login_role') == $user->IsActivador()) {
            return true;
        }
        return false;
    }


    /**
     * Valida el index a mostrar para el experto
     *
     * @param User $user
     * @return bool
     * @author dum
     */
    public function showIndexForExperto(User $user)
    {
        if (session()->get('login_role') == $user->IsExperto()) {
            return true;
        }
        return false;
    }

    /**
     * Determine si un usuario puede ver el index de las equipo mantenimientos.
     * @author julian londono
     * @return boolean
     */
    public function index(User $user)
    {

        return (bool) Str::contains(session()->get('login_role'), [$user->IsApoyoTecnico(), $user->IsDinamizador(), $user->IsInfocenter(), $user->IsAdministrador(), $user->IsExperto(), $user->IsActivador()]);
    }

    /**
     * Determine whether the user can create equipo mantenimientos.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return (bool) Str::contains(session()->get('login_role'), [$user->IsApoyoTecnico(), $user->IsDinamizador(), $user->IsInfocenter(), $user->IsAdministrador()]);
    }

    /**
     * Determine whether the user can show equipo mantenimientos.
     *
     * @param  \App\User  $user
     * @param  \App\Models\EquipoMantenimiento  $mantenimiento
     * @return bool
     */
    public function show(User $user, $mantenimiento)
    {
        if (session()->get('login_role') == $user->IsActivador() || session()->get('login_role') == $user->IsAdministrador()) {
            return true;
        }
        if (session()->get('login_role') == $user->IsDinamizador() && $mantenimiento->equipo->nodo_id == $user->dinamizador->nodo_id) {
            return true;
        }
        if (session()->get('login_role') == $user->IsExperto() && $mantenimiento->equipo->nodo_id == $user->experto->nodo_id) {
            return true;
        }
        if (session()->get('login_role') == $user->IsApoyoTecnico() && $mantenimiento->equipo->nodo_id == request()->user()->apoyotecnico->nodo_id) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can edit equipo mantenimientos.
     *
     * @param  \App\User  $user
     * @param  \App\Models\EquipoMantenimiento  $mantenimiento
     * @return bool
     */
    public function edit(User $user, $mantenimiento)
    {
        if (session()->get('login_role') == $user->IsAdministrador()) {
            return true;
        }
        if (session()->get('login_role') == $user->IsDinamizador() && $mantenimiento->equipo->nodo_id == $user->dinamizador->nodo_id) {
            return true;
        }
        if (session()->get('login_role') == $user->IsApoyoTecnico() && $mantenimiento->equipo->nodo_id == request()->user()->apoyotecnico->nodo_id) {
            return true;
        }
        // if (session()->get('login_role') == $user->IsExperto() && $mantenimiento->equipo->lineatecnologica_id == $user->experto->lineatecnologica_id) {
        //     return true;
        // }
        return false;

    }

}
