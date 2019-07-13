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
            // 'nombre'      => 'Medellin',
            'entidad_id'  => 2,
            'direccion'   => 'Carrera 46 # 56-11. Edificio TecnoParque, Piso 6-7',
            'anho_inicio' => '2007',
        ]);

        Nodo::create([
            'id'          => 2,
            'centro_id'   => 119,
            // 'nombre'      => 'Rionegro',
            'entidad_id'  => 3,
            'direccion'   => 'Calle 41 Nº 50A – 324',
            'anho_inicio' => '2007',
        ]);

        Nodo::create([
            'id'          => 3,
            'centro_id'   => 30,
            // 'nombre'      => 'Calí',
            'entidad_id'  => 4,
            'direccion'   => 'Carrera 5 No. 11-68, Plaza de Caicedo Centro de Cali',
            'anho_inicio' => '2011',
        ]);

        Nodo::create([
            'id'          => 4,
            'centro_id'   => 14,
            // 'nombre'      => 'Bogotá DC',
            'entidad_id'  => 5,
            'direccion'   => 'Calle 54 No 10 – 39',
            'anho_inicio' => '2014',
        ]);

        Nodo::create([
            'id'          => 5,
            'centro_id'   => 105,
            // 'nombre'      => 'Cazuca',
            'entidad_id'  => 6,
            'direccion'   => 'Autopista Sur Transversal 7 No 8 – 40.TecnoParque Central',
            'anho_inicio' => '2009',
        ]);

        Nodo::create([
            'id'          => 6,
            'centro_id'   => 43,
            // 'nombre'      => 'Pereira',
            'entidad_id'  => 7,
            'direccion'   => 'Carrera 10 No. 17 - 15 Piso 2',
            'anho_inicio' => '2007',
        ]);

        Nodo::create([
            'id'          => 7,
            'centro_id'   => 42,
            // 'nombre'      => 'Neiva',
            'entidad_id'  => 8,
            'direccion'   => 'Diagonal 20 Nº 38 -16',
            'anho_inicio' => '2007',
        ]);

        Nodo::create([
            'id'          => 8,
            'centro_id'   => 47,
            // 'nombre'      => 'Bucaramanga',
            'entidad_id'  => 9,
            'direccion'   => 'Km 6 Autopista Florida Blanca # 50-33',
            'anho_inicio' => '2009',
        ]);

        Nodo::create([
            'id'          => 9,
            'centro_id'   => 67,
            // 'nombre'      => 'Manizales',
            'entidad_id'  => 10,
            'direccion'   => 'Kilómetro 10 Vía al Magdalena',
            'anho_inicio' => '2008',
        ]);

        Nodo::create([
            'id'          => 10,
            'centro_id'   => 45,
            // 'nombre'      => 'La Granja',
            'entidad_id'  => 11,
            'direccion'   => 'Km 5 Vía Espinal - Ibagué',
            'anho_inicio' => '2009',
        ]);

        Nodo::create([
            'id'          => 11,
            'centro_id'   => 85,
            // 'nombre'      => 'Pitalito',
            'entidad_id'  => 12,
            'direccion'   => 'Km 7 vía Pitalito, vereda Aguaduas',
            'anho_inicio' => '2012',
        ]);

        Nodo::create([
            'id'          => 12,
            'centro_id'   => 111,
            // 'nombre'      => 'Valledupar',
            'entidad_id'  => 13,
            'direccion'   => 'Carrera 19 entre Calles 14 y 15',
            'anho_inicio' => '2009',
        ]);

        Nodo::create([
            'id'          => 13,
            'centro_id'   => 42,
            // 'nombre'      => 'Ocaña',
            'entidad_id'  => 14,
            'direccion'   => 'Transversal 30 N° 7-110 La Primavera',
            'anho_inicio' => '2009',
        ]);

        Nodo::create([
            'id'          => 14,
            'centro_id'   => 33,
            // 'nombre'      => 'Angostura',
            'entidad_id'  => 15,
            'direccion'   => 'Km 38 Vía Neiva al Sur - Campo Alegre',
            'anho_inicio' => '2009',
        ]);

        Nodo::create([
            'id'          => 15,
            'centro_id'   => 98,
            // 'nombre'      => 'Socorro',
            'entidad_id'  => 16,
            'direccion'   => 'Calle 16 No. 14-28',
            'anho_inicio' => '2012',
        ]);

    }
}
