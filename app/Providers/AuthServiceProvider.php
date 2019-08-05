<?php

namespace App\Providers;

use App\Policies\Nodo\UserRolSesionHasNodoPolicy;
use App\Policies\User\UserRoleSesionPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\User' => 'App\Policies\ProfileUserPolicy',
        'App\User' => UserRoleSesionPolicy::class,
        'App\Models\Nodo' => UserRolSesionHasNodoPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        
    }
}
