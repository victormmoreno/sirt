<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\{Str, Facades\Session, Facades\Validator};
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

class MigracionController extends Controller
{
    public function index()
    {
        return view('migraciones.desarrollador.index', [
            'nodos' => Nodo::SelectNodo()->get()
        ]);
    }

    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombreArchivo' => ['required'],
            'txtnodo_id' => ['required']
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }
        session()->put('errorMigracion', null);
        Excel::import(new MigracionProyectosImport($request->txtnodo_id), request()->file('nombreArchivo'));
        if (Session::get('errorMigracion') == null) {
            alert()->success('Migración Exitosa!', 'La información se ha migrado exitósamente!')->showConfirmButton('Ok', '#3085d6');
        } else {
            alert()->error('Migración Errónea!', Session::get('errorMigracion'))->showConfirmButton('Ok', '#3085d6');
        }
        session()->put('errorMigracion', null);
        return back();
    }

    public function articulations()
    {
        return view('migraciones.articulations', [
            'nodos' => Nodo::SelectNodo()->get()
        ]);
    }

    public function migrateArticulations(Request $request)
    {
        // $articulaciones = Articulacion::query()
        //     ->select('articulaciones.id as articulacion_id', 'articulaciones.asesor_id as asesor',
        //     'articulaciones.nodo_id as nodo', 'articulaciones.fase_id as fase', 'articulaciones.acuerdos',
        //     'articulaciones.alcance_articulacion as alcance', 'articulaciones.siguientes_investigaciones', 'articulaciones.acc',
        //     'articulaciones.informe_final', 'articulaciones.created_at', 'articulaciones.updated_at',
        //     'articulaciones_productos.producto_id as producto', 'articulaciones_productos.logrado')
        //     ->selectRaw('if(articulaciones.tipo_articulacion=0,"grupo", if(articulaciones.tipo_articulacion=1,"Empresa", if(articulaciones.tipo_articulacion=2,"Emprendedor","No registra"))) as tipo_articulacion')
        //     ->leftJoin('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'articulaciones.articulacion_proyecto_id')
        //     ->leftJoin('articulaciones_productos', 'articulaciones_productos.articulacion_id', '=', 'articulaciones.id')

        //     ->get();

        // $articulaciones = ArticulacionPbt::query()
        // ->select('articulacion_pbts.id', 'articulacion_pbts.codigo', 'articulacion_pbts.nombre')
        // ->leftJoin('historial_entidad', 'historial_entidad.model_id', '=', 'articulacion_pbts.id')
        // ->groupBy('articulacion_pbts.codigo')
        // ->orderBy('articulacion_pbts.fecha_inicio')
        // ->get();





        $articulaciones = ArticulacionPbt::query()
            ->with([
                'asesor',
                'talentos',
                'alcancearticulacion',
                'archivomodel'
                // 'talentos' => function($query){
                //     $query->where('talento_lider', 1);
                // }
            ])
            // ->where('nodo_id', 4)
            // ->whereHas('archivomodel', function($query){
            //     $query->where('model_type', ArticulacionPbt::class);
            // })
            // ->latest()
            // ->take(5)
            ->get();



            /**
             * model_id
             * model_type
             * ruta
             * fase_id
             * created_at
             * updated_at
             *
             */
            // return $articulaciones;

            // $articulaciones->each(function($item){
            //     // echo  $item->archivomodel->ruta.  "</br>";
            //     if(isset($item->archivomodel)){
            //         if (Storage::exists(str_replace('storage', 'public', $item->archivomodel->ruta))) {
            //             // echo $url = Storage::url(str_replace('/storage/','', $item->archivomodel->ruta)) . ' | ';
            //             echo "existe " . $item->archivomodel->ruta . "</br>";
            //         }
            //     }


            // });
            // echo "hola";
            // die;

        $articulaciones->each(function ($item){


            $articulationStage = $this->updateOrCreateArticulationStage($item);
            $this->validateArticulationStageType($articulationStage, $item);
            $articulation = $this->updateOrCreateArticulation($articulationStage, $item);

            if ($item->talentos->count() > 0) {
                $item->talentos->each(function($i) use($articulation){
                    $articulation->users()->sync($i->user_id);
                });
            }



            // if ($item->historial->count() > 0) {
            //     $item->historial->each(function($i) use($articulation){
            //         $articulation->traceability()->updateOrCreate([
            //             'model_id' => $i->model_id
            //         ],[
            //             'model_type' => Articution::class,
            //             'movimiento_id' => $i->movimiento_id,
            //             'user_id' => $i->user_id,
            //             'role_id' => $i->role_id,
            //             'comentarios' => $i->comentarios,
            //             'descripcion' => $i->descripcion,
            //             'created_at' => $i->created_at,
            //             'updated_at' => $i->updated_at
            //         ]);
            //     });
            // }

            $newRote = "";



            if(isset($item->archivomodel)){



                $filePath = str_replace('storage', 'public', $item->archivomodel->ruta);

                if (Storage::exists($filePath)) {
                    echo $filePath . "<br>";

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

            // echo $newRote . "<br>";



        });



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
            'endorsement'=> 1,
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
        // $asesor = User::where('id', $item->asesor_id)->first()->id;

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
}
