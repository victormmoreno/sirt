<?php

namespace App\Policies;

use App\User;
use App\Models\{CharlaInformativa};
use Illuminate\Auth\Access\HandlesAuthorization;

class CharlaInformativaPolicy
{
    use HandlesAuthorization;

    /** 
     * Determina quienes pueden ver y usar el botón de crear charlas informativas
     * 
     * @param App\User $user
     * @return bool
     * @author dum
    */
    public function showCreateButton(User $user)
    {
        if (session()->get('login_role') == $user->IsAdministrador() || session()->get('login_role') == $user->IsInfocenter() || session()->get('login_role') == $user->IsArticulador()) {
            return true;
        }
        return false;
    }

    /**
     * Muestra el campo de los nodo para cuando el administrador va a registrar una charla informativa
     *
     * @param \App\User $user
     * @return bool
     * @author dum
     **/
    public function showNodosInput(User $user)
    {
        if (session()->get('login_role') == $user->IsAdministrador()) {
            return true;
        }
        return false;
    }

    /**
     * Muestra el campo para subir archivos de las charlas informativas
     *
     * @param \App\User $user
     * @return bool
     * @author dum
     **/
    public function showDropzone(User $user)
    {
        if (session()->get('login_role') == $user->IsDinamizador()) {
            return false;
        }
        return true;
    }
}
