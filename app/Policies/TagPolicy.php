<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Str;

class TagPolicy
{
    use HandlesAuthorization;

    /**
     * Determina quienes pueden crear etiquetas
     *
     * @param App\User $user
     * @return bool
     * @author dum
     **/
    public function create(User $user)
    {
        if (Str::contains(session()->get('login_role'), [$user->IsActivador(), $user->IsAdministrador()])) {
            return true;
        }
        return false;
    }

    /**
     * Determina quienes pueden cambiar etiquetas
     *
     * @param App\User $user
     * @return bool
     * @author dum
     **/
    public function update(User $user)
    {
        if (Str::contains(session()->get('login_role'), [$user->IsActivador(), $user->IsAdministrador()])) {
            return true;
        }
        return false;
    }
}
