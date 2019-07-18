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

    /**
    * Entidad No Aplica
    */
    Entidad::create([
      'id' => 1,
      'ciudad_id' => 431,
      'nombre'    => 'No Aplica',
    ]);


    /**
    * Nodos de Tecnoparque
    */
    Entidad::create([
      'id' => 2,
      'ciudad_id' => 70,
      'nombre'    => 'Medellin',
    ]);

    Entidad::create([
      'id' => 3,
      'ciudad_id' => 86,
      'nombre'    => 'Rionegro',
    ]);

    Entidad::create([
      'id' => 4,
      'ciudad_id' => 1064,
      'nombre'    => 'Calí',
    ]);

    Entidad::create([
      'id' => 5,
      'ciudad_id' => 525,
      'nombre'    => 'DC',
      ]);

      Entidad::create([
      'id' => 6,
      'ciudad_id' => 603,
      'nombre'    => 'Cazuca',
      ]);

      Entidad::create([
      'id' => 7,
      'ciudad_id' => 888,
      'nombre'    => 'Pereira',
      ]);

      Entidad::create([
      'id' => 8,
      'ciudad_id' => 655,
      'nombre'    => 'Neiva',
      ]);

      Entidad::create([
      'id' => 9,
      'ciudad_id' => 902,
      'nombre'    => 'Bucaramanga',
      ]);

      Entidad::create([
      'id' => 10,
      'ciudad_id' => 336,
      'nombre'    => 'Manizales',
      ]);

      Entidad::create([
      'id' => 11,
      'ciudad_id' => 1021,
      'nombre'    => 'Granja',
      ]);

      Entidad::create([
      'id' => 12,
      'ciudad_id' => 662,
      'nombre'    => 'Pitalito',
      ]);

      Entidad::create([
      'id' => 13,
      'ciudad_id' => 455,
      'nombre'    => 'Valledupar',
      ]);

      Entidad::create([
      'id' => 14,
      'ciudad_id' => 837,
      'nombre'    => 'Ocaña',
      ]);

      Entidad::create([
      'id' => 15,
      'ciudad_id' => 10,
      'nombre'    => 'Angostura',
      ]);

      Entidad::create([
      'id' => 16,
      'ciudad_id' => 971,
      'nombre'    => 'Socorro',
      ]);
      /**
      * Fin de nodos tecnoparque
      */


      /**
      * Inicio de los Centros de Formación
      */
      Entidad::create([
      'ciudad_id' => 1,
      'nombre'    => 'Centro para la Biodiversidad y el Turismo del Amazonas',
      ]);

      Entidad::create([
      'ciudad_id' => 26,
      'nombre'    => 'Centro de los Recursos Naturales Renovables - La Salada',
      ]);

      Entidad::create([
      'ciudad_id' => 45,
      'nombre'    => 'Centro de Formación Minero Ambiental',
      ]);

      Entidad::create([
      'ciudad_id' => 45,
      'nombre'    => 'Centro de Formación Minero Ambiental',
      ]);

      Entidad::create([
      'ciudad_id' => 59,
      'nombre'    => 'Centro del Diseño y Manufactura del Cuero',
      ]);

      Entidad::create([
      'ciudad_id' => 59,
      'nombre'    => 'Centro de Formación en Diseño, Confección y Moda',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'Centro para el Desarrollo del Hábitat y la Construcción',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'Centro de Tecnología de la Manufactura Avanzada',
      ]);

      Entidad::create([
      'ciudad_id' => 59,
      'nombre'    => 'Centro Tecnológico del Mobiliario',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'Centro de Comercio',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'Centro de Servicios de Salud',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'Centro de Servicios y Gestión Empresarial',
      ]);

      Entidad::create([
      'ciudad_id' => 33,
      'nombre'    => 'Complejo Tecnológico para la Gestión Agroempresarial',
      ]);

      Entidad::create([
      'ciudad_id' => 81,
      'nombre'    => 'Complejo Tecnológico Minero Agroempresarial',
      ]);

      Entidad::create([
      'ciudad_id' => 86,
      'nombre'    => 'Centro de la Innovación, la Agroindustria y la Aviación',
      ]);

      Entidad::create([
      'ciudad_id' => 13,
      'nombre'    => 'Complejo Tecnológico Agroindustrial, Pecuario y Turístico',
      ]);

      Entidad::create([
      'ciudad_id' => 103,
      'nombre'    => 'Complejo Tecnológico, Turístico y Agroindustrial del Occidente Antioqueño',
      ]);

      Entidad::create([
      'ciudad_id' => 128,
      'nombre'    => 'Centro de Gestión y Desarrollo Agroindustrial de Arauca',
      ]);

      Entidad::create([
      'ciudad_id' => 151,
      'nombre'    => 'Centro para el Desarrollo Agroecológico y Agroindustrial',
      ]);

      Entidad::create([
      'ciudad_id' => 142,
      'nombre'    => 'Centro Nacional Colombo Alemán',
      ]);

      Entidad::create([
      'ciudad_id' => 136,
      'nombre'    => 'Centro Industrial y de Aviación',
      ]);

      Entidad::create([
      'ciudad_id' => 136,
      'nombre'    => 'Centro de Comercio y Servicios',
      ]);

      /**
      * Centros de Bolivar
      */
      Entidad::create([
      'ciudad_id' => 166,
      'nombre'    => 'Centro Agroempresarial y Minero',
      ]);

      Entidad::create([
      'ciudad_id' => 166,
      'nombre'    => 'Centro Internacional Náutico, Fluvial y Portuario',
      ]);

      Entidad::create([
      'ciudad_id' => 166,
      'nombre'    => 'Centro para la Industria Petroquímica',
      ]);

      Entidad::create([
      'ciudad_id' => 166,
      'nombre'    => 'Centro de Comercio y Servicios',
      ]);

      /**
      * Centros de Boyacá
      */
      Entidad::create([
      'ciudad_id' => 234,
      'nombre'    => 'Centro de Desarrollo Agropecuario y Agroindustrial',
      ]);

      Entidad::create([
      'ciudad_id' => 298,
      'nombre'    => 'Centro  Minero',
      ]);

      Entidad::create([
      'ciudad_id' => 258,
      'nombre'    => 'Centro de Gestión Administrativa y Fortalecimiento Empresarial',
      ]);

      Entidad::create([
      'ciudad_id' => 234,
      'nombre'    => 'Centro Industrial de Mantenimiento y Manufactura',
      ]);

      /**
      * Centros de Caldas
      */
      Entidad::create([
      'ciudad_id' => 336,
      'nombre'    => 'Centro para la Formación Cafetera',
      ]);

      Entidad::create([
      'ciudad_id' => 336,
      'nombre'    => 'Centro de Automatización Industrial',
      ]);

      Entidad::create([
      'ciudad_id' => 336,
      'nombre'    => 'Centro de Procesos Industriales',
      ]);

      Entidad::create([
      'ciudad_id' => 336,
      'nombre'    => 'Centro de Comercio y Servicios',
      ]);

      Entidad::create([
      'ciudad_id' => 333,
      'nombre'    => 'Centro Pecuario y Agroempresarial',
      ]);

      /**
       * Centros de Caquetá
       */
      Entidad::create([
      'ciudad_id' => 360,
      'nombre'    => 'Centro Tecnológico de la Amazonía',
      ]);

      /**
       * Centros del Casanare
       */
      Entidad::create([
      'ciudad_id' => 388,
      'nombre'    => 'Centro Agroindustrial y Fortalecimiento Empresarial de Casanare',
      ]);

      /**
       * Centros del cauca
       */
       Entidad::create([
         'ciudad_id' => 414,
         'nombre'    => 'Centro Agropecuario',
       ]);

       Entidad::create([
         'ciudad_id' => 414,
         'nombre'    => 'Centro de Teleinformática y Producción Industrial',
       ]);

      // Entidad::create([
      // 'ciudad_id' => 13,
      // 'nombre'    => 'COMPLEJO TECNOLÓGICO AGROINDUSTRIAL, PECUARIO Y TURÍSTICO ',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 128,
      // 'nombre'    => 'CENTRO DE GESTIÓN Y DESARROLLO AGROINDUSTRIAL DE ARAUCA',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 867,
      // 'nombre'    => 'CENTRO DE COMERCIO, INDUSTRIA Y TURISMO',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 899,
      // 'nombre'    => 'CENTRO INDUSTRIAL Y DEL DESARROLLO TECNOLÓGICO',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 136,
      // 'nombre'    => 'CENTRO PARA EL DESARROLLO AGROECOLÓGICO Y AGROINDUSTRIAL',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 136,
      // 'nombre'    => 'CENTRO DE COMERCIO Y SERVICIOS',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 136,
      // 'nombre'    => 'CENTRO NACIONAL COLOMBO ALEMAN',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 136,
      // 'nombre'    => 'CENTRO INDUSTRIAL Y DE AVIACIÓN',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 525,
      // 'nombre'    => 'CENTRO DE SERVICIOS FINANCIEROS',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 525,
      // 'nombre'    => 'CENTRO DE TECNOLOGIAS PARA LA CONSTRUCCIÓN Y LA MADERA',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 525,
      // 'nombre'    => 'CENTRO DE ELECTRICIDAD, ELECTRÓNICA Y TELECOMUNICACIONES',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 525,
      // 'nombre'    => 'CENTRO DE MANUFACTURA EN TEXTILES Y CUERO',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 525,
      // 'nombre'    => 'CENTRO METALMECÁNICO',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 525,
      // 'nombre'    => 'CENTRO DE MATERIALES Y ENSAYOS',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 525,
      // 'nombre'    => 'CENTRO DE GESTIÓN INDUSTRIAL',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 525,
      // 'nombre'    => 'CENTRO DE DISEÑO Y METROLOGIA ',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 525,
      // 'nombre'    => 'CENTRO PARA LA INDUSTRIA DE LA COMUNICACIÓN GRÁFICA',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 525,
      // 'nombre'    => 'CENTRO NACIONAL DE HOTELERIA, TURISMO Y ALIMENTOS',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 525,
      // 'nombre'    => 'CENTRO DE DISEÑO TECNOLÓGICO INDUSTRIAL',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 525,
      // 'nombre'    => 'CENTRO DE GESTIÓN ADMINISTRATIVA',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 525,
      // 'nombre'    => 'CENTRO DE GESTIÓN Y FORTALECIMIENTO SOCIO EMPRESARIAL',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 525,
      // 'nombre'    => 'CENTRO DE GESTIÓN DE MERCADOS, LOGÍSITICA Y TECNOLOGIAS DE LA INFORMACIÓN',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 902,
      // 'nombre'    => 'CENTRO DE SERVICIOS EMPRESARIALES Y TURÍSTICOS',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 1059,
      // 'nombre'    => 'CENTRO NÁUTICO PESQUERO DE BUENAVENTURA',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 1060,
      // 'nombre'    => 'CENTRO AGROPECUARIO DE BUGA',
      // ]);
      //

      //
      // Entidad::create([
      // 'ciudad_id' => 1064,
      // 'nombre'    => 'CENTRO DE ELECTRICIDAD Y AUTOMATIZACIÓN INDUSTRIAL - CEAI',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 1064,
      // 'nombre'    => 'CENTRO DE DISEÑO TECNOLÓGICO INDUSTRIAL',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 1064,
      // 'nombre'    => 'CENTRO NACIONAL DE ASISTENCIA TÉCNICA A LA INDUSTRIA - ASTIN',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 1064,
      // 'nombre'    => 'CENTRO DE GESTIÓN TECNOLÓGICA DE SERVICIOS',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 1064,
      // 'nombre'    => 'CENTRO DE LA CONSTRUCCIÓN',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 645,
      // 'nombre'    => 'CENTRO DE FORMACIÓN AGROINDUSTRIAL',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 200,
      // 'nombre'    => 'CENTRO AGROEMPRESARIAL Y MINERO',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 200,
      // 'nombre'    => 'CENTRO DE COMERCIO Y SERVICIOS',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 166,
      // 'nombre'    => 'CENTRO  NAUTICO INTERNACIONAL, FLUVIAL Y PORTUARIO',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 166,
      // 'nombre'    => 'CENTRO PARA LA INDUSTRIA PETROQUÍMICA',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 1066,
      // 'nombre'    => 'CENTRO DE TECNOLOGÍAS AGROINDUSTRIALES',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 33,
      // 'nombre'    => 'COMPLEJO TECNOLÓGICO PARA LA GESTIÓN AGROEMPRESARIAL',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 536,
      // 'nombre'    => 'CENTRO DE DESARROLLO AGROEMPRESARIAL',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 823,
      // 'nombre'    => 'CENTRO ATENCIÓN SECTOR AGROPECUARIO',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 823,
      // 'nombre'    => 'CENTRO DE LA INDUSTRIA, LA EMPRESA Y LOS SERVICIOS',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 882,
      // 'nombre'    => 'CENTRO DE DISEÑO E INNOVACIÓN TECNOLÓGICA INDUSTRIAL',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 236,
      // 'nombre'    => 'CENTRO DE DESARROLLO AGROPECUARIO Y AGROINDUSTRIAL',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 1021,
      // 'nombre'    => 'CENTRO AGROPECUARIO LA GRANJA',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 360,
      // 'nombre'    => 'CENTRO TECNOLÓGICO DE LA AMAZONÍA',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 925,
      // 'nombre'    => 'CENTRO INDUSTRIAL DEL DISEÑO Y LA MANUFACTURA',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 681,
      // 'nombre'    => 'CENTRO AGROEMPRESARIAL Y ACUÍCOLA',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 547,
      // 'nombre'    => 'CENTRO AGROECOLÓGICO Y EMPRESARIAL',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 716,
      // 'nombre'    => 'CENTRO ACUÍCOLA Y AGROINDUSTRIAL DE GAIRA',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 648,
      // 'nombre'    => 'CENTRO AGROEMPRESARIAL Y DESARROLLO PECUARIO DEL HUILA',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 554,
      // 'nombre'    => 'CENTRO DE LA TECNOLOGÍA DEL DISEÑO Y LA PRODUCTIVIDAD EMPRESARIAL',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 928,
      // 'nombre'    => 'CENTRO INDUSTRIAL DE MANTENIMIENTO INTEGRAL',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 1028,
      // 'nombre'    => 'CENTRO DE INDUSTRIA Y CONSTRUCCIÓN',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 1028,
      // 'nombre'    => 'CENTRO DE COMERCIO Y SERVICIOS',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 778,
      // 'nombre'    => 'CENTRO SUR COLOMBIANO DE LOGÍSTICA INTERNACIONAL',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 59,
      // 'nombre'    => 'CENTRO DEL DISEÑO Y MANUFACTURA DE CUERO',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 59,
      // 'nombre'    => 'CENTRO DE FORMACIÓN EN DISEÑO, CONFECCION Y MODA',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 59,
      // 'nombre'    => 'CENTRO TECNOLÓGICO DEL MOBILIARIO',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 500,
      // 'nombre'    => 'CENTRO AGROPECUARIO Y DE BIOTECNOLOGÍA EL PORVENIR',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 333,
      // 'nombre'    => 'CENTRO PECUARIO Y AGROEMPRESARIAL',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 654,
      // 'nombre'    => 'CENTRO DE DESARROLLO AGROEMPRESARIAL Y TURÍSTICO DEL HUILA',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 1,
      // 'nombre'    => 'CENTRO PARA LA BIODIVERSIDAD Y EL TURISMO DEL AMAZONAS',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 947,
      // 'nombre'    => 'CENTRO AGROEMPRESARIAL Y TURÍSITICO DE LOS ANDES',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 336,
      // 'nombre'    => 'CENTRO PARA LA FORMACIÓN CAFETERA',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 336,
      // 'nombre'    => 'CENTRO DE AUTOMATIZACIÓN INDUSTRIAL',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 336,
      // 'nombre'    => 'CENTRO DE PROCESOS INDUSTRIALES',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 336,
      // 'nombre'    => 'CENTRO DE COMERCIO Y SERVICIOS',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 70,
      // 'nombre'    => 'CENTRO DE COMERCIO',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 70,
      // 'nombre'    => 'CENTRO DE SERVICIOS DE SALUD',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 70,
      // 'nombre'    => 'CENTRO DE SERVICIOS Y GESTIÓN EMPRESARIAL ',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 70,
      // 'nombre'    => 'CENTRO PARA EL DESARROLLO DEL HABITAT Y LA CONSTRUCCIÓN',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 70,
      // 'nombre'    => 'CENTRO DE TECNOLOGÍA DE LA MANUFACTURA AVANZADA',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 70,
      // 'nombre'    => 'TECNOLÓGICO DE GESTIÓN INDUSTRIAL',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 1097,
      // 'nombre'    => 'CENTRO AGROPECUARIO Y DE SERVICIOS AMBIENTALES JIRI-JIRIMO',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 500,
      // 'nombre'    => 'CENTRO DE COMERCIO, INDUSTRIA Y TURISMO DE CÓRDOBA',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 298,
      // 'nombre'    => 'CENTRO MINERO',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 576,
      // 'nombre'    => 'CENTRO DE BIOTECNOLOGÍA AGROPECUARIA',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 655,
      // 'nombre'    => 'CENTRO DE LA INDUSTRIA, LA EMPRESA Y LOS SERVICIOS',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 1080,
      // 'nombre'    => 'CENTRO DE BIOTECNOLOGÍA INDUSTRIAL',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 801,
      // 'nombre'    => 'CENTRO INTERNACIONAL DE PRODUCCION LIMPIA - LOPE',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 888,
      // 'nombre'    => 'CENTRO ATENCIÓN SECTOR AGROPECUARIO',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 888,
      // 'nombre'    => 'CENTRO DE COMERCIO Y SERVICIOS',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 953,
      // 'nombre'    => 'CENTRO ATENCIÓN SECTOR AGROPECUARIO',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 662,
      // 'nombre'    => 'CENTRO DE GESTIÓN Y DESARROLLO SOSTENIBLE SURCOLOMBIANO',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 414,
      // 'nombre'    => 'CENTRO AGROPECUARIO',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 414,
      // 'nombre'    => 'CENTRO DE TELEINFORMÁTICA Y PRODUCCIÓN INDUSTRIAL',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 414,
      // 'nombre'    => 'CENTRO DE COMERCIO Y SERVICIOS',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 857,
      // 'nombre'    => 'CENTRO AGROFORESTAL Y ACUÍCOLA ARAPAIMA',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 81,
      // 'nombre'    => 'COMPLEJO TECNOLÓGICO MINERO AGROEMPRESARIAL',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 1101,
      // 'nombre'    => 'CENTRO DE PRODUCCIÓN Y TRANSFORMACIÓN AGROINDUSTRIAL DE LA ORINOQUÍA',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 634,
      // 'nombre'    => 'CENTRO AMBIENTAL Y ECOTURÍSTICO DEL NORORIENTE AMAZÓNICO',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 740,
      // 'nombre'    => 'CENTRO AGROINDUSTRIAL DEL META',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 477,
      // 'nombre'    => 'CENTRO DE RECURSOS NATURALES, INDUSTRIA Y BIODIVERSIDAD',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 686,
      // 'nombre'    => 'CENTRO INDUSTRIAL Y DE ENERGÍAS ALTERNATIVAS',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 86,
      // 'nombre'    => 'CENTRO DE LA INNOVACIÓN, LA AGROINDUSTRIA Y EL TURISMO',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 961,
      // 'nombre'    => 'CENTRO DE FORMACION TURISTICA, GENTE DE MAR Y DE SERVICIOS ',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 963,
      // 'nombre'    => 'CENTRO AGROTURÍSTICO',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 638,
      // 'nombre'    => 'CENTRO DE DESARROLLO AGROINDUSTRIAL, TURÍSTICO Y TECNOLÓGICO DEL GUAVIARE',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 716,
      // 'nombre'    => 'CENTRO DE LOGÍSTICA Y PROMOCIÓN ECOTURÍSTICA DEL MAGDALENA',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 1002,
      // 'nombre'    => 'CENTRO DE LA INNOVACIÓN, LA TECNOLOGÍA Y LOS SERVICIOS',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 603,
      // 'nombre'    => 'CENTRO DE TECNOLOGÍAS PARA LA CONSTRUCCIÓN Y LA MADERA',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 603,
      // 'nombre'    => 'CENTRO DE TECNOLOGÍAS DEL TRANSPORTE',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 603,
      // 'nombre'    => 'CENTRO INDUSTRIAL Y DESARROLLO EMPRESARIAL DE SOACHA',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 603,
      // 'nombre'    => 'CENTRO INDUSTRIAL Y DESARROLLO EMPRESARIAL DE SOACHA',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 603,
      // 'nombre'    => 'CENTRO NACIONAL DE HOTELERÍA, TURISMO Y ALIMENTOS',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 298,
      // 'nombre'    => 'CENTRO INDUSTRIAL DE MANTENIMIENTO Y MANUFACTURA',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 1089,
      // 'nombre'    => 'CENTRO LATINOAMERICANO DE  ESERVICIO PUBLICO DE EMPLEOCIES MENORES',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 811,
      // 'nombre'    => 'CENTRO AGROINDUSTRIAL Y PESQUERO DE LA COSTA PACÍFICA',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 317,
      // 'nombre'    => 'CENTRO DE GESTIÓN ADMINISTRATIVA Y FORTALECIMIENTO EMPRESARIAL',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 455,
      // 'nombre'    => 'CENTRO DE OPERACIÓN Y MANTENIMIENTO MINERO',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 455,
      // 'nombre'    => 'CENTRO BIOTECNOLÓGICO DEL CARIBE',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 979,
      // 'nombre'    => 'CENTRO DE GESTIÓN AGROEMPRESARIAL DEL ORIENTE',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 867,
      // 'nombre'    => 'CENTRO AGROINDUSTRIAL',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 867,
      // 'nombre'    => 'CENTRO PARA EL DESARROLLO TECNOLÓGICO DE LA CONSTRUCCIÓN',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 748,
      // 'nombre'    => 'CENTRO DE INDUSTRIA Y SERVICIOS DEL META',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 628,
      // 'nombre'    => 'CENTRO DE DESARROLLO AGROINDUSTRIAL Y EMPRESARIAL',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 388,
      // 'nombre'    => 'CENTRO AGROINDUSTRIAL Y FORTALECIMIENTO EMPRESARIAL DE CASANARE',
      // ]);
      //
      // Entidad::create([
      // 'ciudad_id' => 86,
      // 'nombre'    => 'CENTRO DE LA INNOVACIÓN, LA AGROINDUSTRIA Y LA AVIACIÓN​',
      // ]);
      /**
      * Fin de los Centros de Formación
      */

      //tecnoacademias
      Entidad::create([
      'ciudad_id' => 902,
      'nombre'    => 'TECNOACADEMIA BUCARAMANGA',
      ]);

      Entidad::create([
      'ciudad_id' => 1064,
      'nombre'    => 'TECNOACADEMIA CALI',
      ]);

      Entidad::create([
      'ciudad_id' => 525,
      'nombre'    => 'TECNOACADEMIA CAZUCA',
      ]);

      Entidad::create([
      'ciudad_id' => 1028,
      'nombre'    => 'TECNOACADEMIA IBAGUE',
      ]);

      Entidad::create([
      'ciudad_id' => 336,
      'nombre'    => 'TECNOACADEMIA MANIZALES',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'TECNOACADEMIA MEDELLIN',
      ]);

      Entidad::create([
      'ciudad_id' => 655,
      'nombre'    => 'TECNOACADEMIA NEIVA',
      ]);

      Entidad::create([
      'ciudad_id' => 888,
      'nombre'    => 'TECNOACADEMIA PEREIRA',
      ]);

      Entidad::create([
      'ciudad_id' => 801,
      'nombre'    => 'TECNOACADEMIA TUQUERRES',
      ]);

      Entidad::create([
      'ciudad_id' => 823,
      'nombre'    => 'TECNOACADEMIA CUCÚTA',
      ]);

      //empresas
      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'CIDET - Centro de Desarrollo Tecnológico del',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'Empresa  EAFIT.',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'Fechner SAS',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'INDUSTRIAS CORY S.A.S',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => '3deko paneles y decoración',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'Alimento Real',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'Alimentos Secos',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'ARDOBOT ROBOTICA S.A.S ',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'Arte Italiano',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'Asecop ',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'Bariloche parrilla Argentina',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'Biolimpieza',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'Cannaxia Labs',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'Centro de Ciencia y Tecnología de Antioquia',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'COGNOX S.A.S',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'COLANTA',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'Colcircuitos',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'Consultorio de Laboratorio Dental JJ Penagos',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'CREATUM',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'DEMETALICOS ',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'DL Café',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'Dulces del Trapiche',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'Eko Group Colombia S.A.S',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'EL COMITÉ DE REABILITACIÓN DE ANTIOQUIA',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'El Llano SAS',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'Elico Group S.A.S',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'Eretz Ambiente',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'ESE METROSALUD',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'FECHER S.A.S',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'Foot Group S.A.S.',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'FRIS MODULACIONES  LTDA ',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'Fris modulaciones limitada',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'Fundación Universitaria Maria Cano',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'Gatitud',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'Gobernación de Antioquia',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'GONVARRI MS COLOMBIA',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'Gonvarry Steel Sesvices',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'Honey plus',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'Hospital General de Medellín',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'Indie Level Studio SAS',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'Industria de alimentos',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'Ingbiocomb',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'Intelmotics',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'LEMON ICE',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'LUMENS FIDEAS',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'MAS CAPACIDAD',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'Masertivos',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'Materiales Asertivos',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'Milagrosa Wear',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'Nanomat SAS',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'Natucafé',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'Natural Conexion',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'OBBRO SAS',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'OSP Internacional  CALA',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'Pasa Pay S.A.S.',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'Perceptio SAS',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'Prodsoft',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'Rey Gallinazo',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'RUTA N',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'RXT Systems S.A.S',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'SAMCO',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'Santa Bárbara Coffee Market',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'SEAT SMART INORCA',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'SIGHT GROUP',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'Solitec Ingenieria',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'Tass',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'tecnologia',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'Tecondor',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'TODO PIZZA ',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'top rack comercilizadora',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'Vikla SAS',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'XENZemp',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'Friko',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'Artextil',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'ESUMER',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'Centro Tecnológico del Mobiliario',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'Varias',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'Corporación Parque Explora',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'Universidad de Antioquia',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'SENA',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'Alimentos Fincas S.A.S',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'Prebel',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'Personal',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'HERA INGENIERIA',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'TECH AND SOLVE S.A.S',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'ATEgroup-sotelco',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'Fundacion CFA',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'IGGA Ingeniería y Gestión Administrativa',
      ]);

      Entidad::create([
      'ciudad_id' => 70,
      'nombre'    => 'Group Ingenieria SAS',
      ]);

    }

  }
