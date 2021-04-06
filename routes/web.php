<?php

use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return view('spa');
})->name('/');


Route::get('politica-de-confidencialidad', function () {

    return view('seguridad.terminos');
})->name('terminos');

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('usuario/confirm/{documento}', 'Auth\RegisterController@showConfirmContratorInformationForm')->name('user.contractor.confirm.request');
Route::put('usuario/confirm/{documento}', 'Auth\RegisterController@confirmContratorInformation')->name('user.contractor.confirm');
Route::get('registro', 'Auth\RegisterController@showRegistrationForm')->name('registro');
Route::post('registro', 'Auth\RegisterController@register')->name('register.request');


// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

// Email Verification Routes...
//Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
//Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');
//Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');


//verificar usuario no registrado
Route::post('user/verify', 'Auth\UnregisteredUserVerificationController@verificationUser')->name('user.verify');

//Change Email Routes...
Route::get('email/reset', 'Auth\ChangeEmailController@showEmailChangeRequestForm')->name('email.request');
Route::post('email/send', 'Auth\ChangeEmailController@sendEmailChange')->name('email.send');

// DB::listen(function ($query) {
// echo "<pre>{$query->sql}</pre>";
// echo "<pre>{$query->time}</pre>";
// });

/*===========================================================
=            ruta para revisar funcionaliddes de prueba          =
===========================================================*/

// Route::get('email', function () {
// return new App\Mail\Comite\SendEmailIdeaComite(App\Models\Idea::first());

// });

/*=====  End of ruta para revisafuncionaliddes de prueba  ======*/


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
// Route::get('activate/{token}', 'ActivationTokenController@activate')->name('activation');
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
Route::get('usuario/getciudad/{departamento?}', 'User\UserController@getCiudad');
Route::get('usuario/export', 'User\UserController@export')->name('usuario.export');
Route::get('usuario/export-talentos', 'User\UserController@exportMyTalentos')->name('usuario.export.talentos');
Route::group(
    [
        'prefix'     => 'usuario',
        'namespace'  => 'User',
        'middleware' => 'disablepreventback',
    ],
    function () {


        Route::get('/talento/getTalentosDeTecnoparque', [
            'uses' => 'TalentoController@datatableTalentosDeTecnoparque',
            'as'   => 'talento.tecnoparque',
        ]);

        Route::get('/talento/consultarTalentoPorId/{id}', [
            'uses' => 'TalentoController@consultarUnTalentoPorId',
            'as'   => 'talento.tecnoparque.byid',
        ]);

        Route::get('consultarUserPorId/{id}', 'UserController@findUserById');
        Route::get('/mistalentos', [
            'uses' => 'UserController@myTalentos',
            'as'   => 'usuario.mytalentos',
        ]);
        Route::get('/', [
            'uses' => 'UserController@index',
            'as'   => 'usuario.index',
        ]);
        Route::put('/updateacceso/{documento}', 'UserController@updateAcceso')->name('usuario.usuarios.updateacceso')->middleware('disablepreventback');
        Route::get('/talento/getEdadTalento/{id}', 'TalentoController@getEdad');

        
        Route::get('/usuarios/{id}', 'UserController@edit')->name('usuario.usuarios.edit')->where('documento', '[0-9]+');;

        Route::get('/usuarios/crear/{documento?}', 'UserController@create')->name('usuario.usuarios.create')->where('documento', '[0-9]+');

        Route::get('/usuarios/gestores/nodo/{id}', [
            'uses' => 'UserController@gestoresByNodo',
            'as'   => 'usuario.gestores.nodo',
        ]);

        Route::post('/usuarios/consultarusuario', [
            'uses' => 'UserController@querySearchUser',
            'as'   => 'usuario.buscarusuario',
        ])->where('documento', '[0-9]+');

        
        Route::get('/usuarios', 'UserController@userSearch')->name('usuario.search');

        Route::get('/usuarios/acceso/{documento}', 'UserController@acceso')->name('usuario.usuarios.acceso')->where('documento', '[0-9]+');
        Route::resource('usuarios', 'UserController', ['as' => 'usuario', 'except' => 'index', 'create', 'store'])->names([
            'update'  => 'usuario.usuarios.update',
            'edit'    => 'usuario.usuarios.edit',
            'destroy' => 'usuario.usuarios.destroy',
            'show'    => 'usuario.usuarios.show',

        ])->parameters([
            'usuarios' => 'id',
        ]);
    }
);

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
Route::get('/equipos/export', 'EquipoController@export')->name('equipo.export');
Route::get('/equipos/getequiposporlinea/{nodo}/{lineatecnologica}', 'EquipoController@getEquiposPorLinea')
    ->name('equipo.getequiposporlinea');

