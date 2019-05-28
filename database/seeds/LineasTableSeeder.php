<?php

use Illuminate\Database\Seeder;
use App\Models\Linea;

class LineasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
  //       Linea::create( [
		// 'id'=>1,
		// 'abreviatura'=>'BIO',
		// 'nombre'=>'Biotecnonlogía y Nanotecnología',
		// 'descripcion'=>''
		// ] );
					
		// Linea::create( [
		// 'id'=>2,
		// 'abreviatura'=>'ETC',
		// 'nombre'=>'Electrónica y Telecomunicaciones',
		// 'descripcion'=>''
		// ] );
					
		// Linea::create( [
		// 'id'=>3,
		// 'abreviatura'=>'IND',
		// 'nombre'=>'Ingenieria y Diseño',
		// 'descripcion'=>''
		// ] );
					
		// Linea::create( [
		// 'id'=>4,
		// 'abreviatura'=>'TV',
		// 'nombre'=>'Tecnologías Virtuales',
		// 'descripcion'=>''
		// ] );

		factory(Linea::class, 10000)->create();
    }
}
