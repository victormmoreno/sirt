<?php

use App\Models\Actividad;
use App\Models\ArticulacionProyecto;
use App\Models\Proyecto;
use App\User;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class ActividadesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::has('talento')->get()->random();
        factory(Actividad::class, 20)->create()
            ->each(function ($actividad) use ($user) {
                $actividad->articulacion_proyecto()->save(factory(ArticulacionProyecto::class)->make());
                $actividad->articulacion_proyecto->proyecto()->save(factory(Proyecto::class)->make());
                $actividad->articulacion_proyecto->talentos()->sync($user->talento->id);
            });
    }
}
