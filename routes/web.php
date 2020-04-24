<?php

use App\User;
use Carbon\Carbon;
use App\Models\Entidad;
use App\Models\Articulacion;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {

    return view('spa');
    // $proyecto = App\Models\Proyecto::find(455);
    // $proyecto->users_propietarios()->attach([7]);
})->name('/');

// DB::listen(function ($query) {
// echo "<pre>{$query->sql}</pre>";
// echo "<pre>{$query->time}</pre>";
// });

/*===========================================================
=            ruta para revisar funcionaliddes de prueba          =
===========================================================*/

// Route::get('email', function () {
// return new App\Mail\Comite\SendEmailIdeaComite(App\Models\Idea::first());
// return new App\Mail\IdeaEnviadaEmprendedor(App\Models\Idea::first());
// return new App\Mail\User\PleaseActivateYourAccount(App\User::first());
// return new App\Mail\User\SendNotificationPassoword(App\User::first(), 'asdafasafasdf');
// });

/*=====  End of ruta para revisafuncionaliddes de prueba  ======*/

/*===================================================================================
=            rutas modulos de login registro, recuperacion de contraseña            =
===================================================================================*/
Auth::routes(['register' => false]);
/*=====  End of rutas modulos de login registro, recuperacion de contraseña  ======*/

/*================================================================
=            ruta para cambiar la session del usuario            =
================================================================*/
Route::post('cambiar-role', 'User\RolesPermissions@changeRoleSession')
    ->name('user.changerole')
    ->middleware('disablepreventback');
/*=====  End of ruta para cambiar la session del usuario  ======*/

/*=======================================================
=            rutas para activacion de cuenta            =
=======================================================*/
Route::get('activate/{token}', 'ActivationTokenController@activate')->name('activation');
/*=====  End of rutas para activacion de cuenta  ======*/

/*===========================================================
=            ruta principal apenas se hace login            =
===========================================================*/

Route::get('/home', 'HomeController@index')->name('home')->middleware('disablepreventback');

/*=====  End of ruta principal apenas se hace login  ======*/

/*===================================================================
=            rutas para las funcionalidades de los nodos            =
===================================================================*/
// Route::get('nodo/pdfequiponodo', 'Nodo\NodoController@pdfEquipoNodo')
// ->name('activation')
// ->middleware('disablepreventback');
Route::resource('nodo', 'Nodo\NodoController')->middleware('disablepreventback');

/*=====  End of rutas para las funcionalidades de los nodos  ======*/

/*======================================================================
=            rutas para las funcionalidades de los usuarios            =
======================================================================*/

Route::group(
    [
        'prefix'     => 'usuario',
        'namespace'  => 'User',
        'middleware' => 'disablepreventback',
    ],
    function () {

        Route::get('administrador', 'AdminController@index')->name('usuario.administrador.index');
        Route::get('administrador/papelera', 'AdminController@trash')->name('usuario.administrador.indexinactivos');


        Route::get('dinamizador/getDinamizador/{id}', 'DinamizadorController@getDinanizador')->name('usuario.dinamizador.getDinanizador');
        Route::get('dinamizador/getDinamizador/papelera/{id}', 'DinamizadorController@getDinanizadorTrash')->name('usuario.dinamizador.getDinanizador.papelera');
        Route::get('dinamizador', 'DinamizadorController@index')->name('usuario.dinamizador.index');
        Route::get('dinamizador/papelera', 'DinamizadorController@trash')->name('usuario.dinamizador.papelera');

        Route::get('getlineanodo/{nodo}', 'GestorController@getLineaPorNodo');
        Route::get('gestor/getGestor/{id}', 'GestorController@getGestor')->name('usuario.gestor.getGestor');
        Route::get('gestor/getGestor/papelera/{id}', 'GestorController@getGestorTrash')->name('usuario.gestor.getGestor.papelera');
        Route::get('gestor/getgestor', 'GestorController@getAllGestoresOfNodo')->name('usuario.gestor.getGestorofnodo');
        Route::get('gestor/getgestor/papelera', 'GestorController@getAllGestoresOfNodoTrash')->name('usuario.gestor.getGestorofnodo.papelera');
        Route::get('gestor', 'GestorController@index')->name('usuario.gestor.index');
        Route::get('gestor/papelera', 'GestorController@trash')->name('usuario.gestor.papelera');

        Route::get('infocenter/getinfocenter/{id}', 'InfocenterController@getInfocenterForNodo')->name('usuario.infoncenter.getinfocenter');
        Route::get('infocenter/getinfocenter/papelera/{id}', 'InfocenterController@getInfocenterForNodoTrash')->name('usuario.infoncenter.getinfocenter.papelera');
        Route::get('infocenter/getinfocenter', 'InfocenterController@getAllInfocentersOfNodo')->name('usuario.infocenter.getinfocenternodo');
        Route::get('infocenter/getinfocenter/papelera', 'InfocenterController@getAllInfocentersOfNodoTrash')->name('usuario.infocenter.getinfocenternodo.papelera');
        Route::get('infocenter', 'InfocenterController@index')->name('usuario.infocenter.index');
        Route::get('infocenter/papelera', 'InfocenterController@trash')->name('usuario.infocenter.papelera');

        Route::get('ingreso/getingreso/{id}', 'IngresoController@getIngresoForNodo')->name('usuario.ingreso.getingreso');
        Route::get('ingreso/getingreso/papelera/{id}', 'IngresoController@getIngresoForNodoTrash')->name('usuario.ingreso.getingreso.papelera');
        Route::get('ingreso/getingreso', 'IngresoController@getAllIngresoOfNodo')->name('usuario.ingreso.getingresonodo');
        Route::get('ingreso/getingreso/papelera', 'IngresoController@getAllIngresoOfNodoTrash')->name('usuario.ingreso.getingresonodo.papelera');
        Route::get('ingreso', 'IngresoController@index')->name('usuario.ingreso.index');
        Route::get('ingreso/papelera', 'IngresoController@trash')->name('usuario.ingreso.papelera');

        Route::get('/talento/getTalentosDeTecnoparque', [
            'uses' => 'TalentoController@datatableTalentosDeTecnoparque',
            'as'   => 'talento.tecnoparque',
        ]);


        Route::get('/talento/consultarTalentoPorId/{id}', [
            'uses' => 'TalentoController@consultarUnTalentoPorId',
            'as'   => 'talento.tecnoparque.byid',
        ]);


        Route::get('/talento/papelera', [
            'uses' => 'TalentoController@talentosTrash',
            'as'   => 'usuario.usuarios.talento.papelera',
        ]);

        Route::get('talento/gettalentodatatable', 'TalentoController@getUsersTalentosForDatatables')->name('usuario.talento.gettalentodatatable');
        Route::get('talento', 'TalentoController@index')->name('usuario.talento.index');

        Route::get('usuarios/allusuarios', 'UserController@getAllUsersInDatatable')->name('usuario.allusers');
        Route::get('consultarUserPorId/{id}', 'UserController@findUserById');


        Route::get('/', [
            'uses' => 'UserController@index',
            'as'   => 'usuario.index',
        ]);

        Route::get('/getuserstalentosbydatatables/{anio}', [
            'uses' => 'UserController@getDatatablesUsersTalentosByDatatables',
            'as'   => 'usuario.getusuariobydatatables',
        ]);

        Route::get('/getuserstalentosbydatatables/papelera/{anio}', [
            'uses' => 'UserController@getDatatablesUsersTalentosByDatatablesTrash',
            'as'   => 'usuario.getusuariobydatatables.papelera',
        ]);

        Route::get('/getuserstalentosbydatatables/papelera/{anio}', [
            'uses' => 'TalentoController@getDatatablesUsersTalentosByDatatablesTrash',
            'as'   => 'usuario.getusuariobydatatablestrash',
        ]);


        Route::get('/getuserstalentosbygestordatatables/{gestor}/{anio}', [
            'uses' => 'UserController@getDatatablesUsersTalentosByGestorDatatables',
            'as'   => 'usuario.getusuariobygestordatatables',
        ]);

        Route::get('/getuserstalentosbygestordatatables/papelera/{gestor}/{anio}', [
            'uses' => 'UserController@getDatatablesUsersTalentosByGestorDatatablesTrash',
            'as'   => 'usuario.getusuariobygestordatatables.papelera',
        ]);

        Route::get('/getuserstalentosbynodo/{nodo}/{anio}', [
            'uses' => 'UserController@getDatatablesUsersTalentosByNodoDatatables',
            'as'   => 'usuario.getusuariobygestordatatables',
        ]);

        Route::get('/getuserstalentosbynodo/papelera/{nodo}/{anio}', [
            'uses' => 'UserController@getDatatablesUsersTalentosByNodoDatatablesTrash',
            'as'   => 'usuario.getusuariobygestordatatables.papelera',
        ]);

        Route::post('/consultaremail', [
            'uses' => 'UserController@consultaremail',
            'as'   => 'usuario.consultaremail',
        ]);

        Route::put('/updateacceso/{documento}', 'UserController@updateAcceso')->name('usuario.usuarios.updateacceso')->middleware('disablepreventback');


        Route::get('/usuarios/consultarusuariopordocumento/{documento}', [
            'uses' => 'UserController@queryUserByDocument',
            'as'   => 'users.byid',
        ])->where('documento', '[0-9]+');

        Route::get('getciudad/{departamento?}', 'UserController@getCiudad');

        Route::get('/talento/getEdadTalento/{id}', 'TalentoController@getEdad');

        Route::get('/usuarios', 'UserController@userSearch')->name('usuario.search');

        Route::get('/usuarios/estudios/{documento}', 'UserController@study')->name('usuario.study')->where('documento', '[0-9]+');;

        Route::get('/usuarios/{id}', 'UserController@edit')->name('usuario.usuarios.edit')->where('documento', '[0-9]+');;

        Route::get('/usuarios/crear/{documento}', 'UserController@create')->name('usuario.usuarios.create')->where('documento', '[0-9]+');

        Route::get('/usuarios/gestores/nodo/{id}', [
            'uses' => 'UserController@gestoresByNodo',
            'as'   => 'usuario.gestores.nodo',
        ]);


        Route::get('/usuarios/acceso/{documento}', 'UserController@acceso')->name('usuario.usuarios.acceso')->where('documento', '[0-9]+');
        Route::resource('usuarios', 'UserController', ['as' => 'usuario', 'except' => 'index', 'create'])->names([
            'create'  => 'usuario.usuarios.create',
            'store'  => 'usuario.usuarios.store',
            'update'  => 'usuario.usuarios.update',
            'edit'    => 'usuario.usuarios.edit',
            'destroy' => 'usuario.usuarios.destroy',
            'show'    => 'usuario.usuarios.show',

        ])->parameters([
            'usuarios' => 'id',
        ]);
    }
);

