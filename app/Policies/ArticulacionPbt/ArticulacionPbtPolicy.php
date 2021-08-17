<?php

namespace App\Policies\ArticulacionPbt;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Spatie\Permission\Models\Role;

class ArticulacionPbtPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the articulaciones.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function index(User $user)
    {

        return (bool) $user->hasAnyRole([User::IsAdministrador(), User::IsDinamizador(), User::IsArticulador(), User::IsTalento()]) &&
            session()->has('login_role')
            && session()->get('login_role') == User::IsAdministrador()
            || session()->get('login_role') == User::IsDinamizador()
            || session()->get('login_role') == User::IsArticulador()
            || session()->get('login_role') == User::IsTalento();
    }


    /**
     * Determine whether the user can create a articulacion.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        return (bool) $user->hasAnyRole([User::IsArticulador()])
            && session()->has('login_role')
            && session()->get('login_role') == User::IsArticulador();
    }

    /**
     * Determine si un usuario puede crear nuevas articulaciones.
     * @author julian londono
     * @return boolean
     */
    public function store(User $user)
    {

        return (bool) collect($user->getRoleNames())->contains(User::IsArticulador()) && session()->get('login_role') == User::IsArticulador();
    }


    /**
     * Determine si un usuario puede ver el listado en datatables.
     * @author julian londono
     * @return boolean
     */
    public function datatable(User $user)
    {
        return (bool) ($user->hasAnyRole([User::IsAdministrador(), User::IsDinamizador(), User::IsArticulador(), User::IsTalento()]) &&
        session()->has('login_role')
        && session()->get('login_role') == User::IsAdministrador()
        || session()->get('login_role') == User::IsDinamizador()
        || session()->get('login_role') == User::IsArticulador()
        || session()->get('login_role') == User::IsTalento()) && request()->ajax();
    }


    /**
     * Determine si un usuario puede ver el detalle de las articulaciones.
     * @author julian londono
     * @return boolean
     */
    public function show(User $user)
    {
        return (bool) $user->hasAnyRole([User::IsAdministrador(), User::IsDinamizador(), User::IsArticulador(), User::IsTalento()]) &&
        session()->has('login_role')
        && session()->get('login_role') == User::IsAdministrador()
        || session()->get('login_role') == User::IsDinamizador()
        || session()->get('login_role') == User::IsArticulador()
        || session()->get('login_role') == User::IsTalento();
    }

    /**
     * Determine si un usuario puede actualizar entregables.
     * @author julian londono
     * @return boolean
     */
    public function updateEntregable(User $user)
    {
        return (bool) collect($user->getRoleNames())->contains(User::IsArticulador()) && session()->get('login_role') == User::IsArticulador();
    }
}
