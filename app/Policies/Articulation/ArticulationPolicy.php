<?php

namespace App\Policies\Articulation;

use App\Models\Articulation;
use App\Models\ControlNotificaciones;
use App\Models\Fase;
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
     * Determine if the given articulations can be change talent by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Articulation  $articulation
     * @return bool
     */
    public function changeTalents(User $user, Articulation $articulation):bool
    {
        return (bool) $user->hasAnyRole([
                User::IsActivador(),
                User::IsArticulador()
            ])
            && (session()->has('login_role')
                && (
                    session()->get('login_role') == User::IsActivador()
                    || session()->get('login_role') == User::IsArticulador()
                )
            ) && $articulation->phase_id != Fase::IsFinalizado();
    }

    /**
     * Determine if the given articulations can be change talent by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\$articulation  $articulation
     * @return bool
     */
    public function updatePhaseClosing(User $user, Articulation $articulation):bool
    {
        return (bool) $user->hasAnyRole([
                User::IsActivador(),
                User::IsArticulador()
            ])
            && (session()->has('login_role')
                && (
                    session()->get('login_role') == User::IsActivador()
                    || session()->get('login_role') == User::IsArticulador()
                )
            ) && $articulation->phase_id == Fase::IsCierre();
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
                && session()->get('login_role') == User::IsArticulador()
            ) && $articulation->phase_id == Fase::IsCierre();
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
        return $articulation->phase_id == Fase::IsEjecucion();
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
        if($articulation->phase_id == Fase::IsInicio()){
            return true;
        }
        return false;

    }

    public function show(User $user, Articulation $articulation)
    {
        return
            session()->has('login_role')
            && (
                session()->get('login_role') == User::IsActivador() ||
                (session()->get('login_role') == User::IsDinamizador() && auth()->user()->dinamizador->nodo->id == $articulation->articulationstage->node_id) ||
                (session()->get('login_role') == User::IsArticulador() && auth()->user()->articulador->nodo->id == $articulation->articulationstage->node_id) ||
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
                User::IsActivador(),
                User::IsArticulador()
            ])
            && (session()->has('login_role')
                && (
                    session()->get('login_role') == User::IsActivador()
                    || session()->get('login_role') == User::IsArticulador()
                )
            ) && $articulation->phase_id == Fase::IsCierre();
    }

    /**
     * Determina quienes y cuando se pueden ver los botones de aprobación o rechazo de un cambio de fase
     *
     * @param \App\User $user
     * @param \App\Models\Proyecto $ult_notificacion
     * @return bool
     * @author dum
     **/
    public function showButtonAprobacion(User $user, Articulation $articulation)
    {
        //$ult_notificacion = $articulationStage->notifications()->where('estado', ControlNotificaciones::IsPendiente())->get()->last();
        $ult_notificacion = $articulation->notifications()->get()->last();
        if ($ult_notificacion != null) {
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
}
