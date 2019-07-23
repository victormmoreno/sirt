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
            'id'          => 1,
            'nombre'      => 'Inicio',
        ]);

        EstadoIdea::create([
            'id'          => 2,
            'nombre'      => 'Convocado',
        ]);

        EstadoIdea::create([
            'id'          => 3,
            'nombre'      => 'Admitido',
        ]);

        EstadoIdea::create([
            'id'          => 4,
            'nombre'      => 'No Admitido',
        ]);

        EstadoIdea::create([
            'id'          => 5,
            'nombre'      => 'No Convocado',
        ]);

        EstadoIdea::create([
            'id'          => 6,
            'nombre'      => 'Inhabilitado',
        ]);

        EstadoIdea::create([
            'id'          => 7,
            'nombre'      => 'En Proyecto',
        ]);

        EstadoIdea::create([
            'id'          => 8,
            'nombre'      => 'No Aplica',
        ]);


    }
}
