<?php

use App\Models\TipoDocumento;
use Illuminate\Database\Seeder;

class TiposDocumentosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoDocumento::create([
            'abreviatura'          => 'CC',
            'nombre'      => 'Cédula de Ciudadanía',
        ]);

        TipoDocumento::create([
            'abreviatura'          => 'TI',
            'nombre'      => 'Tarjeta de Identidad',
        ]);

        TipoDocumento::create([
            'abreviatura'          => 'CE',
            'nombre'      => 'Cédula de Extranjería',
        ]);

        TipoDocumento::create([
            'abreviatura'          => 'RC',
            'nombre'      => 'Registro Civil',
        ]);
    }
}
