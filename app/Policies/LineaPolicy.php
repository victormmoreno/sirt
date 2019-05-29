<?php

namespace App\Policies;

use App\Models\Linea;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LineaPolicy
{
    use HandlesAuthorization;


    public function before($user)
    {
        if ($user->hasRole('Administrador')) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the linea.
     *
     * @param  \App\User  $user
     * @param  \App\Linea  $linea
     * @return mixed
     */
    public function view(User $user, Linea $linea)
    {
         return $user->hasPermissionTo('consultar linea');
    }

    /**
     * Determine whether the user can create lineas.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('registrar linea');
    }

    /**
     * Determine whether the user can update the linea.
     *
     * @param  \App\User  $user
     * @param  \App\Linea  $linea
     * @return mixed
     */
    public function update(User $user, Linea $linea)
    {
        //
    }

    /**
     * Determine whether the user can delete the linea.
     *
     * @param  \App\User  $user
     * @param  \App\Linea  $linea
     * @return mixed
     */
    public function delete(User $user, Linea $linea)
    {
        //
    }

    /**
     * Determine whether the user can restore the linea.
     *
     * @param  \App\User  $user
     * @param  \App\Linea  $linea
     * @return mixed
     */
    public function restore(User $user, Linea $linea)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the linea.
     *
     * @param  \App\User  $user
     * @param  \App\Linea  $linea
     * @return mixed
     */
    public function forceDelete(User $user, Linea $linea)
    {
        //
    }
}
