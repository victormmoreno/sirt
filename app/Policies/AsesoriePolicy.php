<?php

namespace App\Policies;

use App\Models\UsoInfraestructura;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Str;


class AsesoriePolicy
{
    use HandlesAuthorization;
    
    public function before($user, $ability)
    {
         $user->IsAdministrador();
    }

        /**
     * Determine whether the user can view the usos infraestructura.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function indicadores(User $user)
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
     * Determine whether the user can create asesories.
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
     * Determine whether the user can search asesories.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function search(User $user)
    {
        return (bool) Str::contains(session()->get('login_role'), [
            $user->IsAdministrador(),
            $user->IsActivador(),
            $user->IsDinamizador(),
            $user->IsExperto(),
            $user->IsArticulador(),
            $user->IsApoyoTecnico(),
            $user->IsTalento()
        ]);
    }


    /**
     * Determine whether the user can show asesories.
     *
     * @param  \App\User  $user
     * @param  \App\Models\UsoInfraestructura  $asesorie
     * @return bool
     */
    public function show(User $user, UsoInfraestructura $asesorie)
    {
        return (session()->has('login_role')
            && (
                session()->get('login_role') == User::IsAdministrador() || session()->get('login_role') == User::IsActivador()
                || (
                    session()->get('login_role') == User::IsDinamizador()
                    && (
                        (isset($asesorie->asesorable->articulationstage) &&  $asesorie->asesorable->articulationstage->node_id == $user->dinamizador->nodo_id)
                        || (isset($asesorie->asesorable->nodo_id) && $asesorie->asesorable->nodo_id == $user->dinamizador->nodo_id)
                        )
                )
                || (
                    session()->get('login_role') == User::IsExperto()
                    && (isset($asesorie->asesorable->nodo_id) &&  $asesorie->asesorable->nodo_id == $user->experto->nodo_id)
                    && (isset($asesorie->asesorable->experto_id) &&  $asesorie->asesorable->experto_id == $user->id)
                )
                || (
                    session()->get('login_role') == User::IsArticulador()
                    && ((isset($asesorie->asesorable->articulationstage) &&  $asesorie->asesorable->articulationstage->node_id == $user->articulador->nodo_id)
                    || (isset($asesorie->asesorable->nodo_id) &&  $asesorie->asesorable->nodo_id == $user->articulador->nodo_id))
                )
                || (
                    session()->get('login_role') == User::IsApoyoTecnico()
                    && (isset($asesorie->asesorable->nodo_id) &&  $asesorie->asesorable->nodo_id == $user->apoyotecnico->nodo_id)
                    && (isset($asesorie->asesores)
                    && $asesorie->asesores->contains('documento', $user->documento)
                    )
                )
                || (
                    session()->get('login_role') == User::IsTalento()
                    && (isset($asesorie->participantes) &&
                        $asesorie->participantes->contains('documento', $user->documento)
                    )
                )
            )
        );
    }

    /**
     * Determine whether the user can update asesories.
     *
     * @param  \App\User  $user
     * @param  \App\Models\UsoInfraestructura  $asesorie
     * @return bool
     */
    public function update(User $user, UsoInfraestructura $asesorie)
    {
        $date = \Carbon\Carbon::now()->subYear(1)->format('Y');
        return (session()->has('login_role')
            && (
                (
                    session()->get('login_role') == User::IsDinamizador()
                    && (
                        (isset($asesorie->asesorable->articulationstage) &&  $asesorie->asesorable->articulationstage->node_id == $user->dinamizador->nodo_id)
                        || (isset($asesorie->asesorable->nodo_id) && $asesorie->asesorable->nodo_id == $user->dinamizador->nodo_id)
                        )
                )
                || (
                    session()->get('login_role') == User::IsExperto()
                    && $asesorie->asesorable->fase_id != \App\Models\Fase::IsFinalizado()
                    && (isset($asesorie->asesorable->nodo_id) &&  $asesorie->asesorable->nodo_id == $user->experto->nodo_id)
                    && (isset($asesorie->asesorable->experto_id) &&  $asesorie->asesorable->experto_id == $user->id)
                )
                || (
                    session()->get('login_role') == User::IsArticulador()
                    && $asesorie->asesorable->phase_id != \App\Models\Fase::IsFinalizado()
                    && ((isset($asesorie->asesorable->articulationstage) &&  $asesorie->asesorable->articulationstage->node_id == $user->articulador->nodo_id)
                    || (isset($asesorie->asesorable->nodo_id) &&  $asesorie->asesorable->nodo_id == $user->articulador->nodo_id))
                )
                || (
                    session()->get('login_role') == User::IsApoyoTecnico()
                    && (
                        class_basename($asesorie->asesorable) === class_basename(\App\Models\Proyecto::class)
                        && $asesorie->asesorable->fase_id != \App\Models\Fase::IsFinalizado()
                    )
                    && (isset($asesorie->asesorable->nodo_id) &&  $asesorie->asesorable->nodo_id == $user->apoyotecnico->nodo_id)
                    && (isset($asesorie->asesores)
                    && $asesorie->asesores->contains('documento', $user->documento)
                    )
                )
                || (
                    session()->get('login_role') == User::IsTalento()
                    && (
                        (class_basename($asesorie->asesorable) === class_basename(\App\Models\Proyecto::class)
                        && $asesorie->asesorable->fase_id != \App\Models\Fase::IsFinalizado()) ||
                        (class_basename($asesorie->asesorable) === class_basename(\App\Models\Articulation::class)
                        && $asesorie->asesorable->phase_id != \App\Models\Fase::IsFinalizado())
                    )
                    && (isset($asesorie->asesores) && $asesorie->asesores->count() == 0)
                    && (isset($asesorie->participantes) &&
                        $asesorie->participantes->contains('documento', $user->documento)
                    )
                )
            )
        );
    }

