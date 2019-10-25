<?php

use Illuminate\Database\Seeder;
use App\Models\CategoriaMaterial;

class CategoriaMaterialTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        factory(CategoriaMaterial::class, 20)->create();

        // CategoriaMaterial::create([
        //     'nombre' => 'Fab de PCB Acabado Precisión',
        // ]);

        // CategoriaMaterial::create([
        //     'nombre' => 'Fab de PCB Acabado Básico',
        // ]);

        // CategoriaMaterial::create([
        //     'nombre' => 'Montaje de PCB',
        // ]);

    }
}
