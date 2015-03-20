// variables
var dropArea        = undefined;
var config          = {};
var list            = [];
var totalSize       = 0;
var totalProgress   = 0;
var result          = undefined;
var count           = document.getElementById('count');

var canvas = document.querySelector('canvas');
var context = canvas.getContext('2d');
var destinationUrl = document.getElementById('url');
var result = document.getElementById('result');

// Iniciamos los handlers
function D3Drop(element, _config) {
    
    dropArea    = _$(element);
    config      = _config!=undefined ? _config : {};
    result      = _config!=undefined && _config.result!=undefined ? _$(_config.result) : _$('#result');
    count       = _config!=undefined && _config.count!=undefined ? _$(_config.count) : _$('#count'); 
    
    dropArea.addEventListener('drop', handleDrop, false);
    dropArea.addEventListener('dragover', handleDragOver, false);
    dropArea.addEventListener("dragleave", handleDragOver, false);
}

// Evento - drop
function handleDrop(event) {
    event.stopPropagation();
    event.preventDefault();

    processFiles(event.dataTransfer.files);
}

// Procezamiento de archivos
function processFiles(filelist) {
    if (!filelist || !filelist.length || list.length) return;

    totalSize       = 0;
    totalProgress   = 0;
    
    if(result!=undefined) result.textContent = '';
    
    console.log('Files : ' + filelist.length);

    for (var i = 0; i < filelist.length && i < 5; i++) {
        list.push(filelist[i]);
        totalSize += filelist[i].size;
    }
    
    uploadNext();
}

// upload next file
function uploadNext() {
    if (list.length) {
        
        if(count!=undefined) count.textContent = list.length - 1;
        dropArea.className = 'uploading';

        var nextFile = list.shift();
        if (nextFile.size >= 262144) { // ?
            if(result!=undefined) result.innerHTML += '<div class="f">Too big file (max filesize exceeded)</div>';
            handleComplete(nextFile.size);
        } else {
            uploadFile(nextFile, status);
        }
    } else {
        dropArea.className = '';
    }
}

// on complete - start next file
function handleComplete(size) {
    totalProgress += size;
    drawProgress(totalProgress / totalSize);
    uploadNext();
}

// draw progress
function drawProgress(progress) {
    context.clearRect(0, 0, canvas.width, canvas.height); // clear context

    context.beginPath();
    context.strokeStyle = '#4B9500';
    context.fillStyle = '#4B9500';
    context.fillRect(0, 0, progress * 500, 20);
    context.closePath();

    // draw progress (as text)
    context.font = '16px Verdana';
    context.fillStyle = '#000';
    context.fillText('Progress: ' + Math.floor(progress*100) + '%', 50, 15);
}

    // drag over
    function handleDragOver(event) {
        event.stopPropagation();
        event.preventDefault();
        dropArea.className = "hover";
    }
    
    // drag leave
    function handleDragOver(event) {
        event.stopPropagation();
        event.preventDefault();
        dropArea.className = "";
    }

    // update progress
    function handleProgress(event) {
        var progress = totalProgress + event.loaded;
        drawProgress(progress / totalSize);
    }

    // upload file
    function uploadFile(file, status) {

        // prepare XMLHttpRequest
        var xhr = new XMLHttpRequest();
        xhr.open('POST', destinationUrl.value);
        xhr.onload = function() {
            result.innerHTML += this.responseText;
            handleComplete(file.size);
        };
        xhr.onerror = function() {
            result.textContent = this.responseText;
            handleComplete(file.size);
        };
        xhr.upload.onprogress = function(event) {
            handleProgress(event);
        }
        xhr.upload.onloadstart = function(event) {
        }

        // prepare FormData
        var formData = new FormData();  
        formData.append('myfile', file); 
        xhr.send(formData);
    }

    //initHandlers();

// Selector de elemento
function _$(element) {
    
    var elementName = element.substring(1, element.length);
    
    if(element.startsWith("#")) {
        return document.getElementById(elementName);
    }
    else if(element.startsWith(".")) {
        return document.getElementById(elementName);
    }
    else return undefined;

}

// Funcion para determinar si es inicial a class o id
if (typeof String.prototype.startsWith != 'function') {
    String.prototype.startsWith = function (str){
        return this.slice(0, str.length) == str;
    };
}