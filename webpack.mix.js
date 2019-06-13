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

// mix.js('resources/js/app.js', 'public/js')
//     .sass('resources/sass/app.scss', 'public/css');

mix.js('resources/js/app.js', 'public/js');
// mix.styles([
// 		'resources/assets/css/libs/materialize/materialize.min.css',
// 		'resources/assets/css/libs/metrojs/MetroJs.min.css',
// 		'resources/assets/css/libs/weather-icons-master/weather-icons.min.css',
// 		'resources/assets/css/libs/theme/alpha.css',
// 		'resources/assets/css/libs/theme/custom.css'
// 	],'public/css/libs.css');


// mix.styles([
// 		'resources/assets/plugins/materialize/css/materialize.css',
// 		// 'resources/assets/plugins/materialize/css/material-icons.css',
// 		'resources/assets/plugins/material-preloader/css/materialPreloader.min.css',
// 		'resources/assets/plugins/weather-icons-master/css/weather-icons.min.css',
// 		'resources/assets/plugins/datatables/css/jquery.dataTables.min.css',
// 		'resources/assets/plugins/sweetalert/sweetalert.css',
// 		'resources/assets/plugins/select2/css/select2.css',
// 		'resources/assets/plugins/google-code-prettify/prettify.css',
// 		'resources/assets/plugins/jquery-jvectormap/jquery-jvectormap-2.0.3.css',
// 		'resources/assets/css/alpha.css',
// 		// 'resources/assets/plugins/introjs/introjs.css',
// 		'resources/assets/css/custom.css',
// 		'resources/assets/plugins/bootstrap-datapicker/css/bootstrap-material-datetimepicker.css',
// 		'resources/assets/plugins/materialize-clockpicker-master/dist/css/materialize.clockpicker.css',

// 	],'public/css/libs.css');


mix.styles([
		'resources/assets/plugins/materialize/css/materialize.min.css',
		'resources/assets/plugins/materialize/css/material-icons.css',
		'resources/assets/plugins/datatables/css/jquery.dataTables.min.css',
		'resources/assets/plugins/bootstrap-datapicker/css/bootstrap-material-datetimepicker.css',
		'public/sweetalert2/sweetalert2.css',
		'resources/assets/plugins/materialize-clockpicker-master/dist/css/materialize.clockpicker.css',
		'resources/assets/plugins/dropzone/dropzone.css',
		'resources/assets/plugins/dropzone/basic.min.css',
		'resources/assets/css/alpha.css',
		'resources/assets/css/custom.css',


	],'public/css/libs.css');


// mix.scripts([
// 		'resources/assets/js/libs/jquery/jquery-2.2.0.min.js',
// 		'resources/assets/js/libs/materialize/materialize.min.js',
// 		'resources/assets/js/libs/materalize-preloader/materialPreloader.min.js',
// 		'resources/assets/js/libs/jquery-blockui/jquery.blockui.js',
// 		'resources/assets/js/libs/waypoints/jquery.waypoints.min.js',
// 		'resources/assets/js/libs/counter-up-master/jquery.counterup.min.js',
// 		'resources/assets/js/libs/jquery-sparkline/jquery.sparkline.min.js',
// 		// 'resources/assets/js/libs/chartjs/chart.min.js',
// 		'resources/assets/js/libs/flot/jquery.flot.min.js',
// 		'resources/assets/js/libs/flot/jquery.flot.time.min.js',
// 		'resources/assets/js/libs/flot/jquery.flot.symbol.min.js',
// 		'resources/assets/js/libs/flot/jquery.flot.symbol.min.js',
// 		'resources/assets/js/libs/flot/jquery.flot.tooltip.min.js',
// 		'resources/assets/js/libs/curvedlines/curvedLines.js',
// 		'resources/assets/js/libs/peity/jquery.peity.min.js',
// 		'resources/assets/js/libs/theme/alpha.min.js',
// 		// 'resources/assets/js/libs/theme/dashboard.js',
// 	],'public/js/libs.js');
//


// mix.scripts([
// 		'resources/assets/plugins/jquery/jquery-2.2.0.min.js',
// 		'resources/assets/plugins/materialize/js/materialize.min.js',
// 		'resources/assets/plugins/material-preloader/js/materialPreloader.min.js',
// 		'resources/assets/plugins/jquery-blockui/jquery.blockui.js',
// 		'resources/assets/plugins/google-code-prettify/prettify.js',
// 		'resources/assets/plugins/datatables/js/jquery.dataTables.js',
// 		'resources/assets/plugins/sweetalert/sweetalert.min.js',
// 		'resources/assets/plugins/select2/js/select2.min.js',
// 		'resources/assets/plugins/select2/js/i18n/es.js',
// 		'resources/assets/plugins/datatables/js/pdfmake.min.js',
// 		'resources/assets/plugins/datatables/js/vfs_fonts.js',
// 		'resources/assets/plugins/datatables/js/bprint.min.js',
// 		// 'resources/assets/js/pages/form-select2.js',
// 		'resources/assets/plugins/materialize-clockpicker-master/dist/js/materialize.clockpicker.js',
// 		'resources/assets/plugins/jquery-idletimer/idle-timer.js',
// 		'resources/assets/js/alpha.min.js',

// 	],'public/js/libs.js');
//
mix.scripts([
		'resources/assets/plugins/jquery/dist/jquery.js',
		'resources/assets/plugins/materialize/js/materialize.min.js',
		'resources/assets/plugins/datatables/js/jquery.dataTables.js',
		'resources/assets/plugins/jquery-blockui/jquery.blockui.js',
		'resources/assets/plugins/dropzone/dropzone.js',
		'resources/assets/plugins/bootstrap-datapicker/js/bootstrap-material-datetimepicker.js',
		'resources/assets/plugins/materialize-clockpicker-master/dist/js/materialize.clockpicker.js',
		'public/sweetalert2/sweetalert2.min.js',
		'resources/assets/js/alpha.js',
		'resources/assets/js/custom.js',
	],'public/js/libs.js');

mix.scripts([
		'resources/app/linea/administrador/index.js',
		'resources/app/nodo/administrador/index.js',
		'resources/app/ideas/infocenter/index.js',
		'resources/app/ideas/administrador/index.js',
		'resources/app/ideas/gestor/index.js',
		'resources/app/entrenamientos/index.js',
		'resources/app/entrenamientos/infocenter/index.js',
		'resources/app/entrenamientos/infocenter/create.js',
		'resources/app/entrenamientos/infocenter/edit.js',
		'resources/app/user/administrador/index-administrador.js',
	],'public/js/app2.js');

mix.copy('node_modules/sweetalert2/dist/','public/sweetalert2/');

mix.browserSync({

        proxy: 'http://gestion2019.test',
        files: [
            'app/**/*',
            'resources/views/**/*',
            'resources/lang/**/*',
            'routes/**/*'
        ]
 });
