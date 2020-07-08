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
            'nombre' => 'Bachiller Académico',
        ]);

        GradoEscolaridad::create([
            'nombre' => 'Técnico',
        ]);

        GradoEscolaridad::create([
            'nombre' => 'Tecnologo',
        ]);

        GradoEscolaridad::create([
            'nombre' => 'Profesional',
        ]);

        GradoEscolaridad::create([
            'nombre' => 'Especializacion',
        ]);

        GradoEscolaridad::create([
            'nombre' => 'Maestria',
        ]);

        GradoEscolaridad::create([
            'nombre' => 'Doctorado',
        ]);

        GradoEscolaridad::create([
            'nombre' => 'Post Doctorado',
        ]);
    }
}
