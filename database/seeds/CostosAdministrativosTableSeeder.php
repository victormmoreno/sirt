<?php

use App\Models\CostoAdministrativo;
use App\Models\Nodo;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CostosAdministrativosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CostoAdministrativo::create([
            'nombre' => 'Servicios Públicos',
        ]);

        CostoAdministrativo::create([
            'nombre' => 'Administración edificio',
        ]);

        CostoAdministrativo::create([
            'nombre' => 'Servicio de vigilancia',
        ]);

        CostoAdministrativo::create([
            'nombre' => 'Servicio de aseo y cafeteria',
        ]);

        CostoAdministrativo::create([
            'nombre' => 'Enlace',
        ]);

        CostoAdministrativo::create([
            'nombre' => 'Servicios Administrativos',
        ]);

        CostoAdministrativo::create([
            'nombre' => 'Dinamizador',
        ]);

        CostoAdministrativo::create([
            'nombre' => 'Infocenter',
        ]);

        $costos = CostoAdministrativo::all();
        $nodos = Nodo::all();


        if (!$costos->isEmpty() && !$nodos->isEmpty()) {
            $syncData = array();
            foreach ($costos as $id => $value) {
                $syncData[$id] = array('costo_administrativo_id' => $value->id,  'anho' =>Carbon::now()->year, 'valor' => 0);
            }

            foreach ($nodos as $key => $nodo) {
                $nodo->costoadministrativonodo()->attach($syncData);
            }
        }
    }
}
