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

            'departamento',
            'ciudad',
            'sector',
            'servicio',
            'tipodocumento',
            'clasificacioncolciencias',
            'rol',

        ]);
        $this->call([
            DepartamentsTableSeeder::class,
            CitiesTableSeeder::class,
            SectorsTableSeeder::class,
            ServicesTableSeeder::class,
            DocumentsTypesTableSeeder::class,
            ColcienciasClassificationsTableSeeder::class,
            RolesTableSeeder::class,

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
