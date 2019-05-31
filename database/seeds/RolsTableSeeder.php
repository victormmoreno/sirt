<?php

use App\Models\Rols;
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
        Rols::create([
            'id'          => 1,
            'nombre'      => 'Administrador',
            
        ]);

        Rols::create([
            'id'          => 2,
            'nombre'      => 'Dinamizador',
            
        ]);

        Rols::create([
            'id'          => 3,
            'nombre'      => 'Gestor',
            
        ]);

        Rols::create([
            'id'     => 4,
            'nombre' => 'Infocenter',
        ]);

        Rols::create([
            'id'          => 5,
            'nombre'      => 'Talento',
            
        ]);

        Rols::create([
            'id'          => 6,
            'nombre'      => 'Ingreso',
            
        ]);

        Rols::create([
            'id'          => 7,
            'nombre'      => 'Proveedor',
            
        ]);
    }
}
