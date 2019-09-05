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
        $this->app->bind(InfocenterInterface::class, InfocenterRepository::class);
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        // $time = time ();
        // $setTime = time () + 60;
        // if (empty ( $_SESSION ['setTime'] ) || !isset ( $_SESSION ['setTime'] )) {
        //     $_SESSION ['setTime'] = $setTime;
        // }

        // // $session = Config::get('session.lifetime') * 60;
        // // dd(Session::put('time', 'value'));

        // if (!Session::has('time')) {
        //     // $_SESSION['tiempo']= time();
        //     $session = Session::put('time',time());
        //     dd($session);
        // }
        // else if (time() - $_SESSION['tiempo'] > 120) {
        // session_destroy();
        /* Aquí redireccionas a la url especifica */
        // header("Location: urlLogin");
        // die();
        // }
        // $_SESSION['tiempo']=time();
        // $session = Session::activity();
        // dd(time());
        // dd(config('session.expired_session_redirect'));
        // dd($session);
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
            'edit'   => 'editar',
        ]);

    }
}
