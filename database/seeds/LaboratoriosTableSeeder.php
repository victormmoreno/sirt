<?php

use App\Models\Laboratorio;
use Illuminate\Database\Seeder;

class LaboratoriosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Laboratorio::class, 10)->create();
    }
}
