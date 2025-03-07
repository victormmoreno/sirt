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
        if (request()->user()->cannot('index', ArticulationStage::class)) {
            alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        $nodos = null;
        if(request()->user()->can('listNodes', ArticulationStage::class)) {
            $nodos = Nodo::query()->with('entidad')->where('nodos.estado', 1)->get();
            $nodos = collect($nodos)->sortBy('entidad.nombre')->pluck('entidad.nombre', 'id');
        }
        return view('articulation.index-articulation-stage', ['nodos' => $nodos]);
    }

    /**
     * method to show return the datatables ArticulationStages
     * @return void
     */
    public function datatableFiltros(Request $request)
    {
        if (request()->ajax() && request()->user()->cannot('index', ArticulationStage::class)) {
            alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
            return $this->datatablearticulationStages([]);
        }
        $talent = $this->checkRoleAuth($request)['talent'];
        $node = $this->checkRoleAuth($request)['node'];
        $articulationStages = [];
        if (isset($request->filter_status_articulationStage) || isset($request->filter_year_articulationStage)) {
            $articulationStages = $this->articulationStageRepository->getListArticulacionStagesWithArticulations()
            ->leftJoin('articulations', 'articulations.articulation_stage_id', '=', 'articulation_stages.id')
            ->leftJoin('fases', 'fases.id', '=', 'articulations.phase_id')
            ->leftJoin('articulation_scopes', 'articulation_scopes.id', '=', 'articulations.scope_id')
            ->leftJoin('articulation_subtypes', 'articulation_subtypes.id', '=', 'articulations.articulation_subtype_id')
            ->leftJoin('articulation_types', 'articulation_types.id', '=', 'articulation_subtypes.articulation_type_id')
            ->select(
                'articulation_stages.*', 'articulations.code as articulation_code',
                'articulations.id as articulation_id','articulations.start_date as articulation_start_date','articulations.name as articulation_name','articulations.description as articulation_description', 'fases.nombre as fase',
                'entidades.nombre as nodo', 'proyectos.codigo_proyecto as codigo_proyecto',
                'proyectos.nombre as nombre_proyecto', 'proyectos.id as proyecto_id'
            )
            ->selectRaw("if(articulationables.articulationable_type = 'App\\\Models\\\Proyecto', 'Proyecto', if(articulationables.articulationable_type = 'App\\\Models\\\Sede', 'Empresa', if(articulationables.articulationable_type = 'App\\\Models\\\Idea', 'Idea', 'No registra'))) as articulation_state_type, concat(interlocutor.documento, ' - ', interlocutor.nombres, ' ', interlocutor.apellidos) as talent_interlocutor, concat(createdby.documento, ' - ', createdby.nombres, ' ', createdby.apellidos) as created_by, concat(empresas.nit, ' - ', empresas.nombre, ' - ', sedes.nombre_sede) as sede, concat(ideas.codigo_idea, ' - ', ideas.nombre_proyecto) as idea")
            ->node($node)
            ->status($request->filter_status_articulationStage)
            ->year($request->filter_year_articulationStage)
            ->interlocutorTalent($talent)
            ->orderBy('articulation_stages.updated_at', 'desc')
            ->get();
        }
        return $this->datatablearticulationStages($articulationStages);
    }


    /**
     * method to download the list of articulation stages
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request, $extension = 'xlsx')
    {
        if (request()->user()->cannot('downloadReports', ArticulationStage::class)) {
            alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        $talent = $this->checkRoleAuth($request)['talent'];
        $node = $this->checkRoleAuth($request)['node'];
        $articulationStages = [];
        if (isset($request->filter_status_articulationStage)) {
            $articulationStages = $this->articulationStageRepository->getListArticulacionStagesWithArticulations()
            ->leftJoin('articulations', 'articulations.articulation_stage_id', '=', 'articulation_stages.id')
            ->leftJoin('fases', 'fases.id', '=', 'articulations.phase_id')
            ->leftJoin('articulation_scopes', 'articulation_scopes.id', '=', 'articulations.scope_id')
            ->leftJoin('articulation_user', 'articulation_user.articulation_id', '=', 'articulations.id')
            ->leftJoin('users as participants', 'participants.id', '=', 'articulation_user.user_id')
            ->leftJoin('articulation_subtypes', 'articulation_subtypes.id', '=', 'articulations.articulation_subtype_id')
            ->leftJoin('articulation_types', 'articulation_types.id', '=', 'articulation_subtypes.articulation_type_id')
            ->select(
                'articulation_stages.*', 'articulations.code as articulation_code',
                'articulations.id as articulation_id','articulations.end_date as articulation_end_date','articulations.name as articulation_name','articulations.description as articulation_description', 'fases.nombre as fase',
                'entidades.nombre as nodo', 'proyectos.codigo_proyecto as codigo_proyecto',
                'proyectos.nombre as nombre_proyecto', 'proyectos.id as proyecto_id', 'interlocutor.documento', 'interlocutor.nombres',
                'interlocutor.apellidos', 'interlocutor.email', 'articulation_subtypes.name as articulation_subtype', 'articulation_types.name as articulation_type', 'articulation_scopes.name as scope'
            )
            ->selectRaw("if(articulationables.articulationable_type = 'App\\\Models\\\Proyecto', 'Proyecto', 'No registra') as articulation_state_type, concat(interlocutor.documento, ' - ', interlocutor.nombres, ' ', interlocutor.apellidos) as talent_interlocutor, concat(createdby.documento, ' - ', createdby.nombres, ' ', createdby.apellidos) as created_by, GROUP_CONCAT(DISTINCT CONCAT(participants.documento, ' - ', participants.nombres, ' ', participants.apellidos)  SEPARATOR ';') as participants")
            ->selectRaw("DATE_FORMAT(articulations.start_date, '%d/%m/%Y') AS articulation_start_date")
            ->selectRaw("DATE_FORMAT(articulations.start_date, '%Y') AS articulation_start_date_year")
            ->selectRaw("DATE_FORMAT(articulations.end_date, '%d/%m/%Y') AS articulation_end_date")
            ->selectRaw("DATE_FORMAT(articulations.end_date, '%Y') AS articulation_end_date_year")
            ->selectRaw("DATE_FORMAT(articulation_stages.start_date, '%d/%m/%Y') AS articulation_stages_start_date")
            ->selectRaw("DATE_FORMAT(articulation_stages.start_date, '%Y') AS articulation_stages_start_date_year")
            ->selectRaw("DATE_FORMAT(articulation_stages.end_date, '%d/%m/%Y') AS articulation_stages_end_date_year")
            ->selectRaw("DATE_FORMAT(articulation_stages.end_date, '%Y') AS articulation_stages_end_date_year")
            ->node($node)
            ->status($request->filter_status_articulationStage)
            // ->year($request->filter_year_articulationStage)
            ->interlocutorTalent($talent)
            ->groupBy('articulations.code', 'articulation_stages.code')
            ->orderBy('articulations.updated_at', 'desc')
            ->get();
        }
        return (new articulationStageExport($articulationStages))->download(__('Articulations') .' - '. config('app.name') . ".{$extension}");
    }


    /**
     * Display the specified resource for change the interlocutor talent of an articulation stage.
     *
     * @param  string  $code
     * @return \Illuminate\Http\Response
     */
    public function changeInterlocutor($code)
    {
        $articulationStage = ArticulationStage::query()->where('code',$code)->firstOrFail();
        if (request()->user()->cannot('changeTalent', $articulationStage)) {
            alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        return view('articulation.change-interlocutor', compact('articulationStage'));
    }

    /**
     * method to change the interlocutor talent of an articulation stage
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $code
     */
    public function updateInterlocutor(Request $request, $code)
    {
        $articulationStage = ArticulationStage::query()->where('code',$code)->firstOrFail();
        if (request()->user()->cannot('changeTalent', $articulationStage)) {
            alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
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
                        'url' => route('articulation-stage.show', $response['data']),
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
                    return "<blockquote class='primary-text'>{$data->nodo}</blockquote>";
                }
            })
            ->editColumn('articulation_name', function ($data) {
                if($data->articulation_code){
                    return "<p>
                            <span class='primary-text'>{$data->articulation_code}</span><br>
                            <b>".Str::limit("{$data->articulation_name}", 40, '...')."</b>
                        </p>";
                }
            })
            ->editColumn('articulationstate_name', function ($data) {
                $articulationType = '';
                if($data->articulation_state_type == 'Proyecto'){
                    $articulationType = Str::limit("{$data->codigo_proyecto} - {$data->nombre_proyecto}", 40, '...');
                }else if($data->articulation_state_type == 'Empresa'){
                    $articulationType = Str::limit("{$data->sede}", 40, '...');
                }else if($data->articulation_state_type == 'Idea'){
                    $articulationType = Str::limit("{$data->idea}", 40, '...');
                }else{
                    $articulationType = 'No registra';
                }
                return "
                <tr  class='group grey z-depth-1 lighten-2'>
                    <th >
                        {$data->nodo}
                    </th>
                    <th>
                        <p>
                            <span class='primary-text'>{$data->present()->articulationStageCode()}</span><br>
                            <b>".Str::limit("{$data->present()->articulationStageName()}", 40, '...')."</b><br>
                            <span class='primary-text'>Talento Interlocutor: </span> ".Str::limit("{$data->talent_interlocutor}", 30, '...')."
                        </p>
                    </th>
                    <th>
                        <p>
                            <span class='primary-text'>{$data->articulation_state_type}</span><br>
                            <b>".$articulationType."</b><br>
                        </p>
                    </th>
                    <th>
                        <div class='chip ". $data->present()->articulationStageStatusColor() ." white-text text-darken-2'>".$data->present()->articulationStageStatus()."</div>
                    </th>
                    </th>
                    <th>
                        {$data->present()->articulationStageStartDate()}
                    </th>
                    <th>
                        <a class='btn bg-info m-b-xs modal-trigger' href='".route('articulation-stage.show', $data)."'>
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
                    return Carbon::parse($data->articulation_start_date)->isoFormat('YYYY/MM/DD');
                }
            })->addColumn('show', function ($data) {
                if(isset($data->articulation_id)){
                    return '<a class="btn bg-info m-b-xs modal-trigger" href='.route('articulations.show', [$data->articulation_code]).'>
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
        $node = [];
        switch (\Session::get('login_role')) {
            case User::IsAdministrador():
                $node = $request->filter_node_articulationStage;
                break;
            case User::IsActivador():
                $node = $request->filter_node_articulationStage;
                break;
            case User::IsDinamizador():
                $node = [auth()->user()->dinamizador->nodo_id];
                break;
            case User::IsArticulador():
                $node = [auth()->user()->articulador->nodo_id];
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
     * @param  string  $code
     * @return \Illuminate\Http\Response
     */
    public function show($code)
    {
        $articulationStage = ArticulationStage::query()
            ->select(
                'articulation_stages.*', 'articulations.code as articulation_code',
                'articulations.id as articulation_id','articulations.start_date as articulation_start_date','articulations.name as articulation_name','articulations.description as articulation_description', 'fases.nombre as fase', 'fases.id as fase_id',
                'entidades.nombre as nodo', 'proyectos.codigo_proyecto',
                'proyectos.nombre as nombre_proyecto', 'proyectos.id as proyecto_id', 'interlocutor.documento', 'interlocutor.nombres',
                'interlocutor.apellidos', 'interlocutor.email'
            )
            ->selectRaw("if(articulationables.articulationable_type = 'App\\\Models\\\Proyecto', 'Proyecto', if(articulationables.articulationable_type = 'App\\\Models\\\Sede', 'Empresa', if(articulationables.articulationable_type = 'App\\\Models\\\Idea', 'Idea', 'No registra'))) as articulation_type, concat(interlocutor.documento, ' - ', interlocutor.nombres, ' ', interlocutor.apellidos) as talent_interlocutor, concat(createdby.documento, ' - ', createdby.nombres, ' ', createdby.apellidos) as created_by")
            ->join('nodos', 'nodos.id', '=', 'articulation_stages.node_id')
            ->join('entidades', 'entidades.id', '=', 'nodos.entidad_id')
            ->leftJoin('articulations', 'articulations.articulation_stage_id', '=', 'articulation_stages.id')
            ->leftJoin('fases', 'fases.id', '=', 'articulations.phase_id')
            ->leftJoin('articulationables', function($q) {
                $q->on('articulationables.articulation_stage_id', '=', 'articulation_stages.id');
            })
            ->leftJoin('proyectos', 'proyectos.id', '=', 'articulationables.articulationable_id')
            ->leftJoin('users as interlocutor', 'interlocutor.id', '=', 'articulation_stages.interlocutor_talent_id')
            ->leftJoin('users as createdby', 'createdby.id', '=', 'articulation_stages.created_by')
            ->groupBy('articulation_code')
            ->where('articulation_stages.code', $code)->firstOrFail();


        if (request()->user()->cannot('show', $articulationStage))
        {
            alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        $traceability = ArticulationStage::getTraceability($articulationStage)->get();

        $ult_traceability = ArticulationStage::getTraceability($articulationStage)->get()->last();
        $ult_notificacion = $this->articulationStageRepository->retornarUltimaNotificacionPendiente($articulationStage);

        $rol_destinatario = $this->articulationStageRepository->verifyRecipientNotification($ult_notificacion);
        $rol_emisor = $this->articulationStageRepository->verifyRemitenteNotification($ult_notificacion);
        return view('articulation.show-articulation-stage', compact('articulationStage', 'ult_notificacion', 'rol_destinatario','rol_emisor',  'traceability', 'ult_traceability'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $articulationState
     */
    public function destroy($articulationState)
    {
        $articulationStage = ArticulationStage::findOrFail($articulationState);
        if (request()->user()->cannot('delete', $articulationStage)) {
            alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
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
        if (isset($articulationStage->archivomodel)) {
            foreach ($articulationStage->archivomodel as $archive){
                $filePath = str_replace('storage', 'public', $archive->ruta);
                Storage::delete($filePath);
                $archive->delete();
            }
        }

        if (isset($articulationStage->notifications)) {
            $articulationStage->notifications()->delete();
        }
        if (isset($articulationStage->traceability)) {
            $articulationStage->traceability()->delete();
        }
        $articulationStage->delete();
        return response()->json([
            'fail' => false,
            'redirect_url' => route('articulation-stage'),
        ]);


    }

    public function changeStatus($code)
    {
        $articulationStage = ArticulationStage::query()->where('code',$code)->firstOrFail();
        if (request()->user()->cannot('changeState', $articulationStage)) {
            alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        $response = $this->articulationStageRepository->updateStatus($articulationStage);
        if (!$response['state']) {
            return response()->json([
                'fail' => true,
                'errors' => $this->articulationStageRepository->getError(),
                'message' => null,
                'redirect_url' => null,
            ]);
        }
        return response()->json([
            'data' => $response['data'],
            'fail' => false,
            'errors' => null,
            'message' => "Actualización extiosa",
            'redirect_url' => url(route('articulation-stage.show', $response['data'])),
        ]);
    }
}
