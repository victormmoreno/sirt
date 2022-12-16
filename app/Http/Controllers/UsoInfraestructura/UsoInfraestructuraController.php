<?php

namespace App\Http\Controllers\UsoInfraestructura;

use App\Http\Controllers\Controller;
use App\Http\Requests\UsoInfraestructura\UsoInfraestructuraFormRequest;
use App\Models\{Articulation,
    Idea,
    UsoInfraestructura,
    Actividad,
    Talento,
    Proyecto,
    Nodo,
    Fase,
    Equipo,
    Gestor,
    LineaTecnologica,
    Material,
    Entidad};
use App\Datatables\UsoInfraestructuraDatatable;
use App\Repositories\Repository\UserRepository\GestorRepository;
use App\Repositories\Repository\{LineaRepository, ProyectoRepository,  UsoInfraestructuraRepository};
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Exports\UsoInfraestructura\UsoInfraestructuraExport;

class UsoInfraestructuraController extends Controller
{
    private $UsoInfraestructuraProyectoRepository;
    private $UsoInfraestructuraArticulacionRepository;
    private $UsoInfraestructuraRepository;
    private $lineaRepository;
    private $proyectoRepository;

    public function __construct(
        ProyectoRepository $UsoInfraestructuraProyectoRepository,
        UsoInfraestructuraRepository $UsoInfraestructuraRepository,
        GestorRepository $gestorRepository,
        LineaRepository $lineaRepository,
        ProyectoRepository $proyectoRepository
    ) {
        $this->setUsoIngraestructuraProyectoRepository($UsoInfraestructuraProyectoRepository);
        $this->setUsoInfraestructuraRepository($UsoInfraestructuraRepository);
        $this->setGestorRepository($gestorRepository);
        $this->setLineaTecnologicaRepository($lineaRepository);
        $this->setProyectoRepository($proyectoRepository);
    }

    /**
     * Asigna un valor a $UsoInfraestructuraProyectoRepository
     * @param object $UsoInfraestructuraProyectoRepository
     * @return void
     * @author devjul
     */
    private function setUsoIngraestructuraProyectoRepository($UsoInfraestructuraProyectoRepository)
    {
        $this->UsoInfraestructuraProyectoRepository = $UsoInfraestructuraProyectoRepository;
    }

    /**
     * Retorna el valor de $UsoInfraestructuraProyectoRepository
     * @return object
     * @author devjul
     */
    private function getUsoIngraestructuraProyectoRepository()
    {
        return $this->UsoInfraestructuraProyectoRepository;
    }


    /**
     * Asigna un valor a $UsoInfraestructuraRepository
     * @param object $UsoInfraestructuraRepository
     * @return void
     * @author devjul
     */
    private function setUsoInfraestructuraRepository($UsoInfraestructuraRepository)
    {
        $this->UsoInfraestructuraRepository = $UsoInfraestructuraRepository;
    }

    /**
     * Retorna el valor de $UsoInfraestructuraRepository
     * @return object
     * @author devjul
     */
    private function getUsoInfraestructuraRepository()
    {
        return $this->UsoInfraestructuraRepository;
    }

    /**
     * Asigna un valor a $gestorRepository
     * @param object $gestorRepository
     * @return void
     * @author devjul
     */
    private function setGestorRepository($gestorRepository)
    {
        $this->gestorRepository = $gestorRepository;
    }

    /**
     * Retorna el valor de $gestorRepository
     * @return object
     * @author devjul
     */
    private function getGestorRepository()
    {
        return $this->gestorRepository;
    }

    /**
     * Asigna un valor a $lineaRepository
     * @param object $lineaRepository
     * @return void
     * @author devjul
     */
    private function setLineaTecnologicaRepository($lineaRepository)
    {
        $this->lineaRepository = $lineaRepository;
    }

