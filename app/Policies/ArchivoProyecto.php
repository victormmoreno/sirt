<?php

namespace App\Policies;

use App\User;
use App\Models\ArchivoArticulacionProyecto;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArchivoProyecto
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can delete the archivo articulacion proyecto.
     *
     * @param  \App\User  $user
     * @param  \App\ArchivoArticulacionProyecto  $archivoArticulacionProyecto
     * @return mixed
     */
    public function delete(User $user, ArchivoArticulacionProyecto $archivoArticulacionProyecto)
    {
        if (session()->get('login_role') == $user->IsAdministrador()) {
            return true;
        }
        if (session()->get('login_role') == $user->IsExperto()) {
            if ($archivoArticulacionProyecto->articulacion_proyecto->proyecto->asesor->id == auth()->user()->gestor->id) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
        return false;
    }

}
