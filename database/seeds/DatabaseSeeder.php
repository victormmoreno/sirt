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
