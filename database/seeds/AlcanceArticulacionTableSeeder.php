<?php

use App\Models\AlcanceArticulacion;
use Illuminate\Database\Seeder;

class AlcanceArticulacionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AlcanceArticulacion::create([
            'nombre' => 'Internacional',
        ]);

        AlcanceArticulacion::create([
            'nombre' => 'Nacional',
        ]);

        AlcanceArticulacion::create([
            'nombre' => 'Regional',
        ]);

        AlcanceArticulacion::create([
            'nombre' => 'local',
        ]);
    }
}
