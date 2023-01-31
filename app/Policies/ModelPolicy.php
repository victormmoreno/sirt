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
    //  * @return bool
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
}
