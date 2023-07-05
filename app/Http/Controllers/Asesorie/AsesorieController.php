<?php

namespace App\Http\Controllers\Asesorie;

use App\Http\Controllers\Controller;
use App\Http\Requests\UsoInfraestructura\UsoInfraestructuraFormRequest;
use App\Models\{Articulation,
    Idea,
    UsoInfraestructura,
    Proyecto,
    Nodo,
    Fase,
    Equipo,
    LineaTecnologica,
    Material};
use App\Datatables\AsesorieDatatable;
use App\Repositories\Repository\{LineaRepository, ProyectoRepository,  AsesorieRepository};
use App\Repositories\Repository\Articulation\ArticulationRepository;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Exports\Asesorie\AsesorieExport;

class AsesorieController extends Controller
{
    private $asesorieRepository;
    private $projectRepository;
    private $articulationRepository;
    private $lineRepository;

    public function __construct(
        AsesorieRepository $asesorieRepository,
        ProyectoRepository $projectRepository,
        ArticulationRepository $articulationRepository,
        LineaRepository $lineRepository
    ) {
        $this->asesorieRepository = $asesorieRepository;
        $this->projectRepository = $projectRepository;
        $this->articulationRepository = $articulationRepository;
        $this->lineRepository = $lineRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->user()->cannot('index', UsoInfraestructura::class)) {
            alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        $nodes = null;
        $modules = null;
        if(request()->user()->can('listNodes', UsoInfraestructura::class)) {
            $nodes = Nodo::SelectNodo()->get();
        }
        if(request()->user()->can('moduleType', UsoInfraestructura::class)) {
            switch(session()->get('login_role')){
                case User::IsAdministrador():
                    $modules = [
                        class_basename(Proyecto::class) => __('Projects'),
                        class_basename(Articulation::class) => __('Articulations'),
                        class_basename(Idea::class) => __('Ideas')
                    ];
                    break;
                case User::IsActivador():
                    $modules = [
                        class_basename(Proyecto::class) => __('Projects'),
                        class_basename(Articulation::class) => __('Articulations'),
                        class_basename(Idea::class) => __('Ideas')
                    ];
                    break;
                case User::IsDinamizador():
                    $modules = [
                        class_basename(Proyecto::class) => __('Projects'),
                        class_basename(Articulation::class) => __('Articulations'),
                        class_basename(Idea::class) => __('Ideas')
                    ];
                    break;
                case User::IsExperto():
                    $modules = [
                        class_basename(Proyecto::class) => __('Projects'),
                    ];
                    break;
                case User::IsArticulador():
                    $modules = [
                        class_basename(Articulation::class) => __('Articulations'),
                        class_basename(Idea::class) => __('Ideas')
                    ];
                    break;
                case User::IsTalento():
                    $modules = [
                        class_basename(Proyecto::class) => __('Projects'),
                        class_basename(Articulation::class) => __('Articulations')
                    ];
                    break;
                default:
                    $modules = [];
                    break;
            }
        }
        return view('asesorias.index', [
            'nodos' => $nodes,
            'modules' => $modules
        ]);
    }

    /**
     * method to show return the datatables asesories
     * @return void
     */
    public function datatableFiltros(Request $request, AsesorieDatatable $asesorieDatatable)
    {
        if (request()->ajax() && request()->user()->cannot('index', UsoInfraestructura::class)) {
            alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
            return $asesorieDatatable->indexDatatable([]);
        }
        $asesor = $this->checkRoleAuth($request)['user'];
        $node = $this->checkRoleAuth($request)['node'];
        $model = $this->checkRoleAuth($request)['model'];

        $asesories = [];
        if (isset($request->filter_module) || isset($request->filter_node) || isset($request->filter_year) || isset($request->start_date) || isset($request->end_date)) {
            $asesories = $this->asesorieRepository->getListAsesories()
            ->selectAsesoria($model)
            ->joins($model)
            ->node($model, $node)
            ->betweenDate($request->start_date, $request->end_date)
            ->asesor($model,$asesor)
            ->groupBy('usoinfraestructuras.id')
            ->orderBy('usoinfraestructuras.updated_at', 'desc')
            ->get();
        }
        return $asesorieDatatable->indexDatatable($asesories);
    }

