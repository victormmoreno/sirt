<?php

namespace App\Policies\ArticulacionPbt;

use App\Models\TipoArticulacion;
use App\Models\Nodo;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Spatie\Permission\Models\Role;

class TipoArticulacionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the tipos articulaciones.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function index(User $user)
    {
        return (bool) $user->hasAnyRole([User::IsAdministrador(), User::IsActivador()])
            && session()->has('login_role')
            && (
                session()->get('login_role') == User::IsAdministrador()
                || session()->get('login_role') == User::IsActivador()
            );
    }


    /**
     * Determine whether the user can create a tipo articulacion.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        return (bool) $user->hasAnyRole([User::IsAdministrador(), User::IsActivador()])
            && session()->has('login_role')
            && (
                session()->get('login_role') == User::IsAdministrador()
                || session()->get('login_role') == User::IsActivador()
            );
    }
}
