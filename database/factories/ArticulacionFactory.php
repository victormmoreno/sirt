<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\{Articulacion, Fase, TipoArticulacion};
use Carbon\Carbon;

use Faker\Generator as Faker;

$factory->define(Articulacion::class, function (Faker $faker) {
    $tipoArticulacion = TipoArticulacion::all()->random();
    $fase = Fase::all()->random();
    return [
        'tipoarticulacion_id' => $tipoArticulacion->id,
        'tipo_articulacion' => $faker->randomElement([TipoArticulacion::IsGrupo(), TipoArticulacion::IsEmpresaEmprendedor()]),
        'fecha_ejecucion' => $faker->randomElement([Carbon::now()->subYears($faker->randomDigit())->subMonth($faker->randomDigit()), Carbon::now()]),
        'observaciones' => $faker->text($maxNbChars = 1000),
        'estado' => $faker->randomElement([Articulacion::IsInicio(), Articulacion::IsEjecucion(), Articulacion::IsCierre()]),
        'acc' => $faker->randomElement([1, null]),
        'informe_final' => $faker->randomElement([1, null]),
        'pantallazo' => $faker->randomElement([1, null]),
        'otros' => $faker->randomElement([1, null]),
        'acuerdos' => $faker->randomElement([$faker->text($maxNbChars = 1000), null]),
        'alcance_articulacion'  => $faker->randomElement([$faker->text($maxNbChars = 1000), null]),
        'siguientes_investigaciones'  => $faker->randomElement([$faker->text($maxNbChars = 1000), null]),
        'fase_id' => $fase->id
    ];
});
