@extends('front.layout.layout_registro')
@section('css')
<link href="/css/registro.steps.css" type="text/css" rel="stylesheet">
<link href="/admin_assets/plugins/dropzone/dropzone.css" rel="stylesheet" />
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
                    <li><a href="/administracion/clientes/gym/{{  $gym->id }}">Inicio <span><i class="fa fa-angle-right" aria-hidden="true"></i></span></a></li>
                    <li class="active"><a href="/administracion/clientes/gym/datos-fiscales/{{  $gym->id }}">Datos Fiscales <span><i class="fa fa-angle-right" aria-hidden="true"></i></span></a></li>
                    <li><a href="/administracion/clientes/gym/datos-bancarios/{{  $gym->id }}">Datos Bancarios <span><i class="fa fa-angle-right" aria-hidden="true"></i></span></a></li>

                </ul>
                <a href="/administracion">
                <button type="button" name="button" class="cerrar-session">Regresar</button></a>

            </div>
            <div class="col-lg-9">
                <h1 style="margin-bottom: 45px;">Datos Fiscales <img src="/images/barra_amarilla_banner_top.png" height="6" style="width:79px;"/></h1>
                <form action="/perfil/datos-fiscales" class="form-registro" role="form" class="cmxform" method="post" id="frmDatos">
                    <input type="hidden" name="editInfo" value="1">
                    <fieldset class="col-lg-6">
                        <legend class="form-legend-registro">Datos de Propietario o Representante Legal</legend>

                        <input type="text" name="name" value="{{$user->name}}" placeholder="Nombre" class="form-registro-element" disabled>
                        <input type="text" name="last_name" value="{{$user->last_name}}" placeholder="Apellidos" class="form-registro-element" disabled>
                        <input type="text" name="phone" value="{{$user->phone}}" placeholder="Teléfono" class="form-registro-element" required="required" number="true">
                        <input type="text" name="email" value="{{$user->email}}" placeholder="Correo lectrónico" class="form-registro-element" disabled>

                        <legend class="form-legend-registro">Logotipo de la empresa:</legend>
                        
                        <div class="clearfix"></div>
                        <div class="" id="divImages" style="margin-top:15px;">
                            <div style="margin-top:5px; height: 100px;">
                                <img src="/files/gyms/{{$gym->gym_logo}}" style="height: 100px; width:auto;">
                            </div>
                        </div>

                        <legend class="form-legend-registro">Comprobante de registro de marca</legend>

                        <div class="clearfix"></div>
                        <div class="" id="divImagesRegistro" style="margin-top:15px;">
                            <div style="margin-top:5px; height: 100px;">
                                @if($gym->gym_register!='')
                                <input type="checkbox" name="txtNameFileImage" value="{{$gym->gym_register}}" checked><label class="form-label-servicios" style="background: rgba(29,66,137,0.5);width: 100%; color:#fff;"><i class="fa fa-file-image-o" aria-hidden="true"></i> <span style="font-size:11px;">{{$gym->gym_register}}</span></label>
                                @endif
                        </div>
                        </div>


                        <div class="clearfix"></div>

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
<script src="/assets/js/perfil_gym.js"></script>
<script>

$(document).ready(function () {

    $('input, textarea, select').prop('disabled', true);

});

</script>
@endsection
