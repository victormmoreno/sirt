<?php

namespace App\Http\Controllers\Articulation;

use App\Models\Nodo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ArticulationStage;
use App\User;
use Illuminate\Support\Str;
use App\Exports\Articulation\articulationStageExport;
use App\Repositories\Repository\Articulation\ArticulationStageRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade as PDF;

class ArticulationStageListController extends Controller
{
    private $articulationStageRepository;
    public function __construct(ArticulationStageRepository $articulationStageRepository)
    {
        $this->articulationStageRepository = $articulationStageRepository;
        $this->middleware(['auth']);
    }
    /**
     * method to show the list of articulationStages (index) with filters
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->user()->can('index', ArticulationStage::class)) {
            $nodos = null;
            if(request()->user()->can('listNodes', ArticulationStage::class)) {
                $nodos = Nodo::query()->with('entidad')->get();
                $nodos = collect($nodos)->sortBy('entidad.nombre')->pluck('entidad.nombre', 'id');
            }
            return view('articulation.index-articulation-stage', ['nodos' => $nodos]);
        }
        alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
        return redirect()->route('home');
    }

    /**
     * method to show return the datatables ArticulationStages
     * @return \Illuminate\Http\Response
     */
    public function datatableFiltros(Request $request)
    {
        if (request()->ajax() && request()->user()->can('index', ArticulationStage::class)) {
            $talent = $this->checkRoleAuth($request)['talent'];
            $node = $this->checkRoleAuth($request)['node'];
            $articulationStages = [];
            if (isset($request->filter_status_articulationStage) || isset($request->filter_year_articulationStage)) {
                $articulationStages = $this->articulationStageRepository->getListArticulacionStagesWithArticulations()
                    ->status($request->filter_status_articulationStage)
                    ->year($request->filter_year_articulationStage)
                    ->node($node)
                    ->interlocutorTalent($talent)
                    ->orderBy('created_at', 'desc')
                    ->get();
            }
            return $this->datatablearticulationStages($articulationStages);
        }
        alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
        return redirect()->route('home');
    }

    /**
     * method to download the list of articulation stages
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request, $extension = 'xlsx')
    {
        if (request()->user()->can('downloadReports', ArticulationStage::class)) {
            $talent = $this->checkRoleAuth($request)['talent'];
            $node = $this->checkRoleAuth($request)['node'];
            $articulationStages = [];
            if (isset($request->filter_status_articulationStage)) {
                $articulationStages = $this->articulationStageRepository->getListArticulacionStagesWithArticulations()
                    ->status($request->filter_status_articulationStage)
                    ->year($request->filter_year_articulationStage)
                    ->node($node)
                    ->interlocutorTalent($talent)
                    ->groupBy('articulation_stages.code')
                    ->orderBy('created_at', 'desc')
                    ->get();
            }
            return (new articulationStageExport($articulationStages))->download(__('articulation-stage') .' - '. config('app.name') . ".{$extension}");
        }
        return redirect()->route('home');
    }

    /**
     * method to delete system file
     * @param int id
     * @return Response
     */
    public function destroyFile($id)
    {
        if (request()->user()->can('destroyFile', ArticulationStage::class)) {
            $response = $this->articulationStageRepository->destroyFile($id);
            if ($response) {
                toast('El Archivo se ha eliminado con éxito!', 'success')->autoClose(2000)->position('top-end');
                return back();
            }
            toast('El Archivo no se ha eliminado!', 'danger')->autoClose(2000)->position('top-end');
            return back();
        }
        alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
        return redirect()->route('home');
    }

    /**
     * method to download a file from the system
     * @return \Illuminate\Http\Response
     */
    public function downloadFile($articulationStage)
    {
        $articulationStage = ArticulationStage::query()->findOrFail($articulationStage);
        if (request()->user()->can('downloadFile', $articulationStage)) {
            return $this->articulationStageRepository->downloadFile($articulationStage);
        }
        alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
        return redirect()->route('home');
    }

    /**
     * Display the specified resource for change the interlocutor talent of an articulation stage.
     *
     * @param  int  $articulationStage
     * @return \Illuminate\Http\Response
     */
    public function changeInterlocutor($articulationStage)
    {
        $articulationStage = ArticulationStage::query()->findOrFail($articulationStage);
        if (request()->user()->can('changeTalent', $articulationStage)) {
            return view('articulation.change-interlocutor', compact('articulationStage'));
        }
        alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
        return redirect()->route('home');
    }

