<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\AlcanceArticulacion;
use Faker\Generator as Faker;

$factory->define(AlcanceArticulacion::class, function (Faker $faker) {
    return [
        'nombre' => $faker->unique()->word,
    ];
});
