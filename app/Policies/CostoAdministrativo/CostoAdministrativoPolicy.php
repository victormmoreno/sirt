<?php

namespace App\Policies\CostoAdministrativo;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CostoAdministrativoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the costo administrativo.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function index(User $user)
    {
        return (bool) $user->hasAnyRole([User::IsActivador(), User::IsDinamizador()]);
    }

    /**
     * Determine whether the user can query for nodo the costo administrativo.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function getCostoAdministrativoPorNodo(User $user)
    {
        return (bool) $user->hasAnyRole([User::IsActivador()]) && session()->has('login_role') && session()->get('login_role') == User::IsActivador();
    }

    /**
     * Determine whether the user can edit the costo administrativo.
     *
     * @param  \App\User  $user
     * @param   $costoAdministrativo
     * @return mixed
     */
    public function edit(User $user, $costoAdministrativo)
    {
        return (bool) $user->hasAnyRole([User::IsDinamizador()]) && session()->has('login_role') && session()->get('login_role') == User::IsDinamizador() && $user->dinamizador->nodo->id == $costoAdministrativo->nodo_id;
    }

    /**
     * Determine whether the user can update the costo administrativo.
     *
     * @param  \App\User  $user
     * @param  $costoAdministrativo
     * @return mixed
     */
    public function update(User $user, $costoAdministrativo)
    {
        return (bool) $user->hasAnyRole([User::IsDinamizador()]) && session()->has('login_role') && session()->get('login_role') == User::IsDinamizador() && $user->dinamizador->nodo->id == $costoAdministrativo->nodo_id;
    }

}
