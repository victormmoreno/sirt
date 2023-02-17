<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ArticulationSubtype;
use App\Models\ArticulationType;
use Faker\Generator as Faker;

$factory->define(ArticulationSubtype::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->text($maxNbChars = 15),
        'description' =>  $faker->text($maxNbChars = 2000),
        'entity' => json_encode([$faker->company,$faker->company]),
        'state' =>  $faker->randomElement([ArticulationSubtype::mostrar(), ArticulationSubtype::ocultar()]),
        'articulation_type_id' => function(){
            ArticulationType::all()->random()->id;
        }
    ];
});
