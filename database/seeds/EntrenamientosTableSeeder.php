<?php

use App\Models\Entrenamiento;
use Illuminate\Database\Seeder;

class EntrenamientosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Entrenamiento::class, 50)->create()
            ->each(function ($entrenamiento) {
                $entrenamiento->entrenamientosideas()->saveMany([factory(App\Models\EntrenamientoIdea::class)->make()]);
            });
    }
}
