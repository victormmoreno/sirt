<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Entrenamiento;
use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(Entrenamiento::class, function (Faker $faker) {
    return [
        'fecha_sesion1'    => Carbon::now()->subDays($faker->randomDigit()),
        'fecha_sesion2'    => Carbon::now()->addDays($faker->randomDigit()),
        'codigo_entrenamiento'    => $faker->unique()->bothify('ENT####-######-###'),
        'correos'  => $faker->randomElement([1, 0]),
        'fotos'  => $faker->randomElement([1, 0]),
        'listado_asistencia' => $faker->randomElement([1, 0]),
    ];
});
