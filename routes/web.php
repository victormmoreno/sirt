<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
    // $user = App\Models\Nodo::with(['infocenter'])->first();
    // dd($user->infocenter);
    // $user = App\User::infoUserNodo('Infocenter','Medellin')
    // ->first()->nodo_direccion;

    // $user = App\User::with(['nodo'=>function($query){
    //        $query->select('nombre', 'direccion');
    //    }])->get();
    //
    //
    // $user = App\User::select(['id','documento','nombres', 'apellidos','email','direccion','telefono', 'celular','fechanacimiento','descripcion_ocupacion','estado'])
    //     ->with(['dinamizadorInfocenters' => function($query) {
    //         $query->select('profesion');
    //     }])->get();
    // dd($user);
    // dd(config('mail.host'));
    // dd($user);
    // dd($user->ultimo_login->createFromIsoFormat('LLLL', 'Monday 11 March 2019 16:28', null, 'fr'));

    return view('spa');

})->name('/');

// Route::get('{any}', function () {
//     return view('spa');
// })->where('any', '.*');

DB::listen(function ($query) {
    // echo "<pre>{$query->sql}</pre>";
    // echo "<pre>{$query->time}</pre>";
});

// Route::get('/', function () {
// $departaments = App\Models\Departamento::with(['cities'])->get();
// $departaments = App\Models\Departamento::first();
// dd($departaments->cities);

// $users = App\User::allowed()->get();
// dd($users->departament);

// $tiposdocumentos = App\Models\TipoDocumento::first();
// $tiposdocumentos->created_at->year //año
// $tiposdocumentos->created_at->month //mes
// $tiposdocumentos->created_at->day //dia
// $tiposdocumentos->created_at->addDays(2) //añadir dias
// $tiposdocumentos->created_at->subDays(2) //restar dias
// $tiposdocumentos->created_at->addWeeks(2) //sumar semanas
// $tiposdocumentos->created_at->addMonths(2) //sumar meses
// $tiposdocumentos->created_at->yesterday() //dia de ayer
// $tiposdocumentos->created_at->tomorrow() //dia de mañana
// $tiposdocumentos->created_at->dayOfWeek //dia de la semana
// $tiposdocumentos->created_at->diffForHumans() //leible para humanos
// $tiposdocumentos->created_at->startOfMonth() //dia que inicio el mes
// $tiposdocumentos->created_at->endOfMonth() //dia que finalizo el mes
// $tiposdocumentos->created_at->toDateString() //fecha sting
// $tiposdocumentos->created_at->toFormattedDateString() //fecha sting

// dd($tiposdocumentos->created_at->subDays(3)->isoFormat('dddd MMM  YYYY'));
// dd($tiposdocumentos->created_at->subDays(3)->diffForHumans());
//

//     return view('spa');
// });

/*===================================================================================
=            rutas modulos de login registro, recuperacion de contraseña            =
===================================================================================*/

Auth::routes(['register' => false]);

/*=====  End of rutas modulos de login registro, recuperacion de contraseña  ======*/

/*===========================================================
=            ruta principal apenas se hace login            =
===========================================================*/

Route::get('/home', 'HomeController@index')->name('home');

/*=====  End of ruta principal apenas se hace login  ======*/

/*=======================================================
=            rutas para activacion de cuenta            =
=======================================================*/
Route::get('activate/{token}', 'ActivationTokenController@activate')->name('activation');
/*=====  End of rutas para activacion de cuenta  ======*/

/*===================================================================
=            rutas para las funcionalidades de los nodos            =
===================================================================*/

Route::resource('nodo', 'NodoController');

/*=====  End of rutas para las funcionalidades de los nodos  ======*/

/*======================================================================
=            rutas para las funcionalidades de los usuarios            =
======================================================================*/

// Route::resource('usuarios', 'UserController',[ 'names' => [ 'index' => 'usuarios', 'create' => 'usuarios.crear']]);
Route::group([
    'prefix'     => 'usuario',
    'middleware' => 'auth'],
    function () {

        Route::get('/administrador', 'UserController@index')->name('usuario.administrador.index');
        Route::get('/administrador/create', 'UserController@create')->name('usuario.administrador.create');
        Route::post('administrador', 'UserController@store')->name('usuario.administrador.store');
        Route::get('administrador/{id}', 'UserController@show')->name('usuario.administrador.show');
        Route::get('administrador/{id}/edit', 'UserController@edit')->name('usuario.administrador.edit');
        Route::put('administrador/{id}', 'UserController@update')->name('usuario.administrador.update');
        Route::delete('administrador/{id}', 'UserController@delete')->name('usuario.administrador.delete');

    }
);

//-------------------Route group para el módulo de ideas
Route::group([
    	'prefix' => 'idea'
	],
    function () {
        Route::get('/', 'IdeaController@ideas')->name('idea.ideas');
        Route::get('/egi', 'IdeaController@empresasGI')->name('idea.egi');
        Route::get('/{idea}', 'IdeaController@details')->name('idea.details');
        Route::get('/{id}/edit', 'IdeaController@edit')->name('idea.edit');
        Route::get('/ideasEmpGI', 'IdeaController@ideasEmpGI')->name('idea.empgi');
        Route::put('/{idea}', 'IdeaController@update')->name('idea.update');
        Route::post('/', 'IdeaController@store')->name('idea.store');
        Route::post('/egi', 'IdeaController@storeEGI')->name('idea.storeegi');
    }
);

/*===================================================================
=            rutas para las funcionalidades de las ideas            =
===================================================================*/

Route::get('ideas', 'IdeaController@index')->name('ideas.index');

/*=====  End of rutas para las funcionalidades de las ideas  ======*/

/*=====  End of rutas para las funcionalidades de los usuarios  ======*/

Route::get('/notificaciones', 'NotificationsController@index')->name('notifications.index');
Route::patch('/notificaciones/{id}', 'NotificationsController@read')->name('notifications.read');
Route::delete('/notificaciones/{id}', 'NotificationsController@destroy')->name('notifications.destroy');

/*====================================================================
=            rutas para las funcionalidades de las lineas            =
====================================================================*/

Route::resource('lineas', 'LineaController');
// Route::resource('ideas', 'IdeaController');

/*=====  End of rutas para las funcionalidades de las lineas  ======*/
