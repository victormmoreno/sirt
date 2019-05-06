<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\TipoMaterial;
use Faker\Generator as Faker;

$factory->define(TipoMaterial::class, function (Faker $faker) {
    return [
        'nombre' => $faker->unique()->word,
    ];
});
