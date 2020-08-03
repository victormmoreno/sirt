<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (app()->environment() == 'production') {
            $this->truncateTables([
                'permissions',
                'activation_tokens',
                'actividades',
                'archivos_articulacion_proyecto',
                'areasconocimiento',
                'articulaciones',
                'articulaciones_productos',
                'articulacion_proyecto',
                'articulacion_proyecto_talento',
                'categoria_material',
                'centros',
                'charlasinformativas',
                'ciudades',
                'clasificacionescolciencias',
                'comites',
                'comite_idea',
                'contactosentidades',
                'costos_administrativos',
                'departamentos',
                'dinamizador',
                'edts',
                'edt_entidad',
                'empresas',
                'entidades',
                'entrenamientos',
                'entrenamiento_idea',
                'eps',
                'etnias',
                'equipos',
                'equipo_mantenimiento',
                'equipo_uso',
                'estadosidea',
                'publicaciones',
                'estados_comite',
                'failed_jobs',
                'fases',
                'gestores',
                'gestor_uso',
                'gradosescolaridad',
                'gruposanguineos',
                'gruposinvestigacion',
                'ideas',
                'infocenter',
                'ingresos',
                'ingresos_visitantes',
                'jobs',
                'lineastecnologicas',
                'lineastecnologicas_nodos',
                'materiales',
                'material_uso',
                'medidas',
                'model_has_permissions',
                'model_has_roles',
                'nodos',
                'nodo_costoadministrativo',
                'notifications',
                'ocupaciones',
                'ocupaciones',
                'ocupaciones_users',
                'password_resets',
                'presentaciones',
                'presentaciones',
                'proyectos',
                'regionales',
                'roles',
                'role_has_permissions',
                'ruta_model',
                'sectores',
                'servicios',
                'servidor_videos',
                'sublineas',
                'talentos',
                'tecnoacademias',
                'tiposdocumentos',
                'tiposmateriales',
                'tiposedt',
                'tiposvisitante',
                'users',
                'usoinfraestructuras',
                'uso_talentos',
                'visitantes',
                'websockets_statistics_entries',
                'productos',
                'tipo_talentos',
                'tipo_estudio',
                'tipo_formacion',
                'tipos_empresas',
                'tamanhos_empresas',

            ]);
        } else if (app()->environment() == 'local') {
            $this->truncateTables([
                'activation_tokens',
                'actividades',
                'archivos_articulacion_proyecto',
                'areasconocimiento',
                'articulaciones',
                'articulacion_proyecto',
                'articulacion_proyecto_talento',
                'categoria_material',
                'centros',
                'charlasinformativas',
                'ciudades',
                'clasificacionescolciencias',
                'comites',
                'comite_idea',
                'contactosentidades',
                'costos_administrativos',
                'departamentos',
                'dinamizador',
                'edts',
                'edt_entidad',
                'empresas',
                'entidades',
                'entrenamientos',
                'entrenamiento_idea',
                'eps',
                'etnias',
                'equipos',
                'equipo_mantenimiento',
                'equipo_uso',
                'estadosidea',
                'propietarios',
                'objetivos_especificos',
                'estados_comite',
                'failed_jobs',
                'fases',
                'gestores',
                'gestor_uso',
                'gradosescolaridad',
                'gruposanguineos',
                'gruposinvestigacion',
                'ideas',
                'infocenter',
                'ingresos',
                'ingresos_visitantes',
                'jobs',
                'lineastecnologicas',
                'lineastecnologicas_nodos',
                'materiales',
                'material_uso',
                'medidas',
                'model_has_permissions',
                'model_has_roles',
                'nodos',
                'nodo_costoadministrativo',
                'notifications',
                'ocupaciones',
                'ocupaciones',
                'ocupaciones_users',
                'password_resets',
                'permissions',
                'presentaciones',
                'proyectos',
                'regionales',
                'roles',
                'role_has_permissions',
                'ruta_model',
                'sectores',
                'servicios',
                'servidor_videos',
                'sublineas',
                'talentos',
                'tecnoacademias',
                'tiposdocumentos',
                'tiposmateriales',
                'tiposedt',
                'tiposvisitante',
                'users',
                'usoinfraestructuras',
                'uso_talentos',
                'visitantes',
                'websockets_statistics_entries',
                'productos',
                'tipo_talentos',
                'tipo_estudio',
                'tipo_formacion',
                'tipos_empresas',
                'tamanhos_empresas',
            ]);
        } else {
            echo "NO PUEDES TRUNCAR TABLAS";
        }




        collect(config('seeders')[app()->environment()])
            ->where('callable', true)
            ->each(function ($seeder) {
                $this->call($seeder['name']);
            });
    }

    protected function truncateTables(array $tables)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
