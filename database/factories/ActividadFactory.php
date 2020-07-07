<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\{Actividad, Entidad, Gestor};
use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(Actividad::class, function (Faker $faker) {
    $entidadNodo = Entidad::has('nodo')->get()->random();
    $gestor = Gestor::where('nodo_id', $entidadNodo->nodo->id)->get()->random();

    return [
        'nodo_id' => $entidadNodo->nodo->id,
        'gestor_id' => $gestor->id,
        'codigo_actividad' => $faker->unique()->bothify('P####-######-###'),
        'nombre' => $faker->text($maxNbChars = 200),
        'objetivo_general' => $faker->text($maxNbChars = 500),
        'conclusiones' => $faker->text($maxNbChars = 1000),
        'aprobacion_dinamizador' => $faker->randomElement([1, 0]),
        'fecha_inicio' => $faker->randomElement([Carbon::now()->subYears($faker->randomDigit())->subMonth($faker->randomDigit()), Carbon::now()->subMonth($faker->randomDigit())]),
        'fecha_cierre' => $faker->randomElement([Carbon::now()->subYears($faker->randomDigit())->subMonth($faker->randomDigit()), Carbon::now()->subDays($faker->randomDigit())]),
        'formulario_inicio' => $faker->randomElement([1, 0]),
        'cronograma' => $faker->randomElement([1, 0]),
        'seguimiento' => $faker->randomElement([1, 0]),
        'evidencia_final' => $faker->randomElement([1, 0]),
        'formulario_final' => $faker->randomElement([1, 0]),
    ];
});
