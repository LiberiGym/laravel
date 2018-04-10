<?php
/*\Artisan::call('config:cache');
\Artisan::call('cache:clear');
\Artisan::call('config:clear');*/
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>LIBERI :: @yield('title') </title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <meta name="keywords" content="@yield('keywords')" />
    <meta name="description" content="@yield('description')" />

    <!--****************** CSS ******************-->
    <link href="/css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
    <link rel="stylesheet" href="/css/chocolat.css"      type="text/css" media="all">
    <link href="/css/animate.css" rel="stylesheet" type="text/css" media="all">
    <link href="/css/style.css" rel="stylesheet" type="text/css" media="all" />
    <link href="/css/font-awesome.css" type="text/css" rel="stylesheet">
    <!--Validate-->
    <link rel="stylesheet" href="/css/validate.css">
    <!--****************** CSS ******************-->
    @yield('css')
</head>
<body>
<!-- banner -->
<div class="banner">
    <nav class="navbar navbar-default">
        <div class="container">
        <div class="navbar-header navbar-left">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <div class="w3_navigation_pos">
                <h1><a href="/inicio"><img src="/images/logo_liberi_web_eagle.png"/></a></h1>
            </div>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-right" id="bs-example-navbar-collapse-1">
            <nav class="link-effect-2" id="link-effect-2">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="/inicio"><img src="/images/logo_liberi_web_letters.png"/></a></li>
                    <li><a href="#aboutUs" class="scroll"><span data-hover="Sobre Nosotros">Sobre Nosotros</span></a></li>
                    <li><a href="#testimonies" class="scroll"><span data-hover="Testimonios" >Testimonios</span></a></li>
                    <li><a href="#howWorks" class="scroll"><span data-hover="Cómo Funciona">Cómo Funciona</span></a></li>
                    <li><a href="#contact" class="scroll"><span data-hover="Contáctanos">Contáctanos</span></a></li>
                    <li><a href="https://Facebook.com/liberiapp/" target="_blank"><span data-hover="Facebook"><i class="fa fa-facebook" aria-hidden="true"></i></span></a></li>
                    <li><a href="#contact" class="scroll"><span data-hover="Twitter"><i class="fa fa-twitter" aria-hidden="true"></i></span></a></li>
                    <li><a href="https://www.instagram.com/liberiapp/" target="_blank"><span data-hover="Instagram"><i class="fa fa-instagram" aria-hidden="true"></i></span></a></li>
                    <li>
                        <form class="nav-form" action="javascript:formslayout.loginUser();" method="post" role="form" class="cmxform" id="form-login">
                            <button type="submit" name="button">ENTRAR</button>
                            <input type="email" name="login_name" value="" placeholder="Usuario" required="required">
                            <input type="password" name="login_pass" value="" placeholder="Contraseña" required="required">
                        </form>
                    </li>


                </ul>
            </nav>
        </div>
        </div>
    </nav>

    @yield('contenttop')

</div>
<!-- //banner -->

@yield('content')

<!-- testimonies -->
<div class="testimonies-bg agileits-services testimonies-section" id="testimonies">
    <div class="container">
        <div class="slider">
            <div class="callbacks_container">
                <ul class="rslides" id="slider4">
                    <li>
                        <div class="testimony-text">
                            <h5>Carlo Beltrán</h5>
                            <p>“Excelente aplicación. Muy Recomendable.”</p>
                            <p>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                <i class="fa fa-star-o" aria-hidden="true"></i>
                            </p>
                        </div>
                    </li>


                </ul>
            </div>

            <!--banner Slider starts Here-->
        </div>

        <p>Testimoniales - <span class="brand-text">LIBERI</span></p>
    </div>