Route::group([
    'prefix'     => 'usuario/excel',
    'namespace'  => 'User',
    'middleware' => 'auth',
], function () {
    Route::get('/administrador/{state}', [
        'uses' => 'AdminController@exportAdminUser',
        'as'   => 'usuario.excel.administrador',
    ]);

    Route::get('/dinamizador/{state}/{nodo}', [
        'uses' => 'DinamizadorController@exportDinamizadorUser',
        'as'   => 'usuario.excel.dinamizador',
    ]);

    Route::get('/dinamizador/{state}', [
        'uses' => 'DinamizadorController@exportDinamizadorUser',
        'as'   => 'usuario.excel.dinamizador.all',
    ]);

    Route::get('/gestor/{state}/{nodo}', [
        'uses' => 'GestorController@exportGestorUser',
        'as'   => 'usuario.excel.gestor',
    ]);

    Route::get('/gestor/{state}', [
        'uses' => 'GestorController@exportGestorUser',
        'as'   => 'usuario.excel.gestor.all',
    ]);

    Route::get('/infocenter/{state}/{nodo}', [
        'uses' => 'InfocenterController@exportInfocenterUser',
        'as'   => 'usuario.excel.infocenter',
    ]);

    Route::get('/infocenter/{state}', [
        'uses' => 'InfocenterController@exportInfocenterUser',
        'as'   => 'usuario.excel.infocenter.all',
    ]);

    Route::get('/talento/{state}/{nodo}/{anio}', [
        'uses' => 'TalentoController@exportTalentoUser',
        'as'   => 'usuario.excel.talento',
    ]);

    Route::get('/talento/{state}', [
        'uses' => 'TalentoController@exportTalentoUser',
        'as'   => 'usuario.excel.talento.all',
    ]);

    Route::get('/ingreso/{state}/{nodo}', [
        'uses' => 'IngresoController@exportIngresoUser',
        'as'   => 'usuario.excel.ingreso',
    ]);

    Route::get('/ingreso/{state}', [
        'uses' => 'IngresoController@exportIngresoUser',
        'as'   => 'usuario.excel.ingreso.all',
    ]);
});


/*========================================================================
=            seccion para las rutas de costos administrativos            =
========================================================================*/

Route::get('costos-administrativos/costoadministrativo/{nodo}', 'CostoAdministrativoController@getCostoAdministrativoPorNodo')->name('costoadministrativo.costosadministrativosfornodo');

Route::resource('costos-administrativos', 'CostoAdministrativoController', [
    'as' => 'costos-administrativos',
    'except' => [
        'create',
        'store',
        'destroy',
        'show',
    ]
])->names([
    'update'  => 'costoadministrativo.update',
    'edit'    => 'costoadministrativo.edit',
    'index'   => 'costoadministrativo.index',
])
    ->parameters([
        'costos_administrativo' => 'id',
    ]);

Route::get('costos-administrativos/costoadministrativo/{nodo}', 'CostoAdministrativoController@getCostoAdministrativoPorNodo')->name('costoadministrativo.costosadministrativosfornodo');

/*=====  End of seccion para las rutas de costos administrativos  ======*/

/*===============================================
=            seccion para los equipo            =
===============================================*/
Route::get('/equipos/getequiposporlinea/{nodo}/{lineatecnologica}', 'EquipoController@getEquiposPorLinea')
    ->name('equipo.getequiposporlinea');

Route::get('/equipos/getequipospornodo/{nodo}', 'EquipoController@getEquiposPorNodo')
    ->name('equipo.getequipospornodo');

Route::resource('equipos', 'EquipoController', [
    'as' => 'equipos',
    'except' => [
        'destroy',
        'show',
    ]
])->names([
    'index'   => 'equipo.index',
    'create'  => 'equipo.create',
    'store'   => 'equipo.store',
    'show'    => 'equipo.show',
    'update'  => 'equipo.update',
    'edit'    => 'equipo.edit',
    'destroy' => 'equipo.destroy',
])
    ->parameters([
        'equipos' => 'id',
    ]);

/*=====  End of seccion para los equipo  ======*/

/*===============================================
=            seccion para los materiales            =
===============================================*/

Route::get('/materiales/getmaterialespornodo/{nodo}', 'MaterialController@getMaterialesPorNodo')
    ->name('material.getmaterialespornodo');

Route::get('/materiales/getmaterial/{id}', 'MaterialController@getMaterial')
    ->name('material.getmaterial');

Route::resource('materiales', 'MaterialController', [
    'as' => 'materiales',
    'except' => [
        'destroy',
    ]
])->names([
    'index'   => 'material.index',
    'create'  => 'material.create',
    'store'   => 'material.store',
    'show'    => 'material.show',
    'update'  => 'material.update',
    'edit'    => 'material.edit',
    'destroy' => 'material.destroy',
])
    ->parameters([
        'materiales' => 'id',
    ]);

/*=====  End of seccion para los materiales  ======*/



/*========================================================
=            seccion para los mantenimientos             =
========================================================*/
Route::get('/mantenimientos/getmantenimientosequipospornodo/{nodo}', 'MantenimientoController@getMantenimientosEquiposPorNodo')
    ->name('mantenimiento.getmantenimientosequipospornodo');

Route::resource('mantenimientos', 'MantenimientoController', [
    'as' => 'equipos',
    'except' => [
        'destroy',
    ]
])->names([
    'index'   => 'mantenimiento.index',
    'create'  => 'mantenimiento.create',
    'store'   => 'mantenimiento.store',
    'show'    => 'mantenimiento.show',
    'update'  => 'mantenimiento.update',
    'edit'    => 'mantenimiento.edit',
    'destroy' => 'mantenimiento.destroy',
])
    ->parameters([
        'mantenimientos' => 'id',
    ]);


/*=====  End of seccion para los mantenimientos   ======*/


/*======================================================================
=            seccion para las rutas de uso de infraestructa            =
======================================================================*/

Route::group([
    'namespace'  => 'UsoInfraestructura',
    'middleware' => 'disablepreventback',
], function () {

    Route::resource('usoinfraestructura', 'UsoInfraestructuraController', ['as' => 'usoinfraestructura'])->names([
        'create'  => 'usoinfraestructura.create',
        'update'  => 'usoinfraestructura.update',
        'edit'    => 'usoinfraestructura.edit',
        'destroy' => 'usoinfraestructura.destroy',
        'show'    => 'usoinfraestructura.show',
        'index'   => 'usoinfraestructura.index',
        'store'   => 'usoinfraestructura.store',
    ])->parameters([
        'usoinfraestructura' => 'id',
    ]);

    //consultas que se utlizan para el uso de infraestructura

    Route::get('usoinfraestructura/projectsforuser', 'UsoInfraestructuraController@projectsForUser')
        ->name('usoinfraestructura.projectsforuser');


    Route::get('usoinfraestructura/talentosporproyecto/{id}', 'UsoInfraestructuraController@talentosPorProyecto')->name('usoinfraestructura.talentosporproyecto');

    Route::get('usoinfraestructura/articulacionesforuser', 'UsoInfraestructuraController@articulacionesForUser')
        ->name('usoinfraestructura.articulacionesforuser');


    Route::get('usoinfraestructura/talentosporarticulacion/{id}', 'UsoInfraestructuraController@talentosPorArticulacion')
        ->name('usoinfraestructura.talentosporarticulacion');

    Route::get('usoinfraestructura/edtforuser/{id}', 'UsoInfraestructuraController@edtForUser')
        ->name('usoinfraestructura.edtforuser');

    Route::get('usoinfraestructura/edtsforuser', 'UsoInfraestructuraController@edtsForUser')
        ->name('usoinfraestructura.edtsforuser');

    Route::get('usoinfraestructura/usoinfraestructurapornodo/{id}', 'UsoInfraestructuraController@getUsoInfraestructuraForNodo')
        ->name('usoinfraestructura.usoinfraestructurapornodo');

    Route::get('usoinfraestructura/projectsforuser', 'UsoInfraestructuraController@projectsForUser')
        ->name('usoinfraestructura.projectsforuser');
    Route::get('usoinfraestructura/projectsforuser/{id}', 'UsoInfraestructuraController@projectsByUser')
        ->name('usoinfraestructura.projectsforuser.projects');

    Route::get('usoinfraestructura/actividades/{gestor}/{anio}', 'UsoInfraestructuraController@activitiesByGestor')
        ->name('usoinfraestructura.actividadesporgestor');

    Route::get('usoinfraestructura/actividades/datatable/{gestor}/{anio}/{actividad}', 'UsoInfraestructuraController@getDatatableInfoActividad')
        ->name('usoinfraestructura.actividadesdatatable');

    Route::delete('usoinfraestructura/{id}', 'UsoInfraestructuraController@destroy')
        ->name('usoinfraestructura.destroy');
});

/*=====  End of seccion para las rutas de uso de infraestructa  ======*/

/*=========================================================
=            seccion para las rutas del centro de formacion            =
=========================================================*/
Route::get('centro-formacion/getcentrosregional/{regional}', 'CentroController@getAllCentrosForRegional')->name('centro.getcentrosregional');
Route::resource('centro-formacion', 'CentroController');

/*=====  End of seccion para las rutas del centro de formacion  ======*/

