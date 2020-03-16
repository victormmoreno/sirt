<?php

use Illuminate\Database\Seeder;
use App\Models\Producto;

class ProductosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Producto::create([ 'nombre' => 'Artículos de investigación A1, A2, B y C' ]);
        Producto::create([ 'nombre' => 'Artículos de Investigación D' ]);
        Producto::create([ 'nombre' => 'Notas científicas' ]);
        Producto::create([ 'nombre' => 'Libro resultado de investigación' ]);
        Producto::create([ 'nombre' => 'Capítulos de libro resultado de investigación' ]);
        Producto::create([ 'nombre' => 'Conceptos Técnicos' ]);
        Producto::create([ 'nombre' => 'Productos Tecnológicos patentados o en proceso de concesión de patente' ]);
        Producto::create([ 'nombre' => 'Participación Ciudadana en proyectos de CTI' ]);
        Producto::create([ 'nombre' => 'Circulación de conocimiento especializado' ]);
        Producto::create([ 'nombre' => 'Dirección de tesis de doctorado' ]);
        Producto::create([ 'nombre' => 'Dirección de trabajo de grado maestría' ]);
        Producto::create([ 'nombre' => 'Dirección de trabajo de grado pregrado' ]);
        Producto::create([ 'nombre' => 'Proyecto de investigación y desarrollo PID_A PID_ B' ]);
        Producto::create([ 'nombre' => 'Proyecto de I+D+i con Formación' ]);
        Producto::create([ 'nombre' => 'Apoyo a creación programa o curso de formación de investigadores' ]);

    }
}
