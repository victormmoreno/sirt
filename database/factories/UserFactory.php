<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\GradoEscolaridad;
use App\Models\GrupoSanguineo;
use App\Models\Rols;
use App\Models\TipoDocumento;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
 */

$factory->define(User::class, function (Faker $faker) {

    return [

        'rol_id'              => Rols::all()->random()->id,
        'gradoescolaridad_id' => GradoEscolaridad::all()->random()->id,
        'tipodocumento_id'    => TipoDocumento::all()->random()->id,
        'gruposanguineo_id'   => GrupoSanguineo::all()->random()->id,
        'eps_id'              => Eps::all()->random()->id,
        'nombres'             => $faker->firstName,
        'apellidos'           => $faker->lastName,
        'documento'           => $faker->unique()->numberBetween($min = 1, $max = 9000000),
        'email'               => $faker->unique()->safeEmail,
        'direccion'           => $faker->address,
        'telefono'            => $faker->numerify('######'),
        'celular'             => $faker->numberBetween($min = 1, $max = 900000),
        'fechanacimiento'     => $faker->date($format = 'Y-m-d', $max = 'now'),
        'genero'              => $faker->randomElement([User::IS_MASCULINO, User::IS_FEMENINO]),
        'estado'              => $faker->boolean,
        'password'            => Hash::make('12345678'),
        'remember_token'      => Str::random(10),
        'estrato'             => rand(1, 6),

    ];
});
