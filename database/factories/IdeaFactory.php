<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\{Entidad, Idea, EstadoIdea};
use App\User;
use Faker\Generator as Faker;

$factory->define(Idea::class, function (Faker $faker) {

    $userinfocenter = User::all()->random();
    $usergestor = User::all()->random();
    $entidadInfocenter = Entidad::has('nodo')->whereHas('nodo', function ($query) use ($userinfocenter) {
        return $query->where('id', $userinfocenter->infocenter->nodo_id);
    })->get()->random();
    $estadoIdea = EstadoIdea::all()->random();

    return [
        'nodo_id' => $entidadInfocenter->nodo->id,
        'estadoidea_id' => $estado = $estadoIdea->id,
        'nombres_contacto' => $faker->firstName,
        'apellidos_contacto' => $faker->lastName,
        'correo_contacto' => $faker->unique()->freeEmail,
        'telefono_contacto' => $faker->numerify('#######'),
        'nombre_proyecto' => $faker->text($maxNbChars = 200),
        'codigo_idea' => $faker->unique()->bothify('I####-######-###'),
        'aprendiz_sena' => $faker->randomElement([1, 0]),
        'pregunta1' => $faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9]),
        'pregunta2' => $faker->randomElement([1, 2, 3, 4]),
        'pregunta3' => $faker->randomElement([1, 2, 3, 4, 5, 6]),
        'descripcion' => $faker->text($maxNbChars = 2000),
        'objetivo' => $faker->text($maxNbChars = 2000),
        'alcance' => $faker->text($maxNbChars = 2000),
        'viene_convocatoria' => $vieneConvocatoria = $faker->randomElement([1, 0]),
        'convocatoria' => $vieneConvocatoria == 1 ? $faker->text($maxNbChars = 100) : null,
        'aval_empresa' => $avalEmpresa = $faker->randomElement([1, 0]),
        'empresa' => $avalEmpresa == 1 ? $faker->company : null,
    ];
});
