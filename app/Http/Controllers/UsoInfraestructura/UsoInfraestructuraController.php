<?php

namespace App\Http\Controllers\UsoInfraestructura;

use App\Http\Controllers\Controller;
use App\Http\Requests\UsoInfraestructura\UsoInfraestructuraFormRequest;
use App\Models\{UsoInfraestructura, Actividad, Articulacion, Talento, Proyecto, Nodo, Fase, Edt, Equipo, Gestor, LineaTecnologica, Material};
use App\Repositories\Datatables\UsoInfraestructuraDatatables;
use App\Repositories\Repository\UserRepository\GestorRepository;
use App\Repositories\Repository\{ArticulacionRepository, EdtRepository, LineaRepository, ProyectoRepository,  UsoInfraestructuraRepository};
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UsoInfraestructuraController extends Controller
{

    private $UsoInfraestructuraEdtRepository;
    private $UsoInfraestructuraProyectoRepository;
    private $UsoInfraestructuraArticulacionRepository;
    private $UsoInfraestructuraRepository;
    private $lineaRepository;
    private $UsoInfraestructuraDatatables;
    private $proyectoRepository;


    public function __construct(
        ProyectoRepository $UsoInfraestructuraProyectoRepository,
        EdtRepository $UsoInfraestructuraEdtRepository,
        ArticulacionRepository $setUsoIngraestructuraArtculacionRepository,
        UsoInfraestructuraRepository $UsoInfraestructuraRepository,
        GestorRepository $gestorRepository,
        LineaRepository $lineaRepository,
        UsoInfraestructuraDatatables $UsoInfraestructuraDatatables,
        ProyectoRepository $proyectoRepository


    ) {
        $this->middleware(['auth', 'role_session:Administrador|Dinamizador|Gestor|Talento']);
        $this->setUsoIngraestructuraProyectoRepository($UsoInfraestructuraProyectoRepository);
        $this->setUsoIngraestructuraEdtRepository($UsoInfraestructuraEdtRepository);
        $this->setUsoIngraestructuraArtculacionRepository($setUsoIngraestructuraArtculacionRepository);
        $this->setUsoInfraestructuraRepository($UsoInfraestructuraRepository);
        $this->setUsoInfraestructuraDatatables($UsoInfraestructuraDatatables);
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
     * Asigna un valor a $UsoInfraestructuraEdtRepository
     * @param object $edtRepostory
     * @return void
     * @author devjul
     */
    private function setUsoIngraestructuraEdtRepository($UsoInfraestructuraEdtRepository)
    {
        $this->UsoInfraestructuraEdtRepository = $UsoInfraestructuraEdtRepository;
    }

    /**
     * Retorna el valor de $UsoInfraestructuraEdtRepository
     * @return object
     * @author devjul
     */
    private function getUsoIngraestructuraEdtRepository()
    {
        return $this->UsoInfraestructuraEdtRepository;
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
     * Asigna un valor a $UsoInfraestructuraDatatables
     * @param object $UsoInfraestructuraDatatables
     * @return void
     * @author devjul
     */
    private function setUsoInfraestructuraDatatables($UsoInfraestructuraDatatables)
    {
        $this->UsoInfraestructuraDatatables = $UsoInfraestructuraDatatables;
    }

    /**
     * Retorna el valor de $UsoInfraestructuraDatatables
     * @return object
     * @author devjul
     */
    private function getUsoInfraestructuraDatatables()
    {
        return $this->UsoInfraestructuraDatatables;
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
    public function index()
    {
        $this->authorize('index', UsoInfraestructura::class);

        $user = auth()->user()->id;

        $relations = $this->getUsoInfraestructuraRepository()->getDataIndex();

        switch (Session::get('login_role')) {
            case User::IsAdministrador():
                break;
            case User::IsDinamizador():
                $nodo               = auth()->user()->dinamizador->nodo->id;
                $usoinfraestructura = $this->getUsoInfraestructuraRepository()->getUsoInfraestructuraForUser($relations)->select('id', 'actividad_id', 'tipo_usoinfraestructura', 'fecha', 'asesoria_directa', 'asesoria_indirecta', 'descripcion', 'estado', 'created_at')->whereHas('actividad.nodo', function ($query) use ($nodo) {
                    $query->where('id', $nodo);
                })->get();


                $gestores = User::select('gestores.id')
                    ->selectRaw('CONCAT(users.documento, " - ", users.nombres, " ", users.apellidos) as user')
                    ->join('gestores', 'gestores.user_id', 'users.id')
                    ->where('gestores.nodo_id', $nodo)
                    ->role('Gestor')
                    ->withTrashed()
                    ->pluck('user', 'id');

                // return $gestores;
                return view('usoinfraestructura.index', [
                    'gestores' => $gestores,
                ]);
                break;

            case User::IsGestor():

                // $user= auth()->user()->gestor->id;
                // $proyectos = $this->getUsoInfraestructuraRepository()->getProyectosForUser($user)
                // ->where('gestores.id', $user)
                // // ->whereIn('fases.id', [1,2,3])
                // ->pluck( 'nombre', 'proyectos.id');

                return view('usoinfraestructura.index', [
                    'gestor_id' => auth()->user()->gestor->id,
                ]);

                break;
            case User::IsTalento():
                $user = auth()->user()->id;
                $proyectos = $this->getUsoInfraestructuraRepository()->getProyectosForUser($user)
                    ->where('user_talento.id', $user)
                    // ->whereIn('fases.id', [1,2,3])
                    ->pluck('nombre', 'proyectos.id');

                return view('usoinfraestructura.index', [
                    'proyectos' => $proyectos,
                ]);
                break;

            default:
                return abort('403');
                break;
        }



        if (request()->ajax()) {
            return $this->getUsoInfraestructuraDatatables()->indexDatatable($usoinfraestructura);
        }

        return view('usoinfraestructura.index', [
            'nodos' => Nodo::selectNodo()->pluck('nodos', 'id'),
        ]);
    }

    /**
     * retorna datatables con los usos de infraestructura por nodo.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUsoInfraestructuraForNodo(int $nodo)
    {

        $this->authorize('getUsoInfraestructuraForNodo', UsoInfraestructura::class);
        $relations          = $this->getUsoInfraestructuraRepository()->getDataIndex();
        $usoinfraestructura = $this->getUsoInfraestructuraRepository()->getUsoInfraestructuraForUser($relations)->select('id', 'actividad_id', 'tipo_usoinfraestructura', 'fecha', 'asesoria_directa', 'asesoria_indirecta', 'descripcion', 'estado', 'created_at')->whereHas('actividad.nodo', function ($query) use ($nodo) {
            $query->where('id', $nodo);
        })->get();

        if (request()->ajax()) {
            return $this->getUsoInfraestructuraDatatables()
                ->getUsoInfraestructuraForNodoDatatables($usoinfraestructura);
        } else {
            abort('403');
        }
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
        $artulaciones = $this->getDataArticulaciones()->count();

        $projects     = $this->getDataProjectsForUser()->count();
        $date         = Carbon::now()->format('Y-m-d');

        if (Session::has('login_role') && Session::get('login_role') == User::IsGestor()) {
            $edt = $this->getDataEdtForUser()->count();

            $sumasArray = [
                'articulaciones' => $artulaciones,
                'edt'            => $edt,
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
            $nodo             = auth()->user()->gestor->nodo->id;
            $lineaTecnologica = auth()->user()->gestor->lineatecnologica->id;
            $gestores         = $this->getGestorRepository()->getInfoGestor($relations)
                ->whereHas('user', function ($query) use ($user) {
                    $query->where('id', '!=', $user)->where('estado', User::IsActive());
                })
                ->whereHas('nodo', function ($query) use ($nodo) {
                    $query->where('id', $nodo);
                })->get();

            $lineastecnologicas = $this->getLineaTecnologicaRepository()->findLineasByIdNameForNodo($nodo);

            return view('usoinfraestructura.create', [

                'gestores'            => $gestores,
                'lineastecnologicas'  => $lineastecnologicas,
                'date'                => $date,
                'cantidadActividades' => $cantActividades,
            ]);
        } else if (Session::has('login_role') && Session::get('login_role') == User::IsTalento()) {
            $sumasArray = [
                'articulaciones' => $artulaciones,
                'projects'       => $projects,
            ];

            $cantActividades = array_sum($sumasArray);
            return view('usoinfraestructura.create', [
                'date'                => $date,
                'cantidadActividades' => $cantActividades,
            ]);
        } else {
            abort('403');
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

        $this->authorize('store', UsoInfraestructura::class);

        $req       = new UsoInfraestructuraFormRequest;
        $validator = Validator::make($request->all(), $req->rules(), $req->messages());
        if ($validator->fails()) {
            return response()->json([
                'fail'   => true,
                'errors' => $validator->errors(),
            ]);
        }

        $result = $this->getUsoInfraestructuraRepository()->store($request);

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

        $relations          = $this->getUsoInfraestructuraRepository()->getDataIndex();
        $usoinfraestructura = $this->getUsoInfraestructuraRepository()->getUsoInfraestructuraForUser($relations)
            ->select('id', 'actividad_id', 'tipo_usoinfraestructura', 'fecha', 'asesoria_directa', 'asesoria_indirecta', 'descripcion', 'estado', 'created_at')
            ->findOrFail($id);
        $this->authorize('show', $usoinfraestructura);

        $totalCostos = 0;

        $totalCostos = $usoinfraestructura->usoequipos->sum('pivot.costo_equipo') + $usoinfraestructura->usogestores->sum('pivot.costo_asesoria') + $usoinfraestructura->usoequipos->sum('pivot.costo_administrativo') + $usoinfraestructura->usomateriales->sum('pivot.costo_material');

        return view('usoinfraestructura.show', [
            'usoinfraestructura' => $usoinfraestructura,
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

        $relations          = $this->getUsoInfraestructuraRepository()->getDataIndex();
        $usoinfraestructura = $this->getUsoInfraestructuraRepository()->getUsoInfraestructuraForUser($relations)
            ->select('id', 'actividad_id', 'tipo_usoinfraestructura', 'fecha', 'asesoria_directa', 'asesoria_indirecta', 'descripcion', 'estado', 'created_at')
            ->findOrFail($id);

        $this->authorize('edit', $usoinfraestructura);

        $date = Carbon::now()->format('Y-m-d');

        if (Session::has('login_role') && Session::get('login_role') == User::IsGestor()) {
            $edt = $this->getDataEdtForUser()->count();

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
            $lineaTecnologica = auth()->user()->gestor->lineatecnologica->id;
            $gestores         = $this->getGestorRepository()->getInfoGestor($relations)
                ->whereHas('user', function ($query) use ($user) {
                    $query->where('id', '!=', $user)->where('estado', User::IsActive());
                })
                ->whereHas('nodo', function ($query) use ($nodo) {
                    $query->where('id', $nodo);
                })->get();

            $lineastecnologicas = $this->getLineaTecnologicaRepository()->findLineasByIdNameForNodo($nodo);

            return view('usoinfraestructura.edit', [
                'usoinfraestructura' => $usoinfraestructura,
                'gestores'           => $gestores,
                'lineastecnologicas' => $lineastecnologicas,
                'date'               => $date,

            ]);
        } else if (Session::has('login_role') && Session::get('login_role') == User::IsTalento()) {

            return view('usoinfraestructura.edit', [
                'usoinfraestructura' => $usoinfraestructura,
                'date'               => $date,
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Request $request, $id)
    {
        $relations          = $this->getUsoInfraestructuraRepository()->getDataIndex();
        $usoinfraestructura = $this->getUsoInfraestructuraRepository()->getUsoInfraestructuraForUser($relations)
            ->select('id', 'actividad_id', 'tipo_usoinfraestructura', 'fecha', 'asesoria_directa', 'asesoria_indirecta', 'descripcion', 'estado', 'created_at')
            ->findOrFail($id);

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
     * retorna query con las articulaciones en fase Inicio, En ejecución por usuarios
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
                    <a class="btn cyan m-b-xs" onclick="asociarArticulacionAUsoInfraestructura(' . $data->id . ', \'' . $data->articulacion_proyecto->actividad->codigo_actividad . '\', \'' . $this->reemplezarComillas($data->articulacion_proyecto->actividad->nombre) . '\')">
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
            Fase::IsPlaneacion(),
            Fase::IsEjecucion(),
        ];

        $relations = [
            'fase'                => function ($query) {
                $query->select('id', 'nombre');
            },
            'articulacion_proyecto',
            'articulacion_proyecto.actividad' => function ($query) {
                $query->select('id', 'codigo_actividad', 'nombre', 'fecha_inicio');
            },
        ];

        if (Session::has('login_role') && Session::get('login_role') == User::IsGestor()) {

            return $this->getUsoIngraestructuraArtculacionRepository()
                ->getArticulacionesForUser($relations)

                ->whereHas('articulacion_proyecto.actividad.gestor.user', function ($query) use ($user) {
                    $query->withTrashed();
                })
                ->whereHas('articulacion_proyecto.actividad.gestor.user', function ($query) use ($user) {
                    $query->where('documento', $user);
                })
                ->whereIn('fase_id', $fase)
                ->get();
        } elseif (Session::has('login_role') && Session::get('login_role') == User::IsTalento()) {
            return $this->getUsoIngraestructuraArtculacionRepository()
                ->getArticulacionesForUser($relations)

                ->whereHas('articulacion_proyecto.actividad.gestor.user', function ($query) use ($user) {
                    $query->withTrashed();
                })
                ->whereHas('articulacion_proyecto.talentos.user', function ($query) use ($user) {
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

    /**
     * retorna query con los proyectos en fase Inicio, Planeación, En ejecución por usuarios
     * @return object
     * @author devjul
     */
    public function projectsForUser()
    {
        $projects = $this->getDataProjectsForUser();
        // dd(replace$projects->articulacion_proyecto->actividad->nombre);
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
                ->rawColumns(['checkbox', 'codigo_actividad'])->make(true);
        } else {
            abort('403');
        }
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
                ->whereHas('articulacion_proyecto.actividad.gestor.user', function ($query) use ($user) {
                    $query->where('documento', $user);
                })
                ->get();
        } else if (Session::has('login_role') && Session::get('login_role') == User::IsTalento()) {

            return $this->getUsoIngraestructuraProyectoRepository()->getProjectsForFaseById($relations, $fase)
                ->whereHas('articulacion_proyecto.talentos.user', function ($query) use ($user) {
                    $query->where('documento', $user);
                })
                ->get();
        } else {
            abort('403');
        }
    }

    /**
     * retorna query con las edt activas  por usuarios
     * @return collection
     * @author devjul
     */

    public function edtsForUser()
    {

        $edt = $this->getDataEdtForUser();

        if (request()->ajax()) {

            return datatables()->of($edt)
                ->addColumn('checkbox', function ($data) {
                    $checkbox = '<a class="btn cyan m-b-xs" onclick="asociarEdtAUsoInfraestructura(' . $data->id . ', \'' . $data->actividad->codigo_actividad . '\', \'' . $this->reemplezarComillas($data->actividad->nombre) . '\')">
                        <i class="material-icons">done_all</i>
                      </a>';

                    return $checkbox;
                })
                ->editColumn('codigo_actividad', function ($data) {
                    return $data->actividad->codigo_actividad;
                })
                ->editColumn('nombre', function ($data) {
                    return $data->actividad->nombre;
                })
                ->editColumn('empresas', function ($data) {
                    return $data->entidades->implode('nombre', ', ');
                })
                ->rawColumns(['checkbox', 'codigo_actividad', 'empresas'])->make(true);
        } else {
            abort('403');
        }
    }

    private function getDataEdtForUser()
    {
        $user = auth()->user()->documento;

        $relations = [
            'actividad'         => function ($query) {
                $query->select('id', 'codigo_actividad', 'nombre', 'fecha_inicio');
            },
            'entidades'         => function ($query) {
                $query->select('entidades.id', 'entidades.nombre');
            },
            'entidades.empresa' => function ($query) {
                $query->select('id', 'entidad_id', 'nit');
            },
        ];

        if (Session::has('login_role') && Session::get('login_role') == User::IsGestor()) {

            return $this->getUsoIngraestructuraEdtRepository()->findEdtByUser($relations)
                ->whereHas('actividad.gestor.user', function ($query) use ($user) {
                    $query->where('documento', $user);
                })->where('estado', Edt::IsActive())->get();
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

            $proyectoNodo = Proyecto::findOrFail($id)->articulacion_proyecto->actividad->nodo_id;

            $proyectoTalento = Proyecto::select('proyectos.*', 'actividades.id as actividad_id', 'actividades.gestor_id as actividad_gestor_id', 'actividades.nodo_id as actividad_nodo_id', 'actividades.codigo_actividad', 'actividades.nombre as actividades_nombre', 'gestores.id as gestor_id', 'gestores.lineatecnologica_id as gestor_lineatecnologica_id', 'gestores.honorarios', 'users.id as user_id', 'users.documento', 'users.nombres', 'users.apellidos', 'nodos.id as nodo_id', 'lineastecnologicas.abreviatura', 'lineastecnologicas.id as lineatecnologica_id', 'lineastecnologicas.nombre as lineatecnologica_nombre')
                ->join('fases', 'fases.id', '=', 'proyectos.fase_id')
                ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'proyectos.articulacion_proyecto_id')
                ->join('actividades', 'articulacion_proyecto.actividad_id', '=', 'actividades.id')
                ->join('gestores', 'gestores.id', '=', 'actividades.gestor_id')
                ->join('lineastecnologicas', 'lineastecnologicas.id', '=', 'gestores.lineatecnologica_id')
                ->join('users', 'users.id', '=', 'gestores.user_id')
                ->join('nodos', 'nodos.id', '=', 'actividades.nodo_id')
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

            $articulacionNodo = Articulacion::findOrFail($id)->articulacion_proyecto->actividad->nodo_id;

            $fase = [
                Fase::IsInicio(),
                Fase::IsPlaneacion(),
                Fase::IsEjecucion(),
            ];

            $articulacion = Articulacion::select('articulaciones.id as artculacion_id', 'articulaciones.articulacion_proyecto_id as articulacion.articulacion_proyecto_id', 'articulaciones.fecha_ejecucion as articulacion.fecha_ejecucion', 'articulaciones.estado', 'actividades.id as actividad_id', 'actividades.nodo_id as actividad_nodo_id', 'actividades.codigo_actividad', 'actividades.nombre as actividad_nombre', 'gestores.id as gestor_id', 'users.id as user_id', 'users.documento', 'users.nombres as user_nombres', 'users.apellidos as user_apellidos', 'lineastecnologicas.id as lineatecnologica_id', 'lineastecnologicas.abreviatura as lineatecnologica_abreviatura', 'lineastecnologicas.nombre as lineatecnologica_nombre')
                ->join('articulacion_proyecto', 'articulacion_proyecto.id', 'articulaciones.articulacion_proyecto_id')
                ->join('actividades', 'actividades.id', 'articulacion_proyecto.actividad_id')
                ->join('gestores', 'gestores.id', 'actividades.gestor_id')
                ->join('users', 'users.id', 'gestores.user_id')
                ->join('lineastecnologicas', 'lineastecnologicas.id', 'gestores.lineatecnologica_id')
                ->whereIn('articulaciones.fase_id', $fase)
                ->findOrFail($id);

            $gestores = Gestor::select('gestores.id', 'lineastecnologicas.id as lineatecnologica_id', 'lineastecnologicas.abreviatura', 'lineastecnologicas.nombre as lineatecnologica_nombre', 'users.documento', 'users.nombres', 'users.apellidos')
                ->join('lineastecnologicas', 'lineastecnologicas.id', 'gestores.lineatecnologica_id')
                ->join('users', 'users.id', '=', 'gestores.user_id')
                ->join('nodos', 'nodos.id', 'gestores.nodo_id')
                ->where('nodo_id', $articulacionNodo)
                ->where('users.id', '!=', $articulacion->user_id)
                ->where('users.estado', User::IsActive())
                ->where('users.deleted_at', null)
                ->get();

            $lineastecnologicas = LineaTecnologica::join('lineastecnologicas_nodos', 'lineastecnologicas_nodos.linea_tecnologica_id', '=', 'lineastecnologicas.id')
                ->where('lineastecnologicas_nodos.nodo_id', $articulacionNodo)
                ->get();

            $equipos = Equipo::where('lineatecnologica_id', $articulacion->lineatecnologica_id)
                ->where('nodo_id', $articulacionNodo)
                ->get();

            $materiales = Material::select('materiales.id as material_id', 'materiales.codigo_material', 'materiales.nombre as material_nombre', 'materiales.marca as material_marca', 'presentaciones.nombre as presentacion_nombre', 'medidas.nombre as medida_nombre')
                ->join('presentaciones', 'presentaciones.id', 'materiales.presentacion_id')
                ->join('medidas', 'medidas.id', 'materiales.medida_id')
                ->where('materiales.lineatecnologica_id', $articulacion->lineatecnologica_id)
                ->where('materiales.nodo_id', $articulacionNodo)
                ->get();

            $talentos = Talento::select('talentos.id', 'users.id as user_id', 'users.documento', 'users.nombres', 'users.apellidos')
                ->join('users', 'users.id', '=', 'talentos.user_id')
                ->join('articulacion_proyecto_talento', 'articulacion_proyecto_talento.talento_id', '=', 'talentos.id')
                ->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'articulacion_proyecto_talento.articulacion_proyecto_id')
                ->join('articulaciones', 'articulacion_proyecto.id', 'articulaciones.articulacion_proyecto_id')
                ->join('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
                ->where('articulaciones.id', $articulacion->artculacion_id)
                ->whereHas('user', function ($query) {
                    $query->withTrashed();
                })
                ->get();

            return response()->json([
                'articulacion'       => $articulacion,
                'lineastecnologicas' => $lineastecnologicas,
                'gestores'           => $gestores,
                'equipos'            => $equipos,
                'materiales'         => $materiales,
                'talentos' => $talentos
            ]);
        } else {
            abort('403');
        }
    }

    public function edtForUser($id)
    {
        if (request()->ajax()) {

            $edtNodo = Edt::findOrFail($id)->actividad->nodo_id;
            $edt     = Edt::select('edts.id as edt_id', 'edts.tipoedt_id', 'actividades.id as actividad_id', 'actividades.nodo_id as actividad_nodo_id', 'actividades.codigo_actividad', 'actividades.nombre as actividad_nombre', 'gestores.id as gestor_id', 'users.id as user_id', 'users.documento', 'users.nombres as user_nombres', 'users.apellidos as user_apellidos', 'lineastecnologicas.id as lineatecnologica_id', 'lineastecnologicas.abreviatura as lineatecnologica_abreviatura', 'lineastecnologicas.nombre as lineatecnologica_nombre')
                ->join('actividades', 'actividades.id', 'edts.actividad_id')
                ->join('gestores', 'gestores.id', 'actividades.gestor_id')
                ->join('users', 'users.id', 'gestores.user_id')
                ->join('lineastecnologicas', 'lineastecnologicas.id', 'gestores.lineatecnologica_id')
                ->where('edts.estado', Edt::IS_ACTIVE)
                ->findOrFail($id);

            $gestores = Gestor::select('gestores.id', 'lineastecnologicas.id as lineatecnologica_id', 'lineastecnologicas.abreviatura', 'lineastecnologicas.nombre as lineatecnologica_nombre', 'users.documento', 'users.nombres', 'users.apellidos')
                ->join('lineastecnologicas', 'lineastecnologicas.id', 'gestores.lineatecnologica_id')
                ->join('users', 'users.id', '=', 'gestores.user_id')
                ->where('lineastecnologicas.id', $edt->lineatecnologica_id)
                ->where('users.id', '!=', $edt->user_id)
                ->get();

            $lineastecnologicas = LineaTecnologica::join('lineastecnologicas_nodos', 'lineastecnologicas_nodos.linea_tecnologica_id', '=', 'lineastecnologicas.id')
                ->where('lineastecnologicas_nodos.nodo_id', $edtNodo)
                ->get();

            $equipos = Equipo::where('lineatecnologica_id', $edt->lineatecnologica_id)
                ->where('nodo_id', $edtNodo)
                ->get();

            $materiales = Material::select('materiales.id as material_id', 'materiales.codigo_material', 'materiales.nombre as material_nombre', 'materiales.marca as material_marca', 'presentaciones.nombre as presentacion_nombre', 'medidas.nombre as medida_nombre')
                ->join('presentaciones', 'presentaciones.id', 'materiales.presentacion_id')
                ->join('medidas', 'medidas.id', 'materiales.medida_id')
                ->where('materiales.lineatecnologica_id', $edt->lineatecnologica_id)
                ->where('materiales.nodo_id', $edtNodo)
                ->get();

            return response()->json([
                'edt'                => $edt,
                'lineastecnologicas' => $lineastecnologicas,
                'gestores'           => $gestores,
                'equipos'            => $equipos,
                'materiales'         => $materiales,
            ]);
        } else {
            abort('403');
        }
    }


    /**
     * retorna query con los proyectos en fase Inicio, Planeación, En ejecución por usuarios
     * @return object
     * @author devjul
     */
    public function projectsByUser($proyect)
    {
        $relations = $this->getUsoInfraestructuraRepository()->getDataIndex();
        if (Session::get('login_role') == User::IsTalento()) {
            $user = auth()->user()->id;
            $usoinfraestructura =  $this->getUsoInfraestructuraRepository()->getUsoInfraestructuraForUser($relations)->select('id', 'actividad_id', 'tipo_usoinfraestructura', 'fecha', 'asesoria_directa', 'asesoria_indirecta', 'descripcion', 'estado', 'created_at')
                ->whereHas('actividad.articulacion_proyecto.talentos.user', function ($query) use ($user) {
                    $query->where('id', $user);
                })
                ->whereHas('actividad.articulacion_proyecto.proyecto', function ($query) use ($proyect) {
                    $query->where('id', $proyect);
                })
                ->get();
        } else if (Session::get('login_role') == User::IsGestor()) {
            $user = auth()->user()->id;
            $usoinfraestructura =  $this->getUsoInfraestructuraRepository()->getUsoInfraestructuraForUser($relations)->select('id', 'actividad_id', 'tipo_usoinfraestructura', 'fecha', 'asesoria_directa', 'asesoria_indirecta', 'descripcion', 'estado', 'created_at')
                ->whereHas('actividad.gestor.user', function ($query) use ($user) {
                    $query->where('id', $user);
                })
                ->whereHas('actividad.articulacion_proyecto.proyecto', function ($query) use ($proyect) {
                    $query->where('id', $proyect);
                })
                ->get();
        }
        if (request()->ajax()) {
            return $this->getUsoInfraestructuraDatatables()->indexDatatable($usoinfraestructura);
        }
    }


    public function activitiesByGestor($gestor = null, $anio = null)
    {

        $activities =  Actividad::select(
            'id',
            'fecha_inicio'
        )->selectRaw('CONCAT(codigo_actividad, " - ", nombre) as nombre')

            ->where('gestor_id', $gestor)
            ->whereYear('fecha_inicio', $anio)
            ->pluck('nombre', 'id');

        return response()->json([
            'actividades' => $activities
        ], 201);
    }


    public function getDatatableInfoActividad($gestor = null, $anio = null, $actividad)
    {
        $relations          = $this->getUsoInfraestructuraRepository()->getDataIndex();
        $usoinfraestructura = $this->getUsoInfraestructuraRepository()->getUsoInfraestructuraForUser($relations)
            ->select('id', 'actividad_id', 'tipo_usoinfraestructura', 'fecha', 'asesoria_directa', 'asesoria_indirecta', 'descripcion', 'estado', 'created_at')
            ->whereHas('actividad', function ($query) use ($gestor, $anio, $actividad) {
                $query->where('id', $actividad)->whereYear('fecha_inicio', $anio)->where('gestor_id', $gestor);
            })->get();

        if (request()->ajax()) {
            return $this->getUsoInfraestructuraDatatables()
                ->indexDatatable($usoinfraestructura);
        } else {
            abort('403');
        }
    }

    public function destroy(int $id)
    {
        $relations          = $this->getUsoInfraestructuraRepository()->getDataIndex();
        $usoinfraestructura = $this->getUsoInfraestructuraRepository()->getUsoInfraestructuraForUser($relations)
            ->select('id', 'actividad_id', 'tipo_usoinfraestructura', 'fecha', 'asesoria_directa', 'asesoria_indirecta', 'descripcion', 'estado', 'created_at')
            ->findOrFail($id);

        $usoinfraestructura->usolaboratorios()->sync([]);
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
}
