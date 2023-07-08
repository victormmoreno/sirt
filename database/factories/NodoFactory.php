<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\{Entidad, Nodo};
use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(Nodo::class, function (Faker $faker) {

    $centros = Entidad::has('centro')->get()->random();
    return [
        'centro_id' => $centros->centro->id,
        'direccion' => $faker->streetAddress,
        'telefono' => $faker->numerify('######'),
        'anho_inicio' => Carbon::now()->subYears($faker->randomDigit())->year,
    ];
});
