<?php

namespace App\Providers;

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

        // Route::pattern('id', '[0-9]+');
        // parent::boot();
        // $this->registerPolices();
        // \Gate::guesPolicyNameUsing(function ($model) {
        //     $modelName = class_basename($model); //App/models/proyect

        //     return "App\\Policies\\{$modelName}Policy";
        // });
        

        // Schema::defaultStringLength(191);
        
    }
}
