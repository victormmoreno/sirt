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


$ocupacion = App\Models\Ocupacion::first();
dd($ocupacion->users);


// dd($ocupaciones->items);
// $user = App\User::first();
    // dd($user->grupoSanguineo);

    // dd(config('laravelpermission.permissions.linea.index'));
    //
    // $user = App\User::all()->last();

    // dd($user->getRoleNames()[0]);


    // $user = App\Models\Departamento::allDepartamentos()->pluck('id','nombre');
    // dd($user);
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

    // $entidad = App\Models\Entidad::whereBetween('id', [119, 128])->get()->random()->id;
    // dd($entidad);

    return view('spa');

})->name('/');

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
    'namespace'  => 'User',
    'middleware' => 'auth',
],
    function () {

        Route::get('/administrador/getOcupaciones', [
        'uses' => 'AdminController@getOcupacionSesion',
        ]);

        Route::get('/administrador/remove-ocupacion/{id}', [
        'uses' => 'AdminController@removerItemOcupacion',
        ]);

        Route::get('/administrador/anadir-ocupacion/{id}', [
        'uses' => 'AdminController@anadirOcupacion',
        'as' => 'administrador.anadirocupacion'
        ]);

        Route::get('/administrador/anadir-ocupacion-edit/{idOcupacion}/{idUser}', [
        'uses' => 'AdminController@anadirOcupacionEdit',
        'as' => 'administrador.anadirocupacion.edit'
        ]);

        Route::post('/anadir-ocupacion', [
            'uses' => 'AdminController@postanadirOcupacion',
            'as'   => 'administrador.postanadirocupacion',
        ]);
        Route::get('/administrador', 'AdminController@administradorIndex')->name('usuario.administrador.index');
        Route::get('/administrador/create', 'AdminController@administradorCreate')->name('usuario.administrador.create');
        Route::post('administrador', 'AdminController@administradorStore')->name('usuario.administrador.store');
        Route::get('administrador/{id}', 'AdminController@show')->name('usuario.administrador.show');
        Route::get('administrador/{id}/edit', 'AdminController@administradorEdit')->name('usuario.administrador.edit');

        Route::put('administrador/{id}', 'AdminController@administradorUpdate')->name('usuario.administrador.update');
        Route::delete('administrador/{id}', 'AdminController@administradorDelete')->name('usuario.administrador.delete');
        Route::get('getciudad/{departamento}', 'AdminController@getCiudad');

        Route::get('dinamizador/getDinamizador/{id}', 'DinamizadorController@getDinanizador')->name('usuario.dinamizador.getDinanizador');

        // Route::get('dinamizador/show/{nombre}.{apellido}', 'DinamizadorController@show')->name('usuario.dinamizador.show');
        Route::resource('dinamizador', 'DinamizadorController', ['except' => 'show', 'as' => 'usuario']);

        Route::get('/talento', 'TalentoController@index')->name('usuario.talento.index');

    }
);

Route::get('perfil/{id}', 'User\ProfileController@index')->name('perfil.index');
Route::get('perfil/roles/{id}', 'User\ProfileController@roles')->name('perfil.roles');
Route::get('perfil/permisos/{id}', 'User\ProfileController@permisos')->name('perfil.permisos');
Route::resource('perfil', 'User\ProfileController', ['except' => 'show', 'index']);

//-------------------Route group para el módulo de ideas
Route::group([
    'prefix' => 'idea',
],
    function () {
        Route::get('/', 'IdeaController@ideas')->name('idea.ideas');
        Route::get('/egi', 'IdeaController@empresasGI')->name('idea.egi');
        Route::get('/{idea}', 'IdeaController@details')->name('idea.details');
        Route::get('/consultarIdeasEmprendedoresPorNodo/{idea}', 'IdeaController@dataTableIdeasEmprendedoresPorNodo')->name('idea.emprendedores');
        Route::get('/consultarIdeasEmpresasGIPorNodo/{idea}', 'IdeaController@dataTableIdeasEmpresasGIPorNodo')->name('idea.empresasgi');
        Route::get('/{id}/edit', 'IdeaController@edit')->name('idea.edit');
        Route::get('detallesIdea/{id}', 'IdeaController@detallesIdeas')->name('idea.det');
        Route::get('/ideasEmpGI', 'IdeaController@ideasEmpGI')->name('idea.empgi');
        Route::put('/{idea}', 'IdeaController@update')->name('idea.update');
        Route::post('/', 'IdeaController@store')->name('idea.store');
        Route::post('/egi', 'IdeaController@storeEGI')->name('idea.storeegi');
        Route::post('/addIdeaDeProyectoAlComite', 'IdeaController@addIdeaDeProyectoCreate');
    }
);

