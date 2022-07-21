<?php

namespace App\Policies\Equipo;

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
        return (bool) $user->hasAnyRole([User::IsActivador(), User::IsDinamizador(), User::IsGestor()]);
    }

    /**
     * Determine whether the user can create equipos.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return (bool) $user->hasAnyRole([User::IsDinamizador()]) && session()->get('login_role') == User::IsDinamizador();
    }

    /**
     * Determine whether the user can store equipos.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function store(User $user)
    {
        return (bool) $user->hasAnyRole([User::IsDinamizador()]) && session()->get('login_role') == User::IsDinamizador();
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
        return (bool) $user->hasAnyRole([User::IsDinamizador()]) && session()->get('login_role') == User::IsDinamizador() && $equipo->nodo->id == $user->dinamizador->nodo->id;
    }

    /**
     * Determine whether the user can edit usos de infraestructura.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Equipo  $uso
     * @return bool
     */
    public function update(User $user, $equipo)
    {
        return (bool) $user->hasAnyRole([User::IsDinamizador()]) && session()->get('login_role') == User::IsDinamizador() && $equipo->nodo->id == $user->dinamizador->nodo->id;
    }

    /**
     * Determine whether the user can destroy any equipo.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Equipo  $equipo
     * @return bool
     */
    public function destroy(User $user, $equipo)
    {
        return (bool) $user->hasAnyRole([User::IsDinamizador()]) && (session()->get('login_role') == User::IsDinamizador() && $equipo->nodo->id == $user->dinamizador->nodo->id);
    }

    /**
     * Determine whether the user can change state any equipo.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Equipo  $equipo
     * @return bool
     */
    public function changeState(User $user, $equipo)
    {
        return (bool) $user->hasAnyRole([User::IsDinamizador()]) && (session()->get('login_role') == User::IsDinamizador() && $equipo->nodo->id == $user->dinamizador->nodo->id);
    }
}
