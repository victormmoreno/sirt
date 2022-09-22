<?php

namespace App\Policies\Articulation;

use App\Models\Articulation;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\ArticulationStage;
use Illuminate\Auth\Access\Response;

class ArticulationPolicy
{
    use HandlesAuthorization;

    /**
     * Perform pre-authorization checks.
     *
     * @param $user
     * @param  string  $ability
     * @return void|bool
     */
    public function before(User $user, $ability)
    {
        if ($user->hasAnyRole([User::IsAdministrador()])
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
        return (bool) $user->hasAnyRole([User::IsActivador()])
            && session()->has('login_role')
            && session()->get('login_role') == User::IsActivador();
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
     * Determine if the given articulations can be deleted by the user..
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ArticulationStage  $articulationStage
     * @return bool
     */
    public function delete(User $user, ArticulationStage $articulationStage)
    {
        return (bool) $user->hasAnyRole([User::IsArticulador(), User::IsDinamizador()])
            && (session()->has('login_role')
                && (session()->get('login_role') == User::IsArticulador() || session()->get('login_role') != User::IsAdministrador()))
            && auth()->user()->articulador->nodo->id == $articulationStage->node_id
            && $articulationStage->articulations->count() > 0;
        //$articulationSubtype->articulations->IsEmpty()
    }
}