/*=========================================================
=            seccion para las rutas del perfil            =
=========================================================*/
Route::get('certificado', 'User\ProfileController@downloadCertificatedPlataform')->name('certificado');
Route::get('perfil/cuenta', 'User\ProfileController@account')->name('perfil.cuenta')->middleware('disablepreventback');
Route::get('perfil', 'User\ProfileController@index')->name('perfil.index')->middleware('disablepreventback');
Route::get('perfil/roles', 'User\ProfileController@roles')->name('perfil.roles')->middleware('disablepreventback');
Route::put('perfil/contraseña', 'User\ProfileController@updatePassword')->name('perfil.contraseña')->middleware('disablepreventback');
Route::get('perfil/password/reset', 'User\ProfileController@passwordReset')->name('perfil.password.reset')->middleware('disablepreventback');
Route::get('perfil/editar', 'User\ProfileController@editAccount')->name('perfil.edit')->middleware('disablepreventback');
Route::resource('perfil', 'User\ProfileController', ['only' => ['update', 'destroy']])->middleware('disablepreventback');

/*=====  End of seccion para las rutas del perfil  ======*/

/*========================================================
=            sesccion para las rutas de ayuda            =
========================================================*/

Route::get('help/getciudades/{departamento?}', 'Help\HelpController@getCiudad')->name('help.getciudades');
Route::get('help/getcentrosformacion/{regional?}', 'Help\HelpController@getCentrosRegional')->name('help.getcentrosformacion');

/*=====  End of sesccion para las rutas de ayuda  ======*/

//-------------------Route group para el módulo de ideas
Route::group(
    [
        'prefix' => 'idea',
    ],
    function () {
        Route::get('/', 'IdeaController@ideas')->name('idea.ideas');
        // Route::get('/egi', 'IdeaController@empresasGI')->name('idea.egi');
        Route::get('/{idea}', 'IdeaController@details')->name('idea.details');
        Route::get('/consultarIdeasEmprendedoresPorNodo/{id}', 'IdeaController@dataTableIdeasEmprendedoresPorNodo')->name('idea.emprendedores');
        Route::get('/consultarIdeasEmpresasGIPorNodo/{id}', 'IdeaController@dataTableIdeasEmpresasGIPorNodo')->name('idea.empresasgi');
        Route::get('/consultarIdeasTodosPorNodo/{id}', 'IdeaController@dataTableIdeasTodosPorNodo')->name('idea.todas');
        Route::get('/{id}/edit', 'IdeaController@edit')->name('idea.edit')->middleware(['auth', 'role_session:Infocenter']);
        Route::get('detallesIdea/{id}', 'IdeaController@detallesIdeas')->name('idea.det');
        Route::get('/updateEstadoIdea/{id}/{estado}', 'IdeaController@updateEstadoIdea')->name('idea.update.estado')->middleware(['auth', 'role_session:Infocenter']);
        Route::put('/{idea}', 'IdeaController@update')->name('idea.update')->middleware(['auth', 'role_session:Infocenter']);
        Route::post('/', 'IdeaController@store')->name('idea.store');
        // Route::post('/egi', 'IdeaController@storeEGI')->name('idea.storeegi')->middleware(['auth', 'role_session:Infocenter']);
        Route::post('/addIdeaDeProyectoAlComite', 'IdeaController@addIdeaDeProyectoCreate');
    }
);

//-------------------Route group para el módulo de Entrenamientos
Route::group(
    [
        'prefix'     => 'entrenamientos',
        'middleware' => ['auth', 'role_session:Infocenter|Administrador|Dinamizador|Gestor'],
    ],
    function () {
        Route::get('/', 'EntrenamientoController@index')->name('entrenamientos');
        Route::get('/consultarEntrenamientosPorNodo/{id}', 'EntrenamientoController@datatableEntrenamientosPorNodo');
        Route::get('/consultarEntrenamientosPorNodo', 'EntrenamientoController@datatableEntrenamientosPorNodo_Dinamizador');
        Route::get('/create', 'EntrenamientoController@create')->name('entrenamientos.create')->middleware('role_session:Infocenter');
        Route::get('/{id}/edit', 'EntrenamientoController@edit')->name('entrenamientos.edit')->middleware('role_session:Infocenter');
        Route::get('/{id}', 'EntrenamientoController@details')->name('entrenamientos.details');
        Route::get('/inhabilitarEntrenamiento/{id}/{estado}', 'EntrenamientoController@inhabilitarEntrenamiento')->name('entrenamientos.inhabilitar')->middleware('role_session:Infocenter');
        Route::get('/{id}/evidencias', 'EntrenamientoController@evidencias')->name('entrenamientos.evidencias');
        Route::get('/getideasEntrenamiento', 'EntrenamientoController@get_ideasEntrenamiento')->middleware('role_session:Infocenter');
        Route::get('/getConfirm/{id}/{estado}', 'EntrenamientoController@getConfirm')->middleware('role_session:Infocenter');
        Route::get('/getCanvas/{id}/{estado}', 'EntrenamientoController@getCanvas')->middleware('role_session:Infocenter');
        Route::get('/getAssistF/{id}/{estado}', 'EntrenamientoController@getAssistF')->middleware('role_session:Infocenter');
        Route::get('/getAssistS/{id}/{estado}', 'EntrenamientoController@getAssistS')->middleware('role_session:Infocenter');
        Route::get('/getConvocado/{id}/{estado}', 'EntrenamientoController@getConvocado')->middleware('role_session:Infocenter');
        Route::get('/eliminar/{id}', 'EntrenamientoController@eliminar_idea')->middleware('role_session:Infocenter');
        Route::get('/downloadFile/{id}', 'ArchivoController@downloadFileEntrenamiento')->name('entrenamientos.files.download');
        Route::get('/datatableArchivosDeUnEntrenamiento/{id}', 'ArchivoController@datatableArchivosDeUnEntrenamiento');
        // Route::put('/{id}', 'EntrenamientoController@update')->name('entrenamientos.update');
        Route::put('/updateEvidencias/{id}', 'EntrenamientoController@updateEvidencias')->name('entrenamientos.update.evidencias')->middleware('role_session:Infocenter');
        Route::post('/', 'EntrenamientoController@store')->name('entrenamientos.store')->middleware('role_session:Infocenter');
        Route::post('/addidea', 'EntrenamientoController@add_idea')->middleware('role_session:Infocenter');
        Route::post('/store/{id}/files', 'ArchivoController@uploadFileEntrenamiento')->name('entrenamientos.files.store')->middleware('role_session:Infocenter');
        Route::delete('/file/{idFile}', 'ArchivoController@destroyFileEntrenamiento')->name('entrenamientos.files.destroy')->middleware('role_session:Infocenter');
    }
);

//-------------------Route group para el módulo de Comité
Route::group(
    [
        'prefix'     => 'csibt',
        'middleware' => ['auth', 'role_session:Administrador|Dinamizador|Gestor|Infocenter'],
    ],
    function () {
        Route::get('/', 'ComiteController@index')->name('csibt');
        Route::get('/create', 'ComiteController@create')->name('csibt.create');
        Route::get('/{id}/edit', 'ComiteController@edit')->name('csibt.edit')->middleware('role_session:Infocenter');
        Route::get('/{id}', 'ComiteController@show')->name('csibt.show');
        Route::get('/{id}/evidencias', 'ComiteController@evidencias')->name('csibt.evidencias');
        Route::get('/{id}/consultarCsibtPorNodo', 'ComiteController@datatableCsibtPorNodo_Administrador')->name('csibt.show');
        Route::get('/getideasComiteCreate', 'ComiteController@get_ideasComiteCreate');
        Route::get('/eliminarIdeaCC/{id}', 'ComiteController@get_eliminarIdeaComiteCreate');
        Route::get('/archivosDeUnComite/{id}', 'ComiteController@datatableArchivosDeUnComite');
        Route::get('/downloadFile/{id}', 'ArchivoComiteController@downloadFile')->name('csibt.files.download');
        Route::put('/updateEvidencias/{id}', 'ComiteController@updateEvidencias')->name('csibt.update.evidencias');
        Route::put('/{id}', 'ComiteController@update')->name('csibt.update')->middleware('role_session:Infocenter');
        Route::post('/addIdeaComite', 'ComiteController@addIdeaDeProyectoCreate');
        Route::post('/', 'ComiteController@store')->name('csibt.store');
        Route::post('/store/{id}/filesComite', 'ArchivoComiteController@store')->name('csibt.files.store');
        Route::delete('/file/{idFile}', 'ArchivoComiteController@destroy')->name('csibt.files.destroy');
    }
);

//-------------------Route group para el módulo de Comité
Route::group(
    [
        'prefix'     => 'empresa',
        'middleware' => ['auth', 'role_session:Administrador|Dinamizador|Gestor'],
    ],
    function () {
        Route::get('/', 'EmpresaController@index')->name('empresa');
        Route::get('/create', 'EmpresaController@create')->name('empresa.create');
        Route::get('/datatableEmpresasDeTecnoparque', 'EmpresaController@datatableEmpresasDeTecnoparque')->name('empresa.datatable');
        Route::get('/{id}/edit', 'EmpresaController@edit')->name('empresa.edit');
        Route::get('/ajaxDetallesDeUnaEmpresa/{id}', 'EmpresaController@detalleDeUnaEmpresa')->name('empresa.detalle');
        Route::get('/ajaxContactosDeUnaEntidad/{identidad}', 'EmpresaController@contactosDeLaEmpresaPorNodo')->name('empresa.contactos.nodo');
        Route::get('/ajaxConsultarEmpresaPorIdEntidad/{identidad}', 'EmpresaController@consultarEmpresaPorIdEntidad')->name('empresa.detalle.entidad');
        Route::put('/updateContactoDeUnaEmpresa/{id}', 'EmpresaController@updateContactosEmpresa')->name('empresa.update.contactos');
        Route::put('/{id}', 'EmpresaController@update')->name('empresa.update');
        Route::post('/', 'EmpresaController@store')->name('empresa.store');
    }
);

