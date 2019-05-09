<?php

use App\Models\Genero;
use Illuminate\Database\Seeder;

class GenerosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Genero::create([
            'id'          => 1,
            'abreviatura' => 'M',
            'nombre'      => 'Masculino',
        ]);

        Genero::create([
            'id'          => 2,
            'abreviatura' => 'F',
            'nombre'      => 'Femenino',
        ]);
    }
}
