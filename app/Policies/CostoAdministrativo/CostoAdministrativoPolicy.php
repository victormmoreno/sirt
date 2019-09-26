<?php

namespace App\Policies\CostoAdministrativo;

use App\User;
use App\CostoAdministrativo;
use Illuminate\Auth\Access\HandlesAuthorization;

class CostoAdministrativoPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view the costo administrativo.
     *
     * @param  \App\User  $user
     * @param  \App\CostoAdministrativo  $costoAdministrativo
     * @return mixed
     */
    public function index(User $user)
    {
        return (bool) $user->hasAnyRole([User::IsAdministrador(), User::IsDinamizador()]);
    }

    /**
     * Determine whether the user can update the costo administrativo.
     *
     * @param  \App\User  $user
     * @param  \App\CostoAdministrativo  $costoAdministrativo
     * @return mixed
     */
    public function update(User $user, CostoAdministrativo $costoAdministrativo)
    {
        //
    }

    /**
     * Determine whether the user can delete the costo administrativo.
     *
     * @param  \App\User  $user
     * @param  \App\CostoAdministrativo  $costoAdministrativo
     * @return mixed
     */
    public function delete(User $user, CostoAdministrativo $costoAdministrativo)
    {
        //
    }

    /**
     * Determine whether the user can restore the costo administrativo.
     *
     * @param  \App\User  $user
     * @param  \App\CostoAdministrativo  $costoAdministrativo
     * @return mixed
     */
    public function restore(User $user, CostoAdministrativo $costoAdministrativo)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the costo administrativo.
     *
     * @param  \App\User  $user
     * @param  \App\CostoAdministrativo  $costoAdministrativo
     * @return mixed
     */
    public function forceDelete(User $user, CostoAdministrativo $costoAdministrativo)
    {
        //
    }
}
