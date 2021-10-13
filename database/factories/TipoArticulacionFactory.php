<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\TipoArticulacion;
use Faker\Generator as Faker;

$factory->define(TipoArticulacion::class, function (Faker $faker) {
    return [
        'nombre' => $faker->unique()->text($maxNbChars = 15),
        'descripcion' =>  $faker->text($maxNbChars = 2000),
        'entidad' =>  $faker->company,
        'estado' =>  $faker->randomElement([TipoArticulacion::mostrar(), TipoArticulacion::ocultar()])
    ];
});
