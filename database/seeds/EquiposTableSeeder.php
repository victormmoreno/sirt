<?php

use App\Models\{Equipo, EquipoMantenimiento};
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
        factory(Equipo::class, 400)->create()
            ->each(function ($equipo) {
                $equipo->equiposmantenimientos()->saveMany([factory(EquipoMantenimiento::class)->make()]);
            });
    }
}
