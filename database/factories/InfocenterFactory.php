<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Infocenter;
use App\Models\Nodo;
use App\Models\Rols;
use Faker\Generator as Faker;

$factory->define(Infocenter::class, function (Faker $faker) {
    return [
        'nodo_id'   => Nodo::all()->random()->id,
        'user_id'   => Rols::where('nombre', '=', 'Infocenter')->get()->random()->id,
        'extension' => $faker->numerify('######'),
    ];
});
