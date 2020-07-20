<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\UsoInfraestructura;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(UsoInfraestructura::class, function (Faker $faker) {
    return [
        'tipo_usoinfraestructura' => $faker->randomElement([UsoInfraestructura::IsProyecto(), UsoInfraestructura::IsArticulacion()]),
        'fecha' => Carbon::now()->subDays($faker->randomDigit()),
        'descripcion' => $faker->text($maxNbChars = 2000),
        'estado' => $faker->randomElement([1, 0]),
    ];
});
