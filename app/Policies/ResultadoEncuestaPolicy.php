<?php

namespace App\Policies;

use App\User;
use App\Models\ResultadoEncuesta;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Auth\Access\HandlesAuthorization;

class ResultadoEncuestaPolicy
{
    use HandlesAuthorization;


        /**
     * Policy que establece quienes pueden registrar un nuevo grupo de investigación
     *
     * @param App\User $user
     * @return bool
     * @author dum
     */
    public function download_results(User $user): bool
    {
        return (bool) Str::contains(session()->get('login_role'), [$user->IsAdministrador(), $user->IsActivador(), $user->IsAuxiliar(), $user->IsDinamizador()]);
    }
}
