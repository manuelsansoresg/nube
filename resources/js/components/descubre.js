/*funcion perfil aleatorio*/

if ( $("#tagcanvas").length > 0 ) {
    $(function () {
        var seconds              = 2000;
        var total_second_profile = 0;
        var cont                 = 0;
        var total_users          = 0;
        var user;
        var path = '';
        function getProfile() {
            var url = '/profile/random';
            axios.get
            (url)
                .then(function (response) {
                    var result = response.data;
                    var total = result.users.length;

                    total_second_profile = total * seconds;
                    total_users = total;
                    user = result.users;
                    path = result.path;

                })
                .catch(function (error) {

                })
                .then(function () {
                });
        }

        function randomProfile() {
            cont = cont + 1;

            if (cont <= total_users){
                var image = '/' + path + '/' + user[cont - 1].id +'/thumb-'+user[cont-1].photo;
                var profile = '/usuario/'+user[cont-1].id; 

                $('#img-rand').attr('src', image);
                $('.lnk-random').attr('href', profile);
                $('#user-random').html(user[cont-1].username);
            }else{
                cont = 0;
                setTimeout(getProfile, total_second_profile);
            }
        }

        setTimeout(getProfile, total_second_profile);
        setInterval(randomProfile, 2000);
    });

    /* funcion perfil aleatorio*/

    /* descubre*/
    var oopts = {
        textFont: 'Impact,Arial Black,sans-serif',
        textHeight: 20,
        maxSpeed: 0.1,
        decel: 0.9,
        depth: 0.99,
        outlineColour: '#f6f',
        outlineThickness: 3,
        pulsateTo: 0.2,
        pulsateTime: 0.5,
        wheelZoom: false
    }, ttags = 'iconTags', lock, shape = 'sphere';
    window.onload = function() {
        TagCanvas.textFont = 'Roboto, Trebuchet MS, Helvetica, sans-serif';
        TagCanvas.textColour = null;
        TagCanvas.textHeight = 40;
        TagCanvas.outlineMethod = 'block';
        TagCanvas.outlineColour = '#F2F2F2';
        TagCanvas.maxSpeed = 0.03;
        TagCanvas.minBrightness = 0.2;
        TagCanvas.depth = 0.92;
        TagCanvas.pulsateTo = 0.6;
        TagCanvas.initial = [0.1,-0.1];
        TagCanvas.decel = 0.98;
        TagCanvas.reverse = true;
        TagCanvas.hideTags = false;
        TagCanvas.shadow = '#F2F2F2';
        TagCanvas.shadowBlur = 3;
        TagCanvas.weight = true;
        TagCanvas.imageScale = 1;
        TagCanvas.fadeIn = 1000;
        TagCanvas.clickToFront = 600;
        TagCanvas.freezeActive = true;
        TagCanvas.wheelZoom = false;

        TagCanvas.tooltip = 'div';
        TagCanvas.tooltipClass = 'badge badge-info text-white';
        TagCanvas.Start('tagcanvas','iconTags');
    };
    /* /descubre*/
}