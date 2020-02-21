<?php

use Illuminate\Database\Seeder;
use App\Models\TipoTalento;

class TipoTalentosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoTalento::create([
            'nombre'          => 'Aprendiz SENA con apoyo de sostenimiento'
        ]);

        TipoTalento::create([
            'nombre'          => 'Aprendiz SENA sin apoyo de sostenimiento'
        ]);

        TipoTalento::create([
            'nombre'          => 'Egresado SENA'
        ]);

        TipoTalento::create([
            'nombre'          => 'Instructor SENA'
        ]);

        TipoTalento::create([
            'nombre'          => 'Funcionario SENA'
        ]);

        TipoTalento::create([
            'nombre'          => 'Propietario Empresa'
        ]);

        TipoTalento::create([
            'nombre'          => 'Emprendedor'
        ]);

        TipoTalento::create([
            'nombre'          => 'Estudiante Universitario'
        ]);

        TipoTalento::create([
            'nombre'          => 'Funcionario de empresa'
        ]);
    }
}
