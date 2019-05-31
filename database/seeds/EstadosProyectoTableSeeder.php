<?php

use App\Models\EstadoProyecto;
use Illuminate\Database\Seeder;

class EstadosProyectoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EstadoProyecto::create([
            'id'     => 1,
            'nombre' => 'Inicio',
        ]);

        EstadoProyecto::create([
            'id'     => 2,
            'nombre' => 'Planeacion',
        ]);

        EstadoProyecto::create([
            'id'     => 3,
            'nombre' => 'En ejecución',
        ]);

        EstadoProyecto::create([
            'id'     => 4,
            'nombre' => 'Ejecutado',
        ]);

        EstadoProyecto::create([
            'id'     => 5,
            'nombre' => 'Cierre PMV',
        ]);

        EstadoProyecto::create([
            'id'     => 6,
            'nombre' => 'Cierre PF',
        ]);

        EstadoProyecto::create([
            'id'     => 7,
            'nombre' => 'Finalizado',
        ]);

        EstadoProyecto::create([
            'id'     => 8,
            'nombre' => 'Suspendido',
        ]);

    }
}
