<?php

use App\Models\{Centro, Regional, Entidad};
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
      'regional_id'   => Regional::where('nombre', 'AMAZONAS')->first()->id,
      'entidad_id'    => Entidad::where('nombre', 'Centro para la Biodiversidad y el Turismo del Amazonas')->first()->id,
      'codigo_centro' => 9517,
    ]);

    Centro::create([
      'regional_id'   => Regional::where('nombre', 'ANTIOQUIA')->first()->id,
      'entidad_id'    => Entidad::where('nombre', 'Centro de los Recursos Naturales Renovables - La Salada')->first()->id,
      'codigo_centro' => 9101,
    ]);

    Centro::create([
      'regional_id'   => Regional::where('nombre', 'ANTIOQUIA')->first()->id,
      'entidad_id'    => Entidad::where('nombre', 'Centro de Formación Minero Ambiental')->first()->id,
      'codigo_centro' => 9127,
    ]);

    Centro::create([
      'regional_id'   => Regional::where('nombre', 'ANTIOQUIA')->first()->id,
      'entidad_id'    => Entidad::where('nombre', 'Centro del Diseño y Manufactura del Cuero')->first()->id,
      'codigo_centro' => 9201,
    ]);

    Centro::create([
      'regional_id'   => Regional::where('nombre', 'ANTIOQUIA')->first()->id,
      'entidad_id'    => Entidad::where('nombre', 'Centro de Formación en Diseño, Confección y Moda')->first()->id,
      'codigo_centro' => 9202,
    ]);

    Centro::create([
      'regional_id'   => Regional::where('nombre', 'ANTIOQUIA')->first()->id,
      'entidad_id'    => Entidad::where('nombre', 'Centro para el Desarrollo del Hábitat y la Construcción')->first()->id,
      'codigo_centro' => 9203,
    ]);

    Centro::create([
    'regional_id'   => Regional::where('nombre', 'ANTIOQUIA')->first()->id,
    'entidad_id'    => Entidad::where('nombre', 'Centro de Tecnología de la Manufactura Avanzada')->first()->id,
    'codigo_centro' => 9204,
    ]);

    Centro::create([
    'regional_id'   => Regional::where('nombre', 'ANTIOQUIA')->first()->id,
    'entidad_id'    => Entidad::where('nombre', 'Centro Tecnológico del Mobiliario')->first()->id,
    'codigo_centro' => 9205,
    ]);

    Centro::create([
    'regional_id'   => Regional::where('nombre', 'ANTIOQUIA')->first()->id,
    'entidad_id'    => Entidad::where('nombre', 'Centro de Comercio')->first()->id,
    'codigo_centro' => 9301,
    ]);

    Centro::create([
    'regional_id'   => Regional::where('nombre', 'ANTIOQUIA')->first()->id,
    'entidad_id'    => Entidad::where('nombre', 'Centro de Servicios de Salud')->first()->id,
    'codigo_centro' => 9401,
    ]);

    Centro::create([
    'regional_id'   => Regional::where('nombre', 'ANTIOQUIA')->first()->id,
    'entidad_id'    => Entidad::where('nombre', 'Centro de Servicios y Gestión Empresarial')->first()->id,
    'codigo_centro' => 9402,
    ]);

    Centro::create([
    'regional_id'   => Regional::where('nombre', 'ANTIOQUIA')->first()->id,
    'entidad_id'    => Entidad::where('nombre', 'Complejo Tecnológico para la Gestión Agroempresarial')->first()->id,
    'codigo_centro' => 9501,
    ]);

    Centro::create([
    'regional_id'   => Regional::where('nombre', 'ANTIOQUIA')->first()->id,
    'entidad_id'    => Entidad::where('nombre', 'Complejo Tecnológico Minero Agroempresarial')->first()->id,
    'codigo_centro' => 9502,
    ]);

    Centro::create([
    'regional_id'   => Regional::where('nombre', 'ANTIOQUIA')->first()->id,
    'entidad_id'    => Entidad::where('nombre', 'Centro de la Innovación, la Agroindustria y la Aviación')->first()->id,
    'codigo_centro' => 9503,
    ]);

    Centro::create([
    'regional_id'   => Regional::where('nombre', 'ANTIOQUIA')->first()->id,
    'entidad_id'    => Entidad::where('nombre', 'Complejo Tecnológico Agroindustrial, Pecuario y Turístico')->first()->id,
    'codigo_centro' => 9504,
    ]);

    Centro::create([
    'regional_id'   => Regional::where('nombre', 'ANTIOQUIA')->first()->id,
    'entidad_id'    => Entidad::where('nombre', 'Complejo Tecnológico, Turístico y Agroindustrial del Occidente Antioqueño')->first()->id,
    'codigo_centro' => 9549,
    ]);

    Centro::create([
    'regional_id'   => Regional::where('nombre', 'ARAUCA')->first()->id,
    'entidad_id'    => Entidad::where('nombre', 'Centro de Gestión y Desarrollo Agroindustrial de Arauca')->first()->id,
    'codigo_centro' => 9530,
    ]);

    Centro::create([
    'regional_id'   => Regional::where('nombre', 'ATLANTICO')->first()->id,
    'entidad_id'    => Entidad::where('nombre', 'Centro para el Desarrollo Agroecológico y Agroindustrial')->first()->id,
    'codigo_centro' => 9103,
    ]);

    Centro::create([
    'regional_id'   => Regional::where('nombre', 'ATLANTICO')->first()->id,
    'entidad_id'    => Entidad::where('nombre', 'Centro Nacional Colombo Alemán')->first()->id,
    'codigo_centro' => 9207,
    ]);

    Centro::create([
    'regional_id'   => Regional::where('nombre', 'ATLANTICO')->first()->id,
    'entidad_id'    => Entidad::where('nombre', 'Centro Industrial y de Aviación')->first()->id,
    'codigo_centro' => 9208,
    ]);

    Centro::create([
    'regional_id'   => Regional::where('nombre', 'ATLANTICO')->first()->id,
    'entidad_id'    => Entidad::where('nombre', 'Centro de Comercio y Servicios')->first()->id,
    'codigo_centro' => 9302,
    ]);

    /**
    * Centros de Formación de Bolivar
    */
    Centro::create([
    'regional_id'   => Regional::where('nombre', 'BOLIVAR')->first()->id,
    'entidad_id'    => Entidad::where('nombre', 'Centro Agroempresarial y Minero')->first()->id,
    'codigo_centro' => 9104,
    ]);

    Centro::create([
    'regional_id'   => Regional::where('nombre', 'BOLIVAR')->first()->id,
    'entidad_id'    => Entidad::where('nombre', 'Centro Internacional Náutico, Fluvial y Portuario')->first()->id,
    'codigo_centro' => 9105,
    ]);

    Centro::create([
    'regional_id'   => Regional::where('nombre', 'BOLIVAR')->first()->id,
    'entidad_id'    => Entidad::where('nombre', 'Centro para la Industria Petroquímica')->first()->id,
    'codigo_centro' => 9218,
    ]);

    Centro::create([
    'regional_id'   => Regional::where('nombre', 'BOLIVAR')->first()->id,
    'entidad_id'    => Entidad::where('nombre', 'Centro de Comercio y Servicios')->first()->id,
    'codigo_centro' => 9304,
    ]);

    /**
    * Centros de Formaci´pn de Boyacá
    */
    Centro::create([
    'regional_id'   => Regional::where('nombre', 'BOYACA')->first()->id,
    'entidad_id'    => Entidad::where('nombre', 'Centro de Desarrollo Agropecuario y Agroindustrial')->first()->id,
    'codigo_centro' => 9110,
    ]);

    Centro::create([
    'regional_id'   => Regional::where('nombre', 'BOYACA')->first()->id,
    'entidad_id'    => Entidad::where('nombre', 'Centro  Minero')->first()->id,
    'codigo_centro' => 9111,
    ]);

    Centro::create([
    'regional_id'   => Regional::where('nombre', 'BOYACA')->first()->id,
    'entidad_id'    => Entidad::where('nombre', 'Centro de Gestión Administrativa y Fortalecimiento Empresarial')->first()->id,
    'codigo_centro' => 9305,
    ]);

    Centro::create([
    'regional_id'   => Regional::where('nombre', 'BOYACA')->first()->id,
    'entidad_id'    => Entidad::where('nombre', 'Centro Industrial de Mantenimiento y Manufactura')->first()->id,
    'codigo_centro' => 9514,
    ]);

    /**
    * Centros de Formación de Caldas
    */

    Centro::create([
    'regional_id'   => Regional::where('nombre', 'CALDAS')->first()->id,
    'entidad_id'    => Entidad::where('nombre', 'Centro para la Formación Cafetera')->first()->id,
    'codigo_centro' => 9112,
    ]);

    Centro::create([
    'regional_id'   => Regional::where('nombre', 'CALDAS')->first()->id,
    'entidad_id'    => Entidad::where('nombre', 'Centro de Automatización Industrial')->first()->id,
    'codigo_centro' => 9219,
    ]);

    Centro::create([
    'regional_id'   => Regional::where('nombre', 'CALDAS')->first()->id,
    'entidad_id'    => Entidad::where('nombre', 'Centro de Procesos Industriales')->first()->id,
    'codigo_centro' => 9220,
    ]);

    Centro::create([
    'regional_id'   => Regional::where('nombre', 'CALDAS')->first()->id,
    'entidad_id'    => Entidad::where('nombre', 'Centro de Comercio y Servicios')->first()->id,
    'codigo_centro' => 9306,
    ]);

    Centro::create([
    'regional_id'   => Regional::where('nombre', 'CALDAS')->first()->id,
    'entidad_id'    => Entidad::where('nombre', 'Centro Pecuario y Agroempresarial')->first()->id,
    'codigo_centro' => 9515,
    ]);
    /**
    * Centros de Foramción del Caquetá
    */
    Centro::create([
    'regional_id'   => Regional::where('nombre', 'CAQUETA')->first()->id,
    'entidad_id'    => Entidad::where('nombre', 'Centro Tecnológico de la Amazonía')->first()->id,
    'codigo_centro' => 9516,
    ]);

    /**
    * Centros de Formación del Casanare
    */
    Centro::create([
    'regional_id'   => Regional::where('nombre', 'CASANARE')->first()->id,
    'entidad_id'    => Entidad::where('nombre', 'Centro Agroindustrial y Fortalecimiento Empresarial de Casanare')->first()->id,
    'codigo_centro' => 9519,
    ]);

    /**
    * Centros de Formación del Cauca
    */
    Centro::create([
    'regional_id'   => Regional::where('nombre', 'CAUCA')->first()->id,
    'entidad_id'    => Entidad::where('nombre', 'Centro Agropecuario')->first()->id,
    'codigo_centro' => 9113,
    ]);

    Centro::create([
    'regional_id'   => Regional::where('nombre', 'CAUCA')->first()->id,
    'entidad_id'    => Entidad::where('nombre', 'Centro de Teleinformática y Producción Industrial')->first()->id,
    'codigo_centro' => 9221,
    ]);

    Centro::create([
    'regional_id'   => Regional::where('nombre', 'CAUCA')->first()->id,
    'entidad_id'    => Entidad::where('nombre', 'Centro de Comercio y Servicios')->first()->id,
    'codigo_centro' => 9307,
    ]);
    /**
    * Centros de Formación del Cesar
    */
    Centro::create([
    'regional_id'   => Regional::where('nombre', 'CESAR')->first()->id,
    'entidad_id'    => Entidad::where('nombre', 'Centro Biotecnológico del Caribe')->first()->id,
    'codigo_centro' => 9114,
    ]);

    Centro::create([
    'regional_id'   => Regional::where('nombre', 'CESAR')->first()->id,
    'entidad_id'    => Entidad::where('nombre', 'Centro Agroempresarial')->first()->id,
    'codigo_centro' => 9520,
    ]);

    Centro::create([
    'regional_id'   => Regional::where('nombre', 'CESAR')->first()->id,
    'entidad_id'    => Entidad::where('nombre', 'Centro de Operación y Mantenimiento Minero')->first()->id,
    'codigo_centro' => 9521,
    ]);
    /**
    * Centros de Formación del Chocó
    */
    Centro::create([
    'regional_id'   => Regional::where('nombre', 'CHOCO')->first()->id,
    'entidad_id'    => Entidad::where('nombre', 'Centro de Recursos Naturales, Industria y Biodiversidad')->first()->id,
    'codigo_centro' => 9522,
    ]);
    /**
    * Centros de Formación de Córdoba
    */
    Centro::create([
    'regional_id'   => Regional::where('nombre', 'CORDOBA')->first()->id,
    'entidad_id'    => Entidad::where('nombre', 'Centro Agropecuario y de Biotecnología el Porvenir')->first()->id,
    'codigo_centro' => 9115,
    ]);
    Centro::create([
    'regional_id'   => Regional::where('nombre', 'CORDOBA')->first()->id,
    'entidad_id'    => Entidad::where('nombre', 'Centro de Comercio, Industria y Turismo de Córdoba')->first()->id,
    'codigo_centro' => 9523,
    ]);
    /**
    * Centros de Formación de Cundinamarca
    */
    Centro::create([
    'regional_id'   => Regional::where('nombre', 'CUNDINAMARCA')->first()->id,
    'entidad_id'    => Entidad::where('nombre', 'Centro de la Tecnología de Diseño y la Productividad Empresarial')->first()->id,
    'codigo_centro' => 9511,
    ]);

    Centro::create([
    'regional_id'   => Regional::where('nombre', 'CUNDINAMARCA')->first()->id,
    'entidad_id'    => Entidad::where('nombre', 'Centro de Biotecnología Agropecuaria')->first()->id,
    'codigo_centro' => 9512,
    ]);

    Centro::create([
    'regional_id'   => Regional::where('nombre', 'CUNDINAMARCA')->first()->id,
    'entidad_id'    => Entidad::where('nombre', 'Centro Industrial y de Desarrollo Empresarial de Soacha')->first()->id,
    'codigo_centro' => 9232,
    ]);

    Centro::create([
    'regional_id'   => Regional::where('nombre', 'CUNDINAMARCA')->first()->id,
    'entidad_id'    => Entidad::where('nombre', 'Centro de Desarrollo Agroindustrial y Empresarial')->first()->id,
    'codigo_centro' => 9509,
    ]);

    Centro::create([
    'regional_id'   => Regional::where('nombre', 'CUNDINAMARCA')->first()->id,
    'entidad_id'    => Entidad::where('nombre', 'Centro de Desarrollo Agroempresarial')->first()->id,
    'codigo_centro' => 9513,
    ]);

    Centro::create([
    'regional_id'   => Regional::where('nombre', 'CUNDINAMARCA')->first()->id,
    'entidad_id'    => Entidad::where('nombre', 'Centro Agroecológico y Empresarial')->first()->id,
    'codigo_centro' => 9510,
    ]);
    /**
    * Centros de Formación del Distrito Capital
    */

    Centro::create([
    'regional_id'   => Regional::where('nombre', 'DISTRITO CAPITAL')->first()->id,
    'entidad_id'    => Entidad::where('nombre', 'Centro de Tecnologías para la Construcción y la Madera')->first()->id,
    'codigo_centro' => 9209,
    ]);

    Centro::create([
    'regional_id'   => Regional::where('nombre', 'DISTRITO CAPITAL')->first()->id,
    'entidad_id'    => Entidad::where('nombre', 'Centro de Electricidad, Electrónica y Telecomunicaciones')->first()->id,
    'codigo_centro' => 9210,
    ]);

    Centro::create([
    'regional_id'   => Regional::where('nombre', 'DISTRITO CAPITAL')->first()->id,
    'entidad_id'    => Entidad::where('nombre', 'Centro de Gestión Industrial')->first()->id,
    'codigo_centro' => 9211,
    ]);

    Centro::create([
    'regional_id'   => Regional::where('nombre', 'DISTRITO CAPITAL')->first()->id,
    'entidad_id'    => Entidad::where('nombre', 'Centro de Manufactura en Textil y Cuero')->first()->id,
    'codigo_centro' => 9212,
    ]);

    Centro::create([
    'regional_id'   => Regional::where('nombre', 'DISTRITO CAPITAL')->first()->id,
    'entidad_id'    => Entidad::where('nombre', 'Centro de Tecnologías del Transporte')->first()->id,
    'codigo_centro' => 9213,
    ]);

    Centro::create([
    'regional_id'   => Regional::where('nombre', 'DISTRITO CAPITAL')->first()->id,
    'entidad_id'    => Entidad::where('nombre', 'Centro Metalmecánico')->first()->id,
    'codigo_centro' => 9214,
    ]);

    Centro::create([
    'regional_id'   => Regional::where('nombre', 'DISTRITO CAPITAL')->first()->id,
    'entidad_id'    => Entidad::where('nombre', 'Centro de Materiales y Ensayos')->first()->id,
    'codigo_centro' => 9215,
    ]);

    Centro::create([
    'regional_id'   => Regional::where('nombre', 'DISTRITO CAPITAL')->first()->id,
    'entidad_id'    => Entidad::where('nombre', 'Centro de Diseño y Metrología')->first()->id,
    'codigo_centro' => 9216,
    ]);

    Centro::create([
    'regional_id'   => Regional::where('nombre', 'DISTRITO CAPITAL')->first()->id,
    'entidad_id'    => Entidad::where('nombre', 'Centro para la Industria de la Comunicación Gráfica')->first()->id,
    'codigo_centro' => 9217,
    ]);

    Centro::create([
    'regional_id'   => Regional::where('nombre', 'DISTRITO CAPITAL')->first()->id,
    'entidad_id'    => Entidad::where('nombre', 'Centro de Gestión de Mercados, Logística y Tecnologías de la Información')->first()->id,
    'codigo_centro' => 9303,
    ]);

    Centro::create([
    'regional_id'   => Regional::where('nombre', 'DISTRITO CAPITAL')->first()->id,
    'entidad_id'    => Entidad::where('nombre', 'Centro de Formación de Talento Humano en Salud')->first()->id,
    'codigo_centro' => 9403,
    ]);

    Centro::create([
    'regional_id'   => Regional::where('nombre', 'DISTRITO CAPITAL')->first()->id,
    'entidad_id'    => Entidad::where('nombre', 'Centro de Gestión Administrativa')->first()->id,
    'codigo_centro' => 9404,
    ]);

    Centro::create([
    'regional_id'   => Regional::where('nombre', 'DISTRITO CAPITAL')->first()->id,
    'entidad_id'    => Entidad::where('nombre', 'Centro de Servicios Financieros')->first()->id,
    'codigo_centro' => 9405,
    ]);

    Centro::create([
    'regional_id'   => Regional::where('nombre', 'DISTRITO CAPITAL')->first()->id,
    'entidad_id'    => Entidad::where('nombre', 'Centro Nacional de Hotelería, Turismo y Alimentos')->first()->id,
    'codigo_centro' => 9406,
    ]);

    Centro::create([
    'regional_id'   => Regional::where('nombre', 'DISTRITO CAPITAL')->first()->id,
    'entidad_id'    => Entidad::where('nombre', 'Centro de Formación en Actividad Física y Cultura')->first()->id,
    'codigo_centro' => 9508,
    ]);

    /**
     * Centros de formación del Guainia
    */
    Centro::create([
      'regional_id'   => Regional::where('nombre', 'GUAINIA')->first()->id,
      'entidad_id'    => Entidad::where('nombre', 'Centro Ambiental y Ecoturistico del Nororiente Amazónico')->first()->id,
      'codigo_centro' => 9547,
    ]);

    /**
    * Centros de Formación de La Guajira
    */

    Centro::create([
      'regional_id'   => Regional::where('nombre', 'GUAJIRA')->first()->id,
      'entidad_id'    => Entidad::where('nombre', 'Centro Industrial y de Energías Alternativas')->first()->id,
      'codigo_centro' => 9222,
    ]);

    Centro::create([
      'regional_id'   => Regional::where('nombre', 'GUAJIRA')->first()->id,
      'entidad_id'    => Entidad::where('nombre', 'Centro Agroempresarial y Acuícola')->first()->id,
      'codigo_centro' => 9524,
    ]);

    /**
     * Centros de Formación del Guaviare
     */

     Centro::create([
       'regional_id'   => Regional::where('nombre', 'GUAVIARE')->first()->id,
       'entidad_id'    => Entidad::where('nombre', 'Centro de Desarrollo Agroindustrial, Turístico y Tecnológico del Guaviare')->first()->id,
       'codigo_centro' => 9533,
     ]);

     /**
     * Centros de Formación del Huila
     */

     Centro::create([
       'regional_id'   => Regional::where('nombre', 'HUILA')->first()->id,
       'entidad_id'    => Entidad::where('nombre', 'Centro de Formación Agroindustrial')->first()->id,
       'codigo_centro' => 9116,
     ]);

     Centro::create([
       'regional_id'   => Regional::where('nombre', 'HUILA')->first()->id,
       'entidad_id'    => Entidad::where('nombre', 'Centro Agroempresarial y Desarrollo Pecuario del Huila')->first()->id,
       'codigo_centro' => 9525,
     ]);

     Centro::create([
       'regional_id'   => Regional::where('nombre', 'HUILA')->first()->id,
       'entidad_id'    => Entidad::where('nombre', 'Centro de Desarrollo Agroempresarial y Turístico del Huila')->first()->id,
       'codigo_centro' => 9526,
     ]);

     Centro::create([
       'regional_id'   => Regional::where('nombre', 'HUILA')->first()->id,
       'entidad_id'    => Entidad::where('nombre', 'Centro de la Industria, la Empresa y los Servicios')->first()->id,
       'codigo_centro' => 9527,
     ]);

     Centro::create([
       'regional_id'   => Regional::where('nombre', 'HUILA')->first()->id,
       'entidad_id'    => Entidad::where('nombre', 'Centro de Gestión y Desarrollo Sostenible Surcolombiano')->first()->id,
       'codigo_centro' => 9528,
     ]);

     /**
     * Centros de Formaci´pn del Magdalena
     */

     Centro::create([
       'regional_id'   => Regional::where('nombre', 'MAGDALENA')->first()->id,
       'entidad_id'    => Entidad::where('nombre', 'Centro Acuícola y Agroindustrial de Gaira')->first()->id,
       'codigo_centro' => 9118,
     ]);

     Centro::create([
       'regional_id'   => Regional::where('nombre', 'MAGDALENA')->first()->id,
       'entidad_id'    => Entidad::where('nombre', 'Centro de Logística y Promoción Ecoturística del Magdalena')->first()->id,
       'codigo_centro' => 9529,
     ]);

     /**
     * Centros de Formación del Meta
     */
     Centro::create([
       'regional_id'   => Regional::where('nombre', 'META')->first()->id,
       'entidad_id'    => Entidad::where('nombre', 'Centro Agroindustrial del Meta')->first()->id,
       'codigo_centro' => 9117,
     ]);

     Centro::create([
       'regional_id'   => Regional::where('nombre', 'META')->first()->id,
       'entidad_id'    => Entidad::where('nombre', 'Centro de Industria y Servicios del Meta')->first()->id,
       'codigo_centro' => 9532,
     ]);

     /**
     * centros de Formación de Nariño
     */

     Centro::create([
       'regional_id'   => Regional::where('nombre', 'NARIÑO')->first()->id,
       'entidad_id'    => Entidad::where('nombre', 'Centro Sur Colombiano de Logística Internacional')->first()->id,
       'codigo_centro' => 9534,
     ]);

     Centro::create([
       'regional_id'   => Regional::where('nombre', 'NARIÑO')->first()->id,
       'entidad_id'    => Entidad::where('nombre', 'Centro Agroindustrial y Pesquero de la Costa Pacífica')->first()->id,
       'codigo_centro' => 9535,
     ]);

     Centro::create([
       'regional_id'   => Regional::where('nombre', 'NARIÑO')->first()->id,
       'entidad_id'    => Entidad::where('nombre', 'Centro Internacional de Producción Limpia - Lope')->first()->id,
       'codigo_centro' => 9536,
     ]);

     /**
     * Centros de Formación del Norte de Santander
     */

     Centro::create([
       'regional_id'   => Regional::where('nombre', 'NORTE S/DER')->first()->id,
       'entidad_id'    => Entidad::where('nombre', 'Centro de Formación para el Desarrollo Rural y Minero')->first()->id,
       'codigo_centro' => 9119,
     ]);

     Centro::create([
       'regional_id'   => Regional::where('nombre', 'NORTE S/DER')->first()->id,
       'entidad_id'    => Entidad::where('nombre', 'Centro de la Industria, la Empresa y los Servicios')->first()->id,
       'codigo_centro' => 9537,
     ]);

     /**
     * Centros de Formación del Putumayo
     */

     Centro::create([
       'regional_id'   => Regional::where('nombre', 'PUTUMAYO')->first()->id,
       'entidad_id'    => Entidad::where('nombre', 'Centro Agroforestal y Acuícola Arapaima')->first()->id,
       'codigo_centro' => 9518,
     ]);

     /**
     * Centros de Formación del Quindio
     */

     Centro::create([
       'regional_id'   => Regional::where('nombre', 'QUINDIO')->first()->id,
       'entidad_id'    => Entidad::where('nombre', 'Centro Agroindustrial')->first()->id,
       'codigo_centro' => 9120,
     ]);

     Centro::create([
       'regional_id'   => Regional::where('nombre', 'QUINDIO')->first()->id,
       'entidad_id'    => Entidad::where('nombre', 'Centro para el Desarrollo Tecnológico de la Construcción y la Industria')->first()->id,
       'codigo_centro' => 9231,
     ]);

     Centro::create([
       'regional_id'   => Regional::where('nombre', 'QUINDIO')->first()->id,
       'entidad_id'    => Entidad::where('nombre', 'Centro de Comercio y Turismo')->first()->id,
       'codigo_centro' => 9538,
     ]);

     /**
     * Centros de Formación del Risaralda
     */

     Centro::create([
       'regional_id'   => Regional::where('nombre', 'RISARALDA')->first()->id,
       'entidad_id'    => Entidad::where('nombre', 'Centro Atención Sector Agropecuario')->first()->id,
       'codigo_centro' => 9121,
     ]);

     Centro::create([
       'regional_id'   => Regional::where('nombre', 'RISARALDA')->first()->id,
       'entidad_id'    => Entidad::where('nombre', 'Centro de Diseño e Innovación Tecnológica Industrial')->first()->id,
       'codigo_centro' => 9223,
     ]);

     Centro::create([
       'regional_id'   => Regional::where('nombre', 'RISARALDA')->first()->id,
       'entidad_id'    => Entidad::where('nombre', 'Centro de Comercio y Servicios')->first()->id,
       'codigo_centro' => 9308,
     ]);

     /**
     * Centro de Formación de San Andrés
     */

     Centro::create([
       'regional_id'   => Regional::where('nombre', 'SAN ANDRES')->first()->id,
       'entidad_id'    => Entidad::where('nombre', 'Centro de Formación Turística, Gente de Mar y de Servicio')->first()->id,
       'codigo_centro' => 9539,
     ]);

     /**
     * Centros de formación de Santander
     */

     Centro::create([
       'regional_id'   => Regional::where('nombre', 'SANTANDER')->first()->id,
       'entidad_id'    => Entidad::where('nombre', 'Centro Atención Sector Agropecuario')->first()->id,
       'codigo_centro' => 9122,
     ]);

     Centro::create([
       'regional_id'   => Regional::where('nombre', 'SANTANDER')->first()->id,
       'entidad_id'    => Entidad::where('nombre', 'Centro Industrial de Mantenimiento Integral')->first()->id,
       'codigo_centro' => 9224,
     ]);

     Centro::create([
       'regional_id'   => Regional::where('nombre', 'SANTANDER')->first()->id,
       'entidad_id'    => Entidad::where('nombre', 'Centro Industrial del Diseño y la Manufactura')->first()->id,
       'codigo_centro' => 9225,
     ]);

     Centro::create([
       'regional_id'   => Regional::where('nombre', 'SANTANDER')->first()->id,
       'entidad_id'    => Entidad::where('nombre', 'Centro de Servicios Empresariales y Turísticos')->first()->id,
       'codigo_centro' => 9309,
     ]);

     Centro::create([
       'regional_id'   => Regional::where('nombre', 'SANTANDER')->first()->id,
       'entidad_id'    => Entidad::where('nombre', 'Centro Industrial y del Desarrollo Tecnológico')->first()->id,
       'codigo_centro' => 9540,
     ]);

     Centro::create([
       'regional_id'   => Regional::where('nombre', 'SANTANDER')->first()->id,
       'entidad_id'    => Entidad::where('nombre', 'Centro Agroturístico')->first()->id,
       'codigo_centro' => 9541,
     ]);

     Centro::create([
       'regional_id'   => Regional::where('nombre', 'SANTANDER')->first()->id,
       'entidad_id'    => Entidad::where('nombre', 'Centro Agroempresarial y Turístico de los Andes')->first()->id,
       'codigo_centro' => 9545,
     ]);

     Centro::create([
       'regional_id'   => Regional::where('nombre', 'SANTANDER')->first()->id,
       'entidad_id'    => Entidad::where('nombre', 'Centro de Gestión Agroempresarial del Oriente')->first()->id,
       'codigo_centro' => 9546,
     ]);

     /**
     * Centros de Formación de Sucre
     */

     Centro::create([
       'regional_id'   => Regional::where('nombre', 'SUCRE')->first()->id,
       'entidad_id'    => Entidad::where('nombre', 'Centro de la Innovación, la Tecnología y los Servicios')->first()->id,
       'codigo_centro' => 9542,
     ]);

     /**
     * Centros de Formación del Tolima
     */

     Centro::create([
       'regional_id'   => Regional::where('nombre', 'TOLIMA')->first()->id,
       'entidad_id'    => Entidad::where('nombre', 'Centro Agropecuario la Granja')->first()->id,
       'codigo_centro' => 9123,
     ]);

     Centro::create([
       'regional_id'   => Regional::where('nombre', 'TOLIMA')->first()->id,
       'entidad_id'    => Entidad::where('nombre', 'Centro de Industria y Construcción')->first()->id,
       'codigo_centro' => 9226,
     ]);

     Centro::create([
       'regional_id'   => Regional::where('nombre', 'TOLIMA')->first()->id,
       'entidad_id'    => Entidad::where('nombre', 'Centro de Comercio y Servicios')->first()->id,
       'codigo_centro' => 9310,
     ]);

     /**
     * Centos de Formación del Valle
     */

     Centro::create([
       'regional_id'   => Regional::where('nombre', 'VALLE')->first()->id,
       'entidad_id'    => Entidad::where('nombre', 'Centro Agropecuario de Buga')->first()->id,
       'codigo_centro' => 9124,
     ]);

     Centro::create([
       'regional_id'   => Regional::where('nombre', 'VALLE')->first()->id,
       'entidad_id'    => Entidad::where('nombre', 'Centro Latinoamericano de Especies Menores')->first()->id,
       'codigo_centro' => 9125,
     ]);

     Centro::create([
       'regional_id'   => Regional::where('nombre', 'VALLE')->first()->id,
       'entidad_id'    => Entidad::where('nombre', 'Centro Náutico Pesquero de Buenaventura')->first()->id,
       'codigo_centro' => 9126,
     ]);

     Centro::create([
       'regional_id'   => Regional::where('nombre', 'VALLE')->first()->id,
       'entidad_id'    => Entidad::where('nombre', 'Centro de Electricidad y Automatización Industrial -CEAI')->first()->id,
       'codigo_centro' => 9227,
     ]);

     Centro::create([
       'regional_id'   => Regional::where('nombre', 'VALLE')->first()->id,
       'entidad_id'    => Entidad::where('nombre', 'Centro de la Construcción')->first()->id,
       'codigo_centro' => 9228,
     ]);

     Centro::create([
       'regional_id'   => Regional::where('nombre', 'VALLE')->first()->id,
       'entidad_id'    => Entidad::where('nombre', 'Centro de Diseño Tecnológico Industrial')->first()->id,
       'codigo_centro' => 9229,
     ]);

     Centro::create([
       'regional_id'   => Regional::where('nombre', 'VALLE')->first()->id,
       'entidad_id'    => Entidad::where('nombre', 'Centro Nacional de Asistencia Técnica a la Industria -ASTIN')->first()->id,
       'codigo_centro' => 9230,
     ]);

     Centro::create([
       'regional_id'   => Regional::where('nombre', 'VALLE')->first()->id,
       'entidad_id'    => Entidad::where('nombre', 'Centro de Gestión Tecnológica de Servicios')->first()->id,
       'codigo_centro' => 9311,
     ]);

     Centro::create([
       'regional_id'   => Regional::where('nombre', 'VALLE')->first()->id,
       'entidad_id'    => Entidad::where('nombre', 'Centro de Tecnologías Agroindustriales')->first()->id,
       'codigo_centro' => 9543,
     ]);

     Centro::create([
       'regional_id'   => Regional::where('nombre', 'VALLE')->first()->id,
       'entidad_id'    => Entidad::where('nombre', 'Centro de Biotecnología Industrial')->first()->id,
       'codigo_centro' => 9544,
     ]);

     /**
     * Centros de formación del Vaupés
     */

     Centro::create([
       'regional_id'   => Regional::where('nombre', 'VALLE')->first()->id,
       'entidad_id'    => Entidad::where('nombre', 'Centro Agropecuario y de Servicios Ambientales "Jiri-jirimo"')->first()->id,
       'codigo_centro' => 9548,
     ]);

     /**
     * Centros de formación del Vichada
     */

     Centro::create([
       'regional_id'   => Regional::where('nombre', 'VALLE')->first()->id,
       'entidad_id'    => Entidad::where('nombre', 'Centro de Producción y Transformación Agroindustrial de la Orinoquía')->first()->id,
       'codigo_centro' => 9531,
     ]);


  }
}
