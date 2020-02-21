<?php

use App\Models\TipoFormacion;
use Illuminate\Database\Seeder;

class TipoFormacionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoFormacion::create([
            'nombre'          => 'Técnico'
        ]);

        TipoFormacion::create([
            'nombre'          => 'Tecnológico'
        ]);
    }
}
