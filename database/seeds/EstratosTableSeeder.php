<?php

use App\Models\Estrato;
use Illuminate\Database\Seeder;

class EstratosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Estrato::create( [
		'id'=>1,
		'estrato'=>1,
		'nombre'=>'Bajo-bajo'
		] );


					
		Estrato::create( [
		'id'=>2,
		'estrato'=>2,
		'nombre'=>'Bajo'
		] );


					
		Estrato::create( [
		'id'=>3,
		'estrato'=>3,
		'nombre'=>'Medio-bajo'
		] );


					
		Estrato::create( [
		'id'=>4,
		'estrato'=>4,
		'nombre'=>'Medio'
		] );


					
		Estrato::create( [
		'id'=>5,
		'estrato'=>5,
		'nombre'=>'Medio-alto'
		] );


					
		Estrato::create( [
		'id'=>6,
		'estrato'=>6,
		'nombre'=>'Alto'
		] );
    }
}
