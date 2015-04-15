$(document).ready(function(){
                
    // Disable auto discover for all elements:
    Dropzone.autoDiscover = false;

    var main_width  = 0;
    
    var max_width   = 800;
    var max_height  = 600;

    var img_width   = 0;
    var img_height  = 0;

    // Dropzone class:
    var _dz = new Dropzone("div#dropzone",{
        url: "/ujpg",
        dictDefaultMessage: '<i class="fa fa-cloud-upload"></i><p><span>Arrastra tu imagen ó da click.</span></p>',
        autoProcessQueue: true,
        uploadMultiple: false,
        previewsContainer: false,
        maxFiles: 1,
        maxFilesize: 5, // 5MB
        dictFileTooBig: 'tb:La imagen es demasiado grande',
        acceptedFiles: 'image/jpeg,image/jpg',
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
                }// else console.log(response);
            }
        },
        sending: function(file) {
            //console.log('Cargando archivo al servidor');
            $('#dropzone').fadeOut('fast').slideUp('fast');
            $('.fileprogress').fadeIn('fast').slideDown('slow');
        },
        uploadprogress: function(file, progress, bytesSent) {
            $('.upprogress').css('width', progress+'%').html('<i class="fa fa-circle-o-notch fa-spin"></i> ' + Math.round(progress) + '% Cargado..');
            //console.log(progress);
            //console.log(bytesSent);
        },
        complete: function(file) {

            if(file.status=='error') return false;

            $('.fileprogress').slideUp('fast');
            $('.fileprogress_proc').slideDown('slow');

            var _data           = $.parseJSON(file.xhr.response);
            var _status         = _data.status;
            var _original_file  = _data.original;
            var _original_size  = _data.original_size;
            var _uploaded       = _data.uploaded;

            main_width          = $('.viewrow').width();
            img_width           = _data.width;
            img_height          = _data.height;

            if(img_width <= main_width) {
                
                $('.img-viewer').css({'width':img_width,'height':img_height});
                $('#left-image').css({'width':img_width,'height':img_height});
                $('#right-image').css({'width':img_width,'height':img_height});

            } else {
                
                var new_size = $.resize(img_width,img_height,main_width,600);

                $('.img-viewer').css({'width':new_size.width,'height':new_size.height});
                $('#left-image').css({'width':new_size.width,'height':new_size.height});
                $('#right-image').css({'width':new_size.width,'height':new_size.height});
            }

            if(_status==true) {
                $.d3POST('/cjpg',{original:_original_file, original_size:_original_size, uploaded:_uploaded},function(data){

                    $('.fileprogress_proc').slideUp('fast');
                    $('#left-image').prop('src','/uploads/images/' + file.name);
                    $('#right-image').prop('src','/uploads/images/' + data.image);

                    $('.btn-fdownload').data('url',data.image);

                    $('.data_percent').html(data.compress_percent_real);
                    $('.data_before').html(data.original_size);
                    $('.data_after').html(data.new_file_size);

                    $('.img-viewer').slideDown('slow');
                    $('.compress-info').slideDown('slow');
                });
            } else console.log('Mamo');
        }
    });

    $.resize = function(srcWidth, srcHeight, maxWidth, maxHeight) {
        var ratio = [maxWidth / srcWidth, maxHeight / srcHeight ];
        ratio = Math.min(ratio[0], ratio[1]);
        return { width:srcWidth*ratio, height:srcHeight*ratio };
    };

    $(window).on('resize', function(){

        main_width  = $('.viewrow').width();

        if(img_width > max_width) {
            var new_size = $.resize(img_width,img_height,main_width,max_height);
            $('.img-viewer').css({'width':new_size.width,'height':new_size.height});
            $('#left-image').css({'width':new_size.width,'height':new_size.height});
            $('#right-image').css({'width':new_size.width,'height':new_size.height});
        }

    });

    $('.btn-reset').click(function(e){

        $('.data_percent').html('');
        $('.data_before').html('');
        $('.data_after').html('');

        $('#left-image').prop('src','');
        $('#right-image').prop('src','');

        $('.img-viewer').slideUp('fast');
        $('.compress-info').slideUp('fast');

        $('#dropzone').fadeIn('fast').slideDown('fast');
        
        _dz.removeAllFiles();

        e.preventDefault();
    });

    $('.btn-fdownload').click(function(e){
        var _file = $(this).data('url');
        window.location.href = '/f/1/' + _file;
        console.log(_file);
       e.preventDefault(); 
    });
    
    $(".twentytwenty-container[data-orientation!='vertical']").twentytwenty({default_offset_pct: 0.7});
    $(".twentytwenty-container[data-orientation='vertical']").twentytwenty({default_offset_pct: 0.3, orientation: 'vertical'});
   
});