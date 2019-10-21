<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\{Nodo, Material, TipoMaterial, CategoriaMaterial, Presentacion, Medida};
use Faker\Generator as Faker;

$factory->define(Material::class, function (Faker $faker) {

	$nodo = Nodo::with(['lineas'])->get()->random();

    return [
        'nodo_id' => $nodo->id,
        'lineatecnologica_id' => $nodo->lineas->first()->id,
        'tipomaterial_id' => TipoMaterial::all()->random()->id,
        'categoria_material_id' => CategoriaMaterial::all()->random()->id,
        'presentacion_id' => Presentacion::all()->random()->id,
        'medida_id' => Medida::all()->random()->id,
        'fecha' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'codigo_material' => $faker->unique()->numerify('MA-############'),
        'nombre' =>  $faker->unique()->sentence($nbWords = 2, $variableNbWords = true),
        'cantidad' => $faker->randomDigitNot(0),
        'valor_compra' => $faker->numerify('########'),
        'horas_uso_anio' => $faker->randomDigitNot(0),
        'proveedor' => $faker->company,
        'marca' =>$faker->word,
    ];
});
