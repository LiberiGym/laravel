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
Route::group(['prefix' => 'api'], function()
{
    //Route::prefix('api')->group(function(){
    /*Login Page*/
    Route::any('/user-login', 'Movil\UserAppController@userLogin');
    Route::any('/user-password-reset', 'Movil\UserAppController@userPasswordReset');

    /*RegistroPage*/
    Route::get('/load-states', 'Movil\UserAppController@loadStates');
    Route::get('/load-locations/{Id}', 'Movil\UserAppController@loadLocations');
    Route::post('/create-user', 'Movil\UserAppController@createUser');
    Route::any('/user-upload-image', 'Movil\UserAppController@userUploadImage');
    Route::post('/create-user-card', 'Movil\UserAppController@createUserCard');

    /*DatosPersonalesPage*/
    Route::post('/get-user', 'Movil\UserAppController@getUser');
    Route::post('/update-user', 'Movil\UserAppController@updateUser');

    /*DatosTarjetaPage*/
    Route::post('/update-user-addcard', 'Movil\UserAppController@updateUserAddCard');



});
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
