<?php

namespace App\Policies\Articulation;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\ArticulationStage;
use Illuminate\Auth\Access\Response;

class ArticulationStagePolicy
{
    use HandlesAuthorization;

    /**
     * Perform pre-authorization checks.
     *
     * @param  \App\Models\User  $user
     * @param  string  $ability
     * @return void|bool
     */
    public function before(User $user, $ability)
    {
        if ($user->hasAnyRole([User::IsArticulador()])
            && session()->has('login_role')
            && session()->get('login_role') == User::IsAdministrador()) {
            return true;
        }
    }
    /**
     * Determine whether the user can view the articulationStages.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function index(User $user)
    {
        return (bool) $user->hasAnyRole([
                User::IsActivador(),
                User::IsDinamizador(),
                User::IsArticulador(),
                User::IsTalento(),
            ])
            && session()->has('login_role')
            && (
                session()->get('login_role') == User::IsActivador() ||
                session()->get('login_role') != User::IsDinamizador() ||
                session()->get('login_role') != User::IsArticulador() ||
                session()->get('login_role') != User::IsTalento()
            );
    }

    /**
     * Determine if the given articulations can be view nodes by the user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response
     */
    public function viewNodes(User $user)
    {
        return (bool) $user->hasAnyRole([User::IsActivador()])
            && session()->has('login_role')
            && session()->get('login_role') == User::IsActivador();
    }

    public function listNodes(User $user)
    {
        return (bool) $user->hasAnyRole([User::IsAdministrador()])
            && session()->has('login_role')
            && session()->get('login_role') == User::IsAdministrador();
    }

    /**
     * Determine if the given articulations can be view nodes by the user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response
     */
    public function downloadReports(User $user)
    {
        return (bool) $user->hasAnyRole([
                User::IsActivador(),
                User::IsDinamizador(),
                User::IsArticulador(),
                User::IsTalento(),
            ])
            && session()->has('login_role')
            && (
                session()->get('login_role') == User::IsActivador() ||
                session()->get('login_role') != User::IsDinamizador() ||
                session()->get('login_role') != User::IsArticulador() ||
                session()->get('login_role') != User::IsTalento()
            );
    }

    /**
     * Determine if the given articulations can be create by the user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response
     */
    public function create(User $user)
    {
        return (bool) $user->hasAnyRole([User::IsArticulador()])
            && session()->has('login_role')
            && session()->get('login_role') == User::IsArticulador();
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
        return (bool) $user->hasAnyRole([User::IsArticulador()])
            && session()->has('login_role')
            && session()->get('login_role') == User::IsArticulador();
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
