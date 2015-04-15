<!DOCTYPE html>
<html lang="es">
    
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Optimizador de recursos</title>

        <!-- Bootstrap core CSS -->
        {{ HTML::style('css/bootstrap.min.css') }}
        {{ HTML::style('css/bootflat.min.css') }}

        <!-- Font awesome -->
        {{ HTML::style('css/font-awesome.min.css') }}
        
        <!-- D3 Drop Zone -->
        {{ HTML::style('css/dropzone.css') }}
        
        <!-- Custom styles for this template -->
        {{ HTML::style('css/twentytwenty.css') }}
        {{ HTML::style('css/notifications.min.css') }}
        {{ HTML::style('css/style.css') }}

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300' rel='stylesheet' type='text/css'>
        
        <!-- Estilos personalizados -->
        @yield('styles')

    </head>

    <body role="document">
        
        <!-- Menu de navegacion superior -->
        <nav class="navbar navbar-custom navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#"><span class="fa fa-bullseye"></span>ptim</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right social">
                        <li class="facebook"><a href="#"><span class="fa fa-lg fa-facebook"></span></a></li>
                        <li class="twitter"><a href="#"><span class="fa fa-lg fa-twitter"></span></a></li>
                        <li class="gplus"><a href="#"><span class="fa fa-lg fa-google-plus"></span></a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="{{ URL::to('/') }}">Inicio</a></li>
                        <li><a href="{{ URL::to('/register') }}">Registro</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Recursos <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ URL::to('/') }}" class="clearfix"><span class="label label-primary pull-right">JPEG</span></a></li>
                                <li><a href="{{ URL::to('compresion-de-archivos-png') }}" class="clearfix"><span class="label label-normal pull-right">PNG</span></a></li>
                                <li><a href="{{ URL::to('compresion-de-archivos-css') }}" class="clearfix"><span class="label label-warning pull-right">CSS</span></a></li>
                                <li><a href="{{ URL::to('compresion-de-archivos-js') }}" class="clearfix"><span class="label label-success pull-right">JS</span></a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- /Menu de navegacion superior -->
        
        <!-- Page content -->
        @yield('content')
        <!-- END Page Content -->

    <!-- Dialogos -->
    @yield('dialogs')
    <!-- /Dialogos -->
        
        {{ HTML::script('js/jquery-1.11.2.min.js') }}
        {{ HTML::script('js/bootstrap.min.js') }}
        
        {{ HTML::script('js/icheck.min.js') }}
        {{ HTML::script('js/jquery.fs.selecter.min.js') }}
        {{ HTML::script('js/jquery.fs.stepper.min.js') }}
    
        {{ HTML::script('js/jquery.event.move.js') }}
        {{ HTML::script('js/jquery.twentytwenty.js') }}
        {{ HTML::script('js/jquery.ba-throttle-debounce.js') }}
        {{ HTML::script('js/dropzone.js') }}
        {{ HTML::script('js/notifications.min.js') }}
        {{ HTML::script('js/d3.common.js') }}

        <!-- Scripts personalizados -->
        @yield('scripts')

  </body>
</html>
