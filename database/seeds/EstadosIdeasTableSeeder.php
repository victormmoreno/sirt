<?php

use App\Models\EstadoIdea;
use Illuminate\Database\Seeder;

class EstadosIdeasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        EstadoIdea::create([
            'nombre'      => 'En registro',
        ]);

        EstadoIdea::create([
            'nombre'      => 'Convocado',
        ]);

        EstadoIdea::create([
            'nombre'      => 'Admitido',
        ]);

        EstadoIdea::create([
            'nombre'      => 'Rechazado por comité',
        ]);

        EstadoIdea::create([
            'nombre'      => 'No Convocado',
        ]);

        EstadoIdea::create([
            'nombre'      => 'Inhabilitado',
        ]);

        EstadoIdea::create([
            'nombre'      => 'En PBT',
        ]);

        EstadoIdea::create([
            'nombre'      => 'No Aplica',
        ]);

        EstadoIdea::create([
            'nombre'      => 'Programado',
        ]);

        EstadoIdea::create([
            'nombre'      => 'Reprogramado',
        ]);

        EstadoIdea::create([
            'nombre'      => 'Postulado',
        ]);

        EstadoIdea::create([
            'nombre'      => 'Rechazado por articulador',
        ]);
    }
}
