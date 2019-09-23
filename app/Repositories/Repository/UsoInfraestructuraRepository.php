<?php

namespace App\Repositories\Repository;

use App\Models\Actividad;
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
                'asesoria_directa'        => isset($request->txtasesoriadirecta) ? $request->txtasesoriadirecta : '0',
                'asesoria_indirecta'      => isset($request->txtasesoriaindirecta) ? $request->txtasesoriaindirecta : '0',
                'descripcion'             => $request->txtdescripcion,
                'estado'                  => 1,
            ]);

            if ($request->filled('talento')) {

                $usoInfraestructura->usotalentos()->sync($request->get('talento'), false);

            }

            if ($request->filled('laboratorio')) {
                $syncData = array();
                foreach ($request->get('laboratorio') as $id => $value) {
                    $syncData[$id] = array('laboratorio_id' => $value, 'tiempo' => $request->get('tiempouso')[$id]);
                }

                $usoInfraestructura->usolaboratorios()->sync($syncData);
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

            }

            if ($request->filled('laboratorio')) {
                $syncData = array();
                foreach ($request->get('laboratorio') as $id => $value) {
                    $syncData[$id] = array('laboratorio_id' => $value, 'tiempo' => $request->get('tiempouso')[$id]);
                }

                $usoInfraestructura->usolaboratorios()->sync($syncData);
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
