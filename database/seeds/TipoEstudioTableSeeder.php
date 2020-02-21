<?php

use App\Models\TipoEstudio;
use Illuminate\Database\Seeder;

class TipoEstudioTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoEstudio::create([
            'nombre'          => 'Pregrado'
        ]);

        TipoEstudio::create([
            'nombre'          => 'Especialización'
        ]);

        TipoEstudio::create([
            'nombre'          => 'Maestría'
        ]);

        TipoEstudio::create([
            'nombre'          => 'Doctorado'
        ]);
    }
}
