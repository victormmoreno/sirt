<?php

namespace App\Http\Controllers\Articulation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ArticulationStage;
use App\Models\Entidad;
use App\User;
use Illuminate\Support\Str;
use App\Exports\Accompaniment\AccompanimentExport;
use App\Repositories\Repository\Accompaniment\AccompanimentRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ArticulationStageListController extends Controller
{

    private $articulationStageRepository;

    public function __construct(AccompanimentRepository $articulationStageRepository)
    {
        $this->articulationStageRepository = $articulationStageRepository;
        $this->middleware(['auth']);
    }

    /**
     * method to show the list of articulationStages (index) with filters
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nodos = Entidad::with(['nodo'])->has('nodo')->orderBy('nombre')->get()->pluck('nombre', 'nodo.id');
        return view('articulation.index-articulation-stage', ['nodos' => $nodos]);
    }

    private function checkRoleAuth(Request $request)
    {
        $talent = null;
        $node = null;
        switch (\Session::get('login_role')) {
            case User::IsAdministrador():
                $node = $request->filter_node_accompaniment;
                break;
            case User::IsActivador():
                $node = $request->filter_node_accompaniment;
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
                return abort('403');
                break;
        }
        return ['talent' => $talent, 'node' => $node];
    }

    public function datatableFiltros(Request $request)
    {
        $talent = $this->checkRoleAuth($request)['talent'];
        $node = $this->checkRoleAuth($request)['node'];

        $accompaniments = [];
        if (isset($request->filter_status_accompaniment)) {

            $accompaniments =  ArticulationStage::with([
                'node',
                'node.entidad',
                'createdBy'
            ])
            ->status($request->filter_status_accompaniment)
            ->year($request->filter_year_accompaniment)
            ->node($node)
            ->interlocutorTalent($talent)
            ->orderBy('created_at', 'desc')
            ->get();
        }
        return $this->datatableAccompaniments($accompaniments);
    }

    private function datatableAccompaniments($accompaniments)
    {
        return datatables()->of($accompaniments)
        ->editColumn('node', function ($data) {
            return $data->present()->accompanimentNode();
        })
        ->editColumn('code', function ($data) {
            return $data->present()->accompanimentCode();
        })
        ->editColumn('name', function ($data) {
            return Str::limit("{$data->present()->accompanimentName()}", 40, '...');
        })
        ->editColumn('count_articulations', function ($data) {
            if (isset($data->articulations_count)) {
                return "{$data->articulations_count}";
            }
            return 0;
        })
        ->editColumn('status', function ($data) {
            if($data->status == ArticulationStage::STATUS_OPEN){
                return  '<div class="chip green white-text text-darken-2">'.$data->present()->accompanimentStatus().'</div>';
            }
            if($data->status == ArticulationStage::STATUS_CLOSE){
                return  '<div class="chip red white-text text-darken-2">'.$data->present()->accompanimentStatus().'</div>';
            }

        })
        ->editColumn('accompanimentBy', function ($data) {
            return $data->present()->accompanimentBy();
        })
        ->editColumn('starDate', function ($data) {
            return $data->present()->accompanimentStartDate();
        })->addColumn('show', function ($data) {
            $info = '<a class="btn m-b-xs modal-trigger" href='.route('articulation-stage.show', $data->id).'>
            <i class="material-icons">search</i>
            </a>';
                return $info;
        })->rawColumns(['node','code','name','adviser','status','starDate','accompanimentBy','show'])->make(true);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $accompaniment = ArticulationStage::with([
                'node',
                'createdBy',
                'articulations',
                'articulations.phase'

            ])
        ->findOrfail($id);

        $ult_notificacion = $accompaniment->notifications()->whereNull('fecha_aceptacion')->get()->last();

        $articulations = $accompaniment->articulations()->latest('id')->paginate(2);

        return view('articulation.show', compact('accompaniment', 'articulations', 'ult_notificacion'));
    }

    public function export(Request $request, $extension = 'xlsx')
    {
        $talent = $this->checkRoleAuth($request)['talent'];
        $node = $this->checkRoleAuth($request)['node'];


        $accompaniments = [];
        if (isset($request->filter_status_accompaniment)) {

            $accompaniments =  ArticulationStage::with([
                'node',
                'node.entidad',
                'createdBy'
            ])
            ->status($request->filter_status_accompaniment)
            ->year($request->filter_year_accompaniment)
            ->node($node)
            ->interlocutorTalent($talent)
            ->orderBy('created_at', 'desc')
            ->get();
        }
        return (new AccompanimentExport($accompaniments))->download("Etapa articulación" . config('app.name') . ".{$extension}");
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

    public function changeInterlocutor(ArticulationStage $accompaniment)
    {
        return view('articulation.change-interlocutor', compact('accompaniment'));
    }

    /**
     * Update los miembros de una etapa.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function updateInterlocutor(Request $request, ArticulationStage $accompaniment)
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
            $response = $this->articulationStageRepository->updateInterlocutor($request, $accompaniment);
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

}
