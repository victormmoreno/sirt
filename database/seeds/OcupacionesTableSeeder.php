<?php

use App\Models\Ocupacion;
use Illuminate\Database\Seeder;

class OcupacionesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Ocupacion::create([
            'nombre' => 'Otra',
        ]);
        Ocupacion::create([
            'nombre' => 'Estudiante',
        ]);
        Ocupacion::create([
            'nombre' => 'Independiente',
        ]);
        Ocupacion::create([
            'nombre' => 'Empleado',
        ]);
    }
}
