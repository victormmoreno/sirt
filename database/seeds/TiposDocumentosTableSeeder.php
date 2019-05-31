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
            'nombre'      => 'Cédula de Ciudadanía',
        ]);

        TipoDocumento::create([
            'id'          => 2,
            'nombre'      => 'Tarjeta de Identidad',
        ]);

        TipoDocumento::create([
            'id'          => 3,
            'nombre'      => 'Cédula de Extranjería',
        ]);

        TipoDocumento::create([
            'id'          => 4,
            'nombre'      => 'Registro Civil',
        ]);

        // factory(TipoDocumento::class, 10)->create();

    }
}
