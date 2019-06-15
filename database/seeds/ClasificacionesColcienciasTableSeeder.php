<?php

use App\Models\ClasificacionColciencias;
use Illuminate\Database\Seeder;

class ClasificacionesColcienciasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ClasificacionColciencias::create([
            'nombre' => 'A1',
        ]);

        ClasificacionColciencias::create([
            'nombre' => 'A',
        ]);

        ClasificacionColciencias::create([
            'nombre' => 'B',
        ]);

        ClasificacionColciencias::create([
            'nombre' => 'C',
        ]);

        ClasificacionColciencias::create([
            'nombre' => 'Reconocido',
        ]);

        ClasificacionColciencias::create([
            'nombre' => 'Avalado por la institución',
        ]);

        ClasificacionColciencias::create([
            'nombre' => 'Internacional',
        ]);
    }
}
