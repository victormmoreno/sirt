<?php

Route::get('asesorias/exportar', 'Asesorie\AsesorieController@export')->name('usoinfraestructura.export');

Route::group([
    'namespace'  => 'Asesorie',
    'middleware' => 'disablepreventback',
], function () {

    Route::get('asesorias', 'AsesorieController@index')->name('asesorias.index');
    Route::get('/asesorias/search', 'AsesorieSearchController@showFormSearch')->name('asesorias.search');
    Route::get('/asesorias/indicadores', 'AsesorieIndicatorController@showIndicadores')->name('asesorias.indicadores');
    Route::get('/asesorias/indicadores/search', 'AsesorieIndicatorController@getDetallesAsesoria')->name('asesorias.indicadores.search');
    Route::get('/equipo/indicadores/search', 'AsesorieIndicatorController@getDetallesEquipo')->name('equipo.indicadores.search');
    Route::get('/material/indicadores/search', 'AsesorieIndicatorController@getDetallesMaterial')->name('material.indicadores.search');

    Route::get('/asesorias/crear', 'AsesorieRegisterController@showForm')->name('asesorias.create');
    Route::get('/asesorias/datatable_filtros', 'AsesorieController@datatableFiltros')->name('asesorias.datatable.filtros');

    Route::get('/asesorias/projects', 'AsesorieSearchController@projectsForUser')->name('asesorias.projects');
    Route::get('/asesorias/articulaciones', 'AsesorieSearchController@articulationsForUser')->name('asesorias.articulacionesforuser');
    Route::get('asesorias/ideas', 'AsesorieSearchController@ideasForNode')->name('asesorias.ideas');

    Route::get('/asesorias/talentosporproyecto/{id}', 'AsesorieSearchController@talentosPorProyecto')->name('asesorias.talentosporproyecto');
    Route::get('/asesorias/talentosporarticulacion/{id}', 'AsesorieSearchController@talentosPorArticulacion')->name('asesorias.talentosporarticulacion');
    Route::get('/asesorias/idea/{id}', 'AsesorieSearchController@infoidea')->name('asesorias.idea');



    Route::post('asesorias/search', [
        'uses' => 'AsesorieSearchController@queryAsesorieSearch',
        'as'   => 'asesorie.search',
    ]);

    Route::post('/asesorias', 'AsesorieRegisterController@store')->name('asesorias.store');
    Route::get('asesorias/{code}', 'AsesorieController@show')->name('asesorias.show');
    Route::get('asesorias/{code}/editar', 'AsesorieRegisterController@edit')->name('asesorias.edit');
    Route::put('asesorias/{id}', 'AsesorieRegisterController@update')->name('asesorias.update');
    Route::post('/asesorias/costos', 'AsesorieIndicatorController@getCostoProyecto')->name('asesorias.get_costos');
    Route::delete('asesorias/{id}', 'AsesorieController@destroy')->name('asesorias.destroy');

});
