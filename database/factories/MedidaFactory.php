<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Medida;
use Faker\Generator as Faker;

$factory->define(Medida::class, function (Faker $faker) {
    return [
        'nombre'      => $faker->unique()->word,
    ];
});
