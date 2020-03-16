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
                'gradosescolaridad',
                'gruposanguineos',
                'tiposvisitante',
                'areasconocimiento',
                'estadosidea',
                'tiposarticulacionesproyectos',
                'eps',
                'estadosproyecto',
                'estadosprototipos',
                'servicios',
                'departamentos',
                'tiposdocumentos',
                'tiposarticulaciones',
                'ciudades',
                'sectores',
                'regionales',
                'centros',
                'nodos',
                'roles',
                'ocupaciones',
                'ingresos',
                'infocenter',
                'dinamizador',
                'gestores',
                'talentos',
                'entidades',
                'users',
                'permissions',
                'lineastecnologicas',
                'fases',
                'tiposedt',
                'perfiles',
                'sublineas',
                'ideas',
                'ruta_model',
                'servidor_videos',
                'laboratorios',
                'equipos',
                'productos'

            ]);
        }else if(app()->environment() == 'local'){
            $this->truncateTables([
                'activation_tokens',
                'actividades',
                'aprobaciones',
                'archivoscharlasinformativas',
                'archivoscomites',
                'archivosedt',
                'archivosentrenamiento',
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
                'depreciaciones',
                'dinamizador',
                'edts',
                'edt_entidad',
                'empresas',
                'entidades',
                'entrenamientos',
                'entrenamiento_idea',
                'eps',
                'equipos',
                'equipo_mantenimiento',
                'equipo_uso',
                'estadosidea',
                'estadosprototipos',
                'estadosproyecto',
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
                'laboratorios',
                'lineastecnologicas',
                'lineastecnologicas_nodos',
                'mantenimientos',
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
                'perfiles',
                'permissions',
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
                'tiposarticulaciones',
                'tiposarticulaciones',
                'tiposarticulacionesproyectos',
                'tiposdocumentos',
                'tiposmateriales',
                'tiposedt',
                'tiposvisitante',
                'users',
                'usoinfraestructuras',    
                'uso_laboratorios',    
                'uso_talentos',    
                'visitantes',    
                'websockets_statistics_entries', 
                'productos'
            ]);
        }else{
            echo "NO PUEDES TRUNCAR TABLAS";
        }




        collect(config('seeders')[app()->environment()])
            ->where('callable', true)
            ->each(function ($seeder){
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
