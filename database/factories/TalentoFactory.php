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
        'entidad_id' => TipoTalento::find($tipoTalento)->nombre == TipoTalento::IS_APRENDIZ_SENA_CON_APOYO ? $centro : TipoTalento::find($tipoTalento)->nombre == TipoTalento::IS_APRENDIZ_SENA_SIN_APOYO ? $centro : TipoTalento::find($tipoTalento)->nombre == TipoTalento::IS_EGRESADO_SENA ?  $centro : TipoTalento::find($tipoTalento)->nombre == TipoTalento::IS_INSTRUCTOR_SENA ?  $centro : TipoTalento::find($tipoTalento)->nombre == TipoTalento::IS_PROPIETARIO_EMPRESA ?   $noAplica : TipoTalento::find($tipoTalento)->nombre == TipoTalento::IS_EMPRENDEDOR ? $noAplica : TipoTalento::find($tipoTalento)->nombre == TipoTalento::IS_ESTUDIANTE_UNIVERSITARIO ?  $noAplica :
            TipoTalento::find($tipoTalento)->nombre == TipoTalento::IS_FUNCIONARIO_EMPRESA ?  $noAplica : $noAplica,
        'tipo_formacion_id' => TipoTalento::find($tipoTalento)->nombre == TipoTalento::IS_EGRESADO_SENA ?  $tipoFormacion : NULL,
        'tipo_estudio_id' => TipoTalento::find($tipoTalento)->nombre == TipoTalento::IS_ESTUDIANTE_UNIVERSITARIO ?  $tipoEstudio : NULL,
        'universidad' => TipoTalento::find($tipoTalento)->nombre == TipoTalento::IS_ESTUDIANTE_UNIVERSITARIO ?  $faker->company : NULL,
        'programa_formacion' => TipoTalento::find($tipoTalento)->nombre == TipoTalento::IS_APRENDIZ_SENA_CON_APOYO ? $faker->bs :
            TipoTalento::find($tipoTalento)->nombre == TipoTalento::IS_APRENDIZ_SENA_SIN_APOYO ? $faker->bs :
            TipoTalento::find($tipoTalento)->nombre == TipoTalento::IS_EGRESADO_SENA ?  $faker->bs :
            TipoTalento::find($tipoTalento)->nombre == TipoTalento::IS_INSTRUCTOR_SENA ?  $faker->bs : NULL,
        'empresa' =>  TipoTalento::find($tipoTalento)->nombre == TipoTalento::IS_FUNCIONARIO_EMPRESA ?  $faker->company : null,
        'dependencia' => TipoTalento::find($tipoTalento)->nombre == TipoTalento::IS_INSTRUCTOR_SENA ?  $faker->jobTitle : null,
        'otro_tipo_talento' => NULL,
    ];
});
