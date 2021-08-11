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
        // dd($proyectos->first());

        foreach ($proyectos as $key => $proyecto) {
            if ($proyecto->articulacion_proyecto->proyecto != null) {

                $proyecto->articulacion_proyecto->proyecto->update([
                    'asesor_id' => $proyecto->gestor_id,
                    'nodo_id' => $proyecto->nodo_id
                ]);
            }
        }

        // $edts = Actividad::with(['edt'])->whereHas('edt')->first();

        // return $edts->edt->entidades;
        // foreach ($edts as $key => $val) {
        //     if ($val->edt != null) {

        //         $val->edt->update([
        //             'asesor_id' => $val->gestor->user_id,
        //             'nodo_id' => $val->nodo_id
        //         ]);

        //         $val->edt->entidades->each(function ($entidad) use($val) {
        //             $entidad->update([
        //                 'edtable_id' => $val->
        //             ]);
        //         });
        //     }
        // }

        // $articulaciones = Actividad::with(['articulacion_proyecto.articulacion'])->whereHas('articulacion_proyecto.articulacion')->get();

        // foreach ($articulaciones as $key => $articulacion) {
        //     if ($articulacion->articulacion_proyecto->articulacion != null) {

        //         $articulacion->articulacion_proyecto->articulacion->update([
        //             'asesor_id' => $articulacion->gestor->user_id,
        //             'nodo_id' => $articulacion->nodo_id
        //         ]);
        //     }
        // }

        $artpbts = Actividad::with(['articulacionpbt'])->whereHas('articulacionpbt')->get();

        foreach ($artpbts as $key => $artpbt) {
            if ($artpbt->articulacionpbt != null) {

                $artpbt->articulacionpbt->update([
                    'asesor_id' => $artpbt->gestor->user_id,
                    'nodo_id' => $artpbt->nodo_id,
                    'articulable_id' => $this->articulableId($artpbt),
                    'articulable_type' => $this->articulableModel($artpbt),
                    'codigo' => $artpbt->codigo_actividad,
                    'nombre' => $artpbt->nombre,
                    'fecha_inicio' => $artpbt->fecha_inicio,
                    'fecha_cierre' => $artpbt->fecha_cierre,
                    'aprobacion_dinamizador' => $artpbt->aprobacion_dinamizador,
                    'formulario_inicio' => $artpbt->formulario_inicio,
                    'seguimiento' => $artpbt->seguimiento,
                ]);
            }
        }

    }

    protected function articulableId($model){
        if($model->articulacionpbt->proyecto_id != null){
            return $model->articulacionpbt->proyecto_id;
        }
        if($model->articulacionpbt->sede_id != null){
            return $model->articulacionpbt->sede_id;
        }
        return null;
    }

    protected function articulableModel($model){
        if($model->articulacionpbt->proyecto_id != null){
            return \App\Models\Proyecto::class;
        }
        if($model->articulacionpbt->sede_id != null){
            return \App\Models\Sede::class;
        }
        return null;
    }
}
