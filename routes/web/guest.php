<?php

Route::get('/', function () {
    return view('welcome');
})->name('/');

Route::get('creditos', function () {
    return view('configuracion.creditos');
})->name('creditos');

Route::get('politica-de-confidencialidad', function () {
    return view('seguridad.terminos');
})->name('terminos');
