<?php

Route::group(['prefix' => 'admin'], function()
{
    foreach(scandir(__DIR__) as $file)
    {
        if (strpos($file, '.php') !== false && $file != 'admin.php') require $file;
    }

    Route::get('/', 'Admin\DashboardController@index');
});
