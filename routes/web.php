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

    /*DatosTarjetaPage*/
    Route::post('/get-terminoscondiciones', 'Movil\UserAppController@getTerminosCondiciones');

    /*PreferenciasPage*/
    Route::post('/get-preferencias', 'Movil\UserAppController@getPreferencias');
    Route::post('/update-user-preferencias', 'Movil\UserAppController@updateUserPreferencias');

    /*MapaPage*/
    Route::post('/get-location-gyms', 'Movil\UserAppController@getLocationGyms');

    /*AyudaPage*/
    Route::post('/ayuda', 'Movil\UserAppController@ayudaApp');

    /*NegocioDetallePage*/
    Route::post('/get-gym-gallery', 'Movil\UserAppController@getGymGallery');
    Route::post('/get-gym-video', 'Movil\UserAppController@getGymVideo');





});
/*!--ACCESOS APP--*/

/*AyudaPage - Tutoriales*/
Route::get('/tutoriales/{id}', function () {
    return view('tutoriales');
});

/*WEB APP*/
Route::get('/', function () {
    return redirect('/inicio');
});

Route::get('/inicio', 'HomeController@index');

Route::get('/nosotros', function () {
    return view('front.web.nosotros');
});

/*formulario de contacto*/
Route::get('/contacto', function () {
    return view('emails.contacto');
});
Route::post('/send-contacto', 'LayoutController@sendContacto');




/*!--WEB APP--*/


/*PROCESO DE REGISTRO*/

/*registro inicial*/
Route::post('/registro-init','RegisterController@initRegister');

/*registro datos generales*/
Route::any('/registro-generales','RegisterController@registerGrales');
Route::post('/registro-create-datosgrales','RegisterController@registerGralesCreate');

/*registro datos fiscales*/
Route::any('/registro-datos-fiscales','RegisterController@registerDFiscales');
Route::post('/registro-create-datosfiscales','RegisterController@registerDFiscalesCreate');

/*registro datos bancarios*/
Route::any('/registro-datos-bancarios','RegisterController@registerDBancarios');
Route::post('/registro-create-datosbancarios','RegisterController@registerDBancariosCreate');

/*registro finalizar*/
Route::any('/registro-finalizar','RegisterController@registerFinalizar');

/*!--PROCESO DE REGISTRO--*/

/*PERFIL GYM*/
/*Perfil Usuario*/
Route::post('/login','PerfilController@loginUser');

Route::post('/perfil-delete-image','PerfilController@perfilDeleteImage');

Route::any('/perfil','PerfilController@perfilInicio');
Route::any('/perfil/datos-fiscales','PerfilController@perfilDFiscales');
Route::any('/perfil/datos-bancarios','PerfilController@perfilDBancarios');
Route::any('/perfil/usuarios','PerfilController@perfilUsuarios');
Route::any('/perfil/clientes','PerfilController@perfilClientes');
Route::any('/perfil/reportes','PerfilController@perfilReportes');

/*!--PERFIL GYM--*/



Route::get('/registro-init', function()
{
    return redirect('/inicio');
});
Route::post('/register-load-locations','RegisterController@loadLocations');
Route::post('/register-upload-image','RegisterController@uploadGymImage');
