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
        $proyectos = Proyecto::all();
        foreach ($proyectos as $key1 => $proyecto) {
            $id = $proyecto->id;
            DB::table('movimientos_actividades_users_roles')
            ->where('actividad_id', $proyecto->articulacion_proyecto->actividad->id)
            ->update(['proyecto_id' => $id]);
        }
    }
}
