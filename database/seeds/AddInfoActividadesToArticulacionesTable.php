<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddInfoActividadesToArticulacionesTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();
        try {
            $articulaciones = DB::table('articulaciones')->select(
                'articulaciones.id', 'codigo_actividad', 'actividades.nombre', 'actividades.fecha_inicio', 'actividades.fecha_cierre', 'actividades.objetivo_general', 'actividades.conclusiones',
                'actividades.formulario_inicio', 'actividades.cronograma', 'actividades.seguimiento', 'actividades.formulario_final', 'articulacion_proyecto.entidad_id'
            )
            ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'articulaciones.articulacion_proyecto_id')
            ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
            ->get();
            foreach ($articulaciones as $key => $articulacion) {
                $codigo_articulacion = $articulacion->codigo_actividad;
                $nombre = $articulacion->nombre;
                $fecha_inicio = $articulacion->fecha_inicio;
                $fecha_cierre = $articulacion->fecha_cierre;
                $objetivo_general = $articulacion->objetivo_general;
                $conclusiones = $articulacion->conclusiones;
                $formulario_inicio = $articulacion->formulario_inicio;
                $cronograma = $articulacion->cronograma;
                $seguimiento = $articulacion->seguimiento;
                $formulario_final = $articulacion->formulario_final;
                $entidad_id = $articulacion->entidad_id;
                DB::table('articulaciones')
                ->where('id', $articulacion->id)->update([
                    'codigo_articulacion' => $codigo_articulacion,
                    'entidad_id' => $entidad_id,
                    'nombre' => $nombre,
                    'fecha_inicio' => $fecha_inicio,
                    'fecha_cierre' => $fecha_cierre,
                    'objetivo_general' => $objetivo_general,
                    'conclusiones' => $conclusiones,
                    'formulario_inicio' => $formulario_inicio,
                    'cronograma' => $cronograma,
                    'seguimiento' => $seguimiento,
                    'formulario_final' => $formulario_final
                ]);
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
