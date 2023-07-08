<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ArticulationStage;
use App\Models\Nodo;
use App\User;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(ArticulationStage::class, function (Faker $faker) {
    return [
        'code' => $faker->unique()->bothify('ETA####-######-###'),
        'name' => $faker->sentence(),
        'description' => $faker->paragraph(),
        'expected_results' => $faker->paragraph(),
        'scope' => $faker->paragraph(),
        'status' =>  $faker->randomElement([ArticulationStage::STATUS_OPEN,ArticulationStage::STATUS_CLOSE]),
        'start_date' => Carbon::now()->subMonths($faker->randomDigit()),
        'end_date' => Carbon::now()->subDays($faker->randomDigit()),
        'terms_verified_at' =>  Carbon::now()->subDays($faker->randomDigit()),
        'node_id' => Nodo::has('entidad')->get()->random()->id,
        'interlocutor_talent_id' => User::query()->hasRole(User::IsTalento())->get()->random()->id,
        'created_by' => User::has('articulador')->get()->random()->id
    ];
});
