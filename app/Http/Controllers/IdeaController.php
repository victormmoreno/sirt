<?php

namespace App\Http\Controllers;

use App\Http\Requests\{EmpresaFormRequest, IdeaFormRequest};
use App\Models\{Departamento, EstadoIdea, Idea, Comite, Entidad, Sector, TamanhoEmpresa, TipoEmpresa, Nodo};
use App\Repositories\Repository\{IdeaRepository, EmpresaRepository};
use App\User;
use Illuminate\Support\Facades\{Session, Validator};
use Illuminate\Http\Request;
use App\Exports\Idea\IdeasExport;
use RealRashid\SweetAlert\Facades\Alert;

class IdeaController extends Controller
{
    public $ideaRepository;
    public $empresaRepository;

    public function __construct(IdeaRepository $ideaRepository, EmpresaRepository $empresaRepository)
    {
        $this->ideaRepository = $ideaRepository;
        $this->empresaRepository = $empresaRepository;
        $this->middleware('auth');
    }

    /**
     * Retorna los ids de los nodos en un array
     *
     * @param $request
     * @param bool $bandera Indica si se seleccionaron todos los nodos
     * @return array
     * @author dum
     */
    public function retornarSelectedNodos($request, $bandera)
    {
        $list_nodos = [];
        if ($bandera) {
            $nodos = Nodo::SelectNodo()->get();
            foreach ($nodos as $key => $nodo) {
                $list_nodos[] = $nodo->id;
            }
        } else {
            $list_nodos = $request->filter_nodo;
        }
        return $list_nodos;
    }

