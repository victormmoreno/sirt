<?php

use Illuminate\Database\Seeder;
use App\Models\Proyecto;

class AddProyectoToObjetivosTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $proyectos = Proyecto::select(
            'proyectos.id', 'actividades.id AS actividad_id', 'articulacion_proyecto.id as articulacion_proyecto_id'
        )
        ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'proyectos.articulacion_proyecto_id')
        ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
        ->get();
        foreach ($proyectos as $key1 => $proyecto) {
            DB::table('objetivos_especificos')
            ->where('actividad_id', $proyecto->actividad_id)
            ->update(['proyecto_id' => $proyecto->id]);
        }
    }
}
