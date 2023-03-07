<?php

namespace App\Policies;

use App\User;
use App\Models\{Comite, Idea, RutaModel};
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
     * Determina si el usuario puede cambiar informacion de un comité
     *
     * @param User $user
     * @param Comite $comite
     * @return bool
     * @author dum
     **/
    public function edit(User $user, Comite $comite)
    {
        if ($comite->estado->nombre == $comite->estado->IsProgramado()) {
            if (session()->get('login_role') == $user->IsAdministrador()) {
                return true;
            }
            if (session()->get('login_role') == $user->IsInfocenter() && $comite->ideas->first()->nodo_id == $user->getNodoUser()) {
                return true;
            }
            return false;
        }
        return false;
    }

    /**
     * Determina si el usuario puede calificar el comité
     *
     * @param User $user
     * @param Comite $comite
     * @return bool
     * @author dum
     **/
    public function calificar(User $user, Comite $comite)
    {
        if ($comite->estado->nombre == $comite->estado->IsProgramado() || $comite->estado->nombre == $comite->estado->IsRealizado()) {
            if (session()->get('login_role') == $user->IsAdministrador()) {
                return true;
            }
            if (session()->get('login_role') == $user->IsInfocenter() && $comite->ideas->first()->nodo_id == $user->getNodoUser()) {
                return true;
            }
            return false;
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
    public function notificar_comite(User $user, Comite $comite, Idea $idea)
    {
        if ($comite->estado->nombre == $comite->estado->IsProgramado()) {
            if ((session()->get('login_role') == $user->IsInfocenter() && $idea->nodo_id == $user->getNodoUser()) || session()->get('login_role') == $user->IsAdministrador() ) {
                return true;
            }
        }
        return false;
    }

    /**
     * Determina si el usuario puede enviar la notificación de realización del comite al dinamizador
     *
     * @param User $user
     * @param Comite $comite
     * @return bool
     * @author dum
     **/
    public function notificar_dinamizador(User $user, Comite $comite)
    {
        
        return false;
    }

    /**
     * Determina si el usuario
     *
     * @param User $user
     * @param Comite $comite
     * @return bool
     * @author dum
     **/
    public function cargar_evidencias(User $user, Comite $comite)
    {
        if (Str::contains(session()->get('login_role'), [$user->IsAdministrador()])) {
            return true;
        }
        if (Str::contains(session()->get('login_role'), [$user->IsInfocenter()]) && $comite->ideas->first()->nodo_id == $user->getNodoUser()) {
            return true;
        }
        return false;
    }

    /**
     * Determina si el usuario puede eliminar un archivo del comité
     *
     * @param User $user
     * @param Comite $comite
     * @return bool
     * @author dum
     **/
    public function download_file(User $user, Comite $comite, RutaModel $file)
    {
        if (Str::contains(session()->get('login_role'), [$user->IsAdministrador(), $user->IsActivador()])) {
            return true;
        }
        if (Str::contains(session()->get('login_role'), [$user->IsInfocenter(), $user->IsDinamizador(), $user->IsExperto()]) && $file->comite->first()->nodo_id == $user->getNodoUser()) {
            return true;
        }
        return false;
    }
}
