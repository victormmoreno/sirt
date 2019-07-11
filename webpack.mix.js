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

mix.js('resources/js/app.js', 'public/js');

mix.styles([
		'resources/assets/plugins/materialize/css/materialize.css',
		'resources/assets/plugins/materialize/css/material-icons.css',
		'resources/assets/plugins/datatables/css/jquery.dataTables.min.css',
		'public/sweetalert2/sweetalert2.css',
		'resources/assets/plugins/select2/css/select2.css',
		'resources/assets/plugins/materialize-clockpicker-master/dist/css/materialize.clockpicker.css',
		'resources/assets/plugins/bootstrap-datapicker/css/bootstrap-material-datetimepicker.css',
		'resources/assets/plugins/dropzone/dropzone.css',
		'resources/assets/plugins/dropzone/basic.min.css',
		'resources/assets/css/alpha.css',
		'resources/assets/css/custom.css',


	],'public/css/libs.css');

mix.scripts([
		'resources/assets/plugins/jquery/dist/jquery.js',
		'resources/assets/plugins/materialize/js/materialize.min.js',
		'resources/assets/plugins/jquery-blockui/jquery.blockui.js',
		'resources/assets/plugins/datatables/js/jquery.dataTables.js',
		'public/sweetalert2/sweetalert2.min.js',
		'resources/assets/plugins/select2/js/select2.min.js',
		'resources/assets/plugins/select2/js/i18n/es.js',
		'resources/assets/plugins/dropzone/dropzone.js',
		'resources/assets/plugins/bootstrap-datapicker/js/bootstrap-material-datetimepicker.js',
		'resources/assets/plugins/materialize-clockpicker-master/dist/js/materialize.clockpicker.js',
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
		'resources/app/entrenamientos/administrador/index.js',
		'resources/app/entrenamientos/infocenter/index.js',
		'resources/app/entrenamientos/infocenter/create.js',
		'resources/app/entrenamientos/infocenter/edit.js',
		'resources/app/comite/infocenter/index.js',
		'resources/app/comite/infocenter/create.js',
		'resources/app/comite/gestor/index.js',
		'resources/app/comite/administrador/index.js',
		'resources/app/empresa/index.js',
		'resources/app/grupoinvestigacion/index.js',
		'resources/app/user/administrador/index-administrador.js',
		'resources/app/user/administrador/index-dinamizador.js',
		'resources/app/sublinea/administrador/index.js',
		'resources/app/articulaciones/gestor/index.js',
		'resources/app/articulaciones/index.js',
		'resources/app/proyecto/index.js',
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
