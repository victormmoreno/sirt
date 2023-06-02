<?php

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
