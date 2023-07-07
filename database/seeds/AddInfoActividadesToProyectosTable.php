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
            $proyectos = Proyecto::select(
                'proyectos.id', 'actividades.codigo_actividad', 'actividades.nombre', 'actividades.fecha_inicio', 'actividades.fecha_cierre',
                'actividades.objetivo_general', 'actividades.conclusiones', 'actividades.formulario_inicio', 'actividades.cronograma', 
                'actividades.seguimiento', 'actividades.formulario_final'
            )
            ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'proyectos.articulacion_proyecto_id')
            ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
            ->get();
            foreach ($proyectos as $key => $proyecto) {
                $codigo_proyecto = $proyecto->codigo_actividad;
                $nombre = $proyecto->nombre;
                $fecha_inicio = $proyecto->fecha_inicio;
                $fecha_cierre = $proyecto->fecha_cierre;
                $objetivo_general = $proyecto->objetivo_general;
                $conclusiones = $proyecto->conclusiones;
                $formulario_inicio = $proyecto->formulario_inicio;
                $cronograma = $proyecto->cronograma;
                $seguimiento = $proyecto->seguimiento;
                $formulario_final = $proyecto->formulario_final;
                DB::table('proyectos')->where('id', $proyecto->id)->update([
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