//-------------------Route group para el módulo de Comité
Route::group(
    [
        'prefix'     => 'grupo',
        'middleware' => ['auth', 'role_session:Administrador|Dinamizador|Gestor'],
    ],
    function () {
        Route::get('/getgrupodatatables/{ciudad}', 'GrupoInvestigacionController@getDataTablesForGrupoCiudad')->name('getallgruposdatatables');
        Route::get('/getallgruposforciudad/{ciudad}', 'GrupoInvestigacionController@getAllGruposInvestigacionForCiudad')->name('getallgruposforciudad');
        Route::get('/', 'GrupoInvestigacionController@index')->name('grupo');
        Route::get('/create', 'GrupoInvestigacionController@create')->name('grupo.create')->middleware('role_session:Dinamizador|Gestor');
        Route::get('/datatableGruposInvestigacionDeTecnoparque', 'GrupoInvestigacionController@datatableGruposInvestigacionDeTecnoparque')->name('grupo.datatable');
        Route::get('/{id}/edit', 'GrupoInvestigacionController@edit')->name('grupo.edit')->middleware('role_session:Dinamizador|Gestor');
        Route::get('/ajaxDetallesDeUnGrupoInvestigacion/{id}', 'GrupoInvestigacionController@detallesDeUnGrupoInvestigacion')->name('grupo.detalle');
        Route::get('/ajaxContactosDeUnaEntidad/{identidad}', 'GrupoInvestigacionController@contactosDelGrupoPorNodo')->name('grupo.contactos.nodo');
        Route::put('/updateContactoDeUnGrupo/{id}', 'GrupoInvestigacionController@updateContactosGrupo')->name('grupo.update.contactos');
        Route::put('/{id}', 'GrupoInvestigacionController@update')->name('grupo.update')->middleware('role_session:Dinamizador|Gestor');
        Route::post('/', 'GrupoInvestigacionController@store')->name('grupo.store')->middleware('role_session:Dinamizador|Gestor');
    }
);

//-------------------Route group para el módulo de Comité
Route::group(
    [
        'prefix'     => 'articulacion',
        'middleware' => ['auth', 'role_session:Administrador|Dinamizador|Gestor'],
    ],
    function () {
        Route::get('/notificar_inicio/{id}', 'ArticulacionController@notificar_inicio')->name('articulacion.notificar.inicio')->middleware('role_session:Gestor');
        Route::get('/notificar_planeacion/{id}', 'ArticulacionController@notificar_planeacion')->name('articulacion.notificar.planeacion')->middleware('role_session:Gestor');
        Route::get('/notificar_ejecucion/{id}', 'ArticulacionController@notificar_ejecucion')->name('articulacion.notificar.ejecucion')->middleware('role_session:Gestor');
        Route::get('/notificar_cierre/{id}', 'ArticulacionController@notificar_cierre')->name('articulacion.notificar.cierre')->middleware('role_session:Gestor');
        Route::get('/notificar_suspendido/{id}', 'ArticulacionController@notificar_suspendido')->name('articulacion.notificar.suspension')->middleware('role_session:Gestor');

        Route::get('/', 'ArticulacionController@index')->name('articulacion');
        Route::get('/inicio/{id}', 'ArticulacionController@inicio')->name('articulacion.inicio')->middleware('role_session:Gestor|Dinamizador|Talento|Administrador');
        Route::get('/planeacion/{id}', 'ArticulacionController@planeacion')->name('articulacion.planeacion')->middleware('role_session:Gestor|Dinamizador|Talento|Administrador');
        Route::get('/ejecucion/{id}', 'ArticulacionController@ejecucion')->name('articulacion.ejecucion')->middleware('role_session:Gestor|Dinamizador|Talento|Administrador');
        Route::get('/cierre/{id}', 'ArticulacionController@cierre')->name('articulacion.cierre')->middleware('role_session:Gestor|Dinamizador|Talento|Administrador');

        Route::get('/eliminarArticulacion/{id}', 'ArticulacionController@eliminarArticulación')->name('articulacion.delete')->middleware('role_session:Dinamizador');
        Route::get('/create', 'ArticulacionController@create')->name('articulacion.create')->middleware('role_session:Gestor');
        Route::get('/datatableArticulacionesDelGestor/{id}/{anho}', 'ArticulacionController@datatableArticulacionesPorGestor')->name('articulacion.datatable');
        Route::get('/datatableArticulacionesDelNodo/{id}/{anho}', 'ArticulacionController@datatableArticulacionesPorNodo')->name('articulacion.datatable.nodo')->middleware('role_session:Dinamizador|Administrador');
        Route::get('/{id}/edit', 'ArticulacionController@edit')->name('articulacion.edit')->middleware('role_session:Gestor|Dinamizador');
        Route::get('/detalle/{id}', 'ArticulacionController@detalles')->name('articulacion.detalle')->middleware('role_session:Administrador|Dinamizador|Gestor');
        Route::get('/ajaxDetallesDeLosEntregablesDeUnaArticulacion/{id}', 'ArticulacionController@detallesDeLosEntregablesDeUnaArticulacion')->name('articulacion.detalle.entregables');
        Route::get('/consultarTiposArticulacion/{id}', 'ArticulacionController@consultarTipoArticulacion')->name('articulacion.tiposarticulacion');
        Route::get('/{id}/entregables', 'ArticulacionController@entregables')->name('articulacion.entregables');
        Route::get('/archivosDeUnaArticulacion/{id}/{fase}', 'ArchivoController@datatableArchivosDeUnaArticulacion')->name('articulacion.files');
        Route::get('/consultarEntidadDeLaArticulacion/{id}', 'ArticulacionController@consultarEntidadDeLaArticulacion')->name('articulacion.detalle.entidad');
        Route::get('/downloadFile/{id}', 'ArchivoController@downloadFileArticulacion')->name('articulacion.files.download');
        Route::get('/entregables/inicio/{id}', 'ArticulacionController@entregables_inicio')->name('articulacion.entregables.inicio')->middleware('role_session:Gestor');
        Route::get('/suspender/{id}', 'ArticulacionController@suspender')->name('articulacion.suspender')->middleware('role_session:Gestor|Dinamizador');
        Route::get('/cambiar_gestor/{id}', 'ArticulacionController@cambiar_gestor')->name('articulacion.cambiar')->middleware('role_session:Dinamizador');
        Route::get('/entregables/cierre/{id}', 'ArticulacionController@entregables_cierre')->name('articulacion.entregables.cierre')->middleware('role_session:Gestor');
        Route::put('/inicio/{id}', 'ArticulacionController@updateInicio')->name('articulacion.update.inicio')->middleware('role_session:Gestor|Dinamizador');
        Route::put('/planeacion/{id}', 'ArticulacionController@updatePlaneacion')->name('articulacion.update.planeacion')->middleware('role_session:Gestor|Dinamizador');
        Route::put('/ejecucion/{id}', 'ArticulacionController@updateEjecucion')->name('articulacion.update.ejecucion')->middleware('role_session:Gestor|Dinamizador');
        Route::put('/cierre/{id}', 'ArticulacionController@updateCierre')->name('articulacion.update.cierre')->middleware('role_session:Gestor|Dinamizador');
        Route::put('/suspendido/{id}', 'ArticulacionController@updateSuspendido')->name('articulacion.update.suspendido')->middleware('role_session:Gestor|Dinamizador');
        Route::put('/updateEntregables/{id}', 'ArticulacionController@updateEntregables')->name('articulacion.update.entregables.inicio')->middleware('role_session:Gestor|Dinamizador');
        Route::put('/updateEntregables_Cierre/{id}', 'ArticulacionController@updateEntregables_Cierre')->name('articulacion.update.entregables.cierre')->middleware('role_session:Gestor|Dinamizador');
        Route::put('/update_gestor/{id}', 'ArticulacionController@updateGestor')->name('articulacion.update.gestor')->middleware('role_session:Dinamizador');
        Route::put('/reversar/{id}', 'ArticulacionController@updateReversar')->name('articulacion.reversar')->middleware('role_session:Dinamizador');
        Route::put('/{id}', 'ArticulacionController@update')->name('articulacion.update')->middleware('role_session:Gestor|Dinamizador');
        Route::post('/', 'ArticulacionController@store')->name('articulacion.store')->middleware('role_session:Gestor');
        Route::post('/store/{id}/files', 'ArchivoController@uploadFileArticulacion')->name('articulacion.files.upload')->middleware('role_session:Gestor');
    }
);

