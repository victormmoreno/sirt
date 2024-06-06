<?php

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
Route::get('/materiales/cambiar-estado/{id}/', 'MaterialController@changeStatus')->name('material.cambiar-estado');
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


//centros de formación
Route::get('centro-formacion/getcentrosregional/{regional}', 'CentroController@getAllCentrosForRegional')->name('centro.getcentrosregional');


//ayuda
Route::get('help/getciudades/{departamento?}', 'Help\HelpController@getCiudad')->name('help.getciudades');
Route::get('help/getcentrosformacion/{regional?}', 'Help\HelpController@getCentrosRegional')->name('help.getcentrosformacion');
Route::get('help/handbook', 'Help\HelpController@downloadHandbook')->name('help.handbook');

//contactenos
Route::get('contactenos', 'SupportController@send')->name('support.send')->middleware('auth');
Route::resource('support', 'SupportController', ['except' => ['create', 'edit']])->middleware(['auth','disablepreventback']);

//-------------------Route group para el módulo de ideas
Route::get('/registrar-idea', 'IdeaController@create')->name('idea.create')->middleware(['auth']);
Route::group(
    [
        'prefix' => 'idea',

    ],
    function () {
        Route::get('/', 'IdeaController@index')->name('idea.index');
        Route::get('/datatable_filtros', 'IdeaController@datatableFiltros')->name('idea.datatable.filtros');
        Route::get('/export', 'IdeaController@export')->name('idea.export');
        Route::get('/export_registradas/{nodo}/{desde}/{hasta}', 'IdeaController@export_registradas')->name('idea.export.registradas');
        Route::get('/{id}/editar', 'IdeaController@edit')->name('idea.edit');
        Route::get('/detallesIdea/{id}', 'IdeaController@detallesIdeas')->name('idea.det');
        Route::get('/modalIdeas/{id}', 'IdeaController@abrirModalIdeas')->name('idea.modal');
        Route::get('/{id}', 'IdeaController@detalle')->name('idea.detalle');
        Route::get('/updateEstadoIdea/{id}/{estado}', 'IdeaController@updateEstadoIdea')->name('idea.update.estado')->middleware(['auth', 'role_session:Infocenter']);
        Route::get('/derivar_idea/{id}/{comite}/{bandera}', 'IdeaController@deviarIdea')->name('idea.derivar')->middleware('role_session:Dinamizador');
        Route::get('/show/{idea}', 'IdeaController@show')->name('idea.show');
        Route::get('/reasignar/{idea}', 'IdeaController@reasignar_nodo')->name('idea.reasignar.nodo')->middleware('role_session:Articulador');
        Route::get('/sin-registro/{nodo}/{user}', 'IdeaController@consultarIdeasSinRegistro')->name('idea.sin-registrar');
        Route::get('/registradas/{nodo}/{desde}/{hasta}', 'IdeaController@consultar_ideas_registradas')->name('idea.registradas');
        Route::get('/buscar', 'IdeaController@search')->name('idea.buscar');
        Route::put('/asignar/{idea}', 'IdeaController@asignar')->name('idea.asignar.experto')->middleware('role_session:Dinamizador');
        Route::put('/update_nodo/{idea}', 'IdeaController@updateNodoIdea')->name('idea.update.nodo')->middleware('role_session:Articulador');
        Route::put('/aceptar_postulacion/{idea}', 'IdeaController@aceptarPostulacionIdea')->name('idea.aceptar.postulacion')->middleware('role_session:Articulador');
        Route::put('/rechazar_postulacion/{idea}', 'IdeaController@rechazarPostulacionIdea')->name('idea.rechazar.postulacion')->middleware('role_session:Articulador');
        Route::put('/enviar_nodo/{id}', 'IdeaController@enviarIdeaAlNodo')->name('idea.enviar');
        Route::put('/duplicar_idea/{id}', 'IdeaController@duplicarIdea')->name('idea.duplicar');
        Route::put('/inhabilitar_idea/{id}', 'IdeaController@inhabilitarIdea')->name('idea.inhabilitar');
        Route::put('/{idea}', 'IdeaController@update')->name('idea.update');
        Route::post('/', 'IdeaController@store')->name('idea.store');
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

Route::get('actividades/filter-code/{value}', 'ProyectoController@filterByCode')->name('proyecto.filterbycode');

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
 * Route group para el módulo visitantes
 */
Route::group(
    [
        'prefix'     => 'tag',
        'middleware' => ['auth'],
    ],
    function () {
        Route::get('/', 'TagController@index')->name('tag.index');
        // Route::get('/index', 'TagController@index')->name('tag.index');
        Route::get('/create', 'TagController@create')->name('tag.create');
        Route::get('/state/{id}/{state}', 'TagController@update_state')->name('tag.state');
        Route::get('/edit/{id}', 'TagController@edit')->name('tag.edit');
        Route::get('/tagsList', 'TagController@tagsList')->name('tag.list');
        Route::put('/{id}', 'TagController@update')->name('tag.update');
        Route::post('/', 'TagController@store')->name('tag.store');
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
        'middleware' => ['auth'],
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

        Route::get('/export/downloadMetas', 'Excel\IndicadorController@downloadMetas')->name('indicador.export.metas');
        Route::get('/export/downloadMetas/articulaciones', 'Excel\IndicadorController@downloadMetasArticulaciones')->name('indicador.export.metas-articulaciones');
        Route::get('/export/downloadIdeas', 'Excel\IndicadorController@downloadIdeas')->name('indicador.export.ideas');
        Route::get('/export_proyectos_indicadores', 'Excel\IndicadorController@exportIndicadoresProyectos')->name('indicador.proyectos.export.excel')->middleware('role_session:Articulador|Auxiliar|Experto|Infocenter|Dinamizador|Activador');
        Route::get('/export_resultados_encuesta', 'Excel\IndicadorController@exportResultadosEncuesta')->name('encuesta.resultados')->middleware('role_session:Administrador|Auxiliar|Activador|Dinamizador');
        // Route::get('/export_trazabilidad/{idproyecto}', 'Excel\ProyectoController@exportTrazabilidadProyecto')->name('excel.proyecto.trazabilidad');
        Route::get('/import_metas_form', 'IndicadorController@form_import_metas')->name('indicadores.form.metas')->middleware('role_session:Activador');
        Route::get('/export_materiales', 'Excel\MaterialController@download')->name('download.materiales');
        Route::get('/export_equipos', 'Excel\EquipoController@download')->name('download.equipos');
        Route::get('/export_seguimiento', 'Excel\SeguimientoController@download_seguimiento');

        Route::get('/export/{nodo}/articulaciones/{fecha_inicio}/{fecha_fin}/{hoja}', 'Excel\IndicadorController@exportIndicatorArticulations')->name('indicador.export.excel');

        Route::post('/import_materiales', 'Excel\MaterialController@import')->name('import.materiales');
        Route::post('/import_equipos', 'Excel\EquipoController@import')->name('import.equipos');
        Route::post('/import_metas', 'Excel\IndicadorController@importIndicadoresAll')->name('indicadores.import.metas')->middleware('role_session:Activador');
        
        Route::post('/importar/caracterizacion', 'Excel\MigracionController@import_caracterizacion_proyectos')->name('migracion.proyectos.caracterizacion.store')->middleware('role_session:Desarrollador');

        Route::get('/export_articulaciones_actuales/{nodo}/{hoja}', 'Excel\IndicadorController@exportIndicadoresArticulacionesActivas')->name('indicador.proyectos.actuales.export.excel')->middleware('role_session:Auxiliar|Administrador|Dinamizador|Activador|Articulador|Infocenter');
        Route::get('/export_articulaciones_inscritos/{nodo}/{fecha_inicio}/{fecha_fin}/{hoja}', 'Excel\IndicadorController@exportIndicadorArticulacionesInscritas')->name('indicador.articulaciones.inscritas.export.excel')->middleware('role_session:Auxiliar|Administrador|Dinamizador|Activador|Articulador|Infocenter');
        Route::get('/export_articulaciones_finalizadas/{nodo}/{fecha_inicio}/{fecha_fin}/{hoja}', 'Excel\IndicadorController@exportIndicadoresArticulacionesFinalizadas')->name('indicador.articulaciones.finalizadas.export.excel')->middleware('role_session:Auxiliar|Administrador|Dinamizador|Activador|Articulador|Infocenter');
    }
);

/**
 * Route group para el nódulo de seguimiento
 */
Route::group(
    [
        'prefix' => 'seguimiento',
        'middleware' => ['auth', 'role_session:Auxiliar|Administrador|Activador|Dinamizador|Experto|Articulador|Infocenter',]
    ],
    function () {
        // Route::get('/', 'SeguimientoController@index')->name('seguimiento');
        Route::get('/seguimientoEsperadoDeUnGestor/{id}', 'SeguimientoController@seguimientoEsperadoDelGestor');
        Route::get('/seguimientoInscritosPorMesExperto/{id}', 'SeguimientoController@seguimientoProyectosInscritosPorMes');
        Route::get('/seguimientoProyectosInscritosPorMes', 'SeguimientoController@seguimientoProyectosInscritos');
        Route::get('/seguimientoProyectosCerradosPorMes', 'SeguimientoController@seguimientoProyectosCerrados');
        Route::get('/seguimientoEsperadoDeUnaLinea/{id}/{nodo}', 'SeguimientoController@seguimientoEsperadoDeLaLinea');
        Route::get('/seguimientoEsperado', 'SeguimientoController@seguimientoEsperado')->name('seguimiento.esperado');
        Route::get('/seguimientoEsperadoDeTecnoparque', 'SeguimientoController@seguimientoEsperadoDeTecnoparque')->middleware('role_session:Activador');
        Route::get('/seguimientoDeUnNodoFases', 'SeguimientoController@seguimientoDelNodoFases')->middleware('role_session:Articulador|Auxiliar|Activador|Dinamizador|Experto|Infocenter');
        // Route::get('/seguimientoEsperadoDeUnNodo', 'SeguimientoController@seguimientoEsperado')->middleware('role_session:Activador|Dinamizador');
        Route::get('/seguimientoDeTecnoparqueFases', 'SeguimientoController@seguimientoDeTecnoparqueFases')->middleware('role_session:Dinamizador|Activador|Auxiliar');
        Route::get('/seguimientoActualDeUnGestor/{id}', 'SeguimientoController@seguimientoActualDelGestor');
        Route::get('/seguimientoActualDeUnaLinea/{id}/{nodo}', 'SeguimientoController@seguimientoActualDeLaLinea');

        Route::get('/seguimientoArticulacionesCerradasPorMes', 'SeguimientoController@seguimientoArticulacionesCerradas');
        Route::get('/seguimientoArticulacionesInscritasPorMes', 'SeguimientoController@seguimientoArticulacionesInscritas');
        Route::get('/seguimientoArticulacionDeUnNodoFases', 'SeguimientoController@seguimientoArticulacionesDelNodoFases');

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
    Route::get('/proyectos', 'MigracionController@proyectos')->name('migracion.proyectos');
    Route::get('/proyectos/caracterizacion', 'MigracionController@caracterizacion_proyectos')->name('migracion.proyectos.caracterizacion');
    Route::post('/importar', 'MigracionController@import')->name('migracion.proyectos.store');
});


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







