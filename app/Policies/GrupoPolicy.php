<?php

namespace App\Policies;

use App\User;
use Illuminate\Support\Str;
use Illuminate\Auth\Access\HandlesAuthorization;

class GrupoPolicy
{
    use HandlesAuthorization;

    /**
     * Policy que establece quienes pueden registrar un nuevo grupo de investigación
     *
     * @param App\User $user
     * @return bool
     * @author dum
     */
    public function create(User $user)
    {
        return (bool) Str::contains(session()->get('login_role'), [$user->IsAdministrador(), $user->IsDinamizador(), $user->IsExperto()]);
    }

    /**
     * Policy que establece quienes pueden cambiar la información de un grupo de investigación
     *
     * @param App\User $user
     * @return bool
     * @author dum
     */
    public function edit(User $user)
    {
        return (bool) Str::contains(session()->get('login_role'), [$user->IsAdministrador(), $user->IsDinamizador(), $user->IsExperto()]);
    }

    /**
     * Policy que establece quienes pueden acceder a la informacio de grupos de investigación
     *
     * @param App\User $user
     * @return bool
     * @author dum
     */
    public function index(User $user)
    {
        return (bool) Str::contains(session()->get('login_role'), [$user->IsAdministrador(), $user->IsActivador(), $user->IsDinamizador(), $user->IsExperto()]);
    }

    /**
     * Determina si el usuario puede ver la información de un grupo de investigación
     *
     * @param App\User $user
     * @return bool
     * @author dum
     **/
    public function show(User $user)
    {
        return (bool) Str::contains(session()->get('login_role'), [$user->IsAdministrador(), $user->IsActivador(), $user->IsDinamizador(), $user->IsExperto(), $user->IsInfocenter(), $user->IsArticulador()]);
    }
}
