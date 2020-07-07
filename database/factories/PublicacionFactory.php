<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Publicacion;
use App\User;
use Faker\Generator as Faker;
use Carbon\Carbon;


$factory->define(Publicacion::class, function (Faker $faker) {
    $user = User::role(config('laravelpermission.roles.roleDesarrollador'))->get()->random();
    $role = collect($user->roles)->first();
    return [
        'user_id' => $user->id,
        'role_id' => $role->id,
        'codigo_publicacion' => $faker->unique()->bothify('N####-######-###'),
        'titulo' => $faker->sentence($nbWords = 2, $variableNbWords = true),
        'contenido' => $faker->sentence($nbWords = 9, $variableNbWords = true),
        'fecha_inicio' => Carbon::now()->subYears($faker->randomDigit())->subMonth($faker->randomDigit()),
        'fecha_fin' => Carbon::now()->addYears($faker->randomDigit()),
        'estado' => $faker->randomElement([Publicacion::IsActiva(), Publicacion::IsInactiva()]),
    ];
});
