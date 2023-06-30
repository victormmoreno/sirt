<?php

Route::get('usoinfraestructura/export', 'Asesorie\UsoInfraestructuraController@export')->name('usoinfraestructura.export');

Route::group([
    'namespace'  => 'Asesorie',
    'middleware' => 'disablepreventback',
], function () {
    Route::resource('asesorias', 'UsoInfraestructuraController')->parameters([
        'asesorias' => 'id',
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
});
