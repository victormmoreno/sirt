<?php

use Illuminate\Database\Seeder;
use App\Models\AreaConocimiento;

class AreasConocimientoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      AreaConocimiento::create([
          'id' => 1,
          'nombre' => 'Ciencias Naturales',
      ]);

      AreaConocimiento::create([
          'id' => 2,
          'nombre' => 'Ingeniería y Nanotecnología',
      ]);

      AreaConocimiento::create([
          'id' => 3,
          'nombre' => 'Cuarta Revolución Industrial',
      ]);

      AreaConocimiento::create([
          'id' => 4,
          'nombre' => 'Ciencias Médicas y de la Salud',
      ]);

      AreaConocimiento::create([
          'id' => 5,
          'nombre' => 'Ciencias Agrícolas',
      ]);

      AreaConocimiento::create([
          'id' => 6,
          'nombre' => 'Ciencias Sociales',
      ]);

      AreaConocimiento::create([
          'id' => 7,
          'nombre' => 'Humanidades',
      ]);

      AreaConocimiento::create([
          'id' => 8,
          'nombre' => 'Industrias Creativas',
      ]);

      AreaConocimiento::create([
          'id' => 9,
          'nombre' => 'Otro',
      ]);
    }
}
