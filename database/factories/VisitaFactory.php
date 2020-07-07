<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\{IngresoVisitante, Entidad, Visitante, Servicio};
use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(IngresoVisitante::class, function (Faker $faker) {
    $entidad = Entidad::has('nodo')->get()->random();
    return [
        'visitante_id'    => Visitante::all()->random()->id,
        'nodo_id'    => $entidad->nodo->id,
        'servicio_id'    => Servicio::all()->random()->id,
        'fecha_ingreso'           => Carbon::now()->subDays($faker->randomDigit()),
        'hora_salida'             => Carbon::now()->addHours($faker->randomDigit())->hour,
        'descripcion'           => $faker->text($maxNbChars = 2000),
    ];
});
