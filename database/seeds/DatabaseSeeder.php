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

                'gruposanguineos',
                'eps',
                'servicios',
                'departamentos',
                'tiposdocumentos',
                'tiposarticulaciones',
                'tipos_materiales',
                'ciudades',
                'sectores',
                'tiposmateriales',
                'tiposvinculaciones',
                'estadosideas',
                'regionales',
                'centrosformacion',
                'nodos',
                'estratos',
                'roles',
                'ocupaciones',
                'ingresos',
                'infocenter',
                'dinamizador',
                'gestores',
                'talentos',
                'users',
                'permissions',
                'lineas',
                'ideas',
                'nivelesacademicos',
                'fases',
                'ideas',
                'ruta_model',
                'servidor_videos',
                'laboratorios',

            ]);
        }else if(app()->environment() == 'local'){
            $this->truncateTables([
                'gradosescolaridad',
                'gruposanguineos',
                'eps',
                'clasificacionescolciencias',
                'servicios',
                'ocupaciones',
                'tiposdocumentos',
                'ocupaciones',
                'estadosidea',
                'tipos_materiales',
                'sectores',
                'tiposarticulaciones',
                'tiposarticulacionesproyectos',
                'perfiles',
                'estadosproyecto',
                'departamentos',
                'lineastecnologicas',
                'estadosprototipos',
                'role_has_permissions',
                'model_has_roles',
                'model_has_permissions',
                'roles',
                'permissions',
                'sublineas',
                'ciudades',
                'regionales',
                'entidades',
                'centros',
                'nodos',
                'tecnoacademias',
                'ingresos',
                'infocenter',
                'dinamizador',
                'gestores',
                'talentos',
                'users',
                'gruposinvestigacion',
                'empresas',
                'ocupaciones_users',
                'fases',
                'contactosentidades',
                'areasconocimiento',
                'ideas',
                'tiposedt',
                'tiposvisitante',
                'ruta_model',
                'servidor_videos',
                'laboratorios',
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
