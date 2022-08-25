<?php

namespace App\Policies\Articulation;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\ArticulationStage;
use Illuminate\Auth\Access\Response;

class AccompanimentPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the given articulations can be store by the user..
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ArticulationStage  $articulations
     * @return \Illuminate\Auth\Access\Response
     */
    public function store(User $user)
    {
        return $user->hasAnyRole([User::IsArticulador()]);
    }

    /**
     * Determine if the given articulations can be updated by the user..
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ArticulationStage  $accompaniment
     * @return \Illuminate\Auth\Access\Response
     */
    public function update(User $user, ArticulationStage $accompaniment)
    {
        if($user->hasAnyRole([User::IsArticulador()]) &&  session()->get('login_role') == User::IsArticulador() &&  auth()->user()->articulador->nodo_id == $accompaniment->node_id)
        {
            return true;
        }
        return false;
    }
}
