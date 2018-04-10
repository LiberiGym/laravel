<?php

// Estados
Route::post('states/create', 'Admin\StatesController@create');
Route::any('states/edit/{id}/{title}', 'Admin\StatesController@edit');
Route::any('states/delete/{id}', 'Admin\StatesController@delete');
Route::post('states/upload', 'Admin\StatesController@upload');
Route::get('states', 'Admin\StatesController@index');
