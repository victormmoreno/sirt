<?php

use Illuminate\Database\Seeder;
use App\Models\EstadoPrototipo;

class EstadosPrototiposTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      EstadoPrototipo::create([
          'nombre' => 'De Prueba.'
      ]);

      EstadoPrototipo::create([
          'nombre' => 'Funcional.'
      ]);

      EstadoPrototipo::create([
          'nombre' => 'En funcionamiento en la empresa.'
      ]);

      EstadoPrototipo::create([
          'nombre' => 'En proceso de patentamiento.'
      ]);

      EstadoPrototipo::create([
          'nombre' => 'En desarrollo.'
      ]);

      EstadoPrototipo::create([
          'nombre' => 'Otro.'
      ]);
    }
  }
