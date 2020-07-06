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
            'nombre' => 'Inicio',
        ]);

        EstadoProyecto::create([
            'nombre' => 'Planeacion',
        ]);

        EstadoProyecto::create([
            'nombre' => 'En ejecución',
        ]);

        EstadoProyecto::create([
            'nombre' => 'Ejecutado',
        ]);

        EstadoProyecto::create([
            'nombre' => 'Cierre PMV',
        ]);

        EstadoProyecto::create([
            'nombre' => 'Cierre PF',
        ]);

        EstadoProyecto::create([
            'nombre' => 'Finalizado',
        ]);

        EstadoProyecto::create([
            'nombre' => 'Suspendido',
        ]);
    }
}
