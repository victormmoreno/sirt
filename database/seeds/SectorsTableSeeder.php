<?php

use App\Models\Sector;
use Illuminate\Database\Seeder;

class SectorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sector::create([
            'idsector'    => 1,
            'nombre'      => 'Sector primario o agropecuario',
            'descripcion' => '',
        ]);

        Sector::create([
            'idsector'    => 2,
            'nombre'      => 'Sector secundario o industrial',
            'descripcion' => '',
        ]);

        Sector::create([
            'idsector'    => 3,
            'nombre'      => 'Sector terciario o de servicios',
            'descripcion' => '',
        ]);

        Sector::create([
            'idsector'    => 4,
            'nombre'      => 'No aplica',
            'descripcion' => '',
        ]);

    }
}
