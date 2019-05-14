<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\Ciudad;
use App\Models\Estrato;
use App\Models\Genero;
use App\Models\Ocupacion;
use App\Models\Rol;
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

        'documento'             => $faker->unique()->numberBetween($min = 1, $max = 9000000), // 'Hello 609',
        'nombres'               => $faker->firstName,
        'apellidos'             => $faker->lastName,
        'email'                 => $faker->unique()->safeEmail,
        'direccion'             => $faker->address,
        'telefono'              => $faker->numerify('######'),
        'celular'               => $faker->numberBetween($min = 1, $max = 900000),
        'fechanacimiento'       => $faker->date($format = 'Y-m-d', $max = 'now'),
        'descripcion_ocupacion' => $faker->text($maxNbChars = 45),
        'password'              => Hash::make('12345678'),
        'estado'                => $faker->boolean,
        'remember_token'        => Str::random(10),
        'genero_id'             => Genero::where('nombre', '=', 'Masculino')->first()->id,
        'tipodocumento_id'      => TipoDocumento::where('abreviatura', '=', 'CC')->first()->id,
        'ciudad_id'             => Ciudad::all()->random()->id,
        'rol_id'                => Rol::where('nombre', '=', 'Administrador')->first()->id,
        'ocupacion_id'          => Ocupacion::where('nombre', '=', 'Empleado')->first()->id,
        'estrato_id'            => Estrato::where('estrato', '=', 1)->first()->id,
    ];
});
