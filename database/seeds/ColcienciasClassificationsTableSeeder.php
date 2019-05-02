<?php

use App\Models\ColcienciasClassification;
use Illuminate\Database\Seeder;

class ColcienciasClassificationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ColcienciasClassification::create([
            'idclasificacioncolciencias' => 1,
            'nombre'                     => 'A1',
            'descripcion'                => '',
        ]);

        ColcienciasClassification::create([
            'idclasificacioncolciencias' => 2,
            'nombre'                     => 'A',
            'descripcion'                => '',
        ]);

        ColcienciasClassification::create([
            'idclasificacioncolciencias' => 3,
            'nombre'                     => 'B',
            'descripcion'                => '',
        ]);

        ColcienciasClassification::create([
            'idclasificacioncolciencias' => 4,
            'nombre'                     => 'C',
            'descripcion'                => '',
        ]);

        ColcienciasClassification::create([
            'idclasificacioncolciencias' => 5,
            'nombre'                     => 'Reconocido',
            'descripcion'                => '',
        ]);

        ColcienciasClassification::create([
            'idclasificacioncolciencias' => 6,
            'nombre'                     => 'Avalado por la institución',
            'descripcion'                => '',
        ]);

        ColcienciasClassification::create([
            'idclasificacioncolciencias' => 7,
            'nombre'                     => 'Internacional',
            'descripcion'                => '',
        ]);
    }
}
