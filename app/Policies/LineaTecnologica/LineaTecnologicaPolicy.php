<?php

namespace App\Policies\LineaTecnologica;

use App\Models\LineaTecnologica;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LineaTecnologicaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine si un usuario puede ver el index de las lineas tecnologicas.
     * @author julian londono
     * @return boolean
     */
    public function index(User $user)
    {
        return (bool) $user->hasAnyRole([User::IsActivador()]) && session()->has('login_role') && session()->get('login_role') == User::IsActivador();
    }

    /**
     * Determine si un usuario puede ver formulario para crear nuevas lineas teconologicas.
     * @author julian londono
     * @return boolean
     */
    public function create(User $user)
    {
        return (bool) $user->hasAnyRole([User::IsActivador()]) && session()->has('login_role') && session()->get('login_role') == User::IsActivador();
    }

    /**
     * Determine si un usuario puede  crear nuevas lineas teconologicas.
     * @author julian londono
     * @return boolean
     */
    public function store(User $user)
    {
        return (bool) $user->hasAnyRole([User::IsActivador()]) && session()->has('login_role') && session()->get('login_role') == User::IsActivador();
    }

    public function show(User $user)
    {
        return (bool) $user->hasAnyRole([User::IsActivador()]) && session()->has('login_role') && session()->get('login_role') == User::IsActivador();
    }

    public function edit(User $user, LineaTecnologica $linea)
    {
        return (bool) $user->hasAnyRole([User::IsActivador()]) && session()->has('login_role') && session()->get('login_role') == User::IsActivador();

       
    }

    public function update(User $user, LineaTecnologica $linea)
    {
        return (bool) $user->hasAnyRole([User::IsActivador()]) && session()->has('login_role') && session()->get('login_role') == User::IsActivador();
    }
}
