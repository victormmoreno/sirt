<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\{Articulacion, Fase};
use Faker\Generator as Faker;

$factory->define(Articulacion::class, function (Faker $faker) {

    $fase = Fase::all()->random();
    return [
        'tipo_articulacion' => $faker->randomElement([Articulacion::IsGrupo(), Articulacion::IsEmpresa(), Articulacion::IsEmprendedor()]),
        'acc' => $faker->randomElement([1, null]),
        'informe_final' => $faker->randomElement([1, null]),
        'acuerdos' => $faker->randomElement([$faker->text($maxNbChars = 1000), null]),
        'alcance_articulacion'  => $faker->randomElement([$faker->text($maxNbChars = 1000), null]),
        'siguientes_investigaciones'  => $faker->randomElement([$faker->text($maxNbChars = 1000), null]),
        'fase_id' => $fase->id
    ];
});