    /**
     * method to change the interlocutor talent of an articulation stage
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $articulationStage
     */
    public function updateInterlocutor(Request $request, $articulationStage)
    {
        $articulationStage = ArticulationStage::query()->findOrFail($articulationStage);
        if (request()->user()->can('changeTalent', $articulationStage)) {

            $validator = Validator::make($request->all(), [
                'talent' => 'required'
            ], [
                'talent' => 'Debes seleccionar por lo menos un talento interlocutor'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'state' => 'error_form',
                    'errors' => $validator->errors(),
                ]);
            } else {
                $response = $this->articulationStageRepository->updateInterlocutor($request, $articulationStage);
                if ($response["isCompleted"]) {
                    return response()->json([
                        'data' => [
                            'state' => 'success',
                            'url' => route('articulation-stage.show', $response['data']->id),
                            'status_code' => Response::HTTP_CREATED,
                            'errors' => [],
                        ],
                    ], Response::HTTP_CREATED);
                } else {
                    return response()->json([
                        'data' => [
                            'state' => 'danger',
                            'errors' => [],
                        ],
                    ]);
                }
            }
            alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
    }

    /**
     * method to return the structure of the datatables ArticulationStages
     * @return void
     */
    private function datatableArticulationStages($articulationStages)
    {
        return datatables()->of($articulationStages)
            ->editColumn('node', function ($data) {
                if($data->articulation_code){
                    return "<blockquote class='orange-text text-darken-2'>{$data->nodo}</blockquote>";
                }
            })
            ->editColumn('articulation_name', function ($data) {
                if($data->articulation_code){
                    return "<p>
                            <span class='orange-text'>{$data->articulation_code}</span><br>
                            <b>".Str::limit("{$data->articulation_name}", 40, '...')."</b>
                         </p>";
                }

            })
            ->editColumn('articulationstate_name', function ($data) {
                return "
                <tr class='group grey lighten-2'>
                    <th >
                        {$data->nodo}
                    </th>
                    <th>
                        <p>
                        <span class='orange-text'>{$data->present()->articulationStageCode()}</span><br>
                        <b>".Str::limit("{$data->present()->articulationStageName()}", 40, '...')."</b><br>
                        <span class='orange-text'>Talento Interlocutor: </span> ".Str::limit("{$data->nombres} {$data->apellidos}", 30, '...')."
                     </p>
                    </th>
                    <th>
                     <p>
                            <span class='orange-text'>{$data->articulation_type}</span><br>
                            <b>".Str::limit("{$data->codigo_proyecto} - {$data->nombre_proyecto}", 40, '...')."</b><br>
                        </p>
                    </th>
                    <th>
                         <div class='chip red ". $data->present()->articulationStageStatusColor() ." white-text text-darken-2'>".$data->present()->articulationStageStatus()."</div>
                    </th>
                    </th>
                    <th>
                        {$data->present()->articulationStageStartDate()}
                    </th>
                    <th>
                        <a class='btn m-b-xs modal-trigger' href='".route('articulation-stage.show', $data->id)."'>
                            <i class='material-icons'>search</i>
                        </a>
                    </th>
                </tr>";

            })
            ->editColumn('description', function ($data) {
                return Str::limit("{$data->articulation_description}", 40, '...');
            })
            ->editColumn('phase', function ($data) {
                return "{$data->fase}";
            })
            ->editColumn('starDate', function ($data) {
                if($data->articulation_start_date){
                    return Carbon::parse($data->articulation_start_date)->isoFormat('DD/MM/YYYY');
                }
            })->addColumn('show', function ($data) {
                if(isset($data->articulation_id)){
                    return '<a class="btn m-b-xs modal-trigger" href='.route('articulations.show', [$data->articulation_id]).'>
                            <i class="material-icons">search</i>
                        </a>';
                }
            })->rawColumns(['node','articulationstate_name','articulation_name','phase','starDate','show'])->make(true);
    }

