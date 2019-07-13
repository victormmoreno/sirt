<?php

use Illuminate\Database\Seeder;
use App\Models\TipoArticulacionProyecto;

class TiposArticualcionesProyectosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      TipoArticulacionProyecto::create([
          'id' => 1,
          'nombre' => 'Grupos y Semilleros del SENA',
      ]);

      TipoArticulacionProyecto::create([
          'id' => 2,
          'nombre' => 'Tecnoacademias',
      ]);

      TipoArticulacionProyecto::create([
          'id' => 3,
          'nombre' => 'Grupos y Semilleros Externos',
      ]);

      TipoArticulacionProyecto::create([
          'id' => 4,
          'nombre' => 'Empresas',
      ]);

      TipoArticulacionProyecto::create([
          'id' => 5,
          'nombre' => 'Tecnoparques',
      ]);

      TipoArticulacionProyecto::create([
          'id' => 6,
          'nombre' => 'Centros de Formación',
      ]);

      TipoArticulacionProyecto::create([
          'id' => 7,
          'nombre' => 'Universidades',
      ]);

      TipoArticulacionProyecto::create([
          'id' => 8,
          'nombre' => 'Emprendedor',
      ]);

      TipoArticulacionProyecto::create([
          'id' => 9,
          'nombre' => 'Proyecto financiado por SENNOVA',
      ]);

      TipoArticulacionProyecto::create([
          'id' => 10,
          'nombre' => 'Otro',
      ]);
    }
}
