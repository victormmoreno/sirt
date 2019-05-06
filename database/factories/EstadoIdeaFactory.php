<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\EstadoIdea;
use Faker\Generator as Faker;

$factory->define(EstadoIdea::class, function (Faker $faker) {
    return [
        'nombre'      => $faker->unique()->word,
        'descripcion' => $faker->text,
    ];
});
