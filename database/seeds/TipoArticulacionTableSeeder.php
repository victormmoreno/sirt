<?php

use App\Models\TipoArticulacion;
use Illuminate\Database\Seeder;

class TipoArticulacionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoArticulacion::create([
            'nombre' => 'Convenio',
        ]);

        TipoArticulacion::create([
            'nombre' => 'Presentación a convocatoria',
        ]);

        TipoArticulacion::create([
            'nombre' => 'UPI',
        ]);

        TipoArticulacion::create([
            'nombre' => 'Creación empresa',
        ]);
    }
}
