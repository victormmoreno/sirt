<?php

namespace App\Policies;

use App\Models\IngresoVisitante;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Auth\Access\HandlesAuthorization;

class IngresoVisitantePolicy
{
    use HandlesAuthorization;

    /**
     * Determina si el usuario puede registrar ingresos de visitantes
     *
     * @param User $user
     * @return bool
     * @author dum
     **/
    public function create(User $user)
    {
        if (Str::contains(session()->get('login_role'), [$user->IsIngreso(), $user->IsAdministrador()])) {
            return true;
        }
        return false;
    }

    /**
     * Determina si el usuario puede cambiar la información de un ingreso
     *
     * Undocumented function long description
     *
     * @param User $user
     * @param IngresoVisitante $ingreso
     * @return bool
     * @author dum
     **/
    public function edit(User $user, IngresoVisitante $ingreso)
    {
        if (session()->get('login_role') == $user->IsAdministrador()) {
            return true;
        }
        
        if (Str::contains(session()->get('login_role'), [$user->IsIngreso()]) && $ingreso->nodo_id == $user->getNodoUser()) {
            return true;
        }
        return false;
    }

    /**
     * Determina si el usuario puede exportar información de los ingresos
     *
     * @param User $user
     * @return bool
     * @author dum
     **/
    public function export(User $user)
    {
        if (Str::contains(session()->get('login_role'), [$user->IsIngreso(), $user->IsAdministrador(), $user->IsInfocenter()])) {
            return true;
        }
        return false;
    }
}