    /**
     * Retorna el valor de $lineaRepository
     * @return object
     * @author devjul
     */
    private function getLineaTecnologicaRepository()
    {
        return $this->lineaRepository;
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, UsoInfraestructuraDatatable $usoDatatable)
    {

        if (request()->user()->cannot('index',UsoInfraestructura::class)) {
            alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        $asesorUser = $this->checkRoleAuth($request)['user'];
        $nodeUser = $this->checkRoleAuth($request)['node'];
        $model = $this->checkRoleAuth($request)['model'];

        if ($request->ajax()) {
            $usos = [];
            if (($request->filled('filter_nodo') || $request->filter_nodo == null)  && ($request->filled('filter_year') || $request->filter_year == null)) {

                $usos = UsoInfraestructura::query()


                    ->selectAsesoria($model)
                    ->joins($model)
                    ->nodoAsesoriaQuery($model, $nodeUser)
                    ->yearAsesoriaQuery($model, $request->filter_year)
                    ->asesorQuery($model, $asesorUser)


                    ->groupBy('usoinfraestructuras.id')
                    ->latest('usoinfraestructuras.updated_at')
                    ->get();
            }
            return $usoDatatable->indexDatatable($usos);
        }

        $nodes = null;
        $modules = null;
        if(request()->user()->can('listNodes', UsoInfraestructura::class)) {
            $nodes = Nodo::SelectNodo()->get();
        }
        if(request()->user()->can('moduleType', UsoInfraestructura::class)) {
            if(session()->get('login_role') == User::IsTalento()){
                $modules = [
                    class_basename(Proyecto::class) => __('Projects'),
                    class_basename(Articulation::class) => __('Articulations')
                ];
            }else if(session()->get('login_role') == User::IsArticulador()){
                $modules = [
                    class_basename(Articulation::class) => __('Articulations'),
                    class_basename(Idea::class) => __('Ideas')
                ];
            }
            else{
                $modules = [
                    class_basename(Proyecto::class) => __('Projects'),
                    class_basename(Articulation::class) => __('Articulations'),
                    class_basename(Idea::class) => __('Ideas')
                ];
            }
        }
        return view('usoinfraestructura.index', [
            'nodos' => $nodes,
            'modules' => $modules
        ]);
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
                $node = auth()->user()->dinamizador->nodo_id;
                $model = $request->filter_module;
                break;
            case User::IsArticulador():
                $node = auth()->user()->articulador->nodo_id;
                $model = $request->filter_module;
                break;
            case User::IsGestor():
                $node = auth()->user()->gestor->nodo_id;
                $user = auth()->user()->id;
                $model = class_basename(Proyecto::class);
                break;
            case User::IsApoyoTecnico():
                $node = auth()->user()->apoyotecnico->nodo_id;
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

    private function getUsosDeProyectos($proyectos)
    {
        $usos_models = [];
        foreach ($proyectos as $ke1 => $proyecto) {
            foreach ($proyecto->asesorias as $key2 => $usos) {
                if ($usos != null) {
                    $usos_models[] = $usos;
                }
            }
        }
        return $usos_models;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', UsoInfraestructura::class);
        $sumasArray   = [];
        $date         = Carbon::now()->format('Y-m-d');
        switch (\Session::get('login_role')) {
            case User::IsGestor():
                $projects     = $this->getDataProjectsForUser()->count();
                $sumasArray = ['projects'=> $projects];
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
                $nodo             = auth()->user()->gestor->nodo->id;
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
                    'ideas' => 1
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
                return view('usoinfraestructura.create', [
                    'date'                => $date,
                    'cantidadActividades' => $cantActividades,
                ]);
                break;
            default:
                return abort('403');
                break;
        }

        return view('usoinfraestructura.create', [
            'gestores'            => $gestores,
            'lineastecnologicas'  => $lineastecnologicas,
            'date'                => $date,
            'cantidadActividades' => $cantActividades,
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
        $this->authorize('store', UsoInfraestructura::class);
        $req       = new UsoInfraestructuraFormRequest;
        $validator = Validator::make($request->all(), $req->rules(), $req->messages());
        if ($validator->fails()) {
            return response()->json([
                'fail'   => true,
                'errors' => $validator->errors(),
            ]);
        }
        $result = $this->getUsoInfraestructuraRepository()->storeUsoInfraestructuraProyecto($request);
        if ($result == 'false') {
            return response()->json([
                'fail'         => false,
                'redirect_url' => false,
            ]);
        } else if ($result == 'true') {
            return response()->json([
                'fail'         => false,
                'redirect_url' => url(route('usoinfraestructura.index')),
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $usoinfraestructura = UsoInfraestructura::with(
            ['usotalentos.user'=> function($query){
                $query->withTrashed();
            },'usogestores' => function($query){
                $query->withTrashed();
            }
        ])->findOrFail($id);
        // dd($usoinfraestructura);
        $equipos = [];
        if ($usoinfraestructura->has('usoequipos')) {
            $equipos = $usoinfraestructura->usoequipos()->withTrashed()->get();
        }

        $this->authorize('show', $usoinfraestructura);

        $totalCostos = 0;

        $totalCostos = $usoinfraestructura->usoequipos->sum('pivot.costo_equipo') + $usoinfraestructura->usogestores->sum('pivot.costo_asesoria') + $usoinfraestructura->usoequipos->sum('pivot.costo_administrativo') + $usoinfraestructura->usomateriales->sum('pivot.costo_material');

        return view('usoinfraestructura.show', [
            'usoinfraestructura' => $usoinfraestructura,
            'equipos' => $equipos,
            'totalCostos' => $totalCostos,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $usoinfraestructura = UsoInfraestructura::with(
            ['usotalentos.user'=> function($query){
                $query->withTrashed();
            },'usogestores' => function($query){
                $query->withTrashed();
            }]
        )->findOrFail($id);
        $this->authorize('edit', $usoinfraestructura);
        $equipos = [];
        if ($usoinfraestructura->has('usoequipos')) {
            $equipos = $usoinfraestructura->usoequipos()->withTrashed()->get();
        }
        $date = Carbon::now()->format('Y-m-d');
        switch (\Session::get('login_role')) {
            case User::IsGestor():
                $relations = [
                    'user'             => function ($query) {
                        $query->select('id', 'documento', 'nombres', 'apellidos');
                    },
                    'lineatecnologica' => function ($query) {
                        $query->select('id', 'nombre', 'abreviatura');
                    },
                ];
                $user             = auth()->user()->id;
                $nodo             = auth()->user()->gestor->nodo->id;
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
                return view('usoinfraestructura.edit', [
                    'usoinfraestructura' => $usoinfraestructura,
                    'equipos' => $equipos,
                    'date'                => $date,
                    'cantidadActividades' => $cantActividades,
                ]);
                break;
            default:
                return abort('403');
                break;
        }

        return view('usoinfraestructura.edit', [
            'usoinfraestructura' => $usoinfraestructura,
            'gestores'           => $gestores,
            'lineastecnologicas' => $lineastecnologicas,
            'equipos' => $equipos,
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
        $this->authorize('update', $usoinfraestructura);

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
                'redirect_url' => url(route('usoinfraestructura.index')),
            ]);
        }
    }

    /**
     * retorna query con las articulaciones en fase Inicio, En ejecuci車n por usuarios
     * @return collection
     * @author devjul
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

        if (Session::has('login_role') && Session::get('login_role') == User::IsGestor()) {
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
     * @author devjul
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

        if (Session::has('login_role') && Session::get('login_role') == User::IsGestor()) {

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
     * @author devjul
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
                ->join('actividades', 'articulacion_proyecto.actividad_id', '=', 'actividades.id')
                ->join('gestores', 'gestores.id', '=', 'proyectos.asesor_id')
                ->join('lineastecnologicas', 'lineastecnologicas.id', '=', 'gestores.lineatecnologica_id')
                ->join('users', 'users.id', '=', 'gestores.user_id')
                ->join('nodos', 'nodos.id', '=', 'proyectos.nodo_id')
                ->whereIn('fases.id', $fase)
                ->findOrFail($id);

            $lineastecnologicas = LineaTecnologica::join('lineastecnologicas_nodos', 'lineastecnologicas_nodos.linea_tecnologica_id', '=', 'lineastecnologicas.id')
                ->where('lineastecnologicas_nodos.nodo_id', $proyectoNodo)
                ->get();

            $gestores = Gestor::select('gestores.id', 'lineastecnologicas.id as lineatecnologica_id', 'lineastecnologicas.abreviatura', 'lineastecnologicas.nombre as lineatecnologica_nombre', 'users.documento', 'users.nombres', 'users.apellidos')
                ->join('lineastecnologicas', 'lineastecnologicas.id', 'gestores.lineatecnologica_id')
                ->join('users', 'users.id', '=', 'gestores.user_id')
                ->where('lineastecnologicas.id', $proyectoTalento->gestor_lineatecnologica_id)
                ->where('users.id', '!=', $proyectoTalento->user_id)
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
     * @author devjul
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

            $talentos = $articulacion->users()->with([
                'talento'=> function($query){
                    $query->select('id', 'user_id');
                }
            ])->get();

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
     * @author devjul
     */
    public function projectsForUser()
    {
        $projects = $this->getDataProjectsForUser();

        if (request()->ajax()) {

            return datatables()->of($projects)
                ->addColumn('checkbox', function ($data) {
                    $checkbox = '<a class="btn cyan m-b-xs" onclick="asociarProyectoAUsoInfraestructura(' . $data->id . ', \'' . $data->articulacion_proyecto->actividad->codigo_actividad . '\', \'' . $this->reemplezarComillas($data->articulacion_proyecto->actividad->nombre) . '\')">
                        <i class="material-icons">done_all</i>
                    </a>';
                    return $checkbox;
                })->editColumn('codigo_actividad', function ($data) {
                    return $data->articulacion_proyecto->actividad->codigo_actividad;
                })
                ->editColumn('nombre', function ($data) {
                    return $data->articulacion_proyecto->actividad->nombre;
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
        if (Session::get('login_role') == User::IsGestor()) {
            $gestor = auth()->user()->gestor->id;
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
                $activities =  Actividad::select('id')
                    ->selectRaw('CONCAT(codigo_actividad, " - ", nombre) as nombre')
                    ->whereHas('gestor', function ($query) use ($gestor) {
                        $query->where('id', $gestor);
                    })
                    ->pluck('nombre', 'id');
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
        $this->authorize('destroy', $usoinfraestructura);

        $usoinfraestructura->usoequipos()->sync([]);
        $usoinfraestructura->usotalentos()->sync([]);
        $usoinfraestructura->usomateriales()->sync([]);
        $usoinfraestructura->usogestores()->sync([]);
        $usoinfraestructura->delete();

        return response()->json([
            'usoinfraestructura' => 'success',
            'route' => route('usoinfraestructura.index')
        ]);
    }

    public function export(Request $request, $extension = 'xlsx')
    {
        $this->authorize('index', UsoInfraestructura::class);

        switch (\Session::get('login_role')) {
            case User::IsAdministrador():
                $nodo = $request->filter_nodo;
                $asesor = $request->filter_gestor;
                $user = null;
                $actividad = null;
                break;
            case User::IsDinamizador():
                $nodo = auth()->user()->dinamizador->nodo_id;
                $asesor = $request->filter_gestor;
                $user = null;
                $actividad = null;
                break;
            case User::IsGestor():
                $nodo = auth()->user()->gestor->nodo_id;
                $user = auth()->user()->gestor->user->id;
                $asesor = auth()->user()->id;
                $actividad = $request->filter_actividad;
                break;
            case User::IsArticulador():
                $nodo = auth()->user()->articulador->nodo_id;
                $user = auth()->user()->id;
                $asesor = auth()->user()->id;
                $actividad = $request->filter_actividad;
                break;
            case User::IsApoyoTecnico():
                $nodo = auth()->user()->apoyotecnico->nodo_id;
                $user = auth()->user()->id;
                $asesor = auth()->user()->id;
                $actividad = $request->filter_actividad;
                break;
            case User::IsTalento():
                $nodo = null;
                $user = auth()->user()->id;
                $asesor = null;
                $actividad = $request->filter_actividad;
                break;
            default:
                return abort('403');
                break;
        }

        $usos = [];

        if (($request->filled('filter_nodo') || $request->filter_nodo == null)  && ($request->filled('filter_year') || $request->filter_year == null) && ($request->filled('filter_gestor') || $request->filter_gestor == null)  && ($request->filled('filter_actividad') || $request->filter_actividad == null)) {
            $usos = UsoInfraestructura::
            nodoAsesoria($nodo)
                    ->yearAsesoria($request->filter_year)
                    ->asesoria($actividad, $user)
                    ->asesor($asesor)
                    ->orderBy('usoinfraestructuras.created_at', 'desc')
                    ->get();
        }
        return (new UsoInfraestructuraExport($request, $usos))->download("Usos de infraestructura - " . config('app.name') . ".{$extension}");
    }

    /**
     * retorna query con las ideas
     * @return collection
     * @author devjul
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
                })

                ->get();
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
