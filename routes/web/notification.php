<?php

Route::get('/notificaciones', 'NotificationsController@index')
    ->name('notifications.index')
    ->middleware('disablepreventback');
Route::patch('/notificaciones/{notification}', 'NotificationsController@read')
    ->name('notifications.read')
    ->middleware('disablepreventback');
Route::delete('/notificaciones/{notification}', 'NotificationsController@destroy')
    ->name('notifications.destroy')
    ->middleware('disablepreventback');
