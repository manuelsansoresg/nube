require('./bootstrap');

require('./vendor/tagcanvas');
require('./components/register');
require('./components/descubre');
require('./components/calendar');
require('./components/payment');
require('./components/heart');
require('./components/edit_pass');
require('./components/image');

//*abrir modal con recompensa si se adjunto
    
window.openRewards = function () {
    $('#loadrewards').modal('show'); 
}