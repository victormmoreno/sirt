<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Proyecto;

class AddInfoActividadesToProyectosTable extends Seeder
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
            $proyectos = Proyecto::all();
            foreach ($proyectos as $key => $proyecto) {
                $codigo_proyecto = $proyecto->articulacion_proyecto->actividad->codigo_actividad;
                $nombre = $proyecto->articulacion_proyecto->actividad->nombre;
                $fecha_inicio = $proyecto->articulacion_proyecto->actividad->fecha_inicio;
                $fecha_cierre = $proyecto->articulacion_proyecto->actividad->fecha_cierre;
                $objetivo_general = $proyecto->articulacion_proyecto->actividad->objetivo_general;
                $conclusiones = $proyecto->articulacion_proyecto->actividad->conclusiones;
                $formulario_inicio = $proyecto->articulacion_proyecto->actividad->formulario_inicio;
                $cronograma = $proyecto->articulacion_proyecto->actividad->cronograma;
                $seguimiento = $proyecto->articulacion_proyecto->actividad->seguimiento;
                $formulario_final = $proyecto->articulacion_proyecto->actividad->formulario_final;
                $proyecto->update([
                    'codigo_proyecto' => $codigo_proyecto,
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
