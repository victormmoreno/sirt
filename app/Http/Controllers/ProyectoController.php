<?php

namespace App\Http\Controllers;

use App\Models\{AreaConocimiento, Centro, GrupoInvestigacion, Idea, Nodo, Proyecto, Sublinea, Tecnoacademia, Actividad, Fase, Gestor, ArchivoArticulacionProyecto};
use App\Repositories\Repository\{EmpresaRepository, ProyectoRepository, UserRepository\GestorRepository};
use Illuminate\Support\{Str, Facades\Session, Facades\Validator};
use App\Http\Requests\{ProyectoFaseInicioFormRequest, ProyectoFaseCierreFormRequest};
use Illuminate\Http\{Request, Response};
use App\User;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Controllers\CostoController;
use App\Policies\IndicadorPolicy;
use Carbon\Carbon;

class ProyectoController extends Controller
{

    private $empresaRepository;
    private $proyectoRepository;
    private $gestorRepository;
    private $costoController;

    public function __construct(CostoController $costoController, EmpresaRepository $empresaRepository, ProyectoRepository $proyectoRepository, GestorRepository $gestorRepository)
    {
        $this->setEmpresaRepository($empresaRepository);
        $this->setProyectoRepository($proyectoRepository);
        $this->setGestorRepository($gestorRepository);
        $this->costoController = $costoController;
        $this->middleware(['auth']);
    }

    public function detalle(int $id)
    {
        if (request()->ajax()) {
            $proyecto = Proyecto::with([
                    'asesor',
                    'talentos',
                    'sedes',
                    'sedes.empresa',
                    'gruposinvestigacion',
                    'gruposinvestigacion.entidad',
                    'users_propietarios',
                ])->where('id', $id)->get()->first();
            if(!request()->user()->can('detalle', $proyecto)) {
                alert('No autorizado', 'No puedes ver la información de los proyectos que no haces parte', 'error')->showConfirmButton('Ok', '#3085d6');
                return back();
            }
            return response()->json([
                'data' => [
                    'proyecto' => $proyecto,
                    'total_usos' => $proyecto->usoinfraestructuras->count(),
                    ]
                ]);
            } else {
            $proyecto = Proyecto::findOrFail($id);
            if(!request()->user()->can('detalle_end', $proyecto)) {
                alert('No autorizado', 'No puedes ver la información de los proyectos que no haces parte y/o que aún no han finalizado', 'error')->showConfirmButton('Ok', '#3085d6');
                return back();
            }
            $historico = Proyecto::consultarHistoricoProyecto($proyecto->id)->get();
            $costo = $this->costoController->costoProject($proyecto->id);
            // dd($costo);
            return view('proyectos.detalles.detalle', [
                'proyecto' => $proyecto,
                'costo' => $costo,
                'historico' => $historico
            ]);

        }
    }

