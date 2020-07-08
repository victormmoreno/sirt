<?php

use Illuminate\Database\Seeder;

use App\Models\TipoEmpresa;

class TipoEmpresasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoEmpresa::create([
            'nombre'          => 'Pública',  
        ]);

        TipoEmpresa::create([
            'nombre'          => 'Privada',  
        ]);

        TipoEmpresa::create([
            'nombre'          => 'Mixta', 
        ]);
    }
}
