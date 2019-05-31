<?php

use App\Models\Perfil;
use Illuminate\Database\Seeder;

class PerfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Perfil::create([
            'id'     => 1,
            'nombre' => 'Egresado SENA',
        ]);

        Perfil::create([
            'id'     => 2,
            'nombre' => 'Aprendiz SENA',
        ]);

        Perfil::create([
            'id'     => 3,
            'nombre' => 'Funcionario empresa púbilca',
        ]);

        Perfil::create([
            'id'     => 4,
            'nombre' => 'Estudiante Universitario de Pregrado',
        ]);

        Perfil::create([
            'id'     => 5,
            'nombre' => 'Estudiante Universitario de Postgrado',
        ]);

        Perfil::create([
            'id'     => 6,
            'nombre' => 'Funcionario microempresa',
        ]);

        Perfil::create([
            'id'     => 7,
            'nombre' => 'Funcionario mediana empresa',
        ]);

        Perfil::create([
            'id'     => 8,
            'nombre' => 'Funcionario grande empresa',
        ]);

        Perfil::create([
            'id'     => 9,
            'nombre' => 'Empleador independiente',
        ]);

        Perfil::create([
            'id'     => 10,
            'nombre' => 'Otro',
        ]);
    }
}
