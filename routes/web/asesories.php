<?php

Route::get('asesorias/exportar', 'Asesorie\AsesorieController@export')->name('usoinfraestructura.export');

Route::group([
    'namespace'  => 'Asesorie',
    'middleware' => 'disablepreventback',
], function () {
    Route::get('asesorias', 'AsesorieController@index')->name('asesorias.index');
    Route::get('/asesorias/search', 'AsesorieSearchController@showFormSearch')->name('asesorias.search');
    Route::post('asesorias/search', [
        'uses' => 'AsesorieSearchController@queryAsesorieSearch',
        'as'   => 'asesorie.search',
    ]);
    Route::get('/asesorias/datatable_filtros', 'AsesorieController@datatableFiltros')->name('asesorias.datatable.filtros');
    Route::get('asesorias/{code}', 'AsesorieController@show')->name('asesorias.show');
    Route::get('asesorias/{code}/editar', 'AsesorieController@edit')->name('asesorias.edit');
    Route::get('asesorias/crear', 'AsesorieRegisterController@showForm')->name('asesorias.create');
    Route::post('asesorias', 'AsesorieRegisterController@store')->name('asesorias.store');
    // Route::resource('asesorias', 'UsoInfraestructuraController')->parameters([
    //     'asesorias' => 'id',
    // ]);

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
});
