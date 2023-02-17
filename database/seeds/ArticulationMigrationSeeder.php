<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Imports\MigracionProyectosImport;
use App\Models\Nodo;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Articulacion;
use App\Models\ArticulacionPbt;
use App\Models\ArticulationStage;
use App\Models\Proyecto;
use App\User;
use App\Models\Sede;
use Illuminate\Support\Facades\Storage;

class ArticulationMigrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $articulaciones = $this->getQuery()
        // ->take(10)
        ->get();

        if($articulaciones->count() > 0){
            $articulaciones->each(function ($item){
                $articulationStage = $this->updateOrCreateArticulationStage($item);
                $this->validateArticulationStageType($articulationStage, $item);
                $articulation = $this->updateOrCreateArticulation($articulationStage, $item);

                // $this->syncTalentsParticipants($articulation, $item);
                // $this->updateOrCreateTrazability($articulation, $item);
                // $this->updateArchivesArticulation($articulationStage, $articulation, $item);
                $this->updateAsesorablesArticulation($articulation, $item);
            });
        }

    }

    private function getQuery()
    {
        return ArticulacionPbt::query()
            ->with([
                'asesor',
                'talentos',
                'alcancearticulacion',
                'archivomodel',
                'asesorias'
            ]);
    }

    private function updateOrCreateArticulationStage($item){
        $scope = \App\Models\AlcanceArticulacion::query()->select('name')->where('id', $item->alcance_articulacion_id)->first();
        return ArticulationStage::updateOrCreate([
            'code' => $item->codigo
        ],[
            'name'=> $item->nombre ? $item->nombre : __('No register'),
            'description'=> $item->objetivo ? $item->objetivo : __('No register'),
            'scope'=> isset($scope->name) ? $scope->name : __('No register'),
            'status'=> $item->fase_id == 6 ?  ArticulationStage::STATUS_CLOSE : ArticulationStage::STATUS_OPEN,
            'endorsement'=> $item->fase_id == 6 ?  ArticulationStage::STATUS_CLOSE : ArticulationStage::STATUS_OPEN,
            'start_date'=> $item->fecha_inicio,
            'end_date'=> $item->fecha_cierre,
            'confidentiality_format'=> 0,
            'terms_verified_at'=> $item->created_at,
            'node_id'=> $item->nodo_id,
            'interlocutor_talent_id'=> $item->talentos()->where('talento_lider',1)->first()->user_id,
            'created_by'=> $item->asesor_id,
            'created_at'=> $item->created_at,
            'updated_at'=> $item->updated_at
        ]);
    }

    private function validateArticulationStageType($articulationStage, $item)
    {
        if($item->articulable_type == Proyecto::class){
            $project = Proyecto::where('id', $item->articulable_id)->first();
            if(isset($project)){
                $articulationStage->projects()->sync([
                    'articulationable_id' => $project->id
                ]);
            }
        }
        if($item->articulable_type == Sede::class){
            $sede = Sede::where('id', $item->articulable_id)->first();
            if(isset($sede)){
                $articulationStage->sedes()->sync([
                    'articulationable_id' => $sede->id
                ]);
            }
        }
        if($item->articulable_type == \App\Models\Idea::class){
            $idea = \App\Models\Idea::where('id', $item->articulable_id)->first();
            if(isset($idea)){
                $articulationStage->ideas()->sync([
                    'articulationable_id' => $idea->id
                ]);
            }
        }
    }

    private function updateOrCreateArticulation($articulationStage, $item)
    {
        $fase = \App\Models\Fase::where('id',$item->fase_id)->first()->id;
        $alcance = \App\Models\AlcanceArticulacion::where('id',$item->alcance_articulacion_id)->first()->id;
        $articulationSubtype = \App\Models\ArticulationSubtype::where('name',$item->tipoarticulacion->nombre)->first()->id;

        $articulation = $articulationStage->articulations()->updateOrCreate([
            'code' => $item->codigo
        ],[
            'name' => $item->nombre ? $item->nombre : __('No register'),
            'description' => $item->objetivo ? $item->objetivo : __('No register'),
            'start_date' => $item->fecha_inicio,
            'end_date' => $item->fecha_cierre,
            'expected_end_date' => $item->fecha_esperada_finalizacion,
            'entity' => $item->entidad,
            'contact_name' => $item->nombre_contacto,
            'email_entity' => $item->email_entidad,
            'summon_name' => $item->nombre_convocatoria,
            'objective' => $item->objetivo ? $item->objetivo : __('No register'),
            'tracing' => $item->seguimiento,
            'postulation' => $item->postulacion,
            'approval' => $item->aprobacion,
            'justification' => $item->justificacion,
            'justified_report' => $item->informe_justificado,
            'report' => $item->informe,
            'receive' => $item->recibira,
            'received_date' => $item->cuando,
            'approval_document' => $item->pdf_aprobacion,
            'non_approval_document' => $item->pdf_noaprobacion,
            'postulation_document' => $item->documento_postulacion,
            'announcement_document' => $item->documento_convocatoria,
            'learned_lessons' => $item->lecciones_aprendidas,
            'scope_id' => $alcance,
            'phase_id' => $fase,
            'articulation_subtype_id' => $articulationSubtype,
            'created_by' => $item->asesor_id,
            'created_at' => $item->create_at,
            'updated_at' => $item->updated_at,

        ]);
        return $articulation;
    }

    private function syncTalentsParticipants($articulation, $item):void
    {
        if ($item->talentos->count() > 0) {
            $item->talentos->each(function($i) use($articulation){
                $articulation->users()->sync($i->user_id);
            });
        }
    }

    private function updateOrCreateTrazability($articulation, $item)
    {
        if (isset($item->historial)) {
            $item->historial->each(function($i) use($articulation){
                $articulation->traceability()->updateOrCreate([
                    'model_id' => $i->model_id
                ],[
                    'movimiento_id' => $i->movimiento_id,
                    'user_id' => $i->user_id,
                    'role_id' => $i->role_id,
                    'comentarios' => $i->comentarios,
                    'descripcion' => $i->descripcion,
                    'created_at' => $i->created_at,
                    'updated_at' => $i->updated_at
                ]);
            });
        }
    }

    private function updateArchivesArticulation($articulationStage, $articulation, $item)
    {
        if(isset($item->archivomodel)){
            $item->archivomodel->each(function($i) use($item, $articulationStage,$articulation){
                //var_dump(['mode_id' => $i->model_id,'ruta' => $i->ruta, 'fase_id' => $i->fase_id, 'fase' => $i->fase->nombre]);
                if($i->fase_id == 1 && $i->fase->nombre == "Inicio"){
                    if($item->codigo == $articulationStage->code)
                    {
                        $i->update([
                            'model_id' => $articulationStage->id,
                            'model_type'=> ArticulationStage::class
                        ]);
                        var_dump("el archivo {$i->ruta} en la fase {$i->fase_id} se guardará en la articulacion padre {$articulationStage->code}");

                    }else{
                        var_dump(" ojo con el archivo {$i->ruta} de la fase {$i->fase_id} en la padre");
                    }
                }else{
                    if($item->codigo == $articulation->code){
                        $i->update([
                            'model_id' => $articulation->id,
                            'model_type'=> \App\Models\Articulation::class
                        ]);
                        var_dump("el archivo {$i->ruta} en la fase {$i->fase_id} se guardará en la articulacion hija {$articulationStage->code}");

                    }else{
                        var_dump(" ojo con el archivo {$i->ruta} de la fase {$i->fase_id} en la hija");
                    }
                }
            });
        }

    }

    private function migrateArchivesArticulation($articulation, $item)
    {
        $newRote = "";
            if(isset($item->archivomodel)){
                $filePath = str_replace('storage', 'public', $item->archivomodel->ruta);
                if (Storage::exists($filePath)) {
                    //echo $filePath . "<br>";

                    $route = explode('/',$item->archivomodel->ruta);
                    $node = $route[2];
                    $year = $route[3];
                    $fase = $route[7];
                    $file = $route[8];

                    if(isset($fase)){
                        $phase = strtolower($fase);
                        if($phase == "inicio"){
                            $newRote = "public/{$node}/{$year}/". Str::slug(__('articulation-stage'))."/{$articulation->code}/{$file}";
                        }else{
                            $newRote = "public/{$node}/{$year}/". Str::slug(__('articulation-stage'))."/{$articulation->articulationstage->present()->articulationStageCode()}/{$articulation->code}/{$phase}/{$file}";
                        }

                    }else{
                        $newRote = "public/{$node}/{$year}/". Str::slug(__('articulation-stage'))."/{$articulation->articulationstage->present()->articulationStageCode()}/{$articulation->code}/{$file}";
                    }

                    $file = Storage::get(str_replace('storage', 'public', $item->archivomodel->ruta));

                    if (!Storage::exists($newRote)) {
                        Storage::copy(str_replace('storage', 'public', $item->archivomodel->ruta), $newRote);
                    }

                    if(isset($fase)){
                        $phase = strtolower($fase);
                        if($phase == "inicio"){
                            $articulation->articulationstage->archivomodel()->create([
                                'ruta' => Storage::url(str_replace('public', 'storage',$newRote))
                            ]);
                        }else{
                            $articulation->archivomodel()->create([
                                'ruta' => Storage::url(str_replace('public', 'storage',$newRote)),
                                'fase_id' => isset($articulation->phase->id)? $articulation->phase->id : null
                            ]);
                        }
                    }else{
                        $articulation->archivomodel()->create([
                            'ruta' => Storage::url(str_replace('public', 'storage',$newRote))
                        ]);
                    }
                }
            }
    }

    private function updateAsesorablesArticulation($articulation, $item)
    {
        if(isset($item->asesorias)){
            $item->asesorias->each(function($i) use($item, $articulation){
                if($i->asesorable_type == ArticulacionPbt::class){
                    if($item->codigo == $articulation->code)
                    {
                        $i->update([
                            'asesorable_id' => $articulation->id,
                            'asesorable_type'=> \App\Models\Articulation::class
                        ]);
                    }
                }
            });
        }
    }
}
