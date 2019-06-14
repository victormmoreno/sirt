<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Ocupacion;
use Faker\Generator as Faker;

$factory->define(Ocupacion::class, function (Faker $faker) {
    return [
        'nombre'      => $faker->unique()->word,
    ];
});
