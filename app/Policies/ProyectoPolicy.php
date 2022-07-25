<?php

namespace App\Policies;

use App\User;
use App\Models\Proyecto;
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
