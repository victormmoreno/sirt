<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Sector;
use Faker\Generator as Faker;

$factory->define(Sector::class, function (Faker $faker) {
    return [
        'nombre'      => $faker->unique()->word,
        'descripcion' => $faker->paragraph(1),
    ];
});
