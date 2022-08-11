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
    public function showActivadorFilter(User $user)
    {
        if (session()->get('login_role') == $user->IsAdministrador() || session()->get('login_role') == $user->IsActivador()) {
            return true;
        }
        return false;
    }

    /**
     * Determina quien puede ver el filtro para buscar proyectos de un nodo
     *
     * @param App\User $user
     * @return bool
     * @author dum
     **/
    public function showPersonalNodoFilter(User $user)
    {
        if (session()->get('login_role') == $user->IsDinamizador() || session()->get('login_role') == $user->IsInfocenter() || session()->get('login_role') == $user->IsArticulador()) {
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
     * Determina quien puede ver el filtro para ver los proyectos de un experto
     *
     * @param App\User $user
     * @return bool
     * @author dum
     **/
    public function showTalentoFilter(User $user)
    {
        if (session()->get('login_role') == $user->IsTalento()) {
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
     * Determina quienes pueden ver las opciones que tiene el administrador
     * 
     * @param \App\User $user
     * @return bool
     * @author dum
     */
    public function showOptionsForAdministrador(User $user)
    {
        if (session()->get('login_role') == $user->IsAdministrador()) {
            return true;
        }
        return false;
    }

    /**
     * Determina quienes pueden ver las opciones que tiene el activador
     * 
     * @param \App\User $user
     * @return bool
     * @author dum
     */
    public function showOptionsForActivador(User $user)
    {
        if (session()->get('login_role') == $user->IsAdministrador() || session()->get('login_role') == $user->IsActivador()) {
            return true;
        }
        return false;
    }

    /**
     * Determina quienes pueden ver las opciones para un proyecto
     * 
     * @param \App\User $user
     * @return bool
     * @author dum
     */
    public function showOptionsForFuncionarios(User $user)
    {
        if (session()->get('login_role') == $user->IsAdministrador() || session()->get('login_role') == $user->IsActivador() || session()->get('login_role') == $user->IsDinamizador() || session()->get('login_role') == $user->IsExperto()) {
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
        $ult_notificacion = $proyecto->notificaciones()->where('fase_id',  $proyecto->fase_id)->where('estado', ControlNotificaciones::IsPendiente())->get()->last();
        if ($ult_notificacion != null) {
            if (session()->get('login_role') == $user->IsAdministrador() || session()->get('login_role') == $user->IsDinamizador() || session()->get('login_role') == $user->IsTalento()) {
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
    
}
