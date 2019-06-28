<?php

use App\Models\LineaTecnologica;
use Illuminate\Database\Seeder;

class LineasTecnologicasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LineaTecnologica::create([
            'id'          => 1,
            'abreviatura' => 'BIO',
            'nombre'      => 'Biotecnonlogía y Nanotecnología',
            'descripcion' => '',
        ]);

        LineaTecnologica::create([
            'id'          => 2,
            'abreviatura' => 'ETC',
            'nombre'      => 'Electrónica y Telecomunicaciones',
            'descripcion' => '',
        ]);

        LineaTecnologica::create([
            'id'          => 3,
            'abreviatura' => 'IND',
            'nombre'      => 'Ingenieria y Diseño',
            'descripcion' => '',
        ]);

        LineaTecnologica::create([
            'id'          => 4,
            'abreviatura' => 'TV',
            'nombre'      => 'Tecnologías Virtuales',
            'descripcion' => '',
        ]);

        // factory(LineaTecnologica::class, 20)->create();
    }
}
