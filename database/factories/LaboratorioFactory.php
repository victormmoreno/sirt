<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\{Laboratorio, Nodo};
use Faker\Generator as Faker;

$factory->define(Laboratorio::class, function (Faker $faker) {
    $nodo = Nodo::has('lineas')->get()->random();

    return [
        'nodo_id'              => $nodo->id,
        'lineatecnologica_id'  => $nodo->lineas->random()->id,
        'nombre'               => $faker->word,
        'participacion_costos' => $faker->unique()->numberBetween($min = 1, $max = 100),
        'estado'               => $faker->randomElement([Laboratorio::IsActive(), Laboratorio::IsInactive()]),
    ];
});
