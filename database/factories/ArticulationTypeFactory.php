<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ArticulationType;
use Faker\Generator as Faker;

$factory->define(ArticulationType::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->text($maxNbChars = 15),
        'description' =>  $faker->text($maxNbChars = 2000),
        'entity' =>  $faker->company,
        'state' =>  $faker->randomElement([ArticulationType::mostrar(), ArticulationType::ocultar()])
    ];
});
