<?php

use App\Models\Regional;
use Illuminate\Database\Seeder;

class RegionalesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (app()->environment() == 'production') {
            Regional::create([
                'ciudad_id' => 70,
                'nombre'          => 'ANTIOQUIA',
                'codigo_regional' => '5',
                'direccion'       => 'Calle 51  57-70',
            ]);

            Regional::create([
                'ciudad_id' => 136,
                'nombre'          => 'ATLANTICO',
                'codigo_regional' => '8',
                'direccion'       => 'CARRERA 43 42-40',
            ]);

            Regional::create([
                'ciudad_id' => 525,
                'nombre'          => 'DISTRITO CAPITAL',
                'codigo_regional' => '11',
                'direccion'       => 'Cra 13 No 65-10, Pisos 1 7 a 21',
            ]);

            Regional::create([
                'ciudad_id' => 166,
                'nombre'          => 'BOLIVAR',
                'codigo_regional' => '13',
                'direccion'       => 'Ternera, via a Turbaco; Km 1',
            ]);

            Regional::create([
                'ciudad_id' => 317,
                'nombre'          => 'BOYACA',
                'codigo_regional' => '15',
                'direccion'       => 'Carrera 12 No 55 A-51',
            ]);

            Regional::create([
                'ciudad_id' => 336,
                'nombre'          => 'CALDAS',
                'codigo_regional' => '17',
                'direccion'       => 'Km. 10 Vía al Magdalena',
            ]);

            Regional::create([
                'ciudad_id' => 360,
                'nombre'          => 'CAQUETA',
                'codigo_regional' => '18',
                'direccion'       => 'Kilómetro 3 Vía Aeropuerto',
            ]);

            Regional::create([
                'ciudad_id' => 414,
                'nombre'          => 'CAUCA',
                'codigo_regional' => '19',
                'direccion'       => 'Calle 4 #2-80',
            ]);

            Regional::create([
                'ciudad_id' => 455,
                'nombre'          => 'CESAR',
                'codigo_regional' => '20',
                'direccion'       => 'Carrera 19 entre calle 14 y 15',
            ]);

            Regional::create([
                'ciudad_id' => 500,
                'nombre'          => 'CORDOBA',
                'codigo_regional' => '23',
                'direccion'       => 'Av. Circunvalar Cls. 24 y 27',
            ]);

            Regional::create([
                'ciudad_id' => 525,
                'nombre'          => 'CUNDINAMARCA',
                'codigo_regional' => '25',
                'direccion'       => 'AVENIDA 42 No 21A-24',
            ]);

            Regional::create([
                'ciudad_id' => 477,
                'nombre'          => 'CHOCO',
                'codigo_regional' => '27',
                'direccion'       => 'CRA. 1 No28 - 71',
            ]);

            Regional::create([
                'ciudad_id' => 655,
                'nombre'          => 'HUILA',
                'codigo_regional' => '41',
                'direccion'       => 'Carrera 5 Av la toma',
            ]);

            Regional::create([
                'ciudad_id' => 686,
                'nombre'          => 'GUAJIRA',
                'codigo_regional' => '44',
                'direccion'       => 'Avenida aeropuerto calle 21',
            ]);

            Regional::create([
                'ciudad_id' => 716,
                'nombre'          => 'MAGDALENA',
                'codigo_regional' => '47',
                'direccion'       => 'Avenida del ferrocarril # 27-97 Santa Marta',
            ]);

            Regional::create([
                'ciudad_id' => 748,
                'nombre'          => 'META',
                'codigo_regional' => '50',
                'direccion'       => 'KM  1 VIA ACACIAS',
            ]);

            Regional::create([
                'ciudad_id' => 801,
                'nombre'          => 'NARIÑO',
                'codigo_regional' => '52',
                'direccion'       => 'CALLE 22 11 ESTE 05-VIA A ORIENTE',
            ]);

            Regional::create([
                'ciudad_id' => 823,
                'nombre'          => 'NORTE S/DER',
                'codigo_regional' => '54',
                'direccion'       => 'Calle 2N AV 4 Y 5 Barrio Pescadero',
            ]);

            Regional::create([
                'ciudad_id' => 867,
                'nombre'          => 'QUINDIO',
                'codigo_regional' => '63',
                'direccion'       => 'Carrera 6 # 42Norte-02 Avenida centenario',
            ]);

            Regional::create([
                'ciudad_id' => 888,
                'nombre'          => 'RISARALDA',
                'codigo_regional' => '66',
                'direccion'       => 'Cra 8a. No. 26-69',
            ]);

            Regional::create([
                'ciudad_id' => 902,
                'nombre'          => 'SANTANDER',
                'codigo_regional' => '68',
                'direccion'       => 'Carrera 27 No. 15-07 Barrio San Alonso- Bucaramanga',
            ]);

            Regional::create([
                'ciudad_id' => 1002,
                'nombre'          => 'SUCRE',
                'codigo_regional' => '70',
                'direccion'       => 'Calle 25 b Nro. 31-260',
            ]);

            Regional::create([
                'ciudad_id' => 1028,
                'nombre'          => 'TOLIMA',
                'codigo_regional' => '73',
                'direccion'       => 'Cra. 4 Estadio Calle 44 Avenida Ferrocarril',
            ]);

            Regional::create([
                'ciudad_id' => 1064,
                'nombre'          => 'VALLE',
                'codigo_regional' => '76',
                'direccion'       => 'CL 52 2BIS-15',
            ]);

            Regional::create([
                'ciudad_id' => 128,
                'nombre'          => 'ARAUCA',
                'codigo_regional' => '81',
                'direccion'       => 'Carrera 20 No. 28 - 163',
            ]);

            Regional::create([
                'ciudad_id' => 388,
                'nombre'          => 'CASANARE',
                'codigo_regional' => '85',
                'direccion'       => 'Cra. 19 No.36-68',
            ]);

            Regional::create([
                'ciudad_id' => 855,
                'nombre'          => 'PUTUMAYO',
                'codigo_regional' => '86',
                'direccion'       => 'Cra.23 # 16a-06 B/20 de Julio Puerto AsÍs Putumayo',
            ]);

            Regional::create([
                'ciudad_id' => 893,
                'nombre'          => 'SAN ANDRES',
                'codigo_regional' => '88',
                'direccion'       => 'Avenida Franciscon Newball',
            ]);

            Regional::create([
                'ciudad_id' => 1,
                'nombre'          => 'AMAZONAS',
                'codigo_regional' => '91',
                'direccion'       => 'Calle 12 No 10 - 60',
            ]);

            Regional::create([
                'ciudad_id' => 634,
                'nombre'          => 'GUAINIA',
                'codigo_regional' => '94',
                'direccion'       => 'Transversal 6 Nº 29a-55, via al Coco',
            ]);

            Regional::create([
                'ciudad_id' => 638,
                'nombre'          => 'GUAVIARE',
                'codigo_regional' => '95',
                'direccion'       => 'Carrera 24 # 7 - 10 Centro',
            ]);

            Regional::create([
                'ciudad_id' => 1097,
                'nombre'          => 'VAUPES',
                'codigo_regional' => '97',
                'direccion'       => 'Avenida 15 No 6 - 176',
            ]);

            Regional::create([
                'ciudad_id' => 1101,
                'nombre'          => 'VICHADA',
                'codigo_regional' => '99',
                'direccion'       => '(Sede Nueva) Carrera 10 No 15 - 131 Barrio Tamarido',
            ]);
        } else {
            factory(Regional::class, 32)->create();
        }
    }
}
