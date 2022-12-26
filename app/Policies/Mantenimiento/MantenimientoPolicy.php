<?php

namespace App\Policies\Mantenimiento;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MantenimientoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine si un usuario puede ver el index de las equipo mantenimientos.
     * @author julian londono
     * @return boolean
     */
    public function index(User $user)
    {
        return (bool) collect($user->getRoleNames())->contains(User::IsAdministrador()) && session()->get('login_role') == User::IsAdministrador() || collect($user->getRoleNames())->contains(User::IsDinamizador()) && session()->get('login_role') == User::IsDinamizador() || collect($user->getRoleNames())->contains(User::IsGestor()) && session()->get('login_role') == User::IsGestor();
    }

    /**
     * Determine whether the user can create equipo mantenimientos.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return (bool) $user->hasAnyRole([User::IsDinamizador()]) && session()->has('login_role') && session()->get('login_role') == User::IsDinamizador();
    }

    /**
     * Determine whether the user can store equipo mantenimientos.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function store(User $user)
    {
        return (bool) $user->hasAnyRole([User::IsDinamizador()]) && session()->has('login_role') && session()->get('login_role') == User::IsDinamizador();
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
        if ($user->hasAnyRole([User::IsAdministrador()]) && session()->get('login_role') == User::IsAdministrador()) {
            return true;
        } elseif ($user->hasAnyRole([User::IsDinamizador()]) && session()->get('login_role') == User::IsDinamizador() && $mantenimiento->equipo->nodo->id == $user->dinamizador->nodo->id) {
            return true;
        } elseif ($user->hasAnyRole([User::IsGestor()]) && session()->get('login_role') == User::IsGestor() && $mantenimiento->equipo->lineatecnologica->id == $user->gestor->lineatecnologica->id) {

            return true;
        } else {
            return false;
        }

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
        return (bool) $user->hasAnyRole([User::IsDinamizador()]) && session()->get('login_role') == User::IsDinamizador() && $mantenimiento->equipo->nodo->id == $user->dinamizador->nodo->id;

    }

    /**
     * Determine whether the user can update equipo mantenimientos.
     *
     * @param  \App\User  $user
     * @param  \App\Models\EquipoMantenimiento  $mantenimiento
     * @return bool
     */
    public function update(User $user, $mantenimiento)
    {
        return (bool) $user->hasAnyRole([User::IsDinamizador()]) && session()->get('login_role') == User::IsDinamizador() && $mantenimiento->equipo->nodo->id == $user->dinamizador->nodo->id;

    }

}
