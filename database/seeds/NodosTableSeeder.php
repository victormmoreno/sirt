<?php

use App\Models\LineaTecnologica;
use App\Models\{Nodo, Centro, Entidad};
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

    if (app()->environment() == 'production') {
      Nodo::create([
      'centro_id'   => Centro::select('centros.id')->join('entidades', 'entidades.id', '=', 'centros.entidad_id')->where('entidades.nombre', 'Centro De Servicios Y Gestión Empresarial')->first()->id,
      'entidad_id'  => Entidad::where('nombre', 'Medellin')->first()->id,
      'direccion'   => 'Carrera 46 # 56-11. Edificio TecnoParque, Piso 6-7',
      'telefono' => 5760000,
      'anho_inicio' => '2007',
    ]);

    Nodo::create([
      'centro_id'   => Centro::select('centros.id')->join('entidades', 'entidades.id', '=', 'centros.entidad_id')->where('entidades.nombre', 'Centro de la Innovación, la Agroindustria y la Aviación')->first()->id,
      'entidad_id'  => Entidad::where('nombre', 'Rionegro')->first()->id,
      'direccion'   => 'Calle 41 Nº 50A – 324',
      'telefono' => 5311856,
      'anho_inicio' => '2007',
    ]);

    Nodo::create([
        'centro_id'   => Centro::select('centros.id')->join('entidades', 'entidades.id', '=', 'centros.entidad_id')->where('entidades.nombre', 'Centro Nacional de Asistencia Técnica a la Industria -ASTIN')->first()->id,
        'entidad_id'  => Entidad::where('nombre', 'Calí')->first()->id,
        'direccion'   => 'Carrera 5 No. 11-68, Plaza de Caicedo Centro de Cali',
        'telefono' => 8851768,
        'anho_inicio' => '2011',
      ]);

    Nodo::create([
      'centro_id'   => Centro::select('centros.id')->join('entidades', 'entidades.id', '=', 'centros.entidad_id')->where('entidades.nombre', 'Centro de Gestión de Mercados, Logística y Tecnologías de la Información')->first()->id,
      'entidad_id'  => Entidad::where('nombre', 'DC')->first()->id,
      'direccion'   => 'Calle 54 No 10 – 39',
      'telefono' => 5461500,
      'anho_inicio' => '2014',
    ]);


    Nodo::create([
      'centro_id'   => Centro::select('centros.id')->join('entidades', 'entidades.id', '=', 'centros.entidad_id')->where('entidades.nombre', 'Centro de Gestión de Mercados, Logística y Tecnologías de la Información')->first()->id,
      'entidad_id'  => Entidad::where('nombre', 'DC')->first()->id,
      'direccion'   => 'Calle 54 No 10 – 39',
      'telefono' => 5461500,
      'anho_inicio' => '2014',
      ]);

    Nodo::create([
    'centro_id'   => Centro::select('centros.id')->join('entidades', 'entidades.id', '=', 'centros.entidad_id')->where('entidades.nombre', 'Centro Industrial y de Desarrollo Empresarial de Soacha')->first()->id,
    'entidad_id'  => Entidad::where('nombre', 'Cazuca')->first()->id,
    'direccion'   => 'Autopista Sur Transversal 7 No 8 – 40.TecnoParque Central',
    'telefono' => 5461600,
    'anho_inicio' => '2009',
    ]);

    Nodo::create([
    'centro_id'   => Centro::select('centros.id')->join('entidades', 'entidades.id', '=', 'centros.entidad_id')->where('entidades.nombre', 'Centro Atención Sector Agropecuario')->where('entidades.ciudad_id', 888)->first()->id,
    'entidad_id'  => Entidad::where('nombre', 'Pereira')->first()->id,
    'direccion'   => 'Carrera 10 No. 17 - 15 Piso 2',
    'telefono' => 3358887,
    'anho_inicio' => '2007',
    ]);

    Nodo::create([
    'centro_id'   => Centro::select('centros.id')->join('entidades', 'entidades.id', '=', 'centros.entidad_id')->where('entidades.nombre', 'Centro de la Industria, la Empresa y los Servicios')->where('entidades.ciudad_id', 655)->first()->id,
    'entidad_id'  => Entidad::where('nombre', 'Neiva')->first()->id,
    'direccion'   => 'Diagonal 20 Nº 38 -16',
    'telefono' => 3358887,
    'anho_inicio' => '2007',
    ]);

    Nodo::create([
      'centro_id'   => Centro::select('centros.id')->join('entidades', 'entidades.id', '=', 'centros.entidad_id')->where('entidades.nombre', 'Centro de Servicios Empresariales y Turísticos')->first()->id,
      'entidad_id'  => Entidad::where('nombre', 'Bucaramanga')->first()->id,
      'direccion'   => 'Km 6 Autopista Florida Blanca # 50-33',
      'telefono' => 6424614,
      'anho_inicio' => '2009',
      ]);

    Nodo::create([
    'centro_id'   => Centro::select('centros.id')->join('entidades', 'entidades.id', '=', 'centros.entidad_id')->where('entidades.nombre', 'Centro para la Formación Cafetera')->first()->id,
    'entidad_id'  => Entidad::where('nombre', 'Manizales')->first()->id,
    'direccion'   => 'Kilómetro 10 Vía al Magdalena',
    'telefono' => 8741451,
    'anho_inicio' => '2008',
    ]);


    Nodo::create([
    'centro_id'   => Centro::select('centros.id')->join('entidades', 'entidades.id', '=', 'centros.entidad_id')->where('entidades.nombre', 'Centro Agropecuario la Granja')->first()->id,
    'entidad_id'  => Entidad::where('nombre', 'La Granja')->first()->id,
    'direccion'   => 'Km 5 Vía Espinal - Ibagué',
    'telefono' => 2709600,
    'anho_inicio' => '2009',
    ]);

    Nodo::create([
    'centro_id'   => Centro::select('centros.id')->join('entidades', 'entidades.id', '=', 'centros.entidad_id')->where('entidades.nombre', 'Centro de Gestión y Desarrollo Sostenible Surcolombiano')->first()->id,
    'entidad_id'  => Entidad::where('nombre', 'Pitalito')->first()->id,
    'direccion'   => 'Km 7 vía Pitalito, vereda Aguaduas',
    'telefono' => 8365960,
    'anho_inicio' => '2012',
    ]);


    Nodo::create([
    'centro_id'   => Centro::select('centros.id')->join('entidades', 'entidades.id', '=', 'centros.entidad_id')->where('entidades.nombre', 'Centro Agroempresarial')->first()->id,
    'entidad_id'  => Entidad::where('nombre', 'Valledupar')->first()->id,
    'direccion'   => 'Carrera 19 entre Calles 14 y 15',
    'telefono' => 5842455,
    'anho_inicio' => '2009',
    ]);



    Nodo::create([
    'centro_id'   => Centro::select('centros.id')->join('entidades', 'entidades.id', '=', 'centros.entidad_id')->where('entidades.nombre', 'Centro de la Industria, la Empresa y los Servicios')->where('entidades.ciudad_id', 837)->first()->id,
    'entidad_id'  => Entidad::where('nombre', 'Ocaña')->first()->id,
    'direccion'   => 'Transversal 30 N° 7-110 La Primavera',
    'telefono' => 5611035,
    'anho_inicio' => '2009',
    ]);


    Nodo::create([
    'centro_id'   => Centro::select('centros.id')->join('entidades', 'entidades.id', '=', 'centros.entidad_id')->where('entidades.nombre', 'Centro de Formación Agroindustrial')->first()->id,
    'entidad_id'  => Entidad::where('nombre', 'Angostura')->first()->id,
    'direccion'   => 'Km 38 Vía Neiva al Sur - Campo Alegre',
    'telefono' => 8380191,
    'anho_inicio' => '2009',
    ]);


    Nodo::create([
    'centro_id'   => Centro::select('centros.id')->join('entidades', 'entidades.id', '=', 'centros.entidad_id')->where('entidades.nombre', 'Centro Agroturístico')->first()->id,
    'entidad_id'  => Entidad::where('nombre', 'Socorro')->first()->id,
    'direccion'   => 'Calle 16 No. 14-28',
    'telefono' => 7296851,
    'anho_inicio' => '2012',
    ]);


    }elseif(app()->environment() == 'local'){
      $lineasTecnologica = LineaTecnologica::all()->random()->id;
      Nodo::create([
        'centro_id'   => Centro::select('centros.id')->join('entidades', 'entidades.id', '=', 'centros.entidad_id')->where('entidades.nombre', 'Centro De Servicios Y Gestión Empresarial')->first()->id,
        'entidad_id'  => Entidad::where('nombre', 'Medellin')->first()->id,
        'direccion'   => 'Carrera 46 # 56-11. Edificio TecnoParque, Piso 6-7',
        'telefono' => 5760000,
        'anho_inicio' => '2007',
      ])->lineas()->sync($lineasTecnologica);

      Nodo::create([
        'centro_id'   => Centro::select('centros.id')->join('entidades', 'entidades.id', '=', 'centros.entidad_id')->where('entidades.nombre', 'Centro de la Innovación, la Agroindustria y la Aviación')->first()->id,
        'entidad_id'  => Entidad::where('nombre', 'Rionegro')->first()->id,
        'direccion'   => 'Calle 41 Nº 50A – 324',
        'telefono' => 5311856,
        'anho_inicio' => '2007',
      ])->lineas()->sync($lineasTecnologica);

      Nodo::create([
        'centro_id'   => Centro::select('centros.id')->join('entidades', 'entidades.id', '=', 'centros.entidad_id')->where('entidades.nombre', 'Centro Nacional de Asistencia Técnica a la Industria -ASTIN')->first()->id,
        'entidad_id'  => Entidad::where('nombre', 'Calí')->first()->id,
        'direccion'   => 'Carrera 5 No. 11-68, Plaza de Caicedo Centro de Cali',
        'telefono' => 8851768,
        'anho_inicio' => '2011',
      ])->lineas()->sync($lineasTecnologica);

      Nodo::create([
      'centro_id'   => Centro::select('centros.id')->join('entidades', 'entidades.id', '=', 'centros.entidad_id')->where('entidades.nombre', 'Centro de Gestión de Mercados, Logística y Tecnologías de la Información')->first()->id,
      'entidad_id'  => Entidad::where('nombre', 'DC')->first()->id,
      'direccion'   => 'Calle 54 No 10 – 39',
      'telefono' => 5461500,
      'anho_inicio' => '2014',
      ])->lineas()->sync($lineasTecnologica);

      Nodo::create([
      'centro_id'   => Centro::select('centros.id')->join('entidades', 'entidades.id', '=', 'centros.entidad_id')->where('entidades.nombre', 'Centro Industrial y de Desarrollo Empresarial de Soacha')->first()->id,
      'entidad_id'  => Entidad::where('nombre', 'Cazuca')->first()->id,
      'direccion'   => 'Autopista Sur Transversal 7 No 8 – 40.TecnoParque Central',
      'telefono' => 5461600,
      'anho_inicio' => '2009',
      ])->lineas()->sync($lineasTecnologica);


      Nodo::create([
      'centro_id'   => Centro::select('centros.id')->join('entidades', 'entidades.id', '=', 'centros.entidad_id')->where('entidades.nombre', 'Centro Atención Sector Agropecuario')->where('entidades.ciudad_id', 888)->first()->id,
      'entidad_id'  => Entidad::where('nombre', 'Pereira')->first()->id,
      'direccion'   => 'Carrera 10 No. 17 - 15 Piso 2',
      'telefono' => 3358887,
      'anho_inicio' => '2007',
      ])->lineas()->sync($lineasTecnologica);


      Nodo::create([
      'centro_id'   => Centro::select('centros.id')->join('entidades', 'entidades.id', '=', 'centros.entidad_id')->where('entidades.nombre', 'Centro de la Industria, la Empresa y los Servicios')->where('entidades.ciudad_id', 655)->first()->id,
      'entidad_id'  => Entidad::where('nombre', 'Neiva')->first()->id,
      'direccion'   => 'Diagonal 20 Nº 38 -16',
      'telefono' => 3358887,
      'anho_inicio' => '2007',
      ])->lineas()->sync($lineasTecnologica);

      Nodo::create([
    'centro_id'   => Centro::select('centros.id')->join('entidades', 'entidades.id', '=', 'centros.entidad_id')->where('entidades.nombre', 'Centro de Servicios Empresariales y Turísticos')->first()->id,
    'entidad_id'  => Entidad::where('nombre', 'Bucaramanga')->first()->id,
    'direccion'   => 'Km 6 Autopista Florida Blanca # 50-33',
    'telefono' => 6424614,
    'anho_inicio' => '2009',
    ])->lineas()->sync($lineasTecnologica);

      Nodo::create([
      'centro_id'   => Centro::select('centros.id')->join('entidades', 'entidades.id', '=', 'centros.entidad_id')->where('entidades.nombre', 'Centro para la Formación Cafetera')->first()->id,
      'entidad_id'  => Entidad::where('nombre', 'Manizales')->first()->id,
      'direccion'   => 'Kilómetro 10 Vía al Magdalena',
      'telefono' => 8741451,
      'anho_inicio' => '2008',
      ])->lineas()->sync($lineasTecnologica);


      Nodo::create([
        'centro_id'   => Centro::select('centros.id')->join('entidades', 'entidades.id', '=', 'centros.entidad_id')->where('entidades.nombre', 'Centro Agropecuario la Granja')->first()->id,
        'entidad_id'  => Entidad::where('nombre', 'La Granja')->first()->id,
        'direccion'   => 'Km 5 Vía Espinal - Ibagué',
        'telefono' => 2709600,
        'anho_inicio' => '2009',
        ])->lineas()->sync($lineasTecnologica);

      Nodo::create([
      'centro_id'   => Centro::select('centros.id')->join('entidades', 'entidades.id', '=', 'centros.entidad_id')->where('entidades.nombre', 'Centro de Gestión y Desarrollo Sostenible Surcolombiano')->first()->id,
      'entidad_id'  => Entidad::where('nombre', 'Pitalito')->first()->id,
      'direccion'   => 'Km 7 vía Pitalito, vereda Aguaduas',
      'telefono' => 8365960,
      'anho_inicio' => '2012',
      ])->lineas()->sync($lineasTecnologica);

      Nodo::create([
      'centro_id'   => Centro::select('centros.id')->join('entidades', 'entidades.id', '=', 'centros.entidad_id')->where('entidades.nombre', 'Centro Agroempresarial')->first()->id,
      'entidad_id'  => Entidad::where('nombre', 'Valledupar')->first()->id,
      'direccion'   => 'Carrera 19 entre Calles 14 y 15',
      'telefono' => 5842455,
      'anho_inicio' => '2009',
      ])->lineas()->sync($lineasTecnologica);

      Nodo::create([
      'centro_id'   => Centro::select('centros.id')->join('entidades', 'entidades.id', '=', 'centros.entidad_id')->where('entidades.nombre', 'Centro de la Industria, la Empresa y los Servicios')->where('entidades.ciudad_id', 837)->first()->id,
      'entidad_id'  => Entidad::where('nombre', 'Ocaña')->first()->id,
      'direccion'   => 'Transversal 30 N° 7-110 La Primavera',
      'telefono' => 5611035,
      'anho_inicio' => '2009',
      ])->lineas()->sync($lineasTecnologica);



      Nodo::create([
      'centro_id'   => Centro::select('centros.id')->join('entidades', 'entidades.id', '=', 'centros.entidad_id')->where('entidades.nombre', 'Centro de Formación Agroindustrial')->first()->id,
      'entidad_id'  => Entidad::where('nombre', 'Angostura')->first()->id,
      'direccion'   => 'Km 38 Vía Neiva al Sur - Campo Alegre',
      'telefono' => 8380191,
      'anho_inicio' => '2009',
      ])->lineas()->sync($lineasTecnologica);


      Nodo::create([
      'centro_id'   => Centro::select('centros.id')->join('entidades', 'entidades.id', '=', 'centros.entidad_id')->where('entidades.nombre', 'Centro Agroturístico')->first()->id,
      'entidad_id'  => Entidad::where('nombre', 'Socorro')->first()->id,
      'direccion'   => 'Calle 16 No. 14-28',
      'telefono' => 7296851,
      'anho_inicio' => '2012',
      ])->lineas()->sync($lineasTecnologica);
    }
    

  }
}