    /**
     * Formulario que permite cambiar los talentos de un proyecto en cualquier fase
     *
     * @param int id del proyecto
     * @return Response
     * @author dum
     */
    public function cambiar_talento($id)
    {
        $proyecto = Proyecto::find($id);
        if(!request()->user()->can('cambiar_talentos', $proyecto)) {
            alert('No autorizado', 'No tienes permisos para cambiar los talentos que desarrollan este proyecto', 'error')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        $historico = Proyecto::consultarHistoricoProyecto($proyecto->id)->get();
        return view('proyectos.forms.form_cambio_talentos', [
            'proyecto' => $proyecto,
            'historico' => $historico
        ]);
    }

    /**
     * Cambia los talentos de un proyecto
     *
     * @param Request $request
     * @param int id del proyecto
     * @return Response
     */
    public function updateTalentos(Request $request, $id)
    {
        $proyecto = Proyecto::find($id);
        if(!request()->user()->can('cambiar_talentos', $proyecto)) {
            alert('No autorizado', 'No tienes permisos para cambiar los talentos que desarrollan este proyecto', 'error')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        $req = new ProyectoFaseInicioFormRequest;
        $validator = Validator::make($request->all(), $req->rulesTalentos(), $req->messages());
        if ($validator->fails()) {
            return response()->json([
                'state'   => 'error_form',
                'errors' => $validator->errors(),
            ]);
        } else {
            $update = $this->getProyectoRepository()->update_talentos($request, $proyecto);
            if ($update) {
                return response()->json(['state' => 'update', 'url' => route('proyecto.inicio', $update['id'])]);
            } else {
                return response()->json(['state' => 'no_update']);
            }
        }
    }

    public function consultarHorasDeExpertos(int $id)
    {
        $horas = [];
        $horas = $this->getProyectoRepository()->horasAsesoriaPorExperto($id)->get();
        return response()->json([
            'horas' => $horas
        ]);
    }

    /**
     * @param Collection $proyecto Proyectos
     * @param Request $request
     * @return Response
     * @author dum
     */
    private function datatableProyectos($request, $proyectos)
    {
        // dd($request);
        return datatables()->of($proyectos)
            ->addColumn('info', function ($data) {
                $button = "<a class=\"btn bg-info m-b-xs modal-trigger\" href=\"#!\" onclick=\"infoActividad.infoDetailActivityModal('$data->id')\">
                <i class=\" material-icons\">info</i>
                </a>";
                return $button;
            })->addColumn('download_seguimiento', function ($data) {
                $seguimiento = '<a class="btn green lighten-1 m-b-xs" href=' . route('pdf.actividad.usos', [$data->id, 'proyecto']) . ' target="_blank"><i class="far fa-file-pdf"></i></a>';
                return $seguimiento;
            })->addColumn('download_trazabilidad', function ($data) {
                $seguimiento = '<a class="btn bg-success white-text m-b-xs" href=' . route('excel.proyecto.trazabilidad', $data->id) . '  target="_blank"><i class="far fa-file-excel"></i></a>';
                return $seguimiento;
            })->addColumn('ver_horas', function ($data) {
                $seguimiento = '<a class="btn bg-warning white-text m-b-xs" onclick="verHorasDeExpertosEnProyecto('.$data->id.')"><i class="material-icons">access_time</i></a>';
                return $seguimiento;
            })->addColumn('proceso', function ($data) {
                if ($data->nombre_fase == 'Finalizado' || $data->nombre_fase == 'Cancelado') {
                    $edit = '<a class="btn bg-secondary m-b-xs" href=' . route('proyecto.detalle', $data->id) . '><i class="material-icons">search</i></a>';
                } else if ($data->nombre_fase == 'Inicio') {
                    $edit = '<a class="btn bg-secondary m-b-xs" href=' . route('proyecto.inicio', $data->id) . '><i class="material-icons">search</i></a>';
                } else if ($data->nombre_fase == 'Planeación') {
                    $edit = '<a class="btn bg-secondary m-b-xs" href=' . route('proyecto.planeacion', $data->id) . '><i class="material-icons">search</i></a>';
                } else if ($data->nombre_fase == 'Ejecución') {
                    $edit = '<a class="btn bg-secondary m-b-xs" href=' . route('proyecto.ejecucion', $data->id) . '><i class="material-icons">search</i></a>';
                } else {
                    $edit = '<a class="btn bg-secondary m-b-xs" href=' . route('proyecto.cierre', $data->id) . '><i class="material-icons">search</i></a>';
                }
                return $edit;
            })->filter(function ($instance) use ($request) {
                if (!empty($request->get('codigo_proyecto'))) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['codigo_proyecto'], $request->get('codigo_proyecto')) ? true : false;
                    });
                }
                if (!empty($request->get('nombre'))) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['nombre'], $request->get('nombre')) ? true : false;
                    });
                }
                if (!empty($request->get('nombre_fase'))) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['nombre_fase'], $request->get('nombre_fase')) ? true : false;
                    });
                }
                if (!empty($request->get('sublinea_nombre'))) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['sublinea_nombre'], $request->get('sublinea_nombre')) ? true : false;
                    });
                }
                if (!empty($request->get('gestor'))) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return Str::contains($row['gestor'], $request->get('gestor')) ? true : false;
                    });
                }
                if (!empty($request->get('search'))) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        if (Str::contains(Str::lower($row['codigo_proyecto']), Str::lower($request->get('search')))) {
                            return true;
                        } else if (Str::contains(Str::lower($row['nombre']), Str::lower($request->get('search')))) {
                            return true;
                        } else if (Str::contains(Str::lower($row['nombre_fase']), Str::lower($request->get('search')))) {
                            return true;
                        } else if (Str::contains(Str::lower($row['gestor']), Str::lower($request->get('search')))) {
                            return true;
                        } else if (Str::contains(Str::lower($row['sublinea_nombre']), Str::lower($request->get('search')))) {
                            return true;
                        }
                        return false;
                    });
                }
            })->rawColumns(['info', 'details', 'proceso', 'download_seguimiento', 'download_trazabilidad', 'ver_horas'])->make(true);
    }

    public function carta_certificacion($id)
    {
        $proyecto = Proyecto::findOrFail($id);
        return view('proyectos.certificacion', [
            'proyecto' => $proyecto
        ]);
    }

    /**
     * Muestra los proyectos de un nodo por año (de la fecha de cierre)
     * @param int $idnodo Id del nodo
     * @param string $anho Año para filtrar
     * @return Response
     * @author dum
     */
    public function datatableProyectosAnho(Request $request, $idnodo = null, $anho = null)
    {
        $experto = "";
        $nodo = "";
        if (session()->get('login_role') == User::IsDinamizador() || session()->get('login_role') == User::IsInfocenter()) {
            $experto = null;
            $nodo = request()->user()->getNodoUser();
        } elseif (session()->get('login_role') == User::IsExperto()) {
            $experto = request()->user()->id;
            $nodo = request()->user()->getNodoUser();
        } else {
            $nodo = $idnodo;
            $experto = null;
        }

        if (session()->get('login_role') == User::IsTalento()) {
            $proyectos = $proyectos = $this->getProyectoRepository()->proyectosDelTalento(request()->user()->id)->get();
        } else if (session()->get('login_role') == User::IsExperto()) {
            $proyectos = $this->getProyectoRepository()->ConsultarProyectosPorAnho($anho)->where('experto_id', $experto)->where('nodos.id', $nodo)->get();
        } else {
            $proyectos = $this->getProyectoRepository()->ConsultarProyectosPorAnho($anho)->where('nodos.id', $nodo)->get();
        }
        return $this->datatableProyectos($request, $proyectos);
    }

    /**
     * Consultar los proyectos para generar costos
     *
     * @param string $anho
     * @return Request
     * @author dum
     **/
    public function proyectosCostos(string $anho)
    {
        if (Session::get('login_role') == User::IsExperto()) {
            $proyectos = $this->getProyectoRepository()->ConsultarProyectosPorAnho($anho)->where('experto_id', auth()->user()->id)->get();
        } else {

            $proyectos = $this->getProyectoRepository()->ConsultarProyectosPorAnho($anho)->where('nodos.id', auth()->user()->dinamizador->nodo_id)->get();
        }
        return response()->json([
            'proyectos' => $proyectos
        ]);
    }

    /**
     * modifica los entregables de un proyecto
     *
     * @param Request $request
     * @param int $id Id del proyecto
     * @return Response
     * @author dum
     */
    public function updateEntregables(Request $request, $id)
    {
        $update = $this->getProyectoRepository()->updateEntregablesInicioProyectoRepository($request, $id);
        if ($update) {
            Alert::success('Modificación Exitosa!', 'Los entregables del proyecto se han modificado!')->showConfirmButton('Ok', '#3085d6');
            return redirect()->route('proyecto.inicio', $id);
        } else {
            Alert::error('Modificación Errónea!', 'Los entregables del proyecto no se han modificado!')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
    }

    /**
     * Vista para el formulario de los entregables de un proyecto
     *
     * @param int $id Id del proyecto
     * @return Response
     * @author dum
     */
    public function entregables_inicio($id)
    {
        $proyecto = Proyecto::findOrFail($id);
        if(!request()->user()->can('adjuntar_entregables', [$proyecto, 'Inicio'])) {
            alert('No autorizado', 'No puedes adjuntar entregables de la fase de inicio en este proyecto!', 'warning')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        return view('proyectos.forms.views.entregables_inicio', [
            'proyecto' => $proyecto
        ]);
    }

    /**
     * Vista para subir las entregables de un proyecto en la fase de cierre
     *
     * @param int $id Id del proyecto
     * @return Response
     * @author dum
     */
    public function entregables_cierre(int $id)
    {
        $proyecto = Proyecto::findOrFail($id);
        if(!request()->user()->can('adjuntar_entregables', [$proyecto, 'Cierre'])) {
            alert('No autorizado', 'No puedes adjuntar entregables de la fase de cierre en este proyecto!', 'warning')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        return view('proyectos.forms.views.entregables_cierre', [
            'proyecto' => $proyecto
        ]);
    }

    /**
     * Consulta los proyectos de un experto por año (De la fecha de cierre)
     * @param Request $request
     * @param int $id Id del gestor
     * @param string $anho Año por el que se filtran los proyectos
     * @return Response
     * @author dum
     */
    public function datatableProyectosDelGestorPorAnho(Request $request, $id, $anho)
    {
        if (request()->ajax()) {
            $idgestor = $id;
            if (Session::get('login_role') == User::IsExperto()) {
                $idgestor = request()->user()->id;
            }
            $proyectos = $this->getProyectoRepository()->ConsultarProyectosPorAnho($anho)->where('experto_id', $idgestor)->get();
            return $this->datatableProyectos($request, $proyectos);
        }
    }

    // Datatable para listar las ideas de proyectos con emprendedores (que aprobaron el CSIBT)
    public function ideasAsignadaAExperto($nodo = null, $id_experto = null)
    {
        // dd($nodo);
        // exit;
        // dd($nodo);
        if (session()->get('login_role') == User::IsExperto()) {
            $ideas = Idea::ConsultarIdeasAprobadasEnComite(auth()->user()->experto->nodo_id, auth()->user()->id)->get();
        } else {
            $ideas = Idea::ConsultarIdeasAprobadasEnComite($nodo, $id_experto)->get();
        }

        return datatables()->of($ideas)
        ->addColumn('checkbox', function ($data) {
                $checkbox = '
                <a class="btn blue" onclick="asociarIdeaDeProyectoAProyecto(' . $data->consecutivo . ', \'' . $data->nombre_proyecto . '\', \'' . $data->codigo_idea . '\')">
                <i class="material-icons">done</i>
                </a>
                ';
                return $checkbox;
        })->editColumn('nombres_contacto', function ($data) {
                if ($data->talento_id == null) {
                    return "{$data->nombres_contacto}";
                } else {
                    return "{$data->nombres_talento}";
                }
        })->rawColumns(['checkbox'])->make(true);
    }

    // Datatable para listar las ideas de proyectos con emprendedores (que aprobaron el CSIBT)
    public function datatableIdeasConEmpresasGrupo()
    {
        if (request()->ajax()) {
            $ideas = Idea::ConsultarIdeasConEmpresasGrupos(auth()->user()->experto->nodo_id)->get();
            return datatables()->of($ideas)
                ->addColumn('checkbox', function ($data) {
                    $checkbox = '<a class="btn blue" onclick="asociarIdeaDeProyectoAProyecto(' . $data->consecutivo . ', \'' . $data->nombre_proyecto . '\', \'' . $data->codigo_idea . '\')">
                                <i class="material-icons">done</i>
                            </a>';
                    return $checkbox;
                })->rawColumns(['checkbox'])->make(true);
        }
    }

    // Datatable para listar los nodos de tecnoparque
    public function datatableCentroFormacionTecnoparque()
    {
        if (request()->ajax()) {
            $centros = Centro::CentroDeFormacionDeTecnoparque()->get();
            return datatables()->of($centros)
                ->addColumn('checkbox', function ($data) {
                    $checkbox = '
                        <input type="radio" class="with-gap" name="txtentidad_centrofomacion_id"
                        onclick="asociarCentroDeFormacionAProyecto(' . $data->id_entidad . ', \'' . $data->codigo_centro . '\', \'' . $data->nombre . '\')" id="radioButton' . $data->id_entidad . '"
                        value="' . $data->id_entidad . '"/>
                        <label for ="radioButton' . $data->id_entidad . '"></label>
                        ';
                    return $checkbox;
                })->rawColumns(['checkbox'])->make(true);
        }
    }

    // Datatable para listar los nodos de tecnoparque
    public function datatableNodosTecnoparque()
    {
        if (request()->ajax()) {
            $nodos = Nodo::NodoDeTecnoparque()->get();
            return datatables()->of($nodos)
                ->addColumn('checkbox', function ($data) {
                    $checkbox = '
                        <input type="radio" class="with-gap" name="txtentidad_nodo_id"
                        onclick="asociarNodoAProyecto(' . $data->id_entidad . ', \'' . $data->codigo_centro . '\', \'' . $data->nombre_nodo . '\', \'' . $data->centro . '\')" id="radioButton' . $data->id_entidad . '"
                        value="' . $data->id_entidad . '"/>
                        <label for ="radioButton' . $data->id_entidad . '"></label>
                        ';
                    return $checkbox;
                })->rawColumns(['checkbox'])->make(true);
        }
    }

    public function datatableTecnoacademiasTecnoparque()
    {
        if (request()->ajax()) {
            $tecnoacademias = Tecnoacademia::ConsultarTecnoAcademias()->get();
            return datatables()->of($tecnoacademias)
                ->addColumn('checkbox', function ($data) {
                    $nombre   = strval($data->nombre);
                    $checkbox = '
                        <input type="radio" class="with-gap" name="txtentidad_tecnoacademia_id"
                        onclick="asociarTecnoacademiaAProyecto(' . $data->id_entidad . ', \'' . $data->codigo_centro . '\', \'' . $nombre . '\', \'' . $data->codigo . '\')" id="radioButton' . $data->id_entidad . '"
                        value="' . $data->id_entidad . '"/>
                        <label for ="radioButton' . $data->id_entidad . '"></label>
                        ';
                    return $checkbox;
                })->rawColumns(['checkbox'])->make(true);
        }
    }

    // Consulta los grupos de investigación (se filtra por grupo de investigación)
    public function datatableGruposInvestigacionTecnoparque($tipo)
    {
        if ($tipo == GrupoInvestigacion::IsInterno()) {
            $grupo = GrupoInvestigacion::ConsultarGruposDeInvestigaciónTecnoparqueSena()->get();
        } else {
            $grupo = GrupoInvestigacion::ConsultarGruposDeInvestigaciónTecnoparqueExterno()->get();
        }
        return datatables()->of($grupo)
        ->addColumn('checkbox', function ($data) {
            $nombre   = strval($data->nombre);
            $checkbox = '
                <input type="radio" class="with-gap" name="txtentidad_grupo_id"
                onclick="asociarGrupoInvestigacionAProyecto(' . $data->id_entidad . ', \'' . $data->codigo_grupo . '\', \'' . $nombre . '\')" id="radioButton' . $data->id_entidad . '"
                value="' . $data->id_entidad . '"/>
                <label for ="radioButton' . $data->id_entidad . '"></label>
                ';
            return $checkbox;
        })->rawColumns(['checkbox'])->make(true);
    }

    // Datatable de las empresas de tecnoparque
    public function datatableEmpresasTecnoparque()
    {
        $empresas = $this->getEmpresaRepository()->consultarEmpresasDeRedTecnoparque();
        return datatables()->of($empresas)
        ->addColumn('checkbox', function ($data) {
            $nombre   = strval($data->nombre_empresa);
            $checkbox = '
                <input type="radio" class="with-gap" name="txtentidad_id"
                onclick="asociarEmpresaAProyecto(' . $data->id_entidad . ', ' . $data->nit . ', \'' . $nombre . '\')" id="radioButton' . $data->id_entidad . '"
                value="' . $data->id_entidad . '"/>
                <label for ="radioButton' . $data->id_entidad . '"></label>
                ';
            return $checkbox;
        })->rawColumns(['checkbox'])->make(true);
    }


    /**
     * Consulta las sublineas que tiene un experto
     *
     * @param int $id Id de la línea tecnológica.
     * @return Response
     * @author dum
     */
    public function consultarSublineas($id)
    {
        $sublineas = Sublinea::SubLineasDeUnaLinea($id)->get();
        return response()->json([
            'sublineas' => $sublineas
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('proyectos.index', [
            'nodos' => Nodo::SelectNodo()->get(),
            'gestores' => User::ConsultarFuncionarios(request()->user()->getNodoUser(), User::IsExperto())->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!request()->user()->can('create', Proyecto::class)) {
            alert('No autorizado', 'No tienes permisos para registrar proyectos!', 'warning')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        if (session()->get('login_role') == User::IsExperto()) {
            $sublineas = Sublinea::SubLineasDeUnaLinea(auth()->user()->experto->linea_id)->get()->pluck('nombre', 'id');
        } else {
            $sublineas = null;
        }
        return view('proyectos.create', [
            'sublineas' => $sublineas,
            'areasconocimiento' => AreaConocimiento::ConsultarAreasConocimiento()->pluck('nombre', 'id'),
            'nodos' => Nodo::SelectNodo()->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $req = new ProyectoFaseInicioFormRequest;
        $validator = Validator::make($request->all(), $req->rules(), $req->messages());
        if ($validator->fails()) {
            return response()->json([
                'state'   => 'error_form',
                'errors' => $validator->errors(),
            ]);
        } else {
            $result = $this->getProyectoRepository()->store($request);
            if ($result['state']) {
                return response()->json(['state' => 'registro', 'url' => route('proyecto.inicio', $result['id'])]);
            } else {
                return response()->json(['state' => 'no_registro']);
            }
        }
    }

    /**
     * Muestra el formulario para cambiar los datos de la fase de inicio de un proyecto
     *
     * @param int $id Id del proyecto
     * @return Response
     * @author dum
     **/
    public function form_inicio($id)
    {
        $proyecto = Proyecto::findOrFail($id);
        if(!request()->user()->can('detalle', $proyecto)) {
            alert('No autorizado', 'No puedes ver la información de los proyectos que no haces parte', 'warning')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        // dd($proyecto->asesor->experto);
        if ($proyecto->fase->nombre == Proyecto::IsInicio() || session()->get('login_role') == User::IsAdministrador()) {
            return view('proyectos.forms.views.form_inicio_view', [
                'sublineas' => Sublinea::SubLineasDeUnaLinea($proyecto->sublinea->linea->id)->get()->pluck('nombre', 'id'),
                'areasconocimiento' => AreaConocimiento::ConsultarAreasConocimiento()->pluck('nombre', 'id'),
                'proyecto' => $proyecto,
                'nodos' => Nodo::SelectNodo()->get()
            ]);
        } else {
            Alert::error('Error!', 'No es posible cambiar la información de la fase de inicio, el proyecto debe estar en esta fase!')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
    }

    /**
     * Muestra el formulario para cambiar los datos de la fase de planeación de un proyecto
     *
     * @param int $id Id del proyecto
     * @return Response
     * @author dum
     **/
    public function form_planeacion($id)
    {
        $proyecto = Proyecto::findOrFail($id);
        if(!request()->user()->can('detalle', $proyecto)) {
            alert('No autorizado', 'No puedes ver la información de los proyectos que no haces parte', 'warning')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        if ($proyecto->fase->nombre == Proyecto::IsPlaneacion() || session()->get('login_role') == User::IsAdministrador()) {
            return view('proyectos.forms.views.form_planeacion_view', [
                'proyecto' => $proyecto
            ]);
        } else {
            Alert::error('Error!', 'No es posible cambiar la información de la fase de planeación, el proyecto no se encuentra en la fase de planeación!')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
    }

    /**
     * Muestra el formulario para cambiar los datos de la fase de ejecución de un proyecto
     *
     * @param int $id Id del proyecto
     * @return Response
     * @author dum
     **/
    public function form_ejecucion($id)
    {
        $proyecto = Proyecto::findOrFail($id);
        if(!request()->user()->can('detalle', $proyecto)) {
            alert('No autorizado', 'No puedes ver la información de los proyectos que no haces parte', 'warning')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        if ($proyecto->fase->nombre == Proyecto::IsEjecucion() || session()->get('login_role') == User::IsAdministrador()) {
            return view('proyectos.forms.views.form_ejecucion_view', [
                'proyecto' => $proyecto
            ]);
        } else {
            Alert::error('Error!', 'No es posible cambiar la información de la fase de ejecución, el proyecto no se encuentra en la fase de ejecución!')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
    }

    /**
     * Muestra el formulario para cambiar los datos de la fase de cierre de un proyecto
     *
     * @param int $id Id del proyecto
     * @return Response
     * @author dum
     **/
    public function form_cierre($id)
    {
        $proyecto = Proyecto::findOrFail($id);
        if(!request()->user()->can('detalle', $proyecto)) {
            alert('No autorizado', 'No puedes ver la información de los proyectos que no haces parte', 'warning')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        return view('proyectos.forms.views.form_cierre_view', [
            'proyecto' => $proyecto,
            'costo' => $this->costoController->costoProject($proyecto->id)
        ]);
    }

    /**
     * Muestra el detalle de la fase de inicio de un proyecto
     *
     * @param int  $id
     * @return \Illuminate\Http\Response
     * @author dum
     */
    public function inicio($id)
    {
        $proyecto = Proyecto::findOrFail($id);
        // dd($proyecto->talentos);
        if(!request()->user()->can('detalle', $proyecto)) {
            alert('No autorizado', 'No puedes ver la información de los proyectos que no haces parte', 'warning')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        $historico = Proyecto::consultarHistoricoProyecto($proyecto->id)->get();
        $ult_notificacion = $this->proyectoRepository->retornarUltimaNotificacionPendiente($proyecto);
        $rol_destinatario = $this->proyectoRepository->verificarDestinatarioNotificacion($ult_notificacion);
        return view('proyectos.fases.fase_inicio', [
            'proyecto' => $proyecto,
            'historico' => $historico,
            'ult_notificacion' => $ult_notificacion,
            'rol_destinatario' => $rol_destinatario
        ]);
    }

    public function planeacion($id)
    {
        $proyecto = Proyecto::findOrFail($id);
        if(!request()->user()->can('detalle', $proyecto)) {
            alert('No autorizado', 'No puedes ver la información de los proyectos que no haces parte', 'warning')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        $historico = Proyecto::consultarHistoricoProyecto($proyecto->id)->get();
        $ult_notificacion = $this->proyectoRepository->retornarUltimaNotificacionPendiente($proyecto);
        $rol_destinatario = $this->proyectoRepository->verificarDestinatarioNotificacion($ult_notificacion);

        if ($proyecto->fase->nombre == $proyecto->IsInicio()) {
            alert('No autorizado', 'El proyecto se encuentra en la fase de ' . $proyecto->fase->nombre . '!', 'warning')->showConfirmButton('Ok', '#3085d6');
            return back();
        } else {
            return view('proyectos.fases.fase_planeacion', [
                'proyecto' => $proyecto,
                'historico' => $historico,
                'rol_destinatario' => $rol_destinatario,
                'ult_notificacion' => $ult_notificacion
            ]);
        }
    }

    /**
     * Vista para el formulario de la fase de ejecución del proyecto
     * @param int $id Id del proyecto
     * @return Response
     * @author dum
     */
    public function ejecucion(int $id)
    {
        $proyecto = Proyecto::findOrFail($id);
        if(!request()->user()->can('detalle', $proyecto)) {
            alert('No autorizado', 'No puedes ver la información de los proyectos que no haces parte', 'warning')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        $historico = Proyecto::consultarHistoricoProyecto($proyecto->id)->get();
        $ult_notificacion = $this->proyectoRepository->retornarUltimaNotificacionPendiente($proyecto);
        $rol_destinatario = $this->proyectoRepository->verificarDestinatarioNotificacion($ult_notificacion);

        if ($proyecto->fase->nombre == $proyecto->IsInicio() || $proyecto->fase->nombre == $proyecto->IsPlaneacion()) {
            alert('No autorizado', 'El proyecto se encuentra en la fase de ' . $proyecto->fase->nombre . '!', 'warning')->showConfirmButton('Ok', '#3085d6');
            return back();
        } else {
            return view('proyectos.fases.fase_ejecucion', [
                'proyecto' => $proyecto,
                'historico' => $historico,
                'rol_destinatario' => $rol_destinatario,
                'ult_notificacion' => $ult_notificacion
            ]);
        }
    }

    /**
     * Vista para el formulario de la fase de cierre
     * @param int $id Id del proyecto
     * @return Response
     * @author dum
     */
    public function cierre(int $id)
    {
        $proyecto = Proyecto::findOrFail($id);
        if(!request()->user()->can('detalle', $proyecto)) {
            alert('No autorizado', 'No puedes ver la información de los proyectos que no haces parte', 'warning')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        if ($proyecto->fase->nombre == $proyecto->IsFinalizado() || $proyecto->fase->nombre == $proyecto->IsSuspendido()) {
            return redirect()->route('proyecto.detalle', $id);
        }
        if ($proyecto->fase->nombre == $proyecto->IsInicio() || $proyecto->fase->nombre == $proyecto->IsPlaneacion() || $proyecto->fase->nombre == $proyecto->IsEjecucion()) {
            alert('No autorizado', 'El proyecto se encuentra en la fase de ' . $proyecto->fase->nombre . '!', 'warning')->showConfirmButton('Ok', '#3085d6');
            return back();
        } else {
            $historico = Proyecto::consultarHistoricoProyecto($proyecto->id)->get();
            $costo = $this->costoController->costoProject($proyecto->id);
            $ult_notificacion = $this->proyectoRepository->retornarUltimaNotificacionPendiente($proyecto);
            $rol_destinatario = $this->proyectoRepository->verificarDestinatarioNotificacion($ult_notificacion);
            return view('proyectos.fases.fase_cierre', [
                'proyecto' => $proyecto,
                'costo' => $costo,
                'historico' => $historico,
                'ult_notificacion' => $ult_notificacion,
                'rol_destinatario' => $rol_destinatario
            ]);
        }
    }

    /**
     * Vista para suspender un proyecto
     *
     * @param int $id Id del proyecto
     * @return Response
     * @author dum
     **/
    public function suspender(int $id)
    {
        $proyecto = Proyecto::findOrFail($id);
        if(!request()->user()->can('detalle', $proyecto)) {
            alert('No autorizado', 'No puedes ver la información de los proyectos que no haces parte', 'warning')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        $historico = Proyecto::consultarHistoricoProyecto($proyecto->id)->get();
        $ult_notificacion = $proyecto->notificaciones()->where('fase_id',  Fase::where('nombre', $proyecto->IsSuspendido())->first()->id)->whereNull('fecha_aceptacion')->get()->last();
        $rol_destinatario = $this->proyectoRepository->verificarDestinatarioNotificacion($ult_notificacion);
        return view('proyectos.fases.fase_suspendido', [
            'proyecto' => $proyecto,
            'historico' => $historico,
            'ult_notificacion' => $ult_notificacion,
            'rol_destinatario' => $rol_destinatario
        ]);

    }

    /**
     * Formulario para cambiar el experto de un proyecto
     *
     * @param int $id Id del proyecto
     * @return type
     * @throws conditon
     **/
    public function cambiar_gestor(int $id)
    {
        $proyecto = Proyecto::findOrFail($id);
        if(!request()->user()->can('cambiar_gestor', $proyecto)) {
            alert('No autorizado', 'No puedes cambiar el experto de un proyecto de otro nodo!', 'warning')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        $historico = Proyecto::consultarHistoricoProyecto($proyecto->id)->get();
        $gestores = User::ConsultarFuncionarios($proyecto->nodo_id, User::IsExperto(), $proyecto->sublinea->lineatecnologica_id)->get();
        // dd($gestores);
        // $gestores = $this->getGestorRepository()->consultarGestoresPorLineaTecnologicaYNodoRepository($proyecto->sublinea->lineatecnologica_id, $proyecto->nodo_id)->pluck('nombre', 'id');
        return view('proyectos.forms.cambiar_gestor', [
            'proyecto' => $proyecto,
            'historico' => $historico,
            'gestores' => $gestores
        ]);
    }

    /**
     * Notifica al dinamizador para que apruebe el proyecto en la fase de inicio
     *
     * @param int $id Id del proyecto
     * @return Response
     * @author dum
     */
    public function solicitar_aprobacion(int $id, string $fase = null)
    {
        $proyecto = Proyecto::find($id);
        if(!request()->user()->can('notificar_aprobacion', $proyecto)) {
            alert('No autorizado', 'No puedes solicitar la aprobación de este proyecto', 'error')->showConfirmButton('Ok', '#3085d6');
            return back();
        }

        $notificacion = $this->getProyectoRepository()->notificarAprobacionDeFase($proyecto, $fase);
        if ($notificacion['notificacion']) {
            Alert::success('Notificación Exitosa!', $notificacion['msg'])->showConfirmButton('Ok', '#3085d6');
        } else {
            Alert::error('Notificación Errónea!', $notificacion['msg'])->showConfirmButton('Ok', '#3085d6');
        }
        return back();
    }

    /**
     * Notifica al dinamizador para que un proyecto se suspenda
     * @param int $id Id del proyecto
     * @return Reponse
     * @author dum
     **/
    public function notificar_suspendido(int $id)
    {
        $notificacion = $this->getProyectoRepository()->notificarAlDinamziador_Suspendido($id);
        if ($notificacion) {
            Alert::success('Notificación Exitosa!', 'Se le ha enviado una notificación al dinamizador para que apruebe la suspensión del proyecto!')->showConfirmButton('Ok', '#3085d6');
        } else {
            Alert::error('Notificación Errónea!', 'No se le ha enviado una notificación al dinamizador para que apruebe la suspensión del proyecto!')->showConfirmButton('Ok', '#3085d6');
        }
        return back();
    }

    /**
     * Modifica los datos de la fase de inicio de un proyecto.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateInicio(Request $request, $id)
    {
        $req = new ProyectoFaseInicioFormRequest;
        $validator = Validator::make($request->all(), $req->rules(), $req->messages());
        if ($validator->fails()) {
            return response()->json([
                'state'   => 'error_form',
                'errors' => $validator->errors(),
            ]);
        } else {
            $result = $this->getProyectoRepository()->update($request, $id);
            if ($result) {
                return response()->json([
                    'state' => 'update',
                    'url' => route('proyecto.inicio', $id)
            ]);
            } else {
                return response()->json(['state' => 'no_update']);
            }
        }
    }

    /**
     * Gestionar la aprobación de una fase del proyecto
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @param  string $fase Fase que se está aprobando
     * @return \Illuminate\Http\Response
     */
    public function gestionarAprobacion(Request $request, $id)
    {
        $update = $this->getProyectoRepository()->aprobacionFaseInicio($request, $id);
        if ($update['state']) {
            Alert::success($update['title'], $update['mensaje'])->showConfirmButton('Ok', '#3085d6');
            if ($update['route'] != null) {
                return redirect($update['route']);
            } else {
                return back();
            }
        } else {
            Alert::error($update['title'], $update['mensaje'])->showConfirmButton('Ok', '#3085d6');
            return back();
        }
    }

    /**
     * Modifica los datos de un proyecto en el estado de planeación
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id Id del proyecto
     * @return \Illuminate\Http\Response
     * @author dum
     */
    public function updatePlaneacion(Request $request, $id)
    {
        $update = $this->getProyectoRepository()->updateEntregablesPlaneacionProyectoRepository($request, $id);
        if ($update) {
            Alert::success('Modificación Exitosa!', 'Los entregables del proyecto en la fase de planeación se han modificado!')->showConfirmButton('Ok', '#3085d6');
        } else {
            Alert::error('Modificación Errónea!', 'Los entregables del proyecto en la fase de planeación no se han modificado!')->showConfirmButton('Ok', '#3085d6');
        }
        return back();
    }

    /**
     * Modifica los cambios de la fase de ejecución
     * @param Request $request
     * @param int $id Id del proyecto
     * @return Response
     * @author dum
     **/
    public function updateEjecucion(Request $request, $id)
    {
        $update = $this->getProyectoRepository()->updateEntregablesEjecucionProyectoRepository($request, $id);
        if ($update) {
            Alert::success('Modificación Exitosa!', 'Los entregables del proyecto en la fase de ejecución se han modificado!')->showConfirmButton('Ok', '#3085d6');
            return back();
        } else {
            Alert::error('Modificación Errónea!', 'Los entregables del proyecto en la fase de ejecución no se han modificado!')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
    }

    public function updateEntregables_Cierre(Request $request, $id)
    {
        $proyecto = Proyecto::findOrFail($id);
        $update = $this->getProyectoRepository()->updateEntregableCierreProyectoRepository($request, $id);
        if ($update) {
            Alert::success('Modificación Exitosa!', 'Los entregables del proyecto en la fase de cierre se han modificado!')->showConfirmButton('Ok', '#3085d6');
            return back();
        } else {
            Alert::error('Modificación Errónea!', 'Los entregables del proyecto en la fase de cierre no se han modificado!')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
    }

    /**
     * Cambia los datos del proyecto en estado de cierre
     *
     * @param Request $request
     * @param int $id Id del proyecto
     * @author dum
     */
    public function updateCierre(Request $request, int $id)
    {
        $req = new ProyectoFaseCierreFormRequest;
        $validator = Validator::make($request->all(), $req->rules(), $req->messages());
        if ($validator->fails()) {
            return response()->json([
                'state'   => 'error_form',
                'errors' => $validator->errors(),
            ]);
        } else {
            $result = $this->getProyectoRepository()->updateCierreProyectoRepository($request, $id);
            if ($result) {
                return response()->json([
                    'state' => 'update',
                    'url' => route('proyecto.cierre', $id)
            ]);
            } else {
                return response()->json(['state' => 'no_update']);
            }
        }
    }

    /**
     * Cambia el estado del proyecto a suspendido
     *
     * @param Request $request
     * @param int $id
     * @return Response
     * @author dum
     **/
    public function updateSuspendido(Request $request, int $id)
    {
        $proyecto = Proyecto::find($id);
        if(!request()->user()->can('aprobar_suspendido', $proyecto)) {
            alert('No autorizado', 'No puedes suspender proyectos que los que no haces parte', 'error')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        $update = $this->getProyectoRepository()->updateAprobacionSuspendido($id, $request);
        if ($update) {
            Alert::success('Modificación Exitosa!', 'La fase de suspendido del proyecto se aprobó!')->showConfirmButton('Ok', '#3085d6');
            return redirect('proyecto');
        } else {
            Alert::error('Modificación Errónea!', 'La fase de suspendido del proyecto no se aprobó!')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
    }

    /**
     * Cambiar el experto de un proyecto
     * @param Request $request
     * @param int $id
     * @return Response
     * @author dum
     **/
    public function updateGestor(Request $request, int $id)
    {
        $proyecto = Proyecto::findOrFail($id);
        if(!request()->user()->can('cambiar_gestor', $proyecto)) {
            alert('No autorizado', 'No puedes cambiar el experto de un proyecto de otro nodo!', 'error')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        $messages = [
            'txtgestor_id.required' => 'El experto es obligatorio.',
        ];

        $validator = Validator::make($request->all(), [
            'txtgestor_id' => 'required',
        ], $messages);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $update = $this->getProyectoRepository()->updateGestor($request, $id);
        if ($update) {
            Alert::success('Se ha cambiado el experto del proyecto!', 'Modificación Exitosa!')->showConfirmButton('Ok', '#3085d6');
            return redirect()->route('proyecto.inicio', $id);
        } else {
            Alert::error('No se ha cambiado el experto del proyecto!', 'Modificación Errónea!')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
    }

    /**
     * Reversa el proyecto de fase
     *
     * @param Request $request
     * @param int $id Id del proyecto
     * @param string $fase Fase a la que se va a reversar el proyecto
     * @return Response
     * @author dum
     **/
    public function updateReversar(int $id, string $fase)
    {
        $proyecto = Proyecto::findOrFail($id);
        $check = $this->isPosibleReversar($proyecto, $fase);
        if (!$check['return']) {
            return response()->json([
                'msg' => $check['msg'],
                'type_alert' => 'error'
            ]);
        }

        $update = $this->getProyectoRepository()->reversarProyecto($proyecto, $fase);
        if ($update) {
            return response()->json([
                'msg' => 'La fase del proyecto se ha reversado a '.$fase.'!',
                'type_alert' => 'success'
            ]);
        } else {
            return response()->json([
                'msg' => 'El proyecto no se ha reversado!',
                'type_alert' => 'error'
            ]);
        }

    }
    /**
     * Verificar que se puede reversa la fase de un proyecto
     *
     * @param App\Models\Proyecto $proyecto
     * @param string $fase_a_reversar
     * @return array
     * @auth dum
     **/
    private function isPosibleReversar($proyecto, $fase_a_reversar)
    {
        if ($proyecto->fase->nombre == $proyecto->IsFinalizado()) {
            return [
                'return' => true,
                'msg' => 'ok'
            ];
        }
        if ($proyecto->fase->nombre == $fase_a_reversar) {
            return [
                'return' => false,
                'msg' => 'El proyecto ya se encuentra en la fase de ' . $fase_a_reversar
            ];
        } else {
            if ($proyecto->fase->nombre == 'Cancelado') {
                return [
                    'return' => true,
                    'msg' => 'ok'
                ];
            } else {
                if (($proyecto->fase->nombre == 'Planeación' && $fase_a_reversar == 'Inicio')) {
                    return [
                        'return' => true,
                        'msg' => 'ok'
                    ];
                } else {
                    if (($proyecto->fase->nombre == 'Ejecución' && $fase_a_reversar == 'Planeación') || ($proyecto->fase->nombre == 'Ejecución' && $fase_a_reversar == 'Inicio')) {
                        return [
                            'return' => true,
                            'msg' => 'ok'
                        ];
                    } else {
                        if (($proyecto->fase->nombre == 'Cierre' && $fase_a_reversar == 'Ejecución') || ($proyecto->fase->nombre == 'Cierre' && $fase_a_reversar == 'Planeación') || ($proyecto->fase->nombre == 'Cierre' && $fase_a_reversar == 'Inicio')) {
                            return [
                                'return' => true,
                                'msg' => 'ok'
                            ];
                        } else {
                            return [
                                'return' => false,
                                'msg' => 'No se puede revesar el proyecto se ' . $proyecto->fase->nombre . ' a ' . $fase_a_reversar
                            ];
                        }
                    }
                }
            }
        }
        return [
            'return' => true,
            'msg' => 'ok'
        ];
    }


    public function projectsForGestor($id)
    {

        $projects = $this->getProyectoRepository()->getProjectsForGestor($id, ['Inicio', 'Planeacion', 'En ejecución']);

        return response()->json([
            'projects' => $projects,
        ]);
    }

    public function filterByCode($value)
    {

        $proyecto = Proyecto::select('id','idea_id','fase_id','articulacion_proyecto_id','alcance_proyecto')
        ->with([
            'idea',
            'fase',
            'articulacion_proyecto' => function($query){
                $query->select('id', 'actividad_id');
            },
            'articulacion_proyecto.actividad'=> function($query){
                $query->select('id', 'gestor_id', 'nodo_id', 'codigo_proyecto', 'nombre', 'objetivo_general', 'fecha_inicio', 'fecha_cierre');
            },
            'articulacion_proyecto.talentos',
            'articulacion_proyecto.talentos.user',
        ])->whereHas('articulacion_proyecto.actividad', function ($subQuery) use ($value) {
            $subQuery->where('codigo_proyecto', $value);
        })
        ->whereIn('fase_id', [Fase::IsFinalizado(), Fase::IsEjecucion(), Fase::IsCierre()])
        ->first();

        if($proyecto != null){
            return response()->json([
                'data' => [
                    'proyecto' => $proyecto,
                    'status_code' => Response::HTTP_OK
                ]
            ]);
        }
        return response()->json([
            'data' => [
                'proyecto' => null,
                'status_code' => Response::HTTP_NOT_FOUND,
            ]
        ]);
    }

    public function datatableProyectosFinalizados(Request $request)
    {
        switch (\Session::get('login_role')) {
            case User::IsActivador():
                $nodo = $request->filter_nodo_art;
                break;
            case User::IsDinamizador():
                $nodo = auth()->user()->dinamizador->nodo_id;
                break;
            case User::IsArticulador():
                $nodo = auth()->user()->articulador->nodo_id;
                break;
            default:
                return abort('403');
                break;
        }
        $proyectos = [];

        if (isset($request->filter_year_pro)) {
            $proyectos = Proyecto::select('id','idea_id','fase_id','articulacion_proyecto_id','alcance_proyecto')
            ->with([
                'fase',
                'articulacion_proyecto' => function($query){
                    $query->select('id', 'actividad_id');
                },
                'articulacion_proyecto.actividad'=> function($query){
                    $query->select('id', 'gestor_id', 'nodo_id', 'codigo_proyecto', 'nombre', 'objetivo_general', 'fecha_inicio', 'fecha_cierre');
                }
            ])
            ->nodo($nodo)
            ->starEndDate($request->filter_year_pro)
            ->whereIn('fase_id', [Fase::IsFinalizado(), Fase::IsEjecucion(), Fase::IsCierre()])
            ->get();
        }

        return $this->datatableAddProjects($proyectos);
    }

    private function datatableAddProjects($proyectos)
    {
        return datatables()->of($proyectos  )
            ->addColumn('add_proyecto', function ($data) {
                    $checkbox = '';
                    if (isset($data->articulacion_proyecto->actividad)) {
                        $checkbox = '<a class="btn bg-info" onclick="articulationStage.addProjectToArticulacion(\'' .($data->articulacion_proyecto->actividad->codigo_actividad) . '\')">
                                        <i class="material-icons">done</i>
                                    </a>';
                    }
                    return $checkbox;
            })
            ->editColumn('codigo_proyecto', function ($data) {
                if (isset($data->articulacion_proyecto->actividad)) {
                    return  $data->articulacion_proyecto->actividad->present()->actividadCode();
                }
                return "No registra";
            })
            ->editColumn('nombre', function ($data) {
                if (isset($data->articulacion_proyecto->actividad)) {
                    return  $data->articulacion_proyecto->actividad->present()->actividadName();
                }
                return "No registra";
            })
            ->editColumn('fase', function ($data) {
                if (isset($data->fase)) {
                    return  $data->fase->nombre;
                }
                return "No registra";
            })
            ->rawColumns(['codigo_proyecto','nombre','fase','show','add_proyecto'])->make(true);

    }

    /**
     * Muestra los proyectos que llevan mucho tiempo en inicio sin cambiar de fase
     *
     * @param int $nodo
     * @param int $experto
     * @return Response
     * @author dum
     **/
    public function proyectosLimiteInicio($nodo, $experto)
    {
        $limite_inicio = Carbon::now()->subDays(config('app.proyectos.duracion.inicio'));
        $experto = $experto == "null" ? null : $experto;
        return response()->json([
            'data' => [
                'proyectos' => $this->proyectoRepository->selectProyectosLimiteInicio($nodo, $experto, $limite_inicio)->get()
            ]
        ]);
    }

    /**
     * Muestra los proyectos que llevan mucho tiempo en planeacion sin cambiar de fase
     *
     * @param int $nodo
     * @param int $experto
     * @return Response
     * @author dum
     **/
    public function proyectosLimitePlaneacion($nodo, $experto)
    {
        $limite_inicio = Carbon::now()->subDays(config('app.proyectos.duracion.planeacion'));
        $experto = $experto == "null" ? null : $experto;
        return response()->json([
            'data' => [
                'proyectos' => $this->proyectoRepository->selectProyectosLimitePlaneacion($nodo, $experto, $limite_inicio)->groupBy('codigo_proyecto')->get()
            ]
        ]);
    }

    /**
     * Asigna un valor a $proyectoRepository
     * @param object $proyectoRepository
     * @return void type
     * @author dum
     */
    private function setProyectoRepository($proyectoRepository)
    {
        $this->proyectoRepository = $proyectoRepository;
    }

    /**
     * Retorna el valor de $proyectoRepository
     * @return object
     * @author dum
     */
    private function getProyectoRepository()
    {
        return $this->proyectoRepository;
    }

    /**
     * Asgina un valor a $empresaRepository
     * @param object $empresaRepository
     * @return void
     * @author dum
     */
    private function setEmpresaRepository($empresaRepository)
    {
        $this->empresaRepository = $empresaRepository;
    }

    /**
     * Retorna el valor de $empresaRepository
     * @return object
     * @author dum
     */
    private function getEmpresaRepository()
    {
        return $this->empresaRepository;
    }

    /**
     * Asigna un valor a $gestorRepository
     * @param object $gestorRepository
     * @return void
     * @author dum
     */
    private function setGestorRepository($gestorRepository)
    {
        $this->gestorRepository = $gestorRepository;
    }

    /**
     * Retorna el valor de $gestorRepository
     * @return object
     * @author dum
     */
    private function getGestorRepository()
    {
        return $this->gestorRepository;
    }

}
