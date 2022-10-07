<?php

namespace App\Policies\ArticulacionPbt;

use App\Models\ArticulacionPbt;
use App\Models\Nodo;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Spatie\Permission\Models\Role;

class ArticulacionPbtPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the articulaciones.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function index(User $user)
    {

        return (bool) $user->hasAnyRole([User::IsAdministrador(), User::IsActivador(), User::IsDinamizador(), User::IsArticulador(), User::IsTalento()]) &&
            session()->has('login_role')
            && (session()->get('login_role') == User::IsAdministrador()
            || session()->get('login_role') == User::IsActivador()
            || session()->get('login_role') == User::IsDinamizador()
            || session()->get('login_role') == User::IsArticulador()
            || session()->get('login_role') == User::IsTalento());
    }


    /**
     * Determine whether the user can create a articulacion.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        return (bool) $user->hasAnyRole([User::IsArticulador()])
            && session()->has('login_role')
            && session()->get('login_role') == User::IsArticulador();
    }

    /**
     * Determine si un usuario puede crear nuevas articulaciones.
     * @author julian londono
     * @return boolean
     */
    public function store(User $user)
    {

        return (bool) collect($user->getRoleNames())->contains(User::IsArticulador()) && session()->get('login_role') == User::IsArticulador();
    }


    /**
     * Determine si un usuario puede ver el listado en datatables.
     * @author julian londono
     * @return boolean
     */
    public function datatable(User $user)
    {
        return (bool) ($user->hasAnyRole([User::IsAdministrador(), User::IsDinamizador(), User::IsArticulador(), User::IsTalento()]) &&
        session()->has('login_role')
        && (session()->get('login_role') == User::IsAdministrador()
        || session()->get('login_role') == User::IsActivador()
        || session()->get('login_role') == User::IsDinamizador()
        || session()->get('login_role') == User::IsArticulador()
        || session()->get('login_role') == User::IsTalento())) && request()->ajax();
    }


    /**
     * Determine si un usuario puede ver el detalle de las articulaciones.
     * @author julian londono
     * @return boolean
     */
    public function show(User $user, ArticulacionPbt $articulacionPbt)
    {
        return (bool) $user->hasAnyRole([User::IsAdministrador(), User::IsActivador(), User::IsDinamizador(), User::IsArticulador(), User::IsTalento()]) &&
        session()->has('login_role')
        && (
            (session()->get('login_role') == User::IsAdministrador() ||  session()->get('login_role') == User::IsActivador())
            ||(session()->get('login_role') == User::IsDinamizador() && $user->dinamizador->nodo_id == $articulacionPbt->nodo_id)
            || (session()->get('login_role') == User::IsArticulador() && $user->articulador->nodo_id == $articulacionPbt->nodo_id)
            || (
                session()->get('login_role') == User::IsTalento()  &&
                $articulacionPbt->talentos()->wherePivot('talento_id', $user->talento->id)->first()
                )
            );
    }

    /**
     * Determine si un usuario puede actualizar entregables.
     * @author julian londono
     * @return boolean
     */
    public function updateEntregable(User $user)
    {
        return (bool) collect($user->getRoleNames())->contains(User::IsArticulador()) && session()->get('login_role') == User::IsArticulador();
    }

    /**
     * Determine whether the user can download all data of the articulacionPbt.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function downloadAll(User $user)
    {
        return (bool) $user->hasAnyRole([User::IsAdministrador(),User::IsActivador(), User::IsDinamizador(), User::IsArticulador()]) &&
        session()->has('login_role')
        && (session()->get('login_role') == User::IsAdministrador()
        || session()->get('login_role') == User::IsActivador()
        || session()->get('login_role') == User::IsDinamizador()
        || session()->get('login_role') == User::IsArticulador());
    }

    /**
     * Determine if the given articulacionespbt can be view listNodes by the user.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function listNodes(User $user): bool
    {
        return (bool) $user->hasAnyRole([User::IsAdministrador(), User::IsActivador()])
            && session()->has('login_role')
            && (
                session()->get('login_role') == User::IsAdministrador()
                || session()->get('login_role') == User::IsActivador()
        );
    }

    /**
     * Determinar si un usuario puede reversar una fase de una articulacion
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function reversePhase(User $user, ArticulacionPbt $articulacionPbt): bool
    {
        return (bool) $user->hasAnyRole([User::IsDinamizador()])
            && session()->has('login_role')
            && (
                session()->get('login_role') == User::IsDinamizador() &&
                auth()->user()->dinamizador->nodo_id == $articulacionPbt->nodo_id
            ) && !$articulacionPbt->present()->articulacionPbtIssetFase(\App\Models\Fase::IsInicio()) && !$articulacionPbt->present()->articulacionPbtIssetFase(\App\Models\Fase::IsFinalizado());
    }

    /**
     * Determinar si un usuario puede reversar una fase de una articulacion
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function permissionsOptions(User $user, ArticulacionPbt $articulacionPbt): bool
    {

        return (bool)
            session()->has('login_role')
            && (
                session()->get('login_role') != User::IsAdministrador() && session()->get('login_role') != User::IsActivador()
            ) && !$articulacionPbt->present()->articulacionPbtIssetFase(\App\Models\Fase::IsFinalizado());
    }

    /**
     * Determinar si un usuario puede reversar una fase de una articulacion
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function updateMiembros(User $user, ArticulacionPbt $articulacionPbt): bool
    {

        return (bool)
            session()->has('login_role')
            && (
                session()->get('login_role') == User::IsArticulador() && $user->articulador->nodo_id == $articulacionPbt->nodo_id
            ) && !$articulacionPbt->present()->articulacionPbtIssetFase(\App\Models\Fase::IsSuspendido());
    }

    /**
     * Determinar si un usuario puede suspender una articulacion
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function suspender(User $user, ArticulacionPbt $articulacionPbt): bool
    {

        return (bool)
            session()->has('login_role')
            && (
                session()->get('login_role') == User::IsArticulador() && $user->articulador->nodo_id == $articulacionPbt->nodo_id
            ) && !$articulacionPbt->present()->articulacionPbtIssetFase(\App\Models\Fase::IsSuspendido());
    }

    /**
     * Determinar si un usuario puede suspender una articulacion
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function changeAsesor(User $user, ArticulacionPbt $articulacionPbt): bool
    {

        return (bool)
            session()->has('login_role')
            && (
                session()->get('login_role') == User::IsDinamizador() && $user->dinamizador->nodo_id == $articulacionPbt->nodo_id
            ) && !$articulacionPbt->present()->articulacionPbtIssetFase(\App\Models\Fase::IsSuspendido());
    }



}
