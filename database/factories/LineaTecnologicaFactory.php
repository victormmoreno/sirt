<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */



use App\Models\LineaTecnologica;
use Faker\Generator as Faker;

$factory->define(LineaTecnologica::class, function (Faker $faker) {
    return [
        'abreviatura' => strtoupper($faker->lexify('???')),
        'nombre'      => $faker->unique()->word,
    ];
});
