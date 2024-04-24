<?php

namespace App\Policies;

use App\User;
use App\Models\{Encuesta};
use Illuminate\Support\Str;
use Illuminate\Auth\Access\HandlesAuthorization;
use Carbon\Carbon;

class EncuestaPolicy
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
        return (bool) Str::contains(session()->get('login_role'), [$user->IsAdministrador(), $user->IsActivador()]);
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
        return (bool) Str::contains(session()->get('login_role'), [$user->IsAdministrador(), $user->IsActivador()]);
    }
}
