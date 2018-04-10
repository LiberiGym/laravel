<!DOCTYPE HTML>
<html lang="es">
    <head>
        <base href="<?= $base ?>" />
        <meta charset="utf-8" />
        <title>{{ config('app.name') }} Admin</title>
        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
        <link rel="icon" type="image/png" href="/assets/images/icon/favicon.png">

        <!-- ================== CSS ================== -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
        <?php
        $plugins = array_merge(['jquery', 'jquery-ui', 'bootstrap', 'font-awesome', 'slim-scroll', 'jquery-cookie', 'parsley', 'sweetalert'], $plugins);
        $css = array_merge(['base/animate', 'base/style', 'base/style-responsive'], $css);
        $js = array_merge(['base/apps', 'base/app', 'base/controls'], $js);
        Tejuino\Adminbase\Plugins::pluginsCss($plugins);
        Tejuino\Adminbase\Plugins::appCss($css);
        ?>
        <!-- ================== /CSS ================== -->

        <link href="/admin_assets/css/base/theme/custom.css" rel="stylesheet" id="theme" />
        <script src="/admin_assets/plugins/pace/pace.js"></script>
    </head>
    <body>

        <div id="page-loader" class="fade in"><span class="spinner"></span></div>

        <div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
            <div id="header" class="header navbar navbar-inverse navbar-fixed-top">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a href="/admin" class="navbar-brand"><span></span></a>
                        <button type="button" class="navbar-toggle" data-click="sidebar-toggled">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>

                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <form class="navbar-form full-width">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Enter keyword" />
                                    <button type="submit" class="btn btn-search"><i class="fa fa-search"></i></button>
                                </div>
                            </form>
                        </li>

                        <li class="dropdown navbar-user">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="{{ Auth::user()->image }}" alt="" />
                                <span class="hidden-xs">{{ Auth::user()->name }} {{ Auth::user()->last_name }}</span> <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu animated fadeInLeft">
                                <li class="arrow"></li>
                                <li><a href="javascript:;">Edit Profile</a></li>
                                <!--li><a href="javascript:;"><span class="badge badge-danger pull-right">2</span> Inbox</a></li>
                                <li><a href="javascript:;">Calendar</a></li>
                                <li><a href="javascript:;">Settings</a></li-->
                                <li class="divider"></li>
                                <li><a href="/logout"><i class="fa fa-power-off"></i> Log Out</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>

            <div id="sidebar" class="sidebar">
                <div data-scrollbar="true" data-height="100%">
                    <ul class="nav">
                        <li class="nav-profile">
                            <div class="image">
                                <a href="javascript:;"><img src="{{ Auth::user()->image }}" alt="" /></a>
                            </div>
                            <div class="info">
                                {{ Auth::user()->name }} {{ Auth::user()->last_name }}
                                <small>{{ Auth::user()->role->title }}</small>
                            </div>
                        </li>
                        <li class="nav-header">Dashboard</li>

                        <li class="<?= ($section == "Dashboard") ? "active" : "" ?>">
                            <a href="/admin/">
                                <i class="fa fa-tachometer"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-header">Configuración</li>
                        <li class="<?= ($section == "Categories") ? "active" : "" ?>">
                            <a href="/admin/categories">
                                <i class="fa fa-cog"></i>
                                <span>Categorías</span>
                            </a>
                        </li>
                        <li class="<?= ($section == "States") ? "active" : "" ?>">
                            <a href="/admin/states">
                                <i class="fa fa-cog"></i>
                                <span>Estados</span>
                            </a>
                        </li>
                        <li class="<?= ($section == "Locations") ? "active" : "" ?>">
                            <a href="/admin/locations">
                                <i class="fa fa-cog"></i>
                                <span>Municipios</span>
                            </a>
                        </li>

                        <li class="nav-header">Administradores</li>
                        <li class="{{ ($section == "Users" && $subsection == '') ? "active" : "" }}">
                            <a href="/admin/users">
                                <i class="fa fa-users"></i>
                                <span>Usuarios</span>
                            </a>
                        </li>

                        <li class="nav-header">Gimnasios</li>
                        <li class="{{ ($section == "Users" && $subsection == '') ? "active" : "" }}">
                            <a href="/admin/users">
                                <i class="fa fa-users"></i>
                                <span>Usuarios</span>
                            </a>
                        </li>

                        <li class="nav-header">Usuarios App</li>
                        <li class="{{ ($section == "Users" && $subsection == '') ? "active" : "" }}">
                            <a href="/admin/users">
                                <i class="fa fa-users"></i>
                                <span>Usuarios</span>
                            </a>
                        </li>

                        <li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
                    </ul>
                </div>
            </div>

            <div class="sidebar-bg"></div>

            <div id="content" class="content">
                @yield('content')
            </div>

            <a href="javascript:;" class="btn btn-icon btn-circle btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
        </div>

        @if($errors->any())
            @foreach($errors->all() as $error)
                <div class="modal fade" id="modal-alert-error">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
								<h4 class="modal-title">Alerta</h4>
							</div>
							<div class="modal-body">
								<div class="alert alert-danger m-b-0">
									<h4><i class="fa fa-info-circle"></i> Error</h4>
									<p>{{ $error }}</p>
								</div>
							</div>
							<div class="modal-footer">
								<a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Cerrar</a>
							</div>
						</div>
					</div>
				</div>
            @endforeach
        @endif

        <!-- ================== JS ================== -->
        <?php
        Tejuino\Adminbase\Plugins::pluginsJs($plugins);
        Tejuino\Adminbase\Plugins::appJs($js);
        ?>

        @yield("js")

    </body>
</html>
