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
        return (bool) collect($user->getRoleNames())->contains(User::IsAdministrador()) && session()->get('login_role') == User::IsAdministrador() || collect($user->getRoleNames())->contains(User::IsDinamizador()) && session()->get('login_role') == User::IsDinamizador() || collect($user->getRoleNames())->contains(User::IsGestor()) && session()->get('login_role') == User::IsGestor();
    }

    /**
     * Determine si un usuario puede ver formulario para crear nuevas lineas teconologicas.
     * @author julian londono
     * @return boolean
     */
    public function create(User $user)
    {
        return (bool) collect($user->getRoleNames())->contains(User::IsAdministrador()) && session()->has('login_role') && session()->get('login_role') == User::IsAdministrador();
    }

    /**
     * Determine si un usuario puede  crear nuevas lineas teconologicas.
     * @author julian londono
     * @return boolean
     */
    public function store(User $user)
    {
        return (bool) collect($user->getRoleNames())->contains(User::IsAdministrador()) && session()->has('login_role') && session()->get('login_role') == User::IsAdministrador();
    }

    public function show(User $user)
    {
        return (bool) collect($user->getRoleNames())->contains(User::IsAdministrador()) && session()->has('login_role') && session()->get('login_role') == User::IsAdministrador();
    }

    public function edit(User $user, LineaTecnologica $linea)
    {
        return (bool) $user->hasAnyRole([User::IsGestor(), User::IsTalento()]) && session()->has('login_role') && session()->get('login_role') == User::IsAdministrador() || session()->get('login_role') == User::IsDinamizador() || $linea->lineastecnologicasnodos->firstWhere('nodo_id', auth()->user()->dinamizador->nodo->id);

       
    }

    public function update(User $user, LineaTecnologica $linea)
    {
        return (bool) $user->hasAnyRole([User::IsGestor(), User::IsTalento()]) && session()->has('login_role') && session()->get('login_role') == User::IsAdministrador() || session()->get('login_role') == User::IsDinamizador() || $linea->lineastecnologicasnodos->firstWhere('nodo_id', auth()->user()->dinamizador->nodo->id);
    }
}
