<?php

namespace App\Policies\Empresa;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Spatie\Permission\Models\Role;

class EmpresaPolicy
{
    use HandlesAuthorization;

    public $authUser;
    public $user;

    public function __construct(User $authUser, User $user)
    {
        $this->authUser = $authUser;
        $this->user     = $user;
    }

    /**
     * Determine si un usuario puede ver formulario para crear nuevos usuarios.
     * @author julian londono
     * @return boolean
     */
    public function create(User $user)
    {
        return (bool) collect($user->getRoleNames())->contains(User::IsAdministrador()) && session()->get('login_role') == User::IsAdministrador();
    }

    /**
     * Determine whether the user can store a nodo.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function store(User $user)
    {
        return (bool) $user->hasAnyRole([User::IsAdministrador()]) && session()->has('login_role') && session()->get('login_role') == User::IsAdministrador();
    }

    /**
     * Determine whether the user can edit a nodo.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function edit(User $user)
    {
        return (bool) $user->hasAnyRole([User::IsAdministrador()]) && session()->has('login_role') && session()->get('login_role') == User::IsAdministrador();
    }

    /**
     * Determine whether the user can update a nodo.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function update(User $user)
    {
        return (bool) $user->hasAnyRole([User::IsAdministrador()]) && session()->has('login_role') && session()->get('login_role') == User::IsAdministrador();
    }

}