<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Articulacion;

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
            $articulaciones = Articulacion::all();
            foreach ($articulaciones as $key => $articulacion) {
                $codigo_articulacion = $articulacion->articulacion_proyecto->actividad->codigo_actividad;
                $nombre = $articulacion->articulacion_proyecto->actividad->nombre;
                $fecha_inicio = $articulacion->articulacion_proyecto->actividad->fecha_inicio;
                $fecha_cierre = $articulacion->articulacion_proyecto->actividad->fecha_cierre;
                $objetivo_general = $articulacion->articulacion_proyecto->actividad->objetivo_general;
                $conclusiones = $articulacion->articulacion_proyecto->actividad->conclusiones;
                $formulario_inicio = $articulacion->articulacion_proyecto->actividad->formulario_inicio;
                $cronograma = $articulacion->articulacion_proyecto->actividad->cronograma;
                $seguimiento = $articulacion->articulacion_proyecto->actividad->seguimiento;
                $formulario_final = $articulacion->articulacion_proyecto->actividad->formulario_final;
                $articulacion->update([
                    'codigo_articulacion' => $codigo_articulacion,
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
