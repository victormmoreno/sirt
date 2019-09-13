<?php

namespace App\Policies\UsoInfraestrucutura;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UsoInfraestructuraPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the usos infraestructura.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function index(User $user)
    {
        return (bool) $user->hasAnyRole([User::IsAdministrador(), User::IsDinamizador(), User::IsGestor(), User::IsTalento()]) && session()->get('login_role') != User::IsIngreso() || session()->get('login_role') != User::IsInfocenter();
    }

    /**
     * Determine whether the user can create usos de infraestructura.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        return (bool) $user->hasAnyRole([User::IsGestor(), User::IsTalento()]) && session()->get('login_role') == User::IsGestor() || session()->get('login_role') == User::IsTalento();
    }

}
