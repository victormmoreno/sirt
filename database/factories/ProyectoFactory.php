<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\{Proyecto, Idea, Sector, Sublinea, AreaConocimiento, Fase};
use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(Proyecto::class, function (Faker $faker) {
    $idea = Idea::all()->random();
    $sublinea = Sublinea::all()->random();
    $areaConocimiento = AreaConocimiento::all()->random();
    $fase = Fase::all()->random();
    return [
        'idea_id' => $idea->id,
        'sublinea_id' => $sublinea->id,
        'areaconocimiento_id' => $areaConocimiento->id,
        'fase_id' => $fase->id,
        'otro_areaconocimiento' => null,
        'alcance_proyecto' => null,
        'trl_esperado' => $faker->randomElement([1, 0]),
        'trl_obtenido' => $faker->randomElement([1, 0]),
        'trl_prototipo' => null,
        'trl_pruebas' => null,
        'trl_modelo' => null,
        'trl_normatividad' => null,
        'evidencia_trl' => $faker->randomElement([1, 0]),
        'dirigido_discapacitados' => $faker->randomElement([1, 0]),
        'tipo_discapacitados' => null,
        'economia_naranja' => $faker->randomElement([1, 0]),
        'tipo_economianaranja' => null,
        'fabrica_productividad' => $faker->randomElement([1, 0]),
        'doc_titular' => $faker->randomElement([1, 0]),
        'art_cti' => $faker->randomElement([1, 0]),
        'nom_act_cti' => null,
        'diri_ar_emp' => $faker->randomElement([1, 0]),
        'reci_ar_emp' => $faker->randomElement([1, 0]),
        'acc' => $faker->randomElement([1, 0]),
        'manual_uso_inf' => $faker->randomElement([1, 0]),
        'estado_arte' => $faker->randomElement([1, 0]),
    ];
});
