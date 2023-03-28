<?php

use App\Models\ControlNotificaciones;
use App\Models\Movimiento;
use App\Notifications\Articulation\ArticulationStageNoApproveEndorsement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;

/*DB::listen(function ($query) {
    echo "<pre>{$query->sql}</pre>";
    echo "<pre>{$query->time}</pre>";
});*/

/*Route::get('email', function () {
    return new App\Mail\Support\AutomaticMessageSent(App\Models\Support::first());
});*/
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

//verificar usuario no registrado
Route::post('user/verify', 'Auth\UnregisteredUserVerificationController@verificationUser')->name('user.verify');

//Change Email Routes...
Route::get('email/reset', 'Auth\ChangeEmailController@showEmailChangeRequestForm')->name('email.request');
Route::post('email/send', 'Auth\ChangeEmailController@sendEmailChange')->name('email.send');

Route::post('cambiar-role', 'User\RolesPermissions@changeRoleSession')
    ->name('user.changerole')
    ->middleware('disablepreventback');

Route::get('/home', 'HomeController@index')->name('home')->middleware('disablepreventback');

// Route::get('/nodo/inhabilitar_funcionarios/{nodo}', 'Nodo\NodoController@inhabilitar_funcionarios')->name('nodo.inhabilitar');
Route::get('/nodo/fetch_data', 'Nodo\NodoController@nodo_pagination');
Route::resource('nodo', 'Nodo\NodoController')->middleware(['disablepreventback', 'role_session:Administrador|Activador|Dinamizador|Infocenter|Experto']);

Route::get('usuario/{documento}/password/reset', 'User\UserController@generatePassword')->name('user.newpassword')->middleware('disablepreventback');
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

        Route::get('/mistalentos', [
            'uses' => 'UserController@talentsList',
            'as'   => 'usuario.mytalentos',
        ]);
        Route::get('/talento/getTalentosDeTecnoparque', [
            'uses' => 'TalentoController@datatableTalentosDeTecnoparque',
            'as'   => 'talento.tecnoparque',
        ]);

        Route::get('/talento/consultarTalentoPorId/{id}', [
            'uses' => 'TalentoController@consultarUnTalentoPorId',
            'as'   => 'talento.tecnoparque.byid',
        ]);

        Route::get('consultarUserPorId/{id}', 'UserController@findUserById');

        Route::get('/', [
            'uses' => 'UserController@index',
            'as'   => 'usuario.index',
        ]);
        Route::put('/updateacceso/{documento}', 'UserController@updateAccess')->name('usuario.usuarios.updateacceso')->middleware('disablepreventback');
        Route::get('/talento/getEdadTalento/{id}', 'TalentoController@getEdad');


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
        Route::get('/{documento}/permisos', 'UserController@changeNodeAndRole')->name('usuario.usuarios.changenode')->where('documento', '[0-9]+');
        Route::put('/{documento}/permisos', 'UserController@updateNodeAndRole')->name('usuario.usuarios.updatenodo')->middleware('disablepreventback');
        Route::get('/usuarios/acceso/{documento}', 'UserController@access')->name('usuario.usuarios.acceso')->where('documento', '[0-9]+');
        Route::get('/usuarios/tomar_control/{id}', 'UserController@tomar_control')->name('usuario.tomar.control');
        Route::get('/usuarios/dejar_control', 'UserController@dejar_control')->name('usuario.dejar.control');
        Route::put('/{id}/update-account', 'UserController@updateAccountUser')->name('usuario.usuarios.updateaccount')->middleware('disablepreventback');
        Route::resource('usuarios', 'UserController', ['as' => 'usuario', 'only' => ['show', 'edit']])->names([
            'update'  => 'usuario.usuarios.update',
            'show'    => 'usuario.usuarios.show',
            'edit'    => 'usuario.usuarios.edit',
        ])->parameters([
            'usuarios' => 'id',
        ]);
    }
);

//costos administrativos
Route::get('costos-administrativos/costoadministrativo/{nodo}', 'CostoAdministrativoController@getCostoAdministrativoPorNodo')->name('costoadministrativo.costosadministrativosfornodo');

Route::resource('costos-administrativos', 'CostoAdministrativoController', [
    'as' => 'costos-administrativos',
    'except' => [
        'create',
        'store',
        'destroy',
        'show',
        'edit',
        'update'
    ]
])->names([
    'index'   => 'costoadministrativo.index',
])
    ->parameters([
        'costos_administrativo' => 'id',
    ]);
Route::get('costos-administrativos/edit/{id}/{nodo}', 'CostoAdministrativoController@edit')->name('costoadministrativo.edit')->middleware('role_session:Dinamizador|Activador');
Route::put('costos-administrativos/update/{id}/{nodo}', 'CostoAdministrativoController@update')->name('costoadministrativo.update')->middleware('role_session:Dinamizador|Activador');

Route::get('costos-administrativos/costoadministrativo/{nodo}', 'CostoAdministrativoController@getCostoAdministrativoPorNodo')->name('costoadministrativo.costosadministrativosfornodo');

//equipos
Route::get('/equipos/export', 'EquipoController@export')->name('equipo.export');
Route::get('/equipos/getequiposporlinea/{nodo}/{lineatecnologica}', 'EquipoController@getEquiposPorLinea')
    ->name('equipo.getequiposporlinea');

Route::get('/equipos/cambiar-estado/{id}/', 'EquipoController@changeState')->name('equipo.cambiar-estado');
Route::get('/equipos/destacar/{id}/', 'EquipoController@destacarEquipo')->name('equipo.destacar');
Route::get('/equipos/importar', 'EquipoController@importar')->name('equipo.import');
Route::resource('equipos', 'EquipoController', [
    'as' => 'equipos',
])->names([
    'index'   => 'equipo.index',
    'create'  => 'equipo.create',
    'store'   => 'equipo.store',
    'show'    => 'equipo.show',
    'edit'    => 'equipo.edit',
    'update'  => 'equipo.update',
    // 'destroy' => 'equipo.destroy',
])
    ->parameters([
        'equipos' => 'id',
    ]);

//materiales
Route::get('/materiales/getmaterialespornodo/{nodo}', 'MaterialController@getMaterialesPorNodo')
    ->name('material.getmaterialespornodo');

Route::get('/materiales/getmaterial/{id}', 'MaterialController@getMaterial')
    ->name('material.getmaterial');

Route::get('materiales/importar', 'MaterialController@importar')->name('materiales.import');
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
])->parameters([
        'materiales' => 'id',
]);

//mantenimientos
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

