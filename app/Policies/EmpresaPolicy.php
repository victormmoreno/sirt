<?php

namespace App\Policies;

use App\User;
use App\Models\Empresa;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Str;

class EmpresaPolicy
{
    use HandlesAuthorization;

    public $authUser;
    public $user;

    public function __construct(User $authUser, User $user)
    {
        $this->authUser = $authUser;
        $this->user = $user;
    }

    /**
     * Determina si el usuario puede acceder al index de empresas
     *
     * @param App\User $user
     * @return bool
     * @author dum
     **/
    public function index(User $user)
    {
        return (bool) Str::contains(session()->get('login_role'), [
            $user->IsAdministrador(),
            $user->IsActivador(),
            $user->IsDinamizador(),
            $user->IsExperto(),
            $user->IsArticulador(),
            $user->IsInfocenter(),
            $user->IsTalento(),
            $user->IsUsuario()
        ]);
    }

    /**
     * Determina si el usuario puede registrar una empresa
     *
     * @param App\User $user
     * @return bool
     * @author dum
     **/
    public function create(User $user)
    {
        return (bool) Str::contains(session()->get('login_role'), [
            $user->IsActivador(),
            $user->IsAdministrador(),
            $user->IsTalento(),
            $user->IsUsuario()
        ]);
    }

    /**
     * Determina si el usuario puede cambiar la información de una sede
     *
     * @param User $user
     * @param Empresa $empresa
     * @return bool
     * @author dum
     **/
    public function edit(User $user, Empresa $empresa)
    {
        if (Str::contains(session()->get('login_role'), [
            $user->IsActivador(),
            $user->IsAdministrador()])) {
            return true;
        }
        if (session()->get('login_role') == $user->IsTalento() ||
            session()->get('login_role') == $user->IsUsuario() &&
            $empresa->user_id == $user->id) {
            return true;
        }
        return false;
    }

    /**
     * Determina quienes pueden ver y realizar las diferente opciones sobre las empresas
     *
     * @param App\User $user
     * @return bool
     * @author dum
     **/
    public function showOptions(User $user, Empresa $empresa)
    {
        if (session()->get('login_role') == $user->IsAdministrador() || session()->get('login_role') == $user->IsActivador()) {
            return true;
        }
        if ((session()->get('login_role') == $user->IsTalento() || session()->get('login_role') == $user->IsUsuario()) && $empresa->user_id == $user->id) {
            return true;
        }
        return false;
    }

    /**
     * Determina quienes pueden ver y realizar las diferente opciones sobre las empresas
     *
     * @param App\User $user
     * @param App\Models\Empresa $empresa
     * @return bool
     * @author dum
     **/
    public function show(User $user, Empresa $empresa)
    {
        if (Str::contains(session()->get('login_role'), [$user->IsActivador(), $user->IsAdministrador(), $user->IsDinamizador(), $user->IsExperto(), $user->IsInfocenter(), $user->IsArticulador()])) {
            return true;
        }
        if ((session()->get('login_role') == $user->IsTalento() || session()->get('login_role') == $user->IsUsuario()) && $empresa->user_id == $user->id) {
            return true;
        }
        return false;
    }

    /**
     * Determina si el usuario puede ver información mas delicada de las empresas
     *
     * @param User $user
     * @param Empresa $empresa
     * @return bool
     **/
    public function showInfoRestricted(User $user, Empresa $empresa)
    {
        if (Str::contains(session()->get('login_role'), [$user->IsActivador(), $user->IsAdministrador(), $user->IsDinamizador(), $user->IsExperto(), $user->IsInfocenter(), $user->IsArticulador()])) {
            return true;
        }
        if ((session()->get('login_role') == $user->IsTalento() || session()->get('login_role') == $user->IsUsuario()) && $empresa->user_id == $user->id) {
            return true;
        }
        return false;
    }
}
