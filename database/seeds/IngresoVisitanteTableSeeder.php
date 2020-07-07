<?php

use Illuminate\Database\Seeder;
use App\Models\IngresoVisitante;

class IngresoVisitanteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(IngresoVisitante::class, 400)->create();
    }
}
