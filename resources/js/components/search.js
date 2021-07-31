if ( $("#form-search").length > 0 ) {
    $( "#form-search" ).submit(function( event ) {
        event.preventDefault();
        var url = '/search';

        let myForm = document.getElementById('form-search');
        let formData = new FormData(myForm);
        axios.post
        (url, formData)
            .then(function (response) {

            })
            .catch(function (error) {
                $('#spinner-reservacion').hide();



            })
            .then(function () {
            });
    });
}