<?php

namespace App\Policies;

use App\Models\UsoInfraestructura;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Str;


class AsesoriePolicy
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
        return (bool) Str::contains(session()->get('login_role'), [
            $user->IsAdministrador(),
            $user->IsActivador(),
            $user->IsDinamizador(),
            $user->IsExperto(),
            $user->IsArticulador(),
            $user->IsTalento(),
            $user->IsApoyoTecnico()
        ]);
    }

    /**
     * Determine if the given articulations can be view listNodes by the user.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function listNodes(User $user): bool
    {
        return (bool) Str::contains(session()->get('login_role'), [
            $user->IsAdministrador(),
            $user->IsActivador(),
        ]);
    }

    /**
     * Determine if the given user can be export reports by the articulationstage.
     * @param  \App\User  $user
     * @return bool
     */
    public function export(User $user)
    {
        return (bool) Str::contains(session()->get('login_role'), [
            $user->IsAdministrador(),
            $user->IsActivador(),
            $user->IsDinamizador(),
            $user->IsExperto(),
            $user->IsArticulador(),
            $user->IsApoyoTecnico()
        ]);
    }

    /**
     * Determine if the given articulations can be view modules by the user.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function moduleType(User $user): bool
    {
        return (bool) Str::contains(session()->get('login_role'), [
            $user->IsAdministrador(),
            $user->IsActivador(),
            $user->IsDinamizador(),
            $user->IsArticulador(),
            $user->IsTalento(),
        ]);
    }

    /**
     * Determine whether the user can create usos de infraestructura.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        return (bool) Str::contains(session()->get('login_role'), [
            $user->IsExperto(),
            $user->IsArticulador(),
            $user->IsApoyoTecnico(),
            $user->IsTalento()
        ]);
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
        return (bool) (session()->has('login_role')
            && (
                session()->get('login_role') == User::IsAdministrador() || session()->get('login_role') == User::IsActivador()
                || (
                    session()->get('login_role') == User::IsDinamizador()
                    && (
                        (isset($uso->asesorable->articulationstage) &&  $uso->asesorable->articulationstage->node_id == $user->dinamizador->nodo_id)
                        || (isset($uso->asesorable->nodo_id) && $uso->asesorable->nodo_id == $user->dinamizador->nodo_id)
                        )
                )
                || (
                    session()->get('login_role') == User::IsExperto()
                    && (isset($uso->asesorable->nodo_id) &&  $uso->asesorable->nodo_id == $user->experto->nodo_id)
                    && (isset($uso->asesorable->asesor_id) &&  $uso->asesorable->asesor_id == $user->experto->id)
                )
                || (
                    session()->get('login_role') == User::IsArticulador()
                    && ((isset($uso->asesorable->articulationstage) &&  $uso->asesorable->articulationstage->node_id == $user->articulador->nodo_id)
                    || (isset($uso->asesorable->nodo_id) &&  $uso->asesorable->nodo_id == $user->articulador->nodo_id))
                )
                || (
                    session()->get('login_role') == User::IsApoyoTecnico()
                    && (isset($uso->asesorable->nodo_id) &&  $uso->asesorable->nodo_id == $user->apoyotecnico->nodo_id)
                )
                || (
                    session()->get('login_role') == User::IsTalento()
                    && (isset($uso->usotalentos) &&
                    $uso->whereHas('usotalentos.user', function ($particpant) use($user) {
                        $particpant->where('user_id', $user->id);
                    })->first()
                    )
                )
            )
        );
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
        $date = \Carbon\Carbon::now()->subYear(1)->format('Y');
        return (bool) (session()->has('login_role')
            && (
                (
                    session()->get('login_role') == User::IsExperto()
                    && $uso->fecha->format('Y') > $date
                    && class_basename($uso->asesorable) === class_basename(\App\Models\Proyecto::class)
                    && (isset($uso->asesorable->nodo_id) &&  $uso->asesorable->nodo_id == $user->experto->nodo_id)
                    && (isset($uso->asesorable->asesor_id) &&  $uso->asesorable->asesor_id == $user->experto->id)
                    && $uso->whereHas(
                        'asesores',
                        function ($query) use($user) {
                            return $query->where('users.id', $user->id);
                        })
                )
                || (
                    session()->get('login_role') == User::IsArticulador()
                    && $uso->fecha->format('Y') > $date
                    && ((isset($uso->asesorable->articulationstage) &&  $uso->asesorable->articulationstage->node_id == $user->articulador->nodo_id)
                    || (isset($uso->asesorable->nodo_id) &&  $uso->asesorable->nodo_id == $user->articulador->nodo_id))
                    && $uso->whereHas(
                        'asesores',
                        function ($query) use($user) {
                            return $query->where('users.id', $user->id);
                        })
                )
                || (
                    session()->get('login_role') == User::IsApoyoTecnico()
                    && $uso->fecha->format('Y') > $date
                    && class_basename($uso->asesorable) === class_basename(\App\Models\Proyecto::class)
                    && (isset($uso->asesorable->nodo_id) &&  $uso->asesorable->nodo_id == $user->apoyotecnico->nodo_id)
                    && $uso->whereHas(
                        'asesores',
                        function ($query) use($user) {
                            return $query->where('users.id', $user->id);
                        })
                )
                || (

                    session()->get('login_role') == User::IsTalento()
                    && $uso->fecha->format('Y') > $date
                    && class_basename($uso->asesorable) === class_basename(\App\Models\Proyecto::class)
                    && (isset($uso->usotalentos) &&
                    $uso->whereHas('usotalentos.user', function ($particpant) use($user) {
                        $particpant->where('user_id', $user->id);
                    })->first()
                    )
                )
            )
        );
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
        $date = \Carbon\Carbon::now()->subYear(1)->format('Y');
        return (bool) (
            session()->has('login_role')
            && (
                session()->get('login_role') == User::IsAdministrador()
                || (
                    session()->get('login_role') == User::IsExperto()
                    && $uso->fecha->format('Y') > $date
                    && class_basename($uso->asesorable) === class_basename(\App\Models\Proyecto::class)
                    && (isset($uso->asesorable->nodo_id) &&  $uso->asesorable->nodo_id == $user->experto->nodo_id)
                    && (isset($uso->asesorable->asesor_id) &&  $uso->asesorable->asesor_id == $user->experto->id)
                    && $uso->whereHas(
                        'asesores',
                        function ($query) use($user) {
                            return $query->where('users.id', $user->id);
                        })
                )
                || (
                    session()->get('login_role') == User::IsArticulador()
                    && $uso->fecha->format('Y') > $date
                    && ((isset($uso->asesorable->articulationstage) &&  $uso->asesorable->articulationstage->node_id == $user->articulador->nodo_id)
                    || (isset($uso->asesorable->nodo_id) &&  $uso->asesorable->nodo_id == $user->articulador->nodo_id))
                    && $uso->whereHas(
                        'asesores',
                        function ($query) use($user) {
                            return $query->where('users.id', $user->id);
                        })
                )
                || (
                    session()->get('login_role') == User::IsApoyoTecnico()
                    && $uso->fecha->format('Y') > $date
                    && class_basename($uso->asesorable) === class_basename(\App\Models\Proyecto::class)
                    && (isset($uso->asesorable->nodo_id) &&  $uso->asesorable->nodo_id == $user->apoyotecnico->nodo_id)
                    && $uso->whereHas(
                        'asesores',
                        function ($query) use($user) {
                            return $query->where('users.id', $user->id);
                        })
                )
                || (
                    session()->get('login_role') == User::IsTalento()
                    && $uso->fecha->format('Y') > $date
                    && class_basename($uso->asesorable) === class_basename(\App\Models\Proyecto::class)
                    && (isset($uso->usotalentos) &&
                        $uso->whereHas('usotalentos.user', function ($particpant) use($user) {
                            $particpant->where('user_id', $user->id);
                        })->first()
                    )
                )
            )
        );
    }
}

