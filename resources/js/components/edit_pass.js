import Swal from 'sweetalert2'
(function () {
    $(document).ready(function (e) {
        
        if ($("#form-edit-pass").length > 0) { 
            
            $("#form-edit-pass").submit(function (event) {
                event.preventDefault();
                                
                let url      = "/api/user/edit_pass";
                let myForm   = document.getElementById('form-edit-pass');
                let formData = new FormData(myForm);

                $('.form-error').hide();
                $('.form-error').html('');
                $('#spinner-form').show();
                $('input').removeClass('is-invalid');

                axios.post
                    (url, formData)
                    .then(function (response) {
                        var result = response.data;
                        $('#spinner-form').hide();
                        document.getElementById('form-edit-pass').reset();
                        Swal.fire({
                            type: 'success',
                            text: 'Password actualizado',
                        })


                    })
                    .catch(function (error) {
                        var result = error.response.data;
                        var errors = result.errors;
                        $('.form-error').show();
                        $('#spinner-form').hide();
                        for (var k in errors) {
                            if (typeof errors[k] !== 'function') {
                                $('.' + k).html(errors[k]);
                                $('#' + k).addClass('is-invalid');

                            }
                        }


                    })
            });
        }
    });
})();