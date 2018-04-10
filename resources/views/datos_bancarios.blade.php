@extends('layout.layout')
@section('css')
<link href="css/registro.steps.css" type="text/css" rel="stylesheet">
<link href="/admin_assets/css/base/theme/custom.css" rel="stylesheet" id="theme" />
@endsection
@section('content')
<!-- about -->
<div class="jarallax agileits-registro agile-section-about-detail" id="aboutUs">
    <div class="container">
        <div class="row" style="margin-bottom:40px;">
            <div class="col-lg-12">
                <div class="stepwizard">
                    <div class="stepwizard-row">
                        <div class="stepwizard-step">
                            <button type="button" class="btn btn-disabled btn-circle"  disabled="disabled">1</button>
                            <p class="title">Registro</p>
                            <hr/>
                        </div>
                        <div class="stepwizard-step">
                            <button type="button" class="btn btn-disabled btn-circle">2</button>
                            <p class="title">Datos Fiscales</p>
                            <hr/>
                        </div>
                        <div class="stepwizard-step">
                            <button type="button" class="btn btn-selected btn-circle" disabled="disabled">3</button>
                            <p class="title-selected">Datos Bancarios</p>
                            <hr/>
                        </div>
                        <div class="stepwizard-step">
                            <button type="button" class="btn btn-disabled btn-circle" disabled="disabled">4</button>
                            <p class="title">Finalización de Registro</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="w3agile-about w3agile-about-detail">

            <div class="col-lg-3">
                <img src="images/registro_01_image.png" alt="">

            </div>
            <div class="col-lg-9">
                <h1>Datos Bancarios <img src="images/barra_amarilla_banner_top.png" height="6" style="width:79px;"/></h1>
                <form action="/registro-finalizar" class="form-registro" role="form" class="cmxform" method="post" id="frmDatos">
                    <fieldset class="col-lg-6">

                        <input type="text" name="cta_titular" value="{{$gym->cta_titular}}" placeholder="Nombre Titular de la Cuenta" class="form-registro-element" required="required">
                        <input type="text" name="cta_numero" value="{{$gym->cta_numero}}" placeholder="Número de Cuenta" class="form-registro-element" required="required">
                        <input type="text" name="cta_clabe" value="{{$gym->cta_clabe}}" placeholder="Clabe Interbancaria" class="form-registro-element" required="required">
                        <input type="text" name="cta_banco" value="{{$gym->cta_banco}}" placeholder="Banco" class="form-registro-element" required="required">
                        <input type="text" name="cta_pais" value="{{$gym->cta_pais}}" placeholder="País" class="form-registro-element" required="required">

                        <input id="terminosCond" name="terminos_condiciones" type="checkbox" > <label for="terminosCond" class="form-label-servicios">Acepto los <a href="#">Términos y Condiciones</a></label>
                        <button type="button" name="button"  id="btnGuardar">Finalizar</button>
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

            if($("#terminosCond").is(':checked')){
                form.submit();
                console.log('form.submit()');
            }else{
                swal('Cuidado','Debe seleccionar la casilla de verificación','warning');
            }
        }
    });



});

</script>
@endsection
