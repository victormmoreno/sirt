<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;



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
        

        Schema::defaultStringLength(191);

        Route::pattern('id', '[0-9]+');

        Route::resourceVerbs([
            'create' => 'crear',
            'edit' => 'editar',
        ]);
        
    }
}
