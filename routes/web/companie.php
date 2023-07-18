<?php

Route::get('/empresas/filter-code/{value}', 'EmpresaController@filterByCode')->name('empresa.filterbycode');
Route::get('/empresas/sede/{id}', 'EmpresaController@filterSede')->name('empresa.sede.filter');
Route::group(
    [
        'prefix'     => 'empresa',
        'middleware' => ['auth'],
    ],
    function () {
        Route::get('/', 'EmpresaController@index')->name('empresa');
        Route::get('/create', 'EmpresaController@create')->name('empresa.create');
        Route::get('/search', 'EmpresaController@search')->name('empresa.search');
        Route::get('/detalle/{id}', 'EmpresaController@detalle')->name('empresa.detalle');
        Route::get('/cambiar_responsable/{id}', 'EmpresaController@form_responsable')->name('empresa.responsable');
        Route::get('/datatableEmpresasDeTecnoparque', 'EmpresaController@datatableEmpresasDeTecnoparque')->name('empresa.datatable');
        Route::get('/{id}/edit', 'EmpresaController@edit')->name('empresa.edit');
        Route::get('/{id}/{id_sede}/sedes_edit', 'EmpresaController@sedes_edit')->name('empresa.edit.sedes');
        Route::get('/{id}/add_sede', 'EmpresaController@add_sede')->name('empresa.add.sede');
        Route::get('/ajaxDetallesDeUnaEmpresa/{value}/{field}', 'EmpresaController@ajaxDeUnaEmpresa')->name('empresa.ajax.detalle');
        Route::get('/ajaxDetalleDeUnaSede/{id}', 'EmpresaController@ajaxDeUnaSede')->name('empresa.ajax.detalle');
        Route::put('/{id}/responsable', 'EmpresaController@update_responsable')->name('empresa.update.responsable');
        Route::put('/{id}', 'EmpresaController@update')->name('empresa.update');
        Route::put('/{id}/store_sede', 'EmpresaController@store_sede')->name('empresa.store.sede');
        Route::put('/{id}/{id_sede}', 'EmpresaController@update_sede')->name('empresa.update.sede');
        Route::post('/buscar_empresas', 'EmpresaController@search_empresa')->name('empresa.search.rq');
        Route::post('/', 'EmpresaController@store')->name('empresa.store');
    }
);
