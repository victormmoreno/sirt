<?php

namespace App\Policies\Material;

use App\User;
use App\Models\Material;
use Illuminate\Auth\Access\HandlesAuthorization;

class MaterialPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view the index materials.
     *
     * @param  \App\User  $user
     * @return mixed
     * @author devjul
     */
    public function index(User $user)
    {
        return (bool) $user->hasAnyRole([User::IsAdministrador(),User::IsDinamizador(), User::IsGestor()]) && session()->has('login_role') && session()->get('login_role') == User::IsAdministrador() || session()->get('login_role') == User::IsDinamizador() || session()->get('login_role') == User::IsGestor();
    }

    /**
     * Determine whether the user can view the materials for nodo.
     *
     * @param  \App\User  $user
     * @return mixed
     * @author devjul
     */
    public function getMaterialesPorNodo(User $user)
    {
        return (bool) $user->hasAnyRole([User::IsAdministrador()]) && session()->has('login_role') && session()->get('login_role') == User::IsAdministrador();
    }


    /**
     * Determine whether the user can create any materials.
     *
     * @param  \App\User  $user
     * @return mixed
     * @author devjul
     */
    public function create(User $user)
    {
        
        return (bool) $user->hasAnyRole([User::IsDinamizador(), User::IsGestor()]) && session()->has('login_role') || session()->get('login_role') == User::IsDinamizador() || session()->get('login_role') == User::IsGestor();
    }

    /**
     * Determine whether the user can store any materials.
     *
     * @param  \App\User  $user
     * @return mixed
     * @author devjul
     */
    public function store(User $user)
    {
        
        return (bool) $user->hasAnyRole([User::IsDinamizador(), User::IsGestor()]) && session()->has('login_role') || session()->get('login_role') == User::IsDinamizador() || session()->get('login_role') == User::IsGestor();
    }

    /**
     * Determine whether the user can show any material.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Material  $material
     * @return bool
     */
    public function show(User $user, $material)
    {
        return (bool) $user->hasAnyRole([User::IsAdministrador(), User::IsDinamizador(), User::IsGestor()]) && (session()->get('login_role') == User::IsDinamizador() && $material->nodo->id == $user->dinamizador->nodo->id) || (session()->get('login_role') == User::IsGestor() && $material->lineatecnologica->id == $user->gestor->lineatecnologica->id && $material->nodo->id == $user->gestor->nodo->id) || session()->get('login_role') == User::IsAdministrador();

    }


    /**
     * Determine whether the user can edit any material.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Material  $material
     * @return bool
     */
    public function edit(User $user, $material)
    {
        return (bool) $user->hasAnyRole([User::IsDinamizador(), User::IsGestor()]) && (session()->get('login_role') == User::IsDinamizador() && $material->nodo->id == $user->dinamizador->nodo->id) || (session()->get('login_role') == User::IsGestor() && $material->lineatecnologica->id == $user->gestor->lineatecnologica->id && $material->nodo->id == $user->gestor->nodo->id);

    }

    /**
     * Determine whether the user can update any material.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Material  $material
     * @return bool
     */
    public function update(User $user, $material)
    {
        return (bool) $user->hasAnyRole([User::IsDinamizador(), User::IsGestor()]) && (session()->get('login_role') == User::IsDinamizador() && $material->nodo->id == $user->dinamizador->nodo->id) || (session()->get('login_role') == User::IsGestor() && $material->lineatecnologica->id == $user->gestor->lineatecnologica->id && $material->nodo->id == $user->gestor->nodo->id);

    }

    
}
