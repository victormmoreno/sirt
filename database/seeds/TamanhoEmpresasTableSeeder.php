<?php

use Illuminate\Database\Seeder;
use App\Models\TamanhoEmpresa;

class TamanhoEmpresasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TamanhoEmpresa::create([
            'nombre'          => 'Micro',
        ]);
        
        TamanhoEmpresa::create([
            'nombre'          => 'Pequeña',
        ]);

        TamanhoEmpresa::create([
            'nombre'          => 'Mediana',
        ]);

        TamanhoEmpresa::create([
            'nombre'          => 'Grande',
        ]);
    }
}
