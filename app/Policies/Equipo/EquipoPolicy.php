<?php

namespace App\Policies\Equipo;

use App\Models\Equipo;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EquipoPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can create equipos.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        // return (bool) $user->hasAnyRole([User::IsDinamizador()]) &&  session()->get('login_role') == User::IsDinamizador();
        // 
        return true;
    }

    
}
