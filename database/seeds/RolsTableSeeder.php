<?php

use App\Models\Rol;
use Illuminate\Database\Seeder;

class RolsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Rol::create([
            'id'          => 1,
            'nombre'      => 'Administrador',
            'descripcion' => '',
        ]);

        Rol::create([
            'id'          => 2,
            'nombre'      => 'Dinamizador',
            'descripcion' => '',
        ]);

        Rol::create([
            'id'          => 3,
            'nombre'      => 'Gestor',
            'descripcion' => '',
        ]);

        Rol::create([
            'id'     => 4,
            'nombre' => 'Infocenter',
        ]);

        Rol::create([
            'id'          => 5,
            'nombre'      => 'Talento',
            'descripcion' => '',
        ]);

        Rol::create([
            'id'          => 6,
            'nombre'      => 'Ingreso',
            'descripcion' => '',
        ]);

        Rol::create([
            'id'          => 7,
            'nombre'      => 'Proveedor',
            'descripcion' => '',
        ]);
    }
}
