<?php

namespace App\Policies\Material;

use App\User;
use App\Models\Material;
use Illuminate\Auth\Access\HandlesAuthorization;

class MaterialPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view the index materials.
     *
     * @param  \App\User  $user
     * @return mixed
     * @author devjul
     */
    public function index(User $user)
    {
        return (bool) $user->hasAnyRole([User::IsAdministrador(),User::IsDinamizador(), User::IsGestor()]) && session()->has('login_role') && session()->get('login_role') == User::IsAdministrador() || session()->get('login_role') == User::IsDinamizador() || session()->get('login_role') == User::IsGestor();
    }

    /**
     * Determine whether the user can create any materials.
     *
     * @param  \App\User  $user
     * @return mixed
     * @author devjul
     */
    public function create(User $user)
    {
        
        return (bool) $user->hasAnyRole([User::IsDinamizador(), User::IsGestor()]) && session()->has('login_role') || session()->get('login_role') == User::IsDinamizador() || session()->get('login_role') == User::IsGestor();
    }

    /**
     * Determine whether the user can store any materials.
     *
     * @param  \App\User  $user
     * @return mixed
     * @author devjul
     */
    public function store(User $user)
    {
        
        return (bool) $user->hasAnyRole([User::IsDinamizador(), User::IsGestor()]) && session()->has('login_role') || session()->get('login_role') == User::IsDinamizador() || session()->get('login_role') == User::IsGestor();
    }

    
}
