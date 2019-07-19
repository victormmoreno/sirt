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
      'nombre'    => 'La Granja',
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
      * Centros del Cauca
      */
      Entidad::create([
      'ciudad_id' => 414,
      'nombre'    => 'Centro Agropecuario',
      ]);

      Entidad::create([
      'ciudad_id' => 414,
      'nombre'    => 'Centro de Teleinformática y Producción Industrial',
      ]);

      Entidad::create([
      'ciudad_id' => 414,
      'nombre'    => 'Centro de Comercio y Servicios',
      ]);

      /**
      * Centros del Cesa
      */

      Entidad::create([
      'ciudad_id' => 455,
      'nombre'    => 'Centro Biotecnológico del Caribe',
      ]);

      Entidad::create([
      'ciudad_id' => 431,
      'nombre'    => 'Centro Agroempresarial',
      ]);

      Entidad::create([
      'ciudad_id' => 455,
      'nombre'    => 'Centro de Operación y Mantenimiento Minero',
      ]);
      /**
      * Centros del Chocó
      */
      Entidad::create([
      'ciudad_id' => 477,
      'nombre'    => 'Centro de Recursos Naturales, Industria y Biodiversidad',
      ]);
      /**
      * Centros de Córdoba
      */
      Entidad::create([
      'ciudad_id' => 500,
      'nombre'    => 'Centro Agropecuario y de Biotecnología el Porvenir',
      ]);

      Entidad::create([
      'ciudad_id' => 500,
      'nombre'    => 'Centro de Comercio, Industria y Turismo de Córdoba',
      ]);
      /**
      * Centros de Cundinamarca
      */
      Entidad::create([
      'ciudad_id' => 554,
      'nombre'    => 'Centro de la Tecnología de Diseño y la Productividad Empresarial',
      ]);

      Entidad::create([
      'ciudad_id' => 576,
      'nombre'    => 'Centro de Biotecnología Agropecuaria',
      ]);

      Entidad::create([
      'ciudad_id' => 603,
      'nombre'    => 'Centro Industrial y de Desarrollo Empresarial de Soacha',
      ]);

      Entidad::create([
      'ciudad_id' => 628,
      'nombre'    => 'Centro de Desarrollo Agroindustrial y Empresarial',
      ]);

      Entidad::create([
      'ciudad_id' => 536,
      'nombre'    => 'Centro de Desarrollo Agroempresarial',
      ]);

      Entidad::create([
      'ciudad_id' => 547,
      'nombre'    => 'Centro Agroecológico y Empresarial',
      ]);

      /**
      * Centros del Distrito Capital
      */
      Entidad::create([
      'ciudad_id' => 525,
      'nombre'    => 'Centro de Tecnologías para la Construcción y la Madera',
      ]);

      Entidad::create([
      'ciudad_id' => 525,
      'nombre'    => 'Centro de Electricidad, Electrónica y Telecomunicaciones',
      ]);

      Entidad::create([
      'ciudad_id' => 525,
      'nombre'    => 'Centro de Gestión Industrial',
      ]);

      Entidad::create([
      'ciudad_id' => 525,
      'nombre'    => 'Centro de Manufactura en Textil y Cuero',
      ]);

      Entidad::create([
      'ciudad_id' => 525,
      'nombre'    => 'Centro de Tecnologías del Transporte',
      ]);

      Entidad::create([
      'ciudad_id' => 525,
      'nombre'    => 'Centro Metalmecánico',
      ]);

      Entidad::create([
      'ciudad_id' => 525,
      'nombre'    => 'Centro de Materiales y Ensayos',
      ]);

      Entidad::create([
      'ciudad_id' => 525,
      'nombre'    => 'Centro de Diseño y Metrología',
      ]);

      Entidad::create([
      'ciudad_id' => 525,
      'nombre'    => 'Centro para la Industria de la Comunicación Gráfica',
      ]);

      Entidad::create([
      'ciudad_id' => 525,
      'nombre'    => 'Centro de Gestión de Mercados, Logística y Tecnologías de la Información',
      ]);

      Entidad::create([
      'ciudad_id' => 525,
      'nombre'    => 'Centro de Formación de Talento Humano en Salud',
      ]);

      Entidad::create([
      'ciudad_id' => 525,
      'nombre'    => 'Centro de Gestión Administrativa',
      ]);

      Entidad::create([
      'ciudad_id' => 525,
      'nombre'    => 'Centro de Servicios Financieros',
      ]);

      Entidad::create([
      'ciudad_id' => 525,
      'nombre'    => 'Centro Nacional de Hotelería, Turismo y Alimentos',
      ]);

      Entidad::create([
      'ciudad_id' => 525,
      'nombre'    => 'Centro de Formación en Actividad Física y Cultura',
      ]);

      /**
      * Centros del Guinia
      */

      Entidad::create([
      'ciudad_id' => 634,
      'nombre'    => 'Centro Ambiental y Ecoturistico del Nororiente Amazónico',
      ]);

      /**
      * Centros de la Guajira
      */

      Entidad::create([
      'ciudad_id' => 686,
      'nombre'    => 'Centro Industrial y de Energías Alternativas',
      ]);

      Entidad::create([
      'ciudad_id' => 681,
      'nombre'    => 'Centro Agroempresarial y Acuícola',
      ]);

      /**
      * Centros del Guaviare
      */

      Entidad::create([
      'ciudad_id' => 638,
      'nombre'    => 'Centro de Desarrollo Agroindustrial, Turístico y Tecnológico del Guaviare',
      ]);

      /**
      * Centros de formación del Huila
      */

      Entidad::create([
      'ciudad_id' => 645,
      'nombre'    => 'Centro de Formación Agroindustrial',
      ]);

      Entidad::create([
      'ciudad_id' => 648,
      'nombre'    => 'Centro Agroempresarial y Desarrollo Pecuario del Huila',
      ]);

      Entidad::create([
      'ciudad_id' => 654,
      'nombre'    => 'Centro de Desarrollo Agroempresarial y Turístico del Huila',
      ]);

      Entidad::create([
      'ciudad_id' => 655,
      'nombre'    => 'Centro de la Industria, la Empresa y los Servicios',
      ]);

      Entidad::create([
      'ciudad_id' => 662,
      'nombre'    => 'Centro de Gestión y Desarrollo Sostenible Surcolombiano',
      ]);

      /**
      * Centros de Formación del Magdalena
      */

      Entidad::create([
      'ciudad_id' => 716,
      'nombre'    => 'Centro Acuícola y Agroindustrial de Gaira',
      ]);

      Entidad::create([
      'ciudad_id' => 716,
      'nombre'    => 'Centro de Logística y Promoción Ecoturística del Magdalena',
      ]);

      /**
      * Centros de Formación del Meta
      */

      Entidad::create([
        'ciudad_id' => 731,
        'nombre'    => 'Centro Agroindustrial del Meta',
      ]);

      Entidad::create([
        'ciudad_id' => 748,
        'nombre'    => 'Centro de Industria y Servicios del Meta',
      ]);

      /**
      * Centros de Formación de Nariño
      */

      Entidad::create([
        'ciudad_id' => 778,
        'nombre'    => 'Centro Sur Colombiano de Logística Internacional',
      ]);

      Entidad::create([
        'ciudad_id' => 811,
        'nombre'    => 'Centro Agroindustrial y Pesquero de la Costa Pacífica',
      ]);

      Entidad::create([
        'ciudad_id' => 801,
        'nombre'    => 'Centro Internacional de Producción Limpia - Lope',
      ]);

      /**
      * Centros de Formación del Norte del Santander
      */

      Entidad::create([
        'ciudad_id' => 823,
        'nombre'    => 'Centro de Formación para el Desarrollo Rural y Minero',
      ]);

      Entidad::create([
        'ciudad_id' => 837,
        'nombre'    => 'Centro de la Industria, la Empresa y los Servicios',
      ]);

      /**
      * Centros de Formación del Putumayo
      */

      Entidad::create([
        'ciudad_id' => 857,
        'nombre'    => 'Centro Agroforestal y Acuícola Arapaima',
      ]);

      /**
      * Centros de Formación del Quindio
      */

      Entidad::create([
        'ciudad_id' => 867,
        'nombre'    => 'Centro Agroindustrial',
      ]);

      Entidad::create([
        'ciudad_id' => 867,
        'nombre'    => 'Centro para el Desarrollo Tecnológico de la Construcción y la Industria',
      ]);

      Entidad::create([
        'ciudad_id' => 867,
        'nombre'    => 'Centro de Comercio y Turismo',
      ]);

      /**
      * Centros de Formarción del Risaralda
      */

      Entidad::create([
        'ciudad_id' => 888,
        'nombre'    => 'Centro Atención Sector Agropecuario',
      ]);

      Entidad::create([
        'ciudad_id' => 882,
        'nombre'    => 'Centro de Diseño e Innovación Tecnológica Industrial',
      ]);

      Entidad::create([
        'ciudad_id' => 888,
        'nombre'    => 'Centro de Comercio y Servicios',
      ]);

      /**
      * Centros de formación de San Andrés
      */

      Entidad::create([
        'ciudad_id' => 893,
        'nombre'    => 'Centro de Formación Turística, Gente de Mar y de Servicio',
      ]);

      /**
      * Centros de formación de Santander
      */

      Entidad::create([
        'ciudad_id' => 953,
        'nombre'    => 'Centro Atención Sector Agropecuario',
      ]);

      Entidad::create([
        'ciudad_id' => 928,
        'nombre'    => 'Centro Industrial de Mantenimiento Integral',
      ]);

      Entidad::create([
        'ciudad_id' => 925,
        'nombre'    => 'Centro Industrial del Diseño y la Manufactura',
      ]);

      Entidad::create([
        'ciudad_id' => 902,
        'nombre'    => 'Centro de Servicios Empresariales y Turísticos',
      ]);

      Entidad::create([
        'ciudad_id' => 899,
        'nombre'    => 'Centro Industrial y del Desarrollo Tecnológico',
      ]);

      Entidad::create([
        'ciudad_id' => 963,
        'nombre'    => 'Centro Agroturístico',
      ]);

      Entidad::create([
        'ciudad_id' => 947,
        'nombre'    => 'Centro Agroempresarial y Turístico de los Andes',
      ]);

      Entidad::create([
        'ciudad_id' => 897,
        'nombre'    => 'Centro de Gestión Agroempresarial del Oriente',
      ]);

      /**
      * Centros de Formación de Sucre
      */

      Entidad::create([
        'ciudad_id' => 1002,
        'nombre'    => 'Centro de la Innovación, la Tecnología y los Servicios',
      ]);

      /**
      * Centros de Formación del Tolima
      */

      Entidad::create([
        'ciudad_id' => 1021,
        'nombre'    => 'Centro Agropecuario la Granja',
      ]);

      Entidad::create([
        'ciudad_id' => 1028,
        'nombre'    => 'Centro de Industria y Construcción',
      ]);

      Entidad::create([
        'ciudad_id' => 1028,
        'nombre'    => 'Centro de Comercio y Servicios',
      ]);

      /**
      * Centros de Formación del Valle
      */

      Entidad::create([
        'ciudad_id' => 1060,
        'nombre'    => 'Centro Agropecuario de Buga',
      ]);

      Entidad::create([
        'ciudad_id' => 1089,
        'nombre'    => 'Centro Latinoamericano de Especies Menores',
      ]);

      Entidad::create([
        'ciudad_id' => 1059,
        'nombre'    => 'Centro Náutico Pesquero de Buenaventura',
      ]);

      Entidad::create([
        'ciudad_id' => 1064,
        'nombre'    => 'Centro de Electricidad y Automatización Industrial -CEAI',
      ]);

      Entidad::create([
        'ciudad_id' => 1064,
        'nombre'    => 'Centro de la Construcción',
      ]);

      Entidad::create([
        'ciudad_id' => 1064,
        'nombre'    => 'Centro de Diseño Tecnológico Industrial',
      ]);

      Entidad::create([
        'ciudad_id' => 1064,
        'nombre'    => 'Centro Nacional de Asistencia Técnica a la Industria -ASTIN',
      ]);

      Entidad::create([
        'ciudad_id' => 1064,
        'nombre'    => 'Centro de Gestión Tecnológica de Servicios',
      ]);

      Entidad::create([
        'ciudad_id' => 1066,
        'nombre'    => 'Centro de Tecnologías Agroindustriales',
      ]);

      Entidad::create([
        'ciudad_id' => 1080,
        'nombre'    => 'Centro de Biotecnología Industrial',
      ]);

      /**
      * Centros de Formación del Vaupés
      */

      Entidad::create([
        'ciudad_id' => 1097,
        'nombre'    => 'Centro Agropecuario y de Servicios Ambientales "Jiri-jirimo"',
      ]);

      /**
      * Centros de Formación del Vichada
      */

      Entidad::create([
        'ciudad_id' => 1101,
        'nombre'    => 'Centro de Producción y Transformación Agroindustrial de la Orinoquía',
      ]);


      /**
      * Fin de los centros de formación
      */

      /**
      * Tecnoacademias
      */
      
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
