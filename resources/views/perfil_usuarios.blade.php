@extends('layout.layout')
@section('css')
<link href="css/registro.steps.css" type="text/css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/jquery.timepicker.css" />

<link href="/admin_assets/plugins/dropzone/dropzone.css" rel="stylesheet" />
<link href="/admin_assets/css/base/theme/custom.css" rel="stylesheet" id="theme" />

<link href="css/perfil.css" rel="stylesheet" id="theme" />


@endsection
@section('content')

<!-- about -->
<div class="jarallax agileits-registro agile-section-about-detail" id="aboutUs">
    <div class="container">

        <div class="w3agile-about w3agile-about-detail">

            <div class="col-lg-3">
                <div class="logo-perfil" align="center">
                    @if($gym->gym_logo!='default.png' || $gym->gym_logo!='')
                    <img src="files/gyms/{{$gym->gym_logo}}" alt="" style="height: 100px; width:auto; text-aling:center;">
                    @endif
                </div>
                <hr class="hr-nav-perfil">
                <ul class="nav-perfil">
                    <li><a href="/perfil-inicio">Inicio <span><i class="fa fa-angle-right" aria-hidden="true"></i></span></a></li>
                    <li class="active"><a href="perfil-usuarios">Usuarios <span><i class="fa fa-angle-right" aria-hidden="true"></i></span></a></li>
                    <li><a href="perfil-datos-cuenta">Datos de Cuenta <span><i class="fa fa-angle-right" aria-hidden="true"></i></span></a></li>
                    <li><a href="perfil-clientes">Clientes <span><i class="fa fa-angle-right" aria-hidden="true"></i></span></a></li>
                    <li><a href="perfil-reportes">Reportes <span><i class="fa fa-angle-right" aria-hidden="true"></i></span></a></li>
                </ul>
                <button type="button" name="button" id="btnCerrarSesion" class="cerrar-session">Cerrar Sesión</button>

            </div>
            <div class="col-lg-9">
                <h1>Registro de usuario <img src="images/barra_amarilla_banner_top.png" height="6" style="width:79px;"/></h1>
                <p>Alta de usuarios para control interno de aplicación.</p>
                <form action="/perfil-inicio" class="form-registro" role="form" class="cmxform" method="post" id="frmDatos">
                    <input type="hidden" name="editInfo" value="1">
                    <fieldset class="col-lg-6">
                        <input type="text" name="user_name"  placeholder="Nombre Completo" class="form-registro-element" required="required" value="">
                        <input type="text" name="user_nick"  placeholder="Usuario" class="form-registro-element" required="required" number="true" value="">
                        <input type="text" name="user_password"  placeholder="Contraseña" class="form-registro-element" required="required" number="true" value="">
                        <input type="text" name="user_passwordrepeate"  placeholder="Repertir contrasseña" class="form-registro-element" required="required" number="true" value="">
                        <div class="clearfix"></div>

                        <div class="col-lg-5">
                            <div class="photo-usuario" align="center">
                                {{-- @if($gym->gym_logo!='default.png' || $gym->gym_logo!='')
                                <img src="files/gyms/{{$gym->gym_logo}}" alt="" style="height: 100px; width:auto; text-aling:center;">
                                @endif --}}
                            </div>
                            <button type="button" id="btnDeleteImage"  name="button" class="delete-image" style="width: 100%;">Eliminar imágen</button>
                        </div>
                        <div class="col-lg-7">
                            <button type="button" id="divUploadImage"  name="button" class="form-button" style="width: 100%;">Seleccionar imágen</button>
                        </div>






                    </fieldset>

                    <fieldset class="col-lg-6">


                        <div class="clearfix"></div>

                        <legend class="form-legend-registro">Subir imágenes de la Empresa</legend>
                        <p style="font-style: italic;margin-bottom: 0;">Máximo 10</p>

                        <div class="clearfix"></div>
                        <div class="" id="divImages" style="margin-top:15px;">

                        </div>




                        <div class="clearfix"></div>

                        <button type="guardar" name="button" id="btnGuardar">Guardar</button>
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
<script type="text/javascript" src="js/jquery.timepicker.js"></script>
<script src="/admin_assets/plugins/dropzone/dropzone.js"></script>
<script src="/admin_assets/plugins/dropzone/uploader.js"></script>

<script>
$(document).ready(function () {
    var arrImages = [];





    //subir image

    uploader.add('divUploadImage', {
        url: '/register-upload-image',
        formData: {
            type: 'images'
        }
    }, function(data){
        if(data.result == 'ok'){
            var addImage ='<div style="margin-top:5px; background:url(files/gyms/'+data.file+'); height: 31px;">\
                <input type="checkbox" name="txtNameFileImage" value="'+data.file+'" checked><label class="form-label-servicios" style="background: rgba(29,66,137,0.5);width: 100%; color:#fff;"><i class="fa fa-file-image-o" aria-hidden="true"></i> <span style="font-size:11px;">'+data.file+'</span></label>\
            </div>';
            $('#divImages').append(addImage);
            countImage++;
            if(countImage==10){
                $('#divUploadImage').fadeOut();
            }
        }
        if(data.result =='error_type'){
            swal('Cuidado','Solo puede subir imagenes en formato de tiff y jpg','warning');
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

            var _diasSelected = false;
            var _serviceSelected = false;

            $('.diasSemana').each(
                function() {
                    if($(this).is(':checked')){
                        _diasSelected = true;
                        console.log('Dias seleccionados: '+_diasSelected);
                    }
                }
            );

            $('.servicioGym').each(
                function() {
                    if($(this).is(':checked')){
                        _serviceSelected = true;
                        console.log('Servicios seleccionados: '+_serviceSelected);
                    }
                }
            );

            if(_diasSelected && _serviceSelected){
                swal({
                    type: 'success',
                    title: 'Guardando sus cambios',
                    showConfirmButton: false
                })
                form.submit();
                console.log('form.submit()');
            }else{
                swal('Cuidado','Debe seleccionar los días en los que opera y almenos un tipo de servicio','warning');
            }
        }
    });

    $("#btnCerrarSesion").on('click', function(){
        swal({
            title: 'Cerrar Sesión',
            text: "¿Deseas cerrar tu sesión?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText: 'No'
            }).then((result) => {
                if (result.value) {
                    window.location.href="/logout";
                }
            });
    });



});

</script>
@endsection
