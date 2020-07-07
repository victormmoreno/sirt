	<?php

    /* @var $factory \Illuminate\Database\Eloquent\Factory */

    use App\Models\{ContactoEntidad, Entidad};
    use Faker\Generator as Faker;

    $factory->define(ContactoEntidad::class, function (Faker $faker) {
        // $empresa = Entidad::has('empresa')->get()->random();
        // $grupoinvestigacion = Entidad::has('grupoinvestigacion')->get()->random();
        $nodo = Entidad::has('nodo')->get()->random();
        // $rand = [$empresa->id, $grupoinvestigacion->id];
        // $k = array_rand($rand);

        return [
            'nodo_id'         => $nodo->nodo->id,
            'nombres_contacto'   => "{$faker->firstName} {$faker->lastName}",
            'correo_contacto'   => $faker->safeEmail,
            'telefono_contacto' => $faker->numerify('#######'),
        ];
    });
