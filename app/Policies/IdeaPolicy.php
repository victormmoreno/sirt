<?php

namespace App\Policies;

use App\User;
use App\Models\{Idea, EstadoIdea};
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Str;

class IdeaPolicy
{
    use HandlesAuthorization;

    /**
     * Determina si el usuario puede registrar ideas
     *
     * @param User $user
     * @return bool
     * @author dum
     **/
    public function create(User $user)
    {
        if (session()->get('login_role') == $user->IsTalento()) {
            return true;
        }
        return false;
    }

    /**
     * Determina si el usuario puede usar filtros para consultar ideas
     *
     * @param App\User $user
     * @return bool
     * @author dum
     **/
    public function showFilters(User $user)
    {
        return (bool) Str::contains(session()->get('login_role'), [$user->IsDinamizador(), $user->IsInfocenter(), $user->IsAdministrador(), $user->IsActivador(), $user->IsExperto(), $user->IsArticulador()]);
    }

    /**
     * Determina quienes y en qué momento se puede aceptar o rechazar una idea de proyecto
     *
     * @param User $user
     * @param Idea $idea
     * @return bool
     * @author dum
     **/
    public function asignar(User $user, Idea $idea)
    {
        if (session()->get('login_role') == $user->IsAdministrador() || (session()->get('login_role') == $user->IsDinamizador() && $user->dinamizador->nodo_id == $idea->nodo_id)) {
            if ($idea->estadoIdea->nombre == $idea->estadoIdea->IsAdmitido() && $idea->gestor_id == null) {
                return true;
            }
        }
        return false;
    }

    /**
     * Determina quienes y en qué momento se puede aceptar o rechazar una idea de proyecto
     *
     * @param User $user
     * @param Idea $idea
     * @return bool
     * @author dum
     **/
    public function aprobar(User $user, Idea $idea)
    {
        if ($idea->estadoIdea->nombre == $idea->estadoIdea->IsPostulado()) {
            if (session()->get('login_role') == $user->IsArticulador() && $idea->nodo_id == $user->articulador->nodo_id) {
                return true;
            }
            if (session()->get('login_role') == $user->IsAdministrador()) {
                return true;
            }
        }
        return false;
    }

    /**
     * Determina quienes y en qué momento se puede duplicar una idea de proyecto
     *
     * @param User $user
     * @param Idea $idea
     * @return bool
     * @author dum
     **/
    public function duplicar(User $user, Idea $idea)
    {
        if (session()->get('login_role') == $user->IsTalento() && $user->talento->id == $idea->talento_id && ($idea->estadoIdea->nombre == $idea->estadoIdea->IsRechazadoComite() || $idea->estadoIdea->nombre == $idea->estadoIdea->IsPBT())) {
            return true;
        }
        if (session()->get('login_role') == $user->IsDinamizador() && $user->dinamizador->nodo_id == $idea->nodo_id) {
            return true;
        }
        if (session()->get('login_role') == $user->IsArticulador() && $user->articulador->nodo_id == $idea->nodo_id) {
            return true;
        }
        if (session()->get('login_role') == $user->IsInfocenter() && $user->infocenter->nodo_id == $idea->nodo_id) {
            return true;
        }
        if (session()->get('login_role') == $user->IsAdministrador()) {
            return true;
        }
        return false;
    }

    /**
     * Determina quienes y en qué momento se puede inhabilitar una idea de proyecto
     *
     * @param User $user
     * @param Idea $idea
     * @return bool
     * @author dum
     **/
    public function inhabilitar(User $user, Idea $idea)
    {
        if ($idea->estadoIdea->nombre == $idea->estadoIdea->IsInhabilitado()) {
            return false;
        }
        if (session()->get('login_role') == $user->IsTalento() && $user->talento->id == $idea->talento_id) {
            return true;
        }
        if (session()->get('login_role') == $user->IsDinamizador() && $user->dinamizador->nodo_id == $idea->nodo_id) {
            return true;
        }
        if (session()->get('login_role') == $user->IsArticulador() && $user->articulador->nodo_id == $idea->nodo_id) {
            return true;
        }
        if (session()->get('login_role') == $user->IsInfocenter() && $user->infocenter->nodo_id == $idea->nodo_id) {
            return true;
        }
        if (session()->get('login_role') == $user->IsAdministrador()) {
            return true;
        }
        return false;
    }

    /**
     * Determina quienes y en que momento puede realizar la postulación de la idea de proyecto al nodo
     * 
     * @param User $user
     * @param Idea $idea
     * @return bool
     * @author dum
     */
    public function postularIdea(User $user, Idea $idea)
    {
        if ($idea->estadoIdea->nombre == $idea->estadoIdea->IsRegistro()) {
            if (session()->get('login_role') == $user->IsTalento() && $user->talento->id == $idea->talento_id) {
                return true;
            }
            if (session()->get('login_role') == $user->IsAdministrador() || session()->get('login_role') == $user->IsActivador()) {
                return true;
            }
        }
        return false;
    }

    /**
     * Determinar quienes pueden consultar ideas de otros nodos
     *
     * @param User $user
     * @return bool
     * @author dum
     **/
    public function showNodosInput(User $user)
    {
        if (session()->get('login_role') == $user->IsAdministrador() || session()->get('login_role') == $user->IsActivador()) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the idea.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Idea  $idea
     * @return mixed
     */
    public function index(User $user)
    {
        return (bool) Str::contains(session()->get('login_role'), [$user->IsTalento(), $user->IsDinamizador(), $user->IsInfocenter(), $user->IsAdministrador(), $user->IsActivador(), $user->IsExperto(), $user->IsArticulador()]);
    }

    /**
     * Determine whether the user can export ideas.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Idea  $idea
     * @return mixed
     */
    public function export(User $user)
    {
        return (bool) Str::contains(session()->get('login_role'), [$user->IsDinamizador(), $user->IsInfocenter(), $user->IsAdministrador(), $user->IsActivador(), $user->IsExperto(), $user->IsArticulador()]);
    }

    /**
     * Determine whether the user can update the idea.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Idea  $idea
     * @return bool
     */
    public function update(User $user, Idea $idea)
    {
        if ($idea->estadoIdea->nombre == EstadoIdea::IsRegistro() && session()->get('login_role') == $user->IsTalento() && $user->talento->id == $idea->talento_id) {
            return true;
        }
        if (session()->get('login_role') == $user->IsAdministrador()) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can show the idea.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Idea  $idea
     * @return bool
     */
    public function show(User $user, Idea $idea)
    {
        if (session()->get('login_role') == $user->IsAdministrador() || session()->get('login_role') == $user->IsActivador()) {
            return true;
        }
        if (session()->get('login_role') == $user->IsTalento() && $idea->talento_id == $user->talento->id) {
            return true;
        }
        if ((Str::contains(session()->get('login_role'), [$user->IsDinamizador(), $user->IsInfocenter(), $user->IsArticulador(), $user->IsExperto()])) && $idea->nodo_id == $user->getNodoUser()) {
            return true;
        }
        return false;

    }
    
}
