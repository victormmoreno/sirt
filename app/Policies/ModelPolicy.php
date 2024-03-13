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
        return (bool) Str::contains(session()->get('login_role'), [$user->IsAuxiliar(), $user->IsActivador(), $user->IsAdministrador(), $user->IsDinamizador(), $user->IsInfocenter(), $user->IsArticulador(), $user->IsExperto()]);
    }

    public function showIndicadoresProyectoOptions(User $user)
    {
        return (bool) Str::contains(session()->get('login_role'), [$user->IsAuxiliar(), $user->IsActivador(), $user->IsAdministrador()]);
        // if (session()->get('login_role') == $user->IsAdministrador() || session()->get('login_role') == $user->IsActivador()) {
        //     return true;
        // }
        // return false;
    }

    public function showIndicadoresProyectos(User $user)
    {
        return (bool)
                    session()->has('login_role')
                    && (
                        (session()->get('login_role') == User::IsAuxiliar() && $user->IsAuxiliar() ) ||
                        (session()->get('login_role') == User::IsAdministrador() && $user->IsAdministrador() ) ||
                        (session()->get('login_role') == User::IsActivador() && $user->IsActivador()) ||
                        (session()->get('login_role') == User::IsDinamizador() && $user->IsDinamizador()) ||
                        (session()->get('login_role') == User::IsExperto() && $user->IsExperto()) ||
                        (session()->get('login_role') == User::IsInfocenter() && $user->IsInfocenter())
                    );
    }

    public function showIndicadoresArticulacionOptions(User $user)
    {
        return (bool) Str::contains(session()->get('login_role'), [$user->IsAuxiliar(), $user->IsActivador(), $user->IsAdministrador()]);
    }

    public function showIndicadoresArticulacions(User $user)
    {
        return (bool)
                    session()->has('login_role')
                    && (
                        (session()->get('login_role') == User::IsAuxiliar() && $user->IsAuxiliar()) ||
                        (session()->get('login_role') == User::IsAdministrador() && $user->IsAdministrador()) ||
                        (session()->get('login_role') == User::IsActivador() && $user->IsActivador()) ||
                        (session()->get('login_role') == User::IsDinamizador() && $user->IsDinamizador()) ||
                        (session()->get('login_role') == User::IsArticulador() && $user->IsArticulador()) ||
                        (session()->get('login_role') == User::IsInfocenter() && $user->IsInfocenter())
                    );
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
