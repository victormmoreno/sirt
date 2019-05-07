<?php

use App\Models\Nodo;
use Illuminate\Database\Seeder;

class NodosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Nodo::create( [
'id'=>1,
'nombre'=>'Medellin',
'direccion'=>'Carrera 46 # 56-11. Edificio TecnoParque, Piso 6-7',
'anho_inicio'=>'2007',
'centroformacion_id'=>71
] );


			
Nodo::create( [
'id'=>2,
'nombre'=>'Rionegro',
'direccion'=>'Calle 41 Nº 50A – 324',
'anho_inicio'=>'2007',
'centroformacion_id'=>96
] );


			
Nodo::create( [
'id'=>3,
'nombre'=>'Calí',
'direccion'=>'Carrera 5 No. 11-68, Plaza de Caicedo Centro de Cali',
'anho_inicio'=>'2011',
'centroformacion_id'=>30
] );


			
Nodo::create( [
'id'=>4,
'nombre'=>'Bogotá DC',
'direccion'=>'Calle 54 No 10 – 39',
'anho_inicio'=>'2014',
'centroformacion_id'=>14
] );


			
Nodo::create( [
'id'=>5,
'nombre'=>'Cazuca',
'direccion'=>'Autopista Sur Transversal 7 No 8 – 40.TecnoParque Central',
'anho_inicio'=>'2009',
'centroformacion_id'=>105
] );


			
Nodo::create( [
'id'=>6,
'nombre'=>'Pereira',
'direccion'=>'Carrera 10 No. 17 - 15 Piso 2',
'anho_inicio'=>'2007',
'centroformacion_id'=>43
] );


			
Nodo::create( [
'id'=>7,
'nombre'=>'Neiva',
'direccion'=>'Diagonal 20 Nº 38 -16',
'anho_inicio'=>'2007',
'centroformacion_id'=>42
] );


			
Nodo::create( [
'id'=>8,
'nombre'=>'Bucaramanga',
'direccion'=>'Km 6 Autopista Florida Blanca # 50-33',
'anho_inicio'=>'2009',
'centroformacion_id'=>47
] );


			
Nodo::create( [
'id'=>9,
'nombre'=>'Manizales',
'direccion'=>'Kilómetro 10 Vía al Magdalena',
'anho_inicio'=>'2008',
'centroformacion_id'=>67
] );


			
Nodo::create( [
'id'=>10,
'nombre'=>'La Granja',
'direccion'=>'Km 5 Vía Espinal - Ibagué',
'anho_inicio'=>'2009',
'centroformacion_id'=>45
] );


			
Nodo::create( [
'id'=>11,
'nombre'=>'Pitalito',
'direccion'=>'Km 7 vía Pitalito, vereda Aguaduas',
'anho_inicio'=>'2012',
'centroformacion_id'=>85
] );


			
Nodo::create( [
'id'=>12,
'nombre'=>'Valledupar',
'direccion'=>'Carrera 19 entre Calles 14 y 15',
'anho_inicio'=>'2009',
'centroformacion_id'=>111
] );


			
Nodo::create( [
'id'=>13,
'nombre'=>'Ocaña',
'direccion'=>'Transversal 30 N° 7-110 La Primavera',
'anho_inicio'=>'2009',
'centroformacion_id'=>42
] );


			
Nodo::create( [
'id'=>14,
'nombre'=>'Angostura',
'direccion'=>'Km 38 Vía Neiva al Sur - Campo Alegre',
'anho_inicio'=>'2009',
'centroformacion_id'=>33
] );


			
Nodo::create( [
'id'=>15,
'nombre'=>'Socorro',
'direccion'=>'Calle 16 No. 14-28',
'anho_inicio'=>'2012',
'centroformacion_id'=>98
] );
    }
}
