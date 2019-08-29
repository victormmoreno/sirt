<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Laboratorio;
use App\Models\LineaTecnologica;
use App\Models\Nodo;
use Faker\Generator as Faker;

$factory->define(Laboratorio::class, function (Faker $faker) {
    return [
        'nodo_id' => Nodo::join('entidades', 'entidades.id', 'nodos.entidad_id')->where('entidades.nombre', '=', 'Medellin')->first()->id,
        'lineatecnologica_id' => LineaTecnologica::all()->random()->id,
        'nombre' => $faker->unique()->word,
        'participacion_costos' => $faker->unique()->numberBetween($min = 1, $max = 100),
        'estado' => $faker->randomElement([Laboratorio::IsActive(), Laboratorio::IsInactive()]),
    ];
});
