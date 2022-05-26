<?php

namespace App\Repositories\Repository\Accompaniment;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Models\Accompaniment;
use App\Models\Sede;
use App\Models\Proyecto;
use App\Models\Fase;
use App\Models\Articulation;


class ArticulationRepository
{

    /**
        * store
        * @param Request $request
        * @return void
    */
    public function store(Request $request, Accompaniment $accompaniment)
    {
        try {
            $accompaniment = $this->storeArticulation($request, $accompaniment);

            return  [
                'data' => $accompaniment,
                'message' => '',
                'isCompleted' => true,
            ];
        } catch (\Exception $ex) {
            return  [
                'data' => "",
                'message' => $ex->getMessage(),
                'isCompleted' => false,
            ];
        }

    }
    /**
        * store articulation
        * @param Request $request
    */
    public function storeArticulation(Request $request, Accompaniment $accompaniment){
        $articulation = $accompaniment->articulations()->create([
            'code' => $this->generateCode('A'),
            'name' => $request->name_articulation,
            'description' => $request->description_articulation,
            'start_date' => $request->start_date,
            'expected_end_date' => $request->expected_date,
            'entity' => $request->name_entity,
            'contact_name' => $request->name_contact,
            'email_entity' => $request->email,
            'summon_name' => $request->call_name,
            'objective' => $request->objective,
            'phase_id' => Articulation::START_PHASE,
            'scope_id' => $request->scope_articulation,
            'created_by' => auth()->user()->id,
            // 'accompaniment_id' => $accompaniment->id
        ]);

        return $articulation;
    }



    /**
     * Genera un código para el acompañamiento
     * @param string $initial
     * @return string
     * @author devjul
     */
    private function generateCode($initial = null)
    {
            $year = Carbon::now()->isoFormat('YYYY');
            $node = sprintf("%02d", auth()->user()->articulador->id);
            $month = Carbon::now()->isoFormat('MM');
            $user = sprintf("%03d", auth()->user()->id);
            $model = Articulation::selectRaw('MAX(id+1) AS max')->get()->last();
            $model->max == null ? $model->max = 1 : $model->max = $model->max;
            $model->max = sprintf("%04d", $model->max);
            return "{$initial}{$year}-{$node}{$month}{$user}-{$model->max}";
    }

}
