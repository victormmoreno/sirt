<?php

use App\Models\GrupoSanguineo;
use Illuminate\Database\Seeder;

class GrupoSanguineosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GrupoSanguineo::create([
            'nombre' => 'O-',
        ]);

        GrupoSanguineo::create([
            'nombre' => 'O+',
        ]);

        GrupoSanguineo::create([
            'nombre' => 'A−',
        ]);

        GrupoSanguineo::create([
            'nombre' => 'A+',
        ]);

        GrupoSanguineo::create([
            'nombre' => 'B−',
        ]);

        GrupoSanguineo::create([
            'nombre' => 'B+',
        ]);

        GrupoSanguineo::create([
            'nombre' => 'AB−',
        ]);

        GrupoSanguineo::create([
            'nombre' => 'AB+',
        ]);
    }
}
