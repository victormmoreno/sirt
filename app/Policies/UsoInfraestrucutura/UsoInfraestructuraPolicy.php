<?php

namespace App\Policies\UsoInfraestrucutura;

use App\Models\UsoInfraestructura;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Str;


class UsoInfraestructuraPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the usos infraestructura.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function index(User $user)
    {
        return (bool) Str::contains(session()->get('login_role'), [$user->IsAdministrador(), $user->IsActivador(), $user->IsDinamizador(), $user->IsExperto(), $user->IsArticulador(), $user->IsTalento(), $user->IsApoyoTecnico()]);
    }

    /**
     * Determine if the given articulations can be view listNodes by the user.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function listNodes(User $user): bool
    {
        return (bool) $user->hasAnyRole([User::IsActivador(), User::IsAdministrador()])
            && session()->has('login_role')
            && (session()->get('login_role') == User::IsActivador() || session()->get('login_role') == User::IsAdministrador());
    }

    /**
     * Determine if the given articulations can be view modules by the user.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function moduleType(User $user): bool
    {
        return (bool) $user->hasAnyRole([User::IsActivador(), User::IsAdministrador(),User::IsDinamizador(), User::IsTalento(), User::IsArticulador()])
            && session()->has('login_role')
            && (session()->get('login_role') == User::IsActivador() || session()->get('login_role') == User::IsAdministrador() || session()->get('login_role') == User::IsDinamizador() || session()->get('login_role') == User::IsArticulador() || session()->get('login_role') == User::IsTalento());
    }

    /**
     * Determine whether the user can create usos de infraestructura.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        return (bool) session()->has('login_role')
        && (
            session()->get('login_role') == User::IsExperto()
            || session()->get('login_role') == User::IsArticulador()
            || session()->get('login_role') == User::IsTalento()
            || session()->get('login_role') == User::IsApoyoTecnico()
        );
    }



    /**
     * Determine whether the user can get uso ingraestrucutra usos de infraestructura.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function getUsoInfraestructuraForNodo(User $user)
    {
        return (bool) $user->hasAnyRole([User::IsAdministrador()]) && session()->get('login_role') == User::IsAdministrador();
    }

    /**
     * Determine whether the user can show usos de infraestructura.
     *
     * @param  \App\User  $user
     * @param  \App\Models\UsoInfraestructura  $uso
     * @return bool
     */
    public function show(User $user, UsoInfraestructura $uso)
    {
        if ($user->hasAnyRole([User::IsAdministrador()]) && session()->get('login_role') == User::IsAdministrador()) {
            return true;
        } else if ($user->hasAnyRole([ User::IsDinamizador()]) && session()->get('login_role') == User::IsDinamizador() && $uso->asesorable->nodo->id == $user->dinamizador->nodo->id) {
            return true;
        } else if ($user->hasAnyRole([ User::IsExperto()]) && session()->get('login_role') == User::IsExperto() && $uso->whereHas(
            'usogestores',
            function ($query) use($user) {
                return $query->where('users.id', $user->id);
            })
        ) {
            return true;
        } else if ($user->hasAnyRole([User::IsArticulador()]) && session()->get('login_role') == User::IsArticulador() && $uso->whereHas(
            'usogestores',
            function ($query) use($user) {
                return $query->where('users.id', $user->id);
            })
        ) {
            return true;
        }else if ($user->hasAnyRole([User::IsApoyoTecnico()]) && session()->get('login_role') == User::IsApoyoTecnico() &&
        $uso->whereHas(
            'usogestores',
            function ($query) use($user) {
                return $query->where('users.id', $user->id);
            })
        ) {
            return true;
        } else if ($user->hasAnyRole([User::IsTalento()]) && session()->get('login_role') == User::IsTalento() &&
        //$uso->asesorable->articulacion_proyecto->talentos->contains($user->talento->id)
        $uso->whereHas(
            'usotalentos.user',
            function ($query) use($user) {
                return $query->where('id', $user);
            }
        )
        ) {
            return true;
        }else{
            return false;
        }

    }

    /**
     * Determine whether the user can edit usos de infraestructura.
     *
     * @param  \App\User  $user
     * @param  \App\Models\UsoInfraestructura  $uso
     * @return bool
     */
    public function edit(User $user, UsoInfraestructura $uso)
    {

        if ($user->hasAnyRole([ User::IsExperto()]) && session()->get('login_role') == User::IsExperto() && $uso->whereHas(
            'usogestores',
            function ($query) use($user) {
                return $query->where('users.id', $user->id);
            })
            // && $uso->whereHasMorph(
            //     'asesorable',
            //     [ \App\Models\Proyecto::class],
            //     function (Builder $subquery) {
            //         return $subquery->whereHas('fase', function ($subquery)  {
            //             $subquery->where('id','!=' ,Fase::where('nombre', 'Finalizado')->first()->id);
            //         });
            //     }
            // )->whereHasMorph('asesorable', \App\Models\Proyecto::class)
        ) {
            return true;
        } else if ($user->hasAnyRole([User::IsArticulador()]) && session()->get('login_role') == User::IsArticulador() && $uso->whereHas(
            'usogestores',
            function ($query) use($user) {
                return $query->where('users.id', $user->id);
            })
        ) {
            return true;
        }else if ($user->hasAnyRole([User::IsApoyoTecnico()]) && session()->get('login_role') == User::IsApoyoTecnico() &&
        $uso->whereHas(
            'usogestores',
            function ($query) use($user) {
                return $query->where('users.id', $user->id);
            })
        ) {
            return true;
        } else if ($user->hasAnyRole([User::IsTalento()]) && session()->get('login_role') == User::IsTalento() &&
        $uso->whereHas(
            'usotalentos.user',
            function ($query) use($user) {
                return $query->where('id', $user);
            }
        )
        ) {
            return true;
        }else{
            return false;
        }
    }


    /**
     * Determine whether the user can update usos de infraestructura.
     *
     * @param  \App\User  $user
     * @param  \App\Models\UsoInfraestructura  $uso
     * @return bool
     */
    public function update(User $user, UsoInfraestructura $uso)
    {

        if ($user->hasAnyRole([ User::IsExperto()]) && session()->get('login_role') == User::IsExperto() && $uso->whereHas(
            'usogestores',
            function ($query) use($user) {
                return $query->where('users.id', $user->id);
            })
        ) {
            return true;
        } else if ($user->hasAnyRole([User::IsArticulador()]) && session()->get('login_role') == User::IsArticulador() && $uso->whereHas(
            'usogestores',
            function ($query) use($user) {
                return $query->where('users.id', $user->id);
            })
        ) {
            return true;
        }else if ($user->hasAnyRole([User::IsApoyoTecnico()]) && session()->get('login_role') == User::IsApoyoTecnico() &&
        $uso->whereHas(
            'usogestores',
            function ($query) use($user) {
                return $query->where('users.id', $user->id);
            })
        ) {
            return true;
        } else if ($user->hasAnyRole([User::IsTalento()]) && session()->get('login_role') == User::IsTalento() &&
        $uso->whereHas(
            'usotalentos.user',
            function ($query) use($user) {
                return $query->where('id', $user);
            }
        )
        ) {
            return true;
        }else{
            return false;
        }
    }

    /**
     * Determine whether the user can destroy usos de infraestructura.
     *
     * @param  \App\User  $user
     * @param  \App\Models\UsoInfraestructura  $uso
     * @return bool
     */
    public function destroy(User $user, UsoInfraestructura $uso)
    {
        if ($user->hasAnyRole([ User::IsExperto()]) && session()->get('login_role') == User::IsExperto() && $uso->whereHas(
            'usogestores',
            function ($query) use($user) {
                return $query->where('users.id', $user->id);
            })
        ) {
            return true;
        } else if ($user->hasAnyRole([User::IsArticulador()]) && session()->get('login_role') == User::IsArticulador() && $uso->whereHas(
            'usogestores',
            function ($query) use($user) {
                return $query->where('users.id', $user->id);
            })
        ) {
            return true;
        }else if ($user->hasAnyRole([User::IsApoyoTecnico()]) && session()->get('login_role') == User::IsApoyoTecnico() &&
        $uso->whereHas(
            'usogestores',
            function ($query) use($user) {
                return $query->where('users.id', $user->id);
            })
        ) {
            return true;
        } else if ($user->hasAnyRole([User::IsTalento()]) && session()->get('login_role') == User::IsTalento() &&
        $uso->whereHas(
            'usotalentos.user',
            function ($query) use($user) {
                return $query->where('id', $user);
            }
        )
        ) {
            return true;
        }else{
            return false;
        }
    }
}

