@extends('front.layout.layout_registro')
@section('css')
<link href="/css/registro.steps.css" type="text/css" rel="stylesheet">
<link href="/admin_assets/css/base/theme/custom.css" rel="stylesheet" id="theme" />

<link href="/css/perfil.css" rel="stylesheet" id="theme" />
@endsection
@section('content')
<!-- about -->
<div class="jarallax agileits-registro agile-section-about-detail" id="aboutUs">
    <div class="container">

        <div class="w3agile-about w3agile-about-detail">

            <div class="col-lg-3">
                <div class="logo-perfil" align="center">
                    @if($gym->gym_logo!='default.png' || $gym->gym_logo!='')
                    <img src="/files/gyms/{{$gym->gym_logo}}" alt="" style="height: 100px; width:auto; text-aling:center;">
                    @endif
                </div>
                <hr class="hr-nav-perfil">
                <ul class="nav-perfil">
                    <li><a href="/perfil">Inicio <span><i class="fa fa-angle-right" aria-hidden="true"></i></span></a></li>
                    <li><a href="/perfil/datos-fiscales">Datos Fiscales <span><i class="fa fa-angle-right" aria-hidden="true"></i></span></a></li>
                    <li class="active"><a href="/perfil/datos-bancarios">Datos Bancarios <span><i class="fa fa-angle-right" aria-hidden="true"></i></span></a></li>
                    <li><a href="/perfil/usuarios">Usuarios <span><i class="fa fa-angle-right" aria-hidden="true"></i></span></a></li>
                    <li><a href="/perfil/clientes">Clientes <span><i class="fa fa-angle-right" aria-hidden="true"></i></span></a></li>
                    <li><a href="/perfil/reportes">Reportes <span><i class="fa fa-angle-right" aria-hidden="true"></i></span></a></li>
                </ul>
                <button type="button" name="button" id="btnCerrarSesion" class="cerrar-session">Cerrar Sesión</button>

            </div>
            <div class="col-lg-9">
                <h1 style="margin-bottom: 45px;">Datos Bancarios <img src="/images/barra_amarilla_banner_top.png" height="6" style="width:79px;"/></h1>
                <form action="/perfil/datos-bancarios" class="form-registro" role="form" class="cmxform" method="post" id="frmDatos">
                    <input type="hidden" name="editInfo" value="1">
                    <fieldset class="col-lg-6">

                        <input type="text" name="cta_titular" value="{{$gym->cta_titular}}" placeholder="Nombre Titular de la Cuenta" class="form-registro-element" required="required">
                        <input type="text" name="cta_numero" value="{{$gym->cta_numero}}" placeholder="Número de Cuenta" class="form-registro-element" required="required">
                        <input type="text" name="cta_clabe" value="{{$gym->cta_clabe}}" placeholder="Clabe Interbancaria" class="form-registro-element" required="required">
                        <input type="text" name="cta_banco" value="{{$gym->cta_banco}}" placeholder="Banco" class="form-registro-element" required="required">
                        <input type="text" name="cta_pais" value="{{$gym->cta_pais}}" placeholder="País" class="form-registro-element" required="required">

                        <button type="button" name="button"  id="btnGuardar">Guardar</button>
                    </fieldset>
                </form>

            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!-- //about -->
@endsection
@section('js')
<script>

$(document).ready(function () {
    //form registro
    $("#frmDatos").on("click", "#btnGuardar", function(event){
        var form = $("#frmDatos");

        form.validate({
            errorPlacement: function errorPlacement(error, element) {
                element.after(error);
            },
        });

        if( form.valid() ){
            event.preventDefault();//Eliminar el evento del submit del botón

            var _registroSelected = false;

            form.submit();
            console.log('form.submit()');

            /*if($("#terminosCond").is(':checked')){
                form.submit();
                console.log('form.submit()');
            }else{
                swal('Cuidado','Debe seleccionar la casilla de verificación','warning');
            }*/
        }
    });



});

</script>
@endsection
