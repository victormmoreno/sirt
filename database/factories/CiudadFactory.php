<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Ciudad;
use App\Models\Departamento;
use Faker\Generator as Faker;

$factory->define(Ciudad::class, function (Faker $faker) {
    return [
        'nombre'          => $faker->unique()->city,
        'departamento_id' => Departamento::all()->random()->id,
    ];
});
