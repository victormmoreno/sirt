<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */


use App\Models\Linea;
use Faker\Generator as Faker;

$factory->define(Linea::class, function (Faker $faker) {
    return [
        'abreviatura' => strtoupper($faker->lexify('???')),
        'nombre'      => $faker->word,
        'descripcion' => $faker->text,
    ];
});
