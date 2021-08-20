<?php

namespace App\Http\Controllers;

use App\Models\{AreaConocimiento, Centro, Gestor, GrupoInvestigacion, Idea, Nodo, Proyecto, Sublinea, Tecnoacademia, TipoArticulacionProyecto, Actividad, Empresa, Fase};
use App\Repositories\Repository\{EmpresaRepository, EntidadRepository, ProyectoRepository, UserRepository\GestorRepository, ConfiguracionRepository\ServidorVideoRepository};
use Illuminate\Support\{Str, Facades\Session, Facades\Validator, Facades\DB};
use App\Http\Requests\{ProyectoFaseInicioFormRequest, ProyectoFaseCierreFormRequest};
use Illuminate\Http\{Request, Response};
use App\User;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Controllers\CostoController;

class ProyectoController extends Controller
{

    private $empresaRepository;
    private $proyectoRepository;
    private $gestorRepository;
    private $entidadRepository;
    private $servidorVideoRepository;
    private $costoController;

    public function __construct(CostoController $costoController, ServidorVideoRepository $servidorVideoRepository, EmpresaRepository $empresaRepository, ProyectoRepository $proyectoRepository, GestorRepository $gestorRepository, EntidadRepository $entidadRepository)
    {
        $this->setEmpresaRepository($empresaRepository);
        $this->setProyectoRepository($proyectoRepository);
        $this->setGestorRepository($gestorRepository);
        $this->setEntidadRepository($entidadRepository);
        $this->setServidorVideoRepository($servidorVideoRepository);
        $this->costoController = $costoController;
        $this->middleware(['auth']);
    }

    /**
     * Elimina un proyecto de la base de datos
     * @param int $id Id del proyecto a eliminar
     * @return Response
     * @author dum
     */
    public function eliminarProyecto_Controller($id)
    {

        if (Session::get('login_role') == User::IsDinamizador()) {
            $delete = $this->getProyectoRepository()->eliminarProyecto_Repository($id);
            return response()->json([
                'retorno' => $delete
            ]);
        } else {
            abort('403');
        }
    }

    /**
     * Datatable para el rol de talento
     * @return Datatables
     * @author dum
     */
    public function datatableProyectoTalento(Request $request)
    {
        $proyectos = $this->getProyectoRepository()->proyectosDelTalento(auth()->user()->talento->id);
        return $this->datatableProyectos($request, $proyectos);
    }

    public function detalle(int $id)
    {
        $proyecto = Proyecto::findOrFail($id);
        $historico = Actividad::consultarHistoricoActividad($proyecto->articulacion_proyecto->actividad->id)->get();
        $costo = $this->costoController->costoProject($proyecto->id);
        return view('proyectos.detalle', [
            'proyecto' => $proyecto,
            'costo' => $costo,
            'historico' => $historico
        ]);
    }

    public function consultarHorasDeExpertos(int $id)
    {
        $horas = [];
        $horas = $this->getProyectoRepository()->horasAsesoriaPorExperto($id)->get();
        return response()->json([
            'horas' => $horas
        ]);
        // dd($proyecto->articulacion_proyecto->actividad->usoinfraestructuras->usogestores);
    }

