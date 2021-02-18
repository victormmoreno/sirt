<?php

namespace App\Http\Controllers;


use Alert;

use App\Http\Requests\{EmpresaFormRequest, IdeaFormRequest};
use App\Models\{Departamento, EstadoIdea, Idea, Entidad, Sector, TamanhoEmpresa, TipoEmpresa};
use App\Repositories\Repository\{IdeaRepository, EmpresaRepository};
use App\User;
use Illuminate\Support\Facades\{Session, Validator};
use Illuminate\Http\Request;
use App\Exports\Idea\IdeasExport;

class IdeaController extends Controller
{
    public $ideaRepository;

    public function __construct(IdeaRepository $ideaRepository, EmpresaRepository $empresaRepository)
    {
        $this->ideaRepository = $ideaRepository;
        $this->empresaRepository = $empresaRepository;
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
        if ($request->input('txtidea_empresa') == 1) {
            // Idea con empresa
            $empresa = $this->empresaRepository->consultarDetallesDeUnaEmpresa($request->input('txtnit'), 'nit')->first();
            if ($empresa == null) {
                $req_empresa = new EmpresaFormRequest;
                $validar_empresa = Validator::make($request->all(), $req_empresa->rules(), $req_empresa->messages());
                if ($validar_empresa->fails()) {
                return response()->json([
                    'state'   => 'error_form',
                    'errors' => $validar_empresa->errors(),
                ]);
                }
            }
        }

        $req = new IdeaFormRequest;
        $validator = Validator::make($request->all(), $req->rules(), $req->messages());
        if ($validator->fails()) {
            return response()->json([
                'state'   => 'error_form',
                'errors' => $validator->errors(),
            ]);
        } else {
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
        } else if (\Session::get('login_role') == User::IsArticulador()) {
            return view('ideas.articulador.index');
        } else {
            $nodos = Entidad::has('nodo')->with('nodo')->get()->pluck('nombre', 'nodo.id');
            return view('ideas.index', ['nodos' => $nodos, 'estadosIdeas' => $estadosIdeas]);
        }
    }

    public function datatableIdeasTalento(Request $request)
    {
        // $ideas = Idea::with(['estadoIdea']);
        if (Session::get('login_role') == User::IsTalento()) {
            $ideas = $this->ideaRepository->consultarIdeasDeProyecto()->where('talento_id', auth()->user()->talento->id)->get();
        } else {
            $ideas = $this->ideaRepository->consultarIdeasDeProyecto()->where('nodo_id', auth()->user()->gestor->nodo_id)
            ->whereHas('estadoIdea', 
            function ($query){
                $query->where('nombre', EstadoIdea::IsEnviado());
            }
            )->get();
        }
        return $this->datatableIdeas($request, $ideas);
    }

    private function datatableIdeas($request, $ideas)
    {
        return datatables()->of($ideas)
        ->editColumn('estado', function ($data) {
            return $data->estadoIdea->nombre;
        })->editColumn('nombre_talento', function ($data) {
            return $data->talento->user->nombres . " " . $data->talento->user->apellidos;
        })->editColumn('nodo', function ($data) {
            return $data->nodo->entidad->nombre;
        })->addColumn('info', function ($data) {
            $info = '<a class="btn light-blue m-b-xs modal-trigger" href='.route('idea.detalle', $data->id).'>
            <i class="material-icons">info</i>
            </a>';
                return $info;
        })->addColumn('edit', function ($data) {
            $edit = '<a class="btn light-blue m-b-xs modal-trigger" href='.route('idea.edit', $data->id).'>
            <i class="material-icons">edit</i>
            </a>';
                return $edit;
        })->rawColumns(['info', 'edit'])->make(true);
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
        // dd($idea->talento->id);
        $this->authorize('update', $idea);
        $nodos = $this->ideaRepository->getSelectNodo();
        return view('ideas.talento.edit', ['idea' => $idea, 
        'nodos' => $nodos,
        'departamentos' => Departamento::all(),
        'sectores' => Sector::all(),
        'tamanhos' => TamanhoEmpresa::all(),
        'tipos' => TipoEmpresa::all()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        $idea = $this->ideaRepository->findByid($id);
        $this->authorize('update', $idea);

        if ($request->input('txtidea_empresa') == 1) {
            // Idea con empresa
            $empresa = $this->empresaRepository->consultarDetallesDeUnaEmpresa($request->input('txtnit'), 'nit')->first();
            if ($empresa == null) {
                $req_empresa = new EmpresaFormRequest;
                $validar_empresa = Validator::make($request->all(), $req_empresa->rules(), $req_empresa->messages());
                if ($validar_empresa->fails()) {
                return response()->json([
                    'state'   => 'error_form',
                    'errors' => $validar_empresa->errors(),
                ]);
                }
            }
        }

        $req = new IdeaFormRequest;
        $validator = Validator::make($request->all(), $req->rules(), $req->messages());
        if ($validator->fails()) {
            return response()->json([
                'state'   => 'error_form',
                'errors' => $validator->errors(),
            ]);
        } else {
            $result = $this->ideaRepository->Update($request, $idea);
            if ($result) {
                return response()->json(['state' => 'update']);
            } else {
                return response()->json(['state' => 'no_update']);
            }
        }
    }

    /**
     * Envia la idea al nodo donde se registró
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id Id de la idea
     * @return \Illuminate\Http\Response
     * @author dum
     **/
    public function enviarIdeaAlNodo(Request $request, $id)
    {
        $idea = $this->ideaRepository->findByid($id);
        $this->authorize('update', $idea);
        $update = $this->ideaRepository->enviarIdeaAlNodo($request, $idea);
        if ($update) {
            Alert::success('Envio exitoso!', 'La idea se ha enviado al nodo exitosamente!')->showConfirmButton('Ok', '#3085d6');
            return redirect('idea');
        } else {
            Alert::error('Envio erróneo!', 'La idea no se ha enviado al nodo!')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
    }

    public function detalle($id)
    {
        $idea = $this->ideaRepository->findByid($id);
        // dd($idea->empresa_relation);
        $this->authorize('show', $idea);
        if (Session::get('login_role') == User::IsTalento()) {
            return view('ideas.talento.show', ['idea' => $idea]);
        } else {
            return view('ideas.articulador.show', ['idea' => $idea]);
        }
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
