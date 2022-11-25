<?php

namespace App\Http\Controllers\UsoInfraestructura;

use App\Http\Controllers\Controller;
use App\Http\Requests\UsoInfraestructura\UsoInfraestructuraFormRequest;
use App\Models\{ArticulacionPbt, UsoInfraestructura, Actividad, Talento, Proyecto, Nodo, Fase, Equipo, Gestor, LineaTecnologica, Material, Entidad};
use App\Datatables\UsoInfraestructuraDatatable;
use App\Repositories\Repository\UserRepository\GestorRepository;
use App\Repositories\Repository\{LineaRepository, ProyectoRepository,  UsoInfraestructuraRepository};
use App\Repositories\Repository\ArticulacionPbtRepository;
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
        ArticulacionPbtRepository $setUsoIngraestructuraArtculacionRepository,
        UsoInfraestructuraRepository $UsoInfraestructuraRepository,
        GestorRepository $gestorRepository,
        LineaRepository $lineaRepository,
        ProyectoRepository $proyectoRepository
    ) {
        $this->middleware(['auth', 'role_session:Activador|Dinamizador|Articulador|'.User::IsExperto().'|Talento|'.User::IsApoyoTecnico()]);
        $this->setUsoIngraestructuraProyectoRepository($UsoInfraestructuraProyectoRepository);
        $this->setUsoIngraestructuraArtculacionRepository($setUsoIngraestructuraArtculacionRepository);
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
     * Asigna un valor a $UsoInfraestructuraArticulacionRepository
     * @param object $UsoInfraestructuraArticulacionRepository
     * @return void
     * @author devjul
     */
    private function setUsoIngraestructuraArtculacionRepository($UsoInfraestructuraArticulacionRepository)
    {
        $this->UsoInfraestructuraArticulacionRepository = $UsoInfraestructuraArticulacionRepository;
    }

    /**
     * Retorna el valor de $UsoInfraestructuraEdtRepository
     * @return object
     * @author devjul
     */
    private function getUsoIngraestructuraArtculacionRepository()
    {
        return $this->UsoInfraestructuraArticulacionRepository;
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
        $this->authorize('index', UsoInfraestructura::class);
        switch (\Session::get('login_role')) {
            case User::IsActivador():
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
            case User::IsExperto():
                $nodo = auth()->user()->gestor->nodo_id;
                $user = auth()->user()->id;
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
        if ($request->ajax()) {
            $usos = [];
            if (($request->filled('filter_nodo') || $request->filter_nodo == null)  && ($request->filled('filter_year') || $request->filter_year == null) && ($request->filled('filter_gestor') || $request->filter_gestor == null)  && ($request->filled('filter_actividad') || $request->filter_actividad == null)) {
                $usos = UsoInfraestructura::nodoAsesoria($nodo)
                    ->yearAsesoria($request->filter_year)
                    ->asesoria($actividad, $user)
                    ->asesor($asesor)
                    ->orderBy('usoinfraestructuras.created_at', 'desc')
                    ->get();
            }
            return $usoDatatable->indexDatatable($usos);
        }
        switch (Session::get('login_role')) {
            case User::IsActivador():
                return view('usoinfraestructura.administrador.index', [
                    'nodos' =>  Entidad::has('nodo')->with('nodo')->get()->pluck('nombre', 'nodo.id'),
                ]);
                break;
            case User::IsDinamizador():
                $gestores = User::select('gestores.id as idgestor', 'users.id')
                    ->selectRaw('CONCAT(users.documento, " - ", users.nombres, " ", users.apellidos) as user')
                    ->join('gestores', 'gestores.user_id', 'users.id')
                    ->where('gestores.nodo_id', $nodo)
                    ->role(User::IsExperto())
                    ->withTrashed()
                    ->pluck('user', 'idgestor');
                return view('usoinfraestructura.index', ['gestores' => $gestores]);
                break;
            case User::IsExperto():
                return view('usoinfraestructura.index');
                break;
            case User::IsArticulador():
                return view('usoinfraestructura.index');
                break;
            case User::IsApoyoTecnico():
                return view('usoinfraestructura.index');
                break;
            case User::IsTalento():
                $user = auth()->user()->id;
                $proyectos = $this->getUsoInfraestructuraRepository()->getProyectosForUser($user)
                    ->where('user_talento.id', $user)
                    ->pluck('nombre', 'proyectos.id');
                return view('usoinfraestructura.index', [
                    'proyectos' => $proyectos,
                ]);
                break;
            default:
                return abort('403');
                break;
        }


        return view('usoinfraestructura.index', [
            'nodos' => Nodo::selectNodo()->pluck('nodos', 'id'),
        ]);
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
            case User::IsExperto():
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
                $artulaciones = $this->getDataArticulaciones()->count();
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
                $artulaciones = $this->getDataArticulaciones()->count();
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
                    <a class="btn cyan m-b-xs" onclick="asociarArticulacionAUsoInfraestructura(' . $data->id . ', \'' . $data->present()->articulacionCode() . '\', \'' . $this->reemplezarComillas($data->present()->articulacionName()) . '\')">
                        <i class="material-icons">done_all</i>
                    </a>';

                    return $checkbox;
                })->editColumn('codigo_actividad', function ($data) {
                    return $data->present()->articulacionCode();
                })
                ->editColumn('nombre', function ($data) {
                    return $data->present()->articulacionName();
                })
                ->editColumn('fase', function ($data) {
                    return $data->fase->nombre;
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
            'fase'                => function ($query) {
                $query->select('id', 'nombre');
            },
        ];

        if (Session::has('login_role') && Session::get('login_role') == User::IsExperto()) {
            return [];
        }elseif(Session::has('login_role') && Session::get('login_role') == User::IsArticulador()) {

            return $this->getUsoIngraestructuraArtculacionRepository()
                ->getArticulacionesForUser($relations)

                ->whereHas('asesor', function ($query) use ($user) {
                    $query->withTrashed();
                })
                ->whereHas('asesor', function ($query) use ($user) {
                    $query->where('documento', $user);
                })
                ->whereIn('fase_id', $fase)
                ->get();
        }
        elseif (Session::has('login_role') && Session::get('login_role') == User::IsTalento()) {
            return $this->getUsoIngraestructuraArtculacionRepository()
                ->getArticulacionesForUser($relations)

                ->whereHas('asesor', function ($query) use ($user) {
                    $query->withTrashed();
                })
                ->whereHas('talentos.user', function ($query) use ($user) {
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

            $articulacionNodo = ArticulacionPbt::findOrFail($id)->nodo->id;

            $fase = [
                Fase::IsInicio(),
                Fase::IsEjecucion(),
                Fase::IsCierre(),
            ];

            $articulacion = ArticulacionPbt::with([
                'asesor'=> function($query){
                    $query->select('id', 'documento', 'nombres', 'apellidos');
                }])
                    ->whereIn('fase_id', $fase)
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

            $talentos = $articulacion->talentos()->with('user')->get();


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
     * retorna query con los proyectos en fase Inicio, Planeaci車n, En ejecuci車n por usuarios
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
        if (Session::get('login_role') == User::IsExperto()) {
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
            case User::IsActivador():
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
            case User::IsExperto():
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
