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
            'name' => 'Internacional',
        ]);

        AlcanceArticulacion::create([
            'name' => 'Nacional',
        ]);

        AlcanceArticulacion::create([
            'name' => 'Regional',
        ]);

        AlcanceArticulacion::create([
            'name' => 'local',
        ]);
    }
}
