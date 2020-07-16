<?php

use Illuminate\Database\Seeder;
use App\Models\EstadoComite;

class EstadoComiteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EstadoComite::create([
            'nombre'      => 'Programado',
        ]);

        EstadoComite::create([
            'nombre'      => 'Realizado',
        ]);

        EstadoComite::create([
            'nombre'      => 'Proyectos asignados',
        ]);
    }
}
