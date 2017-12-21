<?php

// Categorias
Route::post('categories/create', 'Admin\CategoriesController@create');
Route::any('categories/edit/{id}/{title}', 'Admin\CategoriesController@edit');
Route::any('categories/delete/{id}', 'Admin\CategoriesController@delete');
Route::post('categories/upload', 'Admin\CategoriesController@upload');
Route::get('categories', 'Admin\CategoriesController@index');
