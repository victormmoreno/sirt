<?php

use Illuminate\Database\Seeder;
use App\Models\UsoInfraestructura;

class AdviceAndUseOfPolymorphicInfrastructure extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $asesorias = UsoInfraestructura::with(['actividad.articulacion_proyecto.proyecto'])->whereHas('actividad.articulacion_proyecto.proyecto')->get();

        foreach ($asesorias as $key => $asesoria) {
            if ($asesoria->actividad->articulacion_proyecto->proyecto != null) {

                $asesoria->update([
                    'asesorable_id' => $this->asesorableId($asesoria),
                    'asesorable_type' => $this->asesorableType($asesoria),
                ]);
            }
        }

        $usos = UsoInfraestructura::with(['actividad.articulacionpbt'])->whereHas('actividad.articulacionpbt')->get();

        foreach ($usos as $key => $uso) {
            if ($uso->actividad->articulacionpbt->id != null) {

                $asesoria->update([
                    'asesorable_id' => $this->asesorableId($uso),
                    'asesorable_type' => $this->asesorableType($uso),
                ]);
            }
        }
    }

    protected function asesorableId($model){
        if(isset($model->actividad->articulacion_proyecto->proyecto)){
            return $model->actividad->articulacion_proyecto->proyecto->id;
        }
        if($model->actividad->articulacionpbt  != null){
            return $model->actividad->articulacionpbt->id;
        }
        return null;
    }

    protected function asesorableType($model){
        if($model->actividad->articulacion_proyecto->proyecto->id != null){
            return \App\Models\Proyecto::class;
        }
        if($model->actividad->articulacionpbt->id != null){
            return \App\Models\ArticulacionPbt::class;
        }
        return null;
    }
}
