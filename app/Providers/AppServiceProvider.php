<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Contracts\User\TalentStorage;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (app()->environment() == 'production') {
            $this->app->bind('path.public', function () {
                return config('app.path_public');
            });
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Schema::defaultStringLength(191);

        Route::pattern('id', '[0-9]+');

        Route::resourceVerbs([
            'create' => 'crear',
            'edit'   => 'editar',
        ]);
    }
}
