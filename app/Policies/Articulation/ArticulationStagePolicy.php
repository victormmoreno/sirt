<?php

namespace App\Policies\Articulation;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\ArticulationStage;
use App\Models\ControlNotificaciones;

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
            && session()->get('login_role') == User::IsAdministrador()
            && (
                $ability != 'create' &&
                $ability != 'showButtonAprobacion' &&
                $ability != 'requestApproval'
            )) {
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
     * @return bool
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
     * @return bool
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
     * Determine if the given articulations can be create by the user.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function requestApproval(User $user, ArticulationStage $articulationStage): bool
    {
        return (bool) $user->hasAnyRole([User::IsArticulador()])
            && session()->has('login_role')
            && session()->get('login_role') == User::IsArticulador() &&
            (($articulationStage->status != ArticulationStage::STATUS_CLOSE && optional($articulationStage->end_date)->format('Y') > 2022 || is_null($articulationStage->end_date)));
    }


    public function changeState(User $user, ArticulationStage $articulationStage): bool
    {
        return (bool) session()->has('login_role')
            && session()->get('login_role') == User::IsAdministrador() &&
            (($articulationStage->status != ArticulationStage::STATUS_CLOSE && optional($articulationStage->end_date)->format('Y') > 2022 || is_null($articulationStage->end_date)));
    }




    /**
     * Determine if the given articulations can be show by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Models\ArticulationStage  $articulationStage
     * @return bool
     */
    public function show(User $user, ArticulationStage $articulationStage)
    {
        return
            session()->has('login_role')
            && (
                session()->get('login_role') == User::IsActivador() ||
                (session()->get('login_role') == User::IsDinamizador() && isset($user->dinamizador->nodo_id) && $user->dinamizador->nodo_id == $articulationStage->node_id) ||
                (session()->get('login_role') == User::IsArticulador() && isset($user->articulador->nodo->id) && $user->articulador->nodo->id == $articulationStage->node_id) ||
                (
                    session()->get('login_role') == User::IsTalento()
                    &&
                    (
                        $articulationStage->interlocutor()->where('id', $user->id)->first()
                        ||
                        $articulationStage->whereHas('articulations.users', function ($particpant) use($user) {
                            $particpant->where('user_id', $user->id);
                        })->first()
                    )

                )
            );
    }


    /**
     * Determine if the given articulations can be updated by the user..
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ArticulationStage  $articulationStage
     * @return bool
     */
    public function update(User $user, ArticulationStage $articulationStage)
    {
        return (bool) $user->hasAnyRole([User::IsArticulador()])
            && (session()->has('login_role') && (session()->get('login_role') == User::IsArticulador() || session()->get('login_role') == User::IsAdministrador()))
            && (isset($user->articulador) && $user->articulador->nodo->id == $articulationStage->node_id )
            && ($articulationStage->status != ArticulationStage::STATUS_CLOSE && optional($articulationStage->end_date)->format('Y') > 2022 || is_null($articulationStage->end_date));
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
                && (session()->has('login_role') && session()->get('login_role') == User::IsArticulador())
                && (isset($user->articulador) && $user->articulador->nodo_id == $articulationStage->node_id)
                && $articulationStage->articulations->count() == 0
                && ($articulationStage->status != ArticulationStage::STATUS_CLOSE && optional($articulationStage->end_date)->format('Y') > 2022 || is_null($articulationStage->end_date));
    }

    /**
     * Determine if the given articulations can be change talent by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ArticulationStage  $articulationStage
     * @return bool
     */
    public function changeTalent(User $user, ArticulationStage $articulationStage)
    {

        return (bool) $user->hasAnyRole([User::IsDinamizador(), User::IsArticulador()])
            && (
                    session()->has('login_role') &&
                    (
                        (session()->get('login_role') == User::IsDinamizador() && isset($user->dinamizador) && $user->dinamizador->nodo_id == $articulationStage->node_id)
                        || (session()->get('login_role') == User::IsArticulador() && isset($user->articulador) && $user->articulador->nodo_id == $articulationStage->node_id)
                    ) &&
                    ($articulationStage->status != ArticulationStage::STATUS_CLOSE && optional($articulationStage->end_date)->format('Y') > 2022 || is_null($articulationStage->end_date))
                );


    }
    /**
     * Determine if the given articulations can be updated by the user..
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ArticulationStage  $articulationStage
     * @return bool
     */
    public function downloadCertificateEnd(User $user, ArticulationStage $articulationStage)
    {
        return (bool) $user->hasAnyRole([User::IsArticulador()])
            && (session()->has('login_role') && session()->get('login_role') == User::IsArticulador())
            && ($user->articulador->nodo_id == $articulationStage->node_id)
            && ($articulationStage->has('articulations') && $articulationStage->articulations->count() > 0)
            && ($articulationStage->status != ArticulationStage::STATUS_CLOSE && optional($articulationStage->end_date)->format('Y') > 2022 || is_null($articulationStage->end_date));
    }

    /**
     * Determine if the given articulations can be updated by the user..
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ArticulationStage  $articulationStage
     * @return bool
     */
    public function downloadCertificateStart(User $user, ArticulationStage $articulationStage)
    {
        return (bool) $user->hasAnyRole([User::IsArticulador()])
            && ((session()->has('login_role') && session()->get('login_role') == User::IsArticulador()))
            && ($user->articulador->nodo_id == $articulationStage->node_id)
            && ($articulationStage->status != ArticulationStage::STATUS_CLOSE && optional($articulationStage->end_date)->format('Y') > 2022 || is_null($articulationStage->end_date));
    }
    /**
     * Determine if the given articulations can be Upload Evidences by the user..
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ArticulationStage  $articulationStage
     * @return bool
     */
    public function uploadEvidences(User $user, ArticulationStage $articulationStage)
    {
        return (bool) $user->hasAnyRole([User::IsArticulador()])
            && ( (session()->has('login_role')
                && (session()->get('login_role') == User::IsArticulador()|| session()->get('login_role') == User::IsAdministrador())))
            && ($user->articulador->nodo_id == $articulationStage->node_id)
            && ($articulationStage->articulations()->count() == 0 || $articulationStage->status == ArticulationStage::IsAbierto())
            && ($articulationStage->status != ArticulationStage::STATUS_CLOSE && optional($articulationStage->end_date)->format('Y') > 2022 || is_null($articulationStage->end_date));
    }

    /**
     * Determina quienes y cuando se pueden ver los botones de aprobación o rechazo de un cambio de fase
     *
     * @param \App\User $user
     * @param \App\Models\Proyecto $ult_notificacion
     * @return bool
     **/
    public function showButtonAprobacion(User $user, ArticulationStage $articulationStage)
    {
        $ult_notificacion = $articulationStage->notifications()->get()->last();
        //$ult_notificacion = $articulationStage->notifications()->latest('created_at')->first();
        if ($ult_notificacion != null && (isset($articulationStage->interlocutor_talent_id) && $articulationStage->interlocutor_talent_id == $user->id || ($user->IsDinamizador() && isset($user->dinamizador) && $user->dinamizador->nodo_id == $articulationStage->node_id))) {
            if (session()->get('login_role') == $user->IsAdministrador() || session()->get('login_role') == $user->IsDinamizador() || session()->get('login_role') == $user->IsTalento()) {
                if ($ult_notificacion->estado == $ult_notificacion->IsPendiente()) {
                    if (session()->get('login_role') == $user->IsAdministrador() && $ult_notificacion->estado == ControlNotificaciones::IsPendiente()) {
                        return true;
                    } else {
                        if ($ult_notificacion->receptor->id == auth()->user()->id && $ult_notificacion->rol_receptor->name == session()->get('login_role') && $ult_notificacion->estado == ControlNotificaciones::IsPendiente()) {
                            return true;
                        }
                    }
                }
            }
        }
    }
}
