<?php
\Artisan::call('config:cache');
\Artisan::call('cache:clear');
\Artisan::call('config:clear');
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
                    <!--<li><a href="#testimonies" class="scroll"><span data-hover="Testimonios" >Testimonios</span></a></li>-->
                    <li><a href="#howWorks" class="scroll"><span data-hover="Cómo Funciona">Cómo Funciona</span></a></li>
                    <li><a href="#contact" class="scroll"><span data-hover="Contáctanos">Contáctanos</span></a></li>
                    <li><a href="https://Facebook.com/liberiapp/" target="_blank"><span data-hover="Facebook"><i class="fa fa-facebook" aria-hidden="true"></i></span></a></li>

                    <li><a href="https://www.instagram.com/liberiapp/" target="_blank"><span data-hover="Instagram"><i class="fa fa-instagram" aria-hidden="true"></i></span></a></li>
                    <li id="frmLogin">
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
<!--<div class="testimonies-bg agileits-services testimonies-section" id="testimonies">
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
        </div>

        <p>Testimoniales - <span class="brand-text">LIBERI</span></p>
    </div>
</div>-->
<!-- //testimonies -->

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

<!-- modal -->
<div class="modal about-modal fade" id="mdlDownloadApp" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="width:970px; height:502px;">
        <div class="modal-content modal-img">
            <div class="modal-body">

                <div class="col-lg-12  text-center">
                    <h3 class="howWorks-title-modal text-center">¡BIENVENIDO!</h3>
                    <img src="/images/barra_amarilla_banner_top.png" height="6" style="width:79px;"/>
                    <p class="text-center" style="width:50%; margin:auto; line-height: 22px;">LIBERI te ayuda a alcanzar tus metas físicas y a pagar solo lo que utilizas, sin contratos ni mensualidades.</p>
                    <br>

                    <p class="text-center" style="width:50%; margin:auto; line-height: 22px; margin-bottom:20px;">Pruébala gratuitamente, descárgala para iPhone o Android.</p>

                    <button type="button" name="button" style="border: none;background: none;"><img src="/images/img_modal_app_ios_button.png"/></button>

                    <button type="button" name="button" style="border: none;background: none;"><img src="/images/img_modal_app_droid_button.png"/></button>

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
                <p>{{$terminos->terminos_web_inicio}}</p>
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
