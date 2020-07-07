<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\TipoDocumento;
use Faker\Generator as Faker;

$factory->define(TipoDocumento::class, function (Faker $faker) {
    return [
        'abreviatura' => strtoupper($faker->lexify('???')),
        'nombre'      => $faker->unique()->word,
    ];
});
