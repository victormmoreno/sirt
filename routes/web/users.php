<?php

Route::group(
    [
        'prefix'     => 'usuarios',
        'namespace'  => 'User',
        'middleware' => 'disablepreventback',
    ],
    function () {
        Route::get('/talento/getTalentosDeTecnoparque', [
            'uses' => 'UserController@datatableTalentosDeTecnoparque',
            'as'   => 'talento.tecnoparque',
        ]);

        Route::get('/talento/consultarTalentoPorId/{id}', [
            'uses' => 'UserController@consultarUnUsuarioPorId',
            'as'   => 'talento.tecnoparque.byid',
        ]);

        Route::get('consultarUserPorId/{id}', 'UserController@findUserById');

        Route::put('{documento}/acceso', 'UserController@updateAccess')->name('usuario.access')->middleware('disablepreventback');


        Route::get('/gestores/nodo/{id}', [
            'uses' => 'UserController@gestoresByNodo',
            'as'   => 'usuario.gestores.nodo',
        ]);

        Route::post('/consultarusuario', [
            'uses' => 'UserController@querySearchUser',
            'as'   => 'usuario.buscarusuario',
        ])->where('documento', '[0-9]+');


        Route::get('/search', 'UserController@userSearch')->name('usuario.search');
        Route::get('/{documento}/permisos', 'UserController@changeNodeAndRole')->name('usuario.changenode')->where('documento', '[0-9]+');
        Route::put('/{documento}/permisos', 'UserController@updateNodeAndRole')->name('usuario.updatenodo')->middleware('disablepreventback');
        Route::get('/{documento}/acceso', 'UserController@access')->name('usuario.acceso')->where('documento', '[0-9]+');
        Route::get('/{id}/tomar-control', 'RolesPermissions@tomar_control')->name('usuario.tomar.control');
        Route::get('/dejar-control', 'RolesPermissions@dejar_control')->name('usuario.dejar.control');
        Route::put('/{id}/update-account', 'UserController@updateAccountUser')->name('usuario.updateaccount')->middleware('disablepreventback');
    }
);

Route::get('usuarios/filtro-talento/{documento}', 'User\UserController@filterTalento')->name('usuario.talento.search');
Route::resource('usuarios', 'User\UserController', ['as' => 'usuario', 'only' => ['index','show', 'edit']])->names([
            'index'   => 'usuario.index',
            'update'  => 'usuario.update',
            'show'    => 'usuario.show',
            'edit'    => 'usuario.edit',
        ])->parameters([
            'usuarios' => 'id',
        ]);

Route::get('usuarios/export', 'Excel\UserExportController@__invoque')->name('usuario.export');




