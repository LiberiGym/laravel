<?php

// Notificaciones Bitacora
Route::post('bitacoras/create', 'Admin\BitacorasController@create');
Route::any('bitacoras/edit/{id}/{title}', 'Admin\BitacorasController@edit');
Route::any('bitacoras/delete/{id}', 'Admin\BitacorasController@delete');
Route::post('bitacoras/upload', 'Admin\BitacorasController@upload');
Route::get('bitacoras', 'Admin\BitacorasController@index');
