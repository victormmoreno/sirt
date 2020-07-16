<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ObjetivoEspecifico;
use Faker\Generator as Faker;

$factory->define(ObjetivoEspecifico::class, function (Faker $faker) {

    return [
        'objetivo' => $faker->text($maxNbChars = 500),
        'cumplido' => $faker->randomElement([1, 0]),
    ];
});
