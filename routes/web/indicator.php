<?php
/**
 * Route group para el módulo de indicadores
 */
Route::group(
    [
        'prefix' => 'indicadores',
        'middleware' => ['auth', 'role_session:Auxiliar|Administrador|Activador|Dinamizador|Experto|Articulador|Infocenter']
    ],
    function () {
        Route::get('/', 'IndicadorController@index')->name('indicadores');
        Route::get('/export_metas', 'Excel\IndicadorController@download_metas')->name('download.metas');
        // Route::get('/nodo/fetch_data', 'IndicadorController@nodo_pagination')->name('indicadores.paginar');

    }
);