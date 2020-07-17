<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\{Equipo, Nodo};
use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(Equipo::class, function (Faker $faker) {
    $nodo = Nodo::has('lineas')->get()->random();
    return [
        'nodo_id'             => $nodo->id,
        'lineatecnologica_id' => $nodo->lineas->random()->id,
        'referencia'          => $faker->text($maxNbChars = 50),
        'nombre'              => $faker->word,
        'marca'               => $faker->word,
        'costo_adquisicion'   => $faker->numerify('########'),
        'vida_util'           => $faker->numerify('##'),
        'anio_compra'         => Carbon::now()->subYears($faker->randomDigit())->year,
        'horas_uso_anio'      => $faker->numerify('###'),
    ];
});
