<?php

namespace App\Policies\User;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserRoleSesionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $authUser)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function view(User $authUser, User $user)
    {
        // if ($authUser->hasRole(User::IsAdministrador()) && session()->get('login_role') == User::IsAdministrador()) {
        //     if ($authUser->id != $user->id && 
        //         $user->hasAnyRole([
        //             User::IsAdministrador(), 
        //             User::IsDinamizador()
        //         ]) && 
        //         !$user->hasAnyRole([
        //             User::IsGestor(), 
        //             User::IsInfocenter(),
        //             User::IsIngreso(),
        //             User::IsTalento(),
        //         ]) ) {

        //         return true;
        //     }
        // }

        // if ($authUser->hasRole(User::IsDinamizador()) &&  session()->get('login_role') == User::IsDinamizador()) {
        //     if ($authUser->id != $user->id && $user->hasAnyRole([User::IsGestor(), User::IsInfocenter(), User::IsIngreso()])) {
        //         return true;
        //     }
        // }

        // if ($authUser->hasRole(User::IsGestor()) && session()->get('login_role') == User::IsGestor()) {
        //     if ($authUser->id != $user->id &&
        //         $user->hasAnyRole([User::IsTalento()]) &&
        //         !$user->hasAnyRole([
        //             User::IsAdministrador(),
        //             User::IsDinamizador(),
        //             User::IsInfocenter(),
        //             User::IsGestor(),
        //             User::IsIngreso(),
        //         ])) {
        //         return true;
        //     }
        // }

    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $authUser)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function update(User $authUser, User $user)
    {
        if (collect($user->getRoleNames())->contains(session()->get('login_role')) || $authUser->id != $user->id) {
            return true;
        }

        // return collect($user->getRoleNames())->contains(session()->get('login_role'));
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function delete(User $authUser, User $user)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function restore(User $authUser, User $user)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function forceDelete(User $authUser, User $user)
    {
        //
    }
}
