<?php

namespace App\Policies;

use Illuminate\Support\Str;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ModelPolicy
{
    use HandlesAuthorization;

    /**
     * Determina si el usuario puede hacer registro de metas
     *
     * @param App\User $user
     * @return bool
     * @author dum
     **/
    public function insert_metas(User $user)
    {
        return (bool) Str::contains(session()->get('login_role'), [$user->IsActivador(), $user->IsAdministrador()]);
    }

    /**
     * Determina si el usuario puede hacer registro de metas
     *
     * @param App\User $user
     * @return bool
     * @author dum
     **/
    public function index_indicadores(User $user)
    {
        return (bool) Str::contains(session()->get('login_role'), [$user->IsActivador(), $user->IsAdministrador(), $user->IsDinamizador(), $user->IsInfocenter(), $user->IsExperto()]);
    }

    public function showIndicadoresProyectoOptions(User $user)
    {
        if (session()->get('login_role') == $user->IsAdministrador() || session()->get('login_role') == $user->IsActivador()) {
            return true;
        }
        return false;
    }

    public function showIndicadoresArticulacionOptions(User $user)
    {
        if (session()->get('login_role') == $user->IsAdministrador() || session()->get('login_role') == $user->IsActivador()) {
            return true;
        }
        return false;
    }

    public function showDahsboardExperto(User $user)
    {
        if (session()->get('login_role') == $user->IsExperto()) {
            return true;
        }
        return false;
    }

    public function showDahsboardDinamizador(User $user)
    {
        if (session()->get('login_role') == $user->IsDinamizador()) {
            return true;
        }
        return false;
    }

    // /**
    //  * Determina si el usuario puede ver la gráfica que muestra los proyectos inscritos por un experto en el año actual
    //  *
    //  * @param App\User $user
    //  * @return bool
    //  * @author dum
    //  **/
    // public function grafico_inscrito_expertos(User $user)
    // {
    //     return (bool) Str::contains(session()->get('login_role'), [$user->IsDinamizador(), $user->IsInfocenter(), $user->IsExperto()]);
    // }

}
