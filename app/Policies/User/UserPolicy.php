<?php

namespace App\Policies\User;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Str;


class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the profile.
     * @return boolean
     */
    public function viewProfile(User $authUser, User $user)
    {
        return (bool) $authUser->id == $user->id;
    }


    /**
     * Determine whether the user can update the model.
     * @author julian londono
     * @return boolean
     */
    public function updateProfile(User $authUser, User $user)
    {
        return (bool) $authUser->id == $user->id;
    }

    /**
     * Determine whether the user can to update password
     * @author julian londono
     * @return boolean
     */
    public function updatePassword(User $authUser, User $user)
    {
        return (bool) $authUser->id == $user->id;
    }

    /**
     * Determine whether the user can to download a  register certificate .
     * @author julian londono
     * @return boolean
     */
    public function downloadCertificatedPlataform(User $authUser, User $user)
    {
        return (bool) $authUser->id == $user->id;
    }

    /**
     * Determine whether the user can to request a new password
     * @author julian londono
     * @return boolean
     */
    public function passwordReset(User $authUser, User $user)
    {
        return (bool) $authUser->id == $user->id;
    }

    /**
     * Determine whether the user can view list user
     * @return boolean
     */
    public function index(User $user)
    {
        return (bool)! Str::contains(session()->get('login_role'), [$user->IsApoyoTecnico(), $user->IsIngreso(), $user->IsTalento(), $user->IsUsuario()]);
    }

    /**
     * Determine whether the user can to show user
     * @return boolean
     */
    public function show(User $authUser, $user)
    {
        return (bool)! Str::contains(session()->get('login_role'), [$user->IsApoyoTecnico(), $user->IsIngreso(), $user->IsTalento(), $user->IsUsuario()]);
    }

    /**
     * Determine whether the user can to show user
     * @return boolean
     */
    public function tomar_control(User $user)
    {
        return (bool) Str::contains(session()->get('login_role'), [$user->IsAdministrador()]);
    }


    /**
     * Determina si el usuario puede dejar de tomar el control de otro usuario
     *
     * @param User $user
     * @return bool
     * @author dum
     **/
    public function dejar_control(User $user)
    {
        return (bool) session()->has('before_session');
    }


    /**
     * Determine if the given user can  view the users search
     * @return boolean
     */
    public function search(User $user)
    {
        return (bool)! Str::contains(session()->get('login_role'), [$user->IsDesarrollador(),$user->IsApoyoTecnico(), $user->IsIngreso(), $user->IsTalento(), $user->IsUsuario()]);
    }

    /**
     * Determine if the given user can  view nodes list
     * @return bool
     */
    public function viewNodes(User $user)
    {
        return (bool) $user->hasAnyRole([User::IsActivador(), User::IsAdministrador()])
            && session()->has('login_role')
            && (
                session()->get('login_role') == User::IsActivador() || session()->get('login_role') == User::IsAdministrador()
            );
    }


    /**
     * Determine whether the user can update to one user
     * @return boolean
     */
    public function update(User $authUser, User $user)
    {
        return (bool)
            ($authUser->documento != $user->documento) &&
            session()->has('login_role') &&
            (
                session()->get('login_role') == User::IsAdministrador() ||
                (session()->get('login_role') == User::IsActivador() && !$user->hasAnyRole([User::IsAdministrador(), User::IsActivador(), User::IsDesarrollador()])) ||
                (session()->get('login_role') == User::IsDinamizador() && !$user->hasAnyRole([User::IsAdministrador(), User::IsActivador(), User::IsDesarrollador(), User::IsDinamizador()])) ||
                (
                    (session()->get('login_role') == User::IsExperto() || session()->get('login_role') == User::IsArticulador() || session()->get('login_role') == User::IsInfocenter())
                    && !$user->hasAnyRole([User::IsAdministrador(), User::IsActivador(),User::IsDesarrollador(), User::IsDinamizador(),User::IsExperto(), User::IsArticulador(), User::IsApoyoTecnico(), User::IsInfocenter(), User::IsIngreso()])
                )
            );
    }

    /**
     * Determine whether the user can update state user
     * @return boolean
     */
    public function access(User $authUser, User $user): bool
    {
        return (bool)
            ($authUser->documento != $user->documento) &&
            session()->has('login_role') &&
            (
                session()->get('login_role') == User::IsAdministrador() ||
                (session()->get('login_role') == User::IsActivador() && !$user->hasAnyRole([User::IsAdministrador(), User::IsActivador(), User::IsDesarrollador()])) ||
                (session()->get('login_role') == User::IsDinamizador() && !$user->hasAnyRole([User::IsAdministrador(), User::IsActivador(), User::IsDesarrollador(), User::IsDinamizador()])) ||
                (
                    (session()->get('login_role') == User::IsExperto() || session()->get('login_role') == User::IsArticulador() || session()->get('login_role') == User::IsInfocenter())
                    && !$user->hasAnyRole([User::IsAdministrador(), User::IsActivador(),User::IsDesarrollador(), User::IsDinamizador(),User::IsExperto(), User::IsArticulador(), User::IsApoyoTecnico(), User::IsInfocenter(), User::IsIngreso()])
                )
            );
    }

    /**
     * Determine whether the user can export list users
     * @return boolean
     */
    public function export(User $user): bool
    {
        return (bool) collect($user->getRoleNames())->contains(User::IsActivador())
            && session()->get('login_role') == User::IsActivador()
            || collect($user->getRoleNames())->contains(User::IsAdministrador())
            && session()->get('login_role') == User::IsAdministrador()
            || collect($user->getRoleNames())->contains(User::IsDinamizador())
            && session()->get('login_role') == User::IsDinamizador()
            || collect($user->getRoleNames())->contains(User::IsArticulador())
            && session()->get('login_role') == User::IsArticulador()
            || collect($user->getRoleNames())->contains(User::IsExperto())
            && session()->get('login_role') == User::IsExperto()
            || collect($user->getRoleNames())->contains(User::IsInfocenter())
            && session()->get('login_role') == User::IsInfocenter();
        return (bool) session()->get('login_role') == User::IsExperto();
    }

    /**
     * Determine whether the user can update node and role
     * @return boolean
     */
    public function updateRoles(User $authUser, User $user): bool
    {
        return (bool) false;
        // ($authUser->documento != $user->documento) &&
        //     session()->has('login_role') &&
        //     (
        //         session()->get('login_role') == User::IsAdministrador() ||
        //         (session()->get('login_role') == User::IsActivador() && !$user->hasAnyRole([User::IsAdministrador(), User::IsActivador(), User::IsDesarrollador()])) ||
        //         (session()->get('login_role') == User::IsDinamizador() && !$user->hasAnyRole([User::IsAdministrador(), User::IsActivador(), User::IsDesarrollador(), User::IsDinamizador()])) ||
        //         (
        //             (session()->get('login_role') == User::IsExperto() || session()->get('login_role') == User::IsArticulador() || session()->get('login_role') == User::IsInfocenter())
        //             && !$user->hasAnyRole([User::IsAdministrador(), User::IsActivador(),User::IsDesarrollador(), User::IsDinamizador(),User::IsExperto(), User::IsArticulador(), User::IsApoyoTecnico(), User::IsInfocenter(), User::IsIngreso()])
        //         )
        //     );
    }

    /**
     * Determine whether the user can generate new password.
     * @return boolean
     */
    public function generatePassword(User $authUser, User $user): bool
    {
        return (bool)
            ($authUser->documento != $user->documento) &&
            session()->has('login_role') &&
            (
                session()->get('login_role') == User::IsAdministrador() ||
                (session()->get('login_role') == User::IsActivador() && !$user->hasAnyRole([User::IsAdministrador(), User::IsActivador(), User::IsDesarrollador()])) ||
                (session()->get('login_role') == User::IsDinamizador() && !$user->hasAnyRole([User::IsAdministrador(), User::IsActivador(), User::IsDesarrollador(), User::IsDinamizador()])) ||
                (
                    (session()->get('login_role') == User::IsExperto() || session()->get('login_role') == User::IsArticulador() || session()->get('login_role') == User::IsInfocenter())
                    && !$user->hasAnyRole([User::IsAdministrador(), User::IsActivador(),User::IsDesarrollador(), User::IsDinamizador(),User::IsExperto(), User::IsArticulador(), User::IsApoyoTecnico(), User::IsInfocenter(), User::IsIngreso()])
                )
            );
    }
}
