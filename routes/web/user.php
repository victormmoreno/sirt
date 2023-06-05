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
            'uses' => 'SearchUserController@consultarUnUsuarioPorId',
            'as'   => 'talento.tecnoparque.byid',
        ]);
        /** todo */
        Route::get('consultarUserPorId/{id}', 'UserController@findUserById');
        Route::put('{documento}/acceso', 'UserController@updateAccess')->name('usuario.access')->middleware('disablepreventback');
        Route::get('/gestores/nodo/{id}', ['uses' => 'UserController@gestoresByNodo','as'   => 'usuario.gestores.nodo']);
        Route::get('/search', 'SearchUserController@userSearch')->name('usuario.search');
        Route::post('/search-user', [
            'uses' => 'SearchUserController@querySearchUser',
            'as'   => 'usuario.search.user',
        ])->where('documento', '[0-9]+');
        Route::get('/{documento}/permisos', 'ChangeRolesController@showRolesForm')->name('usuario.change-role-node')->where('documento', '[0-9]+');
        Route::put('/{documento}/permisos', 'ChangeRolesController@updateRoles')->name('usuario.update-role-node')->middleware('disablepreventback');
        Route::get('/{documento}/acceso', 'UserController@access')->name('usuario.acceso')->where('documento', '[0-9]+');
        Route::get('/{documento}/tomar-control', 'RolesPermissions@tomar_control')->name('usuario.tomar.control');
        Route::get('/dejar-control', 'RolesPermissions@dejar_control')->name('usuario.dejar.control');
        Route::put('/{id}/update-account', 'UserController@updateAccountUser')->name('usuario.updateaccount')->middleware('disablepreventback');
    }
);
/**todo */
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




