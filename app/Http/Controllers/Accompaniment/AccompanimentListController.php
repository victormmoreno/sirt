<?php

namespace App\Http\Controllers\Accompaniment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Accompaniment;
use App\Models\Entidad;
use App\User;
use Illuminate\Support\Str;
use App\Exports\Accompaniment\AccompanimentExport;
use App\Repositories\Repository\Accompaniment\AccompanimentRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class AccompanimentListController extends Controller
{

    private $accompanimentRepository;

    public function __construct(AccompanimentRepository $accompanimentRepository)
    {
        $this->accompanimentRepository = $accompanimentRepository;
        $this->middleware(['auth']);
    }
    /**
     * method to show the list of accompaniments (index) with filters
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nodos = Entidad::with(['nodo'])->has('nodo')->orderBy('nombre')->get()->pluck('nombre', 'nodo.id');
        return view('articulation.index-accompaniment', ['nodos' => $nodos]);
    }

    public function datatableFiltros(Request $request)
    {
        $talent = null;
        $node = null;
        switch (\Session::get('login_role')) {
            case User::IsAdministrador():
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

        $accompaniments = [];
        if (isset($request->filter_status_accompaniment)) {

            $accompaniments =  Accompaniment::with([
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
            if($data->status == Accompaniment::STATUS_OPEN){
                return  '<div class="chip green white-text text-darken-2">'.$data->present()->accompanimentStatus().'</div>';
            }
            if($data->status == Accompaniment::STATUS_CLOSE){
                return  '<div class="chip red white-text text-darken-2">'.$data->present()->accompanimentStatus().'</div>';
            }

        })
        ->editColumn('accompanimentBy', function ($data) {
            return $data->present()->accompanimentBy();
        })
        ->editColumn('starDate', function ($data) {
            return $data->present()->accompanimentStartDate();
        })->addColumn('show', function ($data) {
            $info = '<a class="btn m-b-xs modal-trigger" href='.route('accompaniments.show', $data->id).'>
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
        $accompaniment = Accompaniment::with([
                'node',
                'createdBy',
                'articulations',
                'articulations.phase'

            ])
        ->findOrfail($id);

        $articulations = $accompaniment->articulations()->latest('id')->paginate(2);

        return view('articulation.show', compact('accompaniment', 'articulations'));
    }

    public function export(Request $request, $extension = 'xlsx')
    {
        $talent = null;
        $node = null;
        switch (\Session::get('login_role')) {
            case User::IsAdministrador():
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

        $accompaniments = [];
        if (isset($request->filter_status_accompaniment)) {

            $accompaniments =  Accompaniment::with([
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
        return (new AccompanimentExport($accompaniments))->download("Articulaciones PBT - " . config('app.name') . ".{$extension}");
    }

    /**
     * Método que elimina un archivo del servidor y su registro de la base de datos (RutaModel)
    * @param int id Id del archivo del entrenamiento que se usará para eliminarlo del almacenamiento y de la base de datos
    * @return Response
    */
    public function destroyFile($id)
    {
        $response = $this->accompanimentRepository->destroyFile($id);

        if($response){
            toast('El Archivo se ha eliminado con éxito!','success')->autoClose(2000)->position('top-end');
            return back();
        }
        toast('El Archivo no se ha eliminado!','danger')->autoClose(2000)->position('top-end');
        return back();
    }

    public function changeInterlocutor(Accompaniment $accompaniment)
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

    public function updateInterlocutor(Request $request, Accompaniment $accompaniment)
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
            $response = $this->accompanimentRepository->updateInterlocutor($request, $accompaniment);
            if($response["isCompleted"]){
                return response()->json([
                    'data' => [
                        'state'   => 'success',
                        'url' => route('accompaniments.show', $response['data']->id),
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
