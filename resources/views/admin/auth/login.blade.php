<!DOCTYPE HTML>
<html lang="es">
    <head>
        <base href="/" />
        <meta charset="utf-8" />
        <title>{{ config('app.name') }} Admin</title>
        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
        <link rel="icon" type="image/png" href="/admin_assets/images/favicon.jpg">

        <!-- ================== CSS ================== -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
        <?php
        $plugins = ['jquery', 'jquery-ui', 'bootstrap', 'font-awesome', 'slim-scroll', 'jquery-cookie'];
        $css = ['base/animate', 'base/style', 'base/style-responsive'];
        $js = ['base/login', 'base/apps', 'base/app'];
        Tejuino\Adminbase\Plugins::pluginsCss($plugins);
        Tejuino\Adminbase\Plugins::appCss($css);
        ?>
        <!-- ================== /CSS ================== -->

        <link href="/admin_assets/css/base/theme/custom.css" rel="stylesheet" id="theme" />
        <script src="/admin_assets/plugins/pace/pace.min.js"></script>
    </head>
    <body>

        <div id="page-loader" class="fade in"><span class="spinner"></span></div>

    	<div class="login-cover">
    	    <div class="login-cover-image"><img src="/admin_assets/images/login-bg/bg-1.jpg" data-id="login-cover-image" alt="" /></div>
    	    <div class="login-cover-bg"></div>
    	</div>
    	<div id="page-container" class="fade">
            <form class="login login-v2" data-pageload-addclass="animated fadeIn" method="POST" action="/login">
                {{ csrf_field() }}
                <div class="login-header">
                    <div class="brand">
                        <span class="loginLogo"></span>
                    </div>
                </div>
                <div class="login-content">
                    <form action="index.html" method="POST" class="margin-bottom-0">
                        <div class="form-group m-b-20">
                            <p>Indique su usuario y password para entrar:</p>
                        </div>
                        <div class="form-group m-b-20">
                            <input type="email" name="email" id="email" class="form-control input-lg" placeholder="Email Address" value="{{ old('email') }}" />

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group m-b-20">
                            <input type="password" class="form-control input-lg" placeholder="Password" name="password" id="password" />

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="login-buttons">
                            <button type="submit" class="btn btn-danger btn-block btn-lg">Ingresar</button>
                        </div>
                    </form>
                </div>
            </form>

        <!-- ================== JS ================== -->
        <?php
        Tejuino\Adminbase\Plugins::pluginsJs($plugins);
        Tejuino\Adminbase\Plugins::appJs($js);
        ?>
    </body>
</html>
