<?php

namespace App\Policies;

use App\User;
use App\Models\{Comite, Idea};
use Illuminate\Support\Str;
use Illuminate\Auth\Access\HandlesAuthorization;

class ComitePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can show the idea.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Idea  $idea
     * @return bool
     */
    public function show(User $user, Comite $comite)
    {
        if (session()->get('login_role') == $user->IsAdministrador() || session()->get('login_role') == $user->IsActivador()) {
            return true;
        }
        if ((Str::contains(session()->get('login_role'), [$user->IsInfocenter(), $user->IsDinamizador(), $user->IsExperto()])) && $comite->ideas->first()->nodo_id == $user->getNodoUser()) {
            return true;
        }
        return false;
    }

    /**
     * Determina si el usuario puede enviar la citación a una idea de proyecto
     *
     * @param User $user
     * @param Idea $idea
     * @param Comite $comite
     * @return bool
     * @author dum
     **/
    public function notificar_idea(User $user,Comite $comite, Idea $idea)
    {
        if ($comite->estado->IsProgramado()) {
            if (session()->get('login_role') == $user->IsInfocenter() && $idea->nodo_id == $user->getNodoUser()) {
                return true;
            }
        }
        return false;
    }
}
