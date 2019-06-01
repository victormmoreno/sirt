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

                'prototipos',
                'servicios',
                'departamentos',
                'tiposdocumentos',
                'tiposarticulaciones',
                'ciudades',
                'sectores',
                'tiposmateriales',
                'tiposvinculaciones',
                'estadosideas',
                'regionales',
                'centrosformacion',
                // 'generos',
                'nodos',
                'estratos',
                'rol', //tabla vieja
                'roles',
                'ocupaciones',
                'users',
                'permissions',
                'lineas',
                'ideas',
                'nivelesacademicos',

            ]);
        }else if(app()->environment() == 'local'){
            $this->truncateTables([
                'gradosescolaridad',
                'servicios',
                'tiposdocumentos',
                'sectores',
                'tiposarticulaciones',
                'perfiles',
                'rols',//tabla vieja
                'estadosproyecto',
                'departamentos',
                'lineastecnologicas',
                'productos',
                'role_has_permissions',
                'roles',
                'permissions',
<<<<<<< HEAD
                'sublineas',
                'ciudades',
                'users',
=======
                'users',

>>>>>>> 6dd3e63e62a96183c85d29f48571d5e51212673e
            ]);
        }else{
            echo "NO PUESDES TRUNCAR TABLAS";
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
