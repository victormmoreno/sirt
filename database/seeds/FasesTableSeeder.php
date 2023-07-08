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
            'nombre' => 'Inicio',
        ]);

        Fase::create([
            'nombre' => 'Planeación',
        ]);

        Fase::create([
            'nombre' => 'Ejecución',
        ]);

        Fase::create([
            'nombre' => 'Cierre',
        ]);

        Fase::create([
            'nombre' => 'Cancelado',
        ]);

        Fase::create([
            'nombre' => 'Finalizado',
        ]);

    }
}
