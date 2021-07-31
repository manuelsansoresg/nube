window.valImage = function(obj){
    var uploadFile = obj.files[0];

    if (!window.FileReader) {
        alert('El navegador no soporta la lectura de archivos');
        return;
    }

    if (!(/\.(jpg|png|gif)$/i).test(uploadFile.name)) {
        alert('El archivo a adjuntar no es una imagen');
    } 
    else {
        var img = new Image();
        img.onload = function () {
            if (uploadFile.size > 300000) {
                alert('El peso de la imagen no puede exceder los 3Mb')
            }
            
        };
        img.src = URL.createObjectURL(uploadFile);
    }                 
}