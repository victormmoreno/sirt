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
          'id'          => 1,
          'nombre'      => 'De Prueba.',
      ]);

      EstadoPrototipo::create([
          'id'          => 2,
          'nombre'      => 'Funcional.',
      ]);

      EstadoPrototipo::create([
          'id'          => 3,
          'nombre'      => 'En funcionamiento en la empresa.',
      ]);

      EstadoPrototipo::create([
          'id'          => 4,
          'nombre'      => 'En proceso de patentamiento.',
      ]);

      EstadoPrototipo::create([
          'id'          => 5,
          'nombre'      => 'En desarrollo.',
      ]);

      EstadoPrototipo::create([
          'id'          => 6,
          'nombre'      => 'No Aplica.',
      ]);

      EstadoPrototipo::create([
          'id'          => 7,
          'nombre'      => 'Otro.',
      ]);
    }
  }
