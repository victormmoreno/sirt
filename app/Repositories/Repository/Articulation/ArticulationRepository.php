<?php

namespace App\Repositories\Repository\Articulation;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\ArticulationStage;
use App\User;
use App\Models\Articulation;
use App\Models\Fase;
use Illuminate\Support\Facades\DB;


class ArticulationRepository
{

    /**
        * store
        * @param Request $request
        * @return void
    */
    public function store(Request $request, ArticulationStage $accompaniment)
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
    public function storeArticulation(Request $request, ArticulationStage $accompaniment){
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
            'phase_id' => Fase::where('nombre', Articulation::START_PHASE)->first()->id,
            'articulation_subtype_id' => $request->articulation_subtype,
            'scope_id' => $request->scope_articulation,
            'created_by' => auth()->user()->id,
        ]);
        if($request->filled('talents')){
            $articulation->users()->sync($request->talents);
        }
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

    /**
     * store
     * @param Request $request
     * @return void
     */
    public function update(Request $request, Articulation $articulation)
    {
        try {
            $articulation->update([
                'name' => $request->name_articulation,
                'description' => $request->description_articulation,
                'start_date' => $request->start_date,
                'expected_end_date' => $request->expected_date,
                'entity' => $request->name_entity,
                'contact_name' => $request->name_contact,
                'email_entity' => $request->email,
                'summon_name' => $request->call_name,
                'objective' => $request->objective,
                'articulation_subtype_id' => $request->articulation_subtype,
                'scope_id' => $request->scope_articulation
            ]);
            if($request->filled('talents')){
                $articulation->users()->sync($request->talents);
            }
            return  [
                'data' => $articulation,
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
     * Modifica los entregables de una articulacion en la fase de ejecución
     *
     * @param Request $request
     * @param int $id id de la articulacion
     * @return array
     * @author devjul
     */
    public function updateEntregablesEjecucionRepository($request, $articulation)
    {
        DB::beginTransaction();
        try {
            $tracing = 0;
            $announcement_document = 0;
            if (isset($request->tracing)) {
                $tracing = 1;
            }
            if (isset($request->announcement_document)) {
                $announcement_document = 1;
            }

            $articulation->update([
                'announcement_document' => $announcement_document,
                'tracing' => $tracing,
            ]);
            DB::commit();
            return $articulation;
        } catch (\Throwable $th) {
            DB::rollback();
            return null;
        }
    }
}
