<?php

use App\Models\Centro;
use Illuminate\Database\Seeder;

class CentrosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Centro::create([
            'id'            => 1,
            'nombre'        => 'CENTRO AGROEMPRESARIAL',
            'codigo_centro' => 9520,
            'direccion'     => 'KILÓMETRO 1 VÍA BUCARAMANGA',
            'descripcion'   => null,
            'ciudad_id'     => 431,
            'regional_id'   => 9,
            'created_at'    => '2019-05-07 08:20:25',
            'updated_at'    => '2019-05-07 08:20:25',
        ]);

        Centro::create([
            'id'            => 2,
            'nombre'        => 'COMPLEJO TECNOLÓGICO AGROINDUSTRIAL, PECUARIO Y TURÍSTICO ',
            'codigo_centro' => 9504,
            'direccion'     => 'Km.1 Salida a Turbo',
            'descripcion'   => null,
            'ciudad_id'     => 13,
            'regional_id'   => 1,
            'created_at'    => '2019-05-07 08:20:25',
            'updated_at'    => '2019-05-07 08:20:25',
        ]);

        Centro::create([
            'id'            => 3,
            'nombre'        => 'CENTRO DE GESTIÓN Y DESARROLLO AGROINDUSTRIAL DE ARAUCA',
            'codigo_centro' => 9530,
            'direccion'     => 'Carrera 20 No. 28 - 163',
            'descripcion'   => null,
            'ciudad_id'     => 128,
            'regional_id'   => 25,
            'created_at'    => '2019-05-07 08:20:25',
            'updated_at'    => '2019-05-07 08:20:25',
        ]);

        Centro::create([
            'id'            => 4,
            'nombre'        => 'CENTRO DE COMERCIO, INDUSTRIA Y TURISMO',
            'codigo_centro' => 9538,
            'direccion'     => 'Carrera 18 No. 7-58',
            'descripcion'   => null,
            'ciudad_id'     => 867,
            'regional_id'   => 19,
            'created_at'    => '2019-05-07 08:20:25',
            'updated_at'    => '2019-05-07 08:20:25',
        ]);

        Centro::create([
            'id'            => 5,
            'nombre'        => 'CENTRO INDUSTRIAL Y DEL DESARROLLO TECNOLÓGICO',
            'codigo_centro' => 9540,
            'direccion'     => 'Carrera 28 No. 56-10 Barrio Galan- Barrancabermeja- ',
            'descripcion'   => null,
            'ciudad_id'     => 899,
            'regional_id'   => 21,
            'created_at'    => '2019-05-07 08:20:25',
            'updated_at'    => '2019-05-07 08:20:25',
        ]);

        Centro::create([
            'id'            => 6,
            'nombre'        => 'CENTRO PARA EL DESARROLLO AGROECOLÓGICO Y AGROINDUSTRIAL',
            'codigo_centro' => 9103,
            'direccion'     => 'CARRERA 43 42-40 ',
            'descripcion'   => null,
            'ciudad_id'     => 136,
            'regional_id'   => 2,
            'created_at'    => '2019-05-07 08:20:25',
            'updated_at'    => '2019-05-07 08:20:25',
        ]);

        Centro::create([
            'id'            => 7,
            'nombre'        => 'CENTRO DE COMERCIO Y SERVICIOS',
            'codigo_centro' => 9302,
            'direccion'     => 'CARRERA 43 42-40 ',
            'descripcion'   => null,
            'ciudad_id'     => 136,
            'regional_id'   => 2,
            'created_at'    => '2019-05-07 08:20:26',
            'updated_at'    => '2019-05-07 08:20:26',
        ]);

        Centro::create([
            'id'            => 8,
            'nombre'        => 'CENTRO NACIONAL COLOMBO ALEMAN',
            'codigo_centro' => 9207,
            'direccion'     => 'CALLE 30 # 3E-164',
            'descripcion'   => null,
            'ciudad_id'     => 136,
            'regional_id'   => 2,
            'created_at'    => '2019-05-07 08:20:26',
            'updated_at'    => '2019-05-07 08:20:26',
        ]);

        Centro::create([
            'id'            => 9,
            'nombre'        => 'CENTRO INDUSTRIAL Y DE AVIACIÓN',
            'codigo_centro' => 9208,
            'direccion'     => 'CALLE 30 # 3E-164',
            'descripcion'   => null,
            'ciudad_id'     => 136,
            'regional_id'   => 2,
            'created_at'    => '2019-05-07 08:20:26',
            'updated_at'    => '2019-05-07 08:20:26',
        ]);

        Centro::create([
            'id'            => 10,
            'nombre'        => 'CENTRO DE SERVICIOS FINANCIEROS',
            'codigo_centro' => 9405,
            'direccion'     => 'Cra 13 No 65-10, Pisos 1 7 a 21',
            'descripcion'   => null,
            'ciudad_id'     => 525,
            'regional_id'   => 3,
            'created_at'    => '2019-05-07 08:20:26',
            'updated_at'    => '2019-05-07 08:20:26',
        ]);

        Centro::create([
            'id'            => 11,
            'nombre'        => 'CENTRO DE TECNOLOGIAS PARA LA CONSTRUCCIÓN Y LA MADERA',
            'codigo_centro' => 9209,
            'direccion'     => 'Cra 18 A No. 2 - 18 Sur San Antonio',
            'descripcion'   => null,
            'ciudad_id'     => 525,
            'regional_id'   => 3,
            'created_at'    => '2019-05-07 08:20:26',
            'updated_at'    => '2019-05-07 08:20:26',
        ]);

        Centro::create([
            'id'            => 12,
            'nombre'        => 'CENTRO DE ELECTRICIDAD, ELECTRÓNICA Y TELECOMUNICACIONES',
            'codigo_centro' => 9210,
            'direccion'     => 'Avenida 30 No 17 B Sur',
            'descripcion'   => null,
            'ciudad_id'     => 525,
            'regional_id'   => 3,
            'created_at'    => '2019-05-07 08:20:26',
            'updated_at'    => '2019-05-07 08:20:26',
        ]);

        Centro::create([
            'id'            => 13,
            'nombre'        => 'CENTRO DE MANUFACTURA EN TEXTILES Y CUERO',
            'codigo_centro' => 9212,
            'direccion'     => 'Avenida 30 No 17 B Sur',
            'descripcion'   => null,
            'ciudad_id'     => 525,
            'regional_id'   => 3,
            'created_at'    => '2019-05-07 08:20:26',
            'updated_at'    => '2019-05-07 08:20:26',
        ]);

        Centro::create([
            'id'            => 14,
            'nombre'        => 'CENTRO METALMECÁNICO',
            'codigo_centro' => 9214,
            'direccion'     => 'Avenida 30 No 17 B Sur',
            'descripcion'   => null,
            'ciudad_id'     => 525,
            'regional_id'   => 3,
            'created_at'    => '2019-05-07 08:20:26',
            'updated_at'    => '2019-05-07 08:20:26',
        ]);

        Centro::create([
            'id'            => 15,
            'nombre'        => 'CENTRO DE MATERIALES Y ENSAYOS',
            'codigo_centro' => 9215,
            'direccion'     => 'Avenida 30 No 17 B Sur',
            'descripcion'   => null,
            'ciudad_id'     => 525,
            'regional_id'   => 3,
            'created_at'    => '2019-05-07 08:20:26',
            'updated_at'    => '2019-05-07 08:20:26',
        ]);

        Centro::create([
            'id'            => 16,
            'nombre'        => 'CENTRO DE GESTIÓN INDUSTRIAL',
            'codigo_centro' => 9211,
            'direccion'     => 'Carrera 31 No. 14 - 20',
            'descripcion'   => null,
            'ciudad_id'     => 525,
            'regional_id'   => 3,
            'created_at'    => '2019-05-07 08:20:26',
            'updated_at'    => '2019-05-07 08:20:26',
        ]);

        Centro::create([
            'id'            => 17,
            'nombre'        => 'CENTRO DE DISEÑO Y METROLOGIA ',
            'codigo_centro' => 9216,
            'direccion'     => 'Carrera 31 No. 14 - 20',
            'descripcion'   => null,
            'ciudad_id'     => 525,
            'regional_id'   => 3,
            'created_at'    => '2019-05-07 08:20:26',
            'updated_at'    => '2019-05-07 08:20:26',
        ]);

        Centro::create([
            'id'            => 18,
            'nombre'        => 'CENTRO PARA LA INDUSTRIA DE LA COMUNICACIÓN GRÁFICA',
            'codigo_centro' => 9217,
            'direccion'     => 'Carrera 31 No. 14 - 20',
            'descripcion'   => null,
            'ciudad_id'     => 525,
            'regional_id'   => 3,
            'created_at'    => '2019-05-07 08:20:26',
            'updated_at'    => '2019-05-07 08:20:26',
        ]);

        Centro::create([
            'id'            => 19,
            'nombre'        => 'CENTRO NACIONAL DE HOTELERIA, TURISMO Y ALIMENTOS',
            'codigo_centro' => 9406,
            'direccion'     => 'Carrera 31 No. 14 - 20',
            'descripcion'   => null,
            'ciudad_id'     => 525,
            'regional_id'   => 3,
            'created_at'    => '2019-05-07 08:20:26',
            'updated_at'    => '2019-05-07 08:20:26',
        ]);

        Centro::create([
            'id'            => 20,
            'nombre'        => 'CENTRO DE FORMACIÓN DE TALENTO HUMANO EN SALUD',
            'codigo_centro' => 9403,
            'direccion'     => 'Carrera 6 No. 45 - 52',
            'descripcion'   => null,
            'ciudad_id'     => 525,
            'regional_id'   => 3,
            'created_at'    => '2019-05-07 08:20:26',
            'updated_at'    => '2019-05-07 08:20:26',
        ]);

        Centro::create([
            'id'            => 21,
            'nombre'        => 'CENTRO DE GESTIÓN ADMINISTRATIVA',
            'codigo_centro' => 9404,
            'direccion'     => 'Avenida Caracas No. 13 - 88',
            'descripcion'   => null,
            'ciudad_id'     => 525,
            'regional_id'   => 3,
            'created_at'    => '2019-05-07 08:20:26',
            'updated_at'    => '2019-05-07 08:20:26',
        ]);

        Centro::create([
            'id'            => 22,
            'nombre'        => 'CENTRO DE GESTIÓN Y FORTALECIMIENTO SOCIO EMPRESARIAL',
            'codigo_centro' => 9508,
            'direccion'     => 'Transeversal 78J No. 41D - 15 Sur',
            'descripcion'   => null,
            'ciudad_id'     => 525,
            'regional_id'   => 3,
            'created_at'    => '2019-05-07 08:20:26',
            'updated_at'    => '2019-05-07 08:20:26',
        ]);

        Centro::create([
            'id'            => 23,
            'nombre'        => 'CENTRO DE GESTIÓN DE MERCADOS, LOGÍSITICA Y TECNOLOGIAS DE LA INFORMACIÓN',
            'codigo_centro' => 9303,
            'direccion'     => 'Calle 52 No. 11 - 65',
            'descripcion'   => null,
            'ciudad_id'     => 525,
            'regional_id'   => 3,
            'created_at'    => '2019-05-07 08:20:26',
            'updated_at'    => '2019-05-07 08:20:26',
        ]);

        Centro::create([
            'id'            => 24,
            'nombre'        => 'CENTRO DE SERVICIOS EMPRESARIALES Y TURÍSTICOS',
            'codigo_centro' => 9309,
            'direccion'     => 'Carrera 27 No. 15-07 Barrio San Alonso- Bucaramanga',
            'descripcion'   => null,
            'ciudad_id'     => 902,
            'regional_id'   => 21,
            'created_at'    => '2019-05-07 08:20:26',
            'updated_at'    => '2019-05-07 08:20:26',
        ]);

        Centro::create([
            'id'            => 25,
            'nombre'        => 'CENTRO NÁUTICO PESQUERO DE BUENAVENTURA',
            'codigo_centro' => 9126,
            'direccion'     => 'Avenida Simón Bolivar Km 5',
            'descripcion'   => null,
            'ciudad_id'     => 1059,
            'regional_id'   => 24,
            'created_at'    => '2019-05-07 08:20:26',
            'updated_at'    => '2019-05-07 08:20:26',
        ]);

        Centro::create([
            'id'            => 26,
            'nombre'        => 'CENTRO AGROPECUARIO DE BUGA',
            'codigo_centro' => 9124,
            'direccion'     => 'Carretera central , variante Buga - Tulua',
            'descripcion'   => null,
            'ciudad_id'     => 1060,
            'regional_id'   => 24,
            'created_at'    => '2019-05-07 08:20:26',
            'updated_at'    => '2019-05-07 08:20:26',
        ]);

        Centro::create([
            'id'            => 27,
            'nombre'        => 'CENTRO DE LOS RECURSOS NATURALES RENOVABLES - LA SALADA',
            'codigo_centro' => 9101,
            'direccion'     => 'Km.6 Vía Caldas La Pintada',
            'descripcion'   => null,
            'ciudad_id'     => 26,
            'regional_id'   => 1,
            'created_at'    => '2019-05-07 08:20:26',
            'updated_at'    => '2019-05-07 08:20:26',
        ]);

        Centro::create([
            'id'            => 28,
            'nombre'        => 'CENTRO DE ELECTRICIDAD Y AUTOMATIZACIÓN INDUSTRIAL - CEAI',
            'codigo_centro' => 9227,
            'direccion'     => 'CL 52 2BIS-15',
            'descripcion'   => null,
            'ciudad_id'     => 1064,
            'regional_id'   => 24,
            'created_at'    => '2019-05-07 08:20:26',
            'updated_at'    => '2019-05-07 08:20:26',
        ]);

        Centro::create([
            'id'            => 29,
            'nombre'        => 'CENTRO DE DISEÑO TECNOLÓGICO INDUSTRIAL',
            'codigo_centro' => 9229,
            'direccion'     => 'CL 52 2BIS-15',
            'descripcion'   => null,
            'ciudad_id'     => 1064,
            'regional_id'   => 24,
            'created_at'    => '2019-05-07 08:20:26',
            'updated_at'    => '2019-05-07 08:20:26',
        ]);

        Centro::create([
            'id'            => 30,
            'nombre'        => 'CENTRO NACIONAL DE ASISTENCIA TÉCNICA A LA INDUSTRIA - ASTIN',
            'codigo_centro' => 9230,
            'direccion'     => 'CL 52 2BIS-15',
            'descripcion'   => null,
            'ciudad_id'     => 1064,
            'regional_id'   => 24,
            'created_at'    => '2019-05-07 08:20:26',
            'updated_at'    => '2019-05-07 08:20:26',
        ]);

        Centro::create([
            'id'            => 31,
            'nombre'        => 'CENTRO DE GESTIÓN TECNOLÓGICA DE SERVICIOS',
            'codigo_centro' => 9311,
            'direccion'     => 'CL 52 2BIS-15',
            'descripcion'   => null,
            'ciudad_id'     => 1064,
            'regional_id'   => 24,
            'created_at'    => '2019-05-07 08:20:26',
            'updated_at'    => '2019-05-07 08:20:26',
        ]);

        Centro::create([
            'id'            => 32,
            'nombre'        => 'CENTRO DE LA CONSTRUCCIÓN',
            'codigo_centro' => 9228,
            'direccion'     => 'Cl 34 17B-23',
            'descripcion'   => null,
            'ciudad_id'     => 1064,
            'regional_id'   => 24,
            'created_at'    => '2019-05-07 08:20:26',
            'updated_at'    => '2019-05-07 08:20:26',
        ]);

        Centro::create([
            'id'            => 33,
            'nombre'        => 'CENTRO DE FORMACIÓN AGROINDUSTRIAL',
            'codigo_centro' => 9116,
            'direccion'     => 'kmt 8 via al sur',
            'descripcion'   => null,
            'ciudad_id'     => 645,
            'regional_id'   => 13,
            'created_at'    => '2019-05-07 08:20:26',
            'updated_at'    => '2019-05-07 08:20:26',
        ]);

        Centro::create([
            'id'            => 34,
            'nombre'        => 'CENTRO AGROEMPRESARIAL Y MINERO',
            'codigo_centro' => 9104,
            'direccion'     => 'Ternera, via a Turbaco Km 1',
            'descripcion'   => null,
            'ciudad_id'     => 200,
            'regional_id'   => 4,
            'created_at'    => '2019-05-07 08:20:26',
            'updated_at'    => '2019-05-07 08:20:26',
        ]);

        Centro::create([
            'id'            => 35,
            'nombre'        => 'CENTRO DE COMERCIO Y SERVICIOS',
            'codigo_centro' => 9304,
            'direccion'     => 'Ternera, via a Turbaco Km 1',
            'descripcion'   => null,
            'ciudad_id'     => 200,
            'regional_id'   => 4,
            'created_at'    => '2019-05-07 08:20:26',
            'updated_at'    => '2019-05-07 08:20:26',
        ]);

        Centro::create([
            'id'            => 36,
            'nombre'        => 'CENTRO  NAUTICO INTERNACIONAL, FLUVIAL Y PORTUARIO',
            'codigo_centro' => 9105,
            'direccion'     => 'Mamonal Km 5',
            'descripcion'   => null,
            'ciudad_id'     => 166,
            'regional_id'   => 4,
            'created_at'    => '2019-05-07 08:20:26',
            'updated_at'    => '2019-05-07 08:20:26',
        ]);

        Centro::create([
            'id'            => 37,
            'nombre'        => 'CENTRO PARA LA INDUSTRIA PETROQUÍMICA',
            'codigo_centro' => 9218,
            'direccion'     => 'Av. Pedro de Heredia, sector tesca.',
            'descripcion'   => null,
            'ciudad_id'     => 166,
            'regional_id'   => 4,
            'created_at'    => '2019-05-07 08:20:27',
            'updated_at'    => '2019-05-07 08:20:27',
        ]);

        Centro::create([
            'id'            => 38,
            'nombre'        => 'CENTRO DE TECNOLOGÍAS AGROINDUSTRIALES',
            'codigo_centro' => 9543,
            'direccion'     => 'Cr 9 12-141',
            'descripcion'   => null,
            'ciudad_id'     => 1066,
            'regional_id'   => 24,
            'created_at'    => '2019-05-07 08:20:27',
            'updated_at'    => '2019-05-07 08:20:27',
        ]);

        Centro::create([
            'id'            => 39,
            'nombre'        => 'COMPLEJO TECNOLÓGICO PARA LA GESTIÓN AGROEMPRESARIAL',
            'codigo_centro' => 9501,
            'direccion'     => 'Calle 31 Carrera 16 Diagonal al Hospital CUP',
            'descripcion'   => null,
            'ciudad_id'     => 33,
            'regional_id'   => 1,
            'created_at'    => '2019-05-07 08:20:27',
            'updated_at'    => '2019-05-07 08:20:27',
        ]);

        Centro::create([
            'id'            => 40,
            'nombre'        => 'CENTRO DE DESARROLLO AGROEMPRESARIAL',
            'codigo_centro' => 9513,
            'direccion'     => 'CARRERA 9 No 11-34',
            'descripcion'   => null,
            'ciudad_id'     => 536,
            'regional_id'   => 11,
            'created_at'    => '2019-05-07 08:20:27',
            'updated_at'    => '2019-05-07 08:20:27',
        ]);

        Centro::create([
            'id'            => 41,
            'nombre'        => 'CENTRO ATENCIÓN SECTOR AGROPECUARIO',
            'codigo_centro' => 9119,
            'direccion'     => 'Calle 2N AV 4 Y 5 Barrio Pescadero',
            'descripcion'   => null,
            'ciudad_id'     => 823,
            'regional_id'   => 18,
            'created_at'    => '2019-05-07 08:20:27',
            'updated_at'    => '2019-05-07 08:20:27',
        ]);

        Centro::create([
            'id'            => 42,
            'nombre'        => 'CENTRO DE LA INDUSTRIA, LA EMPRESA Y LOS SERVICIOS',
            'codigo_centro' => 9537,
            'direccion'     => 'Calle 2N AV 4 Y 5 Barrio Pescadero',
            'descripcion'   => null,
            'ciudad_id'     => 823,
            'regional_id'   => 18,
            'created_at'    => '2019-05-07 08:20:27',
            'updated_at'    => '2019-05-07 08:20:27',
        ]);

        Centro::create([
            'id'            => 43,
            'nombre'        => 'CENTRO DE DISEÑO E INNOVACIÓN TECNOLÓGICA INDUSTRIAL',
            'codigo_centro' => 9223,
            'direccion'     => 'transv 7 calle 26 Barrio Santa Isabel Dosquebradas',
            'descripcion'   => null,
            'ciudad_id'     => 882,
            'regional_id'   => 20,
            'created_at'    => '2019-05-07 08:20:27',
            'updated_at'    => '2019-05-07 08:20:27',
        ]);

        Centro::create([
            'id'            => 44,
            'nombre'        => 'CENTRO DE DESARROLLO AGROPECUARIO Y AGROINDUSTRIAL',
            'codigo_centro' => 9110,
            'direccion'     => 'KM 1 Via Duitama - Pantano de Vargas',
            'descripcion'   => null,
            'ciudad_id'     => 236,
            'regional_id'   => 5,
            'created_at'    => '2019-05-07 08:20:27',
            'updated_at'    => '2019-05-07 08:20:27',
        ]);

        Centro::create([
            'id'            => 45,
            'nombre'        => 'CENTRO AGROPECUARIO LA GRANJA',
            'codigo_centro' => 9123,
            'direccion'     => 'KILOMETRO 4 VIA PANAMERICANA ESPINAL IBAGUE',
            'descripcion'   => null,
            'ciudad_id'     => 1021,
            'regional_id'   => 23,
            'created_at'    => '2019-05-07 08:20:27',
            'updated_at'    => '2019-05-07 08:20:27',
        ]);

        Centro::create([
            'id'            => 46,
            'nombre'        => 'CENTRO TECNOLÓGICO DE LA AMAZONÍA',
            'codigo_centro' => 9516,
            'direccion'     => 'Kilómetro 3 Vía Aeropuerto',
            'descripcion'   => null,
            'ciudad_id'     => 360,
            'regional_id'   => 7,
            'created_at'    => '2019-05-07 08:20:27',
            'updated_at'    => '2019-05-07 08:20:27',
        ]);

        Centro::create([
            'id'            => 47,
            'nombre'        => 'CENTRO INDUSTRIAL DEL DISEÑO Y LA MANUFACTURA',
            'codigo_centro' => 9225,
            'direccion'     => 'Autopista Floridablanca No. 50-33',
            'descripcion'   => null,
            'ciudad_id'     => 925,
            'regional_id'   => 21,
            'created_at'    => '2019-05-07 08:20:27',
            'updated_at'    => '2019-05-07 08:20:27',
        ]);

        Centro::create([
            'id'            => 48,
            'nombre'        => 'CENTRO AGROEMPRESARIAL Y ACUÍCOLA',
            'codigo_centro' => 9524,
            'direccion'     => 'Kilómetro 1 Salida a Barrancas',
            'descripcion'   => null,
            'ciudad_id'     => 681,
            'regional_id'   => 14,
            'created_at'    => '2019-05-07 08:20:27',
            'updated_at'    => '2019-05-07 08:20:27',
        ]);

        Centro::create([
            'id'            => 49,
            'nombre'        => 'CENTRO AGROECOLÓGICO Y EMPRESARIAL',
            'codigo_centro' => 9510,
            'direccion'     => 'AVENIDA MANUEL H CARDENAS CALLE 16',
            'descripcion'   => null,
            'ciudad_id'     => 547,
            'regional_id'   => 11,
            'created_at'    => '2019-05-07 08:20:27',
            'updated_at'    => '2019-05-07 08:20:27',
        ]);

        Centro::create([
            'id'            => 50,
            'nombre'        => 'CENTRO ACUÍCOLA Y AGROINDUSTRIAL DE GAIRA',
            'codigo_centro' => 9118,
            'direccion'     => 'Kilometro 6 Via gaira',
            'descripcion'   => null,
            'ciudad_id'     => 716,
            'regional_id'   => 15,
            'created_at'    => '2019-05-07 08:20:27',
            'updated_at'    => '2019-05-07 08:20:27',
        ]);

        Centro::create([
            'id'            => 51,
            'nombre'        => 'CENTRO AGROEMPRESARIAL Y DESARROLLO PECUARIO DEL HUILA',
            'codigo_centro' => 9525,
            'direccion'     => 'carrera 10 No 11-22',
            'descripcion'   => null,
            'ciudad_id'     => 648,
            'regional_id'   => 13,
            'created_at'    => '2019-05-07 08:20:27',
            'updated_at'    => '2019-05-07 08:20:27',
        ]);

        Centro::create([
            'id'            => 52,
            'nombre'        => 'CENTRO DE LA TECNOLOGÍA DEL DISEÑO Y LA PRODUCTIVIDAD EMPRESARIAL',
            'codigo_centro' => 9511,
            'direccion'     => 'CARRERA 10 No 30-04',
            'descripcion'   => null,
            'ciudad_id'     => 554,
            'regional_id'   => 11,
            'created_at'    => '2019-05-07 08:20:27',
            'updated_at'    => '2019-05-07 08:20:27',
        ]);

        Centro::create([
            'id'            => 53,
            'nombre'        => 'CENTRO INDUSTRIAL DE MANTENIMIENTO INTEGRAL',
            'codigo_centro' => 9224,
            'direccion'     => 'Via Palenque- Rincón de Girón-Zona Industrial  de Girón',
            'descripcion'   => null,
            'ciudad_id'     => 928,
            'regional_id'   => 21,
            'created_at'    => '2019-05-07 08:20:28',
            'updated_at'    => '2019-05-07 08:20:28',
        ]);

        Centro::create([
            'id'            => 54,
            'nombre'        => 'CENTRO DE INDUSTRIA Y CONSTRUCCIÓN',
            'codigo_centro' => 9226,
            'direccion'     => 'Cra. 4 Estadio Calle 44 Avenida Ferrocarril',
            'descripcion'   => null,
            'ciudad_id'     => 1028,
            'regional_id'   => 22,
            'created_at'    => '2019-05-07 08:20:28',
            'updated_at'    => '2019-05-07 08:20:28',
        ]);

        Centro::create([
            'id'            => 55,
            'nombre'        => 'CENTRO DE COMERCIO Y SERVICIOS',
            'codigo_centro' => 9310,
            'direccion'     => 'Cra. 4 Estadio Calle 44 Avenida Ferrocarril',
            'descripcion'   => null,
            'ciudad_id'     => 1028,
            'regional_id'   => 22,
            'created_at'    => '2019-05-07 08:20:28',
            'updated_at'    => '2019-05-07 08:20:28',
        ]);

        Centro::create([
            'id'            => 56,
            'nombre'        => 'CENTRO SUR COLOMBIANO DE LOGÍSTICA INTERNACIONAL',
            'codigo_centro' => 9534,
            'direccion'     => 'CRA. 7 No.24A-48',
            'descripcion'   => null,
            'ciudad_id'     => 778,
            'regional_id'   => 17,
            'created_at'    => '2019-05-07 08:20:28',
            'updated_at'    => '2019-05-07 08:20:28',
        ]);

        Centro::create([
            'id'            => 57,
            'nombre'        => 'CENTRO DEL DISEÑO Y MANUFACTURA DE CUERO',
            'codigo_centro' => 9201,
            'direccion'     => 'Calle 63  58B - 03',
            'descripcion'   => null,
            'ciudad_id'     => 59,
            'regional_id'   => 1,
            'created_at'    => '2019-05-07 08:20:28',
            'updated_at'    => '2019-05-07 08:20:28',
        ]);

        Centro::create([
            'id'            => 58,
            'nombre'        => 'CENTRO DE FORMACIÓN EN DISEÑO, CONFECCION Y MODA',
            'codigo_centro' => 9202,
            'direccion'     => 'Calle 63  58B - 03',
            'descripcion'   => null,
            'ciudad_id'     => 59,
            'regional_id'   => 1,
            'created_at'    => '2019-05-07 08:20:28',
            'updated_at'    => '2019-05-07 08:20:28',
        ]);

        Centro::create([
            'id'            => 59,
            'nombre'        => 'CENTRO TECNOLÓGICO DEL MOBILIARIO',
            'codigo_centro' => 9205,
            'direccion'     => 'Calle 63  58B - 03',
            'descripcion'   => null,
            'ciudad_id'     => 59,
            'regional_id'   => 1,
            'created_at'    => '2019-05-07 08:20:28',
            'updated_at'    => '2019-05-07 08:20:28',
        ]);

        Centro::create([
            'id'            => 60,
            'nombre'        => 'CENTRO AGROPECUARIO Y DE BIOTECNOLOGÍA EL PORVENIR',
            'codigo_centro' => 9115,
            'direccion'     => 'Via Santa Isabel Km. 7',
            'descripcion'   => null,
            'ciudad_id'     => 500,
            'regional_id'   => 10,
            'created_at'    => '2019-05-07 08:20:28',
            'updated_at'    => '2019-05-07 08:20:28',
        ]);

        Centro::create([
            'id'            => 61,
            'nombre'        => 'CENTRO PECUARIO Y AGROEMPRESARIAL',
            'codigo_centro' => 9515,
            'direccion'     => 'Calle 41 Carrera 1a. Barrio Alfonso López',
            'descripcion'   => null,
            'ciudad_id'     => 333,
            'regional_id'   => 6,
            'created_at'    => '2019-05-07 08:20:28',
            'updated_at'    => '2019-05-07 08:20:28',
        ]);

        Centro::create([
            'id'            => 62,
            'nombre'        => 'CENTRO DE DESARROLLO AGROEMPRESARIAL Y TURÍSTICO DEL HUILA',
            'codigo_centro' => 9526,
            'direccion'     => 'Calle 6 Carrera 7 (Esquina)',
            'descripcion'   => null,
            'ciudad_id'     => 654,
            'regional_id'   => 13,
            'created_at'    => '2019-05-07 08:20:28',
            'updated_at'    => '2019-05-07 08:20:28',
        ]);

        Centro::create([
            'id'            => 63,
            'nombre'        => 'CENTRO PARA LA BIODIVERSIDAD Y EL TURISMO DEL AMAZONAS',
            'codigo_centro' => 9517,
            'direccion'     => 'Calle 12 No 10 - 60 ',
            'descripcion'   => null,
            'ciudad_id'     => 1,
            'regional_id'   => 29,
            'created_at'    => '2019-05-07 08:20:28',
            'updated_at'    => '2019-05-07 08:20:28',
        ]);

        Centro::create([
            'id'            => 64,
            'nombre'        => 'CENTRO AGROEMPRESARIAL Y TURÍSITICO DE LOS ANDES',
            'codigo_centro' => 9545,
            'direccion'     => 'Carrera 11 No. 13-13 Barrio Ricaurte- Malaga',
            'descripcion'   => null,
            'ciudad_id'     => 947,
            'regional_id'   => 21,
            'created_at'    => '2019-05-07 08:20:28',
            'updated_at'    => '2019-05-07 08:20:28',
        ]);

        Centro::create([
            'id'            => 65,
            'nombre'        => 'CENTRO PARA LA FORMACIÓN CAFETERA',
            'codigo_centro' => 9112,
            'direccion'     => 'Km. 10 Vía al Magdalena',
            'descripcion'   => null,
            'ciudad_id'     => 336,
            'regional_id'   => 6,
            'created_at'    => '2019-05-07 08:20:28',
            'updated_at'    => '2019-05-07 08:20:28',
        ]);

        Centro::create([
            'id'            => 66,
            'nombre'        => 'CENTRO DE AUTOMATIZACIÓN INDUSTRIAL',
            'codigo_centro' => 9219,
            'direccion'     => 'Km. 10 Vía al Magdalena',
            'descripcion'   => null,
            'ciudad_id'     => 336,
            'regional_id'   => 6,
            'created_at'    => '2019-05-07 08:20:28',
            'updated_at'    => '2019-05-07 08:20:28',
        ]);

        Centro::create([
            'id'            => 67,
            'nombre'        => 'CENTRO DE PROCESOS INDUSTRIALES',
            'codigo_centro' => 9220,
            'direccion'     => 'Km. 10 Vía al Magdalena',
            'descripcion'   => null,
            'ciudad_id'     => 336,
            'regional_id'   => 6,
            'created_at'    => '2019-05-07 08:20:28',
            'updated_at'    => '2019-05-07 08:20:28',
        ]);

        Centro::create([
            'id'            => 68,
            'nombre'        => 'CENTRO DE COMERCIO Y SERVICIOS',
            'codigo_centro' => 9306,
            'direccion'     => 'Km. 10 Vía al Magdalena',
            'descripcion'   => null,
            'ciudad_id'     => 336,
            'regional_id'   => 6,
            'created_at'    => '2019-05-07 08:20:28',
            'updated_at'    => '2019-05-07 08:20:28',
        ]);

        Centro::create([
            'id'            => 69,
            'nombre'        => 'CENTRO DE COMERCIO',
            'codigo_centro' => 9301,
            'direccion'     => 'Calle 51 No 57-70 ',
            'descripcion'   => null,
            'ciudad_id'     => 70,
            'regional_id'   => 1,
            'created_at'    => '2019-05-07 08:20:28',
            'updated_at'    => '2019-05-07 08:20:28',
        ]);

        Centro::create([
            'id'            => 70,
            'nombre'        => 'CENTRO DE SERVICIOS DE SALUD',
            'codigo_centro' => 9401,
            'direccion'     => 'Calle 51 No 57-70 Piso 2 ',
            'descripcion'   => null,
            'ciudad_id'     => 70,
            'regional_id'   => 1,
            'created_at'    => '2019-05-07 08:20:28',
            'updated_at'    => '2019-05-07 08:20:28',
        ]);

        Centro::create([
            'id'            => 71,
            'nombre'        => 'CENTRO DE SERVICIOS Y GESTIÓN EMPRESARIAL ',
            'codigo_centro' => 9402,
            'direccion'     => 'Calle 57 No. 51-75',
            'descripcion'   => null,
            'ciudad_id'     => 70,
            'regional_id'   => 1,
            'created_at'    => '2019-05-07 08:20:28',
            'updated_at'    => '2019-05-07 08:20:28',
        ]);

        Centro::create([
            'id'            => 72,
            'nombre'        => 'CENTRO PARA EL DESARROLLO DEL HABITAT Y LA CONSTRUCCIÓN',
            'codigo_centro' => 9203,
            'direccion'     => 'Calle 104 69-120 Barrio el Pedregal',
            'descripcion'   => null,
            'ciudad_id'     => 70,
            'regional_id'   => 1,
            'created_at'    => '2019-05-07 08:20:28',
            'updated_at'    => '2019-05-07 08:20:28',
        ]);

        Centro::create([
            'id'            => 73,
            'nombre'        => 'CENTRO DE TECNOLOGÍA DE LA MANUFACTURA AVANZADA',
            'codigo_centro' => 9204,
            'direccion'     => 'Diagonal 104 No 69-120 B/Pedregal ',
            'descripcion'   => null,
            'ciudad_id'     => 70,
            'regional_id'   => 1,
            'created_at'    => '2019-05-07 08:20:28',
            'updated_at'    => '2019-05-07 08:20:28',
        ]);

        Centro::create([
            'id'            => 74,
            'nombre'        => 'TECNOLÓGICO DE GESTIÓN INDUSTRIAL',
            'codigo_centro' => 9206,
            'direccion'     => 'Calle 104 69-120 Barrio el Pedregal',
            'descripcion'   => null,
            'ciudad_id'     => 70,
            'regional_id'   => 1,
            'created_at'    => '2019-05-07 08:20:28',
            'updated_at'    => '2019-05-07 08:20:28',
        ]);

        Centro::create([
            'id'            => 75,
            'nombre'        => 'CENTRO AGROPECUARIO Y DE SERVICIOS AMBIENTALES JIRI-JIRIMO',
            'codigo_centro' => 9548,
            'direccion'     => 'Avenida 15 No 6 - 176',
            'descripcion'   => null,
            'ciudad_id'     => 1097,
            'regional_id'   => 32,
            'created_at'    => '2019-05-07 08:20:28',
            'updated_at'    => '2019-05-07 08:20:28',
        ]);

        Centro::create([
            'id'            => 76,
            'nombre'        => 'CENTRO DE COMERCIO, INDUSTRIA Y TURISMO DE CÓRDOBA',
            'codigo_centro' => 9523,
            'direccion'     => 'Av. Circunvalar Cls. 24 y 27',
            'descripcion'   => null,
            'ciudad_id'     => 500,
            'regional_id'   => 10,
            'created_at'    => '2019-05-07 08:20:28',
            'updated_at'    => '2019-05-07 08:20:28',
        ]);

        Centro::create([
            'id'            => 77,
            'nombre'        => 'CENTRO MINERO',
            'codigo_centro' => 9111,
            'direccion'     => 'Vereda Morcá Sogamoso',
            'descripcion'   => null,
            'ciudad_id'     => 298,
            'regional_id'   => 5,
            'created_at'    => '2019-05-07 08:20:28',
            'updated_at'    => '2019-05-07 08:20:28',
        ]);

        Centro::create([
            'id'            => 78,
            'nombre'        => 'CENTRO DE BIOTECNOLOGÍA AGROPECUARIA',
            'codigo_centro' => 9512,
            'direccion'     => 'KM 7 VIA MOSQUERA',
            'descripcion'   => null,
            'ciudad_id'     => 576,
            'regional_id'   => 11,
            'created_at'    => '2019-05-07 08:20:28',
            'updated_at'    => '2019-05-07 08:20:28',
        ]);

        Centro::create([
            'id'            => 79,
            'nombre'        => 'CENTRO DE LA INDUSTRIA, LA EMPRESA Y LOS SERVICIOS',
            'codigo_centro' => 9527,
            'direccion'     => 'Carrera 5 Av la toma',
            'descripcion'   => null,
            'ciudad_id'     => 655,
            'regional_id'   => 13,
            'created_at'    => '2019-05-07 08:20:29',
            'updated_at'    => '2019-05-07 08:20:29',
        ]);

        Centro::create([
            'id'            => 80,
            'nombre'        => 'CENTRO DE BIOTECNOLOGÍA INDUSTRIAL',
            'codigo_centro' => 9544,
            'direccion'     => 'Cr 30 40-25',
            'descripcion'   => null,
            'ciudad_id'     => 1080,
            'regional_id'   => 24,
            'created_at'    => '2019-05-07 08:20:29',
            'updated_at'    => '2019-05-07 08:20:29',
        ]);

        Centro::create([
            'id'            => 81,
            'nombre'        => 'CENTRO INTERNACIONAL DE PRODUCCION LIMPIA - LOPE',
            'codigo_centro' => 9536,
            'direccion'     => 'CALLE 22 11 ESTE 05-VIA A ORIENTE',
            'descripcion'   => null,
            'ciudad_id'     => 801,
            'regional_id'   => 17,
            'created_at'    => '2019-05-07 08:20:29',
            'updated_at'    => '2019-05-07 08:20:29',
        ]);

        Centro::create([
            'id'            => 82,
            'nombre'        => 'CENTRO ATENCIÓN SECTOR AGROPECUARIO',
            'codigo_centro' => 9121,
            'direccion'     => 'Cra 8a. No. 26-69',
            'descripcion'   => null,
            'ciudad_id'     => 888,
            'regional_id'   => 20,
            'created_at'    => '2019-05-07 08:20:29',
            'updated_at'    => '2019-05-07 08:20:29',
        ]);

        Centro::create([
            'id'            => 83,
            'nombre'        => 'CENTRO DE COMERCIO Y SERVICIOS',
            'codigo_centro' => 9308,
            'direccion'     => 'Cra 8a. No. 26-69',
            'descripcion'   => null,
            'ciudad_id'     => 888,
            'regional_id'   => 20,
            'created_at'    => '2019-05-07 08:20:29',
            'updated_at'    => '2019-05-07 08:20:29',
        ]);

        Centro::create([
            'id'            => 84,
            'nombre'        => 'CENTRO ATENCIÓN SECTOR AGROPECUARIO',
            'codigo_centro' => 9122,
            'direccion'     => 'km. 2 via Palogordo- Vereda Gutiguara Piedecuesta',
            'descripcion'   => null,
            'ciudad_id'     => 953,
            'regional_id'   => 21,
            'created_at'    => '2019-05-07 08:20:29',
            'updated_at'    => '2019-05-07 08:20:29',
        ]);

        Centro::create([
            'id'            => 85,
            'nombre'        => 'CENTRO DE GESTIÓN Y DESARROLLO SOSTENIBLE SURCOLOMBIANO',
            'codigo_centro' => 9528,
            'direccion'     => 'Carrera 8 No 7 - 53',
            'descripcion'   => null,
            'ciudad_id'     => 662,
            'regional_id'   => 13,
            'created_at'    => '2019-05-07 08:20:29',
            'updated_at'    => '2019-05-07 08:20:29',
        ]);

        Centro::create([
            'id'            => 86,
            'nombre'        => 'CENTRO AGROPECUARIO',
            'codigo_centro' => 9113,
            'direccion'     => 'Carrera 9 #69-00 Avenida Panamericana',
            'descripcion'   => null,
            'ciudad_id'     => 414,
            'regional_id'   => 8,
            'created_at'    => '2019-05-07 08:20:29',
            'updated_at'    => '2019-05-07 08:20:29',
        ]);

        Centro::create([
            'id'            => 87,
            'nombre'        => 'CENTRO DE TELEINFORMÁTICA Y PRODUCCIÓN INDUSTRIAL',
            'codigo_centro' => 9221,
            'direccion'     => 'Carrera 9 #69-00 Avenida Panamericana',
            'descripcion'   => null,
            'ciudad_id'     => 414,
            'regional_id'   => 8,
            'created_at'    => '2019-05-07 08:20:29',
            'updated_at'    => '2019-05-07 08:20:29',
        ]);

        Centro::create([
            'id'            => 88,
            'nombre'        => 'CENTRO DE COMERCIO Y SERVICIOS',
            'codigo_centro' => 9307,
            'direccion'     => 'Calle 4 #2-67',
            'descripcion'   => null,
            'ciudad_id'     => 414,
            'regional_id'   => 8,
            'created_at'    => '2019-05-07 08:20:29',
            'updated_at'    => '2019-05-07 08:20:29',
        ]);

        Centro::create([
            'id'            => 89,
            'nombre'        => 'CENTRO AGROFORESTAL Y ACUÍCOLA ARAPAIMA',
            'codigo_centro' => 9518,
            'direccion'     => 'Cra.23 # 16a-06 B/20 de Julio Puerto Asís Putumayo',
            'descripcion'   => null,
            'ciudad_id'     => 857,
            'regional_id'   => 27,
            'created_at'    => '2019-05-07 08:20:29',
            'updated_at'    => '2019-05-07 08:20:29',
        ]);

        Centro::create([
            'id'            => 90,
            'nombre'        => 'COMPLEJO TECNOLÓGICO MINERO AGROEMPRESARIAL',
            'codigo_centro' => 9502,
            'direccion'     => 'Calle 43  20-137',
            'descripcion'   => null,
            'ciudad_id'     => 81,
            'regional_id'   => 1,
            'created_at'    => '2019-05-07 08:20:29',
            'updated_at'    => '2019-05-07 08:20:29',
        ]);

        Centro::create([
            'id'            => 91,
            'nombre'        => 'CENTRO DE PRODUCCIÓN Y TRANSFORMACIÓN AGROINDUSTRIAL DE LA ORINOQUÍA',
            'codigo_centro' => 9531,
            'direccion'     => '(Sede Nueva) Carrera 10 No 15 - 131 Barrio Tamarido',
            'descripcion'   => null,
            'ciudad_id'     => 1101,
            'regional_id'   => 33,
            'created_at'    => '2019-05-07 08:20:29',
            'updated_at'    => '2019-05-07 08:20:29',
        ]);

        Centro::create([
            'id'            => 92,
            'nombre'        => 'CENTRO AMBIENTAL Y ECOTURÍSTICO DEL NORORIENTE AMAZÓNICO',
            'codigo_centro' => 9547,
            'direccion'     => 'Transversal 6 Nº 29a-55, via al Coco',
            'descripcion'   => null,
            'ciudad_id'     => 634,
            'regional_id'   => 30,
            'created_at'    => '2019-05-07 08:20:29',
            'updated_at'    => '2019-05-07 08:20:29',
        ]);

        Centro::create([
            'id'            => 93,
            'nombre'        => 'CENTRO AGROINDUSTRIAL DEL META',
            'codigo_centro' => 9117,
            'direccion'     => 'Km. 17  Vía  Pueto. López',
            'descripcion'   => null,
            'ciudad_id'     => 740,
            'regional_id'   => 16,
            'created_at'    => '2019-05-07 08:20:29',
            'updated_at'    => '2019-05-07 08:20:29',
        ]);

        Centro::create([
            'id'            => 94,
            'nombre'        => 'CENTRO DE RECURSOS NATURALES, INDUSTRIA Y BIODIVERSIDAD',
            'codigo_centro' => 9522,
            'direccion'     => 'CRA. 1 No28 - 71',
            'descripcion'   => null,
            'ciudad_id'     => 477,
            'regional_id'   => 12,
            'created_at'    => '2019-05-07 08:20:29',
            'updated_at'    => '2019-05-07 08:20:29',
        ]);

        Centro::create([
            'id'            => 95,
            'nombre'        => 'CENTRO INDUSTRIAL Y DE ENERGÍAS ALTERNATIVAS',
            'codigo_centro' => 9222,
            'direccion'     => 'Avenida aeropuerto calle 21',
            'descripcion'   => null,
            'ciudad_id'     => 686,
            'regional_id'   => 14,
            'created_at'    => '2019-05-07 08:20:29',
            'updated_at'    => '2019-05-07 08:20:29',
        ]);

        Centro::create([
            'id'            => 96,
            'nombre'        => 'CENTRO DE LA INNOVACIÓN, LA AGROINDUSTRIA Y EL TURISMO',
            'codigo_centro' => 9503,
            'direccion'     => 'Carrera 48  No. 49-62',
            'descripcion'   => null,
            'ciudad_id'     => 86,
            'regional_id'   => 1,
            'created_at'    => '2019-05-07 08:20:29',
            'updated_at'    => '2019-05-07 08:20:29',
        ]);

        Centro::create([
            'id'            => 97,
            'nombre'        => 'CENTRO DE FORMACION TURISTICA, GENTE DE MAR Y DE SERVICIOS ',
            'codigo_centro' => 9539,
            'direccion'     => 'Avenida Franciscon Newball',
            'descripcion'   => null,
            'ciudad_id'     => 961,
            'regional_id'   => 28,
            'created_at'    => '2019-05-07 08:20:29',
            'updated_at'    => '2019-05-07 08:20:29',
        ]);

        Centro::create([
            'id'            => 98,
            'nombre'        => 'CENTRO AGROTURÍSTICO',
            'codigo_centro' => 9541,
            'direccion'     => 'calle 22 No. 9 -82 San Gil',
            'descripcion'   => null,
            'ciudad_id'     => 963,
            'regional_id'   => 21,
            'created_at'    => '2019-05-07 08:20:29',
            'updated_at'    => '2019-05-07 08:20:29',
        ]);

        Centro::create([
            'id'            => 99,
            'nombre'        => 'CENTRO DE DESARROLLO AGROINDUSTRIAL, TURÍSTICO Y TECNOLÓGICO DEL GUAVIARE',
            'codigo_centro' => 9533,
            'direccion'     => 'Carrera 24 # 7 - 10 Centro',
            'descripcion'   => null,
            'ciudad_id'     => 638,
            'regional_id'   => 31,
            'created_at'    => '2019-05-07 08:20:29',
            'updated_at'    => '2019-05-07 08:20:29',
        ]);

        Centro::create([
            'id'            => 100,
            'nombre'        => 'CENTRO DE LOGÍSTICA Y PROMOCIÓN ECOTURÍSTICA DEL MAGDALENA',
            'codigo_centro' => 9529,
            'direccion'     => 'Avenida del ferrocarril # 27-97 Santa Marta',
            'descripcion'   => null,
            'ciudad_id'     => 716,
            'regional_id'   => 15,
            'created_at'    => '2019-05-07 08:20:29',
            'updated_at'    => '2019-05-07 08:20:29',
        ]);

        Centro::create([
            'id'            => 101,
            'nombre'        => 'CENTRO DE LA INNOVACIÓN, LA TECNOLOGÍA Y LOS SERVICIOS',
            'codigo_centro' => 9542,
            'direccion'     => 'Calle 25 b Nro. 31-260',
            'descripcion'   => null,
            'ciudad_id'     => 1002,
            'regional_id'   => 22,
            'created_at'    => '2019-05-07 08:20:29',
            'updated_at'    => '2019-05-07 08:20:29',
        ]);

        Centro::create([
            'id'            => 102,
            'nombre'        => 'CENTRO DE TECNOLOGÍAS PARA LA CONSTRUCCIÓN Y LA MADERA',
            'codigo_centro' => 9209,
            'direccion'     => 'Calle 8 No. 6 -54 entrada 3 zona industrial Cazuca',
            'descripcion'   => null,
            'ciudad_id'     => 603,
            'regional_id'   => 3,
            'created_at'    => '2019-05-07 08:20:30',
            'updated_at'    => '2019-05-07 08:20:30',
        ]);

        Centro::create([
            'id'            => 103,
            'nombre'        => 'CENTRO DE TECNOLOGÍAS DEL TRANSPORTE',
            'codigo_centro' => 9213,
            'direccion'     => 'Calle 8 No. 6 -54 entrada 3 zona industrial Cazuca',
            'descripcion'   => null,
            'ciudad_id'     => 603,
            'regional_id'   => 3,
            'created_at'    => '2019-05-07 08:20:30',
            'updated_at'    => '2019-05-07 08:20:30',
        ]);

        Centro::create([
            'id'            => 104,
            'nombre'        => 'CENTRO INDUSTRIAL Y DESARROLLO EMPRESARIAL DE SOACHA',
            'codigo_centro' => 9406,
            'direccion'     => 'Calle 8 No. 6 -54 entrada 3 zona industrial Cazuca',
            'descripcion'   => null,
            'ciudad_id'     => 603,
            'regional_id'   => 3,
            'created_at'    => '2019-05-07 08:20:30',
            'updated_at'    => '2019-05-07 08:20:30',
        ]);

        Centro::create([
            'id'            => 105,
            'nombre'        => 'CENTRO INDUSTRIAL Y DESARROLLO EMPRESARIAL DE SOACHA',
            'codigo_centro' => 9232,
            'direccion'     => 'CARRERA 7 No 14-41 CENTRO CASA CULTURA',
            'descripcion'   => null,
            'ciudad_id'     => 603,
            'regional_id'   => 11,
            'created_at'    => '2019-05-07 08:20:30',
            'updated_at'    => '2019-05-07 08:20:30',
        ]);

        Centro::create([
            'id'            => 106,
            'nombre'        => 'CENTRO NACIONAL DE HOTELERÍA, TURISMO Y ALIMENTOS',
            'codigo_centro' => 9232,
            'direccion'     => 'Calle 8 No. 6 -54 entrada 3 zona industrial Cazuca',
            'descripcion'   => null,
            'ciudad_id'     => 603,
            'regional_id'   => 11,
            'created_at'    => '2019-05-07 08:20:30',
            'updated_at'    => '2019-05-07 08:20:30',
        ]);

        Centro::create([
            'id'            => 107,
            'nombre'        => 'CENTRO INDUSTRIAL DE MANTENIMIENTO Y MANUFACTURA',
            'codigo_centro' => 9514,
            'direccion'     => 'Carrera 12 No 55 A-51',
            'descripcion'   => null,
            'ciudad_id'     => 298,
            'regional_id'   => 5,
            'created_at'    => '2019-05-07 08:20:30',
            'updated_at'    => '2019-05-07 08:20:30',
        ]);

        Centro::create([
            'id'            => 108,
            'nombre'        => 'CENTRO LATINOAMERICANO DE  ESERVICIO PUBLICO DE EMPLEOCIES MENORES',
            'codigo_centro' => 9125,
            'direccion'     => 'Carretera Central Tulua - Buga - Km 2',
            'descripcion'   => null,
            'ciudad_id'     => 1089,
            'regional_id'   => 24,
            'created_at'    => '2019-05-07 08:20:30',
            'updated_at'    => '2019-05-07 08:20:30',
        ]);

        Centro::create([
            'id'            => 109,
            'nombre'        => 'CENTRO AGROINDUSTRIAL Y PESQUERO DE LA COSTA PACÍFICA',
            'codigo_centro' => 9535,
            'direccion'     => 'Calle del Comercio y Edificio Madrigal ',
            'descripcion'   => null,
            'ciudad_id'     => 811,
            'regional_id'   => 17,
            'created_at'    => '2019-05-07 08:20:30',
            'updated_at'    => '2019-05-07 08:20:30',
        ]);

        Centro::create([
            'id'            => 110,
            'nombre'        => 'CENTRO DE GESTIÓN ADMINISTRATIVA Y FORTALECIMIENTO EMPRESARIAL',
            'codigo_centro' => 9305,
            'direccion'     => 'Calle 19 No 12 - 29',
            'descripcion'   => null,
            'ciudad_id'     => 317,
            'regional_id'   => 5,
            'created_at'    => '2019-05-07 08:20:30',
            'updated_at'    => '2019-05-07 08:20:30',
        ]);

        Centro::create([
            'id'            => 111,
            'nombre'        => 'CENTRO DE OPERACIÓN Y MANTENIMIENTO MINERO',
            'codigo_centro' => 9521,
            'direccion'     => 'carrera 19 entre calle 14 y 15 ',
            'descripcion'   => null,
            'ciudad_id'     => 455,
            'regional_id'   => 9,
            'created_at'    => '2019-05-07 08:20:30',
            'updated_at'    => '2019-05-07 08:20:30',
        ]);

        Centro::create([
            'id'            => 112,
            'nombre'        => 'CENTRO BIOTECNOLÓGICO DEL CARIBE',
            'codigo_centro' => 9114,
            'direccion'     => 'Kilometro 7 Via a la Paz ',
            'descripcion'   => null,
            'ciudad_id'     => 455,
            'regional_id'   => 9,
            'created_at'    => '2019-05-07 08:20:30',
            'updated_at'    => '2019-05-07 08:20:30',
        ]);

        Centro::create([
            'id'            => 113,
            'nombre'        => 'CENTRO DE GESTIÓN AGROEMPRESARIAL DEL ORIENTE',
            'codigo_centro' => 9546,
            'direccion'     => 'Calle 8 No. 2 este par avenida las cuadras antiguo Idema- Velez',
            'descripcion'   => null,
            'ciudad_id'     => 979,
            'regional_id'   => 21,
            'created_at'    => '2019-05-07 08:20:30',
            'updated_at'    => '2019-05-07 08:20:30',
        ]);

        Centro::create([
            'id'            => 114,
            'nombre'        => 'CENTRO AGROINDUSTRIAL',
            'codigo_centro' => 9120,
            'direccion'     => 'Carrera 6 # 42 Norte-02 Avenida centenario',
            'descripcion'   => null,
            'ciudad_id'     => 867,
            'regional_id'   => 19,
            'created_at'    => '2019-05-07 08:20:30',
            'updated_at'    => '2019-05-07 08:20:30',
        ]);

        Centro::create([
            'id'            => 115,
            'nombre'        => 'CENTRO PARA EL DESARROLLO TECNOLÓGICO DE LA CONSTRUCCIÓN',
            'codigo_centro' => 9231,
            'direccion'     => 'Carrera 6 # 42 Norte-02 Avenida centenario',
            'descripcion'   => null,
            'ciudad_id'     => 867,
            'regional_id'   => 19,
            'created_at'    => '2019-05-07 08:20:30',
            'updated_at'    => '2019-05-07 08:20:30',
        ]);

        Centro::create([
            'id'            => 116,
            'nombre'        => 'CENTRO DE INDUSTRIA Y SERVICIOS DEL META',
            'codigo_centro' => 9532,
            'direccion'     => 'KM  1 VIA ACACIAS',
            'descripcion'   => null,
            'ciudad_id'     => 748,
            'regional_id'   => 16,
            'created_at'    => '2019-05-07 08:20:30',
            'updated_at'    => '2019-05-07 08:20:30',
        ]);

        Centro::create([
            'id'            => 117,
            'nombre'        => 'CENTRO DE DESARROLLO AGROINDUSTRIAL Y EMPRESARIAL',
            'codigo_centro' => 9509,
            'direccion'     => 'Calle 2 No.13-03 Barrio San Rafael ',
            'descripcion'   => null,
            'ciudad_id'     => 628,
            'regional_id'   => 11,
            'created_at'    => '2019-05-07 08:20:30',
            'updated_at'    => '2019-05-07 08:20:30',
        ]);

        Centro::create([
            'id'            => 118,
            'nombre'        => 'CENTRO AGROINDUSTRIAL Y FORTALECIMIENTO EMPRESARIAL DE CASANARE',
            'codigo_centro' => 9519,
            'direccion'     => 'Cra. 19 No.36-68',
            'descripcion'   => null,
            'ciudad_id'     => 388,
            'regional_id'   => 26,
            'created_at'    => '2019-05-07 08:20:30',
            'updated_at'    => '2019-05-07 08:20:30',
        ]);

    }
}
