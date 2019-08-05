	<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\{ContactoEntidad, Entidad, Nodo, Empresa, GrupoInvestigacion};
use Faker\Generator as Faker;

$factory->define(ContactoEntidad::class, function (Faker $faker) {
    $rand = array(Empresa::all()->random()->entidad_id, GrupoInvestigacion::all()->random()->entidad_id);
    $k = array_rand($rand);

    return [
        'nodo_id'         => Nodo::all()->random()->id,
        'entidad_id'        => $rand[$k],
        'nombres_contacto'   => $faker->firstName . ' ' . $faker->lastName,
        'correo_contacto'   => $faker->safeEmail,
        'telefono_contacto' => $faker->numerify('#######'),
    ];
});
