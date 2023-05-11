<?php
Route::group(
    [
        'prefix'     => 'usuarios',
        'middleware' => 'disablepreventback',
    ],
    function () {

        Route::get('/mistalentos', [
            'uses' => 'UserController@talentsList',
            'as'   => 'usuario.mytalentos',
        ]);
        Route::get('/talento/getTalentosDeTecnoparque', [
            'uses' => 'UserController@datatableTalentosDeTecnoparque',
            'as'   => 'talento.tecnoparque',
        ]);

        Route::get('/talento/consultarTalentoPorId/{id}', [
            'uses' => 'UserController@consultarUnUsuarioPorId',
            'as'   => 'talento.tecnoparque.byid',
        ]);

        Route::get('consultarUserPorId/{id}', 'UserController@findUserById');

        Route::get('/', [
            'uses' => 'UserController@index',
            'as'   => 'usuario.index',
        ]);
        Route::put('/updateacceso/{documento}', 'UserController@updateAccess')->name('usuario.usuarios.updateacceso')->middleware('disablepreventback');

        Route::get('/usuarios/crear/{documento?}', 'UserController@create')->name('usuario.usuarios.create')->where('documento', '[0-9]+');

        Route::get('/usuarios/gestores/nodo/{id}', [
            'uses' => 'UserController@gestoresByNodo',
            'as'   => 'usuario.gestores.nodo',
        ]);

        Route::post('/usuarios/consultarusuario', [
            'uses' => 'UserController@querySearchUser',
            'as'   => 'usuario.buscarusuario',
        ])->where('documento', '[0-9]+');


        Route::get('/usuarios', 'UserController@userSearch')->name('usuario.search');
        Route::get('/{documento}/permisos', 'UserController@changeNodeAndRole')->name('usuario.usuarios.changenode')->where('documento', '[0-9]+');
        Route::put('/{documento}/permisos', 'UserController@updateNodeAndRole')->name('usuario.usuarios.updatenodo')->middleware('disablepreventback');
        Route::get('acceso/{documento}', 'UserController@access')->name('usuarios.acceso')->where('documento', '[0-9]+');
        Route::get('tomar_control/{id}', 'RolesPermissions@tomar_control')->name('usuario.tomar.control');
        Route::get('dejar_control', 'RolesPermissions@dejar_control')->name('usuario.dejar.control');
        Route::put('/{id}/update-account', 'UserController@updateAccountUser')->name('usuario.usuarios.updateaccount')->middleware('disablepreventback');

    }
);

Route::get('usuarios/filtro-talento/{documento}', 'UserController@filterTalento')->name('articulacion.usuario.talento.search');


