<?php

namespace App\Http\Controllers;


use Alert;

use App\Http\Requests\IdeaFormRequest;
use App\Models\{EstadoIdea, Idea, Entidad};
use App\Repositories\Repository\IdeaRepository;
use App\User;
use Illuminate\Http\Request;
use App\Exports\Idea\IdeasExport;

class IdeaController extends Controller
{
    public $ideaRepository;

    public function __construct(IdeaRepository $ideaRepository)
    {
        $this->ideaRepository = $ideaRepository;
        $this->middleware('auth', ['except' => ['create', 'store']]);
    }

    /*========================================================================================================
    =            metodo para mostrar el registro de ideas en la pagina principal de la aplicacion            =
    ========================================================================================================*/

    /**
     * Display a create of the resource.
     * @author devjul
     */
    public function create()
    {
        $nodos = $this->ideaRepository->getSelectNodo();

        return view('ideas.create', ['nodos' => $nodos,]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(IdeaFormRequest $request)
    {
        $idea = $this->ideaRepository->Store($request);
        if ($idea != null) {
            return redirect()->back()->withSuccess('success');
        }
        return redirect()->route('idea.create');
    }


    //metodo index para mostrar el listado de ideas
    public function index(Request $request)
    {
        $this->authorize('view', Idea::class);

        switch (\Session::get('login_role')) {
            case User::IsAdministrador():
                $nodo = $request->filter_nodo;
                break;
            case User::IsDinamizador():
                $nodo = auth()->user()->dinamizador->nodo_id;
                break;
            case User::IsGestor():
                $nodo = auth()->user()->gestor->nodo_id;
                break;
            case User::IsInfocenter():
                $nodo = auth()->user()->infocenter->nodo_id;
                break;
            default:
                return abort('403');
                break;
        }

        if (request()->ajax()) {
            $ideas = [];
            if (!empty($request->filter_year) && !empty($request->filter_state) && !empty($request->filter_vieneConvocatoria)) {

                $ideas = Idea::with(['estadoIdea'])->createdAt($request->filter_year)
                    ->vieneConvocatoria($request->filter_vieneConvocatoria)
                    ->state($request->filter_state)
                    ->convocatoria($request->filter_convocatoria)
                    ->nodo($nodo)
                    ->orderBy('created_at', 'desc')
                    ->get();
            }

            return datatables()->of($ideas)
                ->editColumn('estado', function ($data) {
                    return $data->estadoIdea->nombre;
                })->editColumn('persona', function ($data) {
                    return "{$data->nombres_contacto} {$data->apellidos_contacto}";
                })->editColumn('created_at', function ($data) {
                    return isset($data->created_at) ? $data->created_at->isoFormat('DD/MM/YYYY') : 'No Registra';
                })

                ->addColumn('details', function ($data) {
                    $button = '
                    <a class="btn light-blue m-b-xs modal-trigger" href="#modal1" onclick="detallesIdeaPorId(' . $data->id . ')">
                        <i class="material-icons">info</i>
                    </a>
                    ';
                    return $button;
                })->addColumn('soft_delete', function ($data) {
                    if (\Session::get('login_role') !== User::IsInfocenter()) {
                        return '';
                    } else {
                        if ($data->estadoIdea->nombre != EstadoIdea::IsInscrito()) {
                            $delete = '<a class="btn red lighten-3 m-b-xs" disabled><i class="material-icons">delete_sweep</i></a>';
                        } else {
                            $delete = '<a class="btn red lighten-3 m-b-xs" onclick="cambiarEstadoIdeaDeProyecto(' . $data->id . ', \'Inhabilitado\')"><i class="material-icons">delete_sweep</i></a>';
                        }
                        return $delete;
                    }
                })->addColumn('dont_apply', function ($data) {
                    if ($data->estadoIdea->nombre != EstadoIdea::IsInscrito()) {
                        $notapply = '<a class="btn brown lighten-3 m-b-xs" disabled><i class="material-icons">thumb_down</i></a>';
                    } else {
                        $notapply = '<a class="btn brown lighten-3 m-b-xs" onclick="cambiarEstadoIdeaDeProyecto(' . $data->id . ', \'No Aplica\')"><i class="material-icons">thumb_down</i></a>';
                    }
                    return $notapply;
                })->addColumn('edit', function ($data) {
                    $edit = '<a href="' . route("idea.edit", $data->id) . '" class="btn m-b-xs"><i class="material-icons">edit</i></a>';
                    return $edit;
                })->rawColumns(['created_at', 'estado', 'persona', 'details', 'edit', 'soft_delete', 'dont_apply'])->make(true);
        }
        $estadosIdeas = EstadoIdea::orderBy('id')->pluck('nombre', 'id');

        if (\Session::get('login_role') == User::IsInfocenter()) {

            return view('ideas.infocenter.index', ['estadosIdeas' => $estadosIdeas]);
        } else {
            $nodos = Entidad::has('nodo')->with('nodo')->get()->pluck('nombre', 'nodo.id');

            return view('ideas.index', ['nodos' => $nodos, 'estadosIdeas' => $estadosIdeas]);
        }
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $idea = $this->ideaRepository->findByid($id);
        $this->authorize('update', $idea);
        $nodos = $this->ideaRepository->getSelectNodo();
        return view('ideas.infocenter.edit', ['idea' => $idea, 'nodos' => $nodos]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(IdeaFormRequest $request, $id)
    {
        $idea = $this->ideaRepository->findByid($id);
        $this->authorize('update', $idea);
        $updateIdea = $this->ideaRepository->Update($request, $idea);
        if ($updateIdea == true) {
            Alert::success("La Idea se ha modificado.", 'Modificación Exitosa', "success");
        } else {
            Alert::error("La Idea no se ha modificado.", 'Modificación Errónea', "error");
        }

        return redirect()->route('idea.index');
    }

    public function detallesIdeas($id)
    {
        $idea = Idea::ConsultarIdeaId($id)->first();
        $this->authorize('show', $idea);
        return response()->json([
            'detalles' => $idea
        ]);
    }

    public function export(Request $request, $extension = 'xlsx')
    {
        $this->authorize('view', Idea::class);
        switch (\Session::get('login_role')) {
            case User::IsAdministrador():
                $nodo = $request->filter_nodo;
                break;
            case User::IsDinamizador():
                $nodo = auth()->user()->dinamizador->nodo_id;
                break;
            case User::IsGestor():
                $nodo = auth()->user()->gestor->nodo_id;
                break;
            case User::IsInfocenter():
                $nodo = auth()->user()->infocenter->nodo_id;
                break;
            default:
                return abort('403');
                break;
        }

        $ideas = Idea::with(['estadoIdea'])->createdAt($request->filter_year)
            ->vieneConvocatoria($request->filter_vieneConvocatoria)
            ->state($request->filter_state)
            ->convocatoria($request->filter_convocatoria)
            ->nodo($nodo)
            ->orderBy('created_at', 'desc')
            ->get();

        return (new IdeasExport($ideas))->download("ideas - " . config('app.name') . ".{$extension}");
    }

    /**
     * Cambia el estado de idea a una idea de proyecto
     * @param int id Id de la idea que se le va a cambiar el estado
     * @param string estado nombre del estado al que se va a cambiar la idea
     * @return void
     */
    public function updateEstadoIdea($id, $estado)
    {
        $idea = Idea::ConsultarIdeaId($id)->first();
        $this->authorize('update', $idea);
        if ($idea->estado_idea == EstadoIdea::IsInscrito()) {
            $this->ideaRepository->updateEstadoIdea($id, $estado);
            return response()->json([
                'route' => route('idea.index'),
            ]);
        }
    }
}
