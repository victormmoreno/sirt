<?php

use Illuminate\Database\Seeder;
use App\Models\Proyecto;

class AddProyectoToHistorialTable extends Seeder
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
            DB::table('movimientos_actividades_users_roles')
            ->where('actividad_id', $proyecto->actividad_id)
            ->update(['proyecto_id' => $proyecto->id]);
        }
    }
}
