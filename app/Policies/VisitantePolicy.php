<?php

namespace App\Policies;

use App\User;
use Illuminate\Support\Str;
use Illuminate\Auth\Access\HandlesAuthorization;

class VisitantePolicy
{
    use HandlesAuthorization;

    /**
     * Determina si el usuario puede registrar visitantes
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
    
}
