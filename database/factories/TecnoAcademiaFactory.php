<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\{Tecnoacademia, Entidad, Regional};
use Faker\Generator as Faker;

$factory->define(Tecnoacademia::class, function (Faker $faker) {

    $centros = Entidad::has('centro')->get()->random();
    $regional = Regional::all()->random();

    return [
        'regional_id' => $regional->id,
        'centro_id' => $centros->centro->id,
    ];
});