//Route group para el módulo de proyectos
Route::group(

    [
        'prefix'     => 'proyecto',
        'middleware' => ['auth', 'role_session:Administrador|Dinamizador|Gestor|Talento|Infocenter'],
    ],
    function () {
        Route::get('/notificar_inicio/{id}', 'ProyectoController@notificar_inicio')->name('proyecto.notificar.inicio')->middleware('role_session:Gestor');
        Route::get('/notificar_planeacion/{id}', 'ProyectoController@notificar_planeacion')->name('proyecto.notificar.planeacion')->middleware('role_session:Gestor');
        Route::get('/notificar_ejecucion/{id}', 'ProyectoController@notificar_ejecucion')->name('proyecto.notificar.ejecucion')->middleware('role_session:Gestor');
        Route::get('/notificar_cierre/{id}', 'ProyectoController@notificar_cierre')->name('proyecto.notificar.cierre')->middleware('role_session:Gestor');
        Route::get('/notificar_suspendido/{id}', 'ProyectoController@notificar_suspendido')->name('proyecto.notificar.suspension')->middleware('role_session:Gestor');

        Route::get('/', 'ProyectoController@index')->name('proyecto');
        Route::get('/create', 'ProyectoController@create')->name('proyecto.create')->middleware('role_session:Gestor');
        Route::get('/datatableProyectosDelTalento', 'ProyectoController@datatableProyectoTalento')->name('proyecto.datatable.talento');
        Route::get('/datatableEntidad/{id}', 'ProyectoController@datatableEntidadesTecnoparque')->name('proyecto.datatable.entidades');
        Route::get('/datatableEmpresasTecnoparque', 'ProyectoController@datatableEmpresasTecnoparque')->name('proyecto.datatable.empresas')->middleware('role_session:Talento');
        Route::get('/datatableGruposInvestigacionTecnoparque/{tipo}', 'ProyectoController@datatableGruposInvestigacionTecnoparque')->name('proyecto.datatable.empresas');
        Route::get('/datatableTecnoacademiasTecnoparque', 'ProyectoController@datatableTecnoacademiasTecnoparque')->name('proyecto.datatable.tecnoacademias');
        Route::get('/datatableNodosTecnoparque', 'ProyectoController@datatableNodosTecnoparque')->name('proyecto.datatable.nodos');
        Route::get('/datatableCentroFormacionTecnoparque', 'ProyectoController@datatableCentroFormacionTecnoparque')->name('proyecto.datatable.centros');
        Route::get('/datatableIdeasConEmprendedores', 'ProyectoController@datatableIdeasConEmprendedores')->name('proyecto.datatable.ideas.emprendedores');
        Route::get('/datatableIdeasConEmpresasGrupo', 'ProyectoController@datatableIdeasConEmpresasGrupo')->name('proyecto.datatable.ideas.empresasgrupos');
        Route::get('/datatableProyectosDelGestorPorAnho/{idgestor}/{anho}', 'ProyectoController@datatableProyectosDelGestorPorAnho')->name('proyecto.datatable.proyectos.gestor.anho')->middleware('role_session:Administradro|Dinamizador|Gestor');
        Route::get('/datatableProyectosDelNodoPorAnho/{idnodo}/{anho}', 'ProyectoController@datatableProyectosDelNodoPorAnho')->name('proyecto.datatable.proyectos.nodo.anho');
        Route::get('/detalle/{id}', 'ProyectoController@detalle')->name('proyecto.detalle')->middleware('role_session:Gestor|Dinamizador|Talento|Administrador');
        Route::get('/inicio/{id}', 'ProyectoController@inicio')->name('proyecto.inicio')->middleware('role_session:Gestor|Dinamizador|Talento|Administrador|Infocenter');
        Route::get('/planeacion/{id}', 'ProyectoController@planeacion')->name('proyecto.planeacion')->middleware('role_session:Gestor|Dinamizador|Talento|Administrador|Infocenter');
        Route::get('/ejecucion/{id}', 'ProyectoController@ejecucion')->name('proyecto.ejecucion')->middleware('role_session:Gestor|Dinamizador|Talento|Administrador|Infocenter');
        Route::get('/cierre/{id}', 'ProyectoController@cierre')->name('proyecto.cierre')->middleware('role_session:Gestor|Dinamizador|Talento|Administrador|Infocenter');
        Route::get('/suspender/{id}', 'ProyectoController@suspender')->name('proyecto.suspender')->middleware('role_session:Gestor|Dinamizador');
        Route::get('/cambiar_gestor/{id}', 'ProyectoController@cambiar_gestor')->name('proyecto.cambiar')->middleware('role_session:Dinamizador');
        Route::get('/entregables/inicio/{id}', 'ProyectoController@entregables_inicio')->name('proyecto.entregables.inicio')->middleware('role_session:Gestor');
        Route::get('/entregables/cierre/{id}', 'ProyectoController@entregables_cierre')->name('proyecto.entregables.cierre')->middleware('role_session:Gestor');
        Route::get('/ajaxConsultarTalentosDeUnProyecto/{id}', 'ProyectoController@consultarTalentosDeUnProyecto')->name('proyecto.talentos');
        Route::get('/downloadFile/{id}', 'ArchivoController@downloadFileProyecto')->name('proyecto.files.download');
        Route::get('/archivosDeUnProyecto/{id}/{fase}', 'ArchivoController@datatableArchivosDeUnProyecto')->name('proyecto.files');
        Route::get('/eliminarProyecto/{id}', 'ProyectoController@eliminarProyecto_Controller')->name('proyecto.delete')->middleware('role_session:Dinamizador');
        Route::put('/inicio/{id}', 'ProyectoController@updateInicio')->name('proyecto.update.inicio')->middleware('role_session:Gestor|Dinamizador');
        Route::put('/planeacion/{id}', 'ProyectoController@updatePlaneacion')->name('proyecto.update.planeacion')->middleware('role_session:Gestor|Dinamizador');
        Route::put('/ejecucion/{id}', 'ProyectoController@updateEjecucion')->name('proyecto.update.ejecucion')->middleware('role_session:Gestor|Dinamizador');
        Route::put('/cierre/{id}', 'ProyectoController@updateCierre')->name('proyecto.update.cierre')->middleware('role_session:Gestor|Dinamizador');
        Route::put('/suspendido/{id}', 'ProyectoController@updateSuspendido')->name('proyecto.update.suspendido')->middleware('role_session:Gestor|Dinamizador');
        Route::put('/updateEntregables/{id}', 'ProyectoController@updateEntregables')->name('proyecto.update.entregables.inicio')->middleware('role_session:Gestor|Dinamizador');
        Route::put('/updateEntregables_Cierre/{id}', 'ProyectoController@updateEntregables_Cierre')->name('proyecto.update.entregables.cierre')->middleware('role_session:Gestor|Dinamizador');
        Route::put('/update_gestor/{id}', 'ProyectoController@updateGestor')->name('proyecto.update.gestor')->middleware('role_session:Dinamizador');
        Route::put('/reversar/{id}', 'ProyectoController@updateReversar')->name('proyecto.reversar')->middleware('role_session:Dinamizador');
        Route::post('/', 'ProyectoController@store')->name('proyecto.store')->middleware('role_session:Gestor');
        Route::post('/store/{id}/files', 'ArchivoController@uploadFileProyecto')->name('proyecto.files.upload')->middleware('role_session:Gestor');
        Route::delete('/file/{idFile}', 'ArchivoController@destroyFileProyecto')->name('proyecto.files.destroy')->middleware('role_session:Gestor');
    }
);

/**
 * Route group para el módulo de edt (Eventos de Divulgación Tecnológica)
 */
Route::group(
    [
        'prefix'     => 'edt',
        'middleware' => ['auth', 'role_session:Gestor|Dinamizador|Administrador'],
    ],
    function () {
        //
        Route::get('/', 'EdtController@index')->name('edt');
        Route::get('/eliminarEdt/{id}', 'EdtController@eliminarEdt')->name('edt.delete')->middleware('role_session:Dinamizador');
        Route::get('/create', 'EdtController@create')->name('edt.create')->middleware('role_session:Gestor');
        Route::get('/{id}/edit', 'EdtController@edit')->name('edt.edit')->middleware('role_session:Gestor|Dinamizador');
        Route::get('/{id}/entregables', 'EdtController@entregables')->name('edt.entregables');
        Route::get('/consultarEdtsDeUnGestor/{id}/{anho}', 'EdtController@consultarEdtsDeUnGestor')->name('edt.gestor');
        Route::get('/consultarEdtsDeUnNodo/{id}/{anho}', 'EdtController@consultarEdtsDeUnNodo')->name('edt.nodo')->middleware('role_session:Dinamizador|Administrador');
        Route::get('/consultarDetallesDeUnaEdt/{id}/{tipo}', 'EdtController@consultarDetallesDeUnaEdt')->name('edt.entidades');
        Route::get('/archivosDeUnaEdt/{id}', 'ArchivoController@datatableArchivosDeUnaEdt')->name('edt.files');
        Route::get('/downloadFile/{id}', 'ArchivoController@downloadFileEdt')->name('edt.files.download');
        Route::put('/{id}', 'EdtController@update')->name('edt.update')->middleware('role_session:Gestor|Dinamizador');
        Route::put('/updateEntregables/{id}', 'EdtController@updateEntregables')->name('edt.update.evidencias')->middleware('role_session:Gestor');
        Route::post('/', 'EdtController@store')->name('edt.store')->middleware('role_session:Gestor');
        Route::post('/store/{id}/files', 'ArchivoController@uploadFileEdt')->name('edt.files.upload')->middleware('role_session:Gestor');
        Route::delete('/file/{idFile}', 'ArchivoController@destroyFileEdt')->name('edt.files.destroy')->middleware('role_session:Gestor');
    }
);

/**
 * Route group para el módulo visitantes
 */
Route::group(
    [
        'prefix'     => 'visitante',
        'middleware' => ['auth', 'role_session:Ingreso|Dinamizador|Administrador'],
    ],
    function () {
        Route::get('/', 'VisitanteController@index')->name('visitante');
        Route::get('/create', 'VisitanteController@create')->name('visitante.create')->middleware('role_session:Ingreso');
        Route::get('/consultarVisitantesRedTecnoparque', 'VisitanteController@consultarVisitantesRedTecnoparque')->name('visitante.tecnoparque');
        Route::get('/{id}/edit', 'VisitanteController@edit')->name('visitante.edit')->middleware('role_session:Ingreso');
        Route::get('/consultarVisitantePorDocumento/{doc}', 'VisitanteController@consultarVisitantePorDocumento')->name('visitante.documento');
        Route::put('/{id}', 'VisitanteController@update')->name('visitante.update')->middleware('role_session:Ingreso');
        Route::post('/', 'VisitanteController@store')->name('visitante.store')->middleware('role_session:Ingreso');
    }
);

/**
 * Route group para el módulo de ingresos de visitantes
 */
Route::group(
    [
        'prefix'     => 'ingreso',
        'middleware' => ['auth', 'role_session:Ingreso|Dinamizador|Administrador'],
    ],
    function () {
        Route::get('/', 'IngresoVisitanteController@index')->name('ingreso');
        Route::get('/create', 'IngresoVisitanteController@create')->name('ingreso.create')->middleware('role_session:Ingreso');
        Route::get('/consultarIngresosDeUnNodoTecnoparque/{id}', 'IngresoVisitanteController@datatableIngresosDeUnNodo')->name('ingreso.nodo');
        Route::get('/{id}/edit', 'IngresoVisitanteController@edit')->name('ingreso.edit')->middleware('role_session:Ingreso');
        Route::put('/{id}', 'IngresoVisitanteController@update')->name('ingreso.update')->middleware('role_session:Ingreso');
        Route::post('/', 'IngresoVisitanteController@store')->name('ingreso.store')->middleware('role_session:Ingreso');
    }
);
/**
 * Route group para el módulo de charlas informativas
 */
