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
                        <li><a href="#">Home</a></li>
                        <li><a href="#about">About</a></li>
                        <li><a href="#contact">Contact</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Recursos <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#" class="clearfix"><span class="label label-primary pull-right">JPEG</span></a></li>
                                <li><a href="#" class="clearfix"><span class="label label-normal pull-right">PNG</span></a></li>
                                <li><a href="#" class="clearfix"><span class="label label-warning pull-right">CSS</span></a></li>
                                <li><a href="#" class="clearfix"><span class="label label-success pull-right">JS</span></a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- /Menu de navegacion superior -->
        
        <div class="container-fluid">
            
            <div class="container">
                
                <div class="clearfix title-box text-center">
                    <h1>Optimizacion de recursos</h1>
                    <span class="label label-primary">JPEG</span>
                    <span class="label label-normal">PNG</span>
                    <span class="label label-warning">CSS</span>
                    <span class="label label-success">JS</span>
                </div>
                
                <div class="row">
                    
                    <div class="dropzone" id="dropzone"></div>
                    <div class="progress progress-striped active fileprogress"><div class="progress-bar progress-bar-danger upprogress" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div></div>
                    <div class="progress progress-striped active fileprogress_proc"><div class="progress-bar progress-bar-success upprogress_proc" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"><i class="fa fa-cog fa-spin"></i> Optimizando imagen..</div></div>
                    
                </div>
                
                {{--
                <div class="row">
                    <div class="twentytwenty-container center-block" style="max-width:600px">
                      <img src="/img/1_1.jpg">
                      <img src="/img/1_2.jpg" />
                    </div>
                </div>
                --}}
                
                {{--
                <div class="row no-gutter">
                    <div class="col-md-6">
                        <div class="jumbotron">
                            <div class="jumbotron-photo-left">
                                <img src="http://bootflat.github.io/img/Jumbotron.jpg">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="jumbotron">
                            <div class="jumbotron-photo-right">
                                <img src="http://bootflat.github.io/img/slider3.jpg">
                            </div>
                        </div>
                    </div>
                </div>
                --}}
            </div>
            
        </div>

    </div> <!-- /container -->
        
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
    
        <script>
            $(document).ready(function(){
                
                // Disable auto discover for all elements:
                Dropzone.autoDiscover = false;

                // Dropzone class:
                $("div#dropzone").dropzone({
                    url: "/ujpg",
                    dictDefaultMessage: '<i class="fa fa-cloud-upload"></i><p><span>Arrastra tu imagen ó da click.</span></p>',
                    autoProcessQueue: true,
                    uploadMultiple: false,
                    previewsContainer: false,
                    maxFiles: 1,
                    maxFilesize: 5, // 5MB
                    dictFileTooBig: 'tb:Imagen demasiado grande',
                    acceptedFiles: 'image/jpeg,image/jpg,image/png',
                    dictInvalidFileType: 'uf:Archivo no soportado',
                    maxfilesexceeded: function(file) {
                        displayNotification('error', 'Ha superado el número máximo de imágenes a cargar.', 4000);
                        this.removeFile(file);
                    },
                    error: function(file, response) {
                        if($.type(response) === "string") {
                            var err = response.split(':');
                            if(err[0]=='tb') {
                                displayNotification('error', file.name + ' ' + err[1], 4000);
                                this.removeFile(file);
                            } else if(err[0]=='uf') {
                                displayNotification('error', file.name + ' ' + err[1], 4000);
                                this.removeFile(file);
                            } else console.log(response);
                        }
                    },
                    sending: function(file) {
                        console.log('Cargando archivo al servidor');
                        $('#dropzone').slideUp('slow',function(){
                            $('.fileprogress').slideDown('slow');
                        });
                    },
                    uploadprogress: function(file, progress, bytesSent) {
                        $('.upprogress').css('width', progress+'%').html('<i class="fa fa-circle-o-notch fa-spin"></i> ' + Math.round(progress) + '% Cargado..');
                        //console.log(progress);
                        //console.log(bytesSent);
                    },
                    complete: function(file) {
                        $('.fileprogress').slideUp('slow',function(){
                            $('.fileprogress_proc').slideDown('slow', function(){
                                console.log(file);
                                var _data           = $.parseJSON(file.xhr.response);
                                
                                var _status         = _data.status;
                                var _original_file  = _data.original;
                                var _original_size  = _data.original_size;
                                var _uploaded       = _data.uploaded;

                                if(_status==true) {
                                    $.d3POST('/cjpg',{original:_original_file, original_size:_original_size, uploaded:_uploaded},function(data){
                                        console.log(data);
                                    });
                                } else {
                                    console.log('Mamo');
                                }
                            });
                        });
                    }
                });
                
                $(".twentytwenty-container[data-orientation!='vertical']").twentytwenty({default_offset_pct: 0.7});
                $(".twentytwenty-container[data-orientation='vertical']").twentytwenty({default_offset_pct: 0.3, orientation: 'vertical'});
               
            });
        </script>
  </body>
</html>
