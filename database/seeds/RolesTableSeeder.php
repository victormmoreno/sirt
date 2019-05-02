<?php

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'idrol'       => 1,
            'nombre'      => 'Administrador',
            'descripcion' => '',
        ]);

        Role::create([
            'idrol'       => 2,
            'nombre'      => 'Dinamizador',
            'descripcion' => '',
        ]);

        Role::create([
            'idrol'       => 3,
            'nombre'      => 'Gestor',
            'descripcion' => '',
        ]);

        Role::create([
            'idrol'       => 4,
            'nombre'      => 'Infocenter',
            'descripcion' => '',
        ]);

        Role::create([
            'idrol'       => 5,
            'nombre'      => 'Talento',
            'descripcion' => '',
        ]);

        Role::create([
            'idrol'       => 6,
            'nombre'      => 'Ingreso',
            'descripcion' => '',
        ]);

        Role::create([
            'idrol'       => 7,
            'nombre'      => 'Proveedor',
            'descripcion' => '',
        ]);

    }
}
