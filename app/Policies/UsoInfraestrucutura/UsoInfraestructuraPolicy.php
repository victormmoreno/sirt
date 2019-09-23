<?php

namespace App\Policies\UsoInfraestrucutura;

use App\Models\UsoInfraestructura;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UsoInfraestructuraPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the usos infraestructura.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function index(User $user)
    {
        return (bool) $user->hasAnyRole([User::IsAdministrador(), User::IsDinamizador(), User::IsGestor(), User::IsTalento()]) && session()->get('login_role') != User::IsIngreso() || session()->get('login_role') != User::IsInfocenter();
    }

    /**
     * Determine whether the user can create usos de infraestructura.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        return (bool) $user->hasAnyRole([User::IsGestor(), User::IsTalento()]) && session()->get('login_role') == User::IsGestor() || session()->get('login_role') == User::IsTalento();
    }

    /**
     * Determine whether the user can store usos de infraestructura.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function store(User $user)
    {
        return (bool) $user->hasAnyRole([User::IsGestor(), User::IsTalento()]) && session()->get('login_role') == User::IsGestor() || session()->get('login_role') == User::IsTalento();
    }

    /**
     * Determine whether the user can get uso ingraestrucutra usos de infraestructura.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function getUsoInfraestructuraForNodo(User $user)
    {
        return (bool) $user->hasAnyRole([User::IsAdministrador()]) && session()->get('login_role') == User::IsAdministrador();
    }

    /**
     * Determine whether the user can show usos de infraestructura.
     *
     * @param  \App\User  $user
     * @param  \App\Models\UsoInfraestructura  $uso
     * @return bool
     */
    public function show(User $user, UsoInfraestructura $uso)
    {
        if ($user->hasAnyRole([User::IsAdministrador(), User::IsDinamizador(), User::IsGestor(), User::IsTalento()]) && session()->get('login_role') == User::IsAdministrador()) {
            return true;
        } else if ($user->hasAnyRole([User::IsAdministrador(), User::IsDinamizador(), User::IsGestor(), User::IsTalento()]) && session()->get('login_role') == User::IsDinamizador() && $uso->actividad->nodo->id == $user->dinamizador->nodo->id) {
            return true;
        } else if ($user->hasAnyRole([User::IsAdministrador(), User::IsDinamizador(), User::IsGestor(), User::IsTalento()]) && session()->get('login_role') == User::IsGestor() && $uso->actividad->gestor->user->id == $user->id) {
            return true;
        } else if ($user->hasAnyRole([User::IsTalento()]) && session()->get('login_role') == User::IsTalento() && $uso->actividad->articulacion_proyecto->talentos->contains($user->talento->id)) {
            return true;
        }else{
            return false;
        }

    }

    /**
     * Determine whether the user can edit usos de infraestructura.
     *
     * @param  \App\User  $user
     * @param  \App\Models\UsoInfraestructura  $uso
     * @return bool
     */
    public function edit(User $user, UsoInfraestructura $uso)
    {
        if ($user->hasAnyRole([User::IsGestor()]) && session()->get('login_role') == User::IsGestor() && $uso->actividad->gestor->user->id == $user->id) {
            return true;
        } else if ($user->hasAnyRole([User::IsTalento()]) && session()->get('login_role') == User::IsTalento() && $uso->actividad->articulacion_proyecto->talentos->contains($user->talento->id)) {
            return true;
        }else{
            return false;
        }

    }


    /**
     * Determine whether the user can update usos de infraestructura.
     *
     * @param  \App\User  $user
     * @param  \App\Models\UsoInfraestructura  $uso
     * @return bool
     */
    public function update(User $user, UsoInfraestructura $uso)
    {
        if ($user->hasAnyRole([User::IsGestor()]) && session()->get('login_role') == User::IsGestor() && $uso->actividad->gestor->user->id == $user->id) {
            return true;
        } else if ($user->hasAnyRole([User::IsTalento()]) && session()->get('login_role') == User::IsTalento() && $uso->actividad->articulacion_proyecto->talentos->contains($user->talento->id)) {
            return true;
        }else{
            return false;
        }

    }

}