    /**
     * method to validate the authenticated role
     * @return void
     */
    private function checkRoleAuth(Request $request)
    {
        $talent = null;
        $node = null;
        switch (\Session::get('login_role')) {
            case User::IsAdministrador():
                $node = $request->filter_node_articulationStage;
                break;
            case User::IsActivador():
                $node = $request->filter_node_articulationStage;
                break;
            case User::IsDinamizador():
                $node = auth()->user()->dinamizador->nodo_id;
                break;
            case User::IsArticulador():
                $node = auth()->user()->articulador->nodo_id;
                break;
            case User::IsTalento():
                $node = null;
                $talent = auth()->user()->id;
                break;
            default:
                $talent = null;
                $node = null;
                break;
        }
        return ['talent' => $talent, 'node' => $node];
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $articulationStage = $this->articulationStageRepository->getListArticulacionStagesWithArticulations()
            ->with(['traceability', 'articulations.phase'])
            ->findOrfail($id);
        if (request()->user()->cannot('show', $articulationStage))
        {
            alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        $ult_notificacion = $this->articulationStageRepository->retornarUltimaNotificacionPendiente($articulationStage);
        $rol_destinatario = $this->articulationStageRepository->verifyRecipientNotification($ult_notificacion);
        return view('articulation.show-articulation-stage', compact('articulationStage', 'ult_notificacion', 'rol_destinatario'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $articulationStage
     */
    public function destroy($articulationStage)
    {
        $articulationStage = ArticulationStage::findOrFail($articulationStage);
        if (request()->user()->can('delete', $articulationStage)) {
            if (!$articulationStage->articulations->IsEmpty()) {
                return response()->json([
                    'fail' => true,
                    'redirect_url' => route('articulation-stage.show', $articulationStage->id),
                ]);
            }
            if (isset($articulationStage->projects)) {
                $articulationStage->projects()->detach();
            }
            if (isset($articulationStage->articulations->users)) {
                $articulationStage->articulations()->delete();
                $articulationStage->articulations->users()->detach();
            }
            if (isset($articulationStage->file)) {
                $filePath = str_replace('storage', 'public', $articulationStage->file->ruta);
                Storage::delete($filePath);
                $articulationStage->file()->delete();
            }
            $articulationStage->delete();
            return response()->json([
                'fail' => false,
                'redirect_url' => route('articulation-stage'),
            ]);
        }
        return redirect()->route('home');
    }

    public function downloadCertificate(string $phase, $articulationStage){
        $articulationStage = ArticulationStage::query()
            ->select(
                'articulation_stages.*', 'articulations.code as articulation_code',
                'articulations.id as articulation_id','articulations.start_date as articulation_start_date','articulations.name as articulation_name','articulations.description as articulation_description', 'fases.nombre as fase',
                'entidades.nombre as nodo', 'actividades.codigo_actividad as codigo_proyecto',
                'actividades.nombre as nombre_proyecto', 'interlocutor.documento', 'interlocutor.nombres',
                'interlocutor.apellidos', 'interlocutor.email'
            )
            ->selectRaw("if(articulationables.articulationable_type = 'App\\\Models\\\Proyecto', 'Proyecto', 'No registra') as articulation_type")
            ->join('nodos', 'nodos.id', '=', 'articulation_stages.node_id')
            ->join('entidades', 'entidades.id', '=', 'nodos.entidad_id')
            ->leftJoin('articulations', 'articulations.articulation_stage_id', '=', 'articulation_stages.id')
            ->leftJoin('fases', 'fases.id', '=', 'articulations.phase_id')
            ->leftJoin('articulationables', function($q) {
                $q->on('articulationables.articulation_stage_id', '=', 'articulation_stages.id');
                $q->where('articulationables.articulationable_type', '=', 'App\Models\Proyecto');
            })
            ->leftJoin('proyectos', 'proyectos.id', '=', 'articulationables.articulationable_id')
            ->leftJoin('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'proyectos.articulacion_proyecto_id')
            ->leftJoin('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
            ->leftJoin('users as interlocutor', 'interlocutor.id', '=', 'articulation_stages.interlocutor_talent_id')
            ->findOrFail($articulationStage);
        if (request()->user()->can('downloadCertificate', $articulationStage)) {
            if(strtoupper($phase) == 'INICIO'){
                $pdf = PDF::loadView('pdf.articulation.articulation-stage-start', compact('articulationStage'));
                return $pdf->stream();
            }else if(strtoupper($phase) == 'CIERRE'){
                $pdf = PDF::loadView('pdf.articulation.articulation-stage-end', compact('articulationStage'));
                return $pdf->stream();
            }
        }
        return redirect()->route('home');
    }

    public function evidences($articulationStage)
    {
        $articulationStage = ArticulationStage::query()->findOrFail($articulationStage);
        if (request()->user()->can('uploadEvidences', $articulationStage)) {
            return view('articulation.articulation-stages-evidences', ['articulationStage' =>$articulationStage]);
        }
        alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
        return redirect()->route('home');
    }

}
