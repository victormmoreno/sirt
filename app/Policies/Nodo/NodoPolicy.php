<?php

namespace App\Policies\Nodo;

use App\Models\Nodo;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NodoPolicy
{
    use HandlesAuthorization;
    /**
     * Perform pre-authorization checks.
     *
     * @param $user
     * @param  string  $ability
     * @return void|bool
     */
    public function before(User $user, $ability)
    {
        if ($user->hasAnyRole([User::IsAdministrador()])
            && session()->has('login_role')
            && session()->get('login_role') == User::IsAdministrador()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the nodos.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function index(User $user)
    {

        return (bool) $user->hasAnyRole([User::IsAdministrador(), User::IsActivador(), User::IsDinamizador(), User::IsExperto(), User::IsInfocenter()]);
    }

    /**
     * Determine whether the user can create a nodo.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        return (bool) $user->hasAnyRole([User::IsActivador(), User::IsAdministrador()]);
    }

    /**
     * Determine whether the user can show a nodo.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function show(User $user,  Nodo $nodo)
    {
        return (bool) $user->hasAnyRole([User::IsActivador(), User::IsAdministrador()]);
    }

    /**
     * Determine whether the user can edit a nodo.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function edit(User $user, Nodo $nodo)
    {
        return (bool) $user->hasAnyRole([User::IsActivador(), User::IsAdministrador()]);
    }

    /**
     * Determine whether the user can create a nodo.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function downloadAll(User $user)
    {
        return (bool) $user->hasAnyRole([User::IsActivador(), User::IsAdministrador()]) && session()->has('login_role') && (session()->get('login_role') == User::IsActivador() || session()->get('login_role') == User::IsAdministrador());
    }

    /**
     * Determine whether the user can edit a nodo.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Nodo  $nodo
     * @return bool
     */
    public function downloadOne(User $user, Nodo $nodo)
    {
        return (bool) $user->hasAnyRole([User::IsActivador(), User::IsAdministrador()]) && session()->has('login_role') && (session()->get('login_role') == User::IsActivador() || session()->get('login_role') == User::IsAdministrador());
    }
}