//-------------------Route group para el módulo de Entrenamientos
Route::group([
    'prefix' => 'entrenamientos',
],
    function () {
        Route::get('/', 'EntrenamientoController@index')->name('entrenamientos');
        Route::get('/consultarEntrenamientosPorNodo/{id}', 'EntrenamientoController@datatableEntrenamientosPorNodo');
        Route::get('/consultarEntrenamientosPorNodo', 'EntrenamientoController@datatableEntrenamientosPorNodo_Dinamizador');
        Route::get('/create', 'EntrenamientoController@create')->name('entrenamientos.create');
        Route::get('/{id}/edit', 'EntrenamientoController@edit')->name('entrenamientos.edit');
        Route::get('/{id}', 'EntrenamientoController@details')->name('entrenamientos.details');
        Route::get('/inhabilitarEntrenamiento/{id}/{tipoCambioEstado}', 'EntrenamientoController@inhabilitarEntrenamiento')->name('entrenamientos.inhabilitar');
        Route::get('/getideasEntrenamiento', 'EntrenamientoController@get_ideasEntrenamiento');
        Route::get('/getideasEntrenamientoEdit', 'EntrenamientoController@get_ideasEntrenamientoEdit');
        Route::get('/getConfirm/{id}/{estado}', 'EntrenamientoController@getConfirm');
        Route::get('/getCanvas/{id}/{estado}', 'EntrenamientoController@getCanvas');
        Route::get('/getAssistF/{id}/{estado}', 'EntrenamientoController@getAssistF');
        Route::get('/getAssistS/{id}/{estado}', 'EntrenamientoController@getAssistS');
        Route::get('/getConvocado/{id}/{estado}', 'EntrenamientoController@getConvocado');
        Route::get('/eliminar/{id}', 'EntrenamientoController@eliminar_idea');
        Route::post('/', 'EntrenamientoController@store')->name('entrenamientos.store');
        Route::post('/addidea', 'EntrenamientoController@add_idea');
        Route::post('/cargarIdeas', 'EntrenamientoController@cargarIdeasDelEntrenamientoEnLaSesion');
        Route::put('/{id}', 'EntrenamientoController@update')->name('entrenamientos.update');
    }
);

//-------------------Route group para el módulo de Comité
Route::group([
    'prefix' => 'csibt',
],
    function () {
        Route::get('/', 'ComiteController@index')->name('csibt');
        Route::get('/create', 'ComiteController@create')->name('csibt.create');
        Route::get('/{id}/edit', 'ComiteController@edit')->name('csibt.edit');
        Route::get('/{id}', 'ComiteController@show')->name('csibt.show');
        Route::get('/{id}/evidencias', 'ComiteController@evidencias')->name('csibt.evidencias');
        Route::get('/{id}/consultarCsibtPorNodo', 'ComiteController@datatableCsibtPorNodo_Administrador')->name('csibt.show');
        Route::get('/getideasComiteCreate', 'ComiteController@get_ideasComiteCreate');
        Route::get('/eliminarIdeaCC/{id}', 'ComiteController@get_eliminarIdeaComiteCreate');
        Route::get('/archivosDeUnComite/{id}', 'ComiteController@datatableArchivosDeUnComite');
        Route::get('/downloadFile/{id}', 'ArchivoComiteController@downloadFile')->name('csibt.files.download');
        Route::put('/updateEvidencias/{id}', 'ComiteController@updateEvidencias')->name('csibt.update.evidencias');
        Route::post('/addIdeaComite', 'ComiteController@addIdeaDeProyectoCreate');
        Route::post('/', 'ComiteController@store')->name('csibt.store');
        Route::post('/store/{id}/filesComite', 'ArchivoComiteController@store')->name('csibt.files.store');
        Route::delete('/file/{idFile}', 'ArchivoComiteController@destroy')->name('csibt.files.destroy');
    }
);

//-------------------Route group para todos los pdfs de la aplicacion
Route::group([
    	'prefix' => 'pdf',
      'namespace' => 'PDF',
	],
    function () {
        Route::get('/', 'PdfComiteController@printPDF')->name('print');
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