Route::group(
    [
        'prefix'     => 'charla',
        'middleware' => ['auth', 'role_session:Infocenter|Dinamizador|Administrador'],
    ],
    function () {
        Route::get('/', 'CharlaInformativaController@index')->name('charla');
        Route::get('/create', 'CharlaInformativaController@create')->name('charla.create')->middleware('role_session:Infocenter');
        Route::get('/consultarCharlasInformativasPorNodo/{id}', 'CharlaInformativaController@datatableCharlasInformativosDeUnNodo')->name('charla.nodo');
        Route::get('/{id}/evidencias', 'CharlaInformativaController@evidencias')->name('charla.evidencias');
        Route::get('/consultarDetallesDeUnaCharlaInformativa/{id}', 'CharlaInformativaController@detallesDeUnaCharlaInformativa')->name('charla.detalle');
        Route::get('/archivosDeUnaCharlaInformartiva/{id}', 'ArchivoController@datatableArchivosDeUnaCharlaInformatva')->name('charla.files');
        Route::get('/downloadFile/{id}', 'ArchivoController@downloadFileCharlaInformativa')->name('charla.files.download');
        Route::get('/{id}/edit', 'CharlaInformativaController@edit')->name('charla.edit')->middleware('role_session:Infocenter');
        Route::put('/{id}', 'CharlaInformativaController@update')->name('charla.update')->middleware('role_session:Infocenter');
        Route::put('/updateEvidencias/{id}', 'CharlaInformativaController@updateEvidencias')->name('charla.update.evidencias')->middleware('role_session:Infocenter');
        Route::post('/', 'CharlaInformativaController@store')->name('charla.store')->middleware('role_session:Infocenter');
        Route::post('/store/{id}/files', 'ArchivoController@uploadFileCharlaInformartiva')->name('charla.files.upload')->middleware('role_session:Infocenter');
        Route::delete('/file/{idFile}', 'ArchivoController@destroyFileCharlaInformartiva')->name('charla.files.destroy')->middleware('role_session:Infocenter');
    }
);
/**
 * Route group para el módulo de gráficos
 */

Route::group(
    [
        'prefix'     => 'grafico',
        'middleware' => ['auth', 'role_session:Gestor|Infocenter|Dinamizador|Administrador|Ingreso'],
    ],
    function () {
        // Gráficos de articulaciones
        Route::get('/', 'GraficoController@index')->name('grafico');
        Route::get('/articulaciones', 'GraficoController@articulacionesGraficos')->name('grafico.articulacion')->middleware('role_session:Gestor|Dinamizador|Administrador');
        Route::get('/consultarArticulacionesPorNodo/{id}/{fecha_inicio}/{fecha_fin}', 'Graficos\ArticulacionController@articulacionesNodoGrafico')->name('grafico.nodo.articulacion')->middleware('role_session:Dinamizador|Administrador');
        Route::get('/consultarArticulacionesPorGestorYFecha/{id}/{fecha_inicio}/{fecha_fin}', 'Graficos\ArticulacionController@articulacionesGestorGrafico')->name('grafico.gestor.articulacion')->middleware('role_session:Dinamizador|Administrador|Gestor');
        Route::get('/consultarCantidadDeArticulacionesPorTipoDeUnaLineaTecnologicaYFecha/{idnodo}/{id}/{fecha_inicio}/{fecha_fin}', 'Graficos\ArticulacionController@articulacionesLineaTecnologicaYFechaGrafico')->name('grafico.linea.articulacion')->middleware('role_session:Dinamizador|Administrador');
        Route::get('/consultarArticulacionesPorNodoYAnho/{id}/{anho}', 'Graficos\ArticulacionController@articulacionesPorNodoYAnho_Controller')->name('grafico.nodo.anho.articulacion')->middleware('role_session:Dinamizador|Administrador');
        // Gráficos de edt
        Route::get('/edts', 'GraficoController@edtsGraficos')->name('grafico.edt')->middleware('role_session:Gestor|Dinamizador|Administrador');
        Route::get('/consultarEdtsPorNodoGestorYFecha/{id}/{fecha_inicio}/{fecha_fin}', 'Graficos\EdtController@edtsNodoGrafico')->name('grafico.edt.nodo')->middleware('role_session:Dinamizador|Administrador');
        Route::get('/consultarEdtsPorGestorYFecha/{id}/{idnodo}/{fecha_inicio}/{fecha_fin}', 'Graficos\EdtController@edtsGestorGrafico')->name('grafico.edt.gestor')->middleware('role_session:Dinamizador|Administrador|Gestor');
        Route::get('/consultarEdtsPorLineaYFecha/{id}/{idnodo}/{fecha_inicio}/{fecha_fin}', 'Graficos\EdtController@edtsLineaGrafico')->name('grafico.edt.linea')->middleware('role_session:Dinamizador|Administrador|Gestor');
        Route::get('/consultarEdtsPorNodoYAnho/{id}/{anho}', 'Graficos\EdtController@edtsPorNodoAnhoGrafico_Controller')->name('grafico.edt.nodo.anho')->middleware('role_session:Dinamizador|Administrador');
        // Gráficos de proyecto
        Route::get('/proyectos', 'GraficoController@proyectosGraficos')->name('grafico.proyectos')->middleware('role_session:Gestor|Dinamizador|Administrador');
        Route::get('/consultarProyectosInscritosPorAnho/{id}/{anho}', 'Graficos\ProyectoController@proyectosPorFechaInicioNodoYAnhoGrafico_Controller')->name('grafico.proyecto.nodo.anho')->middleware('role_session:Dinamizador|Administrador');
        Route::get('/consultarProyectosInscritosConEmpresasPorAnho/{id}/{anho}', 'Graficos\ProyectoController@proyectosInscritosConEmpresasPorMesDeUnNodo_Controller')->name('grafico.proyecto.empresas.nodo.anho')->middleware('role_session:Dinamizador|Administrador');
        Route::get('/consultarProyectosInscritosPorTipoNodoYFecha/{id}/{fecha_inicio}/{fecha_fin}', 'Graficos\ProyectoController@proyectosPorTipoProyectoNodo_Controller')->middleware('role_session:Dinamizador|Administrador');
        Route::get('/consultarProyectosFinalzadosPorAnho/{id}/{anho}', 'Graficos\ProyectoController@proyectosFinalizadosPorNodoYAnho_Controller')->middleware('role_session:Dinamizador|Administrador');
        Route::get('/consultarGestoresYLineasDeUnNodo/{id}', 'GraficoController@gestoresYLineaDelNodo')->middleware('role_session:Dinamizador|Administrador');
        Route::get('/consultarProyectosFinalizadosPorTipoNodoYFecha/{id}/{fecha_inicio}/{fecha_fin}', 'Graficos\ProyectoController@proyectosFinalizadosPorTipoProyectoNodo_Controller')->middleware('role_session:Dinamizador|Administrador');
    }

);

/**
 * Route group para la generación de excel
 */
