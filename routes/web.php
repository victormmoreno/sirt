<?php

use App\Models\UsoInfraestructura;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('spa');
})->name('/');

DB::listen(function ($query) {
    // echo "<pre>{$query->sql}</pre>";
    // echo "<pre>{$query->time}</pre>";
});

/*===========================================================
=            ruta para revisar funcionaliddes de prueba          =
===========================================================*/

Route::get('email', function () {
    // return new App\Mail\Comite\SendEmailIdeaComite(App\Models\Idea::first());
    // return new App\Mail\IdeaEnviadaEmprendedor(App\Models\Idea::first());
    // return new App\Mail\User\PleaseActivateYourAccount(App\User::first());
    // return new App\Mail\User\SendNotificationPassoword(App\User::first(), 'asdafasafasdf');
});

Route::get('excel', 'User\AdminController@exportAdminUser');

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

Route::resource('nodo', 'Nodo\NodoController')->middleware('disablepreventback');

/*=====  End of rutas para las funcionalidades de los nodos  ======*/

/*======================================================================
=            rutas para las funcionalidades de los usuarios            =
======================================================================*/

Route::group([
    'prefix'     => 'usuario',
    'namespace'  => 'User',
    'middleware' => 'disablepreventback',
],
    function () {

        Route::get('administrador', 'AdminController@index')->name('usuario.administrador.index');
        Route::get('administrador/pdf', 'AdminController@downloadPDFAdministrator')->name('usuario.administrador.downloadpdf');

        Route::get('dinamizador/getDinamizador/{id}', 'DinamizadorController@getDinanizador')->name('usuario.dinamizador.getDinanizador');
        Route::get('dinamizador', 'DinamizadorController@index')->name('usuario.dinamizador.index');

    
        Route::get('getlineanodo/{nodo}', 'GestorController@getLineaPorNodo');
        Route::get('gestor/getGestor/{id}', 'GestorController@getGestor')->name('usuario.gestor.getGestor');
        Route::get('gestor/getgestor', 'GestorController@getAllGestoresOfNodo')->name('usuario.gestor.getGestorofnodo');
        Route::get('gestor', 'GestorController@index')->name('usuario.gestor.index');

        Route::get('infocenter/getinfocenter/{id}', 'InfocenterController@getInfocenterForNodo')->name('usuario.infoncenter.getinfocenter');
        Route::get('infocenter/getinfocenter', 'InfocenterController@getAllInfocentersOfNodo')->name('usuario.infocenter.getinfocenternodo');
        Route::get('infocenter', 'InfocenterController@index')->name('usuario.infocenter.index');

        Route::get('ingreso/getingreso/{id}', 'IngresoController@getIngresoForNodo')->name('usuario.ingreso.getingreso');
        Route::get('ingreso/getingreso', 'IngresoController@getAllIngresoOfNodo')->name('usuario.ingreso.getingresonodo');
        Route::get('ingreso', 'IngresoController@index')->name('usuario.ingreso.index');

        Route::get('/talento/getTalentosDeTecnoparque', [
            'uses' => 'TalentoController@datatableTalentosDeTecnoparque',
            'as'   => 'talento.tecnoparque',
        ]);

        Route::get('/talento/consultarTalentoPorId/{id}', [
            'uses' => 'TalentoController@consultarUnTalentoPorId',
            'as'   => 'talento.tecnoparque.byid',
        ]);
        Route::get('talento/gettalentodatatable', 'TalentoController@getUsersTalentosForDatatables')->name('usuario.talento.gettalentodatatable');
        Route::get('talento', 'TalentoController@index')->name('usuario.talento.index');

        Route::get('usuarios/allusuarios', 'UserController@getAllUsersInDatatable')->name('usuario.allusers');

        Route::get('/', [
            'uses' => 'UserController@index',
            'as'   => 'usuario.index',
        ]);

        Route::get('getciudad/{departamento?}', 'UserController@getCiudad');

        Route::get('/talento/getEdadTalento/{id}', 'TalentoController@getEdad');

        Route::resource('usuarios', 'UserController', ['as' => 'usuario', 'except' => 'index'])->names([
            'create'  => 'usuario.usuarios.create',
            'update'  => 'usuario.usuarios.update',
            'edit'    => 'usuario.usuarios.edit',
            'destroy' => 'usuario.usuarios.destroy',
            'show'    => 'usuario.usuarios.show',

        ])->parameters([
            'usuarios' => 'id',
        ]);

    }
);



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
Route::group([
    'prefix' => 'idea',
],
    function () {
        Route::get('/', 'IdeaController@ideas')->name('idea.ideas');
        Route::get('/egi', 'IdeaController@empresasGI')->name('idea.egi');
        Route::get('/{idea}', 'IdeaController@details')->name('idea.details');
        Route::get('/consultarIdeasEmprendedoresPorNodo/{id}', 'IdeaController@dataTableIdeasEmprendedoresPorNodo')->name('idea.emprendedores');
        Route::get('/consultarIdeasEmpresasGIPorNodo/{id}', 'IdeaController@dataTableIdeasEmpresasGIPorNodo')->name('idea.empresasgi');
        Route::get('/consultarIdeasTodosPorNodo/{id}', 'IdeaController@dataTableIdeasTodosPorNodo')->name('idea.todas');
        Route::get('/{id}/edit', 'IdeaController@edit')->name('idea.edit')->middleware(['auth', 'role_session:Infocenter']);
        Route::get('detallesIdea/{id}', 'IdeaController@detallesIdeas')->name('idea.det');
        Route::get('/updateEstadoIdea/{id}/{estado}', 'IdeaController@updateEstadoIdea')->name('idea.update.estado')->middleware(['auth', 'role_session:Infocenter']);
        Route::put('/{idea}', 'IdeaController@update')->name('idea.update')->middleware(['auth', 'role_session:Infocenter']);
        Route::post('/', 'IdeaController@store')->name('idea.store');
        Route::post('/egi', 'IdeaController@storeEGI')->name('idea.storeegi')->middleware(['auth', 'role_session:Infocenter']);
        Route::post('/addIdeaDeProyectoAlComite', 'IdeaController@addIdeaDeProyectoCreate');
    }
);

