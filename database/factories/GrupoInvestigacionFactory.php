<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\{ClasificacionColciencias, GrupoInvestigacion};
use Faker\Generator as Faker;

$factory->define(GrupoInvestigacion::class, function (Faker $faker) {
    $clasificacion = ClasificacionColciencias::all()->random();
    return [
        'clasificacioncolciencias_id' => $clasificacion->id,
        'codigo_grupo'                => $faker->unique()->bothify('COL#######'),
        'tipogrupo'                   => $faker->randomElement([GrupoInvestigacion::IsInterno(), GrupoInvestigacion::IsExterno()]),
        'estado'                      => $faker->randomElement([GrupoInvestigacion::IsActive(), GrupoInvestigacion::IsInactive()]),
        'institucion'                 => $faker->company,
    ];
});