Route::group(
    [
        'prefix'     => 'excel',
        'middleware' => ['auth', 'role_session:Gestor|Infocenter|Dinamizador|Administrador|Ingreso|Talento'],
    ],
    function () {
        // Rutas para la generación de excel del módulo de edts
        Route::get('/excelDeUnaEdt/{id}', 'Excel\EdtController@edtsPorId')->name('edt.excel.unica')->middleware('role_session:Gestor|Dinamizador|Administrador');
        // Route::get('/excelEdtsDeUnGestor/{id}', 'Excel\EdtController@edtsDeUnGestor')->name('edt.excel.gestor')->middleware('role_session:Gestor|Dinamizador|Administrador');
        Route::get('/excelEdtsDeUnNodo/{id}', 'Excel\EdtController@edtsDeUnNodo')->name('edt.excel.nodo')->middleware('role_session:Dinamizador|Administrador');
        Route::get('/excelEdtsFinalizadasPorFechaYNodo/{id}/{fecha_inicio}/{fecha_fin}', 'Excel\EdtController@edtPorFechaCierreYNodo')->name('edt.excel.nodo.fecha')->middleware('role_session:Dinamizador|Administrador');
        Route::get('/excelEdtsFinalizadasPorGestorYFecha/{id}/{fecha_inicio}/{fecha_fin}', 'Excel\EdtController@edtPorFechaCierreYGestor')->name('edt.excel.gestor.fecha')->middleware('role_session:Gestor|Dinamizador|Administrador');
        Route::get('/excelEdtsFinalizadasPorLineaNodoYFecha/{idnodo}/{idlinea}/{fecha_inicio}/{fecha_fin}', 'Excel\EdtController@edtPorFechaCierreLineaYNodo')->name('edt.excel.nodo.linea.fecha')->middleware('role_session:Dinamizador|Administrador');
        // Ruta para la generación de excel del módulo de articulaciones
        Route::get('/excelArticulacionDeUnGestor/{id}', 'Excel\ArticulacionController@articulacionesDeUnGestor')->name('articulacion.excel.gestor');
        Route::get('/excelDeUnaArticulacion/{id}', 'Excel\ArticulacionController@articulacionPorId')->name('articulacion.excel.unica');
        Route::get('/excelArticulacionDeUnNodo/{id}', 'Excel\ArticulacionController@articulacionesDeUnNodo')->name('articulacion.excel.nodo')->middleware('role_session:Dinamizador|Administrador');
        Route::get('/excelArticulacionFinalizadasPorFechaYNodo/{id}/{fecha_inicio}/{fecha_fin}', 'Excel\ArticulacionController@excelArticulacionFinalizadasPorFechaYNodo_Controller')->middleware('role_session:Dinamizador|Administrador');
        Route::get('/excelArticulacionFinalizadasPorGestorYFecha/{id}/{fecha_inicio}/{fecha_fin}', 'Excel\ArticulacionController@excelArticulacionFinalizadasPorGestorFecha_Controller')->middleware('role_session:Dinamizador|Administrador');
        Route::get('/excelArticulacionFinalizadasPorFechaNodoYLinea/{id}/{idlinea}/{fecha_inicio}/{fecha_fin}', 'Excel\ArticulacionController@excelArticulacionFinalizadasPorNodoFechaLinea_Controller')->middleware('role_session:Dinamizador|Administrador');
        Route::get('/excelArticulacionFinalizadasPorNodoYAnho/{id}/{anho}', 'Excel\ArticulacionController@excelArticulacionFinalizadasPorNodoAnho_Controller')->middleware('role_session:Dinamizador|Administrador');
        // Rutas para la generacion de excel del módulo de proyectos
        Route::get('/excelProyectosInscritosPorAnho/{id}/{anho}', 'Excel\ProyectoController@proyectosInscritosPorAnhosDeUnNodo')->name('proyecto.excel.nodo.anho')->middleware('role_session:Dinamizador|Administrador');
        Route::get('/excelProyectosInscritosConEmpresasPorAnho/{id}/{anho}', 'Excel\ProyectoController@consultarProyectosInscritosConEmpresasPorAnhoYAnho')->name('proyecto.excel.nodo.anho')->middleware('role_session:Dinamizador|Administrador');
        Route::get('/excelProyectosDelGestorPorAnho/{id}/{anho}', 'Excel\ProyectoController@consultarProyectosDeUnGestorPorAnho')->name('proyecto.excel.gestor.anho')->middleware('role_session:Gestor|Dinamizador|Administrador');
        Route::get('/excelProyectosDelNodoPorAnho/{id}/{anho}', 'Excel\ProyectoController@consultarProyectosDeUnNodoPorAnho')->middleware('role_session:Dinamizador|Administrador');
        Route::get('/excelProyectosFinalizadosPorAnho/{id}/{anho}', 'Excel\ProyectoController@consultarProyectosDeUnNodoFinalizadosPorAnho_Controller')->middleware('role_session:Dinamizador|Administrador');
        // Rutas para la generación de excel del módulo de seguimiento
        Route::get('/excelSeguimientoDeUnNodo/{id}/{fecha_inicio}/{fecha_fin}', 'Excel\SeguimientoController@consultarSeguimientoDelNodo')->middleware('role_session:Dinamizador|Administrador');
        Route::get('/excelSeguimientoDeUnGestor/{id}/{fecha_inicio}/{fecha_fin}', 'Excel\SeguimientoController@consultarSeguimientoDelGestor')->middleware('role_session:Gestor|Dinamizador|Administrador');
        // Rutas para la generación de excel del módulo de indicadores
        Route::get('/export/{idnodo}/{fecha_inicio}/{fecha_fin}', 'Excel\IndicadorController@exportIndicadores2020')->middleware('role_session:Dinamizador|Administrador')->name('indicador.export.excel');
        // Route::get('/export/{idnodo}/{fecha_inicio}/{fecha_fin}', 'Excel\IndicadorController@export')->middleware('role_session:Dinamizador|Administrador')->name('indicador.export.excel');

        //Rutas para la generación de excel del módulo de nodo
        Route::get('/excelnodo', 'Excel\NodoController@exportQueryAllNodo')
            ->middleware('role_session:Administrador')
            ->name('excel.excelnodo');

        Route::get('/exportexcelfornodo/{nodo}', 'Excel\NodoController@exportQueryForNodo')
            ->middleware('role_session:Administrador|Dinamizador')
            ->name('excel.exportexcelfornodo');
    }
);

/**
 * Route group para el nódulo de seguimiento
 */
Route::group(
    [
        'prefix' => 'seguimiento',
        'middleware' => ['auth', 'role_session:Administrador|Dinamizador|Gestor',]
    ],
    function () {
        Route::get('/', 'SeguimientoController@index')->name('seguimiento');
        Route::get('/seguimientoDeUnGestor/{id}/{fecha_inicio}/{fecha_fin}', 'SeguimientoController@seguimientoDelGestor');
        Route::get('/seguimientoDeUnNodo/{id}/{fecha_inicio}/{fecha_fin}', 'SeguimientoController@seguimientoDelNodo')->middleware('role_session:Dinamizador|Administrador');
    }
);

/**
 * Route group para el módulo de indicadores
 */
Route::group(
    [
        'prefix' => 'indicadores',
        'middleware' => ['auth', 'role_session:Administrador|Dinamizador',]
    ],
    function () {
        Route::get('/', 'IndicadorController@index')->name('indicadores');
        // Relacionado a proyectos
        Route::get('/totalProyectosInscritos/{idnodo}/{fecha_inicio}/{fecha_fin}', 'IndicadorController@totalProyectosInscritos');
        Route::get('/totalProyectosEnEjecucion/{id}', 'IndicadorController@totalProyectosEjecucion');
        Route::get('/totalPFFfinalizados/{id}/{fecha_inicio}/{fecha_fin}', 'IndicadorController@totalPFFfinalizados');
        Route::get('/totalInscritosSena/{id}/{fecha_inicio}/{fecha_fin}', 'IndicadorController@totalInscritosSena');
        Route::get('/totalProyectosEnEjecucionSena/{idnodo}', 'IndicadorController@totalProyectosEnEjecucionSena');
        Route::get('/totalPFFSena/{idnodo}/{fecha_inicio}/{fecha_cierre}', 'IndicadorController@totalPFFSena');
        Route::get('/totalCostoPFFFinalizadoSena/{idnodo}/{fecha_inicio}/{fecha_cierre}', 'IndicadorController@totalCostoPFFFinalizadoSena');
        Route::get('/totalInscritosEmpresas/{idnodo}/{fecha_inicio}/{fecha_cierre}', 'IndicadorController@totalInscritosEmpresas');
        Route::get('/totalProyectosEnEjecucionEmpresas/{idnodo}', 'IndicadorController@totalProyectosEnEjecucionEmpresas');
        Route::get('/totalPFFfinalizadosConEmpresas/{idnodo}/{fecha_inicio}/{fecha_cierre}', 'IndicadorController@totalPFFfinalizadosConEmpresas');
        Route::get('/totalCostoPFFFinalizadoEmpresas/{idnodo}/{fecha_inicio}/{fecha_cierre}', 'IndicadorController@totalCostoPFFFinalizadoEmpresas');
        Route::get('/totalTalentosConProyectosEnAsocioConEmpresas/{idnodo}/{fecha_inicio}/{fecha_cierre}', 'IndicadorController@totalTalentosConProyectosEnAsocioConEmpresas');
        Route::get('/totalProyectosInscritosEmprendedoresInvetoresOtro/{idnodo}/{fecha_inicio}/{fecha_cierre}', 'IndicadorController@totalProyectosInscritosEmprendedoresInvetoresOtro');
        Route::get('/totalPFFFinalizadosEmprendedoresInvetoresOtro/{idnodo}/{fecha_inicio}/{fecha_cierre}', 'IndicadorController@totalPFFFinalizadosEmprendedoresInvetoresOtro');
        Route::get('/totalProyectosEnEjecucionEmprendedoresInventoresOtros/{idnodo}', 'IndicadorController@totalProyectosEnEjecucionEmprendedoresInventoresOtros');
        Route::get('/totalCostoPFFFinalizadoEmprendedoresOtros/{idnodo}/{fecha_inicio}/{fecha_cierre}', 'IndicadorController@totalCostoPFFFinalizadoEmprendedoresOtros');
        Route::get('/totalPMVfinalizados/{id}/{fecha_inicio}/{fecha_fin}', 'IndicadorController@totalPMVfinalizados');
        Route::get('/totalPMVSena/{idnodo}/{fecha_inicio}/{fecha_cierre}', 'IndicadorController@totalPMVSena');
        Route::get('/totalCostoPMVFinalizadoSena/{idnodo}/{fecha_inicio}/{fecha_cierre}', 'IndicadorController@totalCostoPMVFinalizadoSena');
        Route::get('/totalPMVfinalizadosConEmpresas/{idnodo}/{fecha_inicio}/{fecha_cierre}', 'IndicadorController@totalPMVfinalizadosConEmpresas');
        Route::get('/totalCostoPMVFinalizadoEmpresas/{idnodo}/{fecha_inicio}/{fecha_cierre}', 'IndicadorController@totalCostoPMVFinalizadoEmpresas');
        Route::get('/totalPMVFinalizadosEmprendedoresInvetoresOtro/{idnodo}/{fecha_inicio}/{fecha_cierre}', 'IndicadorController@totalPMVFinalizadosEmprendedoresInvetoresOtro');
        Route::get('/totalCostoPMVFinalizadoEmprendedoresOtros/{idnodo}/{fecha_inicio}/{fecha_cierre}', 'IndicadorController@totalCostoPMVFinalizadoEmprendedoresOtros');
        Route::get('/totalProyectoConGruposInternos/{idnodo}/{fecha_inicio}/{fecha_cierre}', 'IndicadorController@totalProyectoConGruposInternos');
        Route::get('/totalProyectoConGruposInternosFinalizados/{idnodo}/{fecha_inicio}/{fecha_cierre}', 'IndicadorController@totalProyectoConGruposInternosFinalizados');
        Route::get('/totalProyectoConGruposExternos/{idnodo}/{fecha_inicio}/{fecha_cierre}', 'IndicadorController@totalProyectoConGruposExternos');
        Route::get('/totalProyectoConGruposExternosFinalizados/{idnodo}/{fecha_inicio}/{fecha_cierre}', 'IndicadorController@totalProyectoConGruposExternosFinalizados');
        Route::get('/totalTalentosConApoyoYProyectosAsociados/{idnodo}/{fecha_inicio}/{fecha_cierre}', 'IndicadorController@totalTalentosConApoyoYProyectosAsociados');
        Route::get('/totalTalentosSinApoyoYProyectosAsociados/{idnodo}/{fecha_inicio}/{fecha_cierre}', 'IndicadorController@totalTalentosSinApoyoYProyectosAsociados');
        // Relacionado a articulaciones
        Route::get('/totalAsesoriasIDiEmpresasYEmprendedores/{idnodo}/{fecha_inicio}/{fecha_cierre}', 'IndicadorController@totalAsesoriasIDiEmpresasYEmprendedores');
        Route::get('/totalAsesoriasIDiEmpresasEmprendedoresEnEjecucion/{id}', 'IndicadorController@totalAsesoriasIDiEmpresasEmprendedoresEnEjecucion');
        Route::get('/totalAsesoriasIDiEmpresasEmprendedoresFinalizadas/{id}/{fecha_inicio}/{fecha_cierre}', 'IndicadorController@totalAsesoriasIDiEmpresasEmprendedoresFinalizadas');
        Route::get('/totalArticulacionesEmpresasEmprendedoresPorTipoFinalizadas/{id}/{fecha_inicio}/{fecha_cierre}/{nombre_tipo_articulacion}', 'IndicadorController@totalArticulacionesEmpresasEmprendedoresPorTipoFinalizadas');
        // Relacionado a edts
        Route::get('/totalEdts/{idnodo}/{fecha_inicio}/{fecha_cierre}', 'IndicadorController@totalEdts');
        Route::get('/totalAtendidosEnEdts/{idnodo}/{fecha_inicio}/{fecha_cierre}/{campos}', 'IndicadorController@totalAtendidosEnEdts');
        // Relacionado a talento
        Route::get('/totalTalentosEnProyecto/{idnodo}/{fecha_inicio}/{fecha_cierre}', 'IndicadorController@totalTalentosEnProyecto');
        Route::get('/totalTalentosSenaEnProyecto/{idnodo}/{fecha_inicio}/{fecha_cierre}', 'IndicadorController@totalTalentosSenaEnProyecto');
        Route::get('/totalTalentosMujeresSenaEnProyecto/{idnodo}/{fecha_inicio}/{fecha_cierre}', 'IndicadorController@totalTalentosMujeresSenaEnProyecto');
        Route::get('/totalTalentosEgresadosSenaEnProyecto/{idnodo}/{fecha_inicio}/{fecha_cierre}', 'IndicadorController@totalTalentosEgresadosSenaEnProyecto');
    }
);


