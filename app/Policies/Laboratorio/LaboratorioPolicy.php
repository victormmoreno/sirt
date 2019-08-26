<?php

namespace App\Policies\Laboratorio;

use App\Models\Laboratorio;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LaboratorioPolicy
{
    use HandlesAuthorization;

    // public function before($user, $ability)
    // {
    //     if ($user->getRoleNames()->contains(User::IsAdministrador())) {
    //         return true;
    //     }
    // }

    /**
     * Determine whether the user can view any laboratorios.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function viewAny(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can view the laboratorio.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Laboratorio  $laboratorio
     * @return bool
     */
    public function view(User $user, Laboratorio $laboratorio)
    {
        return $user->id === 1;
        // if (collect($user->getRoleNames())->contains(User::IsAdministrador())) {
        //     return true;
        // } else if (collect($user->getRoleNames())->contains(User::IsDinamizador()) && $user->dinamizador->nodo->getLaboratorioIds()->contains($laboratorio->id)) {
        //     return true;
        // }

    }

    /**
     * Determine whether the user can create laboratorios.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function create(User $authUser)
    {

        if (collect($authUser->getRoleNames())->contains(User::IsAdministrador()) && session()->get('login_role') == User::IsAdministrador()) {
            return false;
        } else if (collect($authUser->getRoleNames())->contains(User::IsDinamizador()) && session()->get('login_role') == User::IsDinamizador()) {
            return true;
        } else if ($authUser->hasPermissionTo('Crear Laboratorio')) {
            return true;
        }
    }

    public function edit(User $user, Laboratorio $laboratorio)
    {
        if (collect($user->getRoleNames())->contains(User::IsAdministrador()) && session()->get('login_role') == User::IsAdministrador()) {
            return true;
        } else if (collect($user->getRoleNames())->contains(User::IsDinamizador()) && $user->dinamizador->nodo->getLaboratorioIds()->contains($laboratorio->id) && session()->get('login_role') == User::IsDinamizador()) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the laboratorio.
     *
     * @param  \App\User  $user
     * @param  \App\Laboratorio  $laboratorio
     * @return mixed
     */
    public function update(User $user, Laboratorio $laboratorio)
    {
        if (collect($user->getRoleNames())->contains(User::IsAdministrador())) {
            return true;
        } else if (collect($user->getRoleNames())->contains(User::IsDinamizador()) && $user->dinamizador->nodo->getLaboratorioIds()->contains($laboratorio->id)) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the laboratorio.
     *
     * @param  \App\User  $user
     * @param  \App\Laboratorio  $laboratorio
     * @return mixed
     */
    public function delete(User $user, Laboratorio $laboratorio)
    {
        //
    }

    /**
     * Determine whether the user can restore the laboratorio.
     *
     * @param  \App\User  $user
     * @param  \App\Laboratorio  $laboratorio
     * @return mixed
     */
    public function restore(User $user, Laboratorio $laboratorio)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the laboratorio.
     *
     * @param  \App\User  $user
     * @param  \App\Laboratorio  $laboratorio
     * @return mixed
     */
    public function forceDelete(User $user, Laboratorio $laboratorio)
    {
        //
    }
}
