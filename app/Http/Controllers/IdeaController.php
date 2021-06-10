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
        // $nodos = $this->ideaRepository->getSelectNodoPrueba();
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
            $empresa = $this->empresaRepository->consultarEmpresaParams($request->input('txtnit'), 'nit')->first();
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

        if ($request->input('txtopcionRegistro') == "guardar") {
            $req = new IdeaFormRequest($request->input('txtopcionRegistro'));
            $validator = Validator::make($request->all(), $req->rules(), $req->messages());
            if ($validator->fails()) {
                return response()->json([
                    'state'   => 'error_form',
                    'errors' => $validator->errors(),
                ]);
            }
            $result = $this->ideaRepository->Store($request);
            // if ($result['state']) {
            //     return response()->json(['state' => 'registro', 'url' => route('idea.detalle', $result['idea']->id)]);
            // } else {
            //     return response()->json(['state' => 'no_registro']);
            // }
        } else {
            $req = new IdeaFormRequest($request->input('txtopcionRegistro'));
            $validator = Validator::make($request->all(), $req->rules(), $req->messages());
            if ($validator->fails()) {
                return response()->json([
                    'state'   => 'error_form',
                    'errors' => $validator->errors(),
                    'title' => 'Error',
                    'msg' => 'Estas ingresando mal los datos',
                    'type' => 'error'
                ]);
            }
            $result = $this->ideaRepository->storeAndPostular($request);
        }
        if ($result['state']) {
            return response()->json([
                'state' => 'registro', 
                'url' => route('idea.detalle', $result['idea']->id),
                'title' => $result['title'],
                'msg' => $result['msg'],
                'type' => $result['type']
                ]);
        } else {
            return response()->json([
                'state' => 'no_registro', 
                'title' => $result['title'],
                'msg' => $result['msg'],
                'type' => $result['type']
            ]);
        }
    }


    //metodo index para mostrar el listado de ideas
    public function index()
    {
        $estadosIdeas = EstadoIdea::orderBy('id')->whereNotIn('nombre', [
            EstadoIdea::IsNoConvocado(),
            EstadoIdea::IsInhabilitado(),
            EstadoIdea::IsNoAplica()
        ])->pluck('nombre', 'id');
        if (\Session::get('login_role') == User::IsInfocenter()) {
            return view('ideas.infocenter.index', ['estadosIdeas' => $estadosIdeas]);
        } else if (\Session::get('login_role') == User::IsTalento()) {
            return view('ideas.talento.index');
        } else if (\Session::get('login_role') == User::IsArticulador()) {
            return view('ideas.articulador.index', ['estadosIdeas' => $estadosIdeas]);
        } else {
            $nodos = Entidad::has('nodo')->with('nodo')->get()->pluck('nombre', 'nodo.id');
            $estadosIdeas = EstadoIdea::orderBy('id')->pluck('nombre', 'id');
            return view('ideas.index', ['nodos' => $nodos, 'estadosIdeas' => $estadosIdeas]);
        }

    }

    public function aceptarPostulacionIdea(Request $request, $id)
    {
        $idea = $this->ideaRepository->findByid($id);
        $this->authorize('show', $idea);
        // dd($id);
        $update = $this->ideaRepository->aceptarPostulacion($idea, $request);
        if ($update) {
            Alert::success('Postulación aceptada!', 'La postulación de la idea se ha aceptado en el nodo!')->showConfirmButton('Ok', '#3085d6');
            return redirect('idea');
        } else {
            Alert::error('Postulación errónea!', 'La postulación de la idea no se ha aceptado al nodo!')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
    }

    /**
     * Retorna el render de la vista con los datos de la consulta
     * 
     * @param $id Id de la idea de proyecto
     * @return Response
     * @author dum
     */
    public function abrirModalIdeas($id)
    {
        $idea = Idea::findOrFail($id);
        return response()->json([
            'view' => view('ideas.detalle', ['idea' => $idea])->render()
        ]);
    }

    public function detallesIdeas($id)
    {
        $idea = Idea::findOrFail($id);
        return response()->json([
            'detalles' => $idea
        ]);
    }

    /**
     * Rechaza la postulación de la idea de proyecto en el nodo
     * 
     * @param int $id Id de la idea de proyecto
     * @return Response
     * @author dum
     * 
     **/    
    public function rechazarPostulacionIdea(Request $request, $id)
    {
        $idea = $this->ideaRepository->findByid($id);
        $this->authorize('show', $idea);
        $update = $this->ideaRepository->rechazarPostulacion($idea, $request);
        if ($update) {
            Alert::success('Postulación rechazada!', 'La postulación de la idea se ha rechazado en el nodo, se le ha enviado una notificación al talento!')->showConfirmButton('Ok', '#3085d6');
            return redirect('idea');
        } else {
            Alert::error('Postulación errónea!', 'La postulación de la idea no se ha aceptado al nodo!')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
    }

    public function datatableFiltros(Request $request)
    {
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
            case User::IsArticulador():
                $nodo = auth()->user()->gestor->nodo_id;
                break;
            default:
                return abort('403');
                break;
        }
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
        return $this->datatableIdeas($ideas);
    }

    /**
     * Duplica la idea de proyecto que aplicará para mas de un TRL
     *
     * @param int $id Id de la idea de proyecto
     * @param int $comite Id del comité
     * @return Response
     * @author dum
     **/
    public function deviarIdea($id, $comite)
    {
        $idea = $this->ideaRepository->findByid($id);
        $resultado = $this->ideaRepository->derivarIdea($idea, $comite);
        alert($resultado['title'], $resultado['msg'], $resultado['type'])->showConfirmButton('Ok', '#3085d6');;
        return back();
    }

    /**
     * Duplica la idea de proyecto por parte del talento
     *
     * @param Request $request
     * @param int $id Id de la idea de proyecto
     * @return Response
     * @author dum
     **/
    public function duplicarIdeaRechazada(Request $request, $id)
    {
        $idea = $this->ideaRepository->findByid($id);
        $resultado = $this->ideaRepository->duplicarIdea($idea);
        alert($resultado['title'], $resultado['msg'], $resultado['type'])->showConfirmButton('Ok', '#3085d6');;
        if ($resultado['state']) {
            return redirect('idea');
        } else {
            return back();
        }
    }

    /**
     * Inhabilita una idea de proyecto
     *
     * @param Request $request
     * @param int $id Id de la idea de proyecto
     * @return Response
     * @author dum
     **/
    public function inhabilitarIdea(Request $request, $id)
    {
        $idea = $this->ideaRepository->findByid($id);
        $resultado = $this->ideaRepository->inhabilitarIdea($idea);
        alert($resultado['title'], $resultado['msg'], $resultado['type'])->showConfirmButton('Ok', '#3085d6');;
        if ($resultado['state']) {
            return redirect('idea');
        } else {
            return back();
        }
    }

    public function datatableIdeasTalento(Request $request)
    {
        $ideas = $this->ideaRepository->consultarIdeasDeProyecto()->where('talento_id', auth()->user()->talento->id)
        ->whereHas('estadoIdea', 
        function ($query){
            $query->whereNotIn('nombre', [EstadoIdea::IsRechazadoArticulador()]);
        })->get();
        return $this->datatableIdeas($ideas);
    }

    private function datatableIdeas($ideas)
    {
        return datatables()->of($ideas)
        ->editColumn('estado', function ($data) {
            return $data->estadoIdea->nombre;
        })->editColumn('persona', function ($data) {
            if (isset($data->talento->user->nombres)) {
                return "{$data->talento->user->nombres} {$data->talento->user->apellidos}";
            } else {
                return "{$data->nombres_contacto} {$data->apellidos_contacto}";
            }
        })->editColumn('created_at', function ($data) {
            return isset($data->created_at) ? $data->created_at->isoFormat('DD/MM/YYYY') : 'No Registra';
        })->editColumn('correo_contacto', function ($data) {
            if (isset($data->talento->user->email)) {
                return "{$data->talento->user->email}";
            } else {
                return "{$data->correo_contacto}";
            }
        })->editColumn('telefono_contacto', function ($data) {
            if (isset($data->talento->user->celular)) {
                return "{$data->talento->user->celular}";
            } else {
                return "{$data->telefono_contacto}";
            }
        })->editColumn('estado', function ($data) {
            return $data->estadoIdea->nombre;
        })->editColumn('nombre_talento', function ($data) {
            if (isset($data->talento->user->nombres)) {
                return $data->talento->user->nombres . " " . $data->talento->user->apellidos;
            } else {
                return "{$data->nombres_contacto} {$data->apellidos_contacto}";
            }
        })->editColumn('nodo', function ($data) {
            return $data->nodo->entidad->nombre;
        })->addColumn('info', function ($data) {
            $info = '<a class="btn m-b-xs modal-trigger" href='.route('idea.detalle', $data->id).'>
            <i class="material-icons">search</i>
            </a>';
                return $info;
        })->addColumn('edit', function ($data) {
            $edit = '<a class="btn m-b-xs modal-trigger" href='.route('idea.edit', $data->id).'>
            <i class="material-icons">edit</i>
            </a>';
                return $edit;
        })->addColumn('details', function ($data) {
            $button = '
            <a class="btn light-blue m-b-xs modal-trigger" href="#modal1" onclick="detallesIdeaPorId(' . $data->id . ')">
                <i class="material-icons">info</i>
            </a>
            ';
            return $button;
        })->addColumn('postular', function ($data) {
            if ($data->estadoIdea->nombre == EstadoIdea::IsRegistro()) {
                $button = '<form action='.route('idea.enviar', $data->id).' method="POST">
                '.method_field("PUT") .' '.csrf_field().'
                    <button class="btn light-blue m-b-xs" type="submit">
                        <i class="material-icons">assignment_turned_in</i>
                    </button>
                </form>
                ';
            } else {
                $button = '
                <button class="btn light-blue m-b-xs" disabled>
                        <i class="material-icons">assignment_turned_in</i>
                    </button>
                ';
            }
            return $button;
        })->rawColumns(['created_at', 'estado', 'details', 'edit', 'info', 'postular'])->make(true);
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
        // $nodos = $this->ideaRepository->getSelectNodoPrueba();
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
            $empresa = $this->empresaRepository->consultarEmpresaParams($request->input('txtnit'), 'nit')->first();
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
        $req = new IdeaFormRequest($request->input('txtopcionRegistro'));
        $validator = Validator::make($request->all(), $req->rules(), $req->messages());
        if ($validator->fails()) {
            return response()->json([
                'state'   => 'error_form',
                'errors' => $validator->errors(),
            ]);
        }

        if ($request->input('txtopcionRegistro') == "guardar") {
            $result = $this->ideaRepository->Update($request, $idea);
        } else {
            $result = $this->ideaRepository->updateAndPostular($request, $idea);
        }
        if ($result['state']) {
            return response()->json([
                'state' => 'update', 
                'url' => route('idea.detalle', $result['idea']->id),
                'title' => $result['title'],
                'msg' => $result['msg'],
                'type' => $result['type']
            ]);
        } else {
            return response()->json([
                'state' => 'no_update', 
                'title' => $result['title'],
                'msg' => $result['msg'],
                'type' => $result['type']
            ]);
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
        $update = $this->ideaRepository->enviarIdeaAlNodo($request, $idea);
        alert($update['title'], $update['msg'], $update['type'])->showConfirmButton('Ok', '#3085d6');
        if ($update['state']) {
            return redirect('idea');
        } else {
            return back();
        }
    }

    public function detalle($id)
    {
        $idea = $this->ideaRepository->findByid($id);
        // dd($idea->empresa_relation);
        $estadosIdea = EstadoIdea::all();
        $this->authorize('show', $idea);
        if (Session::get('login_role') == User::IsTalento()) {
            return view('ideas.talento.show', ['idea' => $idea, 'estadosIdea' => $estadosIdea]);
        } else {
            return view('ideas.articulador.show', ['idea' => $idea, 'estadosIdea' => $estadosIdea]);
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
            case User::IsArticulador():
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

    public function show($id)
    {
        $idea = Idea::select('id', 'codigo_idea','nombre_proyecto','objetivo', 'alcance',  'talento_id', 'sede_id')->with([
            'talento' => function($query){
                $query->select('id', 'user_id');
            },
            'talento.user' => function($query){
                $query->select('id','documento', 'nombres', 'apellidos', 'email', 'celular');
            },
            'sede' => function($query){
                $query->select('id', 'nombre_sede', 'direccion', 'empresa_id');
            },
            'sede.empresa' => function($query){
                $query->select('id', 'nombre', 'nit');
            }
        ])->where('id', $id)->first();
        $talento = null;
        $sede = null;
      

        if($idea->has('talento.user') &&isset($idea->talento->user))
        {
            $talento = $idea->talento;
        }
        if($idea->has('sede.empresa') && isset($idea->sede->empresa))
        {
            $sede = $idea->sede;
        }
        
        return response()->json([
            'data' => [
                'idea' => $idea,
                'talento' => $talento,
                'sede' => $sede,
            ],
        ]);

    }
}
