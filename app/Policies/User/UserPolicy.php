<?php

namespace App\Policies\User;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Spatie\Permission\Models\Role;

class UserPolicy
{
    use HandlesAuthorization;

    public $authUser;
    public $user;

    public function __construct(User $authUser, User $user)
    {
        $this->authUser = $authUser;
        $this->user     = $user;
    }

    /**
     * Determine whether the user can view the perfil.
     * @author julian londono
     * @return boolean
     */
    public function viewProfile()
    {

        return (bool) $this->authUser->id == $this->user->id;
    }

    /**
     * Determine whether the user can view the rol.
     * @author julian londono
     * @return boolean
     */
    public function viewProfileRole()
    {
        return (bool) $this->authUser->id == $this->user->id;
    }

    /**
     * Determine whether the user can view the rol.
     * @author julian londono
     * @return boolean
     */
    public function viewProfileAccountPassword()
    {
        return (bool) $this->authUser->id == $this->user->id;
    }

    /**
     * @author julian londono
     * Determine si el usuario puede ver editar cuenta.
     * @return boolean
     */
    public function editAccount()
    {
        return (bool) $this->authUser->id == $this->user->id;
    }


    public function show()
    {
        if (auth()->user()->id == $this->user->id) {
            return false;
        } elseif ($this->user->hasAnyRole([User::IsAdministrador(), User::IsDinamizador(), User::IsTalento()]) && session()->has('login_role') && session()->get('login_role') == User::IsDinamizador()) {
            return false;
        } elseif ($this->user->hasAnyRole([User::IsAdministrador(), User::IsDinamizador(), User::IsGestor(), User::IsInfocenter(), User::IsIngreso()]) && session()->has('login_role') && session()->get('login_role') == User::IsGestor()) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     * @author julian londono
     * @return boolean
     */
    public function updateProfile()
    {
        return (bool) $this->authUser->id == $this->user->id;
    }

    /**
     * Determine si un usuario puede cambiar la password.
     * @author julian londono
     * @return boolean
     */
    public function updatePassword()
    {
        return (bool) $this->authUser->id == $this->user->id;
    }

    /**
     * Determine si un usuario puede descargar certificado registro plataforma.
     * @author julian londono
     * @return boolean
     */
    public function downloadCertificatedPlataform(User $user)
    {
        return (bool) collect($user->getRoleNames())->contains(User::IsTalento());
    }

    /**
     * Determine si un usuario puede solicitar nueva contraseña.
     * @author julian londono
     * @return boolean
     */
    public function passwordReset()
    {
        return (bool) $this->authUser->id == $this->user->id;
    }

    /*=============================================
    =            seccion para validar el modulo de usuarios         =
    =============================================*/

    /**
     * Determine si un usuario puede ver ek index de los usuarios.
     * @author julian londono
     * @return boolean
     */
    public function index(User $user)
    {
        return (bool) collect($user->getRoleNames())->contains(User::IsAdministrador())
            && session()->get('login_role') == User::IsAdministrador()
            || collect($user->getRoleNames())->contains(User::IsDinamizador())
            && session()->get('login_role') == User::IsDinamizador()
            || collect($user->getRoleNames())->contains(User::IsGestor())
            && session()->get('login_role') == User::IsGestor()
            || collect($user->getRoleNames())->contains(User::IsInfocenter())
            && session()->get('login_role') == User::IsInfocenter();
    }

    /**
     * Determine si un usuario puede ver formulario para crear nuevos usuarios.
     * @author julian londono
     * @return boolean
     */
    public function create(User $user)
    {

        return (bool) collect($user->getRoleNames())->contains(User::IsAdministrador()) && session()->get('login_role') == User::IsAdministrador() || collect($user->getRoleNames())->contains(User::IsDinamizador()) && session()->get('login_role') == User::IsDinamizador() || collect($user->getRoleNames())->contains(User::IsGestor()) && session()->get('login_role') == User::IsGestor();
    }

    /**
     * Determine si un usuario puede crear nuevos usuarios.
     * @author julian londono
     * @return boolean
     */
    public function store(User $user)
    {

        return (bool) collect($user->getRoleNames())->contains(User::IsAdministrador()) && session()->get('login_role') == User::IsAdministrador() || collect($user->getRoleNames())->contains(User::IsDinamizador()) && session()->get('login_role') == User::IsDinamizador() || collect($user->getRoleNames())->contains(User::IsGestor()) && session()->get('login_role') == User::IsGestor();
    }

    public function edit(User $authuser, User $user)
    {
        if (
            session()->get('login_role') == User::IsAdministrador() && $user->hasAnyRole(Role::all()) && $authuser->documento != $user->documento ||
            $user->roles->isEmpty()
        ) {
            return true;
        } elseif (session()->get('login_role') == User::IsDinamizador() && $authuser->documento != $user->documento || $user->roles->isEmpty()) {
            if (isset($authuser->dinamizador->nodo->id) && isset($user->gestor->nodo->id) && $authuser->dinamizador->nodo->id == $user->gestor->nodo->id && ($user->hasAnyRole(Role::findByName(User::IsGestor()))) || $user->hasAnyRole(Role::findByName(User::IsArticulador()))) {
                return true;
            } else if (isset($authuser->dinamizador->nodo->id) && isset($user->infocenter->nodo->id) && $authuser->dinamizador->nodo->id == $user->infocenter->nodo->id && $user->hasAnyRole(Role::findByName(User::IsInfocenter()))) {
                return true;
            } elseif (isset($authuser->dinamizador->nodo->id) && isset($user->ingreso->nodo->id) && $authuser->dinamizador->nodo->id == $user->ingreso->nodo->id && $user->hasAnyRole(Role::findByName(User::IsIngreso()))) {
                return true;
            } elseif ($user->hasAnyRole(Role::findByName(User::IsTalento()))) {
                return true;
            }
        } elseif (session()->get('login_role') == User::IsGestor() && $authuser->documento != $user->documento || $user->roles->isEmpty()) {

            if ($user->hasAnyRole(Role::all()) ||  $user->roles->isEmpty()) {
                return true;
            }
        }
        return false;
    }

    public function update(User $authuser, User $user)
    {
        if (
            session()->get('login_role') == User::IsAdministrador() && $user->hasAnyRole(Role::all()) && $authuser->id != $user->id ||
            $user->roles->isEmpty()
        ) {
            return true;
        } elseif (session()->get('login_role') == User::IsDinamizador() && $authuser->id != $user->id || $user->roles->isEmpty()) {
            if (isset($authuser->dinamizador->nodo->id) && isset($user->gestor->nodo->id) && $authuser->dinamizador->nodo->id == $user->gestor->nodo->id && ($user->hasAnyRole(Role::findByName(User::IsGestor())) || $user->hasAnyRole(Role::findByName(User::IsArticulador())))) {
                return true;
            } else if (isset($authuser->dinamizador->nodo->id) && isset($user->infocenter->nodo->id) && $authuser->dinamizador->nodo->id == $user->infocenter->nodo->id && $user->hasAnyRole(Role::findByName(User::IsInfocenter()))) {
                return true;
            } elseif (isset($authuser->dinamizador->nodo->id) && isset($user->ingreso->nodo->id) && $authuser->dinamizador->nodo->id == $user->ingreso->nodo->id && $user->hasAnyRole(Role::findByName(User::IsIngreso()))) {
                return true;
            } elseif ($user->hasAnyRole(Role::findByName(User::IsTalento()))) {
                return true;
            }
        } elseif (session()->get('login_role') == User::IsGestor() && $authuser->id != $user->id || $user->roles->isEmpty()) {

            if ($user->hasAnyRole(Role::all()) ||  $user->roles->isEmpty()) {
                return true;
            }
        }
        return false;
    }

    public function acceso()
    {
        if (session()->get('login_role') == User::IsInfocenter() || auth()->user()->id == $this->user->id || $this->authUser->hasAnyRole([User::IsInfocenter(), User::IsTalento(), User::IsIngreso()])) {
            return false;
        }
        return true;
    }


    /**
     * Determine whether the user can view the activities
     * @author julian londono
     * @return boolean
     */
    public function viewActivities()
    {

        return (bool) $this->authUser->id == $this->user->id && (session()->get('login_role') == User::IsGestor() || session()->get('login_role') == User::IsTalento());
    }

    /**
     * Determine whether the user can view the your talentos
     * @author julian londono
     * @return boolean
     */
    public function myTalentos()
    {
        return (bool) session()->get('login_role') == User::IsGestor();
    }

    /**
     * Determine whether the user can export the your talentos
     * @author julian londono
     * @return boolean
     */
    public function export(User $user)
    {
        return (bool) collect($user->getRoleNames())->contains(User::IsAdministrador())
            && session()->get('login_role') == User::IsAdministrador()
            || collect($user->getRoleNames())->contains(User::IsDinamizador())
            && session()->get('login_role') == User::IsDinamizador()
            || collect($user->getRoleNames())->contains(User::IsGestor())
            && session()->get('login_role') == User::IsGestor()
            || collect($user->getRoleNames())->contains(User::IsInfocenter())
            && session()->get('login_role') == User::IsInfocenter();
        return (bool) session()->get('login_role') == User::IsGestor();
    }


    /**
     * Determine whether the user can view the rol.
     * @author julian londono
     * @return boolean
     */
    public function confirmContratorInformation(User $authUser, User $user)
    {
        return (bool) ((collect($authUser->getRoleNames())->contains(User::IsAdministrador())
            && session()->get('login_role') == User::IsAdministrador())
            || (collect($authUser->getRoleNames())->contains(User::IsDinamizador())
            && session()->get('login_role') == User::IsDinamizador())) && ( isset($user->contratista) && $user->estado == User::IsInactive());
    }

}
