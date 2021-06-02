<?php

use Illuminate\Database\Seeder;
use App\Models\Actividad;
use App\Models\ArticulacionPbt;

class ArticulacionPbtTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        factory(Actividad::class, 20)->create()
        ->each(function ($actividad) {
            $actividad->articulacionpbt()->save(factory(ArticulacionPbt::class)->make());    
        });
       
    }
}
