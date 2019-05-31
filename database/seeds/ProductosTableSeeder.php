<?php

use App\Models\Producto;
use Illuminate\Database\Seeder;

class ProductosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Producto::create([
            'id'     => 1,
            'nombre' => 'Articulo',
        ]);

        Producto::create([
            'id'     => 2,
            'nombre' => 'Cartilla',
        ]);

        Producto::create([
            'id'     => 3,
            'nombre' => 'Libro',
        ]);

        Producto::create([
            'id'     => 4,
            'nombre' => 'Capitulo de libro',
        ]);

        Producto::create([
            'id'     => 5,
            'nombre' => 'Prototipo',
        ]);

        Producto::create([
            'id'     => 6,
            'nombre' => 'Patente',
        ]);

        Producto::create([
            'id'     => 7,
            'nombre' => 'Sin Producto',
        ]);

        Producto::create([
            'id'     => 8,
            'nombre' => 'Software Registrado',
        ]);

        Producto::create([
            'id'     => 9,
            'nombre' => 'Diseño Industrial',
        ]);

        Producto::create([
            'id'     => 10,
            'nombre' => 'Otro',
        ]);

    }
}
