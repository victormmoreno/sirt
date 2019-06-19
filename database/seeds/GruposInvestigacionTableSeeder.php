<?php

use App\Models\GrupoInvestigacion;
use Illuminate\Database\Seeder;

class GruposInvestigacionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(GrupoInvestigacion::class, 20)->create();
    }
}
