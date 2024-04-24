<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {

        Route::pattern('id', '[0-9]+');
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {


        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(function(){
                require base_path('routes/web/guest.php');
                require base_path('routes/web/auth.php');
                require base_path('routes/web/user.php');
                require base_path('routes/web/notification.php');
                require base_path('routes/web/node.php');
                require base_path('routes/web.php');
                require base_path('routes/web/project.php');
                require base_path('routes/web/articulation.php');
                require base_path('routes/web/asesorie.php');
                require base_path('routes/web/companie.php');
                require base_path('routes/web/indicator.php');
                require base_path('routes/web/encuesta.php');
            });

    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }
}
