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


    // Centro::create([
    //   'regional_id'   => Regional::where('nombre', 'ANTIOQUIA')->first()->id,
    //   'entidad_id'    => Entidad::where('nombre', 'Centro Tecnológico de Gestión Industrial')->first()->id,
    //   'codigo_centro' => 9206,
    // ]);

    // Centro::create([
    //     'regional_id'   => 9,
    //     'entidad_id'    => 1,
    //     'codigo_centro' => 9520,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 1,
    //     'entidad_id'    => 2,
    //     'codigo_centro' => 9504,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 25,
    //     'entidad_id'    => 3,
    //     'codigo_centro' => 9530,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 19,
    //     'entidad_id'    => 4,
    //     'codigo_centro' => 9538,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 21,
    //     'entidad_id'    => 5,
    //     'codigo_centro' => 9540,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 2,
    //     'entidad_id'    => 6,
    //     'codigo_centro' => 9103,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 2,
    //     'entidad_id'    => 7,
    //     'codigo_centro' => 9302,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 2,
    //     'entidad_id'    => 8,
    //     'codigo_centro' => 9207,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 2,
    //     'entidad_id'    => 9,
    //     'codigo_centro' => 9208,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 2,
    //     'entidad_id'    => 10,
    //     'codigo_centro' => 9405,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 3,
    //     'entidad_id'    => 11,
    //     'codigo_centro' => 9209,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 3,
    //     'entidad_id'    => 12,
    //     'codigo_centro' => 9210,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 3,
    //     'entidad_id'    => 13,
    //     'codigo_centro' => 9212,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 3,
    //     'entidad_id'    => 14,
    //     'codigo_centro' => 9214,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 3,
    //     'entidad_id'    => 15,
    //     'codigo_centro' => 9215,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 3,
    //     'entidad_id'    => 16,
    //     'codigo_centro' => 9211,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 3,
    //     'entidad_id'    => 17,
    //     'codigo_centro' => 9216,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 3,
    //     'entidad_id'    => 18,
    //     'codigo_centro' => 9217,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 3,
    //     'entidad_id'    => 19,
    //     'codigo_centro' => 9406,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 3,
    //     'entidad_id'    => 20,
    //     'codigo_centro' => 9403,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 3,
    //     'entidad_id'    => 21,
    //     'codigo_centro' => 9404,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 3,
    //     'entidad_id'    => 22,
    //     'codigo_centro' => 9508,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 3,
    //     'entidad_id'    => 23,
    //     'codigo_centro' => 9303,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 1,
    //     'entidad_id'    => 24,
    //     'codigo_centro' => 9309,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 24,
    //     'entidad_id'    => 25,
    //     'codigo_centro' => 9126,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 24,
    //     'entidad_id'    => 26,
    //     'codigo_centro' => 9124,
    // ]);
    //

    //
    // Centro::create([
    //     'regional_id'   => 24,
    //     'entidad_id'    => 28,
    //     'codigo_centro' => 9227,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 24,
    //     'entidad_id'    => 29,
    //     'codigo_centro' => 9229,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 24,
    //     'entidad_id'    => 30,
    //     'codigo_centro' => 9230,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 24,
    //     'entidad_id'    => 31,
    //     'codigo_centro' => 9311,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 24,
    //     'entidad_id'    => 32,
    //     'codigo_centro' => 9228,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 13,
    //     'entidad_id'    => 33,
    //     'codigo_centro' => 9116,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 4,
    //     'entidad_id'    => 34,
    //     'codigo_centro' => 9104,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 4,
    //     'entidad_id'    => 35,
    //     'codigo_centro' => 9304,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 4,
    //     'entidad_id'    => 36,
    //     'codigo_centro' => 9105,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 4,
    //     'entidad_id'    => 37,
    //     'codigo_centro' => 9218,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 24,
    //     'entidad_id'    => 38,
    //     'codigo_centro' => 9543,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 1,
    //     'entidad_id'    => 39,
    //     'codigo_centro' => 9501,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 11,
    //     'entidad_id'    => 40,
    //     'codigo_centro' => 9513,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 18,
    //     'entidad_id'    => 41,
    //     'codigo_centro' => 9119,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 18,
    //     'entidad_id'    => 42,
    //     'codigo_centro' => 9537,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 20,
    //     'entidad_id'    => 43,
    //     'codigo_centro' => 9223,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 5,
    //     'entidad_id'    => 44,
    //     'codigo_centro' => 9110,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 23,
    //     'entidad_id'    => 45,
    //     'codigo_centro' => 9123,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 7,
    //     'entidad_id'    => 46,
    //     'codigo_centro' => 9516,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 21,
    //     'entidad_id'    => 47,
    //     'codigo_centro' => 9225,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 14,
    //     'entidad_id'    => 48,
    //     'codigo_centro' => 9524,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 11,
    //     'entidad_id'    => 49,
    //     'codigo_centro' => 9510,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 15,
    //     'entidad_id'    => 50,
    //     'codigo_centro' => 9118,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 13,
    //     'entidad_id'    => 51,
    //     'codigo_centro' => 9525,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 11,
    //     'entidad_id'    => 52,
    //     'codigo_centro' => 9511,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 21,
    //     'entidad_id'    => 53,
    //     'codigo_centro' => 9224,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 22,
    //     'entidad_id'    => 54,
    //     'codigo_centro' => 9226,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 22,
    //     'entidad_id'    => 55,
    //     'codigo_centro' => 9310,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 17,
    //     'entidad_id'    => 56,
    //     'codigo_centro' => 9534,
    // ]);
    //

    //
    // Centro::create([
    //     'regional_id'   => 1,
    //     'entidad_id'    => 58,
    //     'codigo_centro' => 9202,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 1,
    //     'entidad_id'    => 59,
    //     'codigo_centro' => 9205,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 10,
    //     'entidad_id'    => 60,
    //     'codigo_centro' => 9115,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 6,
    //     'entidad_id'    => 61,
    //     'codigo_centro' => 9515,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 13,
    //     'entidad_id'    => 62,
    //     'codigo_centro' => 9526,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 29,
    //     'entidad_id'    => 63,
    //     'codigo_centro' => 9517,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 21,
    //     'entidad_id'    => 64,
    //     'codigo_centro' => 9545,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 6,
    //     'entidad_id'    => 65,
    //     'codigo_centro' => 9112,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 6,
    //     'entidad_id'    => 66,
    //     'codigo_centro' => 9219,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 6,
    //     'entidad_id'    => 67,
    //     'codigo_centro' => 9220,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 6,
    //     'entidad_id'    => 68,
    //     'codigo_centro' => 9306,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 1,
    //     'entidad_id'    => 69,
    //     'codigo_centro' => 9301,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 1,
    //     'entidad_id'    => 70,
    //     'codigo_centro' => 9401,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 1,
    //     'entidad_id'    => 71,
    //     'codigo_centro' => 9402,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 1,
    //     'entidad_id'    => 72,
    //     'codigo_centro' => 9203,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 1,
    //     'entidad_id'    => 73,
    //     'codigo_centro' => 9204,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 1,
    //     'entidad_id'    => 74,
    //     'codigo_centro' => 9206,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 32,
    //     'entidad_id'    => 75,
    //     'codigo_centro' => 9548,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 10,
    //     'entidad_id'    => 76,
    //     'codigo_centro' => 9523,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 5,
    //     'entidad_id'    => 77,
    //     'codigo_centro' => 9111,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 11,
    //     'entidad_id'    => 78,
    //     'codigo_centro' => 9512,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 13,
    //     'entidad_id'    => 79,
    //     'codigo_centro' => 9527,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 24,
    //     'entidad_id'    => 80,
    //     'codigo_centro' => 9544,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 17,
    //     'entidad_id'    => 81,
    //     'codigo_centro' => 9536,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 20,
    //     'entidad_id'    => 82,
    //     'codigo_centro' => 9121,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 20,
    //     'entidad_id'    => 83,
    //     'codigo_centro' => 9308,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 21,
    //     'entidad_id'    => 84,
    //     'codigo_centro' => 9122,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 13,
    //     'entidad_id'    => 85,
    //     'codigo_centro' => 9528,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 8,
    //     'entidad_id'    => 86,
    //     'codigo_centro' => 9113,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 8,
    //     'entidad_id'    => 87,
    //     'codigo_centro' => 9221,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 8,
    //     'entidad_id'    => 88,
    //     'codigo_centro' => 9307,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 27,
    //     'entidad_id'    => 89,
    //     'codigo_centro' => 9518,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 1,
    //     'entidad_id'    => 90,
    //     'codigo_centro' => 9502,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 33,
    //     'entidad_id'    => 91,
    //     'codigo_centro' => 9531,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 30,
    //     'entidad_id'    => 92,
    //     'codigo_centro' => 9547,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 16,
    //     'entidad_id'    => 93,
    //     'codigo_centro' => 9117,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 12,
    //     'entidad_id'    => 94,
    //     'codigo_centro' => 9522,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 14,
    //     'entidad_id'    => 95,
    //     'codigo_centro' => 9222,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 1,
    //     'entidad_id'    => 96,
    //     'codigo_centro' => 9503,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 28,
    //     'entidad_id'    => 97,
    //     'codigo_centro' => 9539,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 21,
    //     'entidad_id'    => 98,
    //     'codigo_centro' => 9541,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 31,
    //     'entidad_id'    => 99,
    //     'codigo_centro' => 9533,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 15,
    //     'entidad_id'    => 100,
    //     'codigo_centro' => 9529,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 22,
    //     'entidad_id'    => 101,
    //     'codigo_centro' => 9542,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 3,
    //     'entidad_id'    => 102,
    //     'codigo_centro' => 9209,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 3,
    //     'entidad_id'    => 103,
    //     'codigo_centro' => 9213,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 3,
    //     'entidad_id'    => 104,
    //     'codigo_centro' => 9406,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 11,
    //     'entidad_id'    => 105,
    //     'codigo_centro' => 9232,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 11,
    //     'entidad_id'    => 106,
    //     'codigo_centro' => 9232,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 5,
    //     'entidad_id'    => 107,
    //     'codigo_centro' => 9514,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 24,
    //     'entidad_id'    => 108,
    //     'codigo_centro' => 9125,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 17,
    //     'entidad_id'    => 109,
    //     'codigo_centro' => 9535,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 5,
    //     'entidad_id'    => 110,
    //     'codigo_centro' => 9305,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 9,
    //     'entidad_id'    => 111,
    //     'codigo_centro' => 9521,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 9,
    //     'entidad_id'    => 112,
    //     'codigo_centro' => 9114,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 21,
    //     'entidad_id'    => 113,
    //     'codigo_centro' => 9546,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 19,
    //     'entidad_id'    => 114,
    //     'codigo_centro' => 9120,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 19,
    //     'entidad_id'    => 115,
    //     'codigo_centro' => 9231,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 16,
    //     'entidad_id'    => 116,
    //     'codigo_centro' => 9532,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 11,
    //     'entidad_id'    => 117,
    //     'codigo_centro' => 9509,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 26,
    //     'entidad_id'    => 118,
    //     'codigo_centro' => 9519,
    // ]);
    //
    // Centro::create([
    //     'regional_id'   => 1,
    //     'entidad_id'    => 119,
    //     'codigo_centro' => 9589,
    // ]);

  }
}
