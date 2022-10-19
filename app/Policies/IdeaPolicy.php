<?php

namespace App\Policies;

use App\User;
use App\Models\{Idea, EstadoIdea};
use Illuminate\Auth\Access\HandlesAuthorization;

class IdeaPolicy
{
    use HandlesAuthorization;

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
        if (session()->get('login_role') == $user->IsTalento() && $user->talento->id == $idea->talento_id) {
            return true;
        }
        if (session()->get('login_role') == $user->IsDinamizador() && $user->dinamizador->nodo_id == $idea->nodo_id) {
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
     * Determine whether the user can view any ideas.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return (bool) $user->hasAnyRole([User::IsActivador(), User::IsDinamizador(), User::IsGestor(), User::IsInfocenter(), User::IsArticulador()]);
    }

    /**
     * Determine whether the user can view the idea.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Idea  $idea
     * @return mixed
     */
    public function view(User $user)
    {
        return (bool) $user->hasAnyRole([User::IsActivador(), User::IsDinamizador(), User::IsGestor(), User::IsInfocenter(), User::IsArticulador()]);
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
        if (session()->get('login_role') == $user->IsTalento() && $user->talento->id == $idea->talento_id) {
            return true;
        }
        if (session()->get('login_role') == $user->IsAdministrador()) {
            return true;
        }
        return false;
        // return (bool) $user->hasAnyRole([User::IsTalento()]) && $user->talento->id == $idea->talento->id && $idea->estadoIdea->nombre == EstadoIdea::IsRegistro();
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
        if (session()->get('login_role') == $user->IsTalento() && $idea->talento_id == $user->talento->id) {
            return true;
        }
        if (session()->get('login_role') == $user->IsDinamizador() && $idea->nodo_id == $user->dinamizador->nodo_id) {
            return true;
        }
        if (session()->get('login_role') == $user->IsInfocenter() && $idea->nodo_id == $user->infocenter->nodo_id) {
            return true;
        }
        if (session()->get('login_role') == $user->IsArticulador() && $idea->nodo_id == $user->articulador->nodo_id) {
            return true;
        }
        if (session()->get('login_role') == $user->IsAdministrador() || session()->get('login_role') == $user->IsActivador()) {
            return true;
        }
        return false;

    }
    
}
