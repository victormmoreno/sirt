<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\{Dinamizador, Nodo};
use App\User;
use Faker\Generator as Faker;

$factory->define(Dinamizador::class, function (Faker $faker) {

    $nodo = Nodo::has('entidad')->get()->random();

    return [
        'nodo_id' => $nodo->id,
    ];
});
