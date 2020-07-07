<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\{TipoVisitante, Visitante, TipoDocumento};

use Faker\Generator as Faker;

$factory->define(Visitante::class, function (Faker $faker) {
    return [
        'tipodocumento_id'    => TipoDocumento::all()->random()->id,
        'tipovisitante_id'    => TipoVisitante::all()->random()->id,
        'documento'           => $faker->unique()->numberBetween($min = 1, $max = 9000000),
        'nombres'             => $faker->firstName,
        'apellidos'           => $faker->lastName,
        'email'               => $faker->unique()->freeEmail,
        'contacto'            => $faker->numerify('#########'),
        'estado'              => $estado = $faker->randomElement([Visitante::IsActive(), Visitante::IsInactive()]),
    ];
});
