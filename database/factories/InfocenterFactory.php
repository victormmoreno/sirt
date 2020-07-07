<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\{Nodo, Infocenter};
use Faker\Generator as Faker;

$factory->define(Infocenter::class, function (Faker $faker) {
    return [
        'nodo_id'   => Nodo::all()->random()->id,
        'extension' => $faker->numerify('######'),
    ];
});
