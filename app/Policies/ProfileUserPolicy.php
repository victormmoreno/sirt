<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProfileUserPolicy
{
    use HandlesAuthorization;


    // public function before($user)
    // {
    //     if($user->hasRole('Administrador')){
    //         return true;
    //     }
    
    // }
    
    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return bool
     */
    public function view(User $authUser, User $user)
    {
        return $authUser->id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        $user->hasPermissionTo('crear usuarios');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return bool
     */
    public function update(User $authUser, User $user)
    {
        // return $authUser->id === $user->id || $user->hasPermissionTo('actualizar usuarios');
        return $authUser->id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return bool
     */
    public function delete(User $user, User $model)
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
    public function restore(User $user, User $model)
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
    public function forceDelete(User $user, User $model)
    {
        //
    }
}
