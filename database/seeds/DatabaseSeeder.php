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
        // $this->call(UsersTableSeeder::class);

        $this->truncateTables([

            'prototipos',
            'servicios',
            'departamentos',
            'tiposdocumentos',
            'ciudades',
            'sectores',
            'tiposmateriales',
            'tiposvinculaciones',
            'estadosideas',
            'regionales',
            'centrosformacion',
            'generos',
            'nodos',
            'estratos',
            'rol', //tabla vieja
            'roles'

        ]);
        $this->call([
            PrototiposTableSeeder::class,
            ServiciosTableSeeder::class,
            DepartamentosTableSeeder::class,
            TiposDocumentosTableSeeder::class,
            CiudadesTableSeeder::class,
            SectoresTableSeeder::class,
            TiposMaterialesTableSeeder::class,
            TiposVinculacionesTableSeeder::class,
            EstadosIdeasTableSeeder::class,
            RegionalesTableSeeder::class,
            CentrosFormacionTableSeeder::class,
            GenerosTableSeeder::class,
            NodosTableSeeder::class,
            EstratosTableSeeder::class,
            RolsTableSeeder::class, //seeder de la tabla vieja
            RolsTableSeeder::class, 
            RoleTableSeeder::class, 

        ]);
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
