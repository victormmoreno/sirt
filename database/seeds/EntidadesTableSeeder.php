<?php

use App\Models\{Entidad, LineaTecnologica};
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
        if (app()->environment() == 'production') {

            /**
             * Entidad No Aplica
             */
            Entidad::create([
                'id'        => 1,
                'ciudad_id' => 431,
                'nombre'    => 'No Aplica',
                'slug'      => 'No Aplica'
            ]);

            /**
             * Nodos de Tecnoparque
             */
            Entidad::create([
                'id'        => 2,
                'ciudad_id' => 70,
                'nombre'    => 'Medellin',
                'slug'      => 'Tecnoparque nodo Medellin'
            ]);

            Entidad::create([
                'id'        => 3,
                'ciudad_id' => 86,
                'nombre'    => 'Rionegro',
                'slug'      => 'Tecnoparque nodo Rionegro'
            ]);

            Entidad::create([
                'id'        => 4,
                'ciudad_id' => 1064,
                'nombre'    => 'Calí',
                'slug'      => 'Tecnoparque nodo Calí'

            ]);

            Entidad::create([
                'id'        => 5,
                'ciudad_id' => 525,
                'nombre'    => 'DC',
                'slug'      => 'Tecnoparque nodo DC'
            ]);

            Entidad::create([
                'id'        => 6,
                'ciudad_id' => 603,
                'nombre'    => 'Cazuca',
                'slug'      => 'Tecnoparque nodo Cazuca'

            ]);

            Entidad::create([
                'id'        => 7,
                'ciudad_id' => 888,
                'nombre'    => 'Pereira',
                'slug'      => 'Tecnoparque nodo Pereira'
            ]);

            Entidad::create([
                'id'        => 8,
                'ciudad_id' => 655,
                'nombre'    => 'Neiva',
                'slug'      => 'Tecnoparque nodo Neiva'
            ]);

            Entidad::create([
                'id'        => 9,
                'ciudad_id' => 902,
                'nombre'    => 'Bucaramanga',
                'slug'      => 'Tecnoparque nodo Bucaramanga'
            ]);

            Entidad::create([
                'id'        => 10,
                'ciudad_id' => 336,
                'nombre'    => 'Manizales',
                'slug'      => 'Tecnoparque nodo Manizales'
            ]);

            Entidad::create([
                'id'        => 11,
                'ciudad_id' => 1021,
                'nombre'    => 'La Granja',
                'slug'      => 'Tecnoparque nodo La Granja'
            ]);

            Entidad::create([
                'id'        => 12,
                'ciudad_id' => 662,
                'nombre'    => 'Pitalito',
                'slug'      => 'Tecnoparque nodo Pitalito'
            ]);

            Entidad::create([
                'id'        => 13,
                'ciudad_id' => 455,
                'nombre'    => 'Valledupar',
                'slug'      => 'Tecnoparque nodo Valledupar'
            ]);

            Entidad::create([
                'id'        => 14,
                'ciudad_id' => 837,
                'nombre'    => 'Ocaña',
                'slug'      => 'Tecnoparque nodo Ocaña'
            ]);

            Entidad::create([
                'id'        => 15,
                'ciudad_id' => 10,
                'nombre'    => 'Angostura',
                'slug'      => 'Tecnoparque nodo Angostura'
            ]);

            Entidad::create([
                'id'        => 16,
                'ciudad_id' => 971,
                'nombre'    => 'Socorro',
                'slug'      => 'Tecnoparque nodo Socorro'

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
                'slug'      => 'Centro para la Biodiversidad y el Turismo del Amazonas'
            ]);

            Entidad::create([
                'ciudad_id' => 26,
                'nombre'    => 'Centro de los Recursos Naturales Renovables - La Salada',
                'slug'      => 'Centro de los Recursos Naturales Renovables - La Salada antioquia'
            ]);

            Entidad::create([
                'ciudad_id' => 45,
                'nombre'    => 'Centro de Formación Minero Ambiental',
                'slug'      => 'Centro de Formación Minero Ambiental antioquia'
            ]);

            Entidad::create([
                'ciudad_id' => 45,
                'nombre'    => 'Centro de Formación Minero Ambiental',
                'slug'      => 'Centro de Formación Minero Ambiental'

            ]);

            Entidad::create([
                'ciudad_id' => 59,
                'nombre'    => 'Centro del Diseño y Manufactura del Cuero',
                'slug'      => 'Centro del Diseño y Manufactura del Cuero antioquia'
            ]);

            Entidad::create([
                'ciudad_id' => 59,
                'nombre'    => 'Centro de Formación en Diseño, Confección y Moda',
                'slug'      => 'Centro de Formación en Diseño, Confección y Moda antioquia'
            ]);

            Entidad::create([
                'ciudad_id' => 70,
                'nombre'    => 'Centro para el Desarrollo del Hábitat y la Construcción',
                'slug'      => 'Centro para el Desarrollo del Hábitat y la Construcción antioquia'
            ]);

            Entidad::create([
                'ciudad_id' => 70,
                'nombre'    => 'Centro de Tecnología de la Manufactura Avanzada',
                'slug'      => 'Centro de Tecnología de la Manufactura Avanzada antioquia'
            ]);

            Entidad::create([
                'ciudad_id' => 59,
                'nombre'    => 'Centro Tecnológico del Mobiliario',
                'slug'      => 'Centro Tecnológico del Mobiliario antioquia'
            ]);

            Entidad::create([
                'ciudad_id' => 70,
                'nombre'    => 'Centro de Comercio',
                'slug'      => 'Centro de Comercio antioquia'
            ]);

            Entidad::create([
                'ciudad_id' => 70,
                'nombre'    => 'Centro de Servicios de Salud',
                'slug'      => 'Centro de Servicios de Salud antioquia'
            ]);

            Entidad::create([
                'ciudad_id' => 70,
                'nombre'    => 'Centro de Servicios y Gestión Empresarial',
                'slug'      => 'Centro de Servicios y Gestión Empresarial antioquia'
            ]);

            Entidad::create([
                'ciudad_id' => 33,
                'nombre'    => 'Complejo Tecnológico para la Gestión Agroempresarial',
                'slug'      => 'Complejo Tecnológico para la Gestión Agroempresarial antioquia'
            ]);

            Entidad::create([
                'ciudad_id' => 81,
                'nombre'    => 'Complejo Tecnológico Minero Agroempresarial',
                'slug'      => 'Complejo Tecnológico Minero Agroempresarial antioquia'
            ]);

            Entidad::create([
                'ciudad_id' => 86,
                'nombre'    => 'Centro de la Innovación, la Agroindustria y la Aviación',
                'slug'      => 'Centro de la Innovación, la Agroindustria y la Aviación antioquia'
            ]);

            Entidad::create([
                'ciudad_id' => 13,
                'nombre'    => 'Complejo Tecnológico Agroindustrial, Pecuario y Turístico',
                'slug'      => 'Complejo Tecnológico Agroindustrial, Pecuario y Turístico antioquia'
            ]);

            Entidad::create([
                'ciudad_id' => 103,
                'nombre'    => 'Complejo Tecnológico, Turístico y Agroindustrial del Occidente Antioqueño',
                'slug'      => 'Complejo Tecnológico, Turístico y Agroindustrial del Occidente Antioqueño'
            ]);

            Entidad::create([
                'ciudad_id' => 128,
                'nombre'    => 'Centro de Gestión y Desarrollo Agroindustrial de Arauca',
                'slug'      => 'Centro de Gestión y Desarrollo Agroindustrial de Arauca'
            ]);

            Entidad::create([
                'ciudad_id' => 151,
                'nombre'    => 'Centro para el Desarrollo Agroecológico y Agroindustrial',
                'slug'      => 'Centro para el Desarrollo Agroecológico y Agroindustrial'
            ]);

            Entidad::create([
                'ciudad_id' => 142,
                'nombre'    => 'Centro Nacional Colombo Alemán',
                'slug'      => 'Centro Nacional Colombo Alemán'
            ]);

            Entidad::create([
                'ciudad_id' => 136,
                'nombre'    => 'Centro Industrial y de Aviación',
                'slug'      => 'Centro Industrial y de Aviación'
            ]);

            Entidad::create([
                'ciudad_id' => 136,
                'nombre'    => 'Centro de Comercio y Servicios',
                'slug'      => 'Centro de Comercio y Servicios'
            ]);

            /**
             * Centros de Bolivar
             */
            Entidad::create([
                'ciudad_id' => 166,
                'nombre'    => 'Centro Agroempresarial y Minero',
                'slug'      => 'Centro Agroempresarial y Minero Bolivar'
            ]);

            Entidad::create([
                'ciudad_id' => 166,
                'nombre'    => 'Centro Internacional Náutico, Fluvial y Portuario',
                'slug'      => 'Centro Internacional Náutico, Fluvial y Portuario Bolivar'
            ]);

            Entidad::create([
                'ciudad_id' => 166,
                'nombre'    => 'Centro para la Industria Petroquímica',
                'slug'      => 'Centro para la Industria Petroquímica Bolivar'
            ]);

            Entidad::create([
                'ciudad_id' => 166,
                'nombre'    => 'Centro de Comercio y Servicios',
                'slug'      => 'Centro de Comercio y Servicios bolivar'
            ]);

            /**
             * Centros de Boyacá
             */
            Entidad::create([
                'ciudad_id' => 234,
                'nombre'    => 'Centro de Desarrollo Agropecuario y Agroindustrial',
                'slug'      => 'Centro de Comercio y Servicios bolivar boyaca'
            ]);

            Entidad::create([
                'ciudad_id' => 298,
                'nombre'    => 'Centro  Minero',
                'slug'      => 'Centro  Minero boyaca'
            ]);

            Entidad::create([
                'ciudad_id' => 258,
                'nombre'    => 'Centro de Gestión Administrativa y Fortalecimiento Empresarial',
                'slug'      => 'Centro de Gestión Administrativa y Fortalecimiento Empresarial boyaca'
            ]);

            Entidad::create([
                'ciudad_id' => 234,
                'nombre'    => 'Centro Industrial de Mantenimiento y Manufactura',
                'slug'      => 'Centro Industrial de Mantenimiento y Manufactura boyaca'
            ]);

            /**
             * Centros de Caldas
             */
            Entidad::create([
                'ciudad_id' => 336,
                'nombre'    => 'Centro para la Formación Cafetera',
                'slug'      => 'Centro para la Formación Cafetera caldas'
            ]);

            Entidad::create([
                'ciudad_id' => 336,
                'nombre'    => 'Centro de Automatización Industrial',
                'slug'      => 'Centro de Automatización Industria caldas'
            ]);

            Entidad::create([
                'ciudad_id' => 336,
                'nombre'    => 'Centro de Procesos Industriales',
                'slug'      => 'Centro de Procesos Industriales caldas'
            ]);

            Entidad::create([
                'ciudad_id' => 336,
                'nombre'    => 'Centro de Comercio y Servicios',
                'slug'      => 'Centro de Comercio y Servicios caldas'
            ]);

            Entidad::create([
                'ciudad_id' => 333,
                'nombre'    => 'Centro Pecuario y Agroempresarial',
                'slug'      => 'Centro Pecuario y Agroempresarial caldas'
            ]);

            /**
             * Centros de Caquetá
             */
            Entidad::create([
                'ciudad_id' => 360,
                'nombre'    => 'Centro Tecnológico de la Amazonía',
                'slug'      => 'Centro Tecnológico de la Amazonía caqueta'
            ]);

            /**
             * Centros del Casanare
             */
            Entidad::create([
                'ciudad_id' => 388,
                'nombre'    => 'Centro Agroindustrial y Fortalecimiento Empresarial de Casanare',
                'slug'      => 'Centro Agroindustrial y Fortalecimiento Empresarial de Casanare'
            ]);

            /**
             * Centros del Cauca
             */
            Entidad::create([
                'ciudad_id' => 414,
                'nombre'    => 'Centro Agropecuario',
                'slug'      => 'Centro Agropecuario cauca'
            ]);

            Entidad::create([
                'ciudad_id' => 414,
                'nombre'    => 'Centro de Teleinformática y Producción Industrial',
                'slug'      => 'Centro de Teleinformática y Producción Industrial cauca'
            ]);

            Entidad::create([
                'ciudad_id' => 414,
                'nombre'    => 'Centro de Comercio y Servicios',
                'slug'      => 'Centro de Comercio y Servicios cauca'
            ]);

            /**
             * Centros del Cesa
             */

            Entidad::create([
                'ciudad_id' => 455,
                'nombre'    => 'Centro Biotecnológico del Caribe',
                'slug'      => 'Centro Biotecnológico del Caribe cesar'
            ]);

            Entidad::create([
                'ciudad_id' => 431,
                'nombre'    => 'Centro Agroempresarial',
                'slug'      => 'Centro Agroempresarial cesar'
            ]);

            Entidad::create([
                'ciudad_id' => 455,
                'nombre'    => 'Centro de Operación y Mantenimiento Minero',
                'slug'      => 'Centro de Operación y Mantenimiento Minero cesar'
            ]);
            /**
             * Centros del Chocó
             */
            Entidad::create([
                'ciudad_id' => 477,
                'nombre'    => 'Centro de Recursos Naturales, Industria y Biodiversidad',
                'slug'      => 'Centro de Recursos Naturales, Industria y Biodiversidad choco'
            ]);
            /**
             * Centros de Córdoba
             */
            Entidad::create([
                'ciudad_id' => 500,
                'nombre'    => 'Centro Agropecuario y de Biotecnología el Porvenir',
                'slug'      => 'Centro Agropecuario y de Biotecnología el Porvenir cordoba'
            ]);

            Entidad::create([
                'ciudad_id' => 500,
                'nombre'    => 'Centro de Comercio, Industria y Turismo de Córdoba',
                'slug'      => 'Centro de Comercio, Industria y Turismo de Córdoba'
            ]);
            /**
             * Centros de Cundinamarca
             */
            Entidad::create([
                'ciudad_id' => 554,
                'nombre'    => 'Centro de la Tecnología de Diseño y la Productividad Empresarial',
                'slug'      => 'Centro de la Tecnología de Diseño y la Productividad Empresarial Cundinamarca'
            ]);

            Entidad::create([
                'ciudad_id' => 576,
                'nombre'    => 'Centro de Biotecnología Agropecuaria',
                'slug'      => 'Centro de Biotecnología Agropecuaria Cundinamarca'
            ]);

            Entidad::create([
                'ciudad_id' => 603,
                'nombre'    => 'Centro Industrial y de Desarrollo Empresarial de Soacha',
                'slug'      => 'Centro Industrial y de Desarrollo Empresarial de Soacha Cundinamarca'
            ]);

            Entidad::create([
                'ciudad_id' => 628,
                'nombre'    => 'Centro de Desarrollo Agroindustrial y Empresarial',
                'slug'      => 'Centro de Desarrollo Agroindustrial y Empresarial Cundinamarca'
            ]);

            Entidad::create([
                'ciudad_id' => 536,
                'nombre'    => 'Centro de Desarrollo Agroempresarial',
                'slug'      => 'Centro de Desarrollo Agroempresarial Cundinamarca'
            ]);

            Entidad::create([
                'ciudad_id' => 547,
                'nombre'    => 'Centro Agroecológico y Empresarial',
                'slug'      => 'Centro Agroecológico y Empresarial Cundinamarca'
            ]);

            /**
             * Centros del Distrito Capital
             */
            Entidad::create([
                'ciudad_id' => 525,
                'nombre'    => 'Centro de Tecnologías para la Construcción y la Madera',
                'slug'      => 'Centro de Tecnologías para la Construcción y la Madera Distrito Capital'
            ]);

            Entidad::create([
                'ciudad_id' => 525,
                'nombre'    => 'Centro de Electricidad, Electrónica y Telecomunicaciones',
                'slug'      => 'Centro de Electricidad, Electrónica y Telecomunicaciones Distrito Capital'
            ]);

            Entidad::create([
                'ciudad_id' => 525,
                'nombre'    => 'Centro de Gestión Industrial',
                'slug'      => 'Centro de Gestión Industrial Distrito Capital'
            ]);

            Entidad::create([
                'ciudad_id' => 525,
                'nombre'    => 'Centro de Manufactura en Textil y Cuero',
                'slug'      => 'Centro de Manufactura en Textil y Cuero Distrito Capital'
            ]);

            Entidad::create([
                'ciudad_id' => 525,
                'nombre'    => 'Centro de Tecnologías del Transporte',
                'slug'      => 'Centro de Tecnologías del Transporte Distrito Capital'
            ]);

            Entidad::create([
                'ciudad_id' => 525,
                'nombre'    => 'Centro Metalmecánico',
                'slug'      => 'Centro Metalmecánico Distrito Capital'
            ]);

            Entidad::create([
                'ciudad_id' => 525,
                'nombre'    => 'Centro de Materiales y Ensayos',
                'slug'      => 'Centro de Materiales y Ensayos Distrito Capital'
            ]);

            Entidad::create([
                'ciudad_id' => 525,
                'nombre'    => 'Centro de Diseño y Metrología',
                'slug'      => 'Centro de Diseño y Metrología Distrito Capital'
            ]);

            Entidad::create([
                'ciudad_id' => 525,
                'nombre'    => 'Centro para la Industria de la Comunicación Gráfica',
                'slug'      => 'Centro para la Industria de la Comunicación Gráfica Distrito Capital'
            ]);

            Entidad::create([
                'ciudad_id' => 525,
                'nombre'    => 'Centro de Gestión de Mercados, Logística y Tecnologías de la Información',
                'slug'      => 'Centro de Gestión de Mercados, Logística y Tecnologías de la Información Distrito Capital'
            ]);

            Entidad::create([
                'ciudad_id' => 525,
                'nombre'    => 'Centro de Formación de Talento Humano en Salud',
                'slug'      => 'Centro de Formación de Talento Humano en Salud Distrito Capital'
            ]);

            Entidad::create([
                'ciudad_id' => 525,
                'nombre'    => 'Centro de Gestión Administrativa',
                'slug'      => 'Centro de Gestión Administrativa Distrito Capital'
            ]);

            Entidad::create([
                'ciudad_id' => 525,
                'nombre'    => 'Centro de Servicios Financieros',
                'slug'      => 'Centro de Servicios Financieros Distrito Capital'
            ]);

            Entidad::create([
                'ciudad_id' => 525,
                'nombre'    => 'Centro Nacional de Hotelería, Turismo y Alimentos',
                'slug'      => 'Centro Nacional de Hotelería, Turismo y Alimentos Distrito Capital'
            ]);

            Entidad::create([
                'ciudad_id' => 525,
                'nombre'    => 'Centro de Formación en Actividad Física y Cultura',
                'slug'      => 'Centro de Formación en Actividad Física y Cultura Distrito Capital'
            ]);

            /**
             * Centros del Guainia
             */

            Entidad::create([
                'ciudad_id' => 634,
                'nombre'    => 'Centro Ambiental y Ecoturistico del Nororiente Amazónico',
                'slug'      => 'Centro Ambiental y Ecoturistico del Nororiente Amazónico Guainia'
            ]);

            /**
             * Centros de la Guajira
             */

            Entidad::create([
                'ciudad_id' => 686,
                'nombre'    => 'Centro Industrial y de Energías Alternativas',
                'slug'      => 'Centro Industrial y de Energías Alternativas Guajira'
            ]);

            Entidad::create([
                'ciudad_id' => 681,
                'nombre'    => 'Centro Agroempresarial y Acuícola',
                'slug'      => 'Centro Agroempresarial y Acuícola Guajira'
            ]);

            /**
             * Centros del Guaviare
             */

            Entidad::create([
                'ciudad_id' => 638,
                'nombre'    => 'Centro de Desarrollo Agroindustrial, Turístico y Tecnológico del Guaviare',
                'slug'      => 'Centro de Desarrollo Agroindustrial, Turístico y Tecnológico del Guaviare'
            ]);

            /**
             * Centros de formación del Huila
             */

            Entidad::create([
                'ciudad_id' => 645,
                'nombre'    => 'Centro de Formación Agroindustrial',
                'slug'      => 'Centro de Formación Agroindustrial Huila'
            ]);

            Entidad::create([
                'ciudad_id' => 648,
                'nombre'    => 'Centro Agroempresarial y Desarrollo Pecuario del Huila',
                'slug'      => 'Centro Agroempresarial y Desarrollo Pecuario del Huila'
            ]);

            Entidad::create([
                'ciudad_id' => 654,
                'nombre'    => 'Centro de Desarrollo Agroempresarial y Turístico del Huila',
                'slug'      => 'Centro de Desarrollo Agroempresarial y Turístico del Huila'
            ]);

            Entidad::create([
                'ciudad_id' => 655,
                'nombre'    => 'Centro de la Industria, la Empresa y los Servicios',
                'slug'      => 'Centro de la Industria, la Empresa y los Servicios del Huila'
            ]);

            Entidad::create([
                'ciudad_id' => 662,
                'nombre'    => 'Centro de Gestión y Desarrollo Sostenible Surcolombiano',
                'slug'      => 'Centro de Gestión y Desarrollo Sostenible Surcolombiano del Huila'
            ]);

            /**
             * Centros de Formación del Magdalena
             */

            Entidad::create([
                'ciudad_id' => 716,
                'nombre'    => 'Centro Acuícola y Agroindustrial de Gaira',
                'slug'      => 'Centro Acuícola y Agroindustrial de Gaira del Magdalena'
            ]);

            Entidad::create([
                'ciudad_id' => 716,
                'nombre'    => 'Centro de Logística y Promoción Ecoturística del Magdalena',
                'slug'      => 'Centro de Logística y Promoción Ecoturística del Magdalena'
            ]);

            /**
             * Centros de Formación del Meta
             */

            Entidad::create([
                'ciudad_id' => 731,
                'nombre'    => 'Centro Agroindustrial del Meta',
                'slug'      => 'Centro Agroindustrial del Meta'
            ]);

            Entidad::create([
                'ciudad_id' => 748,
                'nombre'    => 'Centro de Industria y Servicios del Meta',
                'slug'      => 'Centro de Industria y Servicios del Meta'
            ]);

            /**
             * Centros de Formación de Nariño
             */

            Entidad::create([
                'ciudad_id' => 778,
                'nombre'    => 'Centro Sur Colombiano de Logística Internacional',
                'slug'      => 'Centro Sur Colombiano de Logística Internacional del Nariño'
            ]);

            Entidad::create([
                'ciudad_id' => 811,
                'nombre'    => 'Centro Agroindustrial y Pesquero de la Costa Pacífica',
                'slug'      => 'Centro Agroindustrial y Pesquero de la Costa Pacífica Nariño'
            ]);

            Entidad::create([
                'ciudad_id' => 801,
                'nombre'    => 'Centro Internacional de Producción Limpia - Lope',
                'slug'      => 'Centro Internacional de Producción Limpia - Lope Nariño'
            ]);

            /**
             * Centros de Formación del Norte del Santander
             */

            Entidad::create([
                'ciudad_id' => 823,
                'nombre'    => 'Centro de Formación para el Desarrollo Rural y Minero',
                'slug'      => 'Centro de Formación para el Desarrollo Rural y Minero Norte del Santander'
            ]);

            Entidad::create([
                'ciudad_id' => 837,
                'nombre'    => 'Centro de la Industria, la Empresa y los Servicios',
                'slug'      => 'Centro de la Industria, la Empresa y los Servicios Norte del Santander'
            ]);

            /**
             * Centros de Formación del Putumayo
             */

            Entidad::create([
                'ciudad_id' => 857,
                'nombre'    => 'Centro Agroforestal y Acuícola Arapaima',
                'slug'      => 'Centro Agroforestal y Acuícola Arapaima Putumayo'
            ]);

            /**
             * Centros de Formación del Quindio
             */

            Entidad::create([
                'ciudad_id' => 867,
                'nombre'    => 'Centro Agroindustrial',
                'slug'      => 'Centro Agroindustrial Quindio'
            ]);

            Entidad::create([
                'ciudad_id' => 867,
                'nombre'    => 'Centro para el Desarrollo Tecnológico de la Construcción y la Industria',
                'slug'      => 'Centro para el Desarrollo Tecnológico de la Construcción y la Industria Quindio'
            ]);

            Entidad::create([
                'ciudad_id' => 867,
                'nombre'    => 'Centro de Comercio y Turismo',
                'slug'      => 'Centro de Comercio y Turismo Quindio'
            ]);

            /**
             * Centros de Formarción del Risaralda
             */

            Entidad::create([
                'ciudad_id' => 888,
                'nombre'    => 'Centro Atención Sector Agropecuario',
                'slug'      => 'Centro de Comercio y Turismo Risaralda'
            ]);

            Entidad::create([
                'ciudad_id' => 882,
                'nombre'    => 'Centro de Diseño e Innovación Tecnológica Industrial',
                'slug'      => 'Centro de Diseño e Innovación Tecnológica Industrial Risaralda'
            ]);

            Entidad::create([
                'ciudad_id' => 888,
                'nombre'    => 'Centro de Comercio y Servicios',
                'slug'      => 'Centro de Comercio y Servicios Risaralda'
            ]);

            /**
             * Centros de formación de San Andrés
             */

            Entidad::create([
                'ciudad_id' => 893,
                'nombre'    => 'Centro de Formación Turística, Gente de Mar y de Servicio',
                'slug'      => 'Centro de Comercio y Servicios San Andrés'
            ]);

            /**
             * Centros de formación de Santander
             */

            Entidad::create([
                'ciudad_id' => 953,
                'nombre'    => 'Centro Atención Sector Agropecuario',
                'slug'      => 'Centro Atención Sector Agropecuario Santander'
            ]);

            Entidad::create([
                'ciudad_id' => 928,
                'nombre'    => 'Centro Industrial de Mantenimiento Integral',
                'slug'      => 'Centro Industrial de Mantenimiento Integral Santander'
            ]);

            Entidad::create([
                'ciudad_id' => 925,
                'nombre'    => 'Centro Industrial del Diseño y la Manufactura',
                'slug'      => 'Centro Industrial del Diseño y la Manufactura Santander'
            ]);

            Entidad::create([
                'ciudad_id' => 902,
                'nombre'    => 'Centro de Servicios Empresariales y Turísticos',
                'slug'      => 'Centro de Servicios Empresariales y Turísticos Santander'
            ]);

            Entidad::create([
                'ciudad_id' => 899,
                'nombre'    => 'Centro Industrial y del Desarrollo Tecnológico',
                'slug'      => 'Centro Industrial y del Desarrollo Tecnológico Santander'
            ]);

            Entidad::create([
                'ciudad_id' => 963,
                'nombre'    => 'Centro Agroturístico',
                'slug'      => 'Centro Agroturístico Santander'
            ]);

            Entidad::create([
                'ciudad_id' => 947,
                'nombre'    => 'Centro Agroempresarial y Turístico de los Andes',
                'slug'      => 'Centro Agroempresarial y Turístico de los Andes Santander'
            ]);

            Entidad::create([
                'ciudad_id' => 897,
                'nombre'    => 'Centro de Gestión Agroempresarial del Oriente',
                'slug'      => 'Centro de Gestión Agroempresarial del Oriente Santander'
            ]);

            /**
             * Centros de Formación de Sucre
             */

            Entidad::create([
                'ciudad_id' => 1002,
                'nombre'    => 'Centro de la Innovación, la Tecnología y los Servicios',
                'slug'      => 'Centro de la Innovación, la Tecnología y los Servicios Sucre'
            ]);

            /**
             * Centros de Formación del Tolima
             */

            Entidad::create([
                'ciudad_id' => 1021,
                'nombre'    => 'Centro Agropecuario la Granja',
                'slug'      => 'Centro de la Innovación, la Tecnología y los Servicios Tolima'
            ]);

            Entidad::create([
                'ciudad_id' => 1028,
                'nombre'    => 'Centro de Industria y Construcción',
                'slug'      => 'Centro de Industria y Construcción Tolima'
            ]);

            Entidad::create([
                'ciudad_id' => 1028,
                'nombre'    => 'Centro de Comercio y Servicios',
                'slug'      => 'Centro de Comercio y Servicios Tolima'
            ]);

            /**
             * Centros de Formación del Valle
             */

            Entidad::create([
                'ciudad_id' => 1060,
                'nombre'    => 'Centro Agropecuario de Buga',
                'slug'      => 'Centro Agropecuario de Buga Valle'
            ]);

            Entidad::create([
                'ciudad_id' => 1089,
                'nombre'    => 'Centro Latinoamericano de Especies Menores',
                'slug'      => 'Centro Latinoamericano de Especies Menores Valle'
            ]);

            Entidad::create([
                'ciudad_id' => 1059,
                'nombre'    => 'Centro Náutico Pesquero de Buenaventura',
                'slug'      => 'Centro Náutico Pesquero de Buenaventura Valle'
            ]);

            Entidad::create([
                'ciudad_id' => 1064,
                'nombre'    => 'Centro de Electricidad y Automatización Industrial -CEAI',
                'slug'      => 'Centro de Electricidad y Automatización Industrial -CEAI Valle'

            ]);

            Entidad::create([
                'ciudad_id' => 1064,
                'nombre'    => 'Centro de la Construcción',
                'slug'      => 'Centro de la Construcción Valle'
            ]);

            Entidad::create([
                'ciudad_id' => 1064,
                'nombre'    => 'Centro de Diseño Tecnológico Industrial',
                'slug'      => 'Centro de Diseño Tecnológico Industrial Valle'
            ]);

            Entidad::create([
                'ciudad_id' => 1064,
                'nombre'    => 'Centro Nacional de Asistencia Técnica a la Industria -ASTIN',
                'slug'      => 'Centro Nacional de Asistencia Técnica a la Industria -ASTIN Valle'
            ]);

            Entidad::create([
                'ciudad_id' => 1064,
                'nombre'    => 'Centro de Gestión Tecnológica de Servicios',
                'slug'      => 'Centro de Gestión Tecnológica de Servicios Valle'
            ]);

            Entidad::create([
                'ciudad_id' => 1066,
                'nombre'    => 'Centro de Tecnologías Agroindustriales',
                'slug'      => 'Centro de Tecnologías Agroindustriales Valle'
            ]);

            Entidad::create([
                'ciudad_id' => 1080,
                'nombre'    => 'Centro de Biotecnología Industrial',
                'slug'      => 'Centro de Biotecnología Industrial Valle'

            ]);

            /**
             * Centros de Formación del Vaupés
             */

            Entidad::create([
                'ciudad_id' => 1097,
                'nombre'    => 'Centro Agropecuario y de Servicios Ambientales "Jiri-jirimo"',
                'slug'      => 'Centro Agropecuario y de Servicios Ambientales "Jiri-jirimo" Vaupés'
            ]);

            /**
             * Centros de Formación del Vichada
             */

            Entidad::create([
                'ciudad_id' => 1101,
                'nombre'    => 'Centro de Producción y Transformación Agroindustrial de la Orinoquía',
                'slug'      => 'Centro de Producción y Transformación Agroindustrial de la Orinoquía Vichada'
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
                'slug'      => 'TECNOACADEMIA BUCARAMANGA'
            ]);

            Entidad::create([
                'ciudad_id' => 1064,
                'nombre'    => 'TECNOACADEMIA CALI',
                'slug'      => 'TECNOACADEMIA CALI'
            ]);

            Entidad::create([
                'ciudad_id' => 525,
                'nombre'    => 'TECNOACADEMIA CAZUCA',
                'slug'      => 'TECNOACADEMIA CAZUCA'
            ]);

            Entidad::create([
                'ciudad_id' => 1028,
                'nombre'    => 'TECNOACADEMIA IBAGUE',
                'slug'      => 'TECNOACADEMIA IBAGUE'
            ]);

            Entidad::create([
                'ciudad_id' => 336,
                'nombre'    => 'TECNOACADEMIA MANIZALES',
                'slug'      => 'TECNOACADEMIA MANIZALES'
            ]);

            Entidad::create([
                'ciudad_id' => 70,
                'nombre'    => 'TECNOACADEMIA MEDELLIN',
                'slug'      => 'TECNOACADEMIA MEDELLIN'
            ]);

            Entidad::create([
                'ciudad_id' => 655,
                'nombre'    => 'TECNOACADEMIA NEIVA',
                'slug'      => 'TECNOACADEMIA NEIVA'
            ]);

            Entidad::create([
                'ciudad_id' => 888,
                'nombre'    => 'TECNOACADEMIA PEREIRA',
                'slug'      => 'TECNOACADEMIA PEREIRA'
            ]);

            Entidad::create([
                'ciudad_id' => 801,
                'nombre'    => 'TECNOACADEMIA TUQUERRES',
                'slug'      => 'TECNOACADEMIA TUQUERRES'
            ]);

            Entidad::create([
                'ciudad_id' => 823,
                'nombre'    => 'TECNOACADEMIA CUCÚTA',
                'slug'      => 'TECNOACADEMIA CUCÚTA'
            ]);

            /**
             * Fin de las Tecnoacademias
             */

            /**
             * Inicio de las empresas
             */

            /**
             * Fin de empresas
             */
        } else {
            Entidad::create([
                'ciudad_id' => 431,
                'nombre'    => 'No Aplica',
                'slug'      => 'No Aplica',
                'email_entidad'      => 'noaplica@noaplica.com',
            ]);

            factory(Entidad::class, 50)->create()
                ->each(function ($entidad) {
                    $entidad->centro()->save(factory(App\Models\Centro::class)->make());
                });

            $this->nodo(1, 'Bogotá');
            $this->nodo(1, 'Medellin');
            $this->nodo(1, 'Cartagena');
            $this->nodo(1, 'Manizales');
            $this->nodo(1, 'Cali');
            $this->nodo(1, 'Barranquilla');
            $this->nodo(1, 'Pereira');
            $this->nodo(1, 'Pasto');
            // $this->nodo(7);

            factory(Entidad::class, 10)->create()
                ->each(function ($entidad) {
                    $entidad->tecnoacademia()->save(factory(App\Models\Tecnoacademia::class)->make());
                });

            factory(Entidad::class, 100)->create()
            ->each(function ($entidad) {
                $entidad->empresa()->save(factory(App\Models\Empresa::class)->make());
            });

            factory(Entidad::class, 50)->create()
            ->each(function ($entidad) {
                $entidad->grupoinvestigacion()->save(factory(App\Models\GrupoInvestigacion::class)->make());
            });

        }
    }

    private function nodo($cantidad = 1, $nodo  = '')
    {
        $lineas = LineaTecnologica::all();
        if ($cantidad == 1 && $nodo !== '') {
            factory(Entidad::class, $cantidad)->create([
                'nombre' => $nodo,
                'email_entidad' => "infotecno{$nodo}@{$nodo}.com",
                'slug'      => "tecnoparque nodo {$nodo}",
            ])
                ->each(function ($entidad) use ($lineas) {
                    $entidad->nodo()->save(factory(App\Models\Nodo::class)->make());
                    $entidad->nodo->lineas()->sync($lineas);
                });
        } else {
            factory(Entidad::class, $cantidad)->create()

                ->each(function ($entidad) use ($lineas) {
                    $entidad->nodo()->save(factory(App\Models\Nodo::class)->make());
                    $entidad->nodo->lineas()->sync($lineas);
                });
        }
    }
}
