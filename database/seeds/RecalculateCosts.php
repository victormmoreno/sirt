<?php

use App\User;
use App\Models\UsoInfraestructura;
use App\Models\Equipo;
use App\Models\EquipoMantenimiento;
use App\Models\CostoAdministrativo;
use App\Models\Fase;
use App\Models\Material;
use App\Models\Nodo;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class RecalculateCosts extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usos = UsoInfraestructura::query()
                ->selectRaw("usoinfraestructuras.id as 'id_uso', pro.nodo_id, usoinfraestructuras.codigo, usoinfraestructuras.asesorable_type, usoinfraestructuras.fecha, usoinfraestructuras.created_at, pro.codigo_proyecto AS 'codigo pbt', pro.nombre AS 'nombre pbt', GROUP_CONCAT(DISTINCT euso.tiempo SEPARATOR ', ') AS tiempo, SUM(DISTINCT euso.tiempo) AS 'suma tiempo',
                GROUP_CONCAT(DISTINCT euso.costo_equipo SEPARATOR ', ') AS 'costo equipo', FORMAT(SUM(DISTINCT euso.costo_equipo),2) AS 'suma costo equipo',
                GROUP_CONCAT(DISTINCT euso.costo_administrativo SEPARATOR ', ') AS 'costo administrativo', SUM(DISTINCT euso.costo_administrativo) AS 'suma costo administrativo'")
                ->join('equipo_uso as euso', 'euso.usoinfraestructura_id', '=', 'usoinfraestructuras.id')
                ->join('proyectos as pro', function ( $join) {
                    $join->on('pro.id', '=', 'usoinfraestructuras.asesorable_id')
                        ->where('usoinfraestructuras.asesorable_type', App\Models\Proyecto::class);

                })
                ->whereBetween('usoinfraestructuras.created_at', ['2023-06-01', '2023-08-31'])
                ->whereIn('pro.fase_id', [1,2,3,4])
                ->groupBy('usoinfraestructuras.codigo')
                ->get();

        $usos->map(function($uso){
            // var_dump("{$uso->nodo_id} | {$uso->codigo} | </br>");
            $this->calculateCostsDevices($uso);
        });
    }

    private function calculateCostsDevices($uso)
    {
        $asesoria = UsoInfraestructura::find($uso->id_uso);
        $syncData            = [];
        $depreciacionEquipo  = [];
        $mantenimientoEquipo = [];
        $costoAdministracion = [];
        $totalEquipos        = [];
        $anioActual          = Carbon::now()->year;
        $node = $uso->nodo_id;

        foreach($asesoria->usoequipos as $usoequipo){
            // dd("{$asesoria}");
            $asesorie = UsoInfraestructura::where('id',$usoequipo->pivot->usoinfraestructura_id)->first();
            $equipo = Equipo::with(['equiposmantenimientos', 'lineatecnologica', 'nodo'])->where('id', $usoequipo->pivot->equipo_id)->first();
            if ($equipo->vida_util == 0 || $equipo->horas_uso_anio == 0 || $equipo->costo_adquisicion == 0) {
                $depreciacionEquipo = 0;
            } else {
                $depreciacionEquipo = ($equipo->costo_adquisicion / $equipo->vida_util / $equipo->horas_uso_anio) * (double) $usoequipo->pivot->tiempo;
            }
            $equiposmantenimiento = EquipoMantenimiento::where('equipo_id', $usoequipo->pivot->equipo_id)->where('ultimo_anio_mantenimiento', $anioActual)->first();
            if (isset($equiposmantenimiento)) {
                //formula para calcular el valor del mantenimiento del equipo * tiempo uso infraestructura
                $mantenimientoEquipo = round(($equiposmantenimiento->valor_mantenimiento / $equiposmantenimiento->equipo->vida_util / $equiposmantenimiento->equipo->horas_uso_anio) * (double) $usoequipo->pivot->tiempo);
            } else {
                $mantenimientoEquipo = 0;
            }
            //costo total de equippos
            $totalEquipos = $depreciacionEquipo + $mantenimientoEquipo;

            $costo = CostoAdministrativo::select(DB::raw('SUM(nodo_costoadministrativo.valor) as valor_costo_administrativo'))
                ->join('nodo_costoadministrativo', 'nodo_costoadministrativo.costo_administrativo_id', '=', 'costos_administrativos.id')
                ->join('nodos', 'nodos.id', '=', 'nodo_costoadministrativo.nodo_id')
                ->where('nodo_costoadministrativo.nodo_id', $equipo->nodo->id)
                ->where('nodo_costoadministrativo.anho', Carbon::now()->year)
                ->groupBy('nodos.id')
                ->first();

            $nodolineas   = Nodo::AllLineasPorNodo($equipo->nodo->id);
            $countlineas  = $nodolineas->lineas->count();
            $countequipos = $nodolineas->equipos->count();

            $dinamizadores = User::ConsultarFuncionarios($node, User::IsDinamizador())->get();
            $infocenters = User::ConsultarFuncionarios($node, User::IsInfocenter())->get();
            if(isset($dinamizadores) && $dinamizadores->count() > 0){
                $calculateHonorariosDinamizador = $dinamizadores->sum('honorarios');
            }else{
                $calculateHonorariosDinamizador = 0;
            }
            if(isset($infocenters) && $infocenters->count() > 0){
                $calculateHonorariosInfocenter = $infocenters->sum('honorarios');
            }else{
                $calculateHonorariosInfocenter = 0;
            }

            if ($costo->valor_costo_administrativo == 0) {
                $costoAdministracion = 0;
            } else {
                $costoAdministracion = round((( ($costo->valor_costo_administrativo + $calculateHonorariosDinamizador + $calculateHonorariosInfocenter) / CostoAdministrativo::DIAS_AL_MES / CostoAdministrativo::HORAS_AL_DIA / $countlineas / CostoAdministrativo::DEDICACION)
                    * (100 / ($countequipos) * (double) $usoequipo->pivot->tiempo) / 100));
            }

            var_dump([
                'codigo_asesoria' => $asesorie->codigo,
                'equipo_id'            => $usoequipo->pivot->equipo_id,
                'tiempo'               => $usoequipo->pivot->tiempo,
                'costo_equipo'         => $totalEquipos,
                'costo_administrativo' => $costoAdministracion,
            ]);


            $asesorie->usoequipos()->sync([
                // 'codigo_asesoria' => $asesorie->codigo,
                'equipo_id'            => $usoequipo->pivot->equipo_id,
                'tiempo'               => $usoequipo->pivot->tiempo,
                'costo_equipo'         => $totalEquipos,
                'costo_administrativo' => $costoAdministracion,
            ]);

            var_dump("{$asesorie->codigo}");


        }



    }
}
