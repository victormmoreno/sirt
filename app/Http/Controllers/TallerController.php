<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EntrenamientoFormRequest;
use App\Models\{Entrenamiento, Idea, Nodo, EstadoIdea};
use App\Repositories\Repository\{EntrenamientoRepository, IdeaRepository};
use Illuminate\Support\Facades\{DB, Session, Validator};
use App\User;
use RealRashid\SweetAlert\Facades\Alert;
Use Carbon\Carbon;

class TallerController extends Controller
{

    public $entrenamientoRepository;
    public $ideaRepository;

    public function __construct(EntrenamientoRepository $entrenamientoRepository, IdeaRepository $ideaRepository)
    {
        $this->entrenamientoRepository = $entrenamientoRepository;
        $this->ideaRepository = $ideaRepository;
        // $this->middleware('auth', ['role_session:Infocenter|Activador|Dinamizador']);
    }

    /**
     * Modifica los entregables de un entrenamiento
     *
     * @param Request request Datos del formulario de las evidencias de un entrenamiento
     * @param int id Id del entrenamiento al que se le van a modificar los entregables
     * @return Response
     * @author Victor Manuel Moreno Vega
     */
    public function updateEvidencias(Request $request, $id)
    {
        $update = $this->entrenamientoRepository->updateEvidencias($request, $id);
        if ($update) {
            Alert::success('Modificación Exitosa!', 'Los entregables del taller de fortalecimiento se han modificado!')->showConfirmButton('Ok', '#3085d6');
            return redirect('taller');
        } else {
            Alert::error('Modificación Errónea!', 'Los entregables del taller de fortalecimiento no se han modificado!')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
    }

    /**
     * Retorna la vista donde el infocenter podrá subir las evidencias de lo entrenamientos (Por el id)
     * @param int id Id del entrenamientos del que se registrarán y subiran las evidencias
     * @return \Illuminate\Http\Response
     * @author Victor Manuel Moreno Vega
     */
    public function evidencias($id)
    {
        $taller = $this->entrenamientoRepository->getById($id);
        if (!request()->user()->can('show', $taller)) {
            alert('No autorizado', 'No puedes acceder a este taller de fortalecimiento', 'error')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        return view('talleres.form_evidencias', [
            'entrenamiento' => $taller,
        ]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @author Victor Manuel Moreno Vega
     */
    public function index()
    {
        if (!request()->user()->can('index', Entrenamiento::class)) {
            alert('No autorizado', 'No puedes acceder a los talleres de fortalecimiento', 'error')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        if (request()->ajax()) {
            $entrenamientos = $this->entrenamientoRepository->consultarEntrenamientosPorNodo(auth()->user()->infocenter->nodo_id);
            return datatables()->of($entrenamientos)
                ->addColumn('details', function ($data) {
                    $button = '<a class="btn light-blue m-b-xs modal-trigger" href="#modal1" onclick="detallesIdeasDelEntrenamiento(' . $data->id . ')">
                                    <i class="material-icons">info</i>
                                </a>';
                    return $button;
                })->addColumn('update_state', function ($data) {
                    $delete = '<a class="btn red lighten-3 m-b-xs" onclick="inhabilitarEntrenamientoPorId(' . $data->id . ', event)"><i class="material-icons">delete_sweep</i></a>';
                    return $delete;
                })->addColumn('evidencias', function ($data) {
                    $evidencias = '
                            <a class="btn blue-grey m-b-xs" href=' . route('entrenamientos.evidencias', $data->id) . '>
                                <i class="material-icons">library_books</i>
                            </a>';
                    return $evidencias;
                })->addColumn('edit', function ($data) {
                    $edit = '<a class="btn m-b-xs" disabled><i class="material-icons">edit</i></a>';
                    return $edit;
                })->rawColumns(['details', 'edit', 'update_state', 'evidencias'])->make(true);
        }
        return view('talleres.index', [
            'nodos' => Nodo::SelectNodo()->orderBy('entidades.nombre')->get()
        ]);
    }

    // Datatable para los entrenamientos por nodo, (Por parte del administrador)
    public function datatableEntrenamientosPorNodo(int $nodo)
    {
        $nodo_id = request()->user()->getNodoUser() == null ? $nodo : request()->user()->getNodoUser();
        $entrenamientos = $this->entrenamientoRepository->consultarEntrenamientosPorNodo($nodo_id);
        return datatables()->of($entrenamientos)
        ->addColumn('details', function ($data) {
            $button = '
            <a class="btn bg-info m-b-xs modal-trigger" href="#modal1" onclick="detallesIdeasDelEntrenamiento(' . $data->id . ')">
            <i class="material-icons">info</i>
            </a>
            ';
            return $button;
        })->addColumn('evidencias', function ($data) {
            $evidencias = '
            <a class="btn bg-secondary m-b-xs" href=' . route('taller.evidencias', $data->id) . '>
            <i class="material-icons">library_books</i>
            </a>
            ';
            return $evidencias;
        })->rawColumns(['details', 'edit', 'evidencias'])->make(true);
    }

    // Consulta las ideas que asistieron al entrenamiento
    public function details($id)
    {
        return response()->json($this->entrenamientoRepository->consultarIdeasDelEntrenamiento($id));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @author Victor Manuel Moreno Vega
     */
    public function create()
    {
        if (!request()->user()->can('create', Entrenamiento::class)) {
            alert('No autorizado', 'No puedes registrar talleres de fortalecimiento', 'error')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        $now = Carbon::now()->isoFormat('YYYY');
        $ideas = $this->ideaRepository->consultarIdeasDeProyecto()->where('nodo_id', auth()->user()->articulador->nodo_id)->whereYear('created_at', $now)->whereHas('estadoIdea',
        function ($query){
            $query->whereIn('nombre', [EstadoIdea::IsRegistro(), EstadoIdea::IsPostulado()]);
        })->get();
        return view('talleres.create', ['ideas' => $ideas]);
    }

    /**
     * Cambiar el estado de la ideas de proyecto que están asociadas a un entrenamiento e inhabilitado este
     * @param int id Id del entrenamiento que se va a inhabilitar
     * @param string estado El estado a que se le cambiarán el estado a las ideas de proyecto
     * @return Response\Ajax
     * @author Victor Manuel Moreno Vega
     */
    public function inhabilitarEntrenamiento($id, $estado)
    {
        if (request()->ajax()) {
            if (Session::get('login_role') == User::IsInfocenter()) {
                $ideasDelEntrenamiento = $this->entrenamientoRepository->consultarIdeasDelEntrenamiento($id);
                $ideasEnComite = "";
                foreach ($ideasDelEntrenamiento as $key => $value) {
                    $v = $this->ideaRepository->consultarIdeaEnComite($value->id);
                    if ($v != "") {
                        if ($key != 0) {
                            $ideasEnComite = $ideasEnComite . ', ' . $v->codigo_idea;
                        } else {
                            $ideasEnComite = $v->codigo_idea;
                        }
                    }
                }
                if ($ideasEnComite != "") {
                    return response()->json([
                        'ideas' => $ideasEnComite,
                        'update' => "1"
                    ]);
                } else {
                    /**
                     * Función que cambia el estado de las ideas de proyecto que están asociadas al entrenamiento
                     */
                    $updateEntrenamiento = "";
                    DB::beginTransaction();
                    try {
                        // foreach ($ideasDelEntrenamiento as $key => $value) {
                        //     $this->ideaRepository->updateEstadoIdea($value->id, $estado);
                        // }
                        $archivosEntrenamiento = $this->entrenamientoRepository->consultarArchivosDeUnEntrenamiento($id);
                        foreach ($archivosEntrenamiento as $key => $value) {
                            $this->entrenamientoRepository->deleteArchivoEntrenamientoPorEntrenamiento($value->id);
                        }
                        $this->entrenamientoRepository->deleteEntrenamientoIdea($id);
                        $this->entrenamientoRepository->deleteEntrenamiento($id);
                        DB::commit();
                        $updateEntrenamiento = "true";
                    } catch (\Exception $e) {
                        DB::rollback();
                        $updateEntrenamiento = "false";
                    }
                    return response()->json([
                        'update' => $updateEntrenamiento,
                        'estado' => $estado
                    ]);
                }
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @author Victor Manuel Moreno Vega
     */
    public function store(Request $request)
    {

        $req = new EntrenamientoFormRequest;
        $validator = Validator::make($request->all(), $req->rules(), $req->messages());
        if ($validator->fails()) {
            return response()->json([
                'state'   => 'error_form',
                'errors' => $validator->errors(),
            ]);
        } else {
            $result = $this->entrenamientoRepository->storeEntrenamiento($request);
            if ($result['state']) {
                return response()->json([
                    'state' => 'registro',
                    'title' => $result['title'],
                    'msg' => $result['msg'],
                    'type' => $result['type'],
                    'url' => route('taller'),
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
    }

}