//uso infraestrucutra
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

    Route::get('usoinfraestructura/ideasfornode', 'UsoInfraestructuraController@ideasForNode')
    ->name('usoinfraestructura.ideasfornode');

    Route::get('usoinfraestructura/idea/{id}', 'UsoInfraestructuraController@infoidea')
        ->name('usoinfraestructura.idea');

    Route::get('usoinfraestructura/talentosporarticulacion/{id}', 'UsoInfraestructuraController@talentosPorArticulacion')
        ->name('usoinfraestructura.talentosporarticulacion');


    Route::get('usoinfraestructura/projectsforuser', 'UsoInfraestructuraController@projectsForUser')
        ->name('usoinfraestructura.projectsforuser');
    Route::get('usoinfraestructura/projectsforuser/{id}', 'UsoInfraestructuraController@projectsByUser')
        ->name('usoinfraestructura.projectsforuser.projects');

    Route::get('usoinfraestructura/actividades/{anio}', 'UsoInfraestructuraController@activitiesByAnio')
        ->name('usoinfraestructura.actividadesanio');

    Route::delete('usoinfraestructura/{id}', 'UsoInfraestructuraController@destroy')
        ->name('usoinfraestructura.destroy');
});

//centros de formación
Route::get('centro-formacion/getcentrosregional/{regional}', 'CentroController@getAllCentrosForRegional')->name('centro.getcentrosregional');
Route::resource('centro-formacion', 'CentroController');

//profile
Route::get('perfil/actividades', 'User\ProfileController@activities')->name('perfil.actividades')->middleware('disablepreventback');
Route::get('certificado', 'User\ProfileController@downloadCertificatedPlataform')->name('certificado');
Route::get('perfil/cuenta', 'User\ProfileController@account')->name('perfil.cuenta')->middleware('disablepreventback');
Route::get('perfil', 'User\ProfileController@index')->name('perfil.index')->middleware('disablepreventback');
Route::get('perfil/roles', 'User\ProfileController@roles')->name('perfil.roles')->middleware('disablepreventback');
Route::put('perfil/contraseña', 'User\ProfileController@updatePassword')->name('perfil.contraseña')->middleware('disablepreventback');
Route::get('perfil/password/reset', 'User\ProfileController@passwordReset')->name('perfil.password.reset')->middleware('disablepreventback');
Route::get('perfil/editar', 'User\ProfileController@editAccount')->name('perfil.edit')->middleware('disablepreventback');
Route::resource('perfil', 'User\ProfileController', ['only' => ['update', 'destroy']])->middleware('disablepreventback');

//ayuda
Route::get('help/getciudades/{departamento?}', 'Help\HelpController@getCiudad')->name('help.getciudades');
Route::get('help/getcentrosformacion/{regional?}', 'Help\HelpController@getCentrosRegional')->name('help.getcentrosformacion');
Route::get('help/handbook', 'Help\HelpController@downloadHandbook')->name('help.handbook');

//contactenos
Route::get('contactenos', 'SupportController@send')->name('support.send')->middleware('auth');
Route::resource('support', 'SupportController', ['except' => ['create', 'edit']])->middleware(['auth','disablepreventback']);

//-------------------Route group para el módulo de ideas
Route::get('/registrar-idea', 'IdeaController@create')->name('idea.create')->middleware(['auth', 'role_session:Talento']);
Route::group(
    [
        'prefix' => 'idea',

    ],
    function () {
        Route::get('/', 'IdeaController@index')->name('idea.index');
        Route::get('/datatable_filtros', 'IdeaController@datatableFiltros')->name('idea.datatable.filtros')->middleware('role_session:Talento|Articulador|Infocenter|Dinamizador|Activador|Experto');
        Route::get('/export', 'IdeaController@export')->name('idea.export');
        // Route::get('/datatableIdeasDeTalentos', 'IdeaController@datatableIdeasTalento')->name('idea.datatable.talento')->middleware('role_session:Talento');
        // Route::get('/datatableIdeasEnviadasDeTalentos', 'IdeaController@datatableIdeasTalento')->name('idea.datatable.talento')->middleware('role_session:Talento');
        Route::get('/{id}/editar', 'IdeaController@edit')->name('idea.edit')->middleware(['auth', 'role_session:Talento']);
        Route::get('/detallesIdea/{id}', 'IdeaController@detallesIdeas')->name('idea.det');
        Route::get('/modalIdeas/{id}', 'IdeaController@abrirModalIdeas')->name('idea.modal');
        Route::get('/{id}', 'IdeaController@detalle')->name('idea.detalle');
        Route::get('/updateEstadoIdea/{id}/{estado}', 'IdeaController@updateEstadoIdea')->name('idea.update.estado')->middleware(['auth', 'role_session:Infocenter']);
        Route::get('/derivar_idea/{id}/{comite}', 'IdeaController@deviarIdea')->name('idea.derivar')->middleware('role_session:Dinamizador');
        Route::get('/show/{idea}', 'IdeaController@show')->name('idea.show');
        Route::get('/reasignar/{idea}', 'IdeaController@reasignar_nodo')->name('idea.reasignar.nodo')->middleware('role_session:Articulador');
        Route::get('/asignar/{idea}', 'IdeaController@asignar_experto')->name('idea.asignar')->middleware('role_session:Dinamizador');
        Route::get('/sin-registro/{nodo}/{user}', 'IdeaController@consultarIdeasSinRegistro')->name('idea.sin-registrar');
        Route::get('/buscar', 'IdeaController@search')->name('idea.buscar');
        Route::put('/asignar/{idea}', 'IdeaController@asignar')->name('idea.asignar.experto')->middleware('role_session:Dinamizador');
        Route::put('/update_nodo/{idea}', 'IdeaController@updateNodoIdea')->name('idea.update.nodo')->middleware('role_session:Articulador');
        Route::put('/aceptar_postulacion/{idea}', 'IdeaController@aceptarPostulacionIdea')->name('idea.aceptar.postulacion')->middleware('role_session:Articulador');
        Route::put('/rechazar_postulacion/{idea}', 'IdeaController@rechazarPostulacionIdea')->name('idea.rechazar.postulacion')->middleware('role_session:Articulador');
        Route::put('/enviar_nodo/{id}', 'IdeaController@enviarIdeaAlNodo')->name('idea.enviar')->middleware('role_session:Talento');
        Route::put('/duplicar_idea/{id}', 'IdeaController@duplicarIdea')->name('idea.duplicar');
        // Route::put('/duplicar_idea/{id}', 'IdeaController@deviarIdea')->name('idea.derivar')->middleware('role_session:Dinamizador');
        Route::put('/inhabilitar_idea/{id}', 'IdeaController@inhabilitarIdea')->name('idea.inhabilitar');
        Route::put('/{idea}', 'IdeaController@update')->name('idea.update')->middleware(['auth', 'role_session:Talento']);
        Route::post('/', 'IdeaController@store')->name('idea.store')->middleware(['auth', 'role_session:Talento']);
        Route::post('/buscar_ideas', 'IdeaController@search_idea')->name('idea.search.rq');
    }
);

