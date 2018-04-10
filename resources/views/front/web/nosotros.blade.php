@extends('front.layout.layout')
@section('content')
<!-- about -->
<div class="jarallax agileits-about-detail agile-section-about-detail" id="aboutUs">
    <div class="container">

        <div class="w3agile-about w3agile-about-detail">
            <div class="col-lg-3">
                <img src="/images/somos_image_left.png" alt="">

            </div>
            <div class="col-lg-8">
                <h1>Sobre Nosotros <img src="/images/barra_amarilla_banner_top.png" height="6" style="width:79px;"/></h1>
                <p style="font-style: italic; margin-bottom: 31px;">¡Ejercítate a tu ritmo, haciendo lo que te gusta, cuando tú quieras!</p>

                <h1>Misión</h1>
                <p style="width:80%; margin-bottom: 31px;">Es crear la plataforma más eficiente para promover la cultura del ejercicio entre las personas a través de un método que les brinde la libertad de acceder al mayor número de centros dte acondicionamiento físico, en diversas disciplinas, a un costo accesible, buscando con ello mejorar la salud en nuestro entorno social.</p>

                <h1>Visión</h1>
                <p style="width:80%; margin-bottom: 31px;">Ser la plataforma líder en México para la promoción de clientes a centros de acondicionamiento físico, logrando con ello un mayor alcance de la cultura del deporte y ejercicio para que cualquier individuo pueda realizar una actividad adecuada a sus gustos y preferencias, ayudando así al mejoramiento de su salud.</p>

                <p style="font-style: italic; text-align:center; width:80%; margin-bottom:93px;">¡Nuestro compromiso es con tu salud y bienestar, por eso buscamos darte las mejores herramientas para que puedas explotar todo tupotencial!</p>
                <div  style="text-align:center; width:80%;">
                    <a href="/inicio"><button type="button" name="button" class="detail">Crear Cuenta</button></a>
                </div>

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
