<?php

namespace App\Policies\Articulation;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticulationSubtypePolicy
{
    use HandlesAuthorization;

    /**
     * Perform pre-authorization checks.
     *
     * @param  \App\Models\User  $user
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
     * Determine whether the user can view the articulationStages.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function index(User $user): bool
    {
        return (bool) $user->hasAnyRole([
                User::IsActivador()
            ])
            && session()->has('login_role')
            && (
                session()->get('login_role') == User::IsActivador()
            );
    }

    public function listNodes(User $user): bool
    {
        return (bool) $user->hasAnyRole([User::IsActivador()])
            && session()->has('login_role')
            && session()->get('login_role') == User::IsActivador();
    }
    /**
     * Determine if the given articulations can be create by the user.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return (bool) $user->hasAnyRole([User::IsActivador()])
            && session()->has('login_role')
            && session()->get('login_role') == User::IsActivador();
    }

    public function show(User $user): bool
    {
        return (bool) $user->hasAnyRole([User::IsActivador()])
            && session()->has('login_role')
            && session()->get('login_role') == User::IsActivador();
    }

    public function edit(User $user): bool
    {
        return (bool) $user->hasAnyRole([User::IsActivador()])
            && session()->has('login_role')
            && session()->get('login_role') == User::IsActivador();
    }

    public function destroy(User $user): bool
    {
        return (bool) $user->hasAnyRole([User::IsActivador()])
            && session()->has('login_role')
            && session()->get('login_role') == User::IsActivador();
    }
}
