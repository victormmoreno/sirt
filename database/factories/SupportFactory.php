<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Support;
use Faker\Generator as Faker;

$factory->define(Support::class, function (Faker $faker) {
    return [
        'ticket'       => $faker->unique()->numerify('T#######'),
        'name'         => $faker->firstName,
        'lastname'     => $faker->lastName,
        'document'     => $faker->numberBetween($min = 1, $max = 9000000),
        'email'        => $faker->freeEmail,
        'phone'        => $faker->numberBetween($min = 1, $max = 900000),
        'subject'      => $faker->sentence($nbWords = 6, $variableNbWords = true),
        'description'  => $faker->text($maxNbChars = 400)    ,
        'difficulty'   => $faker->randomElement($array = ['Incidencia', 'Requerimiento']) ,
        'status'       => $faker->randomElement($array = ['Pendiente', 'En Espera', 'Solucionado'])
    ];
});
