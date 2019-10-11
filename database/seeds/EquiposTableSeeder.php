<?php

use App\Models\Equipo;
use Illuminate\Database\Seeder;

class EquiposTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Equipo::class, 40)->create();
    }
}
