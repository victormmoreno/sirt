<?php

namespace App\Providers;

use App\Models\Laboratorio;
use App\Models\LineaTecnologica;
use App\Models\Nodo;
use App\Policies\Laboratorio\LaboratorioPolicy;
use App\Policies\LineaTecnologica\LineaTecnologicaPolicy;
use App\Policies\Nodo\NodoPolicy;
use App\Policies\User\UserPolicy;
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
        Laboratorio::class      => LaboratorioPolicy::class,
        User::class             => UserPolicy::class,
        LineaTecnologica::class => LineaTecnologicaPolicy::class,
        Nodo::class             => NodoPolicy::class,
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
