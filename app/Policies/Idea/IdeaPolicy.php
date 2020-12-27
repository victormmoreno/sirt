<?php

namespace App\Policies\Idea;

use App\User;
use App\Models\Idea;
use Illuminate\Auth\Access\HandlesAuthorization;

class IdeaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any ideas.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return (bool) $user->hasAnyRole([User::IsAdministrador(), User::IsDinamizador(), User::IsGestor(), User::IsInfocenter(), User::IsInicial()]);
    }

    /**
     * Determine whether the user can view the idea.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Idea  $idea
     * @return mixed
     */
    public function view(User $user)
    {
        return (bool) $user->hasAnyRole([User::IsAdministrador(), User::IsDinamizador(), User::IsGestor(), User::IsInfocenter(), User::IsInicial()]);
    }

    /**
     * Determine whether the user can update the idea.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Idea  $idea
     * @return mixed
     */
    public function update(User $user, Idea $idea)
    {
        return (bool) $user->hasAnyRole([User::IsInfocenter()]) && $user->infocenter->nodo_id == $idea->nodo->id;
    }

    /**
     * Determine whether the user can show the idea.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Idea  $idea
     * @return mixed
     */
    public function show(User $user, Idea $idea)
    {
        return (bool) $user->hasAnyRole([User::IsAdministrador(), User::IsDinamizador(), User::IsGestor(), User::IsInfocenter()]);
    }

    /**
     * Determine whether the user can restore the idea.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Idea  $idea
     * @return mixed
     */
    public function restore(User $user, Idea $idea)
    {
        //
    }
}
