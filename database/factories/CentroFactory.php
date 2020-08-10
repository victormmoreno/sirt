<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\{Centro, Regional, Entidad};
use Faker\Generator as Faker;

$factory->define(Centro::class, function (Faker $faker) {
    return [
        'regional_id' => Regional::all()->random()->id,
        'codigo_centro' => $faker->unique()->numerify('####'),
    ];
});
