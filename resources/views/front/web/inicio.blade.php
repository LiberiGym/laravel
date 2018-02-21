@extends('front.layout.layout')
@section('contenttop')
    <div class="banner-info">
        <div class="banner-bottom">
            <div class="container">
                <div class="col-md-6 col-sm-6">

                    <h3>¿Tienes un gimnasio?</h3>
                    <h1>ENTRA<br>A LA RED</h1>
                    <p>Se parte de la red de gimnasios más grande<br>de México y se <span class="brand-text">Liberi</span> <img src="images/barra_amarilla_banner_top.png" height="6" style="width:79px;"/></p>
                </div>
                <div class="col-md-6 col-sm-6">
                    <h3>Regístrate para iniciar</h3>
                    <form class="form-registro" method="post" role="form" class="cmxform" id="frmInitRegistro">
                        <input type="text" name="tradename" id="tradename" placeholder="Nombre del Gimnasio" class="form-registro-element" required="required">
                        <input type="text" name="name" id="name" placeholder="Nombre del Propietario o Socio" class="form-registro-element" required="required">
                        <input type="text" name="last_name" id="last_name" placeholder="Apellidos" class="form-registro-element" required="required">
                        <input type="email" name="email" id="email" placeholder="Correo Electrónico de Propietario o Socio" class="form-registro-element" required="required">
                        <select class="" id="cboState" name="state" class="form-registro-element" style="width: 47%; display: inline-block; margin-right: 11px;" required="required">
                            <option value="">Estado</option>
                            @foreach($states as $state)
                            <option value="{{$state->id}}">{{$state->title}}</option>
                            @endforeach
                        </select>
                        <select class="" name="location" id="cboLocation" class="form-registro-element" style="width:50%;" required="required">
                            <option value="">Ciudad</option>
                        </select>
                        <input type="password" name="password" id="password" placeholder="Crear Contraseña" class="form-registro-element" required="required">
                        <input type="checkbox" name="terminos_condiciones" id="terminos_condiciones" required="required"> <span>Acepto los <a href="#" data-toggle="modal" data-target="#mdlTerminos">Términos y Condiciones</a> de Liberi</span>
                        <button type="submit" name="button" id="btnCrear">Crear Cuenta</button>
                    </form>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="w3-arrow bounce animated" style="display:none;">
            <a href="#about" class="scroll"><i class="fa fa-angle-down" aria-hidden="true"></i></a>
        </div>

    </div>
@endsection

@section('content')
<!-- about -->
<div class="jarallax agileits-about agile-section" id="aboutUs">
    <div class="container">

        <div class="w3agile-about">
            <div class="col-md-6 col-sm-6 col-xs-6 w3_agileits-about-left">

            </div>
            <div class="col-md-6 col-sm-6 col-xs-6 w3_agileits-about-right">
                <h3 class="agileits-title text-center"><img src="images/logo_blue.png" style="width:374px;"/></h3>
                <h1>Sobre Nosotros <img src="images/barra_amarilla_banner_top.png" height="6" style="width:79px;"/></h1>
                <p style="font-style: italic;">¡Ejercítate a tu ritmo, haciendo lo que te gusta, cuando tú quieras!</p>
                <p style="width:80%; margin-bottom: 14px;">En Liberi creamos la aplicación perfecta para que no haya pretextos a la hora de hacer ejercicio. Nuestra aplicación te permite elegir entre múltiples establecimientos de acondicionamiento deportivo a un precio accesible, sin plazos forzosos.</p>
                <a href="/nosotros"><button type="button" name="button">Leer Más</button></a>

            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!-- //about -->
<!-- howWorks -->
<div class="howWorks" id="howWorks">
    <div class="container">
        <div class="row">
            <div class="col-lg-12  text-center">
                <h3 class="howWorks-title text-center">¿Como Funciona?</h3>
                <img src="/images/barra_amarilla_banner_top.png" height="6" style="width:79px;"/>
                <p class="text-center" style="width:50%; margin:auto; line-height: 22px;">Usando la app, Liberi te permite tener acceso a múltiples establecimientos de actividades variadas a costos accesibles y sin plazos forzosos.</p>
                <!--<img src="/images/how_works_img.png" alt="" style="margin-top:15px;">-->

                <div class="col-lg-12 howWorks-img">
                    <div class="col-lg-3 col-lg-offset-8" style="padding-left: 44px;">
                        <h4 class="howWorks-h4">¡Regístrate y comienza ahora!</h4>
                        <button type="button" data-toggle="modal" data-target="#mdlDownloadApp">Registrarse como usuario</button>
                    </div>

                </div>


            </div>

        </div>


        </div>
    </div>
    <!-- //howWorks -->

<!-- Contact-form -->
<div id="contact">
    <div class="container">
        <div class="contact-icon">
            <img src="/images/contact_icon.png" alt="">
        </div>
        <h3 class="contact-title text-center">¿Dudas? Contáctanos</h3>
        <div class="contact-info text-center">
            <p>Escríbenos y nos pondremos en contacto a la brevedad</p>
            <div class="clearfix"></div>
        </div>
        <div class="contact-form">
            <form action="javascript:formslayout.contacto();" method="post" class="form-contacto" role="form" class="cmxform" id="form-contacto">
                <input type="text" placeholder="Nombre" name="contact_name" required="required" class="form-contacto-element" style="width:48%; margin-right:10px;">
                <input type="text" placeholder="Teléfono" name="contact_phone" required="required" class="form-contacto-element" style="width:48%;">
                <input type="email" placeholder="Correo Electrónico" name="contact_email" required="required" class="form-contacto-element">
                <textarea placeholder="Mensaje" name="contact_message" required="required" class="form-contacto-texarea"></textarea>
                <div class="" align="center">
                    <button type="submit" name="button">Enviar Mensaje</button>
                </div>

            </form>
        </div>
    </div>
</div>
<!-- //Contact-form -->

@endsection
@section('js')
<script type="text/javascript" src="/assets/js/register.js"></script>
@endsection
