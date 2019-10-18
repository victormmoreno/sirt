<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Presentacion;
use Faker\Generator as Faker;

$factory->define(Presentacion::class, function (Faker $faker) {
    return [
        'nombre'      => $faker->unique()->word,
    ];
});
