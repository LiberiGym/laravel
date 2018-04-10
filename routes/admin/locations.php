<?php

// Municipios
Route::post('locations/create', 'Admin\LocationsController@create');
Route::any('locations/edit/{id}/{title}', 'Admin\LocationsController@edit');
Route::any('locations/delete/{id}', 'Admin\LocationsController@delete');
Route::post('locations/upload', 'Admin\LocationsController@upload');
Route::get('locations', 'Admin\LocationsController@index');
