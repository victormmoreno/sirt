<?php
//Route group para el módulo de proyectos
Route::group(

    [
        'prefix'     => 'proyecto',
        'middleware' => ['auth', 'role_session:Articulador|Activador|Dinamizador|Experto|Talento|Infocenter'],
    ],
    function () {
        Route::get('/notificar_inicio/{id}/{fase}', 'ProyectoController@solicitar_aprobacion')->name('proyecto.solicitar.aprobacion')->middleware('role_session:Experto');
        // Route::get('/informacion-proyecto/{id}', 'ProyectoController@informacionProyectoById')->name('proyecto.informacion')->middleware('role_session:Experto|Dinamizador|Talento|Activador');
        Route::get('/', 'ProyectoController@index')->name('proyecto');
        Route::get('/consultarProyectos_costos/{anho}', 'ProyectoController@proyectosCostos')->name('proyecto.costos')->middleware('role_session:Dinamizador|Experto');
        Route::get('/create', 'ProyectoController@create')->name('proyecto.create')->middleware('role_session:Experto');
        Route::get('/sublineas_of/{id}', 'ProyectoController@consultarSublineas')->name('proyecto.sublineas');
        Route::get('/datatableproyectosfinalizados', 'ProyectoController@datatableProyectosFinalizados')->name('proyecto.datatable.finalizados');
        Route::get('/consultarHorasExpertos/{id}', 'ProyectoController@consultarHorasDeExpertos')->name('proyecto.horas.expertos');

        Route::get('/datatableEmpresasTecnoparque', 'ProyectoController@datatableEmpresasTecnoparque')->name('proyecto.datatable.empresas')->middleware('role_session:Talento');
        Route::get('/datatableGruposInvestigacionTecnoparque/{tipo}', 'ProyectoController@datatableGruposInvestigacionTecnoparque')->name('proyecto.datatable.grupos');
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
        Route::get('/limite-planeacion/{nodo}/{experto}', 'ProyectoController@proyectosLimitePlaneacion')->name('proyecto.limite.planeacion');

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