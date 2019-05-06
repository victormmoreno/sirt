<?php

use App\Models\TipoMaterial;
use Illuminate\Database\Seeder;

class TiposMaterialesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoMaterial::create([
            'id'     => 1,
            'nombre' => 'Material Directo',
        ]);

        TipoMaterial::create([
            'id'     => 2,
            'nombre' => 'Material Indirecto',
        ]);

        // factory(TipoMaterial::class, 10)->create();
    }
}
