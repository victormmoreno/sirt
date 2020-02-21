const mix = require('laravel-mix');
const JavaScriptObfuscator = require('webpack-obfuscator');
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

mix.minify('public/js/app.js')
    mix.version();

mix.styles([
		'resources/assets/plugins/materialize/css/materialize.css',
		'resources/assets/plugins/materialize/css/material-icons.css',
		'resources/assets/plugins/font-awesome/css/all.css',
		'resources/assets/plugins/datatables/css/jquery.dataTables.min.css',
		'resources/assets/plugins/select2/css/select2.css',
		'resources/assets/plugins/materialize-clockpicker-master/dist/css/materialize.clockpicker.css',
		'resources/assets/plugins/bootstrap-datapicker/css/bootstrap-material-datetimepicker.css',
		'resources/assets/plugins/dropzone/dropzone.css',
		'resources/assets/plugins/dropzone/basic.min.css',
		'resources/assets/plugins/summernote/dist/summernote-lite.css',
		'resources/assets/css/alpha.css',
		'resources/assets/css/custom.css',
	],'public/css/libs.css');

mix.minify('public/css/libs.css')
    mix.version();

mix.scripts([
		'resources/assets/plugins/jquery/dist/jquery.js',
		'resources/assets/plugins/materialize/js/materialize.min.js',
		'resources/assets/plugins/jquery-blockui/jquery.blockui.js',
		'resources/assets/plugins/jquery-validation/jquery.validate.js',
		'resources/assets/plugins/jquery-steps/jquery.steps.min.js',
		'resources/assets/plugins/datatables/js/jquery.dataTables.js',
		'resources/assets/plugins/datatables/js/datatables.buttons.min.js',
		'resources/assets/plugins/font-awesome/js/all.js',
		'resources/assets/plugins/select2/js/select2.min.js',
		'resources/assets/plugins/select2/js/i18n/es.js',
		'resources/assets/plugins/dropzone/dropzone.js',
		'resources/assets/plugins/bootstrap-datapicker/js/bootstrap-material-datetimepicker.js',
		'resources/assets/plugins/materialize-clockpicker-master/dist/js/materialize.clockpicker.js',
		'resources/assets/plugins/highcharts/highcharts.js',
		'resources/assets/plugins/highcharts/modules/exporting.js',
		'resources/assets/plugins/highcharts/modules/export-data.js',
		'resources/assets/plugins/highcharts/modules/variable-pie.js',
    'resources/assets/plugins/summernote/dist/summernote-lite.js',
    'resources/assets/plugins/summernote/dist/lang/summernote-es-ES.js',
		'resources/assets/js/alpha.js',
		'resources/assets/js/custom.js'
	],'public/js/libs.js');

mix.minify('public/js/libs.js')
    mix.version();


mix.scripts([
		'resources/app/linea/administrador/index.js',
		'resources/app/linea/dinamizador/index.js',
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
		'resources/app/user/administrador/index-gestor.js',
		'resources/app/user/administrador/index-infocenter.js',
		'resources/app/user/administrador/index-talento.js',
		'resources/app/user/administrador/index-ingreso.js',
		'resources/app/user/dinamizador/index-gestor.js',
		'resources/app/user/dinamizador/index-talento.js',
		'resources/app/user/dinamizador/index-infocenter.js',
		'resources/app/user/dinamizador/index-ingreso.js',
		'resources/app/user/gestor/index-talento.js',
        'resources/app/user/search.js',
		'resources/app/user/infopersonal.js',
		'resources/app/user/estudio.js',
		'resources/app/user/tipotalento.js',
        'resources/app/user/create.js',
        'resources/app/user/edit.js',
		'resources/app/user/index-user.js',
		'resources/app/user/modaluser.js',
		'resources/app/user/role/roleuser.js',
		'resources/app/sublinea/administrador/index.js',
		'resources/app/articulaciones/gestor/index.js',
		'resources/app/articulaciones/index.js',
		'resources/app/intervenciones/gestor/index.js',
		'resources/app/intervenciones/index.js',
		'resources/app/proyecto/index.js',
		'resources/app/proyecto/gestor/form.js',
		'resources/app/proyecto/gestor/form_cierre.js',
		'resources/app/edt/gestor/form.js',
		'resources/app/edt/gestor/index.js',
		'resources/app/edt/index.js',
		'resources/app/laboratorio/administrador/index.js',
		'resources/app/laboratorio/dinamizador/index.js',
		'resources/app/costoadministrativo/dinamizador/index.js',
		'resources/app/costoadministrativo/dinamizador/index.js',
		'resources/app/equipos/administrador/index.js',
		'resources/app/equipos/dinamizador/index.js',
		'resources/app/equipos/gestor/index.js',
		'resources/app/mantenimiento/administrador/index.js',
		'resources/app/mantenimiento/dinamizador/index.js',
		'resources/app/mantenimiento/gestor/index.js',
		'resources/app/materiales/administrador/index.js',
		'resources/app/materiales/dinamizador/index.js',
		'resources/app/materiales/gestor/index.js',
		'resources/app/costoadministrativo/administrador/index.js',
		'resources/app/usoinfraestructura/administrador/index.js',
		'resources/app/usoinfraestructura/dinamizador/index.js',
		'resources/app/usoinfraestructura/index.js',
		'resources/app/visitante/index.js',
		'resources/app/ingreso/index.js',
		'resources/app/ingreso/ingreso/create.js',
		'resources/app/charla/index.js',
		'resources/app/graficos/index.js',
		'resources/app/seguimiento/index.js',
		'resources/app/costos/index.js',
		'resources/app/indicadores/index.js',
    'resources/app/publicacion/index.js',
    'resources/app/publicacion/form.js'
	],'public/js/app2.js');

mix.minify('public/js/app2.js')
    mix.version();


// mix.copy('node_modules/sweetalert2/dist/','public/sweetalert2/');


mix.browserSync({

        proxy: 'http://gestion2020.test',
        files: [
            'app/**/*',
            'resources/views/**/*',
            'resources/lang/**/*',
            'routes/**/*'
        ]
 });


 mix.webpackConfig({
	 plugins: [
		 new JavaScriptObfuscator ({
			 rotateUnicodeArray: true,
			 compact: true,
			 identifierNamesGenerator: 'hexadecimal',
		 }, ['public/js/app2.js'])
	 ],
 });
