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
Route::get('/logout', 'Auth\LoginController@logout');

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
    Route::post('/user-get-cards', 'Movil\UserAppController@userGetCards');
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
    Route::post('/get-gym-info', 'Movil\UserAppController@getGymInfo');
    Route::post('/get-gym-info-mapa', 'Movil\UserAppController@getGymInfoMapa');

    /*ComprarSesionPage*/
    Route::post('/get-gym-comprar', 'Movil\UserAppController@getGymComprar');
    Route::post('/get-gym-registrar-compra', 'Movil\UserAppController@getGymRegistrarCompra');

    /*NotificacionesPage*/
    Route::post('/get-user-notifications', 'Movil\UserAppController@getUserNotifications');
    Route::post('/get-user-notifications-detalle', 'Movil\UserAppController@getUserNotificationsDetalle');
    Route::post('/get-user-notifications-confirm', 'Movil\UserAppController@getUserNotificationsConfirm');

    /*HistorialComprasPage*/
    Route::post('/get-user-purchases', 'Movil\UserAppController@getUserPurchases');

    /*HistorialComprasDetallePage*/
    Route::post('/get-user-purchase-detail', 'Movil\UserAppController@getUserPurchaseDetail');





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
Route::get('/open', 'OpenPayController@index');
Route::post('/processCharge', 'OpenPayController@processCharge');

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
Route::post('/perfil/usuario/delete','PerfilController@perfilUsuariosDelete');
Route::post('/perfil/usuario/select','PerfilController@perfilUsuariosSelect');
Route::post('/perfil/usuario/create','PerfilController@perfilUsuariosCreate');
Route::post('/perfil/usuario/upload/image','PerfilController@perfilUsuariosUploadImage');
Route::any('/perfil/reportes/comentarios','PerfilController@perfilReportesComentarios');
Route::any('/perfil/reportes/ventas','PerfilController@perfilReportesVentas');
Route::any('/perfil/reportes/servicio','PerfilController@perfilReportesServicio');
Route::post('/perfil/reportes/servicio/reportar','PerfilController@perfilReportesServicioReportar');

/*Route::any('/perfil/clientes','PerfilController@perfilClientes');
Route::any('/perfil/reportes','PerfilController@perfilReportes');*/

/*!--PERFIL GYM--*/

/*PERFIL ADMINISTRACION*/
Route::any('/administracion','PerfilController@adminInicio');
Route::any('/administracion/usuarios','PerfilController@adminUsuarios');
Route::post('/administracion/usuario/delete','PerfilController@adminUsuariosDelete');
Route::post('/administracion/usuario/select','PerfilController@adminUsuariosSelect');
Route::post('/administracion/usuario/create','PerfilController@adminUsuariosCreate');
Route::any('/administracion/ventas','PerfilController@adminReportesVentas');
Route::any('/administracion/notificaciones','PerfilController@adminReportesNotificaciones');
Route::post('/administracion/notificaciones/aceptar','PerfilController@adminReportesNotificacionesAceptar');
Route::post('/administracion/notificaciones/cancelar','PerfilController@adminReportesNotificacionesCancelar');
Route::any('/administracion/promociones','PerfilController@adminPromociones');
Route::post('/administracion/promociones/delete','PerfilController@adminPromocionesDelete');
Route::post('/administracion/promociones/select','PerfilController@adminPromocionesSelect');
Route::post('/administracion/promociones/create','PerfilController@adminPromocionesCreate');
Route::any('/administracion/clientes/gym/{id}','PerfilController@adminClientesGym');
Route::any('/administracion/clientes/gym/datos-fiscales/{id}','PerfilController@adminClientesGymDFis');
Route::any('/administracion/clientes/gym/datos-bancarios/{id}','PerfilController@adminClientesGymDBan');

/*!--PERFIL ADMINISTRACION--*/



Route::get('/registro-init', function()
{
    return redirect('/inicio');
});
Route::post('/register-load-locations','RegisterController@loadLocations');
Route::post('/register-upload-image','RegisterController@uploadGymImage');

/*PAGINA WEB*/
Route::get('/aviso-privacidad', function (){ return "Aviso de Privacidad";});
Route::get('/terminos-condiciones', function (){ return "Aviso de Privacidad";});
