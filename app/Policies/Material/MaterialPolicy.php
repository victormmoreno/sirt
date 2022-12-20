<?php

namespace App\Policies\Material;

use App\User;
use App\Models\Material;
use Illuminate\Support\Str;
use Illuminate\Auth\Access\HandlesAuthorization;

class MaterialPolicy
{
    use HandlesAuthorization;

    public function showOptions(User $user, Material $material)
    {
        if (session()->get('login_role') == $user->IsAdministrador()) {
            return true;
        }

        if (session()->get('login_role') == $user->IsDinamizador() && $material->nodo_id == $user->dinamizador->nodo_id) {
            return true;
        }

        if (session()->get('login_role') == $user->IsExperto() && $material->lineatecnologica_id == $user->gestor->lineatecnologica_id) {
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
        if (session()->get('login_role') == $user->IsDinamizador() || session()->get('login_role') == $user->IsExperto() || session()->get('login_role') == $user->IsInfocenter() || session()->get('login_role') == $user->IsApoyoTecnico()) {
            return true;
        }
        return false;
    }

    /**
     * Valida que el usuario sea dinamizador para mostrar el input de la línea tecnológica
     *
     * @param \App\User $user
     * @return bool
     * @author dum
     **/
    public function showInputsForDinamizador(User $user)
    {
        if (session()->get('login_role') == $user->IsDinamizador()) {
            return true;
        }
        return false;
    }

    /**
     * Valida que el usuario sea administrador para mostrar el input del nodo y línea tecnológica
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
        return (bool) $user->hasAnyRole([$user->IsActivador(), $user->IsDinamizador(), $user->IsExperto(), $user->IsAdministrador()]);
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
        return (bool) $user->hasAnyRole([$user->IsActivador(), $user->IsAdministrador(), $user->IsDinamizador(), $user->IsExperto()]);
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

        return (bool) Str::contains(session()->get('login_role'), [$user->IsDinamizador(), $user->IsExperto(), $user->IsAdministrador()]);
    }

    /**
     * Determina si el usuario puede importar información de materiales
     *
     * @param  \App\User  $user
     * @return mixed
     * @author dum
     */
    public function import(User $user)
    {
        return (bool) Str::contains(session()->get('login_role'), [$user->IsDinamizador(), $user->IsExperto(), $user->IsAdministrador()]);
    }

    /**
     * Determina si el usuario puede descargar información de materiales
     *
     * @param  \App\User  $user
     * @return mixed
     * @author dum
     */
    public function download(User $user)
    {
        return (bool) $user->hasAnyRole([$user->IsDinamizador(), $user->IsExperto(), $user->IsAdministrador()]);
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
        return (bool) session()->has('login_role') && session()->get('login_role') == $user->IsDinamizador() || session()->get('login_role') == $user->IsExperto() || session()->get('login_role') == $user->IsAdministrador();
    }

    /**
     * Determine whether the user can show any material.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Material  $material
     * @return bool
     */
    public function show(User $user, Material $material)
    {
        if (session()->get('login_role') == $user->IsAdministrador() || session()->get('login_role') == $user->IsActivador()) {
            return true;
        }
        if (session()->get('login_role') == $user->IsDinamizador() && $material->nodo_id == $user->dinamizador->nodo_id) {
            return true;
        }
        if (session()->get('login_role') == $user->IsExperto() && $material->lineatecnologica_id == $user->gestor->lineatecnologica_id && $material->nodo_id == $user->gestor->nodo_id) {
            return true;
        }
        return false;
    }


    /**
     * Determine whether the user can edit any material.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Material  $material
     * @return bool
     */
    public function edit(User $user, Material $material)
    {
        return (bool) (session()->get('login_role') == $user->IsAdministrador()) ||
        (session()->get('login_role') == $user->IsDinamizador() && $material->nodo->id == $user->dinamizador->nodo->id) || 
        (session()->get('login_role') == $user->IsExperto() && $material->lineatecnologica->id == $user->gestor->lineatecnologica->id && $material->nodo->id == $user->gestor->nodo->id);
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
        return (bool) $user->hasAnyRole([$user->IsDinamizador(), $user->IsExperto()]) && (session()->get('login_role') == $user->IsDinamizador() && $material->nodo->id == $user->dinamizador->nodo->id) || (session()->get('login_role') == $user->IsExperto() && $material->lineatecnologica->id == $user->gestor->lineatecnologica->id && $material->nodo->id == $user->gestor->nodo->id);
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
        return (bool) (session()->get('login_role') == $user->IsAdministrador()) ||
        (session()->get('login_role') == $user->IsDinamizador() && $material->nodo->id == $user->dinamizador->nodo->id) || 
        (session()->get('login_role') == $user->IsExperto() && $material->lineatecnologica->id == $user->gestor->lineatecnologica->id && $material->nodo->id == $user->gestor->nodo->id);
    }
}
