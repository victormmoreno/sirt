<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\{Ingreso, Nodo};
use Faker\Generator as Faker;

$factory->define(Ingreso::class, function (Faker $faker) {
    return [
        'nodo_id' => Nodo::all()->random()->id,
    ];
});
