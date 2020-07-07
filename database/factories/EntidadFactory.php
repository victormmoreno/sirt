<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */


use App\Models\Ciudad;
use App\Models\Entidad;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Entidad::class, function (Faker $faker) {
    return [
        'ciudad_id' => Ciudad::all()->random()->id,
        'nombre' => $company = $faker->unique()->company,
        'slug' => Str::slug($company),
        'email_entidad' => $faker->companyEmail,
    ];
});