    /**
     * @param Collection $proyecto Proyectos
     * @param Request $request
     * @return Response
     * @author dum
     */
    private function datatableProyectos($request, $proyectos)
    {
        return datatables()->of($proyectos)
            ->addColumn('info', function ($data) {
                $button = "<a class=\"btn light-blue m-b-xs modal-trigger\" href=\"#!\" onclick=\"infoActividad.infoDetailActivityModal('$data->codigo_proyecto')\">
                <i class=\" material-icons\">info</i>
                </a>";
                    return $button;
                })->addColumn('details', function ($data) {
                            $details = '
                <a class="btn light-blue m-b-xs" onclick="detallesDeUnProyecto(' . $data->id . ')">
                    <i class="material-icons">info</i>
                </a>';
                return $details;
            })->addColumn('download_seguimiento', function ($data) {
                $seguimiento = '<a class="btn green lighten-1 m-b-xs" href=' . route('pdf.actividad.usos', [$data->id, 'proyecto']) . ' target="_blank"><i class="far fa-file-pdf"></i></a>';
                return $seguimiento;
            })->addColumn('download_trazabilidad', function ($data) {
                $seguimiento = '<a class="btn green lighten-1 m-b-xs" href=' . route('excel.proyecto.trazabilidad', $data->actividad_id) . '  target="_blank"><i class="far fa-file-excel"></i></a>';
                return $seguimiento;
            })->addColumn('ver_horas', function ($data) {
                $seguimiento = '<a class="btn brown lighten-1 m-b-xs" onclick="verHorasDeExpertosEnProyecto('.$data->id.')"><i class="material-icons">access_time</i></a>';
                return $seguimiento;
            })->addColumn('proceso', function ($data) {
                if ($data->nombre_fase == 'Finalizado' || $data->nombre_fase == 'Suspendido') {
                    $edit = '<a class="btn m-b-xs" href=' . route('proyecto.detalle', $data->id) . '><i class="material-icons">search</i></a>';
                } else if ($data->nombre_fase == 'Inicio') {
                    $edit = '<a class="btn m-b-xs" href=' . route('proyecto.inicio', $data->id) . '><i class="material-icons">search</i></a>';
                } else if ($data->nombre_fase == 'Planeación') {
                    $edit = '<a class="btn m-b-xs" href=' . route('proyecto.planeacion', $data->id) . '><i class="material-icons">search</i></a>';
                } else if ($data->nombre_fase == 'Ejecución') {
                    $edit = '<a class="btn m-b-xs" href=' . route('proyecto.ejecucion', $data->id) . '><i class="material-icons">search</i></a>';
                } else {
                    $edit = '<a class="btn m-b-xs" href=' . route('proyecto.cierre', $data->id) . '><i class="material-icons">search</i></a>';
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
    public function datatableProyectosDelNodoPorAnho(Request $request, $idnodo, $anho)
    {
        if (request()->ajax()) {
            $id = "";
            if (Session::get('login_role') == User::IsDinamizador()) {
                $id = auth()->user()->dinamizador->nodo_id;
            } elseif (Session::get('login_role') == User::IsInfocenter()) {
                $id = auth()->user()->infocenter->nodo_id;
            } else {
                $id = $idnodo;
            }
            $proyectos = $this->getProyectoRepository()->ConsultarProyectosPorAnho($anho)->where('nodos.id', $id)->get();
            return $this->datatableProyectos($request, $proyectos);
        }
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
        if (Session::get('login_role') == User::IsGestor()) {
            $proyectos = $this->getProyectoRepository()->ConsultarProyectosPorAnho($anho)->where('gestores.id', auth()->user()->gestor->id)->get();
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
        if (Session::get('login_role') == User::IsGestor()) {
            $update = $this->getProyectoRepository()->updateEntregablesInicioProyectoRepository($request, $id);
            if ($update) {
                Alert::success('Modificación Exitosa!', 'Los entregables del proyecto se han modificado!')->showConfirmButton('Ok', '#3085d6');
                return redirect('proyecto');
            } else {
                Alert::error('Modificación Errónea!', 'Los entregables del proyecto no se han modificado!')->showConfirmButton('Ok', '#3085d6');
                return back();
            }
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
        if (Session::get('login_role') == User::IsGestor()) {
            return view('proyectos.gestor.entregables_inicio', [
                'proyecto' => $proyecto
            ]);
        }
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
        if (Session::get('login_role') == User::IsGestor()) {
            return view('proyectos.gestor.entregables_cierre', [
                'proyecto' => $proyecto
            ]);
        }
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
            if (Session::get('login_role') == User::IsGestor()) {
                $idgestor = auth()->user()->gestor->id;
            }
            $proyectos = $this->getProyectoRepository()->ConsultarProyectosPorAnho($anho)->where('gestores.id', $idgestor)->get();
            return $this->datatableProyectos($request, $proyectos);
        }
    }

    // Datatable para listar las ideas de proyectos con emprendedores (que aprobaron el CSIBT)
    public function datatableIdeasConEmprendedores()
    {
        if (request()->ajax()) {
            $ideas = Idea::ConsultarIdeasAprobadasEnComite(auth()->user()->gestor->nodo_id, auth()->user()->gestor->id)->get();

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
    }

    // Datatable para listar las ideas de proyectos con emprendedores (que aprobaron el CSIBT)
    public function datatableIdeasConEmpresasGrupo()
    {
        if (request()->ajax()) {
            $ideas = Idea::ConsultarIdeasConEmpresasGrupos(auth()->user()->gestor->nodo_id)->get();
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
        if (request()->ajax()) {
            if ($tipo == GrupoInvestigacion::IsInterno()) {
                $grupo = GrupoInvestigacion::ConsultarGruposDeInvestigaciónTecnoparqueSena()->get();
            } else {
                $grupo = GrupoInvestigacion::ConsultarGruposDeInvestigaciónTecnoparqueExterno()->get();
            }
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
        if (request()->ajax()) {
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
    }


    public function datatableEntidadesTecnoparque($id)
    {
        if (request()->ajax()) {
            $nombre    = TipoArticulacionProyecto::where('id', $id)->get()->last();
            $nombre    = $nombre->nombre;
            $entidades = "";
            if ($nombre == 'Grupos y Semilleros del SENA') {
                $entidades = GrupoInvestigacion::ConsultarGruposDeInvestigaciónTecnoparqueSena()->get();
            }
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        switch (Session::get('login_role')) {
            case User::IsGestor():
                return view('proyectos.gestor.index');
                break;

            case User::IsDinamizador():
                return view('proyectos.dinamizador.index', [
                    'gestores' => Gestor::ConsultarGestoresPorNodo(auth()->user()->dinamizador->nodo_id)->pluck('nombres_gestor', 'id'),
                ]);
                break;

            case User::IsAdministrador():
                return view('proyectos.administrador.index', [
                    'nodos' => Nodo::SelectNodo()->get(),
                ]);
                break;

            case User::IsTalento():
                return view('proyectos.talento.index');
                break;

            case User::IsInfocenter():
                return view('proyectos.infocenter.index', [
                    'gestores' => Gestor::ConsultarGestoresPorNodo(auth()->user()->infocenter->nodo_id)->pluck('nombres_gestor', 'id'),
                ]);
                break;

            default:
                return abort(Response::HTTP_FORBIDDEN);

                break;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        if (Session::get('login_role') == User::IsGestor()) {
            return view('proyectos.gestor.create', [
                'sublineas' => Sublinea::SubLineasDeUnaLinea(auth()->user()->gestor->lineatecnologica->id)->get()->pluck('nombre', 'id'),
                'areasconocimiento' => AreaConocimiento::ConsultarAreasConocimiento()->pluck('nombre', 'id'),
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
        $req = new ProyectoFaseInicioFormRequest;
        $validator = Validator::make($request->all(), $req->rules(), $req->messages());
        if ($validator->fails()) {
            return response()->json([
                'state'   => 'error_form',
                'errors' => $validator->errors(),
            ]);
        } else {
            $result = $this->getProyectoRepository()->store($request);
            if ($result) {
                return response()->json(['state' => 'registro']);
            } else {
                return response()->json(['state' => 'no_registro']);
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int  $id
     * @return \Illuminate\Http\Response
     * @author dum
     */
    public function inicio($id)
    {
        $proyecto = Proyecto::findOrFail($id);
        $historico = Actividad::consultarHistoricoActividad($proyecto->articulacion_proyecto->actividad->id)->get();
        $ultimo_movimiento = $historico->last();


        switch (Session::get('login_role')) {
            case User::IsGestor():
                return view('proyectos.gestor.fase_inicio', [
                    'sublineas' => Sublinea::SubLineasDeUnaLinea(auth()->user()->gestor->lineatecnologica->id)->get()->pluck('nombre', 'id'),
                    'areasconocimiento' => AreaConocimiento::ConsultarAreasConocimiento()->pluck('nombre', 'id'),
                    'proyecto' => $proyecto,
                    'historico' => $historico,
                    'ultimo_movimiento' => $ultimo_movimiento
                ]);
                break;

            case User::IsDinamizador():
                return view('proyectos.dinamizador.fase_inicio', [
                    'sublineas' => Sublinea::SubLineasDeUnaLinea($proyecto->asesor->lineatecnologica_id)->get()->pluck('nombre', 'id'),
                    'areasconocimiento' => AreaConocimiento::ConsultarAreasConocimiento()->pluck('nombre', 'id'),
                    'proyecto' => $proyecto,
                    'historico' => $historico,
                    'ultimo_movimiento' => $ultimo_movimiento
                ]);
                break;

            case User::IsTalento():
                return view('proyectos.talento.fase_inicio', [
                    'sublineas' => Sublinea::SubLineasDeUnaLinea($proyecto->asesor->lineatecnologica_id)->get()->pluck('nombre', 'id'),
                    'areasconocimiento' => AreaConocimiento::ConsultarAreasConocimiento()->pluck('nombre', 'id'),
                    'proyecto' => $proyecto,
                    'ultimo_movimiento' => $ultimo_movimiento,
                    'historico' => $historico
                ]);
                break;

            case User::IsAdministrador():
                return view('proyectos.administrador.fase_inicio', [
                    'proyecto' => $proyecto
                ]);
                break;

            case User::IsInfocenter():
                return view('proyectos.infocenter.fase_inicio', [
                    'proyecto' => $proyecto
                ]);
                break;

            default:
                return abort(Response::HTTP_FORBIDDEN);
                break;
        }
    }

    public function planeacion($id)
    {
        $proyecto = Proyecto::findOrFail($id);
        $historico = Actividad::consultarHistoricoActividad($proyecto->articulacion_proyecto->actividad->id)->get();
        $ultimo_movimiento = $historico->last();

        if ($proyecto->fase->nombre == 'Inicio') {
            Alert::error('Error!', 'El proyecto se encuentra en la fase de ' . $proyecto->fase->nombre . '!')->showConfirmButton('Ok', '#3085d6');
            return back();
        } else {
            if (Session::get('login_role') == User::IsGestor()) {
                return view('proyectos.gestor.fase_planeacion', [
                    'proyecto' => $proyecto,
                    'historico' => $historico,
                    'ultimo_movimiento' => $ultimo_movimiento
                ]);
            } else if (Session::get('login_role') == User::IsDinamizador()) {
                return view('proyectos.dinamizador.fase_planeacion', [
                    'proyecto' => $proyecto,
                    'historico' => $historico,
                    'ultimo_movimiento' => $ultimo_movimiento
                ]);
            } else if (Session::get('login_role') == User::IsTalento()) {
                return view('proyectos.talento.fase_planeacion', [
                    'proyecto' => $proyecto,
                    'historico' => $historico,
                    'ultimo_movimiento' => $ultimo_movimiento
                ]);
            } else if (Session::get('login_role') == User::IsAdministrador()) {
                return view('proyectos.administrador.fase_planeacion', [
                    'proyecto' => $proyecto,
                    'historico' => $historico
                ]);
            } else if (Session::get('login_role') == User::IsInfocenter()) {
                return view('proyectos.infocenter.fase_planeacion', [
                    'proyecto' => $proyecto,
                    'historico' => $historico
                ]);
            } else {
                return abort(Response::HTTP_FORBIDDEN);
            }
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
        $historico = Actividad::consultarHistoricoActividad($proyecto->articulacion_proyecto->actividad->id)->get();
        $ultimo_movimiento = $historico->last();
        if ($proyecto->fase->nombre == 'Inicio' || $proyecto->fase->nombre == 'Planeación') {
            Alert::error('Error!', 'El proyecto se encuentra en la fase de ' . $proyecto->fase->nombre . '!')->showConfirmButton('Ok', '#3085d6');
            return back();
        } else {
            switch (Session::get('login_role')) {
                case User::IsGestor():
                    return view('proyectos.gestor.fase_ejecucion', [
                        'proyecto' => $proyecto,
                        'historico' => $historico,
                        'ultimo_movimiento' => $ultimo_movimiento
                    ]);
                    break;
                case User::IsDinamizador():
                    return view('proyectos.dinamizador.fase_ejecucion', [
                        'proyecto' => $proyecto,
                        'historico' => $historico,
                        'ultimo_movimiento' => $ultimo_movimiento
                    ]);
                    break;
                case User::IsTalento():
                    return view('proyectos.talento.fase_ejecucion', [
                        'proyecto' => $proyecto,
                        'historico' => $historico,
                        'ultimo_movimiento' => $ultimo_movimiento
                    ]);
                    break;
                case User::IsAdministrador():
                    return view('proyectos.administrador.fase_ejecucion', [
                        'proyecto' => $proyecto,
                        'historico' => $historico
                    ]);
                    break;
                case User::IsInfocenter():
                    return view('proyectos.infocenter.fase_ejecucion', [
                        'proyecto' => $proyecto,
                        'historico' => $historico
                    ]);
                    break;
                default:
                    return abort(Response::HTTP_FORBIDDEN);
                    break;
            }
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
        if ($proyecto->fase->nombre == 'Inicio' || $proyecto->fase->nombre == 'Planeación' || $proyecto->fase->nombre == 'Ejecución') {
            Alert::error('Error!', 'El proyecto se encuentra en la fase de ' . $proyecto->fase->nombre . '!')->showConfirmButton('Ok', '#3085d6');
            return back();
        } else {
            $historico = Actividad::consultarHistoricoActividad($proyecto->articulacion_proyecto->actividad->id)->get();
            $ultimo_movimiento = $historico->last();
            $costo = $this->costoController->costoProject($proyecto->id);
            switch (Session::get('login_role')) {
                case User::IsGestor():
                    return view('proyectos.gestor.fase_cierre', [
                        'proyecto' => $proyecto,
                        'costo' => $costo,
                        'historico' => $historico,
                        'ultimo_movimiento' => $ultimo_movimiento
                    ]);
                    break;
                case User::IsDinamizador():
                    return view('proyectos.dinamizador.fase_cierre', [
                        'proyecto' => $proyecto,
                        'costo' => $costo,
                        'historico' => $historico,
                        'ultimo_movimiento' => $ultimo_movimiento
                    ]);
                    break;
                case User::IsTalento():
                    return view('proyectos.talento.fase_cierre', [
                        'proyecto' => $proyecto,
                        'costo' => $costo,
                        'historico' => $historico,
                        'ultimo_movimiento' => $ultimo_movimiento
                    ]);
                    break;
                case User::IsAdministrador():
                    return view('proyectos.administrador.fase_cierre', [
                        'proyecto' => $proyecto,
                        'costo' => $costo,
                        'historico' => $historico
                    ]);
                    break;
                case User::IsInfocenter():
                    return view('proyectos.infocenter.fase_cierre', [
                        'proyecto' => $proyecto,
                        'costo' => $costo,
                        'historico' => $historico
                    ]);
                    break;
                default:
                    return abort(Response::HTTP_FORBIDDEN);
                    break;
            }
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
        $historico = Actividad::consultarHistoricoActividad($proyecto->articulacion_proyecto->actividad->id)->get();
        switch (Session::get('login_role')) {
            case User::IsGestor():
                return view('proyectos.gestor.fase_suspendido', [
                    'proyecto' => $proyecto,
                    'historico' => $historico
                ]);
                break;

            case User::IsDinamizador():

                return view('proyectos.dinamizador.fase_suspendido', [
                    'proyecto' => $proyecto,
                    'historico' => $historico
                ]);
            default:
                return abort(Response::HTTP_FORBIDDEN);
                break;
        }
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
        $historico = Actividad::consultarHistoricoActividad($proyecto->articulacion_proyecto->actividad->id)->get();
        $gestores = $this->getGestorRepository()->consultarGestoresPorLineaTecnologicaYNodoRepository($proyecto->sublinea->lineatecnologica_id, auth()->user()->dinamizador->nodo_id)->pluck('gestor', 'id');
        switch (Session::get('login_role')) {
            case User::IsDinamizador();
                return view('proyectos.dinamizador.cambiar_gestor', [
                    'proyecto' => $proyecto,
                    'historico' => $historico,
                    'gestores' => $gestores
                ]);
                break;

            default:
                return abort(403);
                break;
        }
    }

    /**
     * Notifica al dinamizador para que apruebe el proyecto en la fase de inicio
     *
     * @param int $id Id del proyecto
     * @return Response
     * @author dum
     */
    public function solicitar_aprobacion(int $id, string $fase)
    {
        $notificacion = $this->getProyectoRepository()->notificarAlTalento_Inicio($id, $fase);
        if ($notificacion) {
            Alert::success('Notificación Exitosa!', 'Se le ha enviado una notificación al talento para que apruebe la fase de ' . $fase . ' del proyecto!')->showConfirmButton('Ok', '#3085d6');
        } else {
            Alert::error('Notificación Errónea!', 'No se le ha enviado una notificación al talento para que apruebe la fase de ' . $fase . ' del proyecto!')->showConfirmButton('Ok', '#3085d6');
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
        if (Session::get('login_role') == User::IsGestor()) {
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
                    return response()->json(['state' => 'update']);
                } else {
                    return response()->json(['state' => 'no_update']);
                }
            }
        }else{
            return abort(403);
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
    public function gestionarAprobacion(Request $request, $id, $fase)
    {
        $update = $this->getProyectoRepository()->aprobacionFaseInicio($request, $id, $fase);
        if ($update['state']) {
            Alert::success($update['title'], $update['mensaje'])->showConfirmButton('Ok', '#3085d6');
            return redirect('proyecto');
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
        if (Session::get('login_role') == User::IsGestor()) {
            $update = $this->getProyectoRepository()->updateEntregablesPlaneacionProyectoRepository($request, $id);
            if ($update) {
                Alert::success('Modificación Exitosa!', 'Los entregables del proyecto en la fase de planeación se han modificado!')->showConfirmButton('Ok', '#3085d6');
                return redirect('proyecto');
            } else {
                Alert::error('Modificación Errónea!', 'Los entregables del proyecto en la fase de planeación no se han modificado!')->showConfirmButton('Ok', '#3085d6');
                return back();
            }
        } else {
            if ($request->decision == 'aceptado') {
                $aprobar = $this->getProyectoRepository()->updateFaseProyecto($id, 'Ejecución');
                if ($aprobar) {
                    Alert::success('Modificación Exitosa!', 'El proyecto ha cambiado a fase de ejecución!')->showConfirmButton('Ok', '#3085d6');
                    return redirect('proyecto');
                } else {
                    Alert::error('Modificación Errónea!', 'El proyecto no ha cambiado a fase de ejecución!')->showConfirmButton('Ok', '#3085d6');
                    return back();
                }
            } else {
                $update = $this->getProyectoRepository()->noAprobarFaseProyecto($request, $id, 'Planeación');
                if ($update) {
                    Alert::success('Notificación Exitosa!', 'Se le ha notificado al experto del proyecto los motivos por los que no se aprueba esta fase del proyecto!')->showConfirmButton('Ok', '#3085d6');
                    return redirect('proyecto');
                } else {
                    Alert::error('Notificación Errónea!', 'No se ha podido enviar la notificación al experto del proyecto!')->showConfirmButton('Ok', '#3085d6');
                    return back();
                }
            }
        }
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
        if (Session::get('login_role') == User::IsGestor()) {
            $update = $this->getProyectoRepository()->updateEntregablesEjecucionProyectoRepository($request, $id);
            if ($update) {
                Alert::success('Modificación Exitosa!', 'Los entregables del proyecto en la fase de ejecución se han modificado!')->showConfirmButton('Ok', '#3085d6');
                return redirect('proyecto');
            } else {
                Alert::error('Modificación Errónea!', 'Los entregables del proyecto en la fase de ejecución no se han modificado!')->showConfirmButton('Ok', '#3085d6');
                return back();
            }
        } else {
            if ($request->decision == 'aceptado') {
                $update = $this->getProyectoRepository()->setPostCierreProyectoRepository($id);
                if ($update) {
                    Alert::success('Modificación Exitosa!', 'La fase de ejecución del proyecto se ha aprobado!')->showConfirmButton('Ok', '#3085d6');
                    return redirect('proyecto');
                } else {
                    Alert::error('Modificación Errónea!', 'La fase de ejecución del proyecto no se ha aprobado!')->showConfirmButton('Ok', '#3085d6');
                    return back();
                }
            } else {
                $update = $this->getProyectoRepository()->noAprobarFaseProyecto($request, $id, 'Ejecución');
                if ($update) {
                    Alert::success('Notificación Exitosa!', 'Se le ha notificado al experto del proyecto los motivos por los que no se aprueba esta fase del proyecto!')->showConfirmButton('Ok', '#3085d6');
                    return redirect('proyecto');
                } else {
                    Alert::error('Notificación Errónea!', 'No se ha podido enviar la notificación al experto del proyecto!')->showConfirmButton('Ok', '#3085d6');
                    return back();
                }
            }
        }
    }

    public function updateEntregables_Cierre(Request $request, $id)
    {
        $proyecto = Proyecto::findOrFail($id);
        if ($proyecto->fase->nombre == "Cierre") {
            if (Session::get('login_role') == User::IsGestor()) {
                $update = $this->getProyectoRepository()->updateEntregableCierreProyectoRepository($request, $id);
                if ($update) {
                    Alert::success('Modificación Exitosa!', 'Los entregables del proyecto en la fase de cierre se han modificado!')->showConfirmButton('Ok', '#3085d6');
                    return redirect('proyecto');
                } else {
                    Alert::error('Modificación Errónea!', 'Los entregables del proyecto en la fase de cierre no se han modificado!')->showConfirmButton('Ok', '#3085d6');
                    return back();
                }
            }
        } else {
            Alert::error('Error!', 'Este proyecto no está en fase de cierre!')->showConfirmButton('Ok', '#3085d6');
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
        if (Session::get('login_role') == User::IsGestor()) {
            $proyecto = Proyecto::findOrFail($id);
            if ($proyecto->articulacion_proyecto->actividad->aprobacion_dinamizador == 1) {

                $validator = Validator::make(
                    $request->all(),
                    [
                        'txtfecha_cierre' => 'required|date_format:"Y-m-d"',
                    ],
                    [
                        'txtfecha_cierre.required' => 'La fecha de cierre del proyecto es obligatoria.',
                        'txtfecha_cierre.date_format' => 'El formato de la fecha de cierre es incorrecto ("AAAA-MM-DD")'
                    ]
                );
                if ($validator->fails()) {
                    return response()->json([
                        'state'   => 'error_form',
                        'errors' => $validator->errors(),
                    ]);
                } else {
                    $cerrar = $this->getProyectoRepository()->cerrarProyecto($request, $proyecto);
                    if ($cerrar) {
                        return response()->json(['state' => 'update']);
                    } else {
                        return response()->json(['state' => 'no_update']);
                    }
                }
            } else {
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
                        return response()->json(['state' => 'update']);
                    } else {
                        return response()->json(['state' => 'no_update']);
                    }
                }
            }
        } else {
            if ($request->decision == 'aceptado') {
                $update = $this->getProyectoRepository()->updateAprobacionDinamizador($id);
                if ($update) {
                    Alert::success('Modificación Exitosa!', 'La fase de cierre se aprobó!')->showConfirmButton('Ok', '#3085d6');
                    return redirect('proyecto');
                } else {
                    Alert::error('Modificación Errónea!', 'La fase de cierre no se aprobó!')->showConfirmButton('Ok', '#3085d6');
                    return back();
                }
            } else {
                $update = $this->getProyectoRepository()->noAprobarFaseProyecto($request, $id, 'Cierre');
                if ($update) {
                    Alert::success('Notificación Exitosa!', 'Se le ha notificado al experto del proyecto los motivos por los que no se aprueba esta fase del proyecto!')->showConfirmButton('Ok', '#3085d6');
                    return redirect('proyecto');
                } else {
                    Alert::error('Notificación Errónea!', 'No se ha podido enviar la notificación al experto del proyecto!')->showConfirmButton('Ok', '#3085d6');
                    return back();
                }
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
        if (Session::get('login_role') == User::IsDinamizador()) {
            $update = $this->getProyectoRepository()->updateAprobacionSuspendido($id);
            if ($update) {
                Alert::success('Modificación Exitosa!', 'La fase de suspendido del proyecto se aprobó!')->showConfirmButton('Ok', '#3085d6');
                return redirect('proyecto');
            } else {
                Alert::error('Modificación Errónea!', 'La fase de suspendido del proyecto no se aprobó!')->showConfirmButton('Ok', '#3085d6');
                return back();
            }
        } else {
            $proyecto = Proyecto::findOrFail($id);
            if ($proyecto->articulacion_proyecto->aprobacion_dinamizador_suspender == 1) {
                $validator = Validator::make(
                    $request->all(),
                    [
                        'txtfecha_cierre' => 'required|date_format:"Y-m-d"',
                    ],
                    [
                        'txtfecha_cierre.required' => 'La fecha de cierre del proyecto es obligatoria.',
                        'txtfecha_cierre.date_format' => 'El formato de la fecha de cierre es incorrecto ("AAAA-MM-DD")'
                    ]
                );
                if ($validator->fails()) {
                    Alert::error('Modificación Errónea!', 'Estás ingresando mal la fecha de cierre!')->showConfirmButton('Ok', '#3085d6');
                    return back()
                        ->withErrors($validator)
                        ->withInput();
                }
                $suspender = $this->getProyectoRepository()->suspenderProyecto($request, $proyecto);
                if ($suspender) {
                    Alert::success('Modificación Exitosa!', 'El proyecto se ha suspendido!')->showConfirmButton('Ok', '#3085d6');
                    return redirect('proyecto');
                } else {
                    Alert::error('Modificación Errónea!', 'El proyecto no se ha suspendido!')->showConfirmButton('Ok', '#3085d6');
                    return back();
                }
            }
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
            return redirect('proyecto');
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
    public function updateReversar(Request $request, int $id, string $fase)
    {
        $proyecto = Proyecto::findOrFail($id);
        if ($proyecto->fase->nombre == $fase) {
            Alert::warning('El proyecto ya se encuentra en fase de '.$fase.'!', 'Modificación Errónea!')->showConfirmButton('Ok', '#3085d6');
            return back();
        } else {
            if ($proyecto->fase->nombre == 'Suspendido') {
                $update = $this->getProyectoRepository()->reversarProyecto($proyecto, $fase);
                if ($update) {
                    Alert::success('La fase del proyecto se ha reversado a '.$fase.'!', 'Modificación Exitosa!')->showConfirmButton('Ok', '#3085d6');
                    return redirect('proyecto');
                } else {
                    Alert::error('El proyecto no se ha reversado!', 'Modificación Errónea!')->showConfirmButton('Ok', '#3085d6');
                    return back();
                }
            } else {
                if (($proyecto->fase->nombre == 'Planeación' && $fase == 'Inicio')) {
                    $update = $this->getProyectoRepository()->reversarProyecto($proyecto, $fase);
                    if ($update) {
                        Alert::success('La fase del proyecto se ha reversado a '.$fase.'!', 'Modificación Exitosa!')->showConfirmButton('Ok', '#3085d6');
                        return redirect('proyecto');
                    } else {
                        Alert::error('El proyecto no se ha reversado!', 'Modificación Errónea!')->showConfirmButton('Ok', '#3085d6');
                        return back();
                    }
                } else {
                    if (($proyecto->fase->nombre == 'Ejecución' && $fase == 'Planeación') || ($proyecto->fase->nombre == 'Ejecución' && $fase == 'Inicio')) {
                        $update = $this->getProyectoRepository()->reversarProyecto($proyecto, $fase);
                        if ($update) {
                            Alert::success('La fase del proyecto se ha reversado a '.$fase.'!', 'Modificación Exitosa!')->showConfirmButton('Ok', '#3085d6');
                            return redirect('proyecto');
                        } else {
                            Alert::error('El proyecto no se ha reversado!', 'Modificación Errónea!')->showConfirmButton('Ok', '#3085d6');
                            return back();
                        }
                    } else {
                        if (($proyecto->fase->nombre == 'Cierre' && $fase == 'Ejecución') || ($proyecto->fase->nombre == 'Cierre' && $fase == 'Planeación') || ($proyecto->fase->nombre == 'Cierre' && $fase == 'Inicio')) {
                            $update = $this->getProyectoRepository()->reversarProyecto($proyecto, $fase);
                            if ($update) {
                                Alert::success('La fase del proyecto se ha reversado a '.$fase.'!', 'Modificación Exitosa!')->showConfirmButton('Ok', '#3085d6');
                                return redirect('proyecto');
                            } else {
                                Alert::error('El proyecto no se ha reversado!', 'Modificación Errónea!')->showConfirmButton('Ok', '#3085d6');
                                return back();
                            }
                        } else {
                            Alert::warning('El proyecto no se puede reversar a la fase de '.$fase.'!', 'Modificación Errónea!')->showConfirmButton('Ok', '#3085d6');
                            return back();
                        }
                    }
                }
            }
        }
    }

    /*===============================================
  =========================
  =            metodo para consultar los proyectos en ejecucion de un experto            =
  ========================================================================*/

    public function projectsForGestor($id)
    {

        $projects = $this->getProyectoRepository()->getProjectsForGestor($id, ['Inicio', 'Planeacion', 'En ejecución']);

        return response()->json([
            'projects' => $projects,
        ]);
    }

    /*=====  End of metodo para consultar los proyectos en ejecucion de un experto  ======*/

    /**
     * metodo para consultar el detalle de una actividad (proyecto- articulacion)
     * @author devjul
     */
    public function detailActivityByCode(string $code)
    {
        // if (request()->ajax()) {
            $actividad =  Actividad::with([
                'objetivos_especificos',

                'articulacion_proyecto.proyecto.asesor.user' => function ($query) {
                    $query->select('id', 'documento', 'nombres', 'apellidos', 'email', 'telefono', 'celular')->where('deleted_at', null)
                        ->orWhere('deleted_at', '!=', null);
                },
                'articulacion_proyecto.proyecto.asesor.user.gestor.lineatecnologica' => function ($query) {
                    $query->select('id', 'abreviatura', 'nombre');
                },
                'articulacion_proyecto.proyecto',

                'articulacion_proyecto.talentos',
                'articulacion_proyecto.talentos.user' => function ($query) {
                    $query->select('id', 'documento', 'nombres', 'apellidos', 'email', 'telefono', 'celular')->where('deleted_at', null)
                        ->orWhere('deleted_at', '!=', null);
                },
                'articulacion_proyecto.proyecto.sedes',
                'articulacion_proyecto.proyecto.sedes.empresa',
                'articulacion_proyecto.proyecto.gruposinvestigacion',
                'articulacion_proyecto.proyecto.gruposinvestigacion.entidad',
                'articulacion_proyecto.proyecto.users_propietarios',
                'articulacion_proyecto.proyecto',
                'articulacion_proyecto.proyecto.areaconocimiento',
                'articulacion_proyecto.proyecto.fase',
                'articulacion_proyecto.proyecto.sublinea',
                'articulacion_proyecto.proyecto.idea' => function ($query) {
                    $query->select('id', 'nombres_contacto', 'apellidos_contacto', 'correo_contacto', 'telefono_contacto', 'nombre_proyecto', 'codigo_idea');
                },
                'articulacion_proyecto.proyecto.nodo' => function ($query) {
                    $query->select('id', 'entidad_id', 'direccion', 'telefono');
                },
                'articulacion_proyecto.proyecto.nodo.entidad' => function ($query) {
                    $query->select('id', 'ciudad_id', 'nombre', 'email_entidad');
                },
                'edt',
                'edt.entidades',
                'edt.areaconocimiento',
                'edt.tipoedt',
                'edt.nodo' => function ($query) {
                    $query->select('id', 'entidad_id', 'direccion', 'telefono');
                },
                'edt.nodo.entidad' => function ($query) {
                    $query->select('id', 'ciudad_id', 'nombre', 'email_entidad');
                },
                'articulacion_proyecto.articulacion',
                'articulacion_proyecto.articulacion.productos',
                'articulacion_proyecto.articulacion.fase',


            ])->where('codigo_actividad', $code)->first();


            // $costo = $this->costoController->costosDeUnaActividad($actividad->id);
            $costo = 0;
            return response()->json([
                'data' => [
                    'actividad' => $actividad,
                    'costo' => $costo,
                    'total_usos' => $actividad->usoinfraestructuras->count(),
                ]
            ]);
        // }
        // return abort(Response::HTTP_FORBIDDEN);
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
                $query->select('id', 'gestor_id', 'nodo_id', 'codigo_actividad', 'nombre', 'objetivo_general', 'fecha_inicio', 'fecha_cierre');
            },
            'articulacion_proyecto.talentos',
            'articulacion_proyecto.talentos.user',
        ])->whereHas('articulacion_proyecto.actividad', function ($subQuery) use ($value) {
            $subQuery->where('codigo_actividad', $value);
        })
        ->whereIn('fase_id', [Fase::IsFinalizado(), Fase::IsEjecucion(), Fase::IsCierre()])
        ->first();

        if($proyecto != null){
            return response()->json([
                'data' => [
                    'proyecto' => $proyecto,
                    'status_code' => Response::HTTP_OK
                ]
            ],Response::HTTP_OK);
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
            case User::IsAdministrador():
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

        if (!empty($request->filter_year_pro)) {
            $proyectos = Proyecto::select('id','idea_id','fase_id','articulacion_proyecto_id','alcance_proyecto')
            ->with([
                'fase',
                'articulacion_proyecto' => function($query){
                    $query->select('id', 'actividad_id');
                },
                'articulacion_proyecto.actividad'=> function($query){
                    $query->select('id', 'gestor_id', 'nodo_id', 'codigo_actividad', 'nombre', 'objetivo_general', 'fecha_inicio', 'fecha_cierre');
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
                        $checkbox = '<a class="btn blue" onclick="filter_project.addProjectToArticulacion(\'' .($data->articulacion_proyecto->actividad->codigo_actividad) . '\')">
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

    /**
     * Asigna un valor a $entidadRepository
     * @param object $entidadRepository
     * @return void
     * @author dum
     */
    private function setEntidadRepository($entidadRepository)
    {
        $this->entidadRepository = $entidadRepository;
    }

    /**
     * Retorna el valor de $entidadRepository
     * @return object
     * @author dum
     */
    private function getEntidadRepository()
    {
        return $this->entidadRepository;
    }

    /**
     * Asigna un valor a $servidorVideoRepository
     * @param object $servidorVideoRepository
     * @return void
     * @author dum
     */
    private function setServidorVideoRepository($servidorVideoRepository)
    {
        $this->servidorVideoRepository = $servidorVideoRepository;
    }

    /**
     * Retorna el valor de $servidorVideoRepository
     * @return object
     * @author dum
     */
    private function getServidorVideoRepository()
    {
        return $this->servidorVideoRepository;
    }
}