    /**
     * Determine whether the user can destroy asesories.
     *
     * @param  \App\User  $user
     * @param  \App\Models\UsoInfraestructura  $asesorie
     * @return bool
     */
    public function destroy(User $user, UsoInfraestructura $asesorie)
    {
        $date = \Carbon\Carbon::now()->subYear(1)->format('Y');
        return (session()->has('login_role')
            && (
                session()->get('login_role') == User::IsAdministrador() || session()->get('login_role') == User::IsActivador()
                || (
                    session()->get('login_role') == User::IsDinamizador()
                    && $asesorie->fecha->format('Y') > $date
                    && (
                        (isset($asesorie->asesorable->articulationstage) &&  $asesorie->asesorable->articulationstage->node_id == $user->dinamizador->nodo_id)
                        || (isset($asesorie->asesorable->nodo_id) && $asesorie->asesorable->nodo_id == $user->dinamizador->nodo_id)
                        )
                )
                || (
                    session()->get('login_role') == User::IsExperto()
                    && $asesorie->asesorable->fase_id != \App\Models\Fase::IsFinalizado()
                    && $asesorie->fecha->format('Y') > $date
                    && (isset($asesorie->asesorable->nodo_id) &&  $asesorie->asesorable->nodo_id == $user->experto->nodo_id)
                    && (isset($asesorie->asesorable->experto_id) &&  $asesorie->asesorable->experto_id == $user->id)
                )
                || (
                    session()->get('login_role') == User::IsArticulador()
                    && $asesorie->asesorable->phase_id != \App\Models\Fase::IsFinalizado()
                    && $asesorie->fecha->format('Y') > $date
                    && ((isset($asesorie->asesorable->articulationstage) &&  $asesorie->asesorable->articulationstage->node_id == $user->articulador->nodo_id)
                    || (isset($asesorie->asesorable->nodo_id) &&  $asesorie->asesorable->nodo_id == $user->articulador->nodo_id))
                )
                || (
                    session()->get('login_role') == User::IsApoyoTecnico()
                    && (
                        class_basename($asesorie->asesorable) === class_basename(\App\Models\Proyecto::class)
                        && $asesorie->asesorable->fase_id != \App\Models\Fase::IsFinalizado()
                    )
                    && $asesorie->fecha->format('Y') > $date
                    && (isset($asesorie->asesorable->nodo_id) &&  $asesorie->asesorable->nodo_id == $user->apoyotecnico->nodo_id)
                    && (isset($asesorie->asesores)
                    && $asesorie->asesores->contains('documento', $user->documento)
                    )
                )
                || (
                    session()->get('login_role') == User::IsTalento()
                    && (
                        (class_basename($asesorie->asesorable) === class_basename(\App\Models\Proyecto::class)
                        && $asesorie->asesorable->fase_id != \App\Models\Fase::IsFinalizado()) ||
                        (class_basename($asesorie->asesorable) === class_basename(\App\Models\Articulation::class)
                        && $asesorie->asesorable->phase_id != \App\Models\Fase::IsFinalizado())
                    )
                    && $asesorie->fecha->format('Y') > $date
                    && (isset($asesorie->asesores) &&$asesorie->asesores->count() == 0)
                    && (isset($asesorie->participantes) &&
                        $asesorie->participantes->contains('documento', $user->documento)
                    )
                )
            )
        );
    }
}

