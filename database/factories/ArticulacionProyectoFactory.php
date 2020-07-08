<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ArticulacionProyecto;
use App\Models\Entidad;
use Faker\Generator as Faker;

$factory->define(ArticulacionProyecto::class, function (Faker $faker) {
    $gruposInvestigacion = Entidad::has('grupoinvestigacion')->get()->random();
    $entidad = Entidad::all()->first();
    $rand = [$gruposInvestigacion->id, $entidad->id];
    $k = array_rand($rand);

    return [
        'entidad_id' => $entidad->id,
        'aprobacion_dinamizador_ejecucion' => $faker->randomElement([1, 0]),
        'aprobacion_dinamizador_suspender' => $faker->randomElement([1, 0]),
        'revisado_final' => $faker->randomElement([1, 0]),
        'acta_inicio' => $faker->randomElement([1, 0]),
        'actas_seguimiento' => $faker->randomElement([1, 0]),
        'acta_cierre' => $faker->randomElement([1, 0]),
    ];
});
