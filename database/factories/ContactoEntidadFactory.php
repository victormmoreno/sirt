	<?php

    /* @var $factory \Illuminate\Database\Eloquent\Factory */

    use App\Models\{ContactoEntidad, Entidad};
    use Faker\Generator as Faker;

    $factory->define(ContactoEntidad::class, function (Faker $faker) {
        $nodo = Entidad::has('nodo')->get()->random();
        return [
            'nodo_id'         => $nodo->nodo->id,
            'nombres_contacto'   => "{$faker->firstName} {$faker->lastName}",
            'correo_contacto'   => $faker->safeEmail,
            'telefono_contacto' => $faker->numerify('#######'),
        ];
    });
