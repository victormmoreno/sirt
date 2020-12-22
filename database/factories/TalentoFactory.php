<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\{Centro, Empresa, Entidad, Talento, TipoEstudio, TipoTalento, TipoFormacion};
use Faker\Generator as Faker;

$factory->define(Talento::class, function (Faker $faker) {

    $tipoTalento = TipoTalento::all()->random();
    $centro = Centro::all()->random()->id;
    $noAplica = Entidad::where('nombre', 'No Aplica')->first()->id;
    $tipoFormacion = TipoFormacion::all()->random()->id;
    $tipoEstudio = TipoEstudio::all()->random()->id;

    return [
        'tipo_talento_id' => $tipoTalento = $tipoTalento->id,
        'tipo_formacion_id' => TipoTalento::find($tipoTalento)->nombre == TipoTalento::IS_EGRESADO_SENA ?  $tipoFormacion : NULL,
        'tipo_estudio_id' => TipoTalento::find($tipoTalento)->nombre == TipoTalento::IS_ESTUDIANTE_UNIVERSITARIO ?  $tipoEstudio : NULL,
        'universidad' => TipoTalento::find($tipoTalento)->nombre == TipoTalento::IS_ESTUDIANTE_UNIVERSITARIO ?  $faker->company : NULL,
        'programa_formacion' => NULL,
        'empresa' =>  TipoTalento::find($tipoTalento)->nombre == TipoTalento::IS_FUNCIONARIO_EMPRESA ?  $faker->company : null,
        'dependencia' => TipoTalento::find($tipoTalento)->nombre == TipoTalento::IS_INSTRUCTOR_SENA ?  $faker->jobTitle : null,
    ];
});
