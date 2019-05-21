<?php

use App\Models\NivelAcademico;
use Illuminate\Database\Seeder;

class NivelesAcademicosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        NivelAcademico::create([
            'id'          => 1,
            'nombre'      => 'Bachiller Académico',
            'descripcion' => '',
        ]);

        NivelAcademico::create([
            'id'          => 2,
            'nombre'      => 'Tecnico',
            'descripcion' => '',
        ]);

        NivelAcademico::create([
            'id'          => 3,
            'nombre'      => 'Tecnologo',
            'descripcion' => '',
        ]);

        NivelAcademico::create([
            'id'          => 4,
            'nombre'      => 'Profesional',
            'descripcion' => '',
        ]);

        NivelAcademico::create([
            'id'          => 5,
            'nombre'      => 'Especialización',
            'descripcion' => '',
        ]);

        NivelAcademico::create([
            'id'          => 6,
            'nombre'      => 'Maestria',
            'descripcion' => '',
        ]);

        NivelAcademico::create([
            'id'          => 7,
            'nombre'      => 'Doctorado',
            'descripcion' => '',
        ]);

        NivelAcademico::create([
            'id'          => 8,
            'nombre'      => 'Post Doctorado',
            'descripcion' => '',
        ]);
    }
}
