<?php

use Illuminate\Database\Seeder;
use App\Models\CostoAdministrativo;
use App\User;

class EliminateAdministrativeCostsPassedOnToUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $costs = CostoAdministrativo::query()
                ->select('costos_administrativos.id','nodo_costoadministrativo.anho as year','entidades.nombre as nodo', 'costos_administrativos.nombre as nombre', 'nodo_costoadministrativo.valor')
                ->join('nodo_costoadministrativo', 'nodo_costoadministrativo.costo_administrativo_id', '=', 'costos_administrativos.id')
                ->join('nodos', 'nodos.id', '=', 'nodo_costoadministrativo.nodo_id')
                ->join('entidades', 'entidades.id', '=', 'nodos.entidad_id')
                ->whereIn('costos_administrativos.nombre',[
                    User::IsDinamizador(),
                    User::IsInfocenter(),
                    'Técnico de Apoyo (sumatoria de los salarios de todos los apoyos)'
                ])
                ->orderBy('nodo', 'asc')
                ->get();
        if(isset($costs) && $costs->count() > 0){
            $costs->map(function($cost){
                // echo "{$cost->year} | {$cost->nodo} | {$cost->nombre} | {$cost->valor}" .PHP_EOL ;
                DB::table('nodo_costoadministrativo')
                ->where('costo_administrativo_id', $cost->id)
                ->delete();
            });

            DB::table('costos_administrativos')
            ->whereIn('costos_administrativos.nombre',[
                User::IsDinamizador(),
                User::IsInfocenter(),
                'Técnico de Apoyo (sumatoria de los salarios de todos los apoyos)'
            ])->delete();
        }
    }
}
