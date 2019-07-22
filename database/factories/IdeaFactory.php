<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Idea;
use App\Models\Nodo;
use App\Models\EstadoIdea;
use Faker\Generator as Faker;

$factory->define(Idea::class, function (Faker $faker) {
    return [
        // 'fecha' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'nombres_contacto'=> $faker->firstName,
        'apellidos_contacto'=> $faker->lastName,
        'correo_contacto'=> $faker->unique()->safeEmail,
        'telefono_contacto'=> $faker->numerify('######'),
        'nombre_proyecto'=> $faker->text($maxNbChars = 45),
        'aprendiz_sena'=> $faker->randomElement([1, 0]),
        'pregunta1'=> $faker->randomElement([1, 2,3,4,5,6,7,8,9]),
        'pregunta2'=> $faker->randomElement([1, 2,3,4]),
        'pregunta3'=> $faker->randomElement([1, 2,3,4,5,6]),
        'descripcion'=> $faker->text($maxNbChars = 45),
        'objetivo'=> $faker->text($maxNbChars = 45),
        'alcance'=> $faker->text($maxNbChars = 45),
        'tipo_idea'=> $faker->randomElement([ Idea::IS_EMPRENDEDOR, Idea::IS_GRUPOINVESTIGACION]),
        'nodo_id'=> Nodo::join('entidades','entidades.id','nodos.entidad_id')->where('entidades.nombre', '=', 'Medellin')->first()->id,
        'estadoidea_id'=> 1,
    ];
});
