<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Empresa;
use App\Models\Entidad;
use App\Models\Sector;
use Faker\Generator as Faker;

$factory->define(Empresa::class, function (Faker $faker) {
    return [
        'entidad_id'        => Entidad::whereBetween('id', [129, 217])->get()->random()->id,
        'sector_id'         => Sector::all()->random()->id,
        'nit'               => $faker->unique()->numberBetween($min = 100, $max = 9000000),
        'direccion'         => $faker->streetAddress,
        'nombre_contacto'   => $faker->firstName . ' ' . $faker->lastName,
        'correo_contacto'   => $faker->safeEmail,
        'telefono_contacto' => $faker->numerify('######'),
    ];
});
