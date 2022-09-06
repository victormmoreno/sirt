<?php

namespace App\Http\Controllers\Articulation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ArticulationStage;
use App\Models\Entidad;
use App\User;
use Illuminate\Support\Str;
use App\Exports\Articulation\articulationStageExport;
use App\Repositories\Repository\Articulation\ArticulationStageRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

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
            $nodos = Entidad::with('nodo')->orderBy('nombre')->get()->pluck('nombre', 'nodo.id');
            return view('articulation.index-articulation-stage', ['nodos' => $nodos]);
        }
        return redirect()->route('home');
    }

    public function datatableFiltros(Request $request)
    {
        $talent = $this->checkRoleAuth($request)['talent'];
        $node = $this->checkRoleAuth($request)['node'];
        $articulationStages = [];
        if (isset($request->filter_status_articulationStage)) {

            $articulationStages =  ArticulationStage::query()
            ->with(['node.entidad', 'createdBy'])
            ->status($request->filter_status_articulationStage)
            ->year($request->filter_year_articulationStage)
            ->node($node)
            ->interlocutorTalent($talent)
            ->orderBy('created_at', 'desc')
            ->get();
        }
        return $this->datatablearticulationStages($articulationStages);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $articulationStage = ArticulationStage::with([
                'node',
                'createdBy',
                'articulations',
                'articulations.phase'

            ])
        ->findOrfail($id);

        $ult_notificacion = $articulationStage->notifications()->whereNull('fecha_aceptacion')->get()->last();

        $articulations = $articulationStage->articulations()->latest('id')->paginate(2);

        return view('articulation.show', compact('articulationStage', 'articulations', 'ult_notificacion'));
    }

    public function export(Request $request, $extension = 'xlsx')
    {
        $talent = $this->checkRoleAuth($request)['talent'];
        $node = $this->checkRoleAuth($request)['node'];


        $articulationStages = [];
        if (isset($request->filter_status_articulationStage)) {

            $articulationStages =  ArticulationStage::with([
                'node',
                'node.entidad',
                'createdBy'
            ])
            ->status($request->filter_status_articulationStage)
            ->year($request->filter_year_articulationStage)
            ->node($node)
            ->interlocutorTalent($talent)
            ->orderBy('created_at', 'desc')
            ->get();
        }
        return (new articulationStageExport($articulationStages))->download("Etapa articulación" . config('app.name') . ".{$extension}");
    }

    /**
     * Método que elimina un archivo del servidor y su registro de la base de datos (RutaModel)
    * @param int id Id del archivo del entrenamiento que se usará para eliminarlo del almacenamiento y de la base de datos
    * @return Response
    */
    public function destroyFile($id)
    {
        $response = $this->articulationStageRepository->destroyFile($id);

        if($response){
            toast('El Archivo se ha eliminado con éxito!','success')->autoClose(2000)->position('top-end');
            return back();
        }
        toast('El Archivo no se ha eliminado!','danger')->autoClose(2000)->position('top-end');
        return back();
    }

    public function changeInterlocutor(ArticulationStage $articulationStage)
    {
        return view('articulation.change-interlocutor', compact('articulationStage'));
    }

    /**
     * Update los miembros de una etapa.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function updateInterlocutor(Request $request, ArticulationStage $articulationStage)
    {
        $validator = Validator::make($request->all(), [
            'talent' => 'required'
        ], [
            'talent' => 'Debes seleccionar por lo menos un talento interlocutor'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'state'   => 'error_form',
                'errors' => $validator->errors(),
            ]);
        } else {
            $response = $this->articulationStageRepository->updateInterlocutor($request, $articulationStage);
            if($response["isCompleted"]){
                return response()->json([
                    'data' => [
                        'state'   => 'success',
                        'url' => route(' articulation-stage.show', $response['data']->id),
                        'status_code' => Response::HTTP_CREATED,
                        'errors' => [],
                    ],
                ], Response::HTTP_CREATED);
            }else{
                return response()->json([
                    'data' => [
                        'state'   => 'danger',
                        'errors' => [],
                    ],
                ]);
            }
        }

    }
    private function datatableArticulationStages($articulationStages)
    {
        return datatables()->of($articulationStages)
            ->editColumn('node', function ($data) {
                return $data->node->present()->NodeName();
            })
            ->editColumn('code', function ($data) {
                return $data->present()->articulationStageCode();
            })
            ->editColumn('name', function ($data) {
                return Str::limit("{$data->present()->articulationStageName()}", 40, '...');
            })
            ->editColumn('count_articulations', function ($data) {
                if (isset($data->articulations_count)) {
                    return "{$data->articulations_count}";
                }
                return 0;
            })
            ->editColumn('status', function ($data) {
                if($data->status == ArticulationStage::STATUS_OPEN){
                    return  '<div class="chip green white-text text-darken-2">'.$data->present()->articulationStageStatus().'</div>';
                }
                if($data->status == ArticulationStage::STATUS_CLOSE){
                    return  '<div class="chip red white-text text-darken-2">'.$data->present()->articulationStageStatus().'</div>';
                }
            })
            ->editColumn('articulationStageBy', function ($data) {
                return $data->present()->articulationStageBy();
            })
            ->editColumn('starDate', function ($data) {
                return $data->present()->articulationStageStartDate();
            })->addColumn('show', function ($data) {
                return '<a class="btn m-b-xs modal-trigger" href='.route('articulation-stage.show', $data->id).'>
                            <i class="material-icons">search</i>
                        </a>';
            })->rawColumns(['node','code','name','adviser','status','starDate','articulationStageBy','show'])->make(true);
    }

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

}
