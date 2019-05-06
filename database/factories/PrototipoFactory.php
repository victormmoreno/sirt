<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Prototipo;
use Faker\Generator as Faker;

$factory->define(Prototipo::class, function (Faker $faker) {
    return [
        'nombre'      => $faker->unique()->word,
        'descripcion' => $faker->text,
    ];
});
