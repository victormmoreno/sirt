<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ArticulacionPbt;
use App\Models\Actividad;
use App\Models\Proyecto;
use App\Models\Fase;
use App\Models\TipoArticulacion;
use App\Models\AlcanceArticulacion;
use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(ArticulacionPbt::class, function (Faker $faker) {
    return [
        'actividad_id' => Actividad::all()->last()->id,
        'proyecto_id' => Proyecto::all()->random()->id,
        'fase_id' =>  Fase::all()->random()->id,
        'tipo_articulacion_id' => TipoArticulacion::all()->random()->id,
        'alcance_articulacion_id' => AlcanceArticulacion::all()->random()->id,
        'entidad' => $faker->unique()->company,
        'nombre_contacto' => "{$faker->firstName} {$faker->lastName}",
        'email_entidad' => $faker->unique()->freeEmail,
        'nombre_convocatoria' => $faker->word,
        'objetivo' => $faker->text($maxNbChars = 100),
        'fecha_esperada_finalizacion' => $faker->randomElement([Carbon::now()->subYears($faker->randomDigit())->subMonth($faker->randomDigit()), Carbon::now()->subDays($faker->randomDigit())]),
        'lecciones_aprendidas' => $faker->text($maxNbChars = 100),
    ];
});
