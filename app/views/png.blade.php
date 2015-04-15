@extends ('layout.main')

@section ('content')        
        <div class="container-fluid">
            
            <div class="container">
                
                <div class="clearfix title-box text-center">
                    <h1>Optimizacion de recursos</h1>
                    @if($active=='jpg')
                    <span class="label label-primary">JPEG</span>
                    @elseif($active=='png')
                    <span class="label label-normal">PNG</span>
                    @elseif($active=='css')
                    <span class="label label-warning">CSS</span>
                    @elseif($active=='js')
                    <span class="label label-success">JS</span>
                    @endif
                </div>

                <!-- Visualizador -->
                <div class="row viewrow">
                    <div class="twentytwenty-container center-block img-viewer">
                      <img src="#" id="left-image" alt="Imagen original">
                      <img src="#" id="right-image" alt="Imagen optimizada">
                    </div>
                </div>

                <!-- Post upload -->
                <div class="row compress-info">
                    <div class="color-swatches">
                        <div class="swatches">
                            <div class="infos">
                                <div class="row">
                                    <div class="col-md-2 text-center cpt compress-label">
                                        <span class="data_percent"></span> De compresion
                                    </div>
                                    <div class="col-md-2 cpt text-center">
                                        Antes : <span class="data_before"></span>
                                    </div>
                                    <div class="col-md-2 cpt text-center">
                                        Despues : <span class="data_after"></span>
                                    </div>
                                    <div class="col-md-3">
                                        <button class="btn btn-success btn-block btn-fdownload" data-url="">Descargar</button>
                                    </div>
                                    <div class="col-md-3">
                                        <button class="btn btn-primary btn-block btn-reset">Nuevo archivo</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Dropzone -->
                <div class="row">
                    <div class="dropzone" id="dropzone"></div>
                    <div class="progress progress-striped active fileprogress"><div class="progress-bar progress-bar-danger upprogress" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div></div>
                    <div class="progress progress-striped active fileprogress_proc"><div class="progress-bar progress-bar-success upprogress_proc" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"><i class="fa fa-cog fa-spin"></i> Optimizando imagen..</div></div>
                </div>
                
            </div>
            
        </div>
@stop

@section ('dialogs')
@stop

@section ('scripts')
    @parent

    {{ HTML::script('js/d3.png.js') }}
    
@stop