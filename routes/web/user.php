<?php

Route::group(
    [
        'prefix'     => 'usuarios',
        'namespace'  => 'User',
        'middleware' => 'disablepreventback',
    ],
    function () {
        /** route for get talentos and users in datatable */
        Route::get('/clientes', [
            'uses' => 'UserController@getCustomersDatatableFormat',
            'as'   => 'clientes',
        ]);
        /** route for get users by id */
        Route::get('/cliente/{id}', [
            'uses' => 'SearchUserController@findCustomerById',
            'as'   => 'user',
        ]);
        /** route for get users officers by id */
        Route::get('/funcionario/{id}', 'SearchUserController@findOfficialById');

        Route::get('/search', 'SearchUserController@userSearch')->name('usuario.search');
        Route::post('/search-user', [
            'uses' => 'SearchUserController@querySearchUser',
            'as'   => 'usuario.search.user',
        ])->where('documento', '[0-9]+');
        Route::get('/{documento}/permisos', 'ChangeRolesController@showRolesForm')->name('usuario.change-role-node')->where('documento', '[0-9]+');
        Route::put('/{documento}/permisos', 'ChangeRolesController@updateRoles')->name('usuario.update-role-node')->middleware('disablepreventback');
        Route::get('/{documento}/tomar-control', 'RolesPermissions@tomar_control')->name('usuario.tomar.control');
        Route::get('/dejar-control', 'RolesPermissions@dejar_control')->name('usuario.dejar.control');

        Route::get('/expertos/nodo/{id}', ['uses' => 'SearchUserController@findExpertsByNodo','as'   => 'usuario.gestores.nodo']);
        Route::get('/{documento}/acceso', 'UserController@access')->name('usuario.acceso')->where('documento', '[0-9]+');
        Route::put('/{id}/update-account', 'UserController@updateAccountUser')->name('usuario.updateaccount')->middleware('disablepreventback');
        Route::put('{documento}/acceso', 'UserController@updateAccess')->name('usuario.access')->middleware('disablepreventback');

    }
);

Route::get('usuarios/filtro-talento/{documento}', 'SearchUserController@findUserByDocument')->name('usuario.talento.search');
Route::resource('usuarios', 'User\UserController', ['as' => 'usuario', 'only' => ['index','show', 'edit']])->names([
            'index'   => 'usuario.index',
            'update'  => 'usuario.update',
            'show'    => 'usuario.show',
            'edit'    => 'usuario.edit',
        ])->parameters([
            'usuarios' => 'id',
        ]);

Route::get('usuarios/export', 'Excel\UserExportController@__invoque')->name('usuario.export');




