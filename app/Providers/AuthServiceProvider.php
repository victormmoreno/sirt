<?php

namespace App\Providers;

use App\Models\Laboratorio;
use App\Policies\Laboratorio\LaboratorioPolicy;
use App\Policies\Nodo\UserRolSesionHasNodoPolicy;
use App\Policies\User\UserRoleSesionPolicy;
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
        'App\User'         => 'App\Policies\ProfileUserPolicy',
        'App\User'         => UserRoleSesionPolicy::class,
        'App\Models\Nodo'  => UserRolSesionHasNodoPolicy::class,
        Laboratorio::class => LaboratorioPolicy::class,
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
