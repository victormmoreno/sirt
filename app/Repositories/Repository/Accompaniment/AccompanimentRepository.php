<?php

namespace App\Repositories\Repository\Accompaniment;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Models\Accompaniment;
use App\Models\Sede;
use App\Models\Proyecto;
use App\Models\Fase;
use App\Models\ArchivoModel;


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
            $this->storageFile( $request, $accompaniment );
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

    public function update(Request $request, Accompaniment $accompaniment)
    {
        try {
            $accompaniment = $this->updateAccompaniment($request, $accompaniment);
            $this->validateAccompanimentType($request, $accompaniment);
            $this->updateFile( $request , $accompaniment );
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
            'name' => $request->name,
            'description' => $request->description,
            'scope'  => $request->scope,
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
    public function updateAccompaniment(Request $request, Accompaniment $accompaniment){
        $accompaniment->update([
            'name' => $request->name,
            'description' => $request->description,
            'scope'  => $request->scope,
            'confidentiality_format' => Accompaniment::CONFIDENCIALITY_FORMAT_YES,
            'terms_verified_at' => Carbon::now(),
            'interlocutor_talent_id' => $request->talent,
        ]);
        return $accompaniment;
    }

    /**
        * store accompaniment
        * @param Request $request
    */
    public function validateAccompanimentType(Request $request, Accompaniment $accompaniment)
    {
        if($request->filled('projects')){
            $model = Proyecto::where('id', $request->projects)->first();
            $model->accompaniamentables()->sync([$accompaniment->id]);
        }
    }

    private function storageFile(Request $request, \Illuminate\Database\Eloquent\Model $model = null)
    {
        if($request->hasFile('confidency_format')){
            try {
                $fileName =  $model->code.'_' .$request->file('confidency_format')->getClientOriginalName();
                $node = sprintf('%02d',$model->node->id);
                $year = Carbon::parse($model->start_date)->isoFormat('YYYY');
                $module = class_basename($model);
                $route = "public/{$node}/{$year}/{$module}/{$model->createdBy->documento}/{$model->code}/formato";
                $fileUrl = $request->file('confidency_format')
                            ->storeAs($route, $fileName);
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

    private function updateFile(Request $request, \Illuminate\Database\Eloquent\Model $model = null)
    {
        if($model){
            if ($request->hasFile('confidency_format')) {
                try {
                    $fileName =  $model->code.'_' .$request->file('confidency_format')->getClientOriginalName();
                    $node = sprintf('%02d',$model->node->id);
                    $year = Carbon::parse($model->start_date)->isoFormat('YYYY');
                    $module = class_basename($model);
                    $route = "public/{$node}/{$year}/{$module}/{$model->createdBy->documento}/{$model->code}/formato";
                    $fileUrl = $request->file('confidency_format') ->storeAs($route, $fileName);
                    if(isset($model->file)){
                        $filePath = str_replace('storage', 'public', $model->file->ruta);
                        Storage::delete($filePath);
                        $model->file()->update([
                            'ruta' => Storage::url($fileUrl)
                        ]);
                    }else{
                        $model->file()->create([
                            'ruta' => Storage::url($fileUrl),
                            'fase_id' => Fase::IS_INICIO
                        ]);
                    }

                    return $model;
                }catch (\Exception $ex) {
                    return $ex->getMessage();
                }
            }
            return $model;
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

    /**
     * Método que elimina un archivo del servidor y su registro de la base de datos (RutaModel)
    * @param int id Id del archivo del entrenamiento que se usará para eliminarlo del almacenamiento y de la base de datos
    * @return Response
    */
    public function destroyFile($file)
    {
        try {
            $file = ArchivoModel::find($file);
            $file->delete();
            $filePath = str_replace('storage', 'public', $file->ruta);
            Storage::delete($filePath);
            return true;
        }catch (\Exception $ex) {
            return false;
        }
    }


    /**
     * Update file
     * @return \Illuminate\Http\Response
     */
    public function downloadFile(\App\Models\Accompaniment $accompaniment)
    {
        try {
            $path = $this->existFile($accompaniment->file->ruta);
            return Storage::response($path);
        } catch (\Exception $e) {
            return abort(404, $e->getMessage());
        }
    }

    private function existFile($path){
        if(!isset($path)){
            throw new \Exception('El archivo no existe');
        }
        return  $path = str_replace('storage', 'public', $path);
    }

    /**
     * Update los miembros de una etapa.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function updateInterlocutor(Request $request, Accompaniment $accompaniment)
    {

        try {
            $accompaniment->update([
                'interlocutor_talent_id' => $request->talent,
            ]);
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

}