    /**
     * method to validate the authenticated role
     * @return void
     */
    private function checkRoleAuth($request)
    {
        $user = null;
        $node = null;
        $model = null;
        switch (\Session::get('login_role')) {
            case User::IsAdministrador():
                $node = $request->filter_nodo;
                $model = $request->filter_module;
                break;
            case User::IsActivador():
                $node = $request->filter_nodo;
                $model = $request->filter_module;
                break;
            case User::IsDinamizador():
                $node = [auth()->user()->dinamizador->nodo_id];
                $model = $request->filter_module;
                break;
            case User::IsArticulador():
                $node = [auth()->user()->articulador->nodo_id];
                $model = $request->filter_module;
                break;
            case User::IsExperto():
                $node = [auth()->user()->experto->nodo_id];
                $user = auth()->user()->id;
                $model = class_basename(Proyecto::class);
                break;
            case User::IsApoyoTecnico():
                $node = [auth()->user()->apoyotecnico->nodo_id];
                $user = auth()->user()->id;
                $model = class_basename(Proyecto::class);
                break;
            case User::IsTalento():
                $node = null;
                $user = auth()->user()->id;
                $model = $request->filter_module;
                break;
            default:
                $user = null;
                $node = null;
                $model = null;
                break;
        }
        return ['user' => $user, 'node' => $node, 'model' => $model];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($code)
    {
        $asesorie = UsoInfraestructura::query()
        ->with(['participantes'=> function($query){
                $query->withTrashed();
            },
            'asesores' => function($query){
                $query->withTrashed();
            },
            'usoequipos'
        ])
        ->where('codigo', $code)->firstOrFail();
        if (request()->user()->cannot('show',$asesorie)) {
            alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
            return redirect()->back();
        }
        $devices = [];
        if ($asesorie->has('usoequipos')) {
            $devices = $asesorie->usoequipos()->withTrashed()->get();
        }
        $totalCosts = 0;
        $totalCosts = $asesorie->usoequipos->sum('pivot.costo_equipo') + $asesorie->asesores->sum('pivot.costo_asesoria') + $asesorie->usoequipos->sum('pivot.costo_administrativo') + $asesorie->usomateriales->sum('pivot.costo_material');

        return view('asesorias.show', [
            'asesorie' => $asesorie,
            'devices' => $devices,
            'totalCosts' => $totalCosts,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $code
     * @return \Illuminate\Http\Response
     */
    public function edit($code)
    {
        $asesorie = UsoInfraestructura::with(
            ['participantes'=> function($query){
                $query->withTrashed();
            },'asesores' => function($query){
                $query->withTrashed();
            }]
        )->where('codigo', $code)->firstOrFail();
        if (request()->user()->cannot('update',$asesorie)) {
            alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
            return redirect()->back();
        }
        $devices = [];
        if ($asesorie->has('usoequipos')) {
            $devices = $asesorie->usoequipos()->withTrashed()->get();
        }
        $date = Carbon::now()->format('Y-m-d');
        switch (\Session::get('login_role')) {
            case User::IsExperto():
                $relations = [
                    'user'             => function ($query) {
                        $query->select('id', 'documento', 'nombres', 'apellidos');
                    },
                    'lineatecnologica' => function ($query) {
                        $query->select('id', 'nombre', 'abreviatura');
                    },
                ];
                $user             = auth()->user()->id;
                $nodo             = auth()->user()->experto->nodo->id;
                $gestores         = $this->getGestorRepository()->getInfoGestor($relations)
                    ->whereHas('user', function ($query) use ($user) {
                        $query->where('id', '!=', $user)->where('estado', User::IsActive());
                    })
                    ->whereHas('nodo', function ($query) use ($nodo) {
                        $query->where('id', $nodo);
                    })->get();
                $lineastecnologicas = $this->getLineaTecnologicaRepository()->findLineasByIdNameForNodo($nodo);
            break;
            case User::IsArticulador():
                $artulaciones = 0;
                $sumasArray = [
                    'articulaciones' => $artulaciones,
                ];
                $cantActividades = array_sum($sumasArray);
                $relations = [
                    'user'             => function ($query) {
                        $query->select('id', 'documento', 'nombres', 'apellidos');
                    },
                    'lineatecnologica' => function ($query) {
                        $query->select('id', 'nombre', 'abreviatura');
                    },
                ];
                $user             = auth()->user()->id;
                $nodo             = auth()->user()->articulador->nodo->id;
                $gestores         = $this->getGestorRepository()->getInfoGestor($relations)
                    ->whereHas('user', function ($query) use ($user) {
                        $query->where('id', '!=', $user)->where('estado', User::IsActive());
                    })
                    ->whereHas('nodo', function ($query) use ($nodo) {
                        $query->where('id', $nodo);
                    })->get();
                $lineastecnologicas = $this->getLineaTecnologicaRepository()->findLineasByIdNameForNodo($nodo);
                break;
            case User::IsApoyoTecnico():
                $projects     = $this->getDataProjectsForUser()->count();
                $sumasArray = [
                    'projects'       => $projects,
                ];
                $cantActividades = array_sum($sumasArray);
                $relations = [
                    'user'             => function ($query) {
                        $query->select('id', 'documento', 'nombres', 'apellidos');
                    },
                    'lineatecnologica' => function ($query) {
                        $query->select('id', 'nombre', 'abreviatura');
                    },
                ];
                $user             = auth()->user()->id;
                $nodo             = auth()->user()->apoyotecnico->nodo->id;
                $gestores         = $this->getGestorRepository()->getInfoGestor($relations)
                    ->whereHas('user', function ($query) use ($user) {
                        $query->where('id', '!=', $user)->where('estado', User::IsActive());
                    })
                    ->whereHas('nodo', function ($query) use ($nodo) {
                        $query->where('id', $nodo);
                    })->get();
                $lineastecnologicas = $this->getLineaTecnologicaRepository()->findLineasByIdNameForNodo($nodo);
                break;
            case User::IsTalento():
                $projects     = $this->getDataProjectsForUser()->count();
                $sumasArray = [
                    'projects'       => $projects,
                ];
                $cantActividades = array_sum($sumasArray);
                return view('asesorias.edit', [
                    'usoinfraestructura' => $asesorie,
                    'equipos' => $devices,
                    'date'                => $date,
                    'cantidadActividades' => $cantActividades,
                ]);
                break;
            default:
                return abort('403');
                break;
        }

        return view('asesorias.edit', [
            'usoinfraestructura' => $asesorie,
            'gestores'           => $gestores,
            'lineastecnologicas' => $lineastecnologicas,
            'equipos' => $devices,
            'date'               => $date,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Request $request, $id)
    {
        $usoinfraestructura = UsoInfraestructura::findOrFail($id);
        if (request()->user()->cannot('update',$usoinfraestructura)) {
            alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
            return redirect()->back();
        }
        $req       = new UsoInfraestructuraFormRequest;
        $validator = Validator::make($request->all(), $req->rules(), $req->messages());

        if ($validator->fails()) {
            return response()->json([
                'fail'   => true,
                'errors' => $validator->errors(),
            ]);
        }

        $result = $this->getUsoInfraestructuraRepository()->update($request, $id);

        if ($result == false) {
            return response()->json([
                'fail'         => false,
                'redirect_url' => false,
            ]);
        } else if ($result == true) {
            return response()->json([
                'fail'         => false,
                'redirect_url' => url(route('asesorias.index')),
            ]);
        }
    }

    /**
     * retorna query con las articulaciones en fase Inicio, En ejecuci車n por usuarios
     * @return collection
     */
    public function articulacionesForUser()
    {
        $artulaciones = $this->getDataArticulaciones();
        if (request()->ajax()) {
            return datatables()->of($artulaciones)
                ->addColumn('checkbox', function ($data) {
                    $checkbox = '
                    <a class="btn cyan m-b-xs" onclick="asociarArticulacionAUsoInfraestructura(' . $data->id . ', \'' . $data->present()->articulationCode() . '\', \'' . $this->reemplezarComillas($data->present()->articulationName()) . '\')">
                        <i class="material-icons">done_all</i>
                    </a>';
                    return $checkbox;
                })->editColumn('codigo_actividad', function ($data) {
                    return $data->present()->articulationCode();
                })
                ->editColumn('nombre', function ($data) {
                    return $data->present()->articulationName();
                })
                ->editColumn('fase', function ($data) {
                    return $data->present()->articulationPhase();
                })
                ->rawColumns(['checkbox', 'codigo_actividad', 'nombre', 'fase'])->make(true);
        } else {
            abort('403');
        }
    }

    private function getDataArticulaciones()
    {
        $user = auth()->user()->documento;

        $fase = [
            Fase::IsInicio(),
            Fase::IsEjecucion(),
            Fase::IsCierre(),
        ];

        $relations = [
            'phase'                => function ($query) {
                $query->select('id', 'nombre');
            },
        ];

        if (Session::has('login_role') && Session::get('login_role') == User::IsExperto()) {
            return [];
        }elseif(Session::has('login_role') && Session::get('login_role') == User::IsArticulador()) {
            return   Articulation::query()->with($relations)
                        ->whereHas('articulationstage', function ($query) {
                            $query->where('node_id', auth()->user()->articulador->nodo_id);
                        })
                        ->whereIn('phase_id', $fase)
                        ->get();
        }
        elseif (Session::has('login_role') && Session::get('login_role') == User::IsTalento()) {
            return Articulation::query()->with($relations)
                ->whereHas('users', function ($query) use ($user) {
                    $query->where('documento', $user);
                })
                ->whereIn('fase_id', $fase)
                ->get();
        } else {
            response()->json([
                'error' => 'no tienes permisos'
            ]);
        }
    }

    /**
     * retorna string sin comillas dobles
     * @param string $data
     * @return string
     **/
    private function reemplezarComillas($data)
    {
        return str_replace('"', '', $data);
    }


    private function getDataProjectsForUser()
    {
        $user = auth()->user()->documento;

        $fase = [
            Fase::IsInicio(),
            Fase::IsPlaneacion(),
            Fase::IsEjecucion(),
        ];

        $relations = [
            'asesor',
            'asesor.user',
            'articulacion_proyecto'               => function ($query) {
                $query->select('id', 'actividad_id');
            },
            'articulacion_proyecto.actividad'     => function ($query) {
                $query->select('id', 'codigo_actividad', 'nombre', 'fecha_inicio');
            },
            'articulacion_proyecto.talentos.user' => function ($query) {
                $query->select('id', 'documento', 'nombres', 'apellidos');
            },
        ];

        if (Session::has('login_role') && Session::get('login_role') == User::IsExperto()) {

            return $this->getUsoIngraestructuraProyectoRepository()->getProjectsForFaseById($relations, $fase)
                ->whereHas('asesor.user', function ($query) use ($user) {
                    $query->where('documento', $user);
                })
                ->get();
        }else if(Session::has('login_role') && Session::get('login_role') == User::IsApoyoTecnico()){
            return $this->getUsoIngraestructuraProyectoRepository()->getProjectsForFaseById($relations, $fase)
                ->whereHas('nodo', function($query){
                    $query->where('id', auth()->user()->apoyotecnico->nodo->id);
                })->get();
        } else if (Session::has('login_role') && Session::get('login_role') == User::IsTalento()) {

            return $this->getUsoIngraestructuraProyectoRepository()->getProjectsForFaseById($relations, $fase)
                ->whereHas('articulacion_proyecto.talentos.user', function ($query) use ($user) {
                    $query->where('documento', $user);
                })
                ->get();
        }else if (Session::has('login_role') && Session::get('login_role') == User::IsArticulador()){
            return [];
        }
        else {
            abort('403');
        }
    }



    /**
     * devuelve consulta con los talentos por proyecto
     * @param int $id
     * @return collection
     */
    public function talentosPorProyecto(int $id)
    {
        if (request()->ajax()) {

            $fase = [
                Fase::IsInicio(),
                Fase::IsPlaneacion(),
                Fase::IsEjecucion(),
            ];

            $proyectoNodo = Proyecto::findOrFail($id)->nodo_id;

            $proyectoTalento = Proyecto::select('proyectos.*', 'actividades.id as actividad_id', 'proyectos.asesor_id as actividad_gestor_id',
            'proyectos.nodo_id as actividad_nodo_id', 'actividades.codigo_actividad', 'actividades.nombre as actividades_nombre', 'gestores.id as gestor_id',
            'gestores.lineatecnologica_id as gestor_lineatecnologica_id', 'gestores.honorarios', 'users.id as user_id', 'users.documento', 'users.nombres',
            'users.apellidos', 'nodos.id as nodo_id', 'lineastecnologicas.abreviatura', 'lineastecnologicas.id as lineatecnologica_id',
            'lineastecnologicas.nombre as lineatecnologica_nombre')
                ->join('fases', 'fases.id', '=', 'proyectos.fase_id')
                ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'proyectos.articulacion_proyecto_id')
                ->join('gestores', 'gestores.id', '=', 'proyectos.asesor_id')
                ->join('lineastecnologicas', 'lineastecnologicas.id', '=', 'gestores.lineatecnologica_id')
                ->join('users', 'users.id', '=', 'gestores.user_id')
                ->join('nodos', 'nodos.id', '=', 'proyectos.nodo_id')
                ->whereIn('fases.id', $fase)
                ->findOrFail($id);

            $lineastecnologicas = LineaTecnologica::join('lineastecnologicas_nodos', 'lineastecnologicas_nodos.linea_tecnologica_id', '=', 'lineastecnologicas.id')
                ->where('lineastecnologicas_nodos.nodo_id', $proyectoNodo)
                ->get();



            $equipos = Equipo::where('lineatecnologica_id', $proyectoTalento->gestor_lineatecnologica_id)
                ->where('nodo_id', $proyectoNodo)
                ->get();

            $materiales = Material::select('materiales.id as material_id', 'materiales.codigo_material', 'materiales.nombre as material_nombre', 'materiales.marca as material_marca', 'presentaciones.nombre as presentacion_nombre', 'medidas.nombre as medida_nombre')
                ->join('presentaciones', 'presentaciones.id', 'materiales.presentacion_id')
                ->join('medidas', 'medidas.id', 'materiales.medida_id')
                ->where('materiales.lineatecnologica_id', $proyectoTalento->gestor_lineatecnologica_id)
                ->where('materiales.nodo_id', $proyectoNodo)
                ->get();

            $talentos = Talento::select('talentos.id', 'users.id as user_id', 'users.documento', 'users.nombres', 'users.apellidos')
                ->join('users', 'users.id', '=', 'talentos.user_id')
                ->join('articulacion_proyecto_talento', 'articulacion_proyecto_talento.talento_id', '=', 'talentos.id')
                ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'articulacion_proyecto_talento.articulacion_proyecto_id')
                ->join('proyectos', 'proyectos.articulacion_proyecto_id', '=', 'articulacion_proyecto.id')
                ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
                ->where('proyectos.id', $proyectoTalento->id)
                ->whereHas('user', function ($query) {
                    $query->withTrashed();
                })
                ->get();

            return response()->json([
                'proyecto'           => $proyectoTalento,
                'lineastecnologicas' => $lineastecnologicas,
                'gestores'           => $gestores,
                'equipos'            => $equipos,
                'materiales'         => $materiales,
                'talentos'           => $talentos,
            ]);
        } else {
            abort('403');
        }
    }

    /**
     * devuelve consulta con los talentos por artculacion emprendedores
     * @param int $id
     * @return collection
     */
    public function talentosPorArticulacion(int $id)
    {
        if (request()->ajax()) {
            $articulacionNodo = Articulation::findOrFail($id)->articulationstage->node->id;
            $fase = [
                Fase::IsInicio(),
                Fase::IsEjecucion(),
                Fase::IsCierre(),
            ];

            $articulacion = Articulation::with([
                'articulationstage.createdBy'=> function($query){
                    $query->select('id', 'documento', 'nombres', 'apellidos');
                }])
                ->whereIn('phase_id', $fase)
                ->findOrFail($id);

            $lineastecnologicas = LineaTecnologica::join('lineastecnologicas_nodos', 'lineastecnologicas_nodos.linea_tecnologica_id', '=', 'lineastecnologicas.id')
                ->where('lineastecnologicas_nodos.nodo_id', $articulacionNodo)
                ->get();

            $equipos = Equipo::where('nodo_id', $articulacionNodo)->get();

            $materiales = Material::select('materiales.id as material_id', 'materiales.codigo_material', 'materiales.nombre as material_nombre', 'materiales.marca as material_marca', 'presentaciones.nombre as presentacion_nombre', 'medidas.nombre as medida_nombre')
                ->join('presentaciones', 'presentaciones.id', 'materiales.presentacion_id')
                ->join('medidas', 'medidas.id', 'materiales.medida_id')
                ->where('materiales.nodo_id', $articulacionNodo)
                ->get();

            $talentos = $articulacion->users()->get();

            return response()->json([
                'articulacion'       => $articulacion,
                'lineastecnologicas' => $lineastecnologicas,
                'equipos'            => $equipos,
                'materiales'         => $materiales,
                'talentos' => $talentos
            ]);
        } else {
            abort('403');
        }
    }


    /**
     * retorna query con los proyectos en fase Inicio, planeacion, En ejecucion por usuarios
     * @return object
     */
    public function projectsForUser()
    {
        $projects = $this->getDataProjectsForUser();

        if (request()->ajax()) {

            return datatables()->of($projects)
                ->addColumn('checkbox', function ($data) {
                    $checkbox = '<a class="btn cyan m-b-xs" onclick="asociarProyectoAUsoInfraestructura(' . $data->id . ', \'' . $data->codigo_proyecto . '\', \'' . $this->reemplezarComillas($data->nombre) . '\')">
                        <i class="material-icons">done_all</i>
                    </a>';
                    return $checkbox;
                })->editColumn('codigo_actividad', function ($data) {
                    return $data->codigo_proyecto;
                })
                ->editColumn('nombre', function ($data) {
                    return $data->nombre;
                })
                ->editColumn('fase', function ($data) {
                    return $data->present()->proyectoFase();
                })
                ->rawColumns(['checkbox', 'codigo_actividad', 'nombre','fase'])->make(true);
        } else {
            abort('403');
        }
    }


    public function activitiesByAnio($anio = null)
    {
        $activities = [];
        if (Session::get('login_role') == User::IsExperto()) {
            $gestor = auth()->user()->experto->id;
            if ((!empty($anio) && $anio != null && $anio != 'all')) {

                $activities =  Actividad::select('id')
                    ->selectRaw('CONCAT(codigo_actividad, " - ", nombre) as nombre')
                    ->whereHas('articulacion_proyecto.proyecto.asesor', function ($query) use ($gestor) {
                        $query->where('id', $gestor);
                    })
                    ->where(function ($query) use ($anio) {
                        $query->whereYear('fecha_inicio', $anio)->orWhereYear('fecha_cierre', $anio);
                    })
                    ->pluck('nombre', 'id');

            } elseif ((!empty($anio) && $anio != null && $anio == 'all')) {
                // $activities =  Actividad::select('id')
                //     ->selectRaw('CONCAT(codigo_actividad, " - ", nombre) as nombre')
                //     ->whereHas( function ($query) use ($gestor) {
                //         $query->where('id', $gestor);
                //     })
                //     ->pluck('nombre', 'id');
            }
        } elseif (Session::get('login_role') == User::IsTalento()) {
            $user = auth()->user()->id;
            if ((!empty($anio) && $anio != null && $anio != 'all')) {
                $activities =  Actividad::select('id')
                    ->selectRaw('CONCAT(codigo_actividad, " - ", nombre) as nombre')
                    ->where(function ($query) use ($user) {
                        $query->whereHas('articulacion_proyecto.talentos.user', function ($subquery) use ($user) {
                            $subquery->where('id', $user);
                        });
                    })
                    ->where(function ($query) use ($anio) {
                        $query->whereYear('fecha_inicio', $anio)
                            ->orWhereYear('fecha_cierre', $anio);
                    })->pluck('nombre', 'id');
            } elseif ((!empty($anio) && $anio != null && $anio == 'all')) {
                $activities =  Actividad::select('id')
                    ->selectRaw('CONCAT(codigo_actividad, " - ", nombre) as nombre')
                    ->where(function ($query) use ($user) {
                        $query->whereHas('articulacion_proyecto.talentos.user', function ($subquery) use ($user) {
                            $subquery->where('id', $user);
                        });
                    })->pluck('nombre', 'id');
            }
        }

        return response()->json([
            'actividades' => $activities
        ], 200);
    }


    public function destroy(int $id)
    {
        $usoinfraestructura = UsoInfraestructura::findOrFail($id);
        if (request()->user()->cannot('destroy',$usoinfraestructura)) {
            alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
            return redirect()->back();
        }
        $usoinfraestructura->usoequipos()->detach();
        $usoinfraestructura->participantes()->detach();
        $usoinfraestructura->usomateriales()->detach();
        $usoinfraestructura->asesores()->detach();
        $usoinfraestructura->delete();
        return response()->json([
            'usoinfraestructura' => 'success',
            'route' => route('asesorias.index')
        ]);
    }

    public function export(Request $request, $extension = 'xlsx')
    {
        if (request()->user()->cannot('export',UsoInfraestructura::class)) {
            alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        $asesor = $this->checkRoleAuth($request)['user'];
        $node = $this->checkRoleAuth($request)['node'];
        $model = $this->checkRoleAuth($request)['model'];

        $asesories = [];
        if (isset($request->filter_module) || isset($request->filter_node) || isset($request->filter_year)) {
            $asesories = $this->asesorieRepository->getListAsesories()
            ->selectAsesoria($model)
            ->selectRaw("usoinfraestructuras.descripcion, usoinfraestructuras.compromisos")
            ->selectRaw("GROUP_CONCAT(DISTINCT CONCAT(equipos.referencia, ' - ', equipos.nombre) SEPARATOR ';') as equipos,
            GROUP_CONCAT(DISTINCT CONCAT(materiales.codigo_material, ' - ', materiales.nombre) SEPARATOR ';') as materiales")
            ->joins($model)
            ->leftJoin('equipo_uso', function ($join) {
                $join->on('equipo_uso.usoinfraestructura_id', '=', 'usoinfraestructuras.id');
            })->leftJoin('equipos', function ($join) {
                $join->on('equipos.id', '=', 'equipo_uso.equipo_id');
            })->leftJoin('material_uso', function ($join) {
                $join->on('material_uso.usoinfraestructura_id', '=', 'usoinfraestructuras.id');
            })->leftJoin('materiales', function ($join) {
                $join->on('materiales.id', '=', 'material_uso.material_id');
            })
            ->node($model, $node)
            ->year($model, $request->filter_year)
            ->asesor($model,$asesor)
            ->groupBy('usoinfraestructuras.id')
            ->orderBy('usoinfraestructuras.updated_at', 'desc')
            ->get();
        }
        return (new AsesorieExport($request, $asesories))->download("Asesorias" . config('app.name') . ".{$extension}");
    }

    /**
     * retorna query con las ideas
     * @return collection
     */
    public function ideasForNode()
    {
        $ideas = $this->getDataIdeas();
        if (request()->ajax()) {
            return datatables()->of($ideas)
                ->addColumn('checkbox', function ($data) {
                    $checkbox = '
                    <a class="btn cyan m-b-xs" onclick="asociarIdeaAUsoInfraestructura(' . $data->id . ', \'' . $data->present()->ideaCode() . '\', \'' . $this->reemplezarComillas($data->present()->ideaName()) . '\')">
                        <i class="material-icons">done_all</i>
                    </a>';
                    return $checkbox;
                })->editColumn('codigo_idea', function ($data) {
                    return $data->present()->ideaCode();
                })
                ->editColumn('nombre_proyecto', function ($data) {
                    return $data->present()->ideaName();
                })
                ->editColumn('estadoIdea', function ($data) {
                    return $data->estadoIdea->nombre;
                })
                ->rawColumns(['checkbox', 'codigo_idea', 'nombre_proyecto', 'estadoIdea'])->make(true);
        } else {
            abort('403');
        }
    }

    private function getDataIdeas()
    {
        $fase = [
            \App\Models\EstadoIdea::IsRegistro(),
            \App\Models\EstadoIdea::IsConvocado(),
            \App\Models\EstadoIdea::IsPostulado(),
        ];
        $relations = [
            'estadoIdea'                => function ($query) {
                $query->select('id', 'nombre');
            },
        ];
        if(Session::has('login_role') && Session::get('login_role') == User::IsArticulador()) {
            $user = auth()->user()->articulador;
            return $this->getUsoInfraestructuraRepository()
                ->getIdeasForUser($relations)
                ->whereHas('nodo', function ($query) use ($user) {
                    $query->where('id', $user->nodo_id);
                })
                ->whereHas('estadoIdea',function($query)use ($fase){
                    $query->whereIn('nombre', $fase);
                })->get();
        } else {
            response()->json([
                'error' => 'no tienes permisos'
            ]);
        }
    }

    public  function infoidea(int $id)
    {
        if (request()->ajax()) {
            $relations = [
                'estadoIdea'                => function ($query) {
                    $query->select('id', 'nombre');
                },
            ];
            $idea = $this->getUsoInfraestructuraRepository()
                ->getIdeasForUser($relations)
                ->findOrFail($id);
            return response()->json([
                'idea'       => $idea,
            ]);
        } else {
            abort('403');
        }
    }
}
