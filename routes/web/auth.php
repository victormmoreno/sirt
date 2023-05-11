
<?php

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('registro', 'Auth\RegisterController@showRegistrationForm')->name('registro');
Route::post('registro', 'Auth\RegisterController@register')->name('register.request');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');


//verificar usuario no registrado
Route::post('user/verify', 'Auth\UnregisteredUserVerificationController@verificationUser')->name('user.verify');

//Change Email Routes...
Route::get('email/reset', 'Auth\ChangeEmailController@showEmailChangeRequestForm')->name('email.request');
Route::post('email/send', 'Auth\ChangeEmailController@sendEmailChange')->name('email.send');

Route::post('cambiar-role', 'User\RolesPermissions@changeRoleSession')->name('user.changerole')->middleware('disablepreventback');

//profile
Route::group(
    [
        'prefix'     => 'perfil',
        'middleware' => 'disablepreventback',
        'namespace'  => 'User'
    ],
    function () {
        Route::get('certificado', 'ProfileController@downloadCertificatedPlataform')->name('certificado');
        Route::get('cuenta', 'ProfileController@account')->name('perfil.account');
        Route::get('perfil', 'ProfileController@index')->name('perfil.index');
        Route::get('roles', 'ProfileController@roles')->name('perfil.roles');
        Route::put('password', 'ProfileController@updatePassword')->name('perfil.password');
        Route::get('password/reset', 'ProfileController@passwordReset')->name('perfil.password.reset');
        Route::get('editar', 'ProfileController@editAccount')->name('perfil.edit');
});

Route::resource('perfil', 'User\ProfileController', ['only' => ['update', 'destroy']])->middleware('disablepreventback');
