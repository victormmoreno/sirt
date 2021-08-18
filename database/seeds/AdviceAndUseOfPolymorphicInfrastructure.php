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
        $asesorias = UsoInfraestructura::all();

        $asesorias->each(function ($item, $key)  {
            if($item->tipo_usoinfraestructura == 0 && isset($item->actividad->articulacion_proyecto->proyecto)){
                $item->update([
                        'asesorable_id' => $item->actividad->articulacion_proyecto->proyecto->id,
                        'asesorable_type' => \App\Models\Proyecto::class
                ]);
            }
            if($item->tipo_usoinfraestructura == 1 && isset($item->actividad->articulacionpbt)){
                $item->update([
                        'asesorable_id' => $item->actividad->articulacionpbt->id,
                        'asesorable_type' => \App\Models\ArticulacionPbt::class
                ]);
            }
            if( isset($item->actividad->articulacion_proyecto->articulacion)){
                $item->update([
                    'asesorable_id' => $item->actividad->articulacion_proyecto->articulacion->id,
                    'asesorable_type' => \App\Models\Articulacion::class
                ]);
            }

            if( isset($item->actividad->edt)){
                $item->update([
                    'asesorable_id' => $item->actividad->edt->id,
                    'asesorable_type' => \App\Models\Edt::class
                ]);
            }

            $item->usogestores->each(function ($item1) use($item) {
                if(isset($item1->user_id)){
                    $user = App\User::withTrashed()->where('id', $item1->user_id)->first();
                    $item->usogestores()->update([
                        'asesorable_id' => $user->id,
                        'asesorable_type' => \App\User::class
                    ]);
                }
            });
        });
    }

    protected function asesorableId($model){
        return $model->id;
        // return null;
    }

    protected function asesorableIdUser($model){

        if(isset($model)){
            return  $model->id;
        }
        return null;
    }

    protected function asesorableTypeUser($model){

        if(isset($model)){
            return \App\User::class;
        }
        return null;
    }
}
