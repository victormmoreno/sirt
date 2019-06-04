<?php

use App\Models\Nodo;
use Illuminate\Database\Seeder;

class NodosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Nodo::create([
            'id'          => 1,
            'centro_id'   => 71,
            'nombre'      => 'Medellin',
            'direccion'   => 'Carrera 46 # 56-11. Edificio TecnoParque, Piso 6-7',
            'anho_inicio' => '2007',
        ]);

        Nodo::create([
            'id'          => 2,
            'centro_id'   => 96,
            'nombre'      => 'Rionegro',
            'direccion'   => 'Calle 41 Nº 50A – 324',
            'anho_inicio' => '2007',
        ]);

        Nodo::create([
            'id'          => 3,
            'centro_id'   => 30,
            'nombre'      => 'Calí',
            'direccion'   => 'Carrera 5 No. 11-68, Plaza de Caicedo Centro de Cali',
            'anho_inicio' => '2011',
        ]);

        Nodo::create([
            'id'          => 4,
            'centro_id'   => 14,
            'nombre'      => 'Bogotá DC',
            'direccion'   => 'Calle 54 No 10 – 39',
            'anho_inicio' => '2014',
        ]);

        Nodo::create([
            'id'          => 5,
            'centro_id'   => 105,
            'nombre'      => 'Cazuca',
            'direccion'   => 'Autopista Sur Transversal 7 No 8 – 40.TecnoParque Central',
            'anho_inicio' => '2009',
        ]);

        Nodo::create([
            'id'          => 6,
            'centro_id'   => 43,
            'nombre'      => 'Pereira',
            'direccion'   => 'Carrera 10 No. 17 - 15 Piso 2',
            'anho_inicio' => '2007',
        ]);

        Nodo::create([
            'id'          => 7,
            'centro_id'   => 42,
            'nombre'      => 'Neiva',
            'direccion'   => 'Diagonal 20 Nº 38 -16',
            'anho_inicio' => '2007',
        ]);

        Nodo::create([
            'id'          => 8,
            'centro_id'   => 47,
            'nombre'      => 'Bucaramanga',
            'direccion'   => 'Km 6 Autopista Florida Blanca # 50-33',
            'anho_inicio' => '2009',
        ]);

        Nodo::create([
            'id'          => 9,
            'centro_id'   => 67,
            'nombre'      => 'Manizales',
            'direccion'   => 'Kilómetro 10 Vía al Magdalena',
            'anho_inicio' => '2008',
        ]);

        Nodo::create([
            'id'          => 10,
            'centro_id'   => 45,
            'nombre'      => 'La Granja',
            'direccion'   => 'Km 5 Vía Espinal - Ibagué',
            'anho_inicio' => '2009',
        ]);

        Nodo::create([
            'id'          => 11,
            'centro_id'   => 85,
            'nombre'      => 'Pitalito',
            'direccion'   => 'Km 7 vía Pitalito, vereda Aguaduas',
            'anho_inicio' => '2012',
        ]);

        Nodo::create([
            'id'          => 12,
            'centro_id'   => 111,
            'nombre'      => 'Valledupar',
            'direccion'   => 'Carrera 19 entre Calles 14 y 15',
            'anho_inicio' => '2009',
        ]);

        Nodo::create([
            'id'          => 13,
            'centro_id'   => 42,
            'nombre'      => 'Ocaña',
            'direccion'   => 'Transversal 30 N° 7-110 La Primavera',
            'anho_inicio' => '2009',
        ]);

        Nodo::create([
            'id'          => 14,
            'centro_id'   => 33,
            'nombre'      => 'Angostura',
            'direccion'   => 'Km 38 Vía Neiva al Sur - Campo Alegre',
            'anho_inicio' => '2009',
        ]);

        Nodo::create([
            'id'          => 15,
            'centro_id'   => 98,
            'nombre'      => 'Socorro',
            'direccion'   => 'Calle 16 No. 14-28',
            'anho_inicio' => '2012',
        ]);

    }
}
