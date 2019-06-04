<?php

use App\Models\Entidad;
use Illuminate\Database\Seeder;

class EntidadesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Entidad::create([
            'id'        => 1,
            'ciudad_id' => 431,
            'nombre'    => 'CENTRO AGROEMPRESARIAL',
            'direccion' => 'KILÓMETRO 1 VÍA BUCARAMANGA',
        ]);

        Entidad::create([
            'id'        => 2,
            'ciudad_id' => 13,
            'nombre'    => 'COMPLEJO TECNOLÓGICO AGROINDUSTRIAL, PECUARIO Y TURÍSTICO ',
            'direccion' => 'Km.1 Salida a Turbo',
        ]);

        Entidad::create([
            'id'        => 3,
            'ciudad_id' => 128,
            'nombre'    => 'CENTRO DE GESTIÓN Y DESARROLLO AGROINDUSTRIAL DE ARAUCA',
            'direccion' => 'Carrera 20 No. 28 - 163',
        ]);

        Entidad::create([
            'id'        => 4,
            'ciudad_id' => 867,
            'nombre'    => 'CENTRO DE COMERCIO, INDUSTRIA Y TURISMO',
            'direccion' => 'Carrera 18 No. 7-58',
        ]);

        Entidad::create([
            'id'        => 5,
            'ciudad_id' => 899,
            'nombre'    => 'CENTRO INDUSTRIAL Y DEL DESARROLLO TECNOLÓGICO',
            'direccion' => 'Carrera 28 No. 56-10 Barrio Galan- Barrancabermeja- ',
        ]);

        Entidad::create([
            'id'        => 6,
            'ciudad_id' => 136,
            'nombre'    => 'CENTRO PARA EL DESARROLLO AGROECOLÓGICO Y AGROINDUSTRIAL',
            'direccion' => 'CARRERA 43 42-40 ',
        ]);

        Entidad::create([
            'id'        => 7,
            'ciudad_id' => 136,
            'nombre'    => 'CENTRO DE COMERCIO Y SERVICIOS',
            'direccion' => 'CARRERA 43 42-40 ',
        ]);

        Entidad::create([
            'id'        => 8,
            'ciudad_id' => 136,
            'nombre'    => 'CENTRO NACIONAL COLOMBO ALEMAN',
            'direccion' => 'CALLE 30 # 3E-164',
        ]);

        Entidad::create([
            'id'        => 9,
            'ciudad_id' => 136,
            'nombre'    => 'CENTRO INDUSTRIAL Y DE AVIACIÓN',
            'direccion' => 'CALLE 30 # 3E-164',
        ]);

        Entidad::create([
            'id'        => 10,
            'ciudad_id' => 525,
            'nombre'    => 'CENTRO DE SERVICIOS FINANCIEROS',
            'direccion' => 'Cra 13 No 65-10, Pisos 1 7 a 21',
        ]);

        Entidad::create([
            'id'        => 11,
            'ciudad_id' => 525,
            'nombre'    => 'CENTRO DE TECNOLOGIAS PARA LA CONSTRUCCIÓN Y LA MADERA',
            'direccion' => 'Cra 18 A No. 2 - 18 Sur San Antonio',
        ]);

        Entidad::create([
            'id'        => 12,
            'ciudad_id' => 525,
            'nombre'    => 'CENTRO DE ELECTRICIDAD, ELECTRÓNICA Y TELECOMUNICACIONES',
            'direccion' => 'Avenida 30 No 17 B Sur',
        ]);

        Entidad::create([
            'id'        => 13,
            'ciudad_id' => 525,
            'nombre'    => 'CENTRO DE MANUFACTURA EN TEXTILES Y CUERO',
            'direccion' => 'Avenida 30 No 17 B Sur',
        ]);

        Entidad::create([
            'id'        => 14,
            'ciudad_id' => 525,
            'nombre'    => 'CENTRO METALMECÁNICO',
            'direccion' => 'Avenida 30 No 17 B Sur',
        ]);

        Entidad::create([
            'id'        => 15,
            'ciudad_id' => 525,
            'nombre'    => 'CENTRO DE MATERIALES Y ENSAYOS',
            'direccion' => 'Avenida 30 No 17 B Sur',
        ]);

        Entidad::create([
            'id'        => 16,
            'ciudad_id' => 525,
            'nombre'    => 'CENTRO DE GESTIÓN INDUSTRIAL',
            'direccion' => 'Carrera 31 No. 14 - 20',
        ]);

        Entidad::create([
            'id'        => 17,
            'ciudad_id' => 525,
            'nombre'    => 'CENTRO DE DISEÑO Y METROLOGIA ',
            'direccion' => 'Carrera 31 No. 14 - 20',
        ]);

        Entidad::create([
            'id'        => 18,
            'ciudad_id' => 525,
            'nombre'    => 'CENTRO PARA LA INDUSTRIA DE LA COMUNICACIÓN GRÁFICA',
            'direccion' => 'Carrera 31 No. 14 - 20',
        ]);

        Entidad::create([
            'id'        => 19,
            'ciudad_id' => 525,
            'nombre'    => 'CENTRO NACIONAL DE HOTELERIA, TURISMO Y ALIMENTOS',
            'direccion' => 'Carrera 31 No. 14 - 20',
        ]);

        Entidad::create([
            'id'        => 20,
            'ciudad_id' => 525,
            'nombre'    => 'CENTRO DE FORMACIÓN DE TALENTO HUMANO EN SALUD',
            'direccion' => 'Carrera 6 No. 45 - 52',
        ]);

        Entidad::create([
            'id'        => 21,
            'ciudad_id' => 525,
            'nombre'    => 'CENTRO DE GESTIÓN ADMINISTRATIVA',
            'direccion' => 'Avenida Caracas No. 13 - 88',
        ]);

        Entidad::create([
            'id'        => 22,
            'ciudad_id' => 525,
            'nombre'    => 'CENTRO DE GESTIÓN Y FORTALECIMIENTO SOCIO EMPRESARIAL',
            'direccion' => 'Transeversal 78J No. 41D - 15 Sur',
        ]);

        Entidad::create([
            'id'        => 23,
            'ciudad_id' => 525,
            'nombre'    => 'CENTRO DE GESTIÓN DE MERCADOS, LOGÍSITICA Y TECNOLOGIAS DE LA INFORMACIÓN',
            'direccion' => 'Calle 52 No. 11 - 65',
        ]);

        Entidad::create([
            'id'        => 24,
            'ciudad_id' => 902,
            'nombre'    => 'CENTRO DE SERVICIOS EMPRESARIALES Y TURÍSTICOS',
            'direccion' => 'Carrera 27 No. 15-07 Barrio San Alonso- Bucaramanga',
        ]);

        Entidad::create([
            'id'        => 25,
            'ciudad_id' => 1059,
            'nombre'    => 'CENTRO NÁUTICO PESQUERO DE BUENAVENTURA',
            'direccion' => 'Avenida Simón Bolivar Km 5',
        ]);

        Entidad::create([
            'id'        => 26,
            'ciudad_id' => 1060,
            'nombre'    => 'CENTRO AGROPECUARIO DE BUGA',
            'direccion' => 'Carretera central , variante Buga - Tulua',
        ]);

        Entidad::create([
            'id'        => 27,
            'ciudad_id' => 26,
            'nombre'    => 'CENTRO DE LOS RECURSOS NATURALES RENOVABLES - LA SALADA',
            'direccion' => 'Km.6 Vía Caldas La Pintada',
        ]);

        Entidad::create([
            'id'        => 28,
            'ciudad_id' => 1064,
            'nombre'    => 'CENTRO DE ELECTRICIDAD Y AUTOMATIZACIÓN INDUSTRIAL - CEAI',
            'direccion' => 'CL 52 2BIS-15',
        ]);

        Entidad::create([
            'id'        => 29,
            'ciudad_id' => 1064,
            'nombre'    => 'CENTRO DE DISEÑO TECNOLÓGICO INDUSTRIAL',
            'direccion' => 'CL 52 2BIS-15',
        ]);

        Entidad::create([
            'id'        => 30,
            'ciudad_id' => 1064,
            'nombre'    => 'CENTRO NACIONAL DE ASISTENCIA TÉCNICA A LA INDUSTRIA - ASTIN',
            'direccion' => 'CL 52 2BIS-15',
        ]);

        Entidad::create([
            'id'        => 31,
            'ciudad_id' => 1064,
            'nombre'    => 'CENTRO DE GESTIÓN TECNOLÓGICA DE SERVICIOS',
            'direccion' => 'CL 52 2BIS-15',
        ]);

        Entidad::create([
            'id'        => 32,
            'ciudad_id' => 1064,
            'nombre'    => 'CENTRO DE LA CONSTRUCCIÓN',
            'direccion' => 'Cl 34 17B-23',
        ]);

        Entidad::create([
            'id'        => 33,
            'ciudad_id' => 645,
            'nombre'    => 'CENTRO DE FORMACIÓN AGROINDUSTRIAL',
            'direccion' => 'kmt 8 via al sur',
        ]);

        Entidad::create([
            'id'        => 34,
            'ciudad_id' => 200,
            'nombre'    => 'CENTRO AGROEMPRESARIAL Y MINERO',
            'direccion' => 'Ternera, via a Turbaco Km 1',
        ]);

        Entidad::create([
            'id'        => 35,
            'ciudad_id' => 200,
            'nombre'    => 'CENTRO DE COMERCIO Y SERVICIOS',
            'direccion' => 'Ternera, via a Turbaco Km 1',
        ]);

        Entidad::create([
            'id'        => 36,
            'ciudad_id' => 166,
            'nombre'    => 'CENTRO  NAUTICO INTERNACIONAL, FLUVIAL Y PORTUARIO',
            'direccion' => 'Mamonal Km 5',
        ]);

        Entidad::create([
            'id'        => 37,
            'ciudad_id' => 166,
            'nombre'    => 'CENTRO PARA LA INDUSTRIA PETROQUÍMICA',
            'direccion' => 'Av. Pedro de Heredia, sector tesca.',
        ]);

        Entidad::create([
            'id'        => 38,
            'ciudad_id' => 1066,
            'nombre'    => 'CENTRO DE TECNOLOGÍAS AGROINDUSTRIALES',
            'direccion' => 'Cr 9 12-141',
        ]);

        Entidad::create([
            'id'        => 39,
            'ciudad_id' => 33,
            'nombre'    => 'COMPLEJO TECNOLÓGICO PARA LA GESTIÓN AGROEMPRESARIAL',
            'direccion' => 'Calle 31 Carrera 16 Diagonal al Hospital CUP',
        ]);

        Entidad::create([
            'id'        => 40,
            'ciudad_id' => 536,
            'nombre'    => 'CENTRO DE DESARROLLO AGROEMPRESARIAL',
            'direccion' => 'CARRERA 9 No 11-34',
        ]);

        Entidad::create([
            'id'        => 41,
            'ciudad_id' => 823,
            'nombre'    => 'CENTRO ATENCIÓN SECTOR AGROPECUARIO',
            'direccion' => 'Calle 2N AV 4 Y 5 Barrio Pescadero',
        ]);

        Entidad::create([
            'id'        => 42,
            'ciudad_id' => 823,
            'nombre'    => 'CENTRO DE LA INDUSTRIA, LA EMPRESA Y LOS SERVICIOS',
            'direccion' => 'Calle 2N AV 4 Y 5 Barrio Pescadero',
        ]);

        Entidad::create([
            'id'        => 43,
            'ciudad_id' => 882,
            'nombre'    => 'CENTRO DE DISEÑO E INNOVACIÓN TECNOLÓGICA INDUSTRIAL',
            'direccion' => 'transv 7 calle 26 Barrio Santa Isabel Dosquebradas',
        ]);

        Entidad::create([
            'id'        => 44,
            'ciudad_id' => 236,
            'nombre'    => 'CENTRO DE DESARROLLO AGROPECUARIO Y AGROINDUSTRIAL',
            'direccion' => 'KM 1 Via Duitama - Pantano de Vargas',
        ]);

        Entidad::create([
            'id'        => 45,
            'ciudad_id' => 1021,
            'nombre'    => 'CENTRO AGROPECUARIO LA GRANJA',
            'direccion' => 'KILOMETRO 4 VIA PANAMERICANA ESPINAL IBAGUE',
        ]);

        Entidad::create([
            'id'        => 46,
            'ciudad_id' => 360,
            'nombre'    => 'CENTRO TECNOLÓGICO DE LA AMAZONÍA',
            'direccion' => 'Kilómetro 3 Vía Aeropuerto',
        ]);

        Entidad::create([
            'id'        => 47,
            'ciudad_id' => 925,
            'nombre'    => 'CENTRO INDUSTRIAL DEL DISEÑO Y LA MANUFACTURA',
            'direccion' => 'Autopista Floridablanca No. 50-33',
        ]);

        Entidad::create([
            'id'        => 48,
            'ciudad_id' => 681,
            'nombre'    => 'CENTRO AGROEMPRESARIAL Y ACUÍCOLA',
            'direccion' => 'Kilómetro 1 Salida a Barrancas',
        ]);

        Entidad::create([
            'id'        => 49,
            'ciudad_id' => 547,
            'nombre'    => 'CENTRO AGROECOLÓGICO Y EMPRESARIAL',
            'direccion' => 'AVENIDA MANUEL H CARDENAS CALLE 16',
        ]);

        Entidad::create([
            'id'        => 50,
            'ciudad_id' => 716,
            'nombre'    => 'CENTRO ACUÍCOLA Y AGROINDUSTRIAL DE GAIRA',
            'direccion' => 'Kilometro 6 Via gaira',
        ]);

        Entidad::create([
            'id'        => 51,
            'ciudad_id' => 648,
            'nombre'    => 'CENTRO AGROEMPRESARIAL Y DESARROLLO PECUARIO DEL HUILA',
            'direccion' => 'carrera 10 No 11-22',
        ]);

        Entidad::create([
            'id'        => 52,
            'ciudad_id' => 554,
            'nombre'    => 'CENTRO DE LA TECNOLOGÍA DEL DISEÑO Y LA PRODUCTIVIDAD EMPRESARIAL',
            'direccion' => 'CARRERA 10 No 30-04',
        ]);

        Entidad::create([
            'id'        => 53,
            'ciudad_id' => 928,
            'nombre'    => 'CENTRO INDUSTRIAL DE MANTENIMIENTO INTEGRAL',
            'direccion' => 'Via Palenque- Rincón de Girón-Zona Industrial  de Girón',
        ]);

        Entidad::create([
            'id'        => 54,
            'ciudad_id' => 1028,
            'nombre'    => 'CENTRO DE INDUSTRIA Y CONSTRUCCIÓN',
            'direccion' => 'Cra. 4 Estadio Calle 44 Avenida Ferrocarril',
        ]);

        Entidad::create([
            'id'        => 55,
            'ciudad_id' => 1028,
            'nombre'    => 'CENTRO DE COMERCIO Y SERVICIOS',
            'direccion' => 'Cra. 4 Estadio Calle 44 Avenida Ferrocarril',
        ]);

        Entidad::create([
            'id'        => 56,
            'ciudad_id' => 778,
            'nombre'    => 'CENTRO SUR COLOMBIANO DE LOGÍSTICA INTERNACIONAL',
            'direccion' => 'CRA. 7 No.24A-48',
        ]);

        Entidad::create([
            'id'        => 57,
            'ciudad_id' => 59,
            'nombre'    => 'CENTRO DEL DISEÑO Y MANUFACTURA DE CUERO',
            'direccion' => 'Calle 63  58B - 03',
        ]);

        Entidad::create([
            'id'        => 58,
            'ciudad_id' => 59,
            'nombre'    => 'CENTRO DE FORMACIÓN EN DISEÑO, CONFECCION Y MODA',
            'direccion' => 'Calle 63  58B - 03',
        ]);

        Entidad::create([
            'id'        => 59,
            'ciudad_id' => 59,
            'nombre'    => 'CENTRO TECNOLÓGICO DEL MOBILIARIO',
            'direccion' => 'Calle 63  58B - 03',
        ]);

        Entidad::create([
            'id'        => 60,
            'ciudad_id' => 500,
            'nombre'    => 'CENTRO AGROPECUARIO Y DE BIOTECNOLOGÍA EL PORVENIR',
            'direccion' => 'Via Santa Isabel Km. 7',
        ]);

        Entidad::create([
            'id'        => 61,
            'ciudad_id' => 333,
            'nombre'    => 'CENTRO PECUARIO Y AGROEMPRESARIAL',
            'direccion' => 'Calle 41 Carrera 1a. Barrio Alfonso López',
        ]);

        Entidad::create([
            'id'        => 62,
            'ciudad_id' => 654,
            'nombre'    => 'CENTRO DE DESARROLLO AGROEMPRESARIAL Y TURÍSTICO DEL HUILA',
            'direccion' => 'Calle 6 Carrera 7 (Esquina)',
        ]);

        Entidad::create([
            'id'        => 63,
            'ciudad_id' => 1,
            'nombre'    => 'CENTRO PARA LA BIODIVERSIDAD Y EL TURISMO DEL AMAZONAS',
            'direccion' => 'Calle 12 No 10 - 60 ',
        ]);

        Entidad::create([
            'id'        => 64,
            'ciudad_id' => 947,
            'nombre'    => 'CENTRO AGROEMPRESARIAL Y TURÍSITICO DE LOS ANDES',
            'direccion' => 'Carrera 11 No. 13-13 Barrio Ricaurte- Malaga',
        ]);

        Entidad::create([
            'id'        => 65,
            'ciudad_id' => 336,
            'nombre'    => 'CENTRO PARA LA FORMACIÓN CAFETERA',
            'direccion' => 'Km. 10 Vía al Magdalena',
        ]);

        Entidad::create([
            'id'        => 66,
            'ciudad_id' => 336,
            'nombre'    => 'CENTRO DE AUTOMATIZACIÓN INDUSTRIAL',
            'direccion' => 'Km. 10 Vía al Magdalena',
        ]);

        Entidad::create([
            'id'        => 67,
            'ciudad_id' => 336,
            'nombre'    => 'CENTRO DE PROCESOS INDUSTRIALES',
            'direccion' => 'Km. 10 Vía al Magdalena',
        ]);

        Entidad::create([
            'id'        => 68,
            'ciudad_id' => 336,
            'nombre'    => 'CENTRO DE COMERCIO Y SERVICIOS',
            'direccion' => 'Km. 10 Vía al Magdalena',
        ]);

        Entidad::create([
            'id'        => 69,
            'ciudad_id' => 70,
            'nombre'    => 'CENTRO DE COMERCIO',
            'direccion' => 'Calle 51 No 57-70 ',
        ]);

        Entidad::create([
            'id'        => 70,
            'ciudad_id' => 70,
            'nombre'    => 'CENTRO DE SERVICIOS DE SALUD',
            'direccion' => 'Calle 51 No 57-70 Piso 2 ',
        ]);

        Entidad::create([
            'id'        => 71,
            'ciudad_id' => 70,
            'nombre'    => 'CENTRO DE SERVICIOS Y GESTIÓN EMPRESARIAL ',
            'direccion' => 'Calle 57 No. 51-75',
        ]);

        Entidad::create([
            'id'        => 72,
            'ciudad_id' => 70,
            'nombre'    => 'CENTRO PARA EL DESARROLLO DEL HABITAT Y LA CONSTRUCCIÓN',
            'direccion' => 'Calle 104 69-120 Barrio el Pedregal',
        ]);

        Entidad::create([
            'id'        => 73,
            'ciudad_id' => 70,
            'nombre'    => 'CENTRO DE TECNOLOGÍA DE LA MANUFACTURA AVANZADA',
            'direccion' => 'Diagonal 104 No 69-120 B/Pedregal ',
        ]);

        Entidad::create([
            'id'        => 74,
            'ciudad_id' => 70,
            'nombre'    => 'TECNOLÓGICO DE GESTIÓN INDUSTRIAL',
            'direccion' => 'Calle 104 69-120 Barrio el Pedregal',
        ]);

        Entidad::create([
            'id'        => 75,
            'ciudad_id' => 1097,
            'nombre'    => 'CENTRO AGROPECUARIO Y DE SERVICIOS AMBIENTALES JIRI-JIRIMO',
            'direccion' => 'Avenida 15 No 6 - 176',
        ]);

        Entidad::create([
            'id'        => 76,
            'ciudad_id' => 500,
            'nombre'    => 'CENTRO DE COMERCIO, INDUSTRIA Y TURISMO DE CÓRDOBA',
            'direccion' => 'Av. Circunvalar Cls. 24 y 27',
        ]);

        Entidad::create([
            'id'        => 77,
            'ciudad_id' => 298,
            'nombre'    => 'CENTRO MINERO',
            'direccion' => 'Vereda Morcá Sogamoso',
        ]);

        Entidad::create([
            'id'        => 78,
            'ciudad_id' => 576,
            'nombre'    => 'CENTRO DE BIOTECNOLOGÍA AGROPECUARIA',
            'direccion' => 'KM 7 VIA MOSQUERA',
        ]);

        Entidad::create([
            'id'        => 79,
            'ciudad_id' => 655,
            'nombre'    => 'CENTRO DE LA INDUSTRIA, LA EMPRESA Y LOS SERVICIOS',
            'direccion' => 'Carrera 5 Av la toma',
        ]);

        Entidad::create([
            'id'        => 80,
            'ciudad_id' => 24,
            'nombre'    => 'CENTRO DE BIOTECNOLOGÍA INDUSTRIAL',
            'direccion' => 'Cr 30 40-25',
        ]);

        Entidad::create([
            'id'        => 81,
            'ciudad_id' => 801,
            'nombre'    => 'CENTRO INTERNACIONAL DE PRODUCCION LIMPIA - LOPE',
            'direccion' => 'CALLE 22 11 ESTE 05-VIA A ORIENTE',
        ]);

        Entidad::create([
            'id'        => 82,
            'ciudad_id' => 888,
            'nombre'    => 'CENTRO ATENCIÓN SECTOR AGROPECUARIO',
            'direccion' => 'Cra 8a. No. 26-69',
        ]);

        Entidad::create([
            'id'        => 83,
            'ciudad_id' => 888,
            'nombre'    => 'CENTRO DE COMERCIO Y SERVICIOS',
            'direccion' => 'Cra 8a. No. 26-69',
        ]);

        Entidad::create([
            'id'        => 84,
            'ciudad_id' => 953,
            'nombre'    => 'CENTRO ATENCIÓN SECTOR AGROPECUARIO',
            'direccion' => 'km. 2 via Palogordo- Vereda Gutiguara Piedecuesta',
        ]);

        Entidad::create([
            'id'        => 85,
            'ciudad_id' => 662,
            'nombre'    => 'CENTRO DE GESTIÓN Y DESARROLLO SOSTENIBLE SURCOLOMBIANO',
            'direccion' => 'Carrera 8 No 7 - 53',
        ]);

        Entidad::create([
            'id'        => 86,
            'ciudad_id' => 414,
            'nombre'    => 'CENTRO AGROPECUARIO',
            'direccion' => 'Carrera 9 #69-00 Avenida Panamericana',
        ]);

        Entidad::create([
            'id'        => 87,
            'ciudad_id' => 414,
            'nombre'    => 'CENTRO DE TELEINFORMÁTICA Y PRODUCCIÓN INDUSTRIAL',
            'direccion' => 'Carrera 9 #69-00 Avenida Panamericana',
        ]);

        Entidad::create([
            'id'        => 88,
            'ciudad_id' => 414,
            'nombre'    => 'CENTRO DE COMERCIO Y SERVICIOS',
            'direccion' => 'Calle 4 #2-67',
        ]);

        Entidad::create([
            'id'        => 89,
            'ciudad_id' => 857,
            'nombre'    => 'CENTRO AGROFORESTAL Y ACUÍCOLA ARAPAIMA',
            'direccion' => 'Cra.23 # 16a-06 B/20 de Julio Puerto Asís Putumayo',
        ]);

        Entidad::create([
            'id'        => 90,
            'ciudad_id' => 81,
            'nombre'    => 'COMPLEJO TECNOLÓGICO MINERO AGROEMPRESARIAL',
            'direccion' => 'Calle 43  20-137',
        ]);

        Entidad::create([
            'id'        => 91,
            'ciudad_id' => 1101,
            'nombre'    => 'CENTRO DE PRODUCCIÓN Y TRANSFORMACIÓN AGROINDUSTRIAL DE LA ORINOQUÍA',
            'direccion' => '(Sede Nueva) Carrera 10 No 15 - 131 Barrio Tamarido',
        ]);

        Entidad::create([
            'id'        => 92,
            'ciudad_id' => 634,
            'nombre'    => 'CENTRO AMBIENTAL Y ECOTURÍSTICO DEL NORORIENTE AMAZÓNICO',
            'direccion' => 'Transversal 6 Nº 29a-55, via al Coco',
        ]);

        Entidad::create([
            'id'        => 93,
            'ciudad_id' => 740,
            'nombre'    => 'CENTRO AGROINDUSTRIAL DEL META',
            'direccion' => 'Km. 17  Vía  Pueto. López',
        ]);

        Entidad::create([
            'id'        => 94,
            'ciudad_id' => 477,
            'nombre'    => 'CENTRO DE RECURSOS NATURALES, INDUSTRIA Y BIODIVERSIDAD',
            'direccion' => 'CRA. 1 No28 - 71',
        ]);

        Entidad::create([
            'id'        => 95,
            'ciudad_id' => 686,
            'nombre'    => 'CENTRO INDUSTRIAL Y DE ENERGÍAS ALTERNATIVAS',
            'direccion' => 'Avenida aeropuerto calle 21',
        ]);

        Entidad::create([
            'id'        => 96,
            'ciudad_id' => 86,
            'nombre'    => 'CENTRO DE LA INNOVACIÓN, LA AGROINDUSTRIA Y EL TURISMO',
            'direccion' => 'Carrera 48  No. 49-62',
        ]);

        Entidad::create([
            'id'        => 97,
            'ciudad_id' => 961,
            'nombre'    => 'CENTRO DE FORMACION TURISTICA, GENTE DE MAR Y DE SERVICIOS ',
            'direccion' => 'Avenida Franciscon Newball',
        ]);

        Entidad::create([
            'id'        => 98,
            'ciudad_id' => 963,
            'nombre'    => 'CENTRO AGROTURÍSTICO',
            'direccion' => 'calle 22 No. 9 -82 San Gil',
        ]);

        Entidad::create([
            'id'        => 99,
            'ciudad_id' => 638,
            'nombre'    => 'CENTRO DE DESARROLLO AGROINDUSTRIAL, TURÍSTICO Y TECNOLÓGICO DEL GUAVIARE',
            'direccion' => 'Carrera 24 # 7 - 10 Centro',
        ]);

        Entidad::create([
            'id'        => 100,
            'ciudad_id' => 716,
            'nombre'    => 'CENTRO DE LOGÍSTICA Y PROMOCIÓN ECOTURÍSTICA DEL MAGDALENA',
            'direccion' => 'Avenida del ferrocarril # 27-97 Santa Marta',
        ]);

        Entidad::create([
            'id'        => 101,
            'ciudad_id' => 1002,
            'nombre'    => 'CENTRO DE LA INNOVACIÓN, LA TECNOLOGÍA Y LOS SERVICIOS',
            'direccion' => 'Calle 25 b Nro. 31-260',
        ]);

        Entidad::create([
            'id'        => 102,
            'ciudad_id' => 603,
            'nombre'    => 'CENTRO DE TECNOLOGÍAS PARA LA CONSTRUCCIÓN Y LA MADERA',
            'direccion' => 'Calle 8 No. 6 -54 entrada 3 zona industrial Cazuca',
        ]);

        Entidad::create([
            'id'        => 103,
            'ciudad_id' => 603,
            'nombre'    => 'CENTRO DE TECNOLOGÍAS DEL TRANSPORTE',
            'direccion' => 'Calle 8 No. 6 -54 entrada 3 zona industrial Cazuca',
        ]);

        Entidad::create([
            'id'        => 104,
            'ciudad_id' => 603,
            'nombre'    => 'CENTRO INDUSTRIAL Y DESARROLLO EMPRESARIAL DE SOACHA',
            'direccion' => 'Calle 8 No. 6 -54 entrada 3 zona industrial Cazuca',
        ]);

        Entidad::create([
            'id'        => 105,
            'ciudad_id' => 603,
            'nombre'    => 'CENTRO INDUSTRIAL Y DESARROLLO EMPRESARIAL DE SOACHA',
            'direccion' => 'CARRERA 7 No 14-41 CENTRO CASA CULTURA',
        ]);

        Entidad::create([
            'id'        => 106,
            'ciudad_id' => 603,
            'nombre'    => 'CENTRO NACIONAL DE HOTELERÍA, TURISMO Y ALIMENTOS',
            'direccion' => 'Calle 8 No. 6 -54 entrada 3 zona industrial Cazuca',
        ]);

        Entidad::create([
            'id'        => 107,
            'ciudad_id' => 298,
            'nombre'    => 'CENTRO INDUSTRIAL DE MANTENIMIENTO Y MANUFACTURA',
            'direccion' => 'Carrera 12 No 55 A-51',
        ]);

        Entidad::create([
            'id'        => 108,
            'ciudad_id' => 1089,
            'nombre'    => 'CENTRO LATINOAMERICANO DE  ESERVICIO PUBLICO DE EMPLEOCIES MENORES',
            'direccion' => 'Carretera Central Tulua - Buga - Km 2',
        ]);

        Entidad::create([
            'id'        => 109,
            'ciudad_id' => 811,
            'nombre'    => 'CENTRO AGROINDUSTRIAL Y PESQUERO DE LA COSTA PACÍFICA',
            'direccion' => 'Calle del Comercio y Edificio Madrigal ',
        ]);

        Entidad::create([
            'id'        => 110,
            'ciudad_id' => 317,
            'nombre'    => 'CENTRO DE GESTIÓN ADMINISTRATIVA Y FORTALECIMIENTO EMPRESARIAL',
            'direccion' => 'Calle 19 No 12 - 29',
        ]);

        Entidad::create([
            'id'        => 111,
            'ciudad_id' => 455,
            'nombre'    => 'CENTRO DE OPERACIÓN Y MANTENIMIENTO MINERO',
            'direccion' => 'carrera 19 entre calle 14 y 15 ',
        ]);

        Entidad::create([
            'id'        => 112,
            'ciudad_id' => 455,
            'nombre'    => 'CENTRO BIOTECNOLÓGICO DEL CARIBE',
            'direccion' => 'Kilometro 7 Via a la Paz ',
        ]);

        Entidad::create([
            'id'        => 113,
            'ciudad_id' => 979,
            'nombre'    => 'CENTRO DE GESTIÓN AGROEMPRESARIAL DEL ORIENTE',
            'direccion' => 'Calle 8 No. 2 este par avenida las cuadras antiguo Idema- Velez',
        ]);

        Entidad::create([
            'id'        => 114,
            'ciudad_id' => 867,
            'nombre'    => 'CENTRO AGROINDUSTRIAL',
            'direccion' => 'Carrera 6 # 42 Norte-02 Avenida centenario',
        ]);

        Entidad::create([
            'id'        => 115,
            'ciudad_id' => 867,
            'nombre'    => 'CENTRO PARA EL DESARROLLO TECNOLÓGICO DE LA CONSTRUCCIÓN',
            'direccion' => 'Carrera 6 # 42 Norte-02 Avenida centenario',
        ]);

        Entidad::create([
            'id'        => 116,
            'ciudad_id' => 748,
            'nombre'    => 'CENTRO DE INDUSTRIA Y SERVICIOS DEL META',
            'direccion' => 'KM  1 VIA ACACIAS',
        ]);

        Entidad::create([
            'id'        => 117,
            'ciudad_id' => 628,
            'nombre'    => 'CENTRO DE DESARROLLO AGROINDUSTRIAL Y EMPRESARIAL',
            'direccion' => 'Calle 2 No.13-03 Barrio San Rafael ',
        ]);

        Entidad::create([
            'id'        => 118,
            'ciudad_id' => 388,
            'nombre'    => 'CENTRO AGROINDUSTRIAL Y FORTALECIMIENTO EMPRESARIAL DE CASANARE',
            'direccion' => 'Cra. 19 No.36-68',
        ]);

    }

}
