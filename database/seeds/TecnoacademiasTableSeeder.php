<?php

use Illuminate\Database\Seeder;
use App\Models\Tecnoacademia;

class TecnoacademiasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tecnoacademia::create([
            'id'          => 1,
            'regional_id' => 21,
            'entidad_id'  => 119,
            'centro_id'   => 24,
        ]);

        Tecnoacademia::create([
            'id'          => 2,
            'regional_id' => 24,
            'entidad_id'  => 120,
            'centro_id'   => 30,
        ]);

        Tecnoacademia::create([
            'id'          => 3,
            'regional_id' => 11,
            'entidad_id'  => 121,
            'centro_id'   => 104,
        ]);

        Tecnoacademia::create([
            'id'          => 4,
            'regional_id' => 23,
            'entidad_id'  => 122,
            'centro_id'   => 54,
        ]);

        Tecnoacademia::create([
            'id'          => 5,
            'regional_id' => 6,
            'entidad_id'  => 123,
            'centro_id'   => 66,
        ]);

        Tecnoacademia::create([
            'id'          => 6,
            'regional_id' => 1,
            'entidad_id'  => 124,
            'centro_id'   => 72,
        ]);

        Tecnoacademia::create([
            'id'          => 7,
            'regional_id' => 13,
            'entidad_id'  => 125,
            'centro_id'   => 79,
        ]);

        Tecnoacademia::create([
            'id'          => 8,
            'regional_id' => 20,
            'entidad_id'  => 126,
            'centro_id'   => 43,
        ]);

        Tecnoacademia::create([
            'id'          => 9,
            'regional_id' => 17,
            'entidad_id'  => 127,
            'centro_id'   => 56,
        ]);

        Tecnoacademia::create([
            'id'          => 10,
            'regional_id' => 18,
            'entidad_id'  => 128,
            'centro_id'   => 42,
        ]);
    }
}
