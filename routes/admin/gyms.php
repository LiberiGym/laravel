<?php

// Gimnasios
Route::post('gyms/create', 'Admin\GymsController@create');
Route::any('gyms/edit/{id}/{title}', 'Admin\GymsController@edit');
Route::any('gyms/delete/{id}', 'Admin\GymsController@delete');
Route::post('gyms/upload', 'Admin\GymsController@upload');
Route::get('gyms', 'Admin\GymsController@index');
