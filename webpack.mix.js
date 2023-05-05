const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */



mix.js('resources/js/app.js', 'public/js')
    //.sass('resources/sass/app.scss', 'public/css');
.scripts([
    "public/assets/js/core/jquery.3.2.1.min.js",
    "public/assets/js/core/popper.min.js",
    "public/assets/js/core/bootstrap.min.js",
    "public/assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js",
    "public/assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js",
    "public/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js",
    "public/assets/js/plugin/moment/moment.min.js",
    "public/assets/js/plugin/chart.js/chart.min.js",
    "public/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js",
    "public/assets/js/plugin/chart-circle/circles.min.js",
    "public/assets/js/plugin/datatables/datatables.min.js",
    "public/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js",
    "public/assets/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js",
    "public/assets/js/plugin/jqvmap/jquery.vmap.min.js",
    "public/assets/js/plugin/jqvmap/maps/jquery.vmap.world.js",
    "public/assets/js/plugin/gmaps/gmaps.js",
    "public/assets/js/plugin/sweetalert/sweetalert.min.js",
    "public/assets/js/select2.js",
    "public/assets/js/gijgo.min.js",
    "public/assets/js/messages.fr-fr.min.js",
    "public/assets/js/ready.min.js"
],'public/js/all.js').disableNotifications()



.styles([
    
    "public/assets/css/bootstrap.min.css",
    "public/assets/css/azzara.min.css",
    "public/assets/css/select2.css",
    "public/assets/css/select2-bootstrap4.min.css",
    //"public/assets/css/demo.css",
    "public/assets/css/style.css",
],'public/css/app.css');

