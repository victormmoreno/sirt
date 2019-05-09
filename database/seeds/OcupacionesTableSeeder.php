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
            'id'          => 1,
            'nombre'      => 'Estudiante',
            'descripcion' => '',
        ]);

        Ocupacion::create([
            'id'          => 2,
            'nombre'      => 'Independiente',
            'descripcion' => '',
        ]);

        Ocupacion::create([
            'id'          => 3,
            'nombre'      => 'Empleado',
            'descripcion' => '',
        ]);
    }
}