//-------------------Route group para el módulo de Entrenamientos
Route::group([
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
        Route::put('/{id}', 'EntrenamientoController@update')->name('entrenamientos.update');
        Route::put('/updateEvidencias/{id}', 'EntrenamientoController@updateEvidencias')->name('entrenamientos.update.evidencias')->middleware('role_session:Infocenter');
        Route::post('/', 'EntrenamientoController@store')->name('entrenamientos.store')->middleware('role_session:Infocenter');
        Route::post('/addidea', 'EntrenamientoController@add_idea')->middleware('role_session:Infocenter');
        Route::post('/store/{id}/files', 'ArchivoController@uploadFileEntrenamiento')->name('entrenamientos.files.store')->middleware('role_session:Infocenter');
        Route::delete('/file/{idFile}', 'ArchivoController@destroyFileEntrenamiento')->name('entrenamientos.files.destroy')->middleware('role_session:Infocenter');
    }
);

//-------------------Route group para el módulo de Comité
Route::group([
    'prefix'     => 'csibt',
    'middleware' => ['auth', 'role_session:Administrador|Dinamizador|Gestor|Infocenter'],
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

//-------------------Route group para el módulo de Comité
Route::group([
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
Route::group([
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
Route::group([
    'prefix'     => 'articulacion',
    'middleware' => ['auth', 'role_session:Administrador|Dinamizador|Gestor'],
],
    function () {

        //rutas para consultar articualciones por gestor
        Route::get('/gestor/{id}/{tipoarticulacion}', 'ArticulacionController@ArticulacionForGestor')->name('articulacion.gestor');
        Route::get('/', 'ArticulacionController@index')->name('articulacion');
        Route::get('/create', 'ArticulacionController@create')->name('articulacion.create')->middleware('role_session:Gestor');
        Route::get('/datatableArticulacionesDelGestor/{id}', 'ArticulacionController@datatableArticulacionesPorGestor')->name('articulacion.datatable');
        Route::get('/datatableArticulacionesDelNodo/{id}', 'ArticulacionController@datatableArticulacionesPorNodo')->name('articulacion.datatable.nodo')->middleware('role_session:Dinamizador|Administrador');
        Route::get('/{id}/edit', 'ArticulacionController@edit')->name('articulacion.edit')->middleware('role_session:Gestor|Dinamizador');
        Route::get('/ajaxDetallesDeUnArticulacion/{id}', 'ArticulacionController@detallesDeUnArticulacion')->name('articulacion.detalle');
        Route::get('/ajaxDetallesDeLosEntregablesDeUnaArticulacion/{id}', 'ArticulacionController@detallesDeLosEntregablesDeUnaArticulacion')->name('articulacion.detalle.entregables');
        Route::get('/consultarTiposArticulacion/{id}', 'ArticulacionController@consultarTipoArticulacion')->name('articulacion.tiposarticulacion');
        Route::get('/{id}/entregables', 'ArticulacionController@entregables')->name('articulacion.entregables');
        Route::get('/archivosDeUnaArticulacion/{id}', 'ArchivoController@datatableArchivosDeUnaArticulacion')->name('articulacion.files');
        Route::get('/consultarEntidadDeLaArticulacion/{id}', 'ArticulacionController@consultarEntidadDeLaArticulacion')->name('articulacion.detalle.entidad');
        Route::get('/downloadFile/{id}', 'ArchivoController@downloadFileArticulacion')->name('articulacion.files.download');
        Route::put('/{id}', 'ArticulacionController@update')->name('articulacion.update')->middleware('role_session:Gestor|Dinamizador');
        Route::put('/updateEntregables/{id}', 'ArticulacionController@updateEntregables')->name('articulacion.update.entregables')->middleware('role_session:Gestor|Dinamizador');
        Route::post('/', 'ArticulacionController@store')->name('articulacion.store')->middleware('role_session:Gestor');
        Route::post('/store/{id}/files', 'ArchivoController@uploadFileArticulacion')->name('articulacion.files.upload')->middleware('role_session:Gestor');

    }
);

//Route group para el módulo de proyectos
Route::group(
    [
        'prefix'     => 'proyecto',
        'middleware' => ['auth', 'role_session:Administrador|Dinamizador|Gestor|Talento'],
    ],
    function () {

        /*=====  rutas para consultar los proyectos por gestor ======*/
        Route::get('/gestor/{id}', 'ProyectoController@projectsForGestor')->name('proyecto');
        Route::get('/', 'ProyectoController@index')->name('proyecto');
        Route::get('/create', 'ProyectoController@create')->name('proyecto.create')->middleware('role_session:Gestor');
        Route::get('/pendientes', 'ProyectoController@aprobaciones')->name('proyecto.pendientes')->middleware('role_session:Talento|Gestor|Dinamizador');
        Route::get('/aprobacion/{id}', 'ProyectoController@aprobacion')->name('proyecto.aprobacion')->middleware('role_session:Dinamizador|Talento|Gestor');
        Route::get('/datatableEntidad/{id}', 'ProyectoController@datatableEntidadesTecnoparque')->name('proyecto.datatable.entidades');
        Route::get('/datatableEmpresasTecnoparque', 'ProyectoController@datatableEmpresasTecnoparque')->name('proyecto.datatable.empresas');
        Route::get('/datatableGruposInvestigacionTecnoparque/{tipo}', 'ProyectoController@datatableGruposInvestigacionTecnoparque')->name('proyecto.datatable.empresas');
        Route::get('/datatableTecnoacademiasTecnoparque', 'ProyectoController@datatableTecnoacademiasTecnoparque')->name('proyecto.datatable.tecnoacademias');
        Route::get('/datatableNodosTecnoparque', 'ProyectoController@datatableNodosTecnoparque')->name('proyecto.datatable.nodos');
        Route::get('/datatableCentroFormacionTecnoparque', 'ProyectoController@datatableCentroFormacionTecnoparque')->name('proyecto.datatable.centros');
        Route::get('/datatableIdeasConEmprendedores', 'ProyectoController@datatableIdeasConEmprendedores')->name('proyecto.datatable.ideas.emprendedores');
        Route::get('/datatableIdeasConEmpresasGrupo', 'ProyectoController@datatableIdeasConEmpresasGrupo')->name('proyecto.datatable.ideas.empresasgrupos');
        Route::get('/datatableProyectosDelGestorPorAnho/{idgestor}/{anho}', 'ProyectoController@datatableProyectosDelGestorPorAnho')->name('proyecto.datatable.proyectos.gestor.anho');
        Route::get('/datatableProyectosDelNodoPorAnho/{idnodo}/{anho}', 'ProyectoController@datatableProyectosDelNodoPorAnho')->name('proyecto.datatable.proyectos.nodo.anho');
        Route::get('/datatableProyectosPendienteDeAprobacion', 'ProyectoController@datatableProyectosPendientes')->name('proyecto.datatable.proyectos.pendiente')->middleware('role_session:Dinamizador|Gestor|Talento');
        Route::get('/{id}/edit', 'ProyectoController@edit')->name('proyecto.edit')->middleware('role_session:Gestor|Dinamizador');
        Route::get('/{id}/entregables', 'ProyectoController@entregables')->name('proyecto.entregables');
        Route::get('/ajaxConsultarTalentosDeUnProyecto/{id}', 'ProyectoController@consultarTalentosDeUnProyecto')->name('proyecto.talentos');
        Route::get('/ajaxVerDetallesDeUnProyecto/{id}', 'ProyectoController@consultarDetallesDeUnProyecto')->name('proyecto.detalles');
        Route::get('/downloadFile/{id}', 'ArchivoController@downloadFileProyecto')->name('proyecto.files.download');
        Route::get('/archivosDeUnProyecto/{id}', 'ArchivoController@datatableArchivosDeUnProyecto')->name('proyecto.files');
        Route::get('/ajaxDetallesDeLosEntregablesDeUnProyecto/{id}', 'ProyectoController@detallesDeLosEntregablesDeUnProyecto')->name('proyecto.detalle.entregables');
        Route::put('/{id}', 'ProyectoController@update')->name('proyecto.update')->middleware('role_session:Gestor|Dinamizador');
        Route::put('/updateEntregables/{id}', 'ProyectoController@updateEntregables')->name('proyecto.update.entregables')->middleware('role_session:Gestor|Dinamizador');
        Route::put('/updateAprobacion/{id}', 'ProyectoController@updateAprobacion')->name('proyecto.update.aprobacion')->middleware('role_session:Gestor|Dinamizador|Talento');
        Route::post('/', 'ProyectoController@store')->name('proyecto.store')->middleware('role_session:Gestor');
        Route::post('/store/{id}/files', 'ArchivoController@uploadFileProyecto')->name('proyecto.files.upload')->middleware('role_session:Gestor');
        Route::delete('/file/{idFile}', 'ArchivoController@destroyFileProyecto')->name('proyecto.files.destroy')->middleware('role_session:Gestor');
    }
);

/**
 * Route group para el módulo de edt (Eventos de Divulgación Tecnológica)
 */
Route::group([
    'prefix'     => 'edt',
    'middleware' => ['auth', 'role_session:Gestor|Dinamizador|Administrador'],
],
    function () {

        //
        Route::get('/', 'EdtController@index')->name('edt');
        Route::get('/create', 'EdtController@create')->name('edt.create')->middleware('role_session:Gestor');
        Route::get('/{id}/edit', 'EdtController@edit')->name('edt.edit')->middleware('role_session:Gestor|Dinamizador');
        Route::get('/{id}/entregables', 'EdtController@entregables')->name('edt.entregables');
        Route::get('/consultarEdtsDeUnGestor/{id}', 'EdtController@consultarEdtsDeUnGestor')->name('edt.gestor');
        Route::get('/consultarEdtsDeUnNodo/{id}', 'EdtController@consultarEdtsDeUnNodo')->name('edt.nodo')->middleware('role_session:Dinamizador|Administrador');
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
Route::group([
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
Route::group([
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
Route::group([
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
Route::group([
    'prefix'     => 'grafico',
    'middleware' => ['auth', 'role_session:Gestor|Infocenter|Dinamizador|Administrador|Ingreso'],
],
    function () {
        Route::get('/', 'GraficoController@index')->name('grafico');
        Route::get('/articulaciones', 'GraficoController@articulacionesGraficos')->name('grafico.articulacion')->middleware('role_session:Gestor|Dinamizador|Administrador');
        Route::get('/consultarArticulacionesPorNodo/{id}/{fecha_inicio}/{fecha_fin}', 'Graficos\ArticulacionController@articulacionesNodoGrafico')->name('grafico.nodo.articulacion')->middleware('role_session:Dinamizador|Administrador');
        Route::get('/consultarArticulacionesPorGestorYFecha/{id}/{fecha_inicio}/{fecha_fin}', 'Graficos\ArticulacionController@articulacionesGestorGrafico')->name('grafico.gestor.articulacion')->middleware('role_session:Dinamizador|Administrador|Gestor');
        Route::get('/consultarCantidadDeArticulacionesPorTipoDeUnaLineaTecnologicaYFecha/{idnodo}/{id}/{fecha_inicio}/{fecha_fin}', 'Graficos\ArticulacionController@articulacionesLineaTecnologicaYFechaGrafico')->name('grafico.linea.articulacion')->middleware('role_session:Dinamizador|Administrador');
        Route::get('/consultarArticulacionesPorNodoYAnho/{id}/{anho}', 'Graficos\ArticulacionController@articulacionesPorNodoYAnho_Controller')->name('grafico.nodo.anho.articulacion')->middleware('role_session:Dinamizador|Administrador');
        Route::get('/edts', 'GraficoController@edtsGraficos')->name('grafico.edt')->middleware('role_session:Gestor|Dinamizador|Administrador');
        Route::get('/consultarEdtsPorNodoGestorYFecha/{id}/{fecha_inicio}/{fecha_fin}', 'Graficos\EdtController@edtsNodoGrafico')->name('grafico.edt.nodo')->middleware('role_session:Dinamizador|Administrador');
        Route::get('/consultarEdtsPorGestorYFecha/{id}/{idnodo}/{fecha_inicio}/{fecha_fin}', 'Graficos\EdtController@edtsGestorGrafico')->name('grafico.edt.gestor')->middleware('role_session:Dinamizador|Administrador|Gestor');
        Route::get('/consultarEdtsPorLineaYFecha/{id}/{idnodo}/{fecha_inicio}/{fecha_fin}', 'Graficos\EdtController@edtsLineaGrafico')->name('grafico.edt.linea')->middleware('role_session:Dinamizador|Administrador|Gestor');
        Route::get('/consultarEdtsPorNodoYAnho/{id}/{anho}', 'Graficos\EdtController@edtsPorNodoAnhoGrafico_Controller')->name('grafico.edt.nodo.anho')->middleware('role_session:Dinamizador|Administrador');
        Route::get('/proyectos', 'GraficoController@proyectosGraficos')->name('grafico.proyectos')->middleware('role_session:Gestor|Dinamizador|Administrador');
        Route::get('/consultarProyectosInscritosPorAnho/{id}/{anho}', 'Graficos\ProyectoController@proyectosPorFechaInicioNodoYAnhoGrafico_Controller')->name('grafico.proyecto.nodo.anho')->middleware('role_session:Dinamizador|Administrador');
        Route::get('/consultarProyectosInscritosConEmpresasPorAnho/{id}/{anho}', 'Graficos\ProyectoController@proyectosInscritosConEmpresasPorMesDeUnNodo_Controller')->name('grafico.proyecto.empresas.nodo.anho')->middleware('role_session:Dinamizador|Administrador');
        Route::get('/consultarGestoresYLineasDeUnNodo/{id}', 'GraficoController@gestoresYLineaDelNodo')->middleware('role_session:Dinamizador|Administrador');

    }
);

/**
 * Route group para la generación de excel
 */
Route::group([
    'prefix'     => 'excel',
    'middleware' => ['auth', 'role_session:Gestor|Infocenter|Dinamizador|Administrador|Ingreso|Talento'],
],
    function () {
        // Rutas para la generación de excel del módulo de edts
        Route::get('/excelDeUnaEdt/{id}', 'Excel\EdtController@edtsPorId')->name('edt.excel.unica')->middleware('role_session:Gestor|Dinamizador|Administrador');
        Route::get('/excelEdtsDeUnGestor/{id}', 'Excel\EdtController@edtsDeUnGestor')->name('edt.excel.gestor')->middleware('role_session:Gestor|Dinamizador|Administrador');
        Route::get('/excelEdtsDeUnNodo/{id}', 'Excel\EdtController@edtsDeUnNodo')->name('edt.excel.nodo')->middleware('role_session:Dinamizador|Administrador');
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
    }
);

//-------------------Route group para todos los pdfs de la aplicacion
Route::group([
    'prefix'    => 'pdf',
    'namespace' => 'PDF',
],
    function () {
        Route::get('/', 'PdfComiteController@printPDF')->name('print');
        Route::get('/acc/{id}', 'PdfProyectoController@printAcuerdoConfidencialidadCompromiso')->name('pdf.proyecto.acc');
    }
);

/*===================================================================
=            rutas para las funcionalidades de las ideas            =
===================================================================*/

Route::get('ideas', 'IdeaController@index')->name('ideas.index');

/*=====  End of rutas para las funcionalidades de las ideas  ======*/

/*=====  End of rutas para las funcionalidades de los usuarios  ======*/

Route::get('/notificaciones', 'NotificationsController@index')->name('notifications.index');
Route::patch('/notificaciones/{notification}', 'NotificationsController@read')->name('notifications.read');
Route::delete('/notificaciones/{notification}', 'NotificationsController@destroy')->name('notifications.destroy');

/*====================================================================
=            rutas para las funcionalidades de las lineas            =
====================================================================*/

Route::get('/lineas/getlineasnodo/{nodo?}', 'LineaController@getAllLineasForNodo')->name('lineas.getAllLineas');
Route::resource('lineas', 'LineaController', ['except' => ['destroy']]);

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

Route::group([
    'prefix'     => 'configuracion',
    'middleware' => ['auth', 'role_session:Administrador'],
], function () {
    Route::get('/', function () {
        return view('configuracion.index');
    })->name('configuracion.index');
}
);

/*=====  End of rutas para las funcionalidades de la configuracion app  ======*/

/*================================================================
=            rutas para la documentación del proyecto            =
================================================================*/

Route::group([
    'prefix'     => 'documentacion',
    'namespace'  => 'Docs',
    'middleware' => 'auth',
], function () {
    // Route::get('/', function () {
    //     return view('configuracion.index');
    // })->name('configuracion.index');
});

/*=====  End of rutas para la documentación del proyecto  ======*/
