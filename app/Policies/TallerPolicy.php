<?php

namespace App\Policies;

use App\Models\Entrenamiento;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Auth\Access\HandlesAuthorization;

class TallerPolicy
{
    use HandlesAuthorization;

    /**
     * Determina si el usuario puede registrar talleres
     *
     * @param App\User $user
     * @return bool
     * @author dum
     **/
    public function create(User $user)
    {
        return (bool) Str::contains(session()->get('login_role'), [$user->IsArticulador()]);
    }
    
    /**
     * Determina si el usuario puede acceder al index de tallers
     */
    public function index(User $user)
    {
        return (bool) Str::contains(session()->get('login_role'), [$user->IsInfocenter(), $user->IsActivador(), $user->IsDinamizador(), $user->IsArticulador(), $user->IsAdministrador()]);
    }

    /**
     * Determina si el usuario puede subir un archivo al taller de fortalecimiento
     *
     * @param App\User $user
     * @return bool
     * @author dum
     **/
    public function upload(User $user, Entrenamiento $taller)
    {
        if (Str::contains(session()->get('login_role'), [$user->IsArticulador()]) && $taller->ideas->first()->nodo_id == request()->user()->getNodoUser()) {
            return true;
        }
        return false;
    }

    /**
     * Determina si el usuario puede borrar un archivo del taller de fortalecimiento
     *
     * @param App\User $user
     * @return bool
     * @author dum
     **/
    public function delete(User $user)
    {
        return (bool) Str::contains(session()->get('login_role'), [$user->IsArticulador(), $user->IsAdministrador()]);
    }

    public function show(User $user, Entrenamiento $taller)
    {
        if (Str::contains(session()->get('login_role'), [$user->IsActivador(), $user->IsAdministrador()])) {
            return true;
        }
        if (Str::contains(session()->get('login_role'), [$user->IsInfocenter(), $user->IsArticulador(), $user->IsDinamizador()]) && $taller->ideas->first()->nodo_id == request()->user()->getNodoUser() ) {
            return true;
        }
        return false;
    }

    /**
     * Determina si el usuario puede usar filtro para consultar talleres de fortalecimiento
     *x
     * @param App\User
     * @return bool
     * @author dum
     **/
    public function filter(User $user)
    {
        return (bool) Str::contains(session()->get('login_role'), [$user->IsActivador(), $user->IsAdministrador()]);
    }
}
