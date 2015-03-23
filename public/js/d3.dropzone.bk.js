/**
    Funciton para determinar si un acadena comienza con "n" caracter
*/
if (typeof String.prototype.startsWith != 'function') {
    String.prototype.startsWith = function (str){
        return this.slice(0, str.length) == str;
    };
}

/*
    Constructor
*/
function D3Drop(element, config) {
    
    // COnfiguracion de selectores
    this.fileselect = config!=undefined ? _$(config.fileselect) : _$(".fileselect");
    this.filedrag   = config!=undefined ? _$(config.filedrag) : _$(".filedrag");
    this.submitbtn  = config!=undefined ? _$(config.submitbtn) : _$(".submitbutton");
    
    // Evento para seleccion de archivo
    this.fileselect.addEventListener("change", FileSelectHandler, false);
    
    // Es XHR2 disponible?
    var xhr = new XMLHttpRequest();
    if (xhr.upload) {

        // file drop
        this.filedrag.addEventListener("dragover", FileDragHover, false);
        this.filedrag.addEventListener("dragleave", FileDragHover, false);
        this.filedrag.addEventListener("drop", FileSelectHandler, false);
        //filedrag.style.display = "block";

        // remove submit button
        //submitbutton.style.display = "none";
    }
}

/**
    Function para seleccionar un elemento
*/
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

/**
    Handler para seleccion de archivo
*/
function FileSelectHandler(e) {

    // cancel event and hover styling
    FileDragHover(e);

    // fetch FileList object
    var files = e.target.files || e.dataTransfer.files;

    console.log(files);
    // process all File objects
    //for (var i = 0, f; f = files[i]; i++) {
    //    this.ParseFile(f);
    //}

}

/**
    Handler de funcion drag hover
*/
function FileDragHover(e) {
    e.stopPropagation();
    e.preventDefault();
    e.target.className = (e.type == "dragover" ? "hover" : "");
}