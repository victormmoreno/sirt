<?php

use Illuminate\Database\Seeder;
use App\Models\TipoMaterial;

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
            'nombre' => 'Material Directo',
        ]);

        TipoMaterial::create([
            'nombre' => 'Material Indirecto',
        ]);

    }
}
