<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\TipoVinculacion;
use Faker\Generator as Faker;

$factory->define(TipoVinculacion::class, function (Faker $faker) {
    return [
        'nombre' => $faker->unique()->word,
    ];
});
