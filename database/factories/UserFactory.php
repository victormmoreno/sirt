<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\{Ciudad, Etnia, Eps, GradoEscolaridad, GrupoSanguineo, TipoDocumento};
use App\User;
use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(User::class, function (Faker $faker) {

    return [
        'tipodocumento_id'    => TipoDocumento::all()->random()->id,
        'gradoescolaridad_id' => GradoEscolaridad::all()->random()->id,
        'gruposanguineo_id'   => GrupoSanguineo::all()->random()->id,
        'eps_id'              => $eps = Eps::all()->random()->id,
        'ciudad_id'           => Ciudad::all()->random()->id,
        'ciudad_expedicion_id'  => Ciudad::all()->random()->id,
        'etnia_id'           => Etnia::inRandomOrder()->first()->id,
        'nombres'             => $faker->firstName,
        'apellidos'           => $faker->lastName,
        'documento'           => $faker->unique()->numberBetween($min = 1, $max = 9000000),
        'email'               => $faker->unique()->freeEmail,
        'barrio'              => $faker->streetName,
        'direccion'           => $faker->address,
        'telefono'            => $faker->numerify('######'),
        'celular'             => $faker->numberBetween($min = 1, $max = 900000),
        'fechanacimiento'     => Carbon::now()->subYears($faker->randomDigit())->subMonth($faker->randomDigit()),
        'genero'              => $faker->randomElement([User::IsMasculino(), User::IsFemenino()]),
        'otra_eps' => Eps::where('id', $eps)->first()->nombre ==  Eps::IsOtraEps() ? $faker->company : null,
        'grado_discapacidad' => $gradoDiscapacidad = $faker->randomElement([1, 0]),
        'descripcion_grado_discapacidad' => $gradoDiscapacidad == 1 ? $faker->word : null,
        'estado'              => $estado = $faker->randomElement([User::IsActive(), User::IsInactive()]),
        'institucion'         => $faker->company,
        'titulo_obtenido'     => $faker->jobTitle,
        'fecha_terminacion'   => Carbon::now()->subYears($faker->randomDigit()),
        'remember_token'      => Str::random(10),
        'ultimo_login'      => $faker->randomElement([Carbon::now(), null]),
        'password'            => 'tecnoparque',
        'estrato'             => $faker->randomElement([1, 2, 3, 4, 5, 6]),
        'deleted_at'         => $estado == User::IsActive() ? null : Carbon::now(),
    ];
});
