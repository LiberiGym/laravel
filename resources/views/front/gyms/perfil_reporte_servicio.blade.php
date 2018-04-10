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
                    <li><a href="/perfil/datos-bancarios">Datos Bancarios <span><i class="fa fa-angle-right" aria-hidden="true"></i></span></a></li>
                    <li><a href="/perfil/usuarios">Usuarios <span><i class="fa fa-angle-right" aria-hidden="true"></i></span></a></li>
                    <li><a href="#">Reportes <span><i class="fa fa-angle-right" aria-hidden="true"></i></span></a>
                        <ul style="margin-left: 30px;margin-top: 25px;">
                            <li><a href="/perfil/reportes/comentarios">Comentarios <span><i class="fa fa-angle-right" aria-hidden="true"></i></span></a></li>
                            <li><a href="/perfil/reportes/ventas">Ventas <span><i class="fa fa-angle-right" aria-hidden="true"></i></span></a></li>
                            <li class="active"><a href="/perfil/reportes/servicio">Mal Uso de Servicio <span><i class="fa fa-angle-right" aria-hidden="true"></i></span></a></li>
                        </ul>
                    </li>
                </ul>
                <button type="button" name="button" id="btnCerrarSesion" class="cerrar-session">Cerrar Sesión</button>

            </div>
            <div class="col-lg-9">
                <h1 style="margin-bottom: 45px;">Reporte de Mal Uso del Servicio <img src="/images/barra_amarilla_banner_top.png" height="6" style="width:79px;"/></h1>
                <form class="form-registro" role="form" class="cmxform" method="post" id="frmDatos">
                    <fieldset class="col-lg-6">
                        <input type="text" name="nombre" id="nombre" placeholder="Nombre" class="form-registro-element" required="required">
                        <input type="email" name="correo" id="correo" placeholder="Correo Electrónico" class="form-registro-element" required="required">
                        <input type="text" name="idusuario" id="idusuario" placeholder="ID Usuario" class="form-registro-element" required="required">
                        <textarea name="comentario" id="comentario" placeholder="Comentario" class="form-registro-element" required="required" style="height:200px;"></textarea>


                        <button type="button" name="button"  id="btnGuardar" style="width: 132px;background: #1d4289;color: #fff;">Enviar Reporte</button>
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
<script src="/assets/js/perfil_gym.js"></script>
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

            swal({
                title: "Enviando",
                text: "Espere mientras se envia su reporte",
                type: "info",
                showCancelButton: false,
                cancelButtonText: "",
                showConfirmButton: false,
                confirmButtonText: "",
                closeOnConfirm: false
            },
                function(){
            });


            var formData= {
                nombre:$('#nombre').val(),
                correo:$('#correo').val(),
                idusuario:$('#idusuario').val(),
                comentario:$('#comentario').val()
            };

            $.ajax({
                url: "/perfil/reportes/servicio/reportar",
                data: formData,
                type: "POST",
                beforeSend:function(){
                    //cart.loading.fadeIn();
                },
                success: function (response) {
                    if(response.result=="ok"){
                        $('#nombre').val('');
                        $('#correo').val('');
                        $('#idusuario').val('');
                        $('#comentario').val('');

                        swal("Enviado","Su Reporte se envio correctamente, a la brevedad le daremos el seguimiento correspondiente ", "success");

                    }else{
                        swal("Atención", response.msj, "warning");
                    }

                },


            });
        }
    });



});

</script>
@endsection
