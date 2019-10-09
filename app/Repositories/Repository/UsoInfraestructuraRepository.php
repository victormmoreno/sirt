<?php

namespace App\Repositories\Repository;

use App\Models\Actividad;
use App\Models\CostoAdministrativo;
use App\Models\Gestor;
use App\Models\UsoInfraestructura;
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

            }else{
                $usoInfraestructura->usotalentos()->sync([]);
            }

            if ($request->filled('gestor')) {
                $syncData = array();
                $honorario = array();
                foreach ($request->get('gestor') as $id => $value) {
                    //calculo de costo de horas de asesoria
                    $honorarioGestor = Gestor::where('id',$value)->first()->honorarios;
                    //suma de las horas de asesoria directa y horas de asesoria indirecta
                    $horasAsesoriaGestor = $request->get('asesoriadirecta')[$id] + $request->get('asesoriaindirecta')[$id];
                    $honorario[$id] = round(($honorarioGestor / CostoAdministrativo::DIAS_AL_MES / CostoAdministrativo::HORAS_AL_DIA) * (int) $horasAsesoriaGestor);

                    //array que almacena los datos a 
                    $syncData[$id] = array('gestor_id' => $value,
                    'asesoria_directa' => $request->get('asesoriadirecta')[$id],
                    'asesoria_indirecta' => $request->get('asesoriaindirecta')[$id], 'costo_asesoria' => $honorario[$id]);
                }

                $usoInfraestructura->usogestores()->sync($syncData);
            }else{
                $usoInfraestructura->usogestores()->sync([]);
            }

            if ($request->filled('equipo')) {
                $syncData = array();
                foreach ($request->get('equipo') as $id => $value) {
                    $syncData[$id] = array('equipo_id' => $value, 'tiempo' => $request->get('tiempouso')[$id]);
                }

                $usoInfraestructura->usoequipos()->sync($syncData);
            }else{
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

            }else{
                $usoInfraestructura->usotalentos()->sync([]);
            }

            if ($request->filled('equipo')) {
                $syncData = array();
                foreach ($request->get('equipo') as $id => $value) {
                    $syncData[$id] = array('equipo_id' => $value, 'tiempo' => $request->get('tiempouso')[$id]);
                }

                $usoInfraestructura->usoequipos()->sync($syncData);
            }else{
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
}
