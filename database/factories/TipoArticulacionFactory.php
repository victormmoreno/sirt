<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\TipoArticulacion;
use Faker\Generator as Faker;

$factory->define(TipoArticulacion::class, function (Faker $faker) {
    return [
        'nombre' => $faker->unique()->word,
    ];
});
