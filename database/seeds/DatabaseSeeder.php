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
        $this->call(DepartamentsTableSeeder::class);
        $this->call(CitiesTableSeeder::class);
        $this->call(SectorsTableSeeder::class);
        $this->call(ServicesTableSeeder::class);
        $this->call(DocumentsTypesTableSeeder::class);
        $this->call(ColcienciasClassificationsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
    }
}
