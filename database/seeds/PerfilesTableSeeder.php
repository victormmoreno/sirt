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
            'nombre' => 'Aprendiz SENA sin apoyo de sostenimiento',
        ]);

        Perfil::create([
            'nombre' => 'Aprendiz SENA con apoyo de sostenimiento',
        ]);

        Perfil::create([
            'nombre' => 'Egresado SENA',
        ]);

        Perfil::create([

            'nombre' => 'Funcionario empresa pública',
        ]);

        Perfil::create([
            'nombre' => 'Estudiante Universitario de Pregrado',
        ]);

        Perfil::create([
            'nombre' => 'Estudiante Universitario de Postgrado',
        ]);

        Perfil::create([
            'nombre' => 'Funcionario microempresa',
        ]);

        Perfil::create([
            'nombre' => 'Funcionario mediana empresa',
        ]);

        Perfil::create([
            'nombre' => 'Funcionario grande empresa',
        ]);

        Perfil::create([
            'nombre' => 'Emprendedor independiente',
        ]);

        Perfil::create([
            'nombre' => 'Investigador',
        ]);

        Perfil::create([
            'nombre' => 'Otro',
        ]);
    }
}
