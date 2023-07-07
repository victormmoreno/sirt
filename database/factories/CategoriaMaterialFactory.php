<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\CategoriaMaterial;
use Faker\Generator as Faker;

$factory->define(CategoriaMaterial::class, function (Faker $faker) {
    return [
        'nombre' => $faker->unique()->word,
    ];
});
