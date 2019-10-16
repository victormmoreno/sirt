<?php

namespace App\Repositories\Repository;

use App\Models\Actividad;
use App\Models\CostoAdministrativo;
use App\Models\Equipo;
use App\Models\EquipoMantenimiento;
use App\Models\Gestor;
use App\Models\Material;
use App\Models\Nodo;
use App\Models\UsoInfraestructura;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UsoInfraestructuraRepository
{

    /**
     * retorna registro de un uso de infraestructura
     * @return bool
     * @param $request
     * @author devjul
     */
    public function store($request)
    {
        DB::beginTransaction();
        try {

            $actividad = Actividad::where('codigo_actividad', explode(" - ", $request->txtactividad)[0])
                ->first()->id;

            $usoInfraestructura = UsoInfraestructura::create([
                'actividad_id'            => $actividad,
                'tipo_usoinfraestructura' => $request->get('txttipousoinfraestructura'),
                'fecha'                   => $request->txtfecha,
                'descripcion'             => $request->txtdescripcion,
                'estado'                  => 1,
            ]);

            if ($request->filled('talento')) {

                $usoInfraestructura->usotalentos()->sync($request->get('talento'), false);

            } else {
                $usoInfraestructura->usotalentos()->sync([]);
            }

            if ($request->filled('gestor')) {

                $syncData = $this->calculateCostoHorasAsesoria($request);

                $usoInfraestructura->usogestores()->sync($syncData);
            } else {
                $usoInfraestructura->usogestores()->sync([]);
            }

            if ($request->filled('material')) {
                $syncData       = [];
                $dataMateriales = [];
                foreach ($request->get('material') as $id => $value) {
                    //busqueda id material
                    $material = Material::where('id', $value)->first();
                    //calculo de costos de materiales
                    $dataMateriales[$id] = round(($material->valor_compra / $material->cantidad) * (int) $request->get('cantidad')[$id]);

                    //array que almacena los datos en material_costos
                    $syncData[$id] = [
                        'material_id'        => $value,
                        'costo_material'     => $dataMateriales[$id],
                        'unidad'   => $request->get('cantidad')[$id],
                    ];
                }

                $usoInfraestructura->usomateriales()->sync($syncData);

            } else {
                $usoInfraestructura->usomateriales()->sync([]);
            }

            if ($request->filled('equipo')) {
                $syncData            = array();
                $depreciacionEquipo  = array();
                $mantenimientoEquipo = array();
                $costoAdministracion = array();
                $totalEquipos        = array();
                $anioActual          = Carbon::now()->year;
                foreach ($request->get('equipo') as $id => $value) {

                    $equipo = Equipo::with(['equiposmantenimientos', 'lineatecnologica', 'nodo'])->where('id', $value)->first();

                    if (($anioActual - $equipo->anio_compra) < $equipo->vida_util) {
                        $depreciacionEquipo[$id] = round(($equipo->costo_adquisicion / $equipo->vida_util / $equipo->horas_uso_anio) * (int) $request->get('tiempouso')[$id]);
                    } else {
                        $depreciacionEquipo[$id] = 0;
                    }

                    $equiposmantenimiento = EquipoMantenimiento::where('equipo_id', $value)->where('ultimo_anio_mantenimiento', $anioActual)->first();

                    if (isset($equiposmantenimiento)) {
                        $mantenimientoEquipo[$id] = round(($equiposmantenimiento->valor_mantenimiento / $equiposmantenimiento->vida_util_mantenimiento / $equiposmantenimiento->horas_uso_anio) * (int) $request->get('tiempouso')[$id]);

                    } else {
                        $mantenimientoEquipo[$id] = 0;
                    }
                    $totalEquipos[$id] = $depreciacionEquipo[$id] + $mantenimientoEquipo[$id];

                    $costo = CostoAdministrativo::select(DB::raw('SUM(nodo_costoadministrativo.valor) as valor_costo_administrativo'))
                        ->join('nodo_costoadministrativo', 'nodo_costoadministrativo.costo_administrativo_id', '=', 'costos_administrativos.id')
                        ->join('nodos', 'nodos.id', '=', 'nodo_costoadministrativo.nodo_id')
                        ->where('nodo_costoadministrativo.nodo_id', auth()->user()->gestor->nodo->id)
                        ->first();

                    $lineas      = Nodo::AllLineasPorNodo($equipo->nodo->id);
                    $countlineas = $lineas->lineas->count();

                    $costoAdministracion[$id] = round((($costo->valor_costo_administrativo / CostoAdministrativo::DIAS_AL_MES / CostoAdministrativo::HORAS_AL_DIA / $countlineas / CostoAdministrativo::DEDICACION)
                         * ($equipo->lineatecnologica->nodos->where('id', $equipo->nodo->id)->first()->pivot->porcentaje_linea * (int) $request->get('tiempouso')[$id]) / 100));

                    $syncData[$id] = array(
                        'equipo_id'            => $value,
                        'tiempo'               => $request->get('tiempouso')[$id],
                        'costo_equipo'         => $totalEquipos[$id],
                        'costo_administrativo' => $costoAdministracion[$id],
                    );
                }

                $usoInfraestructura->usoequipos()->sync($syncData);
            } else {
                $usoInfraestructura->usoequipos()->sync([]);
            }

            

            DB::commit();
            return 'true';
        } catch (Exception $e) {
            DB::rollback();
            return 'false';
        }

    }

    /**
     * retorna actualizacion de un uso de infraestructura
     *
     * @param $request
     * @author devjul
     */
    public function update($request, $id)
    {
        DB::beginTransaction();
        try {
            $actividad = Actividad::where('codigo_actividad', explode(" - ", $request->txtactividad)[0])
                ->first()->id;
            $usoInfraestructura = UsoInfraestructura::find($id);
            $usoInfraestructura->update([
                'actividad_id'            => $actividad,
                'tipo_usoinfraestructura' => $request->get('txttipousoinfraestructura'),
                'fecha'                   => $request->txtfecha,
                'asesoria_directa'        => isset($request->txtasesoriadirecta) ? $request->txtasesoriadirecta : '0',
                'asesoria_indirecta'      => isset($request->txtasesoriaindirecta) ? $request->txtasesoriaindirecta : '0',
                'descripcion'             => $request->txtdescripcion,
                'estado'                  => 1,
            ]);

            if ($request->filled('talento')) {

                $usoInfraestructura->usotalentos()->sync($request->get('talento'));

            } else {
                $usoInfraestructura->usotalentos()->sync([]);
            }

            if ($request->filled('equipo')) {
                $syncData = array();

                foreach ($request->get('equipo') as $id => $value) {
                    $syncData[$id] = array(
                        'equipo_id' => $value,
                        'tiempo'    => $request->get('tiempouso')[$id],
                        // 'costo_equipo' => $depreciacionEquipo[$id],
                        // 'costo_administrativo' => 0
                    );
                }

                $usoInfraestructura->usoequipos()->sync($syncData);
            } else {
                $usoInfraestructura->usoequipos()->sync([]);
            }

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollback();
            return false;
        }
    }

    /**
     * retorna query con los usos de infraestructura
     * @return collection
     * @author devjul
     */
    public function getUsoInfraestructuraForUser(array $relations)
    {
        return UsoInfraestructura::usoInfraestructuraWithRelations($relations);
    }

    /**
     * metodo retorna costo de horas de asesoria
     *
     * @param $request
     * @author devjul
     */
    private function calculateCostoHorasAsesoria($request)
    {
        $syncData  = array();
        $honorario = array();

        foreach ($request->get('gestor') as $id => $value) {

            //calculo de costo de horas de asesoria
            $honorarioGestor = Gestor::where('id', $value)->first()->honorarios;
            //suma de las horas de asesoria directa y horas de asesoria indirecta
            $horasAsesoriaGestor = $request->get('asesoriadirecta')[$id] + $request->get('asesoriaindirecta')[$id];
            $honorario[$id]      = round(($honorarioGestor / CostoAdministrativo::DIAS_AL_MES / CostoAdministrativo::HORAS_AL_DIA) * (int) $horasAsesoriaGestor);

            //array que almacena los datos a
            $syncData[$id] = array('gestor_id' => $value,
                'asesoria_directa'                 => $request->get('asesoriadirecta')[$id],
                'asesoria_indirecta'               => $request->get('asesoriaindirecta')[$id], 'costo_asesoria' => $honorario[$id]);

        }

        return $syncData;

    }

}