Route::get('/equipos/cambiar-estado/{id}/', 'EquipoController@changeState')
    ->name('equipo.cambiar-estado');
Route::resource('equipos', 'EquipoController', [
    'as' => 'equipos',
])->names([
    'index'   => 'equipo.index',
    'create'  => 'equipo.create',
    'store'   => 'equipo.store',
    'show'    => 'equipo.show',
    'edit'    => 'equipo.edit',
    'update'  => 'equipo.update',
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

Route::get('usoinfraestructura/export', 'UsoInfraestructura\UsoInfraestructuraController@export')->name('usoinfraestructura.export');

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


    Route::get('usoinfraestructura/talentosporproyecto/{id}', 'UsoInfraestructuraController@talentosPorProyecto')->name('usoinfraestructura.talentosporproyecto');

    Route::get('usoinfraestructura/articulacionesforuser', 'UsoInfraestructuraController@articulacionesForUser')
        ->name('usoinfraestructura.articulacionesforuser');


    Route::get('usoinfraestructura/talentosporarticulacion/{id}', 'UsoInfraestructuraController@talentosPorArticulacion')
        ->name('usoinfraestructura.talentosporarticulacion');

    Route::get('usoinfraestructura/edtforuser/{id}', 'UsoInfraestructuraController@edtForUser')
        ->name('usoinfraestructura.edtforuser');

    Route::get('usoinfraestructura/edtsforuser', 'UsoInfraestructuraController@edtsForUser')
        ->name('usoinfraestructura.edtsforuser');


    Route::get('usoinfraestructura/projectsforuser', 'UsoInfraestructuraController@projectsForUser')
        ->name('usoinfraestructura.projectsforuser');
    Route::get('usoinfraestructura/projectsforuser/{id}', 'UsoInfraestructuraController@projectsByUser')
        ->name('usoinfraestructura.projectsforuser.projects');

    Route::get('usoinfraestructura/actividades/{anio}', 'UsoInfraestructuraController@activitiesByAnio')
        ->name('usoinfraestructura.actividadesanio');

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
Route::get('perfil/actividades', 'User\ProfileController@activities')->name('perfil.actividades')->middleware('disablepreventback');
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
Route::get('/registrar-idea', 'IdeaController@create')->name('idea.create')->middleware(['auth', 'role_session:Talento']);
Route::group(
    [
        'prefix' => 'idea',
    ],
    function () {
        Route::get('/', 'IdeaController@index')->name('idea.index');
        Route::get('/datatable_filtros', 'IdeaController@datatableFiltros')->name('idea.datatable.filtros')->middleware('role_session:Articulador|Infocenter|Dinamizador|Administrador|Gestir');
        Route::get('/export', 'IdeaController@export')->name('idea.export');
        Route::get('/datatableIdeasDeTalentos', 'IdeaController@datatableIdeasTalento')->name('idea.datatable.talento')->middleware('role_session:Talento');
        // Route::get('/datatableIdeasEnviadasDeTalentos', 'IdeaController@datatableIdeasTalento')->name('idea.datatable.talento')->middleware('role_session:Talento');
        Route::get('/{id}/editar', 'IdeaController@edit')->name('idea.edit')->middleware(['auth', 'role_session:Talento']);
        Route::get('/detallesIdea/{id}', 'IdeaController@detallesIdeas')->name('idea.det');
        Route::get('/modalIdeas/{id}', 'IdeaController@abrirModalIdeas')->name('idea.modal');
        Route::get('/{id}/detalle', 'IdeaController@detalle')->name('idea.detalle');
        Route::get('/updateEstadoIdea/{id}/{estado}', 'IdeaController@updateEstadoIdea')->name('idea.update.estado')->middleware(['auth', 'role_session:Infocenter']);
        Route::get('/aceptar_postulacion/{idea}', 'IdeaController@aceptarPostulacionIdea')->name('idea.aceptar.postulacion')->middleware('role_session:Articulador');
        Route::put('/rechazar_postulacion/{idea}', 'IdeaController@rechazarPostulacionIdea')->name('idea.rechazar.postulacion')->middleware('role_session:Articulador');
        Route::put('/enviar_nodo/{id}', 'IdeaController@enviarIdeaAlNodo')->name('idea.enviar')->middleware('role_session:Talento');
        Route::put('/{idea}', 'IdeaController@update')->name('idea.update')->middleware(['auth', 'role_session:Talento']);
        Route::post('/', 'IdeaController@store')->name('idea.store')->middleware(['auth', 'role_session:Talento']);
    }
);

//-------------------Route group para el módulo de Entrenamientos
Route::group(
    [
        'prefix'     => 'entrenamientos',
        'middleware' => ['auth', 'role_session:Infocenter|Administrador|Dinamizador|Gestor|Articulador'],
    ],
    function () {
        Route::get('/', 'EntrenamientoController@index')->name('entrenamientos');
        Route::get('/consultarEntrenamientosPorNodo', 'EntrenamientoController@datatableEntrenamientosPorNodo');
        Route::get('/create', 'EntrenamientoController@create')->name('entrenamientos.create')->middleware('role_session:Articulador');
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
        Route::post('/', 'EntrenamientoController@store')->name('entrenamientos.store')->middleware('role_session:Articulador');
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
        Route::get('/detalle/{id}', 'ComiteController@detalle')->name('csibt.detalle')->middleware('role_session:Gestor|Dinamizador|Administrador|Infocenter');
        Route::get('/realizar/{id}', 'ComiteController@realizar')->name('csibt.realizar')->middleware('role_session:Infocenter');
        Route::get('/asignar/{id}', 'ComiteController@asignar')->name('csibt.asignar')->middleware('role_session:Dinamizador');
        Route::get('/notificar_agendamiento/{id}/{idea}/{rol}', 'ComiteController@notificar_agendamientoController')->name('csibt.notificar.agendamiento')->middleware('role_session:Infocenter');
        Route::get('/notificar_realizado/{id}', 'ComiteController@notificar_realizadoController')->name('csibt.notificar.realizado')->middleware('role_session:Infocenter');
        Route::get('/notificar_resultado/{id}/{idComite}', 'ComiteController@notificar_resultadoController')->name('csibt.notificar.resultados')->middleware('role_session:Infocenter|Dinamizador');
        Route::get('/{id}/edit', 'ComiteController@edit')->name('csibt.edit')->middleware('role_session:Infocenter');
        Route::get('/cambiar_asignacion/{idea}/{comite}', 'ComiteController@cambiar_idea_gestor')->name('comite.cambiar.asignacion')->middleware('role_session:Dinamizador');
        Route::get('/{id}', 'ComiteController@show')->name('csibt.show');
        Route::get('/{id}/evidencias', 'ComiteController@evidencias')->name('csibt.evidencias')->middleware('role_session:Infocenter|Dinamizador');
        Route::get('/{id}/consultarCsibtPorNodo', 'ComiteController@datatableCsibtPorNodo_Administrador')->name('csibt.show');
        Route::get('/getideasComiteCreate', 'ComiteController@get_ideasComiteCreate');
        Route::get('/eliminarIdeaCC/{id}', 'ComiteController@get_eliminarIdeaComiteCreate');
        Route::get('/archivosDeUnComite/{id}', 'ComiteController@datatableArchivosDeUnComite');
        Route::get('/downloadFile/{id}', 'ArchivoComiteController@downloadFile')->name('csibt.files.download');
        Route::put('/{id}', 'ComiteController@updateAgendamiento')->name('csibt.agendamiento.update')->middleware('role_session:Infocenter');
        Route::put('/update_gestor/{idea}/{comite}', 'ComiteController@updateGestor')->name('csibt.update.gestor')->middleware('role_session:Dinamizador');
        Route::put('/realizar_comite/{id}', 'ComiteController@updateRealizado')->name('csibt.realizar.store')->middleware('role_session:Infocenter');
        Route::put('/asignar_ideas/{id}', 'ComiteController@updateAsignarGestor')->name('csibt.asignar.store')->middleware('role_session:Dinamizador');
        Route::put('/updateEvidencias/{id}', 'ComiteController@updateEvidencias')->name('csibt.update.evidencias');
        Route::post('/', 'ComiteController@store')->name('csibt.store')->middleware('role_session:Infocenter');
        Route::post('/store/{id}/filesComite', 'ArchivoComiteController@store')->name('csibt.files.store');
        Route::delete('/file/{idFile}', 'ArchivoComiteController@destroy')->name('csibt.files.destroy');
    }
);

//-------------------Route group para el módulo de Comité
Route::group(
    [
        'prefix'     => 'empresa',
        'middleware' => ['auth', 'role_session:Administrador|Dinamizador|Gestor|Talento'],
    ],
    function () {
        Route::get('/', 'EmpresaController@index')->name('empresa');
        Route::get('/create', 'EmpresaController@create')->name('empresa.create')->middleware('role_session:Talento');
        Route::get('/datatableEmpresasDeTecnoparque', 'EmpresaController@datatableEmpresasDeTecnoparque')->name('empresa.datatable');
        Route::get('/{id}/edit', 'EmpresaController@edit')->name('empresa.edit')->middleware('role_session:Desarrollador|Administrador');
        Route::get('/ajaxDetallesDeUnaEmpresa/{value}/{field}', 'EmpresaController@detalleDeUnaEmpresa')->name('empresa.detalle');
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
        'middleware' => ['auth', 'role_session:Administrador|Dinamizador|Gestor|Infocenter'],
    ],
    function () {
        Route::get('/notificar_inicio/{id}/{rol}', 'ArticulacionController@notificar_inicio')->name('articulacion.notificar.inicio')->middleware('role_session:Gestor');
        Route::get('/notificar_planeacion/{id}', 'ArticulacionController@notificar_planeacion')->name('articulacion.notificar.planeacion')->middleware('role_session:Gestor');
        Route::get('/notificar_ejecucion/{id}', 'ArticulacionController@notificar_ejecucion')->name('articulacion.notificar.ejecucion')->middleware('role_session:Gestor');
        Route::get('/notificar_cierre/{id}', 'ArticulacionController@notificar_cierre')->name('articulacion.notificar.cierre')->middleware('role_session:Gestor');
        Route::get('/notificar_suspendido/{id}', 'ArticulacionController@notificar_suspendido')->name('articulacion.notificar.suspension')->middleware('role_session:Gestor');

        Route::get('/', 'ArticulacionController@index')->name('articulacion');
        Route::get('/inicio/{id}', 'ArticulacionController@inicio')->name('articulacion.inicio')->middleware('role_session:Gestor|Dinamizador|Talento|Administrador|Infocenter');
        Route::get('/planeacion/{id}', 'ArticulacionController@planeacion')->name('articulacion.planeacion')->middleware('role_session:Gestor|Dinamizador|Talento|Administrador|Infocenter');
        Route::get('/ejecucion/{id}', 'ArticulacionController@ejecucion')->name('articulacion.ejecucion')->middleware('role_session:Gestor|Dinamizador|Talento|Administrador|Infocenter');
        Route::get('/cierre/{id}', 'ArticulacionController@cierre')->name('articulacion.cierre')->middleware('role_session:Gestor|Dinamizador|Talento|Administrador|Infocenter');
        Route::get('/consultarArticulaciones_costos/{anho}', 'ArticulacionController@consultarArticulaciones_costos');

        Route::get('/create', 'ArticulacionController@create')->name('articulacion.create')->middleware('role_session:Gestor');
        Route::get('/datatableArticulacionesDelGestor/{id}/{anho}', 'ArticulacionController@datatableArticulacionesPorGestor')->name('articulacion.datatable');
        Route::get('/datatableArticulacionesDelNodo/{id}/{anho}', 'ArticulacionController@datatableArticulacionesPorNodo')->name('articulacion.datatable.nodo')->middleware('role_session:Dinamizador|Administrador|Infocenter');
        Route::get('/{id}/edit', 'ArticulacionController@edit')->name('articulacion.edit')->middleware('role_session:Gestor|Dinamizador');
        Route::get('/detalle/{id}', 'ArticulacionController@detalles')->name('articulacion.detalle')->middleware('role_session:Administrador|Dinamizador|Gestor|Infocenter');
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
        Route::get('/notificar_inicio/{id}/{fase}', 'ProyectoController@solicitar_aprobacion')->name('proyecto.solicitar.aprobacion')->middleware('role_session:Gestor');
        Route::get('/notificar_suspendido/{id}', 'ProyectoController@notificar_suspendido')->name('proyecto.notificar.suspension')->middleware('role_session:Gestor');

        // Route::get('/informacion-proyecto/{id}', 'ProyectoController@informacionProyectoById')->name('proyecto.informacion')->middleware('role_session:Gestor|Dinamizador|Talento|Administrador');
        Route::get('/', 'ProyectoController@index')->name('proyecto');
        Route::get('/consultarProyectos_costos/{anho}', 'ProyectoController@proyectosCostos')->name('proyecto.costos')->middleware('role_session:Dinamizador|Gestor');
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
        Route::get('/datatableProyectosDelGestorPorAnho/{idgestor}/{anho}', 'ProyectoController@datatableProyectosDelGestorPorAnho')->name('proyecto.datatable.proyectos.gestor.anho')->middleware('role_session:Administrador|Dinamizador|Gestor|Infocenter');
        Route::get('/datatableProyectosDelNodoPorAnho/{idnodo}/{anho}', 'ProyectoController@datatableProyectosDelNodoPorAnho')->name('proyecto.datatable.proyectos.nodo.anho');
        Route::get('/detalle/{id}', 'ProyectoController@detalle')->name('proyecto.detalle')->middleware('role_session:Gestor|Dinamizador|Talento|Administrador|Infocenter');
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
        Route::put('/inicio/{id}', 'ProyectoController@updateInicio')->name('proyecto.update.inicio')->middleware('role_session:Gestor');
        Route::put('/gestionar_aprobacion/{id}/{fase}', 'ProyectoController@gestionarAprobacion')->name('proyecto.aprobacion')->middleware('role_session:Dinamizador|Talento');
        Route::put('/planeacion/{id}', 'ProyectoController@updatePlaneacion')->name('proyecto.update.planeacion')->middleware('role_session:Gestor');
        Route::put('/ejecucion/{id}', 'ProyectoController@updateEjecucion')->name('proyecto.update.ejecucion')->middleware('role_session:Gestor');
        Route::put('/cierre/{id}', 'ProyectoController@updateCierre')->name('proyecto.update.cierre')->middleware('role_session:Gestor');
        Route::put('/suspendido/{id}', 'ProyectoController@updateSuspendido')->name('proyecto.update.suspendido')->middleware('role_session:Gestor|Dinamizador');
        Route::put('/updateEntregables/{id}', 'ProyectoController@updateEntregables')->name('proyecto.update.entregables.inicio')->middleware('role_session:Gestor|Dinamizador');
        Route::put('/updateEntregables_Cierre/{id}', 'ProyectoController@updateEntregables_Cierre')->name('proyecto.update.entregables.cierre')->middleware('role_session:Gestor|Dinamizador');
        Route::put('/update_gestor/{id}', 'ProyectoController@updateGestor')->name('proyecto.update.gestor')->middleware('role_session:Dinamizador');
        Route::put('/reversar/{id}/{fase}', 'ProyectoController@updateReversar')->name('proyecto.reversar')->middleware('role_session:Dinamizador|Administrador');
        Route::post('/', 'ProyectoController@store')->name('proyecto.store')->middleware('role_session:Gestor');
        Route::post('/store/{id}/files', 'ArchivoController@uploadFileProyecto')->name('proyecto.files.upload')->middleware('role_session:Gestor');
        Route::delete('/file/{idFile}', 'ArchivoController@destroyFileProyecto')->name('proyecto.files.destroy')->middleware('role_session:Gestor');
    }
);

Route::group(
    [
        'prefix'     => 'actividad',
        'middleware' => ['auth', 'role_session:Administrador|Dinamizador|Gestor|Talento|Infocenter'],
    ],
    function () {
        Route::get('/detalle/{code}', 'ProyectoController@detailActivityByCode')->name('actividad.detalle');
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
        'middleware' => ['auth', 'role_session:Infocenter|Dinamizador|Administrador|Articulador'],
    ],
    function () {
        Route::get('/', 'CharlaInformativaController@index')->name('charla');
        Route::get('/create', 'CharlaInformativaController@create')->name('charla.create')->middleware('role_session:Infocenter|Articulador');
        Route::get('/consultarCharlasInformativasPorNodo/{id}', 'CharlaInformativaController@datatableCharlasInformativosDeUnNodo')->name('charla.nodo');
        Route::get('/{id}/evidencias', 'CharlaInformativaController@evidencias')->name('charla.evidencias');
        Route::get('/consultarDetallesDeUnaCharlaInformativa/{id}', 'CharlaInformativaController@detallesDeUnaCharlaInformativa')->name('charla.detalle');
        Route::get('/archivosDeUnaCharlaInformartiva/{id}', 'ArchivoController@datatableArchivosDeUnaCharlaInformatva')->name('charla.files');
        Route::get('/downloadFile/{id}', 'ArchivoController@downloadFileCharlaInformativa')->name('charla.files.download');
        Route::get('/{id}/edit', 'CharlaInformativaController@edit')->name('charla.edit')->middleware('role_session:Infocenter|Articulador');
        Route::put('/{id}', 'CharlaInformativaController@update')->name('charla.update')->middleware('role_session:Infocenter|Articulador');
        Route::put('/updateEvidencias/{id}', 'CharlaInformativaController@updateEvidencias')->name('charla.update.evidencias')->middleware('role_session:Infocenter|Articulador');
        Route::post('/', 'CharlaInformativaController@store')->name('charla.store')->middleware('role_session:Infocenter|Articulador');
        Route::post('/store/{id}/files', 'ArchivoController@uploadFileCharlaInformartiva')->name('charla.files.upload')->middleware('role_session:Infocenter|Articulador');
        Route::delete('/file/{idFile}', 'ArchivoController@destroyFileCharlaInformartiva')->name('charla.files.destroy')->middleware('role_session:Infocenter|Articulador');
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
        Route::get('/export/{idnodo}/{fecha_inicio}/{fecha_fin}', 'Excel\IndicadorController@exportIndicadores2020')->middleware('role_session:Dinamizador|Administrador|Gestor')->name('indicador.export.excel');
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
        Route::get('/seguimientoDeUnNodoFases/{id}', 'SeguimientoController@seguimientoDelNodoFases')->middleware('role_session:Dinamizador|Administrador');
        Route::get('/seguimientoDeUnGestorFases/{id}', 'SeguimientoController@seguimientoDelGestorFases')->middleware('role_session:Dinamizador|Administrador');
    }
);

/**
 * Route group para el módulo de indicadores
 */
Route::group(
    [
        'prefix' => 'indicadores',
        'middleware' => ['auth', 'role_session:Administrador|Dinamizador|Gestor',]
    ],
    function () {
        Route::get('/', 'IndicadorController@index')->name('indicadores');
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
        Route::get('/admitido/{idea}/{comite}', 'PdfComiteController@printPDF')->name('print.admitido');
        Route::get('/noadmitido', 'PdfComiteController@printPDFNoAceptado')->name('print.noadmitido');
        Route::get('/usos_actividad/{id}/{tipo_actividad}', 'UsoInfraestructuraController@downloadPDFUsosInfraestructura')->name('pdf.actividad.usos');
        Route::get('/inicio_proyecto/{id}', 'PdfProyectoController@printFormularioAcuerdoDeInicio')->name('pdf.proyecto.inicio');
        Route::get('/inicio_articulacion/{id}', 'PdfArticulacionController@printFormularioInicio')->name('pdf.articulacion.inicio');
        Route::get('/cierre_articulacion/{id}', 'PdfArticulacionController@printFormularioCierre')->name('pdf.articulacion.cierre');
        Route::get('/cierre/{id}', 'PdfProyectoController@printFormularioCierre')->name('pdf.proyecto.cierre');
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

//-------------------------------- Route group para el módulo de migración
Route::group([
    'prefix' => 'migracion',
    'middleware' => ['auth']
], function () {
    Route::get('/', 'MigracionController@index')->name('migracion.index')->middleware('role_session:Desarrollador');
    Route::post('/importar', 'MigracionController@import')->name('migracion.proyectos.store')->middleware('role_session:Desarrollador');
});

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

Route::get('creditos', function () {
    return view('configuracion.creditos');
})->name('creditos');


//-----------------------Ruta para registro usuario nuevo---------------------------------

Route::get('/registro-usuario', 'User\UserController@create')->name('persona.create');

//-----------------------Fin ruta registro usuario nuevo-----------------------------------

//-----------------------Ruta para sección de noticias---------------------------------

Route::get('/spa', ['as' => 'spa','uses' => 'NoticiasController@spa']);

Route::group([
    'prefix' => 'noticias',
    'middleware' => ['auth']
], function () {

    Route::get('/', 'NoticiasController@index')->name('noticias.index')->middleware('role_session:Administrador');
    Route::get('/create', 'NoticiasController@create')->name('noticias.create');
    Route::post('/', 'NoticiasController@store')->name('noticias.store');
    Route::get('/{id}/edit', 'NoticiasController@edit')->name('noticias.edit')->middleware('role_session:Administrador');
    Route::patch('/{id}', 'NoticiasController@update')->name('noticias.update')->middleware('role_session:Administrador');
    Route::delete('/{id}', 'NoticiasController@destroy')->name('noticias.destroy');


});

//-----------------------Fin ruta sección noticias-----------------------------------
