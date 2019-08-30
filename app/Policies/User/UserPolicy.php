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

        return (bool) collect($user->getRoleNames())->contains(User::IsAdministrador()) && session()->get('login_role') == User::IsAdministrador() || collect($user->getRoleNames())->contains(User::IsDinamizador()) && session()->get('login_role') == User::IsDinamizador() || collect($user->getRoleNames())->contains(User::IsGestor()) && session()->get('login_role') == User::IsGestor();
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

        if (session()->get('login_role') == User::IsAdministrador() && $user->hasAnyRole(Role::all())) {
            return true;
        } elseif (session()->get('login_role') == User::IsDinamizador()) {
            if (isset($authuser->dinamizador->nodo->id) && isset($user->gestor->nodo->id) && $authuser->dinamizador->nodo->id == $user->gestor->nodo->id && $user->hasAnyRole(Role::findByName('Gestor'))) {
                return true;
            } else if (isset($authuser->dinamizador->nodo->id) && isset($user->infocenter->nodo->id) && $authuser->dinamizador->nodo->id == $user->infocenter->nodo->id && $user->hasAnyRole(Role::findByName('Infocenter'))) {
                return true;
            } elseif (isset($authuser->dinamizador->nodo->id) && isset($user->ingreso->nodo->id) && $authuser->dinamizador->nodo->id == $user->ingreso->nodo->id && $user->hasAnyRole(Role::findByName('Ingreso'))) {
                return true;
            } elseif ($user->hasAnyRole(Role::findByName('Talento'))) {
                return true;
            }
        } elseif (session()->get('login_role') == User::IsGestor()) {

            if ($user->hasAnyRole(Role::all())) {
                return true;
            }
        }
        return false;

    }

}
