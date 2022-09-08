<?php

namespace App\Policies\Material;

use App\User;
use App\Models\Material;
use Illuminate\Auth\Access\HandlesAuthorization;

class MaterialPolicy
{
    use HandlesAuthorization;

    /**
     * 
     * @param App\User $user
     * @return bool
     * @author dum
     */
    public function showFiltersForAdmins(User $user)
    {
        if (session()->get('login_role') == $user->IsActivador() || session()->get('login_role') == $user->IsAdministrador()) {
            return true;
        }
        return false;
    }

    /**
     * 
     * @param App\User $user
     * @return bool
     * @author dum
     */
    public function showFiltersForPersonalNodo(User $user)
    {
        if (session()->get('login_role') == $user->IsDinamizador() || session()->get('login_role') == $user->IsGestor() || session()->get('login_role') == $user->IsInfocenter() || session()->get('login_role') == $user->IsApoyoTecnico()) {
            return true;
        }
        return false;
    }

    /**
     * undocumented function summary
     *
     * @param \App\User $user
     * @return bool
     * @author dum
     **/
    public function showInputsForAdmin(User $user)
    {
        if (session()->get('login_role') == $user->IsAdministrador()) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the index materials.
     *
     * @param  \App\User  $user
     * @return mixed
     * @author devjul
     */
    public function index(User $user)
    {
        return (bool) $user->hasAnyRole([User::IsActivador(), User::IsDinamizador(), User::IsGestor()]) && session()->has('login_role') && session()->get('login_role') == User::IsActivador() || session()->get('login_role') == User::IsDinamizador() || session()->get('login_role') == User::IsGestor();
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
        return (bool) $user->hasAnyRole([User::IsActivador(), User::IsAdministrador()]);
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
        return (bool) $user->hasAnyRole([User::IsDinamizador(), User::IsGestor(), User::IsAdministrador()]);
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
        return (bool) $user->hasAnyRole([User::IsDinamizador(), User::IsGestor()]) && session()->has('login_role') && session()->get('login_role') == User::IsDinamizador() || session()->get('login_role') == User::IsGestor();
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
        return (bool) $user->hasAnyRole([User::IsActivador(), User::IsDinamizador(), User::IsGestor()]) && (session()->get('login_role') == User::IsDinamizador() && $material->nodo->id == $user->dinamizador->nodo->id) || (session()->get('login_role') == User::IsGestor() && $material->lineatecnologica->id == $user->gestor->lineatecnologica->id && $material->nodo->id == $user->gestor->nodo->id) || session()->get('login_role') == User::IsActivador();
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

    /**
     * Determine whether the user can destroy any material.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Material  $material
     * @return bool
     */
    public function destroy(User $user, $material)
    {
        return (bool) $user->hasAnyRole([User::IsDinamizador(), User::IsGestor()]) && (session()->get('login_role') == User::IsDinamizador() && $material->nodo->id == $user->dinamizador->nodo->id) || (session()->get('login_role') == User::IsGestor() && $material->lineatecnologica->id == $user->gestor->lineatecnologica->id && $material->nodo->id == $user->gestor->nodo->id);
    }
}
