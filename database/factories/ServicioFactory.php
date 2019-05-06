<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Servicio;
use Faker\Generator as Faker;

$factory->define(Servicio::class, function (Faker $faker) {
    return [
        'nombre'      => $faker->unique()->word,
        'descripcion' => $faker->text,
    ];
});
