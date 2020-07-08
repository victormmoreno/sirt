<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\{EntrenamientoIdea, Idea};
use Faker\Generator as Faker;

$factory->define(EntrenamientoIdea::class, function (Faker $faker) {
    $idea = Idea::all()->random();
    return [
        'idea_id'    => $idea->id,
        'confirmacion'  => $faker->randomElement([1, 0]),
        'canvas'  => $faker->randomElement([1, 0]),
        'asistencia1' => $faker->randomElement([1, 0]),
        'asistencia2' => $faker->randomElement([1, 0]),
        'convocado_csibt' => $faker->randomElement([1, 0]),
    ];
});
