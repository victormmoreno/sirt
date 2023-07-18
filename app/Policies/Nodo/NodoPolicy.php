<?php

namespace App\Policies\Nodo;

use App\Models\Nodo;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Auth\Access\HandlesAuthorization;

class NodoPolicy
{
    use HandlesAuthorization;
    /**
     * Perform pre-authorization checks.
     *
     * @param $user
     * @param  string  $ability
     * @return void|bool
     */
    public function before(User $user, $ability)
    {
        if ($user->hasAnyRole([User::IsAdministrador()])
            && session()->has('login_role')
            && session()->get('login_role') == User::IsAdministrador()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the nodos.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function index(User $user)
    {

        return (bool) $user->hasAnyRole([User::IsAdministrador(), User::IsActivador(), User::IsDinamizador(), User::IsExperto(),User::IsArticulador(), User::IsInfocenter(), User::IsApoyoTecnico()])
            && session()->has('login_role')
            && (
                session()->get('login_role') == User::IsAdministrador() ||
                session()->get('login_role') == User::IsActivador() ||
                session()->get('login_role') == User::IsDinamizador() ||
                session()->get('login_role') == User::IsExperto() ||
                session()->get('login_role') == User::IsArticulador() ||
                session()->get('login_role') == User::IsInfocenter() ||
                session()->get('login_role') == User::IsApoyoTecnico()
            );
    }

    /**
     * Determine whether the user can create a nodo.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        return (bool) $user->hasAnyRole([User::IsActivador(), User::IsAdministrador()])
        && session()->has('login_role')
        && (
            session()->get('login_role') == User::IsAdministrador() ||
            session()->get('login_role') == User::IsActivador()
        );
    }

    /**
     * Determine whether the user can show a nodo.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function show(User $user,  Nodo $nodo)
    {
        return (bool) $user->hasAnyRole([User::IsActivador(), User::IsAdministrador()])
        && session()->has('login_role')
        && (
            session()->get('login_role') == User::IsAdministrador() ||
            session()->get('login_role') == User::IsActivador()
        );
    }

    /**
     * Determine whether the user can edit a nodo.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function edit(User $user, Nodo $nodo)
    {
        return (bool) $user->hasAnyRole([User::IsActivador(), User::IsAdministrador()])
        && session()->has('login_role')
        && (
            session()->get('login_role') == User::IsAdministrador() ||
            session()->get('login_role') == User::IsActivador()
        );
    }

    /**
     * Determine whether the user can create a nodo.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function downloadAll(User $user)
    {
        return (bool) $user->hasAnyRole([User::IsActivador(), User::IsAdministrador()])
        && session()->has('login_role')
        && (
            session()->get('login_role') == User::IsAdministrador() ||
            session()->get('login_role') == User::IsActivador()
        );
    }

    /**
     * Determine whether the user can upload files a nodo.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function uploadFiles(User $user, Nodo $nodo)
    {
        return (bool)  ( (
                    session()->has('login_role')
                    && (
                        session()->get('login_role') == User::IsAdministrador() ||
                        session()->get('login_role') == User::IsActivador() ||
                        session()->get('login_role') == User::IsDinamizador()
                        )
                    )
                )
            && ($user->dinamizador->nodo_id == $nodo->id);
    }

    /**
     * Determine whether the user can edit a nodo.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Nodo  $nodo
     * @return bool
     */
    public function downloadOne(User $user, Nodo $nodo)
    {
        return (bool) $user->hasAnyRole([User::IsAdministrador(), User::IsActivador(), User::IsDinamizador()])
                && (
                    session()->has('login_role') && (
                        session()->get('login_role') == User::IsAdministrador()
                        || session()->get('login_role') == User::IsActivador()
                        || (session()->get('login_role') == User::IsDinamizador() && isset($user->dinamizador) && $user->dinamizador->nodo_id == $nodo->id)
                    )
                );
    }

    /**
     * Determina si el usuario puede inhabilitar a los funcionarios de un nodo
     *
     * @param  \App\User  $user
     * @return mixed
     * @author dum
     */
    public function inhabilitar(User $user)
    {
        return (bool) Str::contains(session()->get('login_role'), [$user->IsActivador(), $user->IsAdministrador()]);
    }
}
