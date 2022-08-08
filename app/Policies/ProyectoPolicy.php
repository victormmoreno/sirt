<?php

namespace App\Policies;

use App\User;
use App\Models\{Proyecto, ControlNotificaciones};
use Illuminate\Auth\Access\HandlesAuthorization;

class ProyectoPolicy
{
    use HandlesAuthorization;

    /** 
     * Determina quienes pueden ver y usar el botón de crear proyectos
     * 
     * @param App\User $user
     * @return bool
     * @author dum
    */
    public function showCreateButton(User $user)
    {
        if (session()->get('login_role') == $user->IsAdministrador() || session()->get('login_role') == $user->IsGestor()) {
            return true;
        }
        return false;
    }

    /**
     * Determina cuando se pueden ver los botones de update
     *
     * @param App\User $user
     * @param App\Models\Proyecto $proyecto
     * @param string $fase
     * @return bool
     * @author dum
     **/
    public function showUpdateButton(User $user, Proyecto $proyecto, string $fase)
    {
        if (session()->get('login_role') == $user->IsAdministrador()) {
            return true;
        } else {
            if ($proyecto->present()->proyectoFase() == $fase) {
                return true;
            }
            return false;
        }
        return false;
    }

    /**
     * Determina cuando se puede ver el botón para enviar notificaciones de aprobación
     *
     * @param App\User $user
     * @param App\Models\Proyecto $proyecto
     * @return bool
     * @author dum
     **/
    public function showNotificationButton(User $user, Proyecto $proyecto)
    {
        if ($proyecto->present()->proyectoFase() == $proyecto->IsFinalizado() || $proyecto->present()->proyectoFase() == $proyecto->IsSuspendido()) {
            return false;
        }
        return true;
    }

    /**
     * Determina quien puede ver el filtro para buscar proyectos de un nodo
     *
     * @param App\User $user
     * @return bool
     * @author dum
     **/
    public function showPorNodoFilter(User $user)
    {
        if (session()->get('login_role') == $user->IsAdministrador() || session()->get('login_role') == $user->IsActivador() || session()->get('login_role') == $user->IsDinamizador() || session()->get('login_role') == $user->IsInfocenter() || session()->get('login_role') == $user->IsArticulador()) {
            return true;
        }
        return false;
    }

    /**
     * Determina quien puede ver el filtro para ver los proyectos de un experto
     *
     * @param App\User $user
     * @return bool
     * @author dum
     **/
    public function showExpertoFilter(User $user)
    {
        if (session()->get('login_role') == $user->IsGestor()) {
            return true;
        }
        return false;
    }

    /**
     * Determina quienes pueden ver las opciones que tiene el experto
     * 
     * @param \App\User $user
     * @return bool
     * @author dum
     */
    public function showOptionsForExperto(User $user)
    {
        if (session()->get('login_role') == $user->IsAdministrador() || session()->get('login_role') == $user->IsGestor()) {
            return true;
        }
        return false;
    }

    /**
     * Determina quienes pueden ver las opciones que tiene el dinamizador
     * 
     * @param \App\User $user
     * @return bool
     * @author dum
     */
    public function showOptionsForDinamizador(User $user)
    {
        if (session()->get('login_role') == $user->IsAdministrador() || session()->get('login_role') == $user->IsDinamizador()) {
            return true;
        }
        return false;
    }


    /**
     * Determina quienes y cuando se pueden ver los botones de aprobación o rechazo de un cambio de fase
     *
     * @param \App\User $user
     * @param \App\Models\Proyecto $ult_notificacion
     * @return bool
     * @author dum
     **/
    public function showButtonAprobacion(User $user, Proyecto $proyecto)
    {
        // if ($proyecto->fase->nombre == $proyecto->IsSuspendido()) {
        //     $ult_notificacion = $proyecto->notificaciones()->where('fase_id',  Fase::where('nombre', $proyecto->IsSuspendido())->first()->id)->whereNull('fecha_aceptacion')->get()->last();

        // } else {
        // }
        $ult_notificacion = $proyecto->notificaciones()->where('fase_id',  $proyecto->fase_id)->where('estado', ControlNotificaciones::IsPendiente())->get()->last();
        if ($ult_notificacion != null) {
            if (session()->get('login_role') == $user->IsAdministrador() || session()->get('login_role') == $user->IsDinamizador() || session()->get('login_role') == $user->IsGestor()) {
                if ($ult_notificacion->estado == $ult_notificacion->IsPendiente()) {
                    if (session()->get('login_role') == $user->IsAdministrador()) {
                        return true;
                    } else {
                        if ($ult_notificacion->receptor->id == auth()->user()->id && $ult_notificacion->rol_receptor->name == session()->get('login_role')) {
                            return true;
                        }
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
        return false;
    }
    
    /**
     * Determine whether the user can view any proyectos.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the proyecto.
     *
     * @param  \App\User  $user
     * @param  \App\App\Models\Proyecto  $proyecto
     * @return mixed
     */
    public function view(User $user, Proyecto $proyecto)
    {
        //
    }

    /**
     * Determine whether the user can create proyectos.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the proyecto.
     *
     * @param  \App\User  $user
     * @param  \App\App\Models\Proyecto  $proyecto
     * @return mixed
     */
    public function update(User $user, Proyecto $proyecto)
    {
        //
    }

    /**
     * Determine whether the user can delete the proyecto.
     *
     * @param  \App\User  $user
     * @param  \App\App\Models\Proyecto  $proyecto
     * @return mixed
     */
    public function delete(User $user, Proyecto $proyecto)
    {
        //
    }

    /**
     * Determine whether the user can restore the proyecto.
     *
     * @param  \App\User  $user
     * @param  \App\App\Models\Proyecto  $proyecto
     * @return mixed
     */
    public function restore(User $user, Proyecto $proyecto)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the proyecto.
     *
     * @param  \App\User  $user
     * @param  \App\App\Models\Proyecto  $proyecto
     * @return mixed
     */
    public function forceDelete(User $user, Proyecto $proyecto)
    {
        //
    }
}