/**
 * Route group para el módulo de costos
 */
Route::group(
    [
        'prefix' => 'costos',
        'middleware' => ['auth', 'role_session:Administrador|Dinamizador|Gestor']
    ],
    function () {
        Route::get('/', 'CostoController@index')->name('costos');
        Route::get('/costosDeUnaActividad/{id}', 'CostoController@costosDeUnaActividad');
        Route::get('/costosDeProyectos/{idnodo}/{tipos_proyecto}/{estado_proyecto}/{fecha_inicio}/{fecha_fin}/{type}', 'CostoController@costosDeProyectos')->middleware('role_session:Dinamizador|Administrador');
    }
);


//-------------------Route group para todos los pdfs de la aplicacion
Route::group(
    [
        'prefix'    => 'pdf',
        'namespace' => 'PDF',
    ],

    function () {
        Route::get('/', 'PdfComiteController@printPDF')->name('print');
        Route::get('/usos_proyecto/{id}', 'UsoInfraestructuraController@downloadPDFUsosInfraestructura')->name('pdf.proyecto.usos');
        Route::get('/inicio_proyecto/{id}', 'PdfProyectoController@printFormularioAcuerdoDeInicio')->name('pdf.proyecto.inicio');
        Route::get('/inicio_articulacion/{id}', 'PdfArticulacionController@printFormularioInicio')->name('pdf.articulacion.inicio');
        Route::get('/cierre_articulacion/{id}', 'PdfArticulacionController@printFormularioCierre')->name('pdf.articulacion.cierre');
        Route::get('/cierre/{id}', 'PdfProyectoController@printFormularioCierre')->name('pdf.proyecto.cierre');
        Route::put('/acc/{id}', 'PdfProyectoController@printAcuerdoConfidencialidadCompromiso')->name('pdf.proyecto.acc');
    }

);

//------------------------------ Route group para el módulo de publicacion
Route::group([
    'prefix' => 'publicacion',
    'middleware' => ['auth']
], function () {
    Route::get('/', 'PublicacionController@index')->name('publicacion.index')->middleware('role_session:Desarrollador');
    Route::get('/updateEstado/{id}/{estado}', 'PublicacionController@updateEstado')->name('publicacion.update.estado')->middleware('role_session:Desarrollador');
    Route::get('/create', 'PublicacionController@create')->name('publicacion.create');
    Route::get('/show/{codigo}', 'PublicacionController@show')->name('publicacion.show');
    Route::get('/edit/{codigo}', 'PublicacionController@edit')->name('publicacion.edit')->middleware('role_session:Desarrollador');
    Route::get('/datatablePublicaciones', 'PublicacionController@datatablePublicaciones');
    Route::put('/{id}', 'PublicacionController@update')->name('publicacion.update')->middleware('role_session:Desarrollador');
    Route::post('/store', 'PublicacionController@store')->name('publicacion.store');
});


/*===================================================================
=            rutas para las funcionalidades de las ideas            =
===================================================================*/

Route::get('ideas', 'IdeaController@index')->name('ideas.index');

/*=====  End of rutas para las funcionalidades de las ideas  ======*/

/*=====  End of rutas para las funcionalidades de los usuarios  ======*/

Route::get('/notificaciones', 'NotificationsController@index')
    ->name('notifications.index')
    ->middleware('disablepreventback');
Route::patch('/notificaciones/{notification}', 'NotificationsController@read')
    ->name('notifications.read')
    ->middleware('disablepreventback');
Route::delete('/notificaciones/{notification}', 'NotificationsController@destroy')
    ->name('notifications.destroy')
    ->middleware('disablepreventback');;

/*====================================================================
=            rutas para las funcionalidades de las lineas            =
====================================================================*/


Route::group([
    'middleware' => 'disablepreventback',
], function () {
    Route::get('/lineas/getlineasnodo/{nodo?}', 'LineaController@getAllLineasForNodo')->name('lineas.getAllLineas');
    Route::resource('lineas', 'LineaController', ['except' => ['destroy']])
        ->names([
            'create'  => 'lineas.create',
            'update'  => 'lineas.update',
            'edit'    => 'lineas.edit',
            'destroy' => 'lineas.destroy',
            'show'    => 'lineas.show',
            'index'   => 'lineas.index',
            'store'   => 'lineas.store',
        ]);
});

/*=====  End of rutas para las funcionalidades de las lineas  ======*/

/*====================================================================
=            rutas para las funcionalidades de las sublineas            =
====================================================================*/

Route::resource('sublineas', 'SublineaController', ['except' => ['show']])->middleware('disablepreventback');

/*=====  End of rutas para las funcionalidades de las sublineas  ======*/

/*==========================================================================
=            rutas para las funcionalidades de los laboratorios            =
==========================================================================*/
Route::get('/laboratorio/nodo/{nodo?}', 'LaboratorioController@getLaboratorioPorNodo')->name('laboratorio.nodo')->middleware('disablepreventback');
Route::resource('laboratorio', 'LaboratorioController')->parameters([
    'laboratorio' => 'id',
])->middleware('disablepreventback');

/*=====  End of rutas para las funcionalidades de los laboratorios  ======*/

/*==============================================================================
=            rutas para las funcionalidades de la configuracion app            =
==============================================================================*/

// Route::group([
//     'prefix'     => 'configuracion',
//     'middleware' => ['auth', 'role_session:Administrador'],
// ], function () {
//     Route::get('/', function () {
//         return view('configuracion.index');
//     })->name('configuracion.index');
// }
// );

/*=====  End of rutas para las funcionalidades de la configuracion app  ======*/

/**
 *
 * Route group para el módulo de edt (Eventos de Divulgación Tecnológica)
 */
// Route::group(
//     [
//         'middleware' => ['auth', 'role_session:Gestor|Dinamizador|Administrador', 'disablepreventback'],
//     ],
//     function () {
//         Route::get('intervencion/datatableIntervencionEmpresaDelGestor/{id}/{anho}', 'IntervencionEmpresaController@datatableIntervencionesEmpresaPorGestor')->name('intervencion.datatable.gestor');
//         Route::get('intervencion/eliminarArticulacion/{id}', 'IntervencionEmpresaController@eliminarIntervencionEmpresa')->name('intervencion.delete')->middleware('role_session:Dinamizador');
//         Route::put('intervencion/updateEntregables/{id}', 'IntervencionEmpresaController@updateEntregables')->name('intervencion.update.entregables')->middleware('role_session:Gestor|Dinamizador');
//         Route::get('intervencion/{id}/entregables', 'IntervencionEmpresaController@entregables')->name('intervencion.entregables');
//         Route::get('intervencion/ajaxDetallesDeUnaArticulacion/{id}', 'IntervencionEmpresaController@detallesDeUnaIntervencion')->name('intervencion.detalle');
//         Route::get('intervencion/datatableIntervencionesAEmpresasDelGestor/{id}/{anho}', 'IntervencionEmpresaController@datatableIntervencionesAempresasPorGestor')->name('intervencion.datatable');
//         Route::get('intervencion/datatableIntervencionesDelNodo/{id}/{anho}', 'IntervencionEmpresaController@datatableIntervencionesPorNodo')->name('intervencion.datatable.nodo');
//         Route::get('intervencion/archivosDeUnaArticulacion/{id}', 'ArchivoController@datatableArchivosDeUnaArticulacion')->name('articulacion.files');
//         Route::resource('intervencion', 'IntervencionEmpresaController', ['except' => ['show', 'destroy']])->parameters([
//             'intervencion' => 'id',
//         ])->names([
//             'create'  => 'intervencion.create',
//             'update'  => 'intervencion.update',
//             'edit'    => 'intervencion.edit',
//             'destroy' => 'intervencion.destroy',
//             'show'    => 'intervencion.show',
//             'index'   => 'intervencion.index',
//             'store'   => 'intervencion.store',
//         ]);
//     }
// );


Route::get('creditos', function () {
    return view('configuracion.creditos');
})->name('creditos');
