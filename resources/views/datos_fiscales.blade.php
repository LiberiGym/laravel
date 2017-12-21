@extends('layout.layout')
@section('css')
<link href="css/registro.steps.css" type="text/css" rel="stylesheet">
<link href="/admin_assets/plugins/dropzone/dropzone.css" rel="stylesheet" />
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
                            <button type="button" class="btn btn-selected btn-circle">2</button>
                            <p class="title-selected">Datos Fiscales</p>
                            <hr/>
                        </div>
                        <div class="stepwizard-step">
                            <button type="button" class="btn btn-disabled btn-circle" disabled="disabled">3</button>
                            <p class="title">Datos Bancarios</p>
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
                <h1>Datos Fiscales <img src="images/barra_amarilla_banner_top.png" height="6" style="width:79px;"/></h1>
                <form action="/registro-datos-bancarios" class="form-registro" role="form" class="cmxform" method="post" id="frmDatos">
                    <fieldset class="col-lg-6">
                        <legend class="form-legend-registro">Datos de Propietario o Representante Legal</legend>



                        <input type="text" name="name" value="{{$user->name}}" placeholder="Nombre" class="form-registro-element" disabled>
                        <input type="text" name="last_name" value="{{$user->last_name}}" placeholder="Apellidos" class="form-registro-element" disabled>
                        <input type="text" name="phone" value="{{$user->phone}}" placeholder="Teléfono" class="form-registro-element" required="required" number="true">
                        <input type="text" name="email" value="{{$user->email}}" placeholder="Correo lectrónico" class="form-registro-element" disabled>

                        <legend class="form-legend-registro">Logotipo de la empresa:</legend>
                        <button type="button" name="button" class="form-button" id="divUploadImage">Seleccionar imágen</button>
                        <div class="clearfix"></div>
                        <div class="" id="divImages" style="margin-top:15px;">
                            <div style="margin-top:5px; height: 100px;">
                                <img src="files/gyms/{{$gym->gym_logo}}" style="height: 100px; width:auto;">
                            </div>
                        </div>

                        <legend class="form-legend-registro">Comprobante de registro de marca</legend>
                        <button type="button" name="button" class="form-button"  id="divUploadRegistro">Seleccionar imágen</button>
                        <div class="clearfix"></div>
                        <div class="" id="divImagesRegistro" style="margin-top:15px;">
                            <div style="margin-top:5px; height: 100px;">
                                @if($gym->gym_register!='')
                                <input type="checkbox" name="txtNameFileImage" value="{{$gym->gym_register}}" checked><label class="form-label-servicios" style="background: rgba(29,66,137,0.5);width: 100%; color:#fff;"><i class="fa fa-file-image-o" aria-hidden="true"></i> <span style="font-size:11px;">{{$gym->gym_register}}</span></label>
                                @endif
                        </div>
                        </div>


                        <div class="clearfix"></div>

                        <input id="Registro" name="changeLogo" type="checkbox" required="required" value="1"> <label for="Registro" class="form-label-servicios">Por cuestiones de derechos de Propiedad Intelectual te concedemos una prórroga hasta el 30 de junio de 2018 para cargar tu comprobante de registro de marca ante el IMPI. En caso de exceder esa fecha, concedes a LIBERI el derecho de sustituir el logotipo de tu empresa por una imagen genérica para evitar problemas legales.</label>


                    </fieldset>

                    <fieldset class="col-lg-6">
                        <legend class="form-legend-registro">Datos Fiscales</legend>
                        <input type="text" name="razon_social" value="{{$gym->razon_social}}" placeholder="Razón Social" class="form-registro-element" required="required">
                        <input type="text" name="rfc" value="{{$gym->rfc}}" placeholder="RFC" class="form-registro-element" required="required">
                        <input type="text" name="calle" value="{{$gym->calle}}" placeholder="Calle" class="form-registro-element" required="required">
                        <input type="text" name="no_ext" value="{{$gym->no_ext}}" placeholder="No. Ext." class="form-registro-element" required="required" >
                        <input type="text" name="no_int" value="{{$gym->no_int}}" placeholder="No. Int." class="form-registro-element">
                        <input type="text" name="colonia" value="{{$gym->colonia}}" placeholder="Colonia" class="form-registro-element" required="required">
                        <input type="text" name="cp" value="{{$gym->cp}}" placeholder="C.P." class="form-registro-element" required="required">
                        <input type="text" name="municipio" value="{{$gym->municipio}}" placeholder="Municipio" class="form-registro-element"  required="required">
                        <input type="text" name="ciudad" value="{{$gym->ciudad}}" placeholder="Ciudad" class="form-registro-element">
                        <input type="text" name="estado" value="{{$gym->estado}}" placeholder="Estado" class="form-registro-element" required="required">
                        <input type="text" name="pais" value="{{$gym->pais}}" placeholder="País" class="form-registro-element" required="required">

                        <button type="button" name="button" id="btnGuardar">Siguiente</button>
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
<script src="/admin_assets/plugins/dropzone/dropzone.js"></script>
<script src="/admin_assets/plugins/dropzone/uploader.js"></script>
<script>

$(document).ready(function () {

    //para subir logo
    uploader.add('divUploadImage', {
        url: '/register-upload-image',
        formData: {
            type: 'logo'
        }
    }, function(data){
        if(data.result == 'ok'){
            var addImage ='<div style="margin-top:5px; height: 100px;"><img src="files/gyms/'+data.file+'" style="height: 100px; width:auto;"></div>';
            $('#divImages').html(addImage);
        }
        if(data.result =='error_type'){
            swal('Cuidado','Solo puede subir imagenes en formato de tiff y jpg','warning');
        }
    });

    uploader.add('divUploadRegistro', {
        url: '/register-upload-image',
        formData: {
            type: 'registro'
        }
    }, function(data){
        if(data.result == 'ok'){
            var addImage ='<div style="margin-top:5px; height: 100px;">\
                <input type="checkbox" name="txtNameFileImage" value="'+data.file+'" checked><label class="form-label-servicios" style="background: rgba(29,66,137,0.5);width: 100%; color:#fff;"><i class="fa fa-file-image-o" aria-hidden="true"></i> <span style="font-size:11px;">'+data.file+'</span></label>\
            </div>';
            $('#divImagesRegistro').html(addImage);
        }
        if(data.result =='error_type'){
            swal('Cuidado','Solo puede subir formatos jpg, png o pdf','warning');
        }
    });

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

            if($("#Registro").is(':checked')){
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
