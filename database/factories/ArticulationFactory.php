<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Articulation;
use App\Models\Fase;
use App\Models\TipoArticulacion;
use App\Models\AlcanceArticulacion;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Articulation::class, function (Faker $faker) {
    return [
        'code' => $faker->unique()->bothify('A####-######-###'),
        'name' => $faker->sentence(),
        'description' => $faker->paragraph(),
        'start_date' => Carbon::now()->subDays($faker->randomDigit()),
        'expected_end_date' => Carbon::now()->subDays($faker->randomDigit()),
        'entity',
        'contact_name',
        'email_entity',
        'summon_name',
        'objective' => $faker->paragraph(),
        // 'accompaniment_id',
        'scope_id' => AlcanceArticulacion::all()->random()->id,
        'phase_id' => Fase::all()->random()->id,
        'articulation_type_id' => TipoArticulacion::all()->random()->id
    ];
});
