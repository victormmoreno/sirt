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
        Route::get('/{module}/{id}', 'Encuesta\EnvioEncuestaController@enviarLinkEncuesta')->name('encuesta.link');

        Route::get('/{module}/{id}/{token}', 'Encuesta\EncuestaController@mostrarFormularioEncuesta')->name('encuesta.formulario');
        // ->middleware('role_session:Experto');
    }
);
