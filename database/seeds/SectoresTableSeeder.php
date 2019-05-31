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
            'id'          => 1,
            'nombre'      => 'Sector primario o agropecuario',
        ]);

        Sector::create([
            'id'          => 2,
            'nombre'      => 'Sector secundario o industrial',
        ]);

        Sector::create([
            'id'          => 3,
            'nombre'      => 'Sector terciario o de servicios',
        ]);

        Sector::create([
            'id'          => 4,
            'nombre'      => 'No aplica',
        ]);

        // factory(Sector::class, 10)->create();
    }
}
