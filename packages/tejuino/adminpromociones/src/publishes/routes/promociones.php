<?php

// Promociones
Route::post('promociones/create', 'Admin\PromocionesController@create');
Route::any('promociones/edit/{id}/{title}', 'Admin\PromocionesController@edit');
Route::any('promociones/delete/{id}', 'Admin\PromocionesController@delete');
Route::post('promociones/upload', 'Admin\PromocionesController@upload');
Route::get('promociones', 'Admin\PromocionesController@index');
