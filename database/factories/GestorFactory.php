<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\{Nodo, Gestor};
use Faker\Generator as Faker;

$factory->define(Gestor::class, function (Faker $faker) {
    $nodo = Nodo::has('lineas')->get()->random();
    return [
        'nodo_id'             => $nodo->id,
        'lineatecnologica_id' => $nodo->lineas->random()->id,
        'honorarios'          => $faker->numberBetween($min = 4000000, $max = 6500000),
    ];
});
