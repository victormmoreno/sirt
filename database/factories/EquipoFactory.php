<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Equipo;
use App\Models\Nodo;
use Faker\Generator as Faker;

$factory->define(Equipo::class, function (Faker $faker) {
	$nodo = Nodo::with(['lineas'])->get()->random();
    return [
        'nodo_id'             => $nodo->id,
        'lineatecnologica_id' => $nodo->lineas->first()->id,
        'referencia'          => $faker->text($maxNbChars = 50),
        'nombre'              => $faker->word,
        'marca'               => $faker->word,
        'costo_adquisicion'   => $faker->numerify('########'),
        'vida_util'           => $faker->numerify('##'),
        'anio_compra'         => $faker->date($format = 'Y',$min = 2016, $max = 'now'),
        'horas_uso_anio'      => $faker->numerify('##'),
    ];
});
