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
            'abreviatura' => 'BIO',
            'nombre'      => 'Biotecnonlogía y Nanotecnología',
            'slug'        => str_slug('Biotecnonlogía y Nanotecnología', '-'),
            'descripcion' => '',
        ]);

        LineaTecnologica::create([
            'abreviatura' => 'ETC',
            'nombre'      => 'Electrónica y Telecomunicaciones',
            'slug'        => str_slug('Electrónica y Telecomunicaciones', '-'),
            'descripcion' => '',
        ]);

        LineaTecnologica::create([
            'abreviatura' => 'IND',
            'nombre'      => 'Ingenieria y Diseño',
            'slug'        => str_slug('Ingenieria y Diseño', '-'),
            'descripcion' => '',
        ]);

        LineaTecnologica::create([
            'abreviatura' => 'TV',
            'nombre'      => 'Tecnologías Virtuales',
            'slug'        => str_slug('Tecnologías Virtuales', '-'),
            'descripcion' => '',
        ]);

        // factory(LineaTecnologica::class, 20)->create();
    }
}
