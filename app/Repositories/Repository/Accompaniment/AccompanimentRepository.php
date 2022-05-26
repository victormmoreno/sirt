<?php

namespace App\Repositories\Repository\Accompaniment;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Models\Accompaniment;
use App\Models\Sede;
use App\Models\Proyecto;
use App\Models\Fase;


class AccompanimentRepository
{

    /**
        * store
        * @param Request $request
        * @return void
    */
    public function store(Request $request)
    {
        try {
            $accompaniment = $this->storeAccompaniment($request);
            $this->validateAccompanimentType($request, $accompaniment);
            $this->storageFile($request, $accompaniment );
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
        * store accompaniment
        * @param Request $request
    */
    public function storeAccompaniment(Request $request){
        $accompaniment = Accompaniment::create([
            'accompaniment_type' => Proyecto::class,
            'code' => $this->generateCode('EA'),
            'name' => $request->name_accompaniment,
            'description' => $request->description_accompaniment,
            'scope'  => $request->scope_accompaniment,
            'status' => Accompaniment::STATUS_OPEN,
            'start_date' => Carbon::now(),
            'confidentiality_format' => Accompaniment::CONFIDENCIALITY_FORMAT_YES,
            'terms_verified_at' => Carbon::now(),
            'node_id' => auth()->user()->articulador->nodo->id,
            'interlocutor_talent_id' => $request->talent,
            'created_by' => auth()->user()->id
        ]);

        return $accompaniment;
    }

    /**
        * store accompaniment
        * @param Request $request
    */
    public function validateAccompanimentType(Request $request, Accompaniment $accompaniment)
    {
        if($request->accompaniment_type == 'pbt'){
            $model = Proyecto::where('id', $request->projects)->first();
            $model->accompaniamentables()->sync([$accompaniment->id]);
        }else if($request->accompaniment_type == 'empresa'){
            $model = Sede::where('id', $request->sedes)->first();
            $model->accompaniamentables()->sync([$accompaniment->id]);
        }
    }

    private function storageFile(Request $request, \Illuminate\Database\Eloquent\Model $model = null)
    {
        if($request->hasFile('confidency_format')){
            try {
                $file = $request->file('confidency_format')->getClientOriginalName();
                $node = sprintf('%02d',$model->node->id);
                $year = Carbon::parse($model->start_date)->isoFormat('YYYY');
                $module = class_basename($model);
                $route = "public/{$node}/{$year}/{$module}/{$model->createdBy->documento}/{$model->code}/formato";
                $fileUrl = $request->file('confidency_format')
                            ->storeAs($route, $file);

                $model->file()->create([
                    'ruta' => Storage::url($fileUrl),
                    'fase_id' => Fase::IS_INICIO
                ]);
                return $model;
            } catch (\Exception $ex) {
                return $ex->getMessage();
            }
        }
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
            $accompaniment = Accompaniment::selectRaw('MAX(id+1) AS max')->get()->last();
            $accompaniment->max == null ? $accompaniment->max = 1 : $accompaniment->max = $accompaniment->max;
            $accompaniment->max = sprintf("%04d", $accompaniment->max);
            return "{$initial}{$year}-{$node}{$month}{$user}-{$accompaniment->max}";
    }

}
