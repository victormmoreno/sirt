
<?php

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::put('usuario/confirm/{documento}', 'Auth\RegisterController@confirmContratorInformation')->name('user.contractor.confirm');
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

Route::post('cambiar-role', 'User\RolesPermissions@changeRoleSession')
    ->name('user.changerole')
    ->middleware('disablepreventback');
