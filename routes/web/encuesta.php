<?php
//Route group para el módulo de encuesta
Route::group(

    [
        'prefix'     => 'encuesta',
        'middleware' => [
            // 'auth',
        // 'role_session:Articulador|Activador|Dinamizador|Experto|Talento|Infocenter'
    ],
    ],
    function () {
        Route::get('/', 'Encuesta\EncuestaController@index')->name('encuesta.index');
        Route::get('/create', 'Encuesta\EncuestaController@create')->name('encuesta.create');

        Route::get('/{module}/{id}', 'Encuesta\EnvioEncuestaController@enviarLinkEncuesta')->name('encuesta.link')->middleware(['auth', 'role_session:Experto|Articulador']);
        Route::get('/{module}/{id}/{token}', 'Encuesta\EncuestaController@mostrarFormularioEncuesta')->name('encuesta.formulario');

    }
);
