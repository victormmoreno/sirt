<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        // $this->registerPolices();
        // \Gate::guesPolicyNameUsing(function ($model) {
        //     $modelName = class_basename($model); //App/models/proyect

        //     return "App\\Policies\\{$modelName}Policy";
        // });
        
        // App::isLocale('es');
        // App::setLocale('es');
        Schema::defaultStringLength(191);

        Route::pattern('id', '[0-9]+');

        Route::resourceVerbs([
            'create' => 'crear',
            'edit' => 'editar',
        ]);
        
    }
}
