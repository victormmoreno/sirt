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
            'id'          => 1,
            'abreviatura' => 'CC',
            'nombre'      => 'Cédula de Ciudadanía',
            'estado'      => 1,
        ]);

        TipoDocumento::create([
            'id'          => 2,
            'abreviatura' => 'TI',
            'nombre'      => 'Tarjeta de Identidad',
            'estado'      => 1,
        ]);

        TipoDocumento::create([
            'id'          => 3,
            'abreviatura' => 'CE',
            'nombre'      => 'Cédula de Extranjería',
            'estado'      => 1,
        ]);

        TipoDocumento::create([
            'id'          => 4,
            'abreviatura' => 'RC',
            'nombre'      => 'Registro Civil',
            'estado'      => 1,
        ]);

        // factory(TipoDocumento::class, 10)->create();

    }
}
