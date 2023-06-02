<?php

Route::get('nodo/files/{nodo}', 'ArchivoController@datatableArchivesNodes')->name('nodo.files');
Route::post('nodo/files/{nodo}', 'ArchivoController@uploadFileNode')->name('nodo.files.upload');
Route::get('nodo/{nodo}/cargar-archivos',  'Nodo\NodoController@uploadFiles')->name('nodo.upload-files');
Route::get('nodo/downloadFile/{id}', 'ArchivoController@downloadFileNode')->name('nodo.files.download');

Route::delete('nodo/{idFile}/files', 'ArchivoController@destroyFileNode')->name('nodo.files.destroy');
Route::get('/nodo/fetch_data', 'Nodo\NodoController@nodo_pagination');
Route::resource('nodo', 'Nodo\NodoController')->middleware(['disablepreventback', 'role_session:Administrador|Activador|Dinamizador|Infocenter|Experto']);