//-------------------Route group para el módulo de taller de fortalecimiento
Route::group(
    [
        'prefix'     => 'taller',
        'middleware' => ['auth', 'role_session:Infocenter|Activador|Dinamizador|Experto|Articulador'],
    ],
    function () {
        Route::get('/', 'TallerController@index')->name('taller');
        Route::get('/consultarEntrenamientosPorNodo/{id}', 'TallerController@datatableEntrenamientosPorNodo');
        Route::get('/create', 'TallerController@create')->name('taller.create')->middleware('role_session:Articulador');

        Route::get('/{id}', 'TallerController@details')->name('taller.details');
        Route::get('/inhabilitarEntrenamiento/{id}/{estado}', 'TallerController@inhabilitarEntrenamiento')->name('taller.inhabilitar')->middleware('role_session:Infocenter');
        Route::get('/{id}/evidencias', 'TallerController@evidencias')->name('taller.evidencias');
        Route::get('/getideasEntrenamiento', 'TallerController@get_ideasEntrenamiento')->middleware('role_session:Infocenter');
        Route::get('/getConfirm/{id}/{estado}', 'TallerController@getConfirm')->middleware('role_session:Infocenter');
        Route::get('/getCanvas/{id}/{estado}', 'TallerController@getCanvas')->middleware('role_session:Infocenter');
        Route::get('/getAssistF/{id}/{estado}', 'TallerController@getAssistF')->middleware('role_session:Infocenter');
        Route::get('/getAssistS/{id}/{estado}', 'TallerController@getAssistS')->middleware('role_session:Infocenter');
        Route::get('/getConvocado/{id}/{estado}', 'TallerController@getConvocado')->middleware('role_session:Infocenter');
        Route::get('/eliminar/{id}', 'TallerController@eliminar_idea')->middleware('role_session:Infocenter');
        Route::get('/downloadFile/{id}', 'ArchivoController@downloadFileEntrenamiento')->name('taller.files.download');
        Route::get('/datatableArchivosDeUnEntrenamiento/{id}', 'ArchivoController@datatableArchivosDeUnEntrenamiento');
        Route::put('/updateEvidencias/{id}', 'TallerController@updateEvidencias')->name('taller.update.evidencias')->middleware('role_session:Articulador');
        Route::post('/', 'TallerController@store')->name('taller.store')->middleware('role_session:Articulador');
        Route::post('/addidea', 'TallerController@add_idea')->middleware('role_session:Infocenter');
        Route::post('/store/{id}/files', 'ArchivoController@uploadFileEntrenamiento')->name('taller.files.store')->middleware('role_session:Articulador');
        Route::delete('/file/{idFile}', 'ArchivoController@destroyFileEntrenamiento')->name('taller.files.destroy')->middleware('role_session:Articulador');
    }
);

