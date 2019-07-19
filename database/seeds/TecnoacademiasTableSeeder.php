<?php

use App\Models\{Tecnoacademia, Entidad, Regional, Centro};
use Illuminate\Database\Seeder;

class TecnoacademiasTableSeeder extends Seeder
{
  /**
  * Run the database seeds.
  *
  * @return void
  */
  public function run()
  {
    Tecnoacademia::create([
      'regional_id' => Regional::where('nombre', 'SANTANDER')->first()->id,
      'entidad_id'  => Entidad::where('nombre', 'TECNOACADEMIA BUCARAMANGA')->first()->id,
      'centro_id'   => Centro::select('centros.id')->join('entidades', 'entidades.id', '=', 'centros.entidad_id')->where('entidades.nombre', 'Centro de Servicios Empresariales y Turísticos')->first()->id,
    ]);

    Tecnoacademia::create([
      'regional_id' => Regional::where('nombre', 'VALLE')->first()->id,
      'entidad_id'  => Entidad::where('nombre', 'TECNOACADEMIA CALI')->first()->id,
      'centro_id'   => Centro::select('centros.id')->join('entidades', 'entidades.id', '=', 'centros.entidad_id')->where('entidades.nombre', 'Centro Nacional de Asistencia Técnica a la Industria -ASTIN')->first()->id,
    ]);

    Tecnoacademia::create([
      'regional_id' => Regional::where('nombre', 'CUNDINAMARCA')->first()->id,
      'entidad_id'  => Entidad::where('nombre', 'TECNOACADEMIA CAZUCA')->first()->id,
      'centro_id'   => Centro::select('centros.id')->join('entidades', 'entidades.id', '=', 'centros.entidad_id')->where('entidades.nombre', 'Centro Industrial y de Desarrollo Empresarial de Soacha')->first()->id,
    ]);

    Tecnoacademia::create([
      'regional_id' => Regional::where('nombre', 'TOLIMA')->first()->id,
      'entidad_id'  => Entidad::where('nombre', 'TECNOACADEMIA IBAGUE')->first()->id,
      'centro_id'   => Centro::select('centros.id')->join('entidades', 'entidades.id', '=', 'centros.entidad_id')->where('entidades.nombre', 'Centro de Industria y Construcción')->first()->id,
    ]);

    Tecnoacademia::create([
      'regional_id' => Regional::where('nombre', 'CALDAS')->first()->id,
      'entidad_id'  => Entidad::where('nombre', 'TECNOACADEMIA MANIZALES')->first()->id,
      'centro_id'   => Centro::select('centros.id')->join('entidades', 'entidades.id', '=', 'centros.entidad_id')->where('entidades.nombre', 'Centro de Automatización Industrial')->first()->id,
    ]);

    Tecnoacademia::create([
      'regional_id' => Regional::where('nombre', 'ANTIOQUIA')->first()->id,
      'entidad_id'  => Entidad::where('nombre', 'TECNOACADEMIA MEDELLIN')->first()->id,
      'centro_id'   => Centro::select('centros.id')->join('entidades', 'entidades.id', '=', 'centros.entidad_id')->where('entidades.nombre', 'Centro para el Desarrollo del Hábitat y la Construcción')->first()->id,
    ]);

    Tecnoacademia::create([
      'regional_id' => Regional::where('nombre', 'HUILA')->first()->id,
      'entidad_id'  => Entidad::where('nombre', 'TECNOACADEMIA NEIVA')->first()->id,
      'centro_id'   => Centro::select('centros.id')->join('entidades', 'entidades.id', '=', 'centros.entidad_id')->where('entidades.nombre', 'Centro de la Industria, la Empresa y los Servicios')->where('entidades.ciudad_id', 655)->first()->id,
    ]);

    Tecnoacademia::create([
      'regional_id' => Regional::where('nombre', 'RISARALDA')->first()->id,
      'entidad_id'  => Entidad::where('nombre', 'TECNOACADEMIA PEREIRA')->first()->id,
      'centro_id'   => Centro::select('centros.id')->join('entidades', 'entidades.id', '=', 'centros.entidad_id')->where('entidades.nombre', 'Centro de Diseño e Innovación Tecnológica Industrial')->first()->id,
    ]);

    Tecnoacademia::create([
      'regional_id' => Regional::where('nombre', 'NARIÑO')->first()->id,
      'entidad_id'  => Entidad::where('nombre', 'TECNOACADEMIA TUQUERRES')->first()->id,
      'centro_id'   => Centro::select('centros.id')->join('entidades', 'entidades.id', '=', 'centros.entidad_id')->where('entidades.nombre', 'Centro Sur Colombiano de Logística Internacional')->first()->id,
    ]);

    Tecnoacademia::create([
      'regional_id' => Regional::where('nombre', 'NORTE S/DER')->first()->id,
      'entidad_id'  => Entidad::where('nombre', 'TECNOACADEMIA CUCÚTA')->first()->id,
      'centro_id'   => Centro::select('centros.id')->join('entidades', 'entidades.id', '=', 'centros.entidad_id')->where('entidades.nombre', 'Centro de la Industria, la Empresa y los Servicios')->where('entidades.ciudad_id', 837)->first()->id,
    ]);

  }
}
