<?php

use App\Models\{Empresa, Entidad, Sector};
use Illuminate\Database\Seeder;

class EmpresasTableSeeder extends Seeder
{
  /**
  * Run the database seeds.
  *
  * @return void
  */
  public function run()
  {

    // Entidad::create([
    //   'entidad_id' => Entidad::where('nombre', 'Empresa  EAFIT.')->first()->id,
    //   'sector_id' => Sector::where('nombre', 'Sector terciario o de servicios')->first()->id,
    //   'nit' => '890901389',
    //   'direccion' => 'Carrera 49, número 7 sur 50, Medellín, Antioquia (El Poblado)'
    // ]);
    //
    // Entidad::create([
    //   'entidad_id' => Entidad::where('nombre', 'INGBIOCOMB SAS')->first()->id,
    //   'sector_id' => Sector::where('nombre', 'Sector terciario o de servicios')->first()->id,
    //   'nit' => '890901389',
    //   'direccion' => ''
    // ]);
    //
    // Entidad::create([
    //   'entidad_id' => Entidad::where('nombre', ' Fechner SAS')->first()->id,
    //   'sector_id' => Sector::where('nombre', 'Sector terciario o de servicios')->first()->id,
    //   'nit' => '890901389',
    //   'direccion' => 'VEREDA 3 PUERTAS LLANOGRANDE KM 7, 5 FCA SAN ESTEBAN, RIONEGRO - ANTIOQUIA'
    // ]);
    //
    // Entidad::create([
    //   'entidad_id' => Entidad::where('nombre', ' INDUSTRIAS CORY S.A.S')->first()->id,
    //   'sector_id' => Sector::where('nombre', 'Sector terciario o de servicios')->first()->id,
    //   'nit' => '890901389',
    //   'direccion' => ' Cl. 10 Sur #50 FF 42, Medellín, Antioquia'
    // ]);
    //
    // Entidad::create([
    //   'entidad_id' => Entidad::where('nombre', '3deko paneles y decoración')->first()->id,
    //   'sector_id' => Sector::where('nombre', 'Sector terciario o de servicios')->first()->id,
    //   'nit' => '890901389',
    //   'direccion' => ''
    // ]);

  }
}
