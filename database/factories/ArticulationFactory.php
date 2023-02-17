<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Articulation;
use App\Models\Fase;
use App\Models\ArticulationSubType;
use App\Models\AlcanceArticulacion;
use App\User;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Articulation::class, function (Faker $faker) {
    return [
        'code' => $faker->unique()->bothify('A####-######-###'),
        'name' => $faker->sentence(),
        'description' => $faker->paragraph(),
        'start_date' => Carbon::now()->subMonths($faker->randomDigit()),
        'end_date' => Carbon::now()->subMonths($faker->randomDigit()),
        'expected_end_date' => Carbon::now()->subDays($faker->randomDigit()),
        'entity' => $faker->company(),
        'contact_name' => $faker->phoneNumber(),
        'email_entity' => $faker->companyEmail(),
        'summon_name' => $faker->sentence(),
        'objective' => $faker->paragraph(),
        'scope_id' => AlcanceArticulacion::all()->random()->id,
        'phase_id' =>
            Fase::whereIn('nombre', [
                Articulation::START_PHASE,
                Articulation::EXECUTION_PHASE,
                Articulation::CLOSING_PHASE,
                Articulation::FINISHED_PHASE,
                Articulation::SUSPENDED_PHASE
            ])->get()->random()->id,
        'articulation_subtype_id' => ArticulationSubtype::all()->random()->id,
        'created_by' =>User::has('articulador')->get()->random()->id

    ];
});
