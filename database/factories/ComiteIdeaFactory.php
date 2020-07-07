<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\{ComiteIdea, Comite};
use App\Models\Idea;
use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(ComiteIdea::class, function (Faker $faker) {
    $idea = Idea::with([
        'estadoIdea' => function ($query) {
            $query->whereIn('nombre', ['Admitido', 'En Proyecto', 'Inhabilitado', 'No Admitido']);
        }
    ])->get()->random();
    $comite = Comite::all()->random();
    return [
        'idea_id'    =>  $idea->id,
        'comite_id'    =>  $comite->id,
        'hora'    => Carbon::now()->subDays($faker->randomDigit())->hour,
        'admitido'  => $faker->randomElement([1, 0]),
        'asistencia'  => $faker->randomElement([1, 0]),
        'observaciones'    => $faker->text($maxNbChars = 2000),
    ];
});
