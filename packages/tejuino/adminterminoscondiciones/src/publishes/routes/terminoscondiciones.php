<?php

// Terminos y Condiciones
Route::post('terminoscondiciones/create', 'Admin\TerminoscondicionesController@create');
Route::any('terminoscondiciones/edit/{id}/{title}', 'Admin\TerminoscondicionesController@edit');
Route::any('terminoscondiciones/delete/{id}', 'Admin\TerminoscondicionesController@delete');
Route::post('terminoscondiciones/upload', 'Admin\TerminoscondicionesController@upload');
Route::get('terminoscondiciones', 'Admin\TerminoscondicionesController@index');
