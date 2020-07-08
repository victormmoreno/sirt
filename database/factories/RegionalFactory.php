<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\{Regional, Ciudad};
use Faker\Generator as Faker;

$factory->define(Regional::class, function (Faker $faker) {
    return [
        'ciudad_id' => Ciudad::all()->random()->id,
        'nombre' =>  $faker->unique()->city,
        'codigo_regional' => $faker->unique()->randomNumber($nbDigits = NULL, $strict = false),
        'direccion' =>  $faker->streetAddress,
        'telefono' => $faker->numerify('######'),

    ];
});
