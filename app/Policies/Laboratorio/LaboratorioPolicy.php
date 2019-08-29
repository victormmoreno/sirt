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
     * Determine whether the user can view the laboratorios.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Laboratorio  $laboratorio
     * @return bool
     */
    public function index(User $user)
    {
        return (bool) collect($user->getRoleNames())->contains(User::IsAdministrador()) && session()->get('login_role') == User::IsAdministrador() || collect($user->getRoleNames())->contains(User::IsDinamizador()) && session()->get('login_role') == User::IsDinamizador();
    }

    /**
     * Determine whether the user can create laboratorios.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function create(User $authUser)
    {
        return (bool) collect($authUser->getRoleNames())->contains(User::IsAdministrador()) && session()->get('login_role') == User::IsAdministrador() || collect($authUser->getRoleNames())->contains(User::IsDinamizador()) && session()->get('login_role') == User::IsDinamizador();
    }

    public function edit(User $user, Laboratorio $laboratorio)
    {

        return (bool) collect($user->getRoleNames())->contains(User::IsAdministrador()) && session()->get('login_role') == User::IsAdministrador() || collect($user->getRoleNames())->contains(User::IsDinamizador()) && session()->get('login_role') == User::IsDinamizador() && $user->dinamizador->nodo->getLaboratorioIds()->contains($laboratorio->id);
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
        return (bool) collect($user->getRoleNames())->contains(User::IsAdministrador()) || collect($user->getRoleNames())->contains(User::IsDinamizador()) && $user->dinamizador->nodo->getLaboratorioIds()->contains($laboratorio->id);

    }

}
