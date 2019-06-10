<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Gestor;
use App\Models\LineaTecnologica;
use App\Models\Nodo;
use App\Models\Rols;
use App\User;
use Faker\Generator as Faker;

$factory->define(Gestor::class, function (Faker $faker) {
    return [
        'user_id'             => Rols::where('nombre','=','Gestor')->get()->random()->id,
        'nodo_id'             => Nodo::all()->random()->id,
        'lineatecnologica_id' => LineaTecnologica::all()->random()->id,
        'honorarios'          => $faker->numberBetween($min = 1, $max = 9000000),
    ];
});