//-------------------Route group para el módulo de Comité
Route::group(
    [
        'prefix'     => 'csibt',
        'middleware' => ['auth', 'role_session:Activador|Dinamizador|Experto|Infocenter'],
    ],
    function () {
        Route::get('/', 'ComiteController@index')->name('csibt');
        Route::get('/create', 'ComiteController@create')->name('csibt.create');
        Route::get('/detalle/{id}', 'ComiteController@detalle')->name('csibt.detalle')->middleware('role_session:Experto|Dinamizador|Activador|Infocenter');
        Route::get('/realizar/{id}', 'ComiteController@realizar')->name('csibt.realizar')->middleware('role_session:Infocenter');
        Route::get('/asignar/{id}', 'ComiteController@asignar')->name('csibt.asignar')->middleware('role_session:Dinamizador');
        Route::get('/notificar_agendamiento/{id}/{idea}/{rol}', 'ComiteController@notificar_agendamientoController')->name('csibt.notificar.agendamiento')->middleware('role_session:Infocenter');
        Route::get('/notificar_realizado/{id}', 'ComiteController@notificar_realizadoController')->name('csibt.notificar.realizado')->middleware('role_session:Infocenter');
        Route::get('/notificar_resultado/{id}/{idComite}', 'ComiteController@notificar_resultadoController')->name('csibt.notificar.resultados')->middleware('role_session:Infocenter|Dinamizador');
        Route::get('/{id}/edit', 'ComiteController@edit')->name('csibt.edit')->middleware('role_session:Infocenter');
        Route::get('/cambiar_asignacion/{idea}/{comite}', 'ComiteController@cambiar_idea_gestor')->name('comite.cambiar.asignacion')->middleware('role_session:Dinamizador');
        Route::get('/{id}', 'ComiteController@show')->name('csibt.show');
        Route::get('/{id}/evidencias', 'ComiteController@evidencias')->name('csibt.evidencias')->middleware('role_session:Infocenter|Dinamizador|Activador');
        Route::get('/{id}/consultarCsibtPorNodo', 'ComiteController@datatableCsibtPorNodo');
        // Route::get('/getideasComiteCreate', 'ComiteController@get_ideasComiteCreate');
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

//-------------------Route group para el módulo de empresas
Route::get('/empresas/filter-code/{value}', 'EmpresaController@filterByCode')->name('empresa.filterbycode');
Route::get('/empresas/sede/{id}', 'EmpresaController@filterSede')->name('empresa.sede.filter');
Route::group(
    [
        'prefix'     => 'empresa',
        'middleware' => ['auth', 'role_session:Talento|Activador|Articulador|Experto|Infocenter|Dinamizador'],
    ],
    function () {
        Route::get('/', 'EmpresaController@index')->name('empresa');
        Route::get('/create', 'EmpresaController@create')->name('empresa.create')->middleware('role_session:Talento|Activador');
        Route::get('/search', 'EmpresaController@search')->name('empresa.search');
        Route::get('/detalle/{id}', 'EmpresaController@detalle')->name('empresa.detalle');
        Route::get('/cambiar_responsable/{id}', 'EmpresaController@form_responsable')->name('empresa.responsable')->middleware('role_session:Talento|Activador');
        Route::get('/datatableEmpresasDeTecnoparque', 'EmpresaController@datatableEmpresasDeTecnoparque')->name('empresa.datatable');
        Route::get('/{id}/edit', 'EmpresaController@edit')->name('empresa.edit')->middleware('role_session:Talento|Activador');
        Route::get('/{id}/{id_sede}/sedes_edit', 'EmpresaController@sedes_edit')->name('empresa.edit.sedes')->middleware('role_session:Talento|Activador');
        Route::get('/{id}/add_sede', 'EmpresaController@add_sede')->name('empresa.add.sede')->middleware('role_session:Talento|Activador');
        Route::get('/ajaxDetallesDeUnaEmpresa/{value}/{field}', 'EmpresaController@ajaxDeUnaEmpresa')->name('empresa.ajax.detalle');
        Route::get('/ajaxDetalleDeUnaSede/{id}', 'EmpresaController@ajaxDeUnaSede')->name('empresa.ajax.detalle');
        Route::put('/{id}/responsable', 'EmpresaController@update_responsable')->name('empresa.update.responsable')->middleware('role_session:Talento|Activador');
        Route::put('/{id}', 'EmpresaController@update')->name('empresa.update')->middleware('role_session:Talento|Activador');
        Route::put('/{id}/store_sede', 'EmpresaController@store_sede')->name('empresa.store.sede')->middleware('role_session:Talento|Activador');
        Route::put('/{id}/{id_sede}', 'EmpresaController@update_sede')->name('empresa.update.sede')->middleware('role_session:Talento|Activador');
        Route::post('/buscar_empresas', 'EmpresaController@search_empresa')->name('empresa.search.rq');
        Route::post('/', 'EmpresaController@store')->name('empresa.store')->middleware('role_session:Talento|Activador');
    }
);

//-------------------Route group para el módulo de Comité
Route::group(
    [
        'prefix'     => 'grupo',
        'middleware' => ['auth', 'role_session:Activador|Dinamizador|Experto'],
    ],
    function () {
        Route::get('/getgrupodatatables/{ciudad}', 'GrupoInvestigacionController@getDataTablesForGrupoCiudad')->name('getallgruposdatatables');
        Route::get('/getallgruposforciudad/{ciudad}', 'GrupoInvestigacionController@getAllGruposInvestigacionForCiudad')->name('getallgruposforciudad');
        Route::get('/', 'GrupoInvestigacionController@index')->name('grupo');
        Route::get('/create', 'GrupoInvestigacionController@create')->name('grupo.create')->middleware('role_session:Dinamizador|Experto');
        Route::get('/datatableGruposInvestigacionDeTecnoparque', 'GrupoInvestigacionController@datatableGruposInvestigacionDeTecnoparque')->name('grupo.datatable');
        Route::get('/{id}/edit', 'GrupoInvestigacionController@edit')->name('grupo.edit')->middleware('role_session:Dinamizador|Experto');
        Route::get('/ajaxDetallesDeUnGrupoInvestigacion/{id}', 'GrupoInvestigacionController@detallesDeUnGrupoInvestigacion')->name('grupo.detalle');
        Route::put('/{id}', 'GrupoInvestigacionController@update')->name('grupo.update')->middleware('role_session:Dinamizador|Experto');
        Route::post('/', 'GrupoInvestigacionController@store')->name('grupo.store')->middleware('role_session:Dinamizador|Experto');
    }
);

//Route group para el módulo de proyectos
Route::group(

    [
        'prefix'     => 'proyecto',
        'middleware' => ['auth', 'role_session:Articulador|Activador|Dinamizador|Experto|Talento|Infocenter'],
    ],
    function () {
        Route::get('/notificar_inicio/{id}/{fase}', 'ProyectoController@solicitar_aprobacion')->name('proyecto.solicitar.aprobacion')->middleware('role_session:Experto');
        Route::get('/notificar_suspendido/{id}', 'ProyectoController@notificar_suspendido')->name('proyecto.notificar.suspension')->middleware('role_session:Experto');

        // Route::get('/informacion-proyecto/{id}', 'ProyectoController@informacionProyectoById')->name('proyecto.informacion')->middleware('role_session:Experto|Dinamizador|Talento|Activador');
        Route::get('/', 'ProyectoController@index')->name('proyecto');
        Route::get('/consultarProyectos_costos/{anho}', 'ProyectoController@proyectosCostos')->name('proyecto.costos')->middleware('role_session:Dinamizador|Experto');
        Route::get('/create', 'ProyectoController@create')->name('proyecto.create')->middleware('role_session:Experto');
        Route::get('/sublineas_of/{id}', 'ProyectoController@consultarSublineas')->name('proyecto.sublineas');
        Route::get('/datatableproyectosfinalizados', 'ProyectoController@datatableProyectosFinalizados')->name('proyecto.datatable.finalizados');
        Route::get('/consultarHorasExpertos/{id}', 'ProyectoController@consultarHorasDeExpertos')->name('proyecto.horas.expertos');

        Route::get('/datatableEmpresasTecnoparque', 'ProyectoController@datatableEmpresasTecnoparque')->name('proyecto.datatable.empresas')->middleware('role_session:Talento');
        Route::get('/datatableGruposInvestigacionTecnoparque/{tipo}', 'ProyectoController@datatableGruposInvestigacionTecnoparque')->name('proyecto.datatable.empresas');
        Route::get('/datatableTecnoacademiasTecnoparque', 'ProyectoController@datatableTecnoacademiasTecnoparque')->name('proyecto.datatable.tecnoacademias');
        Route::get('/datatableNodosTecnoparque', 'ProyectoController@datatableNodosTecnoparque')->name('proyecto.datatable.nodos');
        Route::get('/datatableCentroFormacionTecnoparque', 'ProyectoController@datatableCentroFormacionTecnoparque')->name('proyecto.datatable.centros');
        Route::get('/ideasAsociadasAExperto/{nodo}/{id}', 'ProyectoController@ideasAsignadaAExperto')->name('proyecto.ideas.asociadas');
        Route::get('/datatableIdeasConEmpresasGrupo', 'ProyectoController@datatableIdeasConEmpresasGrupo')->name('proyecto.datatable.ideas.empresasgrupos');
        Route::get('/datatableProyectosDelGestorPorAnho/{idgestor}/{anho}', 'ProyectoController@datatableProyectosDelGestorPorAnho')->name('proyecto.datatable.proyectos.gestor.anho')->middleware('role_session:Activador|Dinamizador|Experto|Infocenter');
        Route::get('/datatableProyectosAnho/{idnodo}/{anho}', 'ProyectoController@datatableProyectosAnho')->name('proyecto.datatable.proyectos.nodo.anho')->middleware('role_session:Activador|Dinamizador|Experto|Infocenter|Articulador|Talento');
        Route::get('/detalle/{id}', 'ProyectoController@detalle')->name('proyecto.detalle')->middleware('role_session:Articulador|Experto|Dinamizador|Talento|Activador|Infocenter');
        Route::get('/inicio/{id}', 'ProyectoController@inicio')->name('proyecto.inicio')->middleware('role_session:Experto|Dinamizador|Talento|Activador|Infocenter');
        Route::get('/planeacion/{id}', 'ProyectoController@planeacion')->name('proyecto.planeacion')->middleware('role_session:Experto|Dinamizador|Talento|Activador|Infocenter');
        Route::get('/ejecucion/{id}', 'ProyectoController@ejecucion')->name('proyecto.ejecucion')->middleware('role_session:Experto|Dinamizador|Talento|Activador|Infocenter');
        Route::get('/cierre/{id}', 'ProyectoController@cierre')->name('proyecto.cierre')->middleware('role_session:Experto|Dinamizador|Talento|Activador|Infocenter');
        Route::get('/form_inicio/{id}', 'ProyectoController@form_inicio')->name('proyecto.form.inicio')->middleware('role_session:Experto');
        Route::get('/form_planeacion/{id}', 'ProyectoController@form_planeacion')->name('proyecto.form.planeacion')->middleware('role_session:Experto');
        Route::get('/form_ejecucion/{id}', 'ProyectoController@form_ejecucion')->name('proyecto.form.ejecucion')->middleware('role_session:Experto');
        Route::get('/form_cierre/{id}', 'ProyectoController@form_cierre')->name('proyecto.form.cierre')->middleware('role_session:Experto');
        Route::get('/suspender/{id}', 'ProyectoController@suspender')->name('proyecto.suspender')->middleware('role_session:Experto|Dinamizador');
        Route::get('/cambiar_gestor/{id}', 'ProyectoController@cambiar_gestor')->name('proyecto.cambiar')->middleware('role_session:Dinamizador');
        Route::get('/entregables/inicio/{id}', 'ProyectoController@entregables_inicio')->name('proyecto.entregables.inicio')->middleware('role_session:Experto');
        Route::get('/entregables/cierre/{id}', 'ProyectoController@entregables_cierre')->name('proyecto.entregables.cierre')->middleware('role_session:Experto');
        Route::get('/ajaxConsultarTalentosDeUnProyecto/{id}', 'ProyectoController@consultarTalentosDeUnProyecto')->name('proyecto.talentos');
        Route::get('/archivosDeUnProyecto/{id}/{fase}', 'ArchivoController@datatableArchivosDeUnProyecto')->name('proyecto.files');
        Route::get('/cambiar_talentos/{id}', 'ProyectoController@cambiar_talento')->name('proyecto.cambiar.talentos')->middleware('role_session:Experto');
        Route::get('/certificacion_pbt/{id}', 'ProyectoController@carta_certificacion')->name('proyecto.certificacion')->middleware('role_session:Experto|Dinamizador|Activador');
        Route::get('/downloadFile/{id}', 'ArchivoController@downloadFileProyecto')->name('proyecto.files.download');
        Route::get('/reversar/{id}/{fase}', 'ProyectoController@updateReversar')->name('proyecto.reversar')->middleware('role_session:Dinamizador|Activador');
        Route::get('/limite-inicio/{nodo}/{experto}', 'ProyectoController@proyectosLimiteInicio')->name('proyecto.limite.inicio');
        Route::put('/suspendido/{id}', 'ProyectoController@updateSuspendido')->name('proyecto.update.suspendido')->middleware('role_session:Experto|Dinamizador');
        Route::put('/inicio/{id}', 'ProyectoController@updateInicio')->name('proyecto.update.inicio')->middleware('role_session:Experto');

        Route::put('/gestionar_aprobacion/{id}', 'ProyectoController@gestionarAprobacion')->name('proyecto.aprobacion')->middleware('role_session:Dinamizador|Talento');
        Route::put('/planeacion/{id}', 'ProyectoController@updatePlaneacion')->name('proyecto.update.planeacion')->middleware('role_session:Experto');

        Route::put('/ejecucion/{id}', 'ProyectoController@updateEjecucion')->name('proyecto.update.ejecucion')->middleware('role_session:Experto');
        Route::put('/cierre/{id}', 'ProyectoController@updateCierre')->name('proyecto.update.cierre')->middleware('role_session:Experto');
        Route::put('/updateEntregables/{id}', 'ProyectoController@updateEntregables')->name('proyecto.update.entregables.inicio')->middleware('role_session:Experto');
        Route::put('/updateEntregables_Cierre/{id}', 'ProyectoController@updateEntregables_Cierre')->name('proyecto.update.entregables.cierre')->middleware('role_session:Experto');
        Route::put('/update_gestor/{id}', 'ProyectoController@updateGestor')->name('proyecto.update.gestor')->middleware('role_session:Dinamizador');
        Route::put('/update_talents/{id}', 'ProyectoController@updateTalentos')->name('proyecto.update.talentos')->middleware('role_session:Experto');

        Route::post('/', 'ProyectoController@store')->name('proyecto.store')->middleware('role_session:Experto');
        Route::post('/store/{id}/files', 'ArchivoController@uploadFileProyecto')->name('proyecto.files.upload')->middleware('role_session:Experto');
        Route::delete('/file/{idFile}', 'ArchivoController@destroyFileProyecto')->name('proyecto.files.destroy');

    }
);

Route::get('actividades/filter-code/{value}', 'ProyectoController@filterByCode')->name('proyecto.filterbycode');

Route::group(
    [
        'prefix'     => 'actividad',
        'middleware' => ['auth', 'role_session:Articulador|Activador|Dinamizador|Experto|Talento|Infocenter'],
    ],
    function () {
        Route::get('/detalle/{code}', 'ProyectoController@detailActivityByCode')->name('actividad.detalle');
    }
);

/**
 * Route group para el módulo de edt (Eventos de Divulgación Tecnológica)
 */
// Route::group(
//     [
//         'prefix'     => 'edt',
//         'middleware' => ['auth', 'role_session:Gestor|Dinamizador|Activador'],
//     ],
//     function () {
//         //
//         Route::get('/', 'EdtController@index')->name('edt');
//         Route::get('/eliminarEdt/{id}', 'EdtController@eliminarEdt')->name('edt.delete')->middleware('role_session:Dinamizador');
//         Route::get('/create', 'EdtController@create')->name('edt.create')->middleware('role_session:Gestor');
//         Route::get('/{id}/edit', 'EdtController@edit')->name('edt.edit')->middleware('role_session:Gestor|Dinamizador');
//         Route::get('/{id}/entregables', 'EdtController@entregables')->name('edt.entregables');
//         Route::get('/consultarEdtsDeUnGestor/{id}/{anho}', 'EdtController@consultarEdtsDeUnGestor')->name('edt.gestor');
//         Route::get('/consultarEdtsDeUnNodo/{id}/{anho}', 'EdtController@consultarEdtsDeUnNodo')->name('edt.nodo')->middleware('role_session:Dinamizador|Activador');
//         Route::get('/consultarDetallesDeUnaEdt/{id}/{tipo}', 'EdtController@consultarDetallesDeUnaEdt')->name('edt.entidades');
//         Route::get('/archivosDeUnaEdt/{id}', 'ArchivoController@datatableArchivosDeUnaEdt')->name('edt.files');
//         Route::get('/downloadFile/{id}', 'ArchivoController@downloadFileEdt')->name('edt.files.download');
//         Route::put('/{id}', 'EdtController@update')->name('edt.update')->middleware('role_session:Gestor|Dinamizador');
//         Route::put('/updateEntregables/{id}', 'EdtController@updateEntregables')->name('edt.update.evidencias')->middleware('role_session:Gestor');
//         Route::post('/', 'EdtController@store')->name('edt.store')->middleware('role_session:Gestor');
//         Route::post('/store/{id}/files', 'ArchivoController@uploadFileEdt')->name('edt.files.upload')->middleware('role_session:Gestor');
//         Route::delete('/file/{idFile}', 'ArchivoController@destroyFileEdt')->name('edt.files.destroy')->middleware('role_session:Gestor');
//     }
// );

/**
 * Route group para el módulo visitantes
 */
Route::group(
    [
        'prefix'     => 'visitante',
        'middleware' => ['auth', 'role_session:Ingreso|Dinamizador|Activador'],
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
        'middleware' => ['auth', 'role_session:Ingreso|Dinamizador|Activador'],
    ],
    function () {
        Route::get('/', 'IngresoVisitanteController@index')->name('ingreso');
        Route::get('/create', 'IngresoVisitanteController@create')->name('ingreso.create');
        Route::get('/export', 'IngresoVisitanteController@export')->name('ingreso.export');
        Route::get('/consultarIngresosDeUnNodoTecnoparque/{id}/{start_date}/{end_date}', 'IngresoVisitanteController@datatableIngresosDeUnNodo')->name('ingreso.nodo');
        Route::get('/{id}/edit', 'IngresoVisitanteController@edit')->name('ingreso.edit');
        Route::put('/{id}', 'IngresoVisitanteController@update')->name('ingreso.update');
        Route::post('/', 'IngresoVisitanteController@store')->name('ingreso.store');
    }
);
/**
 * Route group para el módulo de charlas informativas
 */
Route::group(
    [
        'prefix'     => 'charla',
        'middleware' => ['auth', 'role_session:Infocenter|Dinamizador|Activador|Articulador'],
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
        'middleware' => ['auth'],
    ],
    function () {
        // Rutas para la generación de excel del módulo de edts
        Route::get('/excelDeUnaEdt/{id}', 'Excel\EdtController@edtsPorId')->name('edt.excel.unica')->middleware('role_session:Experto|Dinamizador|Activador|Infocenter');
        Route::get('/excelEdtsDeUnNodo/{id}', 'Excel\EdtController@edtsDeUnNodo')->name('edt.excel.nodo')->middleware('role_session:Dinamizador|Activador');
        Route::get('/excelEdtsFinalizadasPorFechaYNodo/{id}/{fecha_inicio}/{fecha_fin}', 'Excel\EdtController@edtPorFechaCierreYNodo')->name('edt.excel.nodo.fecha')->middleware('role_session:Dinamizador|Activador');
        Route::get('/excelEdtsFinalizadasPorGestorYFecha/{id}/{fecha_inicio}/{fecha_fin}', 'Excel\EdtController@edtPorFechaCierreYGestor')->name('edt.excel.gestor.fecha')->middleware('role_session:Experto|Dinamizador|Activador');
        Route::get('/excelEdtsFinalizadasPorLineaNodoYFecha/{idnodo}/{idlinea}/{fecha_inicio}/{fecha_fin}', 'Excel\EdtController@edtPorFechaCierreLineaYNodo')->name('edt.excel.nodo.linea.fecha')->middleware('role_session:Dinamizador|Activador');
        // Ruta para la generación de excel del módulo de articulaciones
        Route::get('/excelArticulacionDeUnGestor/{id}', 'Excel\ArticulacionController@articulacionesDeUnGestor')->name('articulacion.excel.gestor');
        Route::get('/excelDeUnaArticulacion/{id}', 'Excel\ArticulacionController@articulacionPorId')->name('articulacion.excel.unica');
        Route::get('/excelArticulacionDeUnNodo/{id}', 'Excel\ArticulacionController@articulacionesDeUnNodo')->name('articulacion.excel.nodo')->middleware('role_session:Dinamizador|Activador');
        Route::get('/export/{idnodo}/{fecha_inicio}/{fecha_fin}/{hoja}', 'Excel\IndicadorController@exportIndicadores2020')->name('indicador.export.excel');
        Route::get('/export/downloadMetas', 'Excel\IndicadorController@downloadMetas')->name('indicador.export.metas');
        Route::get('/export/downloadIdeas', 'Excel\IndicadorController@downloadIdeas')->name('indicador.export.ideas');
        Route::get('/export_proyectos_finalizados/{idnodo}/{fecha_inicio}/{fecha_fin}/{hoja}', 'Excel\IndicadorController@exportIndicadoresProyectosFinalizados')->name('indicador.proyectos.finalizados.export.excel');
        Route::get('/export_proyectos_inscritos/{idnodo}/{fecha_inicio}/{fecha_fin}/{hoja}', 'Excel\IndicadorController@exportIndicadoresProyectosInscritos')->name('indicador.proyectos.inscritos.export.excel')->middleware('role_session:Experto|Infocenter|Dinamizador|Activador');
        Route::get('/export_proyectos_actuales/{idnodo}/{hoja}', 'Excel\IndicadorController@exportIndicadoresProyectosActuales')->name('indicador.proyectos.actuales.export.excel');
        Route::get('/export_trazabilidad/{idproyecto}', 'Excel\ProyectoController@exportTrazabilidadProyecto')->name('excel.proyecto.trazabilidad');
        Route::get('/import_metas_form', 'IndicadorController@form_import_metas')->name('indicadores.form.metas')->middleware('role_session:Activador');
        Route::get('/export_materiales', 'Excel\MaterialController@download')->name('download.materiales');
        Route::get('/export_equipos', 'Excel\EquipoController@download')->name('download.equipos');

        //Rutas para la generación de excel del módulo de nodo
        Route::get('/excelnodo', 'Excel\NodoController@exportQueryAllNodo')
        ->middleware('role_session:Activador')
        ->name('excel.excelnodo');

        Route::get('/exportexcelfornodo/{nodo}', 'Excel\NodoController@exportQueryForNodo')
        ->middleware('role_session:Activador|Dinamizador')
        ->name('excel.exportexcelfornodo');

        Route::post('/import_materiales', 'Excel\MaterialController@import')->name('import.materiales');
        Route::post('/import_equipos', 'Excel\EquipoController@import')->name('import.equipos');
        Route::post('/import_metas', 'Excel\IndicadorController@importIndicadoresAll')->name('indicadores.import.metas')->middleware('role_session:Activador');
    }
);

/**
 * Route group para el nódulo de seguimiento
 */
Route::group(
    [
        'prefix' => 'seguimiento',
        'middleware' => ['auth', 'role_session:Activador|Dinamizador|Experto',]
    ],
    function () {
        Route::get('/', 'SeguimientoController@index')->name('seguimiento');
        Route::get('/seguimientoEsperadoDeUnGestor/{id}', 'SeguimientoController@seguimientoEsperadoDelGestor');
        Route::get('/seguimientoInscritosPorMesExperto/{id}', 'SeguimientoController@seguimientoProyectosInscritosPorMes');
        Route::get('/seguimientoProyectosInscritosPorMes', 'SeguimientoController@seguimientoProyectosInscritos');
        Route::get('/seguimientoProyectosCerradosPorMes', 'SeguimientoController@seguimientoProyectosCerrados');
        Route::get('/seguimientoEsperadoDeUnaLinea/{id}/{nodo}', 'SeguimientoController@seguimientoEsperadoDeLaLinea');
        Route::get('/seguimientoEsperado', 'SeguimientoController@seguimientoEsperado')->middleware('role_session:Activador|Dinamizador|Experto')->name('seguimiento.esperado');
        Route::get('/seguimientoEsperadoDeTecnoparque', 'SeguimientoController@seguimientoEsperadoDeTecnoparque')->middleware('role_session:Activador');
        Route::get('/seguimientoDeUnNodoFases', 'SeguimientoController@seguimientoDelNodoFases')->middleware('role_session:Activador|Dinamizador|Experto');
        // Route::get('/seguimientoEsperadoDeUnNodo', 'SeguimientoController@seguimientoEsperado')->middleware('role_session:Activador|Dinamizador');
        Route::get('/seguimientoDeTecnoparqueFases', 'SeguimientoController@seguimientoDeTecnoparqueFases')->middleware('role_session:Dinamizador|Activador');
        Route::get('/seguimientoActualDeUnGestor/{id}', 'SeguimientoController@seguimientoActualDelGestor');
        Route::get('/seguimientoActualDeUnaLinea/{id}/{nodo}', 'SeguimientoController@seguimientoActualDeLaLinea');
    }
);

/**
 * Route group para el módulo de indicadores
 */
Route::group(
    [
        'prefix' => 'indicadores',
        'middleware' => ['auth', 'role_session:Activador|Dinamizador|Experto|Infocenter']
    ],
    function () {
        Route::get('/', 'IndicadorController@index')->name('indicadores');
        // Route::get('/nodo/fetch_data', 'IndicadorController@nodo_pagination')->name('indicadores.paginar');

    }
);


/**
 * Route group para el módulo de costos
 */
Route::group(
    [
        'prefix' => 'costos',
        'middleware' => ['auth', 'role_session:Activador|Dinamizador|Experto']
    ],
    function () {
        Route::get('/', 'CostoController@index')->name('costos');
        Route::get('/proyecto/{id}', 'CostoController@costoProject');
        Route::get('/costosDeProyectos/{idnodo}/{tipos_proyecto}/{estado_proyecto}/{fecha_inicio}/{fecha_fin}/{type}', 'CostoController@costosDeProyectos')->middleware('role_session:Dinamizador|Activador');
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
        Route::get('/inicio_proyecto/{id}', 'PdfProyectoController@printFormularioAcuerdoDeInicio')->name('pdf.proyecto.inicio')->middleware('role_session:Experto');
        Route::get('/inicio_articulacion/{id}', 'PdfArticulacionController@printFormularioInicio')->name('pdf.articulacion.inicio');
        Route::get('/cierre_articulacion/{id}', 'PdfArticulacionController@printFormularioCierre')->name('pdf.articulacion.cierre');
        Route::get('/cierre/{id}', 'PdfProyectoController@printFormularioCierre')->name('pdf.proyecto.cierre')->middleware('role_session:Experto');
        Route::get('/categorizacion/{id}', 'PdfProyectoController@printActaCatergorizacion')->name('pdf.proyecto.acta.inicio')->middleware('role_session:Activador|Dinamizador|Experto');
        Route::post('/carta_certificacion/{id}', 'PdfProyectoController@printCartaCertificacionPbt')->name('pdf.proyecto.certificacion');
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
    'prefix' => 'migracion'
], function () {
    Route::get('/', 'MigracionController@index')->name('migracion.index');
    Route::post('/importar', 'MigracionController@import')->name('migracion.proyectos.store');
    Route::get('/articulaciones', 'MigracionController@migrateArticulations')->name('migracion.migrate-articulations');
});

    //-------------------------------- Route group para el módulo de exportar
Route::group([
    'prefix' => 'exportar',
    'middleware' => ['auth']
], function () {
    Route::get('/', 'ExportJsonController@index')->name('exportar.index')->middleware('role_session:Desarrollador');
    Route::get('/export_user_json', 'ExportJsonController@exportJsonUsers')->name('exportar.json.user')->middleware('role_session:Desarrollador');
    // Route::post('/importar', 'MigracionController@import')->name('migracion.proyectos.store')->middleware('role_session:Desarrollador');
});

/*=====  End of rutas para las funcionalidades de los usuarios  ======*/

/**
 * Route group para la generación de excel
 */
Route::group(
    [
        'prefix'     => 'excel',
        'middleware' => ['auth', 'role_session:Experto|Infocenter|Dinamizador|Administrador|Ingreso|Talento'],
    ],
    function () {
        // Rutas para la generación de excel del módulo de edts
        Route::get('/excelDeUnaEdt/{id}', 'Excel\EdtController@edtsPorId')->name('edt.excel.unica')->middleware('role_session:Experto|Dinamizador|Administrador|Infocenter');
        Route::get('/excelEdtsDeUnNodo/{id}', 'Excel\EdtController@edtsDeUnNodo')->name('edt.excel.nodo')->middleware('role_session:Dinamizador|Administrador');
        Route::get('/excelEdtsFinalizadasPorFechaYNodo/{id}/{fecha_inicio}/{fecha_fin}', 'Excel\EdtController@edtPorFechaCierreYNodo')->name('edt.excel.nodo.fecha')->middleware('role_session:Dinamizador|Administrador');
        Route::get('/excelEdtsFinalizadasPorGestorYFecha/{id}/{fecha_inicio}/{fecha_fin}', 'Excel\EdtController@edtPorFechaCierreYGestor')->name('edt.excel.gestor.fecha')->middleware('role_session:Experto|Dinamizador|Administrador');
        Route::get('/excelEdtsFinalizadasPorLineaNodoYFecha/{idnodo}/{idlinea}/{fecha_inicio}/{fecha_fin}', 'Excel\EdtController@edtPorFechaCierreLineaYNodo')->name('edt.excel.nodo.linea.fecha')->middleware('role_session:Dinamizador|Administrador');


        Route::get('/export/{idnodo}/{fecha_inicio}/{fecha_fin}/{hoja}', 'Excel\IndicadorController@exportIndicadores2020')->name('indicador.export.excel');
        Route::get('/export_proyectos_finalizados/{idnodo}/{fecha_inicio}/{fecha_fin}/{hoja}', 'Excel\IndicadorController@exportIndicadoresProyectosFinalizados')->name('indicador.proyectos.finalizados.export.excel');
        Route::get('/export_proyectos_inscritos/{idnodo}/{fecha_inicio}/{fecha_fin}/{hoja}', 'Excel\IndicadorController@exportIndicadoresProyectosInscritos')->name('indicador.proyectos.inscritos.export.excel');
        Route::get('/export_proyectos_actuales/{idnodo}/{hoja}', 'Excel\IndicadorController@exportIndicadoresProyectosActuales')->name('indicador.proyectos.actuales.export.excel');
        Route::get('/export_trazabilidad/{idproyecto}', 'Excel\ProyectoController@exportTrazabilidadProyecto')->name('excel.proyecto.trazabilidad');

        //Rutas para la generación de excel del módulo de nodo
        Route::get('/excelnodo', 'Excel\NodoController@exportQueryAllNodo')
            ->middleware('role_session:Administrador')
            ->name('excel.excelnodo');

        Route::get('/exportexcelfornodo/{nodo}', 'Excel\NodoController@exportQueryForNodo')
            ->middleware('role_session:Administrador|Dinamizador')
            ->name('excel.exportexcelfornodo');
    }
);



Route::get('/notificaciones', 'NotificationsController@index')
    ->name('notifications.index')
    ->middleware('disablepreventback');
Route::patch('/notificaciones/{notification}', 'NotificationsController@read')
    ->name('notifications.read')
    ->middleware('disablepreventback');
Route::delete('/notificaciones/{notification}', 'NotificationsController@destroy')
    ->name('notifications.destroy')
    ->middleware('disablepreventback');;

Route::group([
    'middleware' => 'disablepreventback',
], function () {
    Route::get('/lineas/getlineasnodo/{nodo?}', 'LineaController@getAllLineasForNodo')->name('lineas.getAllLineas');
    Route::resource('/lineas', 'LineaController', ['except' => ['destroy']])
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


Route::resource('sublineas', 'SublineaController', ['except' => ['show', 'destroy']])->middleware('disablepreventback');

Route::get('creditos', function () {
    return view('configuracion.creditos');
})->name('creditos');

Route::get('usuarios/filtro-talento/{documento}', 'User\UserController@filterTalento')->name('articulacion.usuario.talento.search');


Route::get('articulaciones/downloadFile/{id}', 'ArchivoController@downloadFileArticulation')->name('articulation.files.download');
Route::get('articulaciones/files/{id}/', 'ArchivoController@datatableArchiveArticulations')->name('articulation.files');
Route::delete('articulaciones/{idFile}/files', 'ArchivoController@destroyFileArticulation')->name('articulation.files.destroy');
Route::post('articulaciones/files/{id}', 'ArchivoController@uploadFileArticulacion')->name('articulation.files.upload');

Route::get('tipoarticulaciones/{id}/tiposubarticulaciones', 'Articulation\ArticulationTypeController@filterArticulationType');
Route::resource('tipoarticulaciones', 'Articulation\ArticulationTypeController');
Route::resource('tiposubarticulaciones', 'Articulation\ArticulationSubtypeController');


Route::group(
    [
        'namespace' => 'Articulation',
        'prefix' => 'etapa-articulaciones',
        'middleware' => ['auth']
    ],
    function () {

        Route::get('/', 'ArticulationStageListController@index')->name('articulation-stage');
        Route::get('/datatable_filtros', 'ArticulationStageListController@datatableFiltros')->name('articulation-stage.datatable.filtros');
        Route::get('/export', 'ArticulationStageListController@export')->name('articulation-stage.export');
        Route::get('/crear', 'ArticulationStageRegisterController@create')->name('articulation-stage.create');
        Route::post('/', 'ArticulationStageRegisterController@store')->name('articulation-stage.store');
        Route::get('/{code}', 'ArticulationStageListController@show')->name('articulation-stage.show');
        Route::get('/{code}/editar', 'ArticulationStageRegisterController@edit')->name('articulation-stage.edit');
        Route::put('/{code}', 'ArticulationStageRegisterController@update')->name('articulation-stage.update');

        Route::get('/articulaciones/{code}/cambiar-participantes', 'ArticulationListController@changeTalents')->name('articulations.changetalents');
        Route::put('/articulaciones/{code}/cambiar-participantes', 'ArticulationListController@updateTalents')->name('articulations.updatetalents');
        Route::get('/{code}/cambiar-interlocutor', 'ArticulationStageListController@changeInterlocutor')->name('articulation-stage.changeinterlocutor');
        Route::put('/{code}/cambiar-interlocutor', 'ArticulationStageListController@updateInterlocutor')->name('articulation-stage.updateinterlocutor');
        Route::put('/{code}/cambiar-estado', 'ArticulationStageListController@changeStatus')->name('articulations.changeStatus');


        Route::get('/articulaciones/{code}/crear', 'ArticulationRegisterController@create')->name('articulations.create');

        Route::get('/solicitar-aprobacion/{id}/{fase}', 'ArticulationStageApprovalsController@requestApproval')->name('articulation-stage.request-approval');
        Route::get('/descargar/{phase}/{code}', 'ArticulationListController@downloadCertificate')->name('articulations.download-certificate');
        Route::get('/articulaciones/{code}/evidencias', 'ArticulationListController@evidences')->name('articulations.evidences');
        Route::get('/articulaciones/{code}/solicitar-aprobacion', 'ArticulationListController@requestApproval')->name('articulation.request-approval');

        Route::get('/articulaciones/{code}/{fase}', 'ArticulationListController@showPhase')->name('articulations.show.phase');

        Route::post('/articulaciones/{code}/crear', 'ArticulationRegisterController@store')->name('articulations.store');


        Route::get('/articulaciones/{code}', 'ArticulationListController@show')->name('articulations.show');
        Route::put('/articulaciones/{code}/editar', 'ArticulationRegisterController@update')->name('articulation.update');
        Route::put('articulaciones/gestionar_aprobacion/{id}/{fase}', 'ArticulationListController@manageApprovall')->name('articulations.manage-approval');
        Route::put('/gestionar_aprobacion/{id}/{fase}', 'ArticulationStageApprovalsController@manageEndorsement')->name('articulation-stage.manage-endorsement');
        Route::put('/articulaciones/{code}/{fase}/siguiente-fase', 'ArticulationListController@changeNextPhase')->name('articulation.change-next-phase');
        Route::put('/articulaciones/{code}/{fase}/anterior-fase', 'ArticulationListController@changePreviusPhase')->name('articulation.change-previus-phase');
        Route::put('/articulaciones/{code}/ejecutar', 'ArticulationListController@updatePhaseExecute')->name('articulation.update.execution');
        Route::put('/articulaciones/{code}/cierre', 'ArticulationListController@updatePhaseClosing')->name('articulation.update.closing');
        Route::delete('/{id}', 'ArticulationStageListController@destroy')->name('articulation-stage.destroy');
        Route::delete('articulaciones/{id}', 'ArticulationListController@destroy')->name('articulation.destroy');
    }
);

