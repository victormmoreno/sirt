<?php

use Illuminate\Database\Seeder;
use App\Models\Presentacion;

class PresentacionesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        factory(Presentacion::class)->create([
            'nombre' => 'lamina'
        ]);
        factory(Presentacion::class)->create([
            'nombre' => 'unidad'
        ]);

        factory(Presentacion::class)->create([
            'nombre' => 'contenedor'
        ]);

        factory(Presentacion::class)->create([
            'nombre' => 'cartucho'
        ]);

        factory(Presentacion::class)->create([
            'nombre' => 'kit'
        ]);

        factory(Presentacion::class)->create([
            'nombre' => 'carrete'
        ]);

        factory(Presentacion::class)->create([
            'nombre' => 'rollo'
        ]);
    }
}
