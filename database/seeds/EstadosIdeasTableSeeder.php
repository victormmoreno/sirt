<?php

use Illuminate\Database\Seeder;
use App\Models\EstadoIdea;

class EstadosIdeasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
						
			EstadoIdea::create( [
			'id'=>1,
			'nombre'=>'Inicio Emprendedor',
			'descripcion'=>''
			] );
						
			EstadoIdea::create( [
			'id'=>2,
			'nombre'=>'Aprobado Emprendedor',
			'descripcion'=>''
			] );
						
			EstadoIdea::create( [
			'id'=>3,
			'nombre'=>'Asociado Emprendedor',
			'descripcion'=>''
			] );
						
			EstadoIdea::create( [
			'id'=>4,
			'nombre'=>'Entrenamiento Emprendedor',
			'descripcion'=>''
			] );
						
			EstadoIdea::create( [
			'id'=>5,
			'nombre'=>'Comite Emprendedor',
			'descripcion'=>''
			] );
						
			EstadoIdea::create( [
			'id'=>6,
			'nombre'=>'Asociado Empresa-grupos',
			'descripcion'=>''
			] );
						
			EstadoIdea::create( [
			'id'=>7,
			'nombre'=>'No Aprobada',
			'descripcion'=>''
			] );
						
			EstadoIdea::create( [
			'id'=>8,
			'nombre'=>'Inhabilitada',
			'descripcion'=>''
			] );
						
			EstadoIdea::create( [
			'id'=>9,
			'nombre'=>'No Aplica',
			'descripcion'=>''
			] );

			 EstadoIdea::create( [
			'id'=>10,
			'nombre'=>'Inicial empresa-grupos',
			'descripcion'=>''
			] );

			 // factory(EstadoIdea::class, 5)->create();
    }
}
