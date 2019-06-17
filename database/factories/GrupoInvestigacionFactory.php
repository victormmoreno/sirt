<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\ClasificacionColciencias;
use App\Models\Entidad;
use App\Models\GrupoInvestigacion;
use Faker\Generator as Faker;

$factory->define(GrupoInvestigacion::class, function (Faker $faker) {
    return [
        'entidad_id'                  => Entidad::whereBetween('id', [119, 128])->get()->random()->id,
        'clasificacioncolciencias_id' => ClasificacionColciencias::all()->random()->id,
        'codigo_grupo'                => $faker->unique()->numberBetween($min = 1, $max = 900000),
        'tipogrupo'                   => $faker->randomElement([GrupoInvestigacion::IsInterno(), GrupoInvestigacion::IsExterno()]),
        'estado'                      => $faker->randomElement([GrupoInvestigacion::IsActive(), GrupoInvestigacion::IsInactive()]),
        'institucion'                 => $faker->word,
        'nombres_contacto'            => $faker->firstName . ' ' . $faker->lastName,
        'correo_contacto'             => $faker->safeEmail,
        'telefono_contacto'           => $faker->numerify('######'),
    ];
});
