<?php

use App\Models\Fase;
use Illuminate\Database\Seeder;

class FasesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Fase::create([
            'id'     => 1,
            'nombre' => 'Inicio',
        ]);

        Fase::create([
            'id'     => 2,
            'nombre' => 'Planeación',
        ]);

        Fase::create([
            'id'     => 3,
            'nombre' => 'Ejecución',
        ]);

        Fase::create([
            'id'     => 4,
            'nombre' => 'Cierre',
        ]);

    }
}
