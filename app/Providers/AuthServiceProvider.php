<?php

namespace App\Providers;

use App\Models\CostoAdministrativo;
use App\Models\Equipo;
use App\Models\EquipoMantenimiento;
use App\Models\Laboratorio;
use App\Models\LineaTecnologica;
use App\Models\Nodo;
use App\Models\UsoInfraestructura;
use App\Policies\CostoAdministrativo\CostoAdministrativoPolicy;
use App\Policies\Equipo\EquipoPolicy;
use App\Policies\Laboratorio\LaboratorioPolicy;
use App\Policies\LineaTecnologica\LineaTecnologicaPolicy;
use App\Policies\Mantenimiento\MantenimientoPolicy;
use App\Policies\Nodo\NodoPolicy;
use App\Policies\User\UserPolicy;
use App\Policies\UsoInfraestrucutura\UsoInfraestructuraPolicy;
use App\User;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Laboratorio::class         => LaboratorioPolicy::class,
        User::class                => UserPolicy::class,
        LineaTecnologica::class    => LineaTecnologicaPolicy::class,
        Nodo::class                => NodoPolicy::class,
        UsoInfraestructura::class  => UsoInfraestructuraPolicy::class,
        CostoAdministrativo::class => CostoAdministrativoPolicy::class,
        Equipo::class              => EquipoPolicy::class,
        EquipoMantenimiento::class => MantenimientoPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

    }
}
