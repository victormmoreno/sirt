<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\{Comite, EstadoComite};
use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(Comite::class, function (Faker $faker) {
    $estadoComite = EstadoComite::all()->random();
    return [
        'codigo'    => $faker->unique()->bothify('CSB####-######-###'),
        'fechacomite'    => Carbon::now()->subDays($faker->randomDigit()),
        'correos'  => $faker->randomElement([1, 0]),
        'listado_asistencia' => $faker->randomElement([1, 0]),
        'otros'  => $faker->randomElement([1, 0]),
        'estado_comite_id'  => $estadoComite->id,
    ];
});
