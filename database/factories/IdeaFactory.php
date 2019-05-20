<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Idea;
use App\Models\Nodo;
use App\Models\EstadoIdea;
use Faker\Generator as Faker;

$factory->define(Idea::class, function (Faker $faker) {
    return [
        'fecha' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'nombrec'=> $faker->firstName,
        'apellidoc'=> $faker->lastName,
        'correo'=> $faker->unique()->safeEmail,
        'telefono'=> $faker->numerify('######'),
        'nombreproyecto'=> $faker->text($maxNbChars = 45),
        'aprendizsena'=> $faker->randomElement([1, 0]),
        'pregunta1'=> $faker->randomElement([1, 2,3,4,5,6,7,8,9]),
        'pregunta2'=> $faker->randomElement([1, 2,3,4]),
        'pregunta3'=> $faker->randomElement([1, 2,3,4,5,6]),
        'descripcion'=> $faker->text($maxNbChars = 45),
        'objetivo'=> $faker->text($maxNbChars = 45),
        'alcance'=> $faker->text($maxNbChars = 45),
        'tipoidea'=> $faker->randomElement([ Idea::IS_EMPRENDEDOR, Idea::IS_GRUPOINVESTIGACION_EMPRESA]),
        'nodo_id'=> Nodo::all()->random()->id,
        'estadoidea_id'=> EstadoIdea::FilterEstadoIdea('nombre','Inicio Emprendedor')->first()->id,
    ];
});
