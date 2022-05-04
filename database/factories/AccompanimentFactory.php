<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Accompaniment;
use App\Models\Sede;
use App\Models\Proyecto;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Accompaniment::class, function (Faker $faker) {
    return [
        'accompaniment_type' => $faker->randomElement([Proyecto::class, Sede::class]),
        'code' => $faker->unique()->bothify('ACO####-######-###'),
        'name' => $faker->sentence(),
        'description' => $faker->paragraph(),
        'scope' => $faker->paragraph(),
        'status' =>  $faker->randomElement([Accompaniment::STATUS_OPEN,Accompaniment::STATUS_CLOSE]),
        'start_date' => Carbon::now()->subMonths($faker->randomDigit()),
        'end_date' => Carbon::now()->subDays($faker->randomDigit()),
        'confidentiality_format' => $faker->randomElement([Accompaniment::CONFIDENCIALITY_FORMAT_YES,Accompaniment::CONFIDENCIALITY_FORMAT_NO]),
        'terms_verified_at' =>  Carbon::now()->subDays($faker->randomDigit()),
        'node_id' => 1,
        'interlocutor_talent_id' => 6176,
    ];
});
