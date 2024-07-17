<?php

namespace App\Policies\Articulation;

use App\Models\Articulation;
use App\Models\ControlNotificaciones;
use App\Models\Fase;
use App\User;
use App\Models\ArticulationStage;
use Illuminate\Auth\Access\HandlesAuthorization;

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
        if (
            $user->hasAnyRole([User::IsAdministrador()])
            && session()->has('login_role')
            && session()->get('login_role') == User::IsAdministrador()
            && (
                $ability != 'create' &&
                $ability != 'showButtonAprobacion'&&
                $ability != 'delete' &&
                // $ability != 'cancel' &&
                $ability != 'requestApproval' &&
                $ability != 'approvalCancel'
                // $ability != 'requestCancel'
                // $ability != 'uploadFiles'
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
    public function index(User $user)
    {
        return (bool)session()->has('login_role')
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
        return (bool) session()->has('login_role')
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
     * Determine if the given articulations can be change talent by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Articulation  $articulation
     * @return bool
     */
    public function changeTalents(User $user, Articulation $articulation):bool
    {
        return (bool) (session()->has('login_role')
                && (
                    session()->get('login_role') == User::IsArticulador()
                    && (isset($user->articulador) && isset($articulation->articulationstage)  && $user->articulador->nodo_id == $articulation->articulationstage->node_id)
                )
            )
            && ($articulation->phase_id != Fase::IsFinalizado() && $articulation->phase_id != Fase::IsSuspendido()) &&
            (isset($articulation->articulationstage) && $articulation->articulationstage->status != ArticulationStage::STATUS_CLOSE) &&
            (($articulation->phase_id != Fase::IsFinalizado()&& optional($articulation->end_date)->format('Y') > 2022 || is_null($articulation->end_date)));
    }

    /**
     * Determine if the given articulations can be change talent by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Articulation  $articulation
     * @return bool
     */
    public function updatePhaseClosing(User $user, Articulation $articulation):bool
    {
        return (bool) $user->hasAnyRole([
                User::IsArticulador()
            ])
            && (session()->has('login_role')
                && (
                    session()->get('login_role') == User::IsArticulador()
                    && (isset($user->articulador) && isset($articulation->articulationstage)  && $user->articulador->nodo_id == $articulation->articulationstage->node_id)
                )
            ) && $articulation->phase_id == Fase::IsCierre() &&
            (isset($articulation->articulationstage) && $articulation->articulationstage->status != ArticulationStage::STATUS_CLOSE) &&
            (($articulation->phase_id != Fase::IsFinalizado()&& optional($articulation->end_date)->format('Y') > 2022 || is_null($articulation->end_date)));
    }

    /**
     * Determine if the given articulations can be change talent by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Articulation  $articulation
     * @return bool
     */
    public function showClosing(User $user, Articulation $articulation):bool
    {
        return (bool) $user->hasAnyRole([
            User::IsArticulador()
        ])
        && (session()->has('login_role')
            && (
                session()->get('login_role') == User::IsArticulador()
                && (isset($user->articulador) && isset($articulation->articulationstage)  && $user->articulador->nodo_id == $articulation->articulationstage->node_id)
            )
        ) && $articulation->phase_id == Fase::IsCierre() &&
        (isset($articulation->articulationstage) && $articulation->articulationstage->status != ArticulationStage::STATUS_CLOSE) &&
        (($articulation->phase_id != Fase::IsFinalizado()&& optional($articulation->end_date)->format('Y') > 2022 || is_null($articulation->end_date)));
    }

    /**
     * Determine if the given articulations can be change talent by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Articulation  $articulation
     * @return bool
     */
    public function showExecution(User $user, Articulation $articulation):bool
    {
        return (bool) $user->hasAnyRole([
            User::IsArticulador()
        ])
        && (session()->has('login_role')
            && (
                session()->get('login_role') == User::IsArticulador()
                && (isset($user->articulador) && isset($articulation->articulationstage)  && $user->articulador->nodo_id == $articulation->articulationstage->node_id)
            )
        ) && $articulation->phase_id == Fase::IsEjecucion() &&
        (isset($articulation->articulationstage) && $articulation->articulationstage->status != ArticulationStage::STATUS_CLOSE) &&
        (($articulation->phase_id != Fase::IsFinalizado()&& optional($articulation->end_date)->format('Y') > 2022 || is_null($articulation->end_date)));
    }
    /**
     * Determine if the given articulations can be change talent by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Articulation $articulation
     * @return bool
     */
    public function showStart(User $user, Articulation $articulation):bool
    {
        return (bool) $user->hasAnyRole([
            User::IsArticulador()
        ])
        && (session()->has('login_role')
            && (
                session()->get('login_role') == User::IsArticulador()
                && (isset($user->articulador) && isset($articulation->articulationstage)  && $user->articulador->nodo_id == $articulation->articulationstage->node_id)
            )
        ) && $articulation->phase_id == Fase::IsInicio() &&
        (isset($articulation->articulationstage) && $articulation->articulationstage->status != ArticulationStage::STATUS_CLOSE) &&
        (($articulation->phase_id != Fase::IsFinalizado()&& optional($articulation->end_date)->format('Y') > 2022 || is_null($articulation->end_date)));


    }

    public function show(User $user, Articulation $articulation)
    {
        return
            session()->has('login_role')
            && (
                session()->get('login_role') == User::IsActivador() ||
                (session()->get('login_role') == User::IsDinamizador() && isset($user->dinamizador) && $user->dinamizador->nodo_id == $articulation->articulationstage->node_id) ||
                (session()->get('login_role') == User::IsArticulador() && isset($user->articulador) && $user->articulador->nodo_id == $articulation->articulationstage->node_id) ||
                (
                    session()->get('login_role') == User::IsTalento()
                    &&
                    (
                        (isset($articulation->articulationstage->interlocutor) && $articulation->articulationstage->interlocutor()->where('id', $user->id)->first())
                        ||
                        $articulation->whereHas('users', function ($particpant) use($user) {
                            $particpant->where('user_id', $user->id);
                        })->first()
                    )

                )
            );
    }

    /**
     * Determine if the given articulations can be change talent by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\$articulation  $articulation
     * @return bool
     */
    public function requestApproval(User $user, Articulation $articulation):bool
    {
        return (bool) $user->hasAnyRole([
                User::IsArticulador()
            ])
            && (session()->has('login_role')
                && (
                    session()->get('login_role') == User::IsArticulador()
                && (isset($user->articulador) && isset($articulation->articulationstage)  && $user->articulador->nodo_id == $articulation->articulationstage->node_id)
                )
            ) && $articulation->phase_id == Fase::IsCierre()
            &&
        (isset($articulation->articulationstage) && $articulation->articulationstage->status != ArticulationStage::STATUS_CLOSE) &&
        (($articulation->phase_id != Fase::IsFinalizado()&& optional($articulation->end_date)->format('Y') > 2022 || is_null($articulation->end_date)));
    }

    /**
     * Determina quienes y cuando se pueden ver los botones de aprobación o rechazo de un cambio de fase
     *
     * @param \App\User $user
     * @param \App\Models\Proyecto $ult_notificacion
     * @return bool
     * @author dum
     **/
    public function showButtonAprobacion(User $user, Articulation $articulation, string $fase = nulL)
    {

        $ult_notificacion = $articulation->notifications()->get()->last();
        if ($ult_notificacion != null && $articulation->phase_id == Fase::IsCierre() && $fase != Articulation::IsCancelado() && !is_null($fase)) {
            if (session()->get('login_role') == $user->IsAdministrador() || session()->get('login_role') == $user->IsDinamizador()) {
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

        if ($ult_notificacion != null  && $fase == Articulation::IsCancelado() && !is_null($fase)) {
            if (session()->get('login_role') == $user->IsAdministrador() || session()->get('login_role') == $user->IsDinamizador()) {
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

    /**
     * Determine if the given articulations can be change phase by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Articulation  $articulation
     * @return bool
     */
    public function changePhase(User $user, Articulation $articulation):bool
    {
        return (bool) (session()->has('login_role')
                && (
                    session()->get('login_role') == User::IsArticulador()
                    && (isset($user->articulador) && isset($articulation->articulationstage)  && $user->articulador->nodo_id == $articulation->articulationstage->node_id)
                )
            )
            && ($articulation->phase_id != Fase::IsFinalizado() && $articulation->phase_id != Fase::IsSuspendido()) &&
            (isset($articulation->articulationstage) && $articulation->articulationstage->status != ArticulationStage::STATUS_CLOSE) &&
            (($articulation->phase_id != Fase::IsFinalizado() && optional($articulation->end_date)->format('Y') > 2022 || is_null($articulation->end_date)));
    }

    /**
     * Determine if the given articulations can be deleted by the user..
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ArticulationStage  $articulationStage
     * @return bool
     */
    public function delete(User $user, Articulation $articulation)
    {
        return (bool)(
            session()->has('login_role') && (
                session()->get('login_role') == User::IsAdministrador()
            )
            && $articulation->phase_id != Fase::IsFinalizado() &&
            (isset($articulation->articulationstage) && $articulation->articulationstage->status != ArticulationStage::STATUS_CLOSE) &&
            (($articulation->phase_id != Fase::IsFinalizado()&& optional($articulation->end_date)->format('Y') > 2022 || is_null($articulation->end_date))));
    }

    /**
     * Determina quienes pueden generar documentos de un proyecto
     *
     * @param App\User $user
     * @param App\Models\Articulation $articulation
     * @return bool
    */
    public function generateDocumentAdvisory(User $user, Articulation $articulation)
    {
        return session()->get('login_role') == $user->IsAdministrador() ||
        (
            session()->get('login_role') == $user->IsArticulador() &&
            $articulation->articulationstage->node_id == auth()->user()->articulador->nodo_id &&
            $articulation->phase_id == Fase::IsEjecucion()
        );

    }

    /**
     * Determine if the given articulations can be Upload Evidences by the user..
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Articulation  $articulation
     * @return bool
     */
    public function uploadEvidences(User $user, Articulation $articulation, string $phase)
    {
        return (bool) $user->hasAnyRole([User::IsArticulador()])
            && ( (
                    session()->has('login_role')
                    && (
                        session()->get('login_role') == User::IsArticulador() ||
                        session()->get('login_role') == User::IsAdministrador()
                        )
                    )
                )
            && ($user->articulador->nodo_id == $articulation->articulationstage->node_id)
                && (isset($articulation->phase) && $articulation->phase->nombre == $phase)
            && (

                $articulation->articulationstage->status == ArticulationStage::IsAbierto() && optional($articulation->articulationstage->end_date)->format('Y') > 2022 || is_null($articulation->articulationstage->end_date)
            );
    }

    /**
     * Determine if the given articulations can be updated by the user..
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Articulation  $articulation
     * @return bool
     */
    public function downloadCertificateEnd(User $user, Articulation $articulation)
    {
        return (bool) $user->hasAnyRole([User::IsArticulador()])
            && (session()->has('login_role') && session()->get('login_role') == User::IsArticulador())
            && (isset($user->articulador->nodo_id) && $user->articulador->nodo_id == $articulation->articulationstage->node_id)
            && ($articulation->phase->nombre == Articulation::IsCierre());
    }

    /**
     * Determine if the given articulations can be updated by the user..
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Articulation  $articulation
     * @return bool
     */
    public function downloadCertificateStart(User $user, Articulation $articulation)
    {
        return (bool) $user->hasAnyRole([User::IsArticulador()])
        && (session()->has('login_role') && session()->get('login_role') == User::IsArticulador())
        && (isset($user->articulador->nodo_id) && $user->articulador->nodo_id == $articulation->articulationstage->node_id)
        && ($articulation->phase->nombre == Articulation::IsInicio());
    }

    /**
     * Determine if the given articulations can be canceled by the user..
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ArticulationStage  $articulationStage
     * @return bool
     */
    public function cancel(User $user, Articulation $articulation)
    {
        return (bool) $user->hasAnyRole([User::IsArticulador(), User::IsDinamizador()])
        && (session()->has('login_role') && (session()->get('login_role') == User::IsArticulador() || session()->get('login_role') == User::IsDinamizador()))
        && ((isset($user->articulador->nodo_id) && $user->articulador->nodo_id == $articulation->articulationstage->node_id) || (isset($user->dinamizador->nodo_id) && $user->dinamizador->nodo_id == $articulation->articulationstage->node_id))

        && ($articulation->phase->nombre != Articulation::IsFinalizado() || $articulation->phase->nombre != Articulation::IsCancelado());
    }

    /**
     * Determine if the given articulations can be change talent by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\$articulation  $articulation
     * @return bool
     */
    public function requestCancel(User $user, Articulation $articulation):bool
    {
        // dd($articulation->phase->nombre);
        return (bool) $user->hasAnyRole([
                User::IsArticulador()
            ])
            && (session()->has('login_role')
                && (
                    session()->get('login_role') == User::IsArticulador()
                && (isset($user->articulador) && isset($articulation->articulationstage)  && $user->articulador->nodo_id == $articulation->articulationstage->node_id)
                )
            )
            && ($articulation->phase->nombre != Articulation::IsFinalizado() && $articulation->phase->nombre != Articulation::IsCancelado())
        && (isset($articulation->articulationstage) && $articulation->articulationstage->status != ArticulationStage::STATUS_CLOSE);
    }

    public function approvalCancel(User $user, Articulation $articulation):bool
    {

        return (bool) $user->hasAnyRole([
                User::IsDinamizador()
            ])
            && (session()->has('login_role')
                && (
                    session()->get('login_role') == User::IsDinamizador()
                && (isset($user->dinamizador) && isset($articulation->articulationstage)  && $user->dinamizador->nodo_id == $articulation->articulationstage->node_id)
                )
            )
            && $articulation->phase->nombre != Articulation::IsFinalizado()
        && (isset($articulation->articulationstage) && $articulation->articulationstage->status != ArticulationStage::STATUS_CLOSE);
    }

    public function uploadFiles(User $user, Articulation $articulation): bool
    {
        return (bool) $user->hasAnyRole([
            User::IsArticulador()
        ])
        && (session()->has('login_role')
                && (
                    session()->get('login_role') == User::IsArticulador()
                && (isset($user->articulador) && isset($articulation->articulationstage)  && $user->articulador->nodo_id == $articulation->articulationstage->node_id)
                && $articulation->articulationstage->status != ArticulationStage::STATUS_CLOSE
                )
            )
        && $articulation->phase->nombre != Articulation::IsCancelado();
    }

    public function deleteFiles(User $user, Articulation $articulation): bool
    {
        return (bool) $user->hasAnyRole([
            User::IsArticulador()
        ])
        && (session()->has('login_role')
                && (
                    session()->get('login_role') == User::IsArticulador()
                && (isset($user->articulador) && isset($articulation->articulationstage)  && $user->articulador->nodo_id == $articulation->articulationstage->node_id)
                && $articulation->articulationstage->status != ArticulationStage::STATUS_CLOSE
                )
            )
        && $articulation->phase->nombre != Articulation::IsCancelado();
    }

}
