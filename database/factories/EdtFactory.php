<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Edt;
use App\Models\AreaConocimiento;
use App\Models\TipoEdt;
use Faker\Generator as Faker;

$factory->define(Edt::class, function (Faker $faker) {
    $areaConocimiento = AreaConocimiento::all()->random();
    $tipoEdt = TipoEdt::all()->random();
    return [
        'areaconocimiento_id' => $areaConocimiento->id,
        'tipoedt_id' => $tipoEdt->id,
        'observaciones' => $faker->text($maxNbChars = 1000),
        'empleados' =>  $faker->randomElement([$faker->randomDigit, 0]),
        'instructores' =>  $faker->randomElement([$faker->randomDigit, 0]),
        'aprendices' =>  $faker->randomElement([$faker->randomDigit, 0]),
        'publico' =>  $faker->randomElement([$faker->randomDigit, 0]),
        'estado' =>  $faker->randomElement([Edt::IsActive(), Edt::IsInactive()]),
        'fotografias' =>  $faker->randomElement([1, 0]),
        'listado_asistencia' =>  $faker->randomElement([1, 0]),
        'informe_final' =>  $faker->randomElement([1, 0]),
    ];
});