</div>
<!-- //services -->
<!-- portfolio -->
<div class="howWorks" id="howWorks">
    <div class="container">
        <div class="row">
            <div class="col-lg-12  text-center">
                <h3 class="howWorks-title text-center">¿Como Funciona?</h3>
                <img src="/images/barra_amarilla_banner_top.png" height="6" style="width:79px;"/>
                <p class="text-center" style="width:50%; margin:auto; line-height: 22px;">Usando la app, Liberi te permite tener acceso a múltiples establecimientos de actividades variadas a costos accesibles y sin plazos forzosos.</p>
                <img src="/images/how_works_img.png" alt="" style="margin-top:15px;">
            </div>

        </div>


        </div>
    </div>
    <!-- //portfolio -->

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
<!-- modal -->
<div class="modal about-modal fade" id="myModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">grains</h4>
            </div>
            <div class="modal-body">
                <div class="agileits-w3layouts-info">
                    <img src="/images/2.jpg" alt="" />
                    <p>Duis venenatis, turpis eu bibendum porttitor, sapien quam ultricies tellus, ac rhoncus risus odio eget nunc. Pellentesque ac fermentum diam. Integer eu facilisis nunc, a iaculis felis. Pellentesque pellentesque tempor enim, in dapibus turpis porttitor quis. Suspendisse ultrices hendrerit massa. Nam id metus id tellus ultrices ullamcorper.  Cras tempor massa luctus, varius lacus sit amet, blandit lorem. Duis auctor in tortor sed tristique. Proin sed finibus sem.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- //modal -->
<!-- footer -->
<div class="agileits_w3layouts-footer">
    <div class="col-md-12  agileinfo-copyright">
        <p><span class="brand-text">LIBERI</span> -  Todos los derechos reservados {{date('Y')}}</p>
    </div>

</div>
<!-- //footer -->

<!-- modal terminos y condiciones -->
<div class="modal fade" id="mdlTerminos" tabindex="-1" role="dialog" aria-labelledby="mdlTerminos" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Términos y Condiciones de Liberi</h5>
            </div>
            <div class="modal-body">
                <p>Términos y Condiciones de Liberi</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- //modal terminos y condiciones -->

    <!--****************** JS ******************-->
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
            function hideURLbar(){ window.scrollTo(0,1); } </script>
    <script type="text/javascript" src="/js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="/js/popper.min.js"></script>
    <script type="text/javascript" src="/js/bootstrap.js"></script>
    <script src="/js/modernizr.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $(".scroll").click(function(event){
                event.preventDefault();
                $('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
            });
        });
    </script>

    <script src="/js/responsiveslides.min.js"></script>
    <script>
        // You can also use "$(window).load(function() {"
        $(function () {
          // Slideshow 4
          $("#slider4").responsiveSlides({
            auto: true,
            pager:true,
            nav:true,
            speed: 500,
            namespace: "callbacks",
            before: function () {
              $('.events').append("<li>before event fired.</li>");
            },
            after: function () {
              $('.events').append("<li>after event fired.</li>");
            }
          });

        });
     </script>
    <!--banner Slider starts Here-->


    <script src="/js/classie.js"></script>
    <script src="/js/helper.js"></script>
    <!--<script src="js/grid3d.js"></script>
    <script>
        new grid3D( document.getElementById( 'grid3d' ) );
    </script>-->
    <script src="/js/jarallax.js"></script>
    <script src="/js/SmoothScroll.min.js"></script>
    <script type="text/javascript">
        /* init Jarallax */
        $('.jarallax').jarallax({
            speed: 0.5,
            imgWidth: 1366,
            imgHeight: 768
        })
    </script>

    <script type="text/javascript" src="/js/move-top.js"></script>
    <script type="text/javascript" src="/js/easing.js"></script>
    <script src="/js/sweetalert2.all.js"> </script>

    <!--Validate-->
    <script src="/js/jquery.validate.js"></script>
    <script src="/js/ccvalidate.js"></script>


    <script src="/js/layout.js"></script>
    <!--****************** JS ******************-->
    @yield('js')
</body>
</html>
