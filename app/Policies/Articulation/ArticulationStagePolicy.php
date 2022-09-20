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
     * @param  \App\User  $user
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
    public function index(User $user): bool
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
                session()->get('login_role') == User::IsDinamizador() ||
                session()->get('login_role') == User::IsArticulador() ||
                session()->get('login_role') == User::IsTalento()
            );
    }

    /**
     * Determine if the given user can be view nodes by the articulationstage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Auth\Access\Response
     */
    public function viewNodes(User $user)
    {
        return (bool) $user->hasAnyRole([User::IsActivador()])
            && session()->has('login_role')
            && session()->get('login_role') == User::IsActivador();
    }

    /**
     * Determine if the given articulations can be view listNodes by the user.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function listNodes(User $user): bool
    {
        return (bool) $user->hasAnyRole([User::IsActivador()])
            && session()->has('login_role')
            && session()->get('login_role') == User::IsActivador();
    }

    /**
     * Determine if the given user can be downloadReports by the articulationstage.
     * @param  \App\User  $user
     * @return \Illuminate\Auth\Access\Response
     */
    public function downloadReports(User $user)
    {
        return (bool) $user->hasAnyRole([
                User::IsActivador(),
                User::IsDinamizador(),
                User::IsArticulador()
            ])
            && session()->has('login_role')
            && (
                session()->get('login_role') == User::IsActivador() ||
                session()->get('login_role') == User::IsDinamizador() ||
                session()->get('login_role') == User::IsArticulador()
            );
    }

    /**
     * Determine if the given articulations can be create by the user.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return (bool) $user->hasAnyRole([User::IsArticulador()])
            && session()->has('login_role')
            && session()->get('login_role') == User::IsArticulador();
    }

    /**
     * Determine if the given articulations can be show by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Models\ArticulationStage  $articulationStage
     * @return bool
     */
    public function show(User $user, ArticulationStage $articulationStage): bool
    {
        return (bool) $user->hasAnyRole([
                User::IsActivador(),
                User::IsDinamizador(),
                User::IsArticulador(),
                User::IsTalento()
            ])
            && session()->has('login_role')
            && (
                session()->get('login_role') == User::IsActivador() ||
                (session()->get('login_role') == User::IsDinamizador() && auth()->user()->dinamizador->nodo->id == $articulationStage->node_id) ||
                (session()->get('login_role') == User::IsArticulador() && auth()->user()->articulador->nodo->id == $articulationStage->node_id) ||
                (
                    session()->get('login_role') == User::IsTalento() && $articulationStage->where('interlocutor_talent_id', $user->id)
                        ->orWhereHas('articulations.users', function ($query) use($user) {
                            return $query->where('users.id', $user->id);
                        })
                )
            );
    }


    /**
     * Determine if the given articulations can be updated by the user..
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ArticulationStage  $articulationStage
     * @return \Illuminate\Auth\Access\Response
     */
    public function update(User $user, ArticulationStage $articulationStage)
    {
        return (bool) $user->hasAnyRole([User::IsArticulador()])
            && ( (session()->has('login_role')
            && session()->get('login_role') == User::IsArticulador()))
            && auth()->user()->articulador->nodo->id == $articulationStage->node_id;
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
        return (bool) $user->hasAnyRole([User::IsArticulador()])
                && (session()->has('login_role')
                && session()->get('login_role') == User::IsArticulador())
                && auth()->user()->articulador->nodo->id == $articulationStage->node_id
                && $articulationStage->articulations->count() <= 0;
    }

    /**
     * determine if the given archives can be destroy by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ArticulationStage  $articulationStage
     * @return bool
     */
    public function destroyFile(User $user, ArticulationStage $articulationStage): bool
    {
        return (bool) $user->hasAnyRole([User::IsArticulador()])
            && (session()->has('login_role')
                && session()->get('login_role') == User::IsArticulador())
            && auth()->user()->articulador->nodo->id == $articulationStage->node_id
            && $articulationStage->articulations->count() <= 0;
    }

    /**
     * Determine if the given archives can be download by the user.
     * @param  \App\Models\User  $user
     * @param  \App\Models\ArticulationStage  $articulationStage
     * @return bool
     */
    public function downloadFile(User $user, ArticulationStage $articulationStage): bool
    {
        return (bool) $user->hasAnyRole([
                User::IsActivador(),
                User::IsDinamizador(),
                User::IsArticulador(),
                User::IsTalento()
            ])
            && (session()->has('login_role')
                && (
                    session()->get('login_role') == User::IsActivador()
                    || session()->get('login_role') == User::IsDinamizador()
                    || session()->get('login_role') == User::IsArticulador()
                    || session()->get('login_role') == User::IsTalento()
                )
            );
    }
    /**
     * Determine if the given articulations can be change talent by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ArticulationStage  $articulationStage
     * @return bool
     */
    public function changeTalent(User $user, ArticulationStage $articulationStage):bool
    {
        return (bool) $user->hasAnyRole([
                User::IsActivador(),
                User::IsDinamizador(),
                User::IsArticulador()
            ])
            && (session()->has('login_role')
                && (
                    session()->get('login_role') == User::IsActivador()
                    || session()->get('login_role') == User::IsDinamizador()
                    || session()->get('login_role') == User::IsArticulador()
                )
            );
    }
}