    /**
     * Verifica que se haya seleccionado la opción de "Todos" en el select de nodos
     *
     * @param $request
     * @return bool
     * @author dum
     */
    public function verificarSelectAllNodos($request)
    {
        if (isset($request->filter_nodo)) {
            foreach ($request->filter_nodo as $key => $select) {
                if ($select == 'all') {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Retorna el id del nodo para realizar consultas sobre las ideas de proyeco
     *
     * @param $request
     * @return mixed
     * @author dum
     */
    public function getIdNodoForIdeas($request)
    {
        $nodo = null;
        if (session()->get('login_role') == User::IsActivador() || session()->get('login_role') == User::IsAdministrador()) {
            $bandera = $this->verificarSelectAllNodos($request);
            $nodo = $this->retornarSelectedNodos($request, $bandera);
        } else {
            $nodo = [request()->user()->getNodoUser()];
        }
        return $nodo;
    }

    /**
     * Display a create of the resource.
     * @author devjul
     */
    public function create()
    {
        if(!request()->user()->can('create', Idea::class)) {
            alert('No autorizado', 'No tienes permisos para registrar ideas de proyecto', 'error')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        $nodos = $this->ideaRepository->getSelectNodo();
        if (Session::get('login_role') == User::IsTalento()) {
            return view('ideas.create', [
                'nodos' => $nodos,
                'departamentos' => Departamento::all(),
                'sectores' => Sector::all(),
                'tamanhos' => TamanhoEmpresa::all(),
                'tipos' => TipoEmpresa::all()
            ]);
        }
    }

    /**
     * Formulario para asginar la idea de proyecto a un experto
     *
     * @param int $id Id de la idea de proyecto
     * @return Response
     * @author dum
     **/
    public function asignar(Request $request)
    {
        $idea = Idea::find($request->idea);

        if(!request()->user()->can('asignar', $idea)) {
            alert('No autorizado', 'No tienes permisos para asignar esta idea de proyecto a un experto', 'error')->showConfirmButton('Ok', '#3085d6');
            return back();
        }

        $validator = Validator::make($request->all(), [
            'txtgestor_id' => 'required',
        ], [
            'txtgestor_id.required' => 'El experto es obligatorio.'
        ]);

        if ($validator->fails()) {
            return redirect()->route('idea.asignar', $request->idea)
            ->withErrors($validator)
            ->withInput();
        }
        $asignacion = $this->ideaRepository->asginarIdeaExperto($request, $idea);
        alert($asignacion['title'], $asignacion['msg'], $asignacion['type'])->showConfirmButton('Ok', '#3085d6');
        if ($asignacion['state']) {
            return redirect()->route('idea.detalle', $request->idea);
        } else {
          return back()->withInput();
        }
    }

    /**
     * Formulario para reasignar una idea de nodo
     *
     * @param int $id Id de la idea de proyecto
     * @return Response
     * @author dum
     **/
    public function reasignar_nodo(int $id)
    {
        $idea = Idea::find($id);
        if ($idea->nodo->id == auth()->user()->articulador->nodo_id) {
            return view('ideas.articulador.reasignar', [
                'nodos' => $this->ideaRepository->getSelectNodo(),
                'idea' => $idea
            ]);
        } else {
            Alert::error('Error!', 'Esta idea no pertenece a tu nodo!')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
    }

    public function updateNodoIdea(Request $request, $id)
    {
        $update = $this->ideaRepository->update_nodo($request);

        if ($update) {
            alert()->success('La idea de proyecto ha cambiado de nodo satisfactoriamente','Actualización exitosa.')->showConfirmButton('Ok', '#3085d6');
            return redirect()->route('idea.index');
        } else {
          alert()->error('La idea no ha cambiado de nodo','Actualización errónea.')->showConfirmButton('Ok', '#3085d6');
          return back()->withInput();
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
        $empresa = null;
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
            $req = new IdeaFormRequest($request->input('txtopcionRegistro'), $empresa);
            $validator = Validator::make($request->all(), $req->rules(), $req->messages());
            if ($validator->fails()) {
                return response()->json([
                    'state'   => 'error_form',
                    'errors' => $validator->errors(),
                ]);
            }
            $result = $this->ideaRepository->Store($request);
        } else {
            $req = new IdeaFormRequest($request->input('txtopcionRegistro'), $empresa);
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
        if(!request()->user()->can('index', Idea::class)) {
            alert('No autorizado', 'No tienes permisos para ver ideas de proyecto', 'error')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        $estadosIdeas = EstadoIdea::orderBy('id')->whereNotIn('nombre', [
            EstadoIdea::IsNoConvocado(),
            EstadoIdea::IsInhabilitado(),
            EstadoIdea::IsRechazadoArticulador(),
            EstadoIdea::IsNoAplica()
        ])->pluck('nombre', 'id');

        $nodos = Entidad::has('nodo')->with('nodo')->orderBy('entidades.nombre')->get()->pluck('nombre', 'nodo.id');
        return view('ideas.index', [
            'nodos' => $nodos,
            'estadosIdeas' => $estadosIdeas
        ]);
    }

    public function aceptarPostulacionIdea(Request $request, $id)
    {
        $idea = $this->ideaRepository->findByid($id);
        $this->authorize('show', $idea);
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
        if (session()->get('login_role') == request()->user()->IsTalento()) {
            $ideas = $this->ideaRepository->consultarIdeasDeProyecto()->where('user_id', request()->user()->id)
            ->whereHas('estadoIdea',
            function ($query){
                $query->whereNotIn('nombre', [EstadoIdea::IsRechazadoArticulador()]);
            })->get();
        } else {
            $nodos = $this->getIdNodoForIdeas($request);
            $ideas = [];
            if (!empty($request->filter_year) && !empty($request->filter_state) && !empty($request->filter_vieneConvocatoria)) {
                $ideas = Idea::with(['estadoIdea'])->createdAt($request->filter_year)
                ->vieneConvocatoria($request->filter_vieneConvocatoria)
                ->state($request->filter_state)
                ->convocatoria($request->filter_convocatoria)
                ->nodo($nodos)
                ->orderBy('created_at', 'desc')
                ->get();
            }

        }
        return $this->datatableIdeas($ideas);
    }

    /**
     * Duplica la idea de proyecto que aplicará para mas de un TRL
     *
     * @param int $id Id de la idea de proyecto
     * @param int $comite Id del comité
     * @param $bandera Pra saber si se duplicará antes o despues de asignar la idea
     * @return Response
     * @author dum
     **/
    public function deviarIdea($id, $comite, $bandera = null)
    {
        $idea = $this->ideaRepository->findByid($id);
        $comite_model = Comite::findOrFail($comite);
        if(!request()->user()->can('derivar_idea', [$comite_model, $idea])) {
            alert('No autorizado', 'No tienes permisos para duplicar idea de proyecto', 'error')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        $resultado = $this->ideaRepository->derivarIdea($idea, $comite);
        alert($resultado['title'], $resultado['msg'], $resultado['type'])->showConfirmButton('Ok', '#3085d6');
        if ($resultado['state']) {
            if ($bandera != 1) {
                return back();
            } else {
                return redirect()->route('comite.cambiar.asignacion', ['idea' => $resultado['idea']->id, 'comite' => $comite]);
            }
        } else {
            alert('Error', 'No se ha podido realizar esta acción: '. $resultado['msg'], 'error');
            return back();
        }
    }

    /**
     * Duplica la idea de proyecto por parte del talento
     *
     * @param Request $request
     * @param int $id Id de la idea de proyecto
     * @return Response
     * @author dum
     **/
    public function duplicarIdea(Request $request, $id)
    {
        $idea = $this->ideaRepository->findByid($id);
        if(!request()->user()->can('duplicar', $idea)) {
            alert('No autorizado', 'No tienes permisos para duplicar idea de proyecto', 'error')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        $resultado = $this->ideaRepository->duplicarIdea($idea);
        alert($resultado['title'], $resultado['msg'], $resultado['type'])->showConfirmButton('Ok', '#3085d6');;
        if ($resultado['state']) {
            return redirect()->route('idea.detalle', ['id' => $resultado['id']]);
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
        if(!request()->user()->can('inhabilitar', $idea)) {
            alert('No autorizado', 'No tienes permisos para inhabilitar idea de proyecto', 'error')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
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
        $ideas = $this->ideaRepository->consultarIdeasDeProyecto()->where('user_id', auth()->user()->id)
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
            if (isset($data->user->nombres)) {
                return "{$data->user->nombres} {$data->user->apellidos}";
            } else {
                return "No hay información disponible";
            }
        })->editColumn('created_at', function ($data) {
            return isset($data->created_at) ? $data->created_at->isoFormat('DD/MM/YYYY') : 'No Registra';
        })->editColumn('correo_contacto', function ($data) {
            if (isset($data->user->email)) {
                return "{$data->user->email}";
            } else {
                return "No hay información disponible";
            }
        })->editColumn('telefono_contacto', function ($data) {
            if (isset($data->user->celular)) {
                return "{$data->user->celular}";
            } else {
                return "No hay información disponible";
            }
        })->editColumn('estado', function ($data) {
            return $data->estadoIdea->nombre;
        })->editColumn('nombre_talento', function ($data) {
            if (isset($data->user->nombres)) {
                return $data->user->nombres . " " . $data->user->apellidos;
            } else {
                return "No hay información disponible";
            }
        })->editColumn('nodo', function ($data) {
            return $data->nodo->entidad->nombre;
        })->addColumn('info', function ($data) {
            $info = '<a class="btn m-b-xs bg-secondary" href='.route('idea.detalle', $data->id).'>
            <i class="material-icons">search</i>
            </a>';
                return $info;
        })->addColumn('edit', function ($data) {
            $editable = !request()->user()->can('update', $data) ? 'disabled' : '';
            $edit = '<a class="btn m-b-xs bg-warning" '.$editable.' href='.route('idea.edit', $data->id).'>
            <i class="material-icons">edit</i>
            </a>';
            return $edit;
        })->addColumn('details', function ($data) {
            $button = '
            <a class="btn m-b-xs modal-trigger bg-secondary" href="#modal1" onclick="detallesIdeaPorId(' . $data->id . ')">
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
        if(!request()->user()->can('update', $idea)) {
            alert('No autorizado', 'No tienes permisos para cambiar la información de esta idea de proyecto', 'error')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        $nodos = $this->ideaRepository->getSelectNodo();
        return view('ideas.edit', ['idea' => $idea,
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
        $empresa = null;
        $idea = $this->ideaRepository->findByid($id);
        if(!request()->user()->can('update', $idea)) {
            alert('No autorizado', 'No tienes permisos para cambiar la información de esta idea de proyecto', 'error')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
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
        $req = new IdeaFormRequest($request->input('txtopcionRegistro'), $empresa);
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
            if(!request()->user()->can('postularIdea', $idea)) {
                alert('No autorizado', 'No tienes permisos para postular esta idea de proyecto', 'error')->showConfirmButton('Ok', '#3085d6');
                return response()->json([
                    'state' => 'no_update',
                    'title' => 'No autorizado',
                    'msg' => 'No tienes permisos para postular esta idea de proyecto',
                    'type' =>'error'
                ]);
            }
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
        if(!request()->user()->can('postularIdea', $idea)) {
            alert('No autorizado', 'No tienes permisos para postular esta idea de proyecto', 'error')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
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
        if(!request()->user()->can('show', $idea)) {
            alert('No autorizado', 'No tienes permisos para ver la información de esta idea de proyecto', 'error')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        $estadosIdea = EstadoIdea::all();
        return view('ideas.show', [
            'idea' => $idea,
            'estadosIdea' => $estadosIdea
        ]);
    }

    public function export_registradas($nodo, $desde, $hasta)
    {
        $ideas = Idea::with(['estadoIdea'])->where('ideas.nodo_id', $nodo)->whereBetween('ideas.created_at', [$desde, $hasta])->orderBy('created_at', 'desc')->get();
        return (new IdeasExport($ideas))->download("Ideas - " . config('app.name') . ".xlsx");
    }

    public function export(Request $request, $extension = 'xlsx')
    {
        if(!request()->user()->can('export', Idea::class)) {
            alert('No autorizado', 'No puedes descargar información de las ideas de proyecto', 'error')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        $nodos = $this->getIdNodoForIdeas($request);

        $ideas = Idea::with(['estadoIdea'])->createdAt($request->filter_year)
            ->vieneConvocatoria($request->filter_vieneConvocatoria)
            ->state($request->filter_state)
            ->convocatoria($request->filter_convocatoria)
            ->nodo($nodos)
            ->orderBy('created_at', 'desc')
            ->get();

        return (new IdeasExport($ideas))->download("ideas - " . config('app.name') . ".{$extension}");
    }

    public function show($id)
    {
        $idea = Idea::select('id', 'codigo_idea','nombre_proyecto','objetivo', 'alcance',  'user_id', 'sede_id')->with([
            'user' => function($query){
                $query->select('id','documento', 'nombres', 'apellidos', 'email', 'celular');
            },
            'sede' => function($query){
                $query->select('id', 'nombre_sede', 'direccion', 'empresa_id');
            },
            'sede.empresa' => function($query){
                $query->select('id', 'nombre', 'nit');
            }
        ])->where('id', $id)->first();
        $user = null;
        $sede = null;


        if($idea->has('user') &&isset($idea->user))
        {
            $user = $idea->user;
        }
        if($idea->has('sede.empresa') && isset($idea->sede->empresa))
        {
            $sede = $idea->sede;
        }

        return response()->json([
            'data' => [
                'idea' => $idea,
                'talento' => $user,
                'sede' => $sede,
            ],
        ]);

    }

    /**
     * Consultar ideas sin asignar
     *
     * @param $nodo Id del nodo
     * @param $user Id del usuario
     * @return Response\Json
     * @author dum
     **/
    public function consultarIdeasSinRegistro($nodo, $user = null)
    {
        // dd(Idea::ConsultarIdeasAprobadasEnComite($nodo, $user)->dd());
        $user = $user == "null" ? null : $user;
        return response()->json([
            'data' => [
                'ideas' => Idea::ConsultarIdeasAprobadasEnComite($nodo, $user)->get()
            ]
        ]);
    }

    /**
     * Consultar ideas registradas entre un rango de fechas
     *
     * @param $nodo Id del nodo
     * @param $desde Fecha desde
     * @param $hasta Fecha hasta
     * @return Response\Json
     * @author dum
     **/
    public function consultar_ideas_registradas($nodo, $desde, $hasta)
    {
        // dd(Idea::ConsultarIdeasAprobadasEnComite($nodo, $user)->dd());
        $nodo = $nodo == "null" ? null : $nodo;
        return response()->json([
            'data' => [
                'ideas' => Idea::with(['estadoIdea'])->where('ideas.nodo_id', $nodo)->whereBetween('ideas.created_at', [$desde, $hasta])->orderBy('created_at', 'desc')->get()
                // 'ideas' => Idea::ConsultarIdeasRegistradas($nodo, $desde, $hasta)->get()
            ]
        ]);
    }


    /**
     * Formulario para buscar una idea de proyecto
     *
     * @return Response
     * @author dum
     **/
    public function search()
    {
        if(!request()->user()->can('search', Idea::class)) {
            alert('No autorizado', 'No tienes permisos para buscar ideas de proyecto', 'error')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        return view('ideas.search');
    }

    /**
     * Busca una idea de proyecto según un criterio.
     *
     * @param Request $request
     * @return Response
     * @author dum
     **/
    public function search_idea(Request $request)
    {
        // $ideas = Idea::where('nit', 'like', '%'.$request->txtidea_search.'%')->get();
        $ideas = $this->ideaRepository->consultarIdeasRepository($request);
        $urls = [];
        foreach ($ideas as $idea) {
            // dd($idea->id);
            $urls[] = route('idea.detalle', $idea->id);
        }
        return response()->json([
            'ideas' => $ideas,
            'urls' => $urls,
            'state' => 'search'
        ]);
    }
}
