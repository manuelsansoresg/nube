if ($(".calendarHeader").length > 0) {
    /*$('.calendarHeader').tagsInput({
        'defaultText': 'escribe tus palabras clave separadas por  ,',
        'width': '100%',
        'height': '53px',
        'placeholderColor': '#999',
        'delimiter': [',', ';', ' '],
    });*/


    $("#form-title").submit(function (e) {
        e.preventDefault();
        $('.titulos-error').hide();
        $('.titulos-error').html('');
        $('#spinner-titulos').show();

        const form = document.getElementById('form-title');
        let data = new FormData(form);
        var btn_mercado = $('#btn-mercado').val();

        const config = {
            headers:{
                'Content-Type' : 'multipart/form-data',
            }
        };

        axios.post('/api/pago', data, config)
            .then(function (response) {
                result = response.data;
                //location.href = '/pago-success?token=' + $('#token_pay').val();
                location.href = btn_mercado;

            })
            .catch(error => {
                var result = error.response.data;
                var errors = result.errors;
                $('.titulos-error').show();
                $('#spinner-titulos').hide();
                for (var k in errors) {
                    if (typeof errors[k] !== 'function') {
                        $('.' + k).html(errors[k]);
                        $('#' + k).addClass('is-invalid');

                    }
                }
            })


        /*var $keywords = $("#tags").siblings(".tagsinput").children(".tag");
        var tags = [];
        
        for (var i = $keywords.length; i--;) {
            tags.push($($keywords[i]).text().substring(0, $($keywords[i]).text().length - 1).trim());
        }*/

        /* axios.post
            ('/api/pago', {btn_mercado:btn_mercado, title:$('#title').val(), _token: document .querySelector('meta[name="csrf-token"]').getAttribute('content') })
            .then(function (response) {
                result = response.data;
                location.href = '/pago-success?token=' + $('#token_pay').val();

            })
            .catch(function (error) {
                var result = error.response.data;
                var errors = result.errors;
                $('.titulos-error').show();
                $('#spinner-titulos').hide();
                for (var k in errors) {
                    if (typeof errors[k] !== 'function') {
                        $('.' + k).html(errors[k]);
                        $('#' + k).addClass('is-invalid');

                    }
                }


            }) */
           
    });

}
