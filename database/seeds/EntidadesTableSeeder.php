<?php

use App\Models\Entidad;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

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
                'slug'      => Str::slug('No Aplica', '-'),
            ]);

            /**
             * Nodos de Tecnoparque
             */
            Entidad::create([
                'id'        => 2,
                'ciudad_id' => 70,
                'nombre'    => 'Medellin',
                'slug'      => Str::slug('Tecnoparque nodo Medellin', '-'),
            ]);

            Entidad::create([
                'id'        => 3,
                'ciudad_id' => 86,
                'nombre'    => 'Rionegro',
                'slug'      => Str::slug('Tecnoparque nodo Rionegro', '-'),
            ]);

            Entidad::create([
                'id'        => 4,
                'ciudad_id' => 1064,
                'nombre'    => 'Calí',
                'slug'      => Str::slug('Tecnoparque nodo Calí', '-'),

            ]);

            Entidad::create([
                'id'        => 5,
                'ciudad_id' => 525,
                'nombre'    => 'DC',
                'slug'      => Str::slug('Tecnoparque nodo DC', '-'),
            ]);

            Entidad::create([
                'id'        => 6,
                'ciudad_id' => 603,
                'nombre'    => 'Cazuca',
                'slug'      => Str::slug('Tecnoparque nodo Cazuca', '-'),

            ]);

            Entidad::create([
                'id'        => 7,
                'ciudad_id' => 888,
                'nombre'    => 'Pereira',
                'slug'      => Str::slug('Tecnoparque nodo Pereira', '-'),
            ]);

            Entidad::create([
                'id'        => 8,
                'ciudad_id' => 655,
                'nombre'    => 'Neiva',
                'slug'      => Str::slug('Tecnoparque nodo Neiva', '-'),
            ]);

            Entidad::create([
                'id'        => 9,
                'ciudad_id' => 902,
                'nombre'    => 'Bucaramanga',
                'slug'      => Str::slug('Tecnoparque nodo Bucaramanga', '-'),
            ]);

            Entidad::create([
                'id'        => 10,
                'ciudad_id' => 336,
                'nombre'    => 'Manizales',
                'slug'      => Str::slug('Tecnoparque nodo Manizales', '-'),
            ]);

            Entidad::create([
                'id'        => 11,
                'ciudad_id' => 1021,
                'nombre'    => 'La Granja',
                'slug'      => Str::slug('Tecnoparque nodo La Granja', '-'),
            ]);

            Entidad::create([
                'id'        => 12,
                'ciudad_id' => 662,
                'nombre'    => 'Pitalito',
                'slug'      => Str::slug('Tecnoparque nodo Pitalito', '-'),
            ]);

            Entidad::create([
                'id'        => 13,
                'ciudad_id' => 455,
                'nombre'    => 'Valledupar',
                'slug'      => Str::slug('Tecnoparque nodo Valledupar', '-'),
            ]);

            Entidad::create([
                'id'        => 14,
                'ciudad_id' => 837,
                'nombre'    => 'Ocaña',
                'slug'      => Str::slug('Tecnoparque nodo Ocaña', '-'),
            ]);

            Entidad::create([
                'id'        => 15,
                'ciudad_id' => 10,
                'nombre'    => 'Angostura',
                'slug'      => Str::slug('Tecnoparque nodo Angostura', '-'),
            ]);

            Entidad::create([
                'id'        => 16,
                'ciudad_id' => 971,
                'nombre'    => 'Socorro',
                'slug'      => Str::slug('Tecnoparque nodo Socorro', '-'),

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
                'slug'      => Str::slug('Centro para la Biodiversidad y el Turismo del Amazonas', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 26,
                'nombre'    => 'Centro de los Recursos Naturales Renovables - La Salada',
                'slug'      => Str::slug('Centro de los Recursos Naturales Renovables - La Salada antioquia', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 45,
                'nombre'    => 'Centro de Formación Minero Ambiental',
                'slug'      => Str::slug('Centro de Formación Minero Ambiental antioquia', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 45,
                'nombre'    => 'Centro de Formación Minero Ambiental',
                'slug'      => Str::slug('Centro de Formación Minero Ambiental', '-'),

            ]);

            Entidad::create([
                'ciudad_id' => 59,
                'nombre'    => 'Centro del Diseño y Manufactura del Cuero',
                'slug'      => Str::slug('Centro del Diseño y Manufactura del Cuero antioquia', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 59,
                'nombre'    => 'Centro de Formación en Diseño, Confección y Moda',
                'slug'      => Str::slug('Centro de Formación en Diseño, Confección y Moda antioquia', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 70,
                'nombre'    => 'Centro para el Desarrollo del Hábitat y la Construcción',
                'slug'      => Str::slug('Centro para el Desarrollo del Hábitat y la Construcción antioquia', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 70,
                'nombre'    => 'Centro de Tecnología de la Manufactura Avanzada',
                'slug'      => Str::slug('Centro de Tecnología de la Manufactura Avanzada antioquia', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 59,
                'nombre'    => 'Centro Tecnológico del Mobiliario',
                'slug'      => Str::slug('Centro Tecnológico del Mobiliario antioquia', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 70,
                'nombre'    => 'Centro de Comercio',
                'slug'      => Str::slug('Centro de Comercio antioquia', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 70,
                'nombre'    => 'Centro de Servicios de Salud',
                'slug'      => Str::slug('Centro de Servicios de Salud antioquia', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 70,
                'nombre'    => 'Centro de Servicios y Gestión Empresarial',
                'slug'      => Str::slug('Centro de Servicios y Gestión Empresarial antioquia', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 33,
                'nombre'    => 'Complejo Tecnológico para la Gestión Agroempresarial',
                'slug'      => Str::slug('Complejo Tecnológico para la Gestión Agroempresarial antioquia', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 81,
                'nombre'    => 'Complejo Tecnológico Minero Agroempresarial',
                'slug'      => Str::slug('Complejo Tecnológico Minero Agroempresarial antioquia', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 86,
                'nombre'    => 'Centro de la Innovación, la Agroindustria y la Aviación',
                'slug'      => Str::slug('Centro de la Innovación, la Agroindustria y la Aviación antioquia', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 13,
                'nombre'    => 'Complejo Tecnológico Agroindustrial, Pecuario y Turístico',
                'slug'      => Str::slug('Complejo Tecnológico Agroindustrial, Pecuario y Turístico antioquia', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 103,
                'nombre'    => 'Complejo Tecnológico, Turístico y Agroindustrial del Occidente Antioqueño',
                'slug'      => Str::slug('Complejo Tecnológico, Turístico y Agroindustrial del Occidente Antioqueño', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 128,
                'nombre'    => 'Centro de Gestión y Desarrollo Agroindustrial de Arauca',
                'slug'      => Str::slug('Centro de Gestión y Desarrollo Agroindustrial de Arauca', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 151,
                'nombre'    => 'Centro para el Desarrollo Agroecológico y Agroindustrial',
                'slug'      => Str::slug('Centro para el Desarrollo Agroecológico y Agroindustrial', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 142,
                'nombre'    => 'Centro Nacional Colombo Alemán',
                'slug'      => Str::slug('Centro Nacional Colombo Alemán', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 136,
                'nombre'    => 'Centro Industrial y de Aviación',
                'slug'      => Str::slug('Centro Industrial y de Aviación', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 136,
                'nombre'    => 'Centro de Comercio y Servicios',
                'slug'      => Str::slug('Centro de Comercio y Servicios', '-'),
            ]);

            /**
             * Centros de Bolivar
             */
            Entidad::create([
                'ciudad_id' => 166,
                'nombre'    => 'Centro Agroempresarial y Minero',
                'slug'      => Str::slug('Centro Agroempresarial y Minero Bolivar', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 166,
                'nombre'    => 'Centro Internacional Náutico, Fluvial y Portuario',
                'slug'      => Str::slug('Centro Internacional Náutico, Fluvial y Portuario Bolivar', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 166,
                'nombre'    => 'Centro para la Industria Petroquímica',
                'slug'      => Str::slug('Centro para la Industria Petroquímica Bolivar', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 166,
                'nombre'    => 'Centro de Comercio y Servicios',
                'slug'      => Str::slug('Centro de Comercio y Servicios bolivar', '-'),
            ]);

            /**
             * Centros de Boyacá
             */
            Entidad::create([
                'ciudad_id' => 234,
                'nombre'    => 'Centro de Desarrollo Agropecuario y Agroindustrial',
                'slug'      => Str::slug('Centro de Comercio y Servicios bolivar boyaca', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 298,
                'nombre'    => 'Centro  Minero',
                'slug'      => Str::slug('Centro  Minero boyaca', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 258,
                'nombre'    => 'Centro de Gestión Administrativa y Fortalecimiento Empresarial',
                'slug'      => Str::slug('Centro de Gestión Administrativa y Fortalecimiento Empresarial boyaca', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 234,
                'nombre'    => 'Centro Industrial de Mantenimiento y Manufactura',
                'slug'      => Str::slug('Centro Industrial de Mantenimiento y Manufactura boyaca', '-'),
            ]);

            /**
             * Centros de Caldas
             */
            Entidad::create([
                'ciudad_id' => 336,
                'nombre'    => 'Centro para la Formación Cafetera',
                'slug'      => Str::slug('Centro para la Formación Cafetera caldas', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 336,
                'nombre'    => 'Centro de Automatización Industrial',
                'slug'      => Str::slug('Centro de Automatización Industria caldas', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 336,
                'nombre'    => 'Centro de Procesos Industriales',
                'slug'      => Str::slug('Centro de Procesos Industriales caldas', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 336,
                'nombre'    => 'Centro de Comercio y Servicios',
                'slug'      => Str::slug('Centro de Comercio y Servicios caldas', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 333,
                'nombre'    => 'Centro Pecuario y Agroempresarial',
                'slug'      => Str::slug('Centro Pecuario y Agroempresarial caldas', '-'),
            ]);

            /**
             * Centros de Caquetá
             */
            Entidad::create([
                'ciudad_id' => 360,
                'nombre'    => 'Centro Tecnológico de la Amazonía',
                'slug'      => Str::slug('Centro Tecnológico de la Amazonía caqueta', '-'),
            ]);

            /**
             * Centros del Casanare
             */
            Entidad::create([
                'ciudad_id' => 388,
                'nombre'    => 'Centro Agroindustrial y Fortalecimiento Empresarial de Casanare',
                'slug'      => Str::slug('Centro Agroindustrial y Fortalecimiento Empresarial de Casanare', '-'),
            ]);

            /**
             * Centros del Cauca
             */
            Entidad::create([
                'ciudad_id' => 414,
                'nombre'    => 'Centro Agropecuario',
                'slug'      => Str::slug('Centro Agropecuario cauca', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 414,
                'nombre'    => 'Centro de Teleinformática y Producción Industrial',
                'slug'      => Str::slug('Centro de Teleinformática y Producción Industrial cauca', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 414,
                'nombre'    => 'Centro de Comercio y Servicios',
                'slug'      => Str::slug('Centro de Comercio y Servicios cauca', '-'),
            ]);

            /**
             * Centros del Cesa
             */

            Entidad::create([
                'ciudad_id' => 455,
                'nombre'    => 'Centro Biotecnológico del Caribe',
                'slug'      => Str::slug('Centro Biotecnológico del Caribe cesar', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 431,
                'nombre'    => 'Centro Agroempresarial',
                'slug'      => Str::slug('Centro Agroempresarial cesar', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 455,
                'nombre'    => 'Centro de Operación y Mantenimiento Minero',
                'slug'      => Str::slug('Centro de Operación y Mantenimiento Minero cesar', '-'),
            ]);
            /**
             * Centros del Chocó
             */
            Entidad::create([
                'ciudad_id' => 477,
                'nombre'    => 'Centro de Recursos Naturales, Industria y Biodiversidad',
                'slug'      => Str::slug('Centro de Recursos Naturales, Industria y Biodiversidad choco', '-'),
            ]);
            /**
             * Centros de Córdoba
             */
            Entidad::create([
                'ciudad_id' => 500,
                'nombre'    => 'Centro Agropecuario y de Biotecnología el Porvenir',
                'slug'      => Str::slug('Centro Agropecuario y de Biotecnología el Porvenir cordoba', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 500,
                'nombre'    => 'Centro de Comercio, Industria y Turismo de Córdoba',
                'slug'      => Str::slug('Centro de Comercio, Industria y Turismo de Córdoba', '-'),
            ]);
            /**
             * Centros de Cundinamarca
             */
            Entidad::create([
                'ciudad_id' => 554,
                'nombre'    => 'Centro de la Tecnología de Diseño y la Productividad Empresarial',
                'slug'      => Str::slug('Centro de la Tecnología de Diseño y la Productividad Empresarial Cundinamarca', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 576,
                'nombre'    => 'Centro de Biotecnología Agropecuaria',
                'slug'      => Str::slug('Centro de Biotecnología Agropecuaria Cundinamarca', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 603,
                'nombre'    => 'Centro Industrial y de Desarrollo Empresarial de Soacha',
                'slug'      => Str::slug('Centro Industrial y de Desarrollo Empresarial de Soacha Cundinamarca', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 628,
                'nombre'    => 'Centro de Desarrollo Agroindustrial y Empresarial',
                'slug'      => Str::slug('Centro de Desarrollo Agroindustrial y Empresarial Cundinamarca', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 536,
                'nombre'    => 'Centro de Desarrollo Agroempresarial',
                'slug'      => Str::slug('Centro de Desarrollo Agroempresarial Cundinamarca', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 547,
                'nombre'    => 'Centro Agroecológico y Empresarial',
                'slug'      => Str::slug('Centro Agroecológico y Empresarial Cundinamarca', '-'),
            ]);

            /**
             * Centros del Distrito Capital
             */
            Entidad::create([
                'ciudad_id' => 525,
                'nombre'    => 'Centro de Tecnologías para la Construcción y la Madera',
                'slug'      => Str::slug('Centro de Tecnologías para la Construcción y la Madera Distrito Capital', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 525,
                'nombre'    => 'Centro de Electricidad, Electrónica y Telecomunicaciones',
                'slug'      => Str::slug('Centro de Electricidad, Electrónica y Telecomunicaciones Distrito Capital', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 525,
                'nombre'    => 'Centro de Gestión Industrial',
                'slug'      => Str::slug('Centro de Gestión Industrial Distrito Capital', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 525,
                'nombre'    => 'Centro de Manufactura en Textil y Cuero',
                'slug'      => Str::slug('Centro de Manufactura en Textil y Cuero Distrito Capital', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 525,
                'nombre'    => 'Centro de Tecnologías del Transporte',
                'slug'      => Str::slug('Centro de Tecnologías del Transporte Distrito Capital', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 525,
                'nombre'    => 'Centro Metalmecánico',
                'slug'      => Str::slug('Centro Metalmecánico Distrito Capital', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 525,
                'nombre'    => 'Centro de Materiales y Ensayos',
                'slug'      => Str::slug('Centro de Materiales y Ensayos Distrito Capital', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 525,
                'nombre'    => 'Centro de Diseño y Metrología',
                'slug'      => Str::slug('Centro de Diseño y Metrología Distrito Capital', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 525,
                'nombre'    => 'Centro para la Industria de la Comunicación Gráfica',
                'slug'      => Str::slug('Centro para la Industria de la Comunicación Gráfica Distrito Capital', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 525,
                'nombre'    => 'Centro de Gestión de Mercados, Logística y Tecnologías de la Información',
                'slug'      => Str::slug('Centro de Gestión de Mercados, Logística y Tecnologías de la Información Distrito Capital', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 525,
                'nombre'    => 'Centro de Formación de Talento Humano en Salud',
                'slug'      => Str::slug('Centro de Formación de Talento Humano en Salud Distrito Capital', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 525,
                'nombre'    => 'Centro de Gestión Administrativa',
                'slug'      => Str::slug('Centro de Gestión Administrativa Distrito Capital', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 525,
                'nombre'    => 'Centro de Servicios Financieros',
                'slug'      => Str::slug('Centro de Servicios Financieros Distrito Capital', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 525,
                'nombre'    => 'Centro Nacional de Hotelería, Turismo y Alimentos',
                'slug'      => Str::slug('Centro Nacional de Hotelería, Turismo y Alimentos Distrito Capital', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 525,
                'nombre'    => 'Centro de Formación en Actividad Física y Cultura',
                'slug'      => Str::slug('Centro de Formación en Actividad Física y Cultura Distrito Capital', '-'),
            ]);

            /**
             * Centros del Guainia
             */

            Entidad::create([
                'ciudad_id' => 634,
                'nombre'    => 'Centro Ambiental y Ecoturistico del Nororiente Amazónico',
                'slug'      => Str::slug('Centro Ambiental y Ecoturistico del Nororiente Amazónico Guainia', '-'),
            ]);

            /**
             * Centros de la Guajira
             */

            Entidad::create([
                'ciudad_id' => 686,
                'nombre'    => 'Centro Industrial y de Energías Alternativas',
                'slug'      => Str::slug('Centro Industrial y de Energías Alternativas Guajira', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 681,
                'nombre'    => 'Centro Agroempresarial y Acuícola',
                'slug'      => Str::slug('Centro Agroempresarial y Acuícola Guajira', '-'),
            ]);

            /**
             * Centros del Guaviare
             */

            Entidad::create([
                'ciudad_id' => 638,
                'nombre'    => 'Centro de Desarrollo Agroindustrial, Turístico y Tecnológico del Guaviare',
                'slug'      => Str::slug('Centro de Desarrollo Agroindustrial, Turístico y Tecnológico del Guaviare', '-'),
            ]);

            /**
             * Centros de formación del Huila
             */

            Entidad::create([
                'ciudad_id' => 645,
                'nombre'    => 'Centro de Formación Agroindustrial',
                'slug'      => Str::slug('Centro de Formación Agroindustrial Huila', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 648,
                'nombre'    => 'Centro Agroempresarial y Desarrollo Pecuario del Huila',
                'slug'      => Str::slug('Centro Agroempresarial y Desarrollo Pecuario del Huila', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 654,
                'nombre'    => 'Centro de Desarrollo Agroempresarial y Turístico del Huila',
                'slug'      => Str::slug('Centro de Desarrollo Agroempresarial y Turístico del Huila', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 655,
                'nombre'    => 'Centro de la Industria, la Empresa y los Servicios',
                'slug'      => Str::slug('Centro de la Industria, la Empresa y los Servicios del Huila', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 662,
                'nombre'    => 'Centro de Gestión y Desarrollo Sostenible Surcolombiano',
                'slug'      => Str::slug('Centro de Gestión y Desarrollo Sostenible Surcolombiano del Huila', '-'),
            ]);

            /**
             * Centros de Formación del Magdalena
             */

            Entidad::create([
                'ciudad_id' => 716,
                'nombre'    => 'Centro Acuícola y Agroindustrial de Gaira',
                'slug'      => Str::slug('Centro Acuícola y Agroindustrial de Gaira del Magdalena', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 716,
                'nombre'    => 'Centro de Logística y Promoción Ecoturística del Magdalena',
                'slug'      => Str::slug('Centro de Logística y Promoción Ecoturística del Magdalena', '-'),
            ]);

            /**
             * Centros de Formación del Meta
             */

            Entidad::create([
                'ciudad_id' => 731,
                'nombre'    => 'Centro Agroindustrial del Meta',
                'slug'      => Str::slug('Centro Agroindustrial del Meta', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 748,
                'nombre'    => 'Centro de Industria y Servicios del Meta',
                'slug'      => Str::slug('Centro de Industria y Servicios del Meta', '-'),
            ]);

            /**
             * Centros de Formación de Nariño
             */

            Entidad::create([
                'ciudad_id' => 778,
                'nombre'    => 'Centro Sur Colombiano de Logística Internacional',
                'slug'      => Str::slug('Centro Sur Colombiano de Logística Internacional del Nariño', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 811,
                'nombre'    => 'Centro Agroindustrial y Pesquero de la Costa Pacífica',
                'slug'      => Str::slug('Centro Agroindustrial y Pesquero de la Costa Pacífica Nariño', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 801,
                'nombre'    => 'Centro Internacional de Producción Limpia - Lope',
                'slug'      => Str::slug('Centro Internacional de Producción Limpia - Lope Nariño', '-'),
            ]);

            /**
             * Centros de Formación del Norte del Santander
             */

            Entidad::create([
                'ciudad_id' => 823,
                'nombre'    => 'Centro de Formación para el Desarrollo Rural y Minero',
                'slug'      => Str::slug('Centro de Formación para el Desarrollo Rural y Minero Norte del Santander', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 837,
                'nombre'    => 'Centro de la Industria, la Empresa y los Servicios',
                'slug'      => Str::slug('Centro de la Industria, la Empresa y los Servicios Norte del Santander', '-'),
            ]);

            /**
             * Centros de Formación del Putumayo
             */

            Entidad::create([
                'ciudad_id' => 857,
                'nombre'    => 'Centro Agroforestal y Acuícola Arapaima',
                'slug'      => Str::slug('Centro Agroforestal y Acuícola Arapaima Putumayo', '-'),
            ]);

            /**
             * Centros de Formación del Quindio
             */

            Entidad::create([
                'ciudad_id' => 867,
                'nombre'    => 'Centro Agroindustrial',
                'slug'      => Str::slug('Centro Agroindustrial Quindio', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 867,
                'nombre'    => 'Centro para el Desarrollo Tecnológico de la Construcción y la Industria',
                'slug'      => Str::slug('Centro para el Desarrollo Tecnológico de la Construcción y la Industria Quindio', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 867,
                'nombre'    => 'Centro de Comercio y Turismo',
                'slug'      => Str::slug('Centro de Comercio y Turismo Quindio', '-'),
            ]);

            /**
             * Centros de Formarción del Risaralda
             */

            Entidad::create([
                'ciudad_id' => 888,
                'nombre'    => 'Centro Atención Sector Agropecuario',
                'slug'      => Str::slug('Centro de Comercio y Turismo Risaralda', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 882,
                'nombre'    => 'Centro de Diseño e Innovación Tecnológica Industrial',
                'slug'      => Str::slug('Centro de Diseño e Innovación Tecnológica Industrial Risaralda', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 888,
                'nombre'    => 'Centro de Comercio y Servicios',
                'slug'      => Str::slug('Centro de Comercio y Servicios Risaralda', '-'),
            ]);

            /**
             * Centros de formación de San Andrés
             */

            Entidad::create([
                'ciudad_id' => 893,
                'nombre'    => 'Centro de Formación Turística, Gente de Mar y de Servicio',
                'slug'      => Str::slug('Centro de Comercio y Servicios San Andrés', '-'),
            ]);

            /**
             * Centros de formación de Santander
             */

            Entidad::create([
                'ciudad_id' => 953,
                'nombre'    => 'Centro Atención Sector Agropecuario',
                'slug'      => Str::slug('Centro Atención Sector Agropecuario Santander', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 928,
                'nombre'    => 'Centro Industrial de Mantenimiento Integral',
                'slug'      => Str::slug('Centro Industrial de Mantenimiento Integral Santander', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 925,
                'nombre'    => 'Centro Industrial del Diseño y la Manufactura',
                'slug'      => Str::slug('Centro Industrial del Diseño y la Manufactura Santander', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 902,
                'nombre'    => 'Centro de Servicios Empresariales y Turísticos',
                'slug'      => Str::slug('Centro de Servicios Empresariales y Turísticos Santander', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 899,
                'nombre'    => 'Centro Industrial y del Desarrollo Tecnológico',
                'slug'      => Str::slug('Centro Industrial y del Desarrollo Tecnológico Santander', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 963,
                'nombre'    => 'Centro Agroturístico',
                'slug'      => Str::slug('Centro Agroturístico Santander', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 947,
                'nombre'    => 'Centro Agroempresarial y Turístico de los Andes',
                'slug'      => Str::slug('Centro Agroempresarial y Turístico de los Andes Santander', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 897,
                'nombre'    => 'Centro de Gestión Agroempresarial del Oriente',
                'slug'      => Str::slug('Centro de Gestión Agroempresarial del Oriente Santander', '-'),
            ]);

            /**
             * Centros de Formación de Sucre
             */

            Entidad::create([
                'ciudad_id' => 1002,
                'nombre'    => 'Centro de la Innovación, la Tecnología y los Servicios',
                'slug'      => Str::slug('Centro de la Innovación, la Tecnología y los Servicios Sucre', '-'),
            ]);

            /**
             * Centros de Formación del Tolima
             */

            Entidad::create([
                'ciudad_id' => 1021,
                'nombre'    => 'Centro Agropecuario la Granja',
                'slug'      => Str::slug('Centro de la Innovación, la Tecnología y los Servicios Tolima', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 1028,
                'nombre'    => 'Centro de Industria y Construcción',
                'slug'      => Str::slug('Centro de Industria y Construcción Tolima', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 1028,
                'nombre'    => 'Centro de Comercio y Servicios',
                'slug'      => Str::slug('Centro de Comercio y Servicios Tolima', '-'),
            ]);

            /**
             * Centros de Formación del Valle
             */

            Entidad::create([
                'ciudad_id' => 1060,
                'nombre'    => 'Centro Agropecuario de Buga',
                'slug'      => Str::slug('Centro Agropecuario de Buga Valle', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 1089,
                'nombre'    => 'Centro Latinoamericano de Especies Menores',
                'slug'      => Str::slug('Centro Latinoamericano de Especies Menores Valle', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 1059,
                'nombre'    => 'Centro Náutico Pesquero de Buenaventura',
                'slug'      => Str::slug('Centro Náutico Pesquero de Buenaventura Valle', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 1064,
                'nombre'    => 'Centro de Electricidad y Automatización Industrial -CEAI',
                'slug'      => Str::slug('Centro de Electricidad y Automatización Industrial -CEAI Valle', '-'),

            ]);

            Entidad::create([
                'ciudad_id' => 1064,
                'nombre'    => 'Centro de la Construcción',
                'slug'      => Str::slug('Centro de la Construcción Valle', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 1064,
                'nombre'    => 'Centro de Diseño Tecnológico Industrial',
                'slug'      => Str::slug('Centro de Diseño Tecnológico Industrial Valle', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 1064,
                'nombre'    => 'Centro Nacional de Asistencia Técnica a la Industria -ASTIN',
                'slug'      => Str::slug('Centro Nacional de Asistencia Técnica a la Industria -ASTIN Valle', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 1064,
                'nombre'    => 'Centro de Gestión Tecnológica de Servicios',
                'slug'      => Str::slug('Centro de Gestión Tecnológica de Servicios Valle', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 1066,
                'nombre'    => 'Centro de Tecnologías Agroindustriales',
                'slug'      => Str::slug('Centro de Tecnologías Agroindustriales Valle', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 1080,
                'nombre'    => 'Centro de Biotecnología Industrial',
                'slug'      => Str::slug('Centro de Biotecnología Industrial Valle', '-'),

            ]);

            /**
             * Centros de Formación del Vaupés
             */

            Entidad::create([
                'ciudad_id' => 1097,
                'nombre'    => 'Centro Agropecuario y de Servicios Ambientales "Jiri-jirimo"',
                'slug'      => Str::slug('Centro Agropecuario y de Servicios Ambientales "Jiri-jirimo" Vaupés', '-'),
            ]);

            /**
             * Centros de Formación del Vichada
             */

            Entidad::create([
                'ciudad_id' => 1101,
                'nombre'    => 'Centro de Producción y Transformación Agroindustrial de la Orinoquía',
                'slug'      => Str::slug('Centro de Producción y Transformación Agroindustrial de la Orinoquía Vichada', '-'),
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
                'slug'      => Str::slug('TECNOACADEMIA BUCARAMANGA', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 1064,
                'nombre'    => 'TECNOACADEMIA CALI',
                'slug'      => Str::slug('TECNOACADEMIA CALI', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 525,
                'nombre'    => 'TECNOACADEMIA CAZUCA',
                'slug'      => Str::slug('TECNOACADEMIA CAZUCA', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 1028,
                'nombre'    => 'TECNOACADEMIA IBAGUE',
                'slug'      => Str::slug('TECNOACADEMIA IBAGUE', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 336,
                'nombre'    => 'TECNOACADEMIA MANIZALES',
                'slug'      => Str::slug('TECNOACADEMIA MANIZALES', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 70,
                'nombre'    => 'TECNOACADEMIA MEDELLIN',
                'slug'      => Str::slug('TECNOACADEMIA MEDELLIN', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 655,
                'nombre'    => 'TECNOACADEMIA NEIVA',
                'slug'      => Str::slug('TECNOACADEMIA NEIVA', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 888,
                'nombre'    => 'TECNOACADEMIA PEREIRA',
                'slug'      => Str::slug('TECNOACADEMIA PEREIRA', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 801,
                'nombre'    => 'TECNOACADEMIA TUQUERRES',
                'slug'      => Str::slug('TECNOACADEMIA TUQUERRES', '-'),
            ]);

            Entidad::create([
                'ciudad_id' => 823,
                'nombre'    => 'TECNOACADEMIA CUCÚTA',
                'slug'      => Str::slug('TECNOACADEMIA CUCÚTA', '-'),
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
                'id'        => 1,
                'ciudad_id' => 431,
                'nombre'    => 'No Aplica',
                'slug'      => Str::slug('No Aplica', '-'),
            ]);
            factory(Entidad::class, 100)->create();
        }
    }
}
