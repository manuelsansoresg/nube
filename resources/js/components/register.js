import Swal from 'sweetalert2'
if ( $(".register").length > 0 ) {

    window.onload = function () {
        var fileupload = document.getElementById("photo");
        var filePath   = document.getElementById("spnFilePath");
        var image      = document.getElementById("image_preview");

        image.onclick = function () {
            fileupload.click();
        };

        function changeSocialUser(){
            var result = [];
            axios.get
            ('/social_user/'+$('#user_id').val())
                .then(function (response) {
                    result = response.data;

                })
                .catch(function (error) {

                })
                .then(function () {
                    for (let i_social = 0; i_social < result.length; i_social++) {
                        $('#social-'+result[i_social].id+'').val(result[i_social].name);
                        /*$("#town_id").append(new Option(result[i_town].name, result[i_town].id));*/
                    }
                });
        }


        window.changeState = function (){
            $('#town_id').empty();

            var estado = $('#state_id').val();
            var url    = '/state_town/' + estado;

            axios.get
            (url)
                .then(function (response) {
                    $('#town_id').empty();
                    $("#town_id").append(new Option('-Municipio-', ''));

                    var result = response.data;
                    for (let i_town = 0; i_town < result.length; i_town++) {

                        $("#town_id").append(new Option(result[i_town].name, result[i_town].id));
                    }
                })
                .catch(function (error) {

                })
                .then(function () {
                    if ( $("#edit-registro").length > 0 ) {
                        var my_satate = $('#my_town').val();
                        $("#town_id option[value= "+my_satate+" ]").attr('selected', 'selected');
                    }
                });
        }

        fileupload.onchange = function () {
            var fileName = fileupload.value.split('\\')[fileupload.value.split('\\').length - 1];
            /* filePath.innerHTML = "<b>Selected File: </b>" + fileName;*/
            var fileExtension = ['jpeg', 'jpg', 'png'];
            if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                $('#error-photo').show();
                $('#error-photo').html("El campo foto debe ser un archivo de tipo jpeg, jpeg, png.");
            }
            else {
                $('#error-photo').hide();
                /* vista previa imagen */
                var ImagePreview = document.getElementById('image_preview');
                var UploadFile   = document.getElementById('photo').files[0];
                var ReaderObj    = new FileReader();
                ReaderObj.onloadend = function () {
                    ImagePreview.src = ReaderObj.result;
                };

                if (UploadFile) {
                    ReaderObj.readAsDataURL(UploadFile);
                } else {
                    ImagePreview.src = '';
                }

            }
        };
        if ( $("#edit-registro").length > 0 ) {
            changeState();
            changeSocialUser();
        }


    };


    /* click botones redes sociales*/
    $(".item").on('click', function (ev) {
        const name      = $(this).attr("data-name");
        const id        = $(this).attr("data-id");
        var placeholder = 'Tú sitio';

        if(name != 'http://'){
            placeholder = 'Usuario';
        }
        $('.item-social').addClass('d-none'); //ocultar todos los elementos
        $('#social-'+id+'').removeClass('d-none'); //quitar lo oculto al elemento seleccionado
        $('#social-'+id+'').attr("placeholder", placeholder); //agregar placeholder al elemento seleccionado
        $('#sitio-url').html(name); //agregar placeholder al elemento seleccionado


    });


    /*cargar municipio*/
    $( "#state_id" ).change(function() {
        changeState();
    });



    /* registro*/
    $( "#form-registro" ).submit(function( event ) {
        event.preventDefault();

        $('.registro-error').hide();
        $('.registro-error').html('');
        $('input').removeClass('is-invalid');
        $('select').removeClass('is-invalid');

        $('#spinner-registro').show();
        var url = '/usuario/'+$('#user_id').val();

        if ( $("#edit-registro").length === 0 ) {
            url = '/user/register';
        }

        let myForm   = document.getElementById('form-registro');
        let formData = new FormData(myForm);


        axios.post
        (url, formData)
            .then(function (response) {
                var result = response.data;
                $('#spinner-contacto').hide();
                /*document.getElementById('form-contacto').reset();*/
                if(result.status == 200 ){
                    if ($("#edit-registro").length === 0) {
                        window.location = '/';
                    }else{
                        
                        Swal.fire({
                            type: 'success',
                            text: 'Usuario actualizado',
                        })
                        $('#spinner-registro').hide();
                    }

                }


            })
            .catch(function (error) {
                var result = error.response.data;
                var errors = result.errors;
                $('.registro-error').show();
                $('#spinner-registro').hide();
                for (var k in errors){
                    if (typeof errors[k] !== 'function') {
                        $('.'+k).html(errors[k]);
                        $('#'+k).addClass('is-invalid');

                    }
                }


            })
            
    });
}


