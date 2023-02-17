<?php

use Illuminate\Database\Seeder;
use App\Models\Actividad;

class AdvisorActivtiesToDaughterTables extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //proyectos
        $proyectos = Actividad::with(['articulacion_proyecto.proyecto'])->whereHas('articulacion_proyecto.proyecto')->get();

        foreach ($proyectos as $key => $proyecto) {
            if ($proyecto->articulacion_proyecto->proyecto != null) {

                $proyecto->articulacion_proyecto->proyecto->update([
                    'asesor_id' => $proyecto->gestor_id,
                    'nodo_id' => $proyecto->nodo_id
                ]);
            }
        }

        $edts = Actividad::with(['edt'])->whereHas('edt')->get();

        foreach ($edts as $key => $val) {

            if ($val->edt != null) {

                $val->edt->update([
                    'asesor_id' => $val->gestor->user_id,
                    'nodo_id' => $val->nodo_id
                ]);
            }
        }

    }

}
