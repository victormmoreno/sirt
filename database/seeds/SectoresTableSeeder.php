<?php

use App\Models\Sector;
use Illuminate\Database\Seeder;

class SectoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sector::create([
            'nombre'      => 'Sector primario o agropecuario',
        ]);

        Sector::create([
            'nombre'      => 'Sector secundario o industrial',
        ]);

        Sector::create([
            'nombre'      => 'Sector terciario o de servicios',
        ]);

        Sector::create([
            'nombre'      => 'No aplica',
        ]);
    }
}
