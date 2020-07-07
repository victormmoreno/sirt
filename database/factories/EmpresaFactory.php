<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\{Empresa, Sector, TipoEmpresa, TamanhoEmpresa};
use Faker\Generator as Faker;

$factory->define(Empresa::class, function (Faker $faker) {
    $sector = Sector::all()->random();
    $tipoEmpresa = TipoEmpresa::all()->random();
    $tamEmpresa = TamanhoEmpresa::all()->random();
    return [
        'sector_id'         => $sector->id,
        'tipoempresa_id'    => $tipoEmpresa->id,
        'tamanhoempresa_id'    => $tamEmpresa->id,
        'nit'    => $faker->unique()->numberBetween($min = 100, $max = 9000000),
        'codigo_ciiu'         => $faker->randomElement([$faker->unique()->numberBetween($min = 100, $max = 9000000), null]),
        'direccion'         => $faker->randomElement([$faker->streetAddress, null]),
    ];
});
