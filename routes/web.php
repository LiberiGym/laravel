<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
require('admin/admin.php');
Auth::routes();
Route::get('logout', 'Auth\LoginController@logout');

/*ACCESOS APP*/
Route::get('/load-states', 'UserAppController@loadStates');
/*!--ACCESOS APP--*/

Route::get('/', function () {
    return redirect('/inicio');
});

Route::get('/inicio', 'HomeController@index');

Route::get('/nosotros', function () {
    return view('nosotros');
});

/*proceso registro*/
Route::post('/registro-init','RegisterController@initRegister');
Route::get('/registro-init', function()
{
    return redirect('/inicio');
});
Route::post('/register-load-locations','RegisterController@loadLocations');
Route::post('/register-upload-image','RegisterController@uploadGymImage');
Route::post('/registro-datos-fiscales','RegisterController@DatosGralesRegister');
Route::post('/registro-datos-bancarios','RegisterController@DatosFisRegister');
Route::post('/registro-finalizar','RegisterController@DatosBancariosRegister');

/*Perfil Usuario*/
Route::post('/login','PerfilController@loginUser');
Route::any('/perfil-inicio','PerfilController@perfilInicio');
Route::post('/perfil-delete-image','PerfilController@perfilDeleteImage');
Route::any('/perfil-usuarios','PerfilController@perfilUsuarios');

/*formulario de contacto*/
Route::post('/send-contacto', 'LayoutController@sendContacto');


Route::get('/contacto', function () {
    return view('emails.contacto');
});
