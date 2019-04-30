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
    .sass('resources/sass/app.scss', 'public/css');

mix.styles([
		'resources/assets/css/libs/materialize/materialize.min.css',
		'resources/assets/css/libs/metrojs/MetroJs.min.css',
		'resources/assets/css/libs/weather-icons-master/weather-icons.min.css',
		'resources/assets/css/libs/theme/alpha.min.css',
		'resources/assets/css/libs/theme/custom.css'
	],'public/css/libs.css');


mix.scripts([
		'resources/assets/js/libs/jquery/jquery-2.2.0.min.js',
		'resources/assets/js/libs/materialize/materialize.min.js',
		'resources/assets/js/libs/materalize-preloader/materialPreloader.min.js',
		'resources/assets/js/libs/jquery-blockui/jquery.blockui.js',
		'resources/assets/js/libs/waypoints/jquery.waypoints.min.js',
		'resources/assets/js/libs/counter-up-master/jquery.counterup.min.js',
		'resources/assets/js/libs/jquery-sparkline/jquery.sparkline.min.js',
		// 'resources/assets/js/libs/chartjs/chart.min.js',
		'resources/assets/js/libs/flot/jquery.flot.min.js',
		'resources/assets/js/libs/flot/jquery.flot.time.min.js',
		'resources/assets/js/libs/flot/jquery.flot.symbol.min.js',
		'resources/assets/js/libs/flot/jquery.flot.symbol.min.js',
		'resources/assets/js/libs/flot/jquery.flot.tooltip.min.js',
		'resources/assets/js/libs/curvedlines/curvedLines.js',
		'resources/assets/js/libs/peity/jquery.peity.min.js',
		'resources/assets/js/libs/theme/alpha.min.js',
		// 'resources/assets/js/libs/theme/dashboard.js',
	],'public/js/libs.js');
