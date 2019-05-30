<?php

use App\Models\GradoEscolaridad;
use Illuminate\Database\Seeder;

class GradosEscolaridadTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GradoEscolaridad::create([
            'id'     => 1,
            'nombre' => 'Bachiller Académico',
        ]);

        GradoEscolaridad::create([
            'id'     => 2,
            'nombre' => 'Técnico',
        ]);

        GradoEscolaridad::create([
            'id'     => 3,
            'nombre' => 'Tecnologo',
        ]);

        GradoEscolaridad::create([
            'id'     => 4,
            'nombre' => 'Profesional',
        ]);

        GradoEscolaridad::create([
            'id'     => 5,
            'nombre' => 'Especializacion',
        ]);

        GradoEscolaridad::create([
            'id'     => 6,
            'nombre' => 'Maestria',
        ]);

        GradoEscolaridad::create([
            'id'     => 7,
            'nombre' => 'Doctorado',
        ]);

        GradoEscolaridad::create([
            'id'     => 8,
            'nombre' => 'Post Doctorado',
        ]);

    }
}
