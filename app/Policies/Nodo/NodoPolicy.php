<?php

namespace App\Policies\Nodo;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NodoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the nodos.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function index(User $user)
    {

        return (bool) $user->hasAnyRole([User::IsAdministrador(), User::IsActivador(), User::IsDinamizador(), User::IsGestor(), User::IsInfocenter()]);
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
     * Determine whether the user can store a nodo.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function store(User $user)
    {
        return (bool) $user->hasAnyRole([User::IsActivador(), User::IsAdministrador()]);
    }

    /**
     * Determine whether the user can show a nodo.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function show(User $user)
    {
        return (bool) $user->hasAnyRole([User::IsActivador(), User::IsAdministrador()]);
    }

    /**
     * Determine whether the user can edit a nodo.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function edit(User $user)
    {
        return (bool) $user->hasAnyRole([User::IsActivador(), User::IsAdministrador()]) && session()->has('login_role') && (session()->get('login_role') == User::IsActivador() || session()->get('login_role') == User::IsAdministrador());
    }

    /**
     * Determine whether the user can update a nodo.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function update(User $user)
    {
        return (bool) $user->hasAnyRole([User::IsActivador(), User::IsAdministrador()]) && session()->has('login_role') && (session()->get('login_role') == User::IsActivador() || session()->get('login_role') == User::IsAdministrador());
    }
}
