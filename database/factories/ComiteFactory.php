<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Comite;
use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(Comite::class, function (Faker $faker) {
    return [
        'codigo'    => $faker->unique()->bothify('CSB####-######-###'),
        'fechacomite'    => Carbon::now()->subDays($faker->randomDigit()),
        'observaciones'    => $faker->text($maxNbChars = 1000),
        'correos'  => $faker->randomElement([1, 0]),
        'listado_asistencia' => $faker->randomElement([1, 0]),
        'otros'  => $faker->randomElement([1, 0]),
    ];
});
