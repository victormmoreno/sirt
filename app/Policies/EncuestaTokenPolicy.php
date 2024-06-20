<?php

namespace App\Policies;

use App\User;
use App\Models\Proyecto;
use Illuminate\Support\Str;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class EncuestaTokenPolicy
{
    use HandlesAuthorization;
    /**
     * Policy que establece quienes puede enviar una encuesta
     * @author julicode
     * @param App\User $user
     * @param Model $model
     * @return bool
     */
    public function enviarEncuesta(User $user, Model $model)
    {
        if (Str::contains(session()->get('login_role'), [$user->IsAdministrador(), $user->IsActivador(), $user->IsExperto()])) {
            if ($model instanceof Proyecto && $model->fase->nombre === Proyecto::IsEjecucion()) {
                if (isset($model->resultadosEncuesta)) {
                    return false;
                } else {
                    if (isset($model->encuestaToken)) {
                        if ($model->encuestaToken->created_at->diffInDays(Carbon::now()) >= 3) {
                            return true;
                        } else {
                            return false;
                        }
                    }
                }
            }
        }
        return true;
        // return (bool) Str::contains(session()->get('login_role'), [$user->IsAdministrador(), $user->IsActivador(), $user->IsExperto()]) && 
        // ($model instanceof Proyecto && $model->fase->nombre === Proyecto::IsEjecucion());
    }
}
