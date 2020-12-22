<?php

namespace App\Http\Controllers;


use Alert;

use App\Http\Requests\{IdeaFormRequest, EmpresaFormRequest};
use App\Models\{Departamento, EstadoIdea, Idea, Entidad, Sector, TamanhoEmpresa, TipoEmpresa};
use App\Repositories\Repository\IdeaRepository;
use App\User;
use Illuminate\Support\Facades\{Session, Validator};
use Illuminate\Http\Request;
use App\Exports\Idea\IdeasExport;

class IdeaController extends Controller
{
    public $ideaRepository;

    public function __construct(IdeaRepository $ideaRepository)
    {
        $this->ideaRepository = $ideaRepository;
        $this->middleware('auth');
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
        if (Session::get('login_role') == User::IsTalento()) {
            return view('ideas.talento.create', [
                'nodos' => $nodos,
                'departamentos' => Departamento::all(),
                'sectores' => Sector::all(),
                'tamanhos' => TamanhoEmpresa::all(),
                'tipos' => TipoEmpresa::all()
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $req = new IdeaFormRequest;
        $validator = Validator::make($request->all(), $req->rules(), $req->messages());
        if ($validator->fails()) {
            return response()->json([
                'state'   => 'error_form',
                'errors' => $validator->errors(),
            ]);
        } else {
            if ($request->bandera_empresa == 1) {
                $req2 = new EmpresaFormRequest;
                $validarEmpresa = Validator::make($request->all(), $req2->rules(), $req2->messages());
                if ($validarEmpresa->fails()) {
                    return response()->json([
                        'state'   => 'error_form',
                        'errors' => $validarEmpresa->errors(),
                    ]);
                }
            }
            $result = $this->ideaRepository->Store($request);;
            if ($result) {
                return response()->json(['state' => 'registro']);
            } else {
                return response()->json(['state' => 'no_registro']);
            }
        }
    }


    //metodo index para mostrar el listado de ideas
    public function index(Request $request)
    {
        $estadosIdeas = EstadoIdea::orderBy('id')->pluck('nombre', 'id');

        if (\Session::get('login_role') == User::IsInfocenter()) {
            return view('ideas.infocenter.index', ['estadosIdeas' => $estadosIdeas]);
        } else if (\Session::get('login_role') == User::IsTalento()) {
            return view('ideas.talento.index');
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
