<?php

use App\Models\Prototipo;
use Illuminate\Database\Seeder;

class PrototiposTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Prototipo::create([
            'id'          => 1,
            'nombre'      => 'De prueba',
            'descripcion' => '',
        ]);

        Prototipo::create([
            'id'          => 2,
            'nombre'      => 'Funcional',
            'descripcion' => '',
        ]);

        Prototipo::create([
            'id'          => 3,
            'nombre'      => 'En funcionamiento en la empresa',
            'descripcion' => '',
        ]);

        Prototipo::create([
            'id'          => 4,
            'nombre'      => 'En proceso de patentamiento',
            'descripcion' => '',
        ]);

        Prototipo::create([
            'id'          => 5,
            'nombre'      => 'En desarrollo',
            'descripcion' => '',
        ]);

        Prototipo::create([
            'id'          => 6,
            'nombre'      => 'No aplica',
            'descripcion' => '',
        ]);

        Prototipo::create([
            'id'          => 7,
            'nombre'      => 'Otro',
            'descripcion' => '',
        ]);

        // factory(Prototipo::class, 10)->create();
    }
}
