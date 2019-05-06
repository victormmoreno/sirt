<?php

use App\Models\TipoVinculacion;
use Illuminate\Database\Seeder;

class TiposVinculacionesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoVinculacion::create([
            'id'     => 1,
            'nombre' => 'Planta',
        ]);

        TipoVinculacion::create([
            'id'     => 2,
            'nombre' => 'Planta Temporal',
        ]);

        TipoVinculacion::create([
            'id'     => 3,
            'nombre' => 'Contratista',
        ]);

        // factory(TipoVinculacion::class, 10)->create();
    }
}
