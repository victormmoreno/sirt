<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\{CharlaInformativa, Entidad};
use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(CharlaInformativa::class, function (Faker $faker) {
    $entidad = Entidad::has('nodo')->get()->random();
    return [
        'nodo_id'    =>  $entidad->nodo->id,
        'codigo_charla'    =>  $faker->unique()->bothify('CI####-######-###'),
        'fecha'    => Carbon::now()->subYears($faker->randomDigit())->subDays($faker->randomDigit()),
        'encargado'  => "{$faker->firstName} {$faker->lastName}",
        'nro_asistentes'  => $faker->randomNumber(),
        'observacion'    => $faker->text($maxNbChars = 1000),
        'listado_asistentes' => $faker->randomElement([1, 0]),
        'evidencia_fotografica' => $faker->randomElement([1, 0]),
        'programacion' => $faker->randomElement([1, 0]),
        'estado' => $faker->randomElement([CharlaInformativa::IsActive(), CharlaInformativa::IsInactive()]),
    ];
});
