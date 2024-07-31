<?php

namespace App\Policies;

use App\User;
use App\Models\{Proyecto, ControlNotificaciones, Fase};
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ProyectoPolicy
{
    use HandlesAuthorization;

    /**
     * Determina que usuarios pueden ver información sensible de un proyecto
     *
     * @param User $user
     * @return bool
     * @author dum
     **/
    public function showConfInformation(User $user)
    {
        if (Str::contains(session()->get('login_role'), [$user->IsTalento(), $user->IsUsuario()]))
            return false;
        return true;
    }

    /**
     * Determina quien y cuando se puede establecer una fecha para finalizar la ejecución de un 
     * proyecto cuando no se ha alcanzado la fecha estimada 
     *
     * @param User $user
     * @param Proyecto $proyecto
     * @return bool
     * @author dum
     **/
    public function solicitar_prorroga(User $user, Proyecto $proyecto)
    {
        if ( ($proyecto->prorrogas->count() >= 1 && ($proyecto->prorrogas()->get()->last()->fecha_ejecucion < Carbon::now()->format('Y-m-d')))  && Str::contains(session()->get('login_role'), [$user->IsExperto(), $user->IsAdministrador()])) {
            return true;
        }
        return false;
    }

    /**
     * Determina quien y cuando se puede establecer una fecha para finalizar la ejecución de un proyecto por primera vez
     *
     * @param User $user
     * @param Proyecto $proyecto
     * @return bool
     * @author dum
     **/
    public function solicitar_primera_fecha(User $user, Proyecto $proyecto)
    {
        if ( $proyecto->prorrogas->count() == 0 && $proyecto->fase->nombre == Proyecto::IsEjecucion()  && Str::contains(session()->get('login_role'), [$user->IsExperto(), $user->IsAdministrador()])) {
            return true;
        }
        return false;
    }

    /**
     * Determina quienes y cuando pueden subir entregables de una fase de proyecto
     *
     * @param App\User $user
     * @param App\Models\Proyecto $proyecto
     * @param string $fase Fase a la que se subirán los documentos
     * @return bool
     * @author dum
     **/
    public function adjuntar_entregables(User $user, Proyecto $proyecto, string $fase)
    {
        if (session()->get('login_role') == $user->IsAdministrador()) {
            return true;
        }
        if (session()->get('login_role') == $user->IsExperto() && $proyecto->asesor->id == request()->user()->id) {
            if ($proyecto->fase->nombre != $fase) {
                return false;
            }
            return true;
        }
        return false;
    }

    /** 
     * Determina quienes pueden ver el detalle de un proyecto en ejecución
     * 
     * @param App\User $user
     * @param App\Models\Proyecto $proyecto
     * @return bool
     * @author dum
    */
    public function detalle(User $user, Proyecto $proyecto)
    {
        if (Str::contains(session()->get('login_role'), [$user->IsActivador(), $user->IsAdministrador()]))
            return true;
        if (session()->get('login_role') == $user->IsExperto() && $proyecto->asesor->id == auth()->user()->id)
            return true;
        if (Str::contains(session()->get('login_role'), [$user->IsDinamizador(), $user->IsInfocenter(), $user->IsArticulador()]) && $proyecto->nodo_id == request()->user()->getNodoUser())
            return true;
        if (session()->get('login_role') == $user->IsTalento()) {
            $talento = $proyecto->talentos()->wherePivot('user_id', request()->user()->id)->first();
            if ($talento != null) {
                return true;
            }
        }
        return false;
    }

    /** 
     * Determina quienes pueden ver el detalle de un proyecto finalizado
     * 
     * @param App\User $user
     * @param App\Models\Proyecto $proyecto
     * @return bool
     * @author dum
    */
    public function detalle_end(User $user, Proyecto $proyecto)
    {
        if ($proyecto->present()->proyectoFase() == $proyecto->IsFinalizado() || $proyecto->present()->proyectoFase() == $proyecto->IsSuspendido()) {
            if (session()->get('login_role') == $user->IsAdministrador() || session()->get('login_role') == $user->IsActivador())
                return true;
            if (session()->get('login_role') == $user->IsExperto() && $proyecto->asesor->id == auth()->user()->id)
                return true;
            if (session()->get('login_role') == $user->IsDinamizador() && $proyecto->nodo_id == auth()->user()->dinamizador->nodo_id)
                return true;
            if (session()->get('login_role') == $user->IsInfocenter() && $proyecto->nodo_id == auth()->user()->infocenter->nodo_id)
                return true;
            if (session()->get('login_role') == $user->IsArticulador() && $proyecto->nodo_id == auth()->user()->articulador->nodo_id)
                return true;
            if (session()->get('login_role') == $user->IsTalento()) {
                $talento = $proyecto->talentos()->wherePivot('user_id', auth()->user()->id)->first();
                if ($talento != null) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Determina quienes y cuando puede eliminar archivos de un proyecto
     *
     * @param App\User $user
     * @param App\Models\Proyecto $proyecto
     * @param string $fase Fase de donde se eliminarán los proyectos
     * @author dum
     **/
    public function delete_files(User $user, Proyecto $proyecto, string $fase)
    {
        if ((session()->get('login_role') == $user->IsExperto() && $proyecto->asesor->id == request()->user()->id)) {
            if ($proyecto->fase->nombre == $fase) {
                return true;
            } else {
                return false;
            }
        }
        if (session()->get('login_role') == $user->IsAdministrador())
            return true;
        return false;
    }

    /** 
     * Determina quienes pueden generar documentos de un proyecto
     * 
     * @param App\User $user
     * @param App\Models\Proyecto $proyecto
     * @return bool
     * @author dum
    */
    public function generar_docs(User $user, Proyecto $proyecto)
    {
        if (session()->get('login_role') == $user->IsAdministrador())
            return true;
        if (session()->get('login_role') == $user->IsExperto() && $proyecto->experto_id == auth()->user()->id)
            return true;
        return false;
    }

    /** 
     * Determina quienes pueden cambiar talentos de un proyecto
     * 
     * @param App\User $user
     * @param App\Models\Proyecto $proyecto
     * @return bool
     * @author dum
    */
    public function cambiar_talentos(User $user, Proyecto $proyecto)
    {
        if ($proyecto->present()->proyectoFase() == $proyecto->IsFinalizado() || $proyecto->present()->proyectoFase() == $proyecto->IsSuspendido())
            return false;
        if (session()->get('login_role') == $user->IsAdministrador())
            return true;
        if (session()->get('login_role') == $user->IsExperto() && $proyecto->experto_id == auth()->user()->id)
            return true;
        return false;
    }

    /** 
     * Determina quienes pueden cambiar talentos de un proyecto
     * 
     * @param App\User $user
     * @param App\Models\Proyecto $proyecto
     * @return bool
     * @author dum
    */
    public function cambiar_gestor(User $user, Proyecto $proyecto)
    {
        if ($proyecto->present()->proyectoFase() == $proyecto->IsFinalizado() || $proyecto->present()->proyectoFase() == $proyecto->IsSuspendido())
            return false;
        if (session()->get('login_role') == $user->IsAdministrador())
            return true;
        if (session()->get('login_role') == $user->IsDinamizador() && $proyecto->nodo_id == request()->user()->getNodoUser())
            return true;
        return false;
    }

    /** 
     * Determina quienes pueden ver y usar el botón de crear proyectos
     * 
     * @param App\User $user
     * @return bool
     * @author dum
    */
    public function create(User $user)
    {
        if (session()->get('login_role') == $user->IsAdministrador() || session()->get('login_role') == $user->IsExperto()) {
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
    public function notificar_aprobacion(User $user, Proyecto $proyecto, $fase = null)
    {

        if (Str::contains($proyecto->fase->nombre, [$proyecto->IsFinalizado(), $proyecto->IsSuspendido()])) {
            return false;
        } else {
            if ($fase == $proyecto->IsSuspendido()) {
                return true;
            }
            if ( (session()->get('login_role') == $user->IsExperto() && $proyecto->asesor->id == auth()->user()->id) || session()->get('login_role') == $user->IsAdministrador() ) {
                if ($proyecto->fase->nombre == $proyecto->IsEjecucion() && !isset($proyecto->resultadosEncuesta)) {
                    if ($proyecto->EncuestasEnviadas()->get()->count() >= 3) {
                        return true;
                    }
                    return false;
                }
                return true;
            } else {
                return false;
            }
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
    public function showActivadorFilter(User $user)
    {
        if (Str::contains(session()->get('login_role'), [$user->IsAdministrador(), $user->IsActivador()])) {
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
        if (session()->get('login_role') == $user->IsExperto()) {
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
        if (session()->get('login_role') == $user->IsAdministrador() || session()->get('login_role') == $user->IsExperto()) {
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
    public function aprobar(User $user, Proyecto $proyecto)
    {
        $ult_notificacion = $proyecto->notificaciones()->where('fase_id',  $proyecto->fase_id)->where('estado', ControlNotificaciones::IsPendiente())->get()->last();
        if ($ult_notificacion != null) {
            if (session()->get('login_role') == $user->IsAdministrador() || session()->get('login_role') == $user->IsDinamizador() || session()->get('login_role') == $user->IsTalento()) {
                if ($ult_notificacion->estado == $ult_notificacion->IsPendiente()) {
                    if (session()->get('login_role') == $user->IsAdministrador()) {
                        return true;
                    } else {
                        if ($ult_notificacion->receptor->id == request()->user()->id && $ult_notificacion->rol_receptor->name == session()->get('login_role')) {
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
     * Determina quienes y cuando se pueden ver los botones de aprobación o rechazo de la cancelación del proyecto
     *
     * @param \App\User $user
     * @param \App\Models\Proyecto $ult_notificacion
     * @return bool
     * @author dum
     **/
    public function aprobar_suspendido(User $user, Proyecto $proyecto)
    {
        $ult_notificacion = $proyecto->notificaciones()->where('fase_id',  Fase::where('nombre', 'Cancelado')->first()->id)->where('estado', ControlNotificaciones::IsPendiente())->get()->last();
        if ($ult_notificacion != null) {
            if (session()->get('login_role') == $user->IsAdministrador() || session()->get('login_role') == $user->IsDinamizador()) {
                if ($ult_notificacion->estado == $ult_notificacion->IsPendiente()) {
                    if (session()->get('login_role') == $user->IsAdministrador()) {
                        return true;
                    } else {
                        if (session()->get('login_role') == $user->IsDinamizador() && $proyecto->nodo_id == request()->user()->getNodoUser()) {
                            if ($ult_notificacion->receptor->id == request()->user()->id && $ult_notificacion->rol_receptor->name == session()->get('login_role')) {
                                return true;
                            }
                        } else {
                            return false;
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
