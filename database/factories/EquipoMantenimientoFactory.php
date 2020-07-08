<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\EquipoMantenimiento;
use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(EquipoMantenimiento::class, function (Faker $faker) {
    return [
        'ultimo_anio_mantenimiento'         => Carbon::now()->subYears($faker->randomDigit())->year,
        'valor_mantenimiento'          => $faker->numerify('########'),
    ];
});
