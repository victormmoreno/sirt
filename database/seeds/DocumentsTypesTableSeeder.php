<?php

use App\DocumentType;
use Illuminate\Database\Seeder;

class DocumentsTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DocumentType::create( [
		'idtipodocumento'=>1,
		'abreviatura'=>'CC',
		'nombre'=>'Cédula de Ciudadanía',
		'estado'=>1
		] );


					
		DocumentType::create( [
		'idtipodocumento'=>2,
		'abreviatura'=>'TI',
		'nombre'=>'Tarjeta de Identidad',
		'estado'=>1
		] );


					
		DocumentType::create( [
		'idtipodocumento'=>3,
		'abreviatura'=>'CE',
		'nombre'=>'Cédula de Extranjería',
		'estado'=>1
		] );


					
		DocumentType::create( [
		'idtipodocumento'=>4,
		'abreviatura'=>'RC',
		'nombre'=>'Registro Civil',
		'estado'=>1
		] );
    }
}
