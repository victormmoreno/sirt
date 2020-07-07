<?php

use Illuminate\Database\Seeder;
use App\Models\Visitante;

class VisitantesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Visitante::class, 300)->create();
    }
}
