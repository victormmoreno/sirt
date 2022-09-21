<?php

namespace App\Policies;

use App\User;
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
        if (session()->get('login_role') == $user->IsAdministrador() || session()->get('login_role') == $user->IsDinamizador() || session()->get('login_role') == $user->IsGestor()) {
            return true;
        }
        return false;
    }
}
