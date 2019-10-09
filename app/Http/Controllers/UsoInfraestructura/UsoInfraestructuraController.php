<?php

namespace App\Http\Controllers\UsoInfraestructura;

use App\Http\Controllers\Controller;
use App\Http\Requests\UsoInfraestructura\UsoInfraestructuraFormRequest;
use App\Models\Articulacion;
use App\Models\Edt;
use App\Models\Gestor;
use App\Models\LineaTecnologica;
use App\Models\Nodo;
use App\Models\Proyecto;
use App\Models\UsoInfraestructura;
use App\Repositories\Repository\ArticulacionRepository;
use App\Repositories\Repository\EdtRepository;
use App\Repositories\Repository\LineaRepository;
use App\Repositories\Repository\ProyectoRepository;
use App\Repositories\Repository\UserRepository\GestorRepository;
use App\Repositories\Repository\UsoInfraestructuraRepository;
use App\User;
use Carbon;
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

    public function __construct(
        ProyectoRepository $UsoInfraestructuraProyectoRepository,
        EdtRepository $UsoInfraestructuraEdtRepository,
        ArticulacionRepository $setUsoIngraestructuraArtculacionRepository,
        UsoInfraestructuraRepository $UsoInfraestructuraRepository,
        GestorRepository $gestorRepository,
        LineaRepository $lineaRepository
    ) {
        $this->middleware('role_session:Administrador|Dinamizador|Gestor|Talento');
        $this->setUsoIngraestructuraProyectoRepository($UsoInfraestructuraProyectoRepository);
        $this->setUsoIngraestructuraEdtRepository($UsoInfraestructuraEdtRepository);
        $this->setUsoIngraestructuraArtculacionRepository($setUsoIngraestructuraArtculacionRepository);
        $this->setUsoInfraestructuraRepository($UsoInfraestructuraRepository);
        $this->setGestorRepository($gestorRepository);
        $this->setLineaTecnologicaRepository($lineaRepository);

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

        $relations = $this->getDataIndex();


        switch (Session::get('login_role')) {
            case User::IsAdministrador():
                // $usoinfraestructura = $this->getUsoInfraestructuraRepository()->getUsoInfraestructuraForUser($relations)->select('id', 'actividad_id', 'tipo_usoinfraestructura', 'fecha', 'asesoria_directa', 'asesoria_indirecta', 'descripcion', 'estado', 'created_at')->whereHas('actividad.nodo', function ($query) use ($nodo) {
                //     $query->where('id', $nodo);
                // })->get();
                break;

            case User::IsDinamizador():
                $nodo               = auth()->user()->dinamizador->nodo->id;
                $usoinfraestructura = $this->getUsoInfraestructuraRepository()->getUsoInfraestructuraForUser($relations)->select('id', 'actividad_id', 'tipo_usoinfraestructura', 'fecha', 'asesoria_directa', 'asesoria_indirecta', 'descripcion', 'estado', 'created_at')->whereHas('actividad.nodo', function ($query) use ($nodo) {
                    $query->where('id', $nodo);
                })->get();
                break;

            case User::IsGestor():

                $usoinfraestructura = $this->getUsoInfraestructuraRepository()->getUsoInfraestructuraForUser($relations)->select('id', 'actividad_id', 'tipo_usoinfraestructura', 'fecha', 'asesoria_directa', 'asesoria_indirecta', 'descripcion', 'estado', 'created_at')->whereHas('actividad.gestor.user', function ($query) use ($user) {
                    $query->where('id', $user);
                })->get();
                break;
            case User::IsTalento():
                $usoinfraestructura = $this->getUsoInfraestructuraRepository()->getUsoInfraestructuraForUser($relations)->select('id', 'actividad_id', 'tipo_usoinfraestructura', 'fecha', 'asesoria_directa', 'asesoria_indirecta', 'descripcion', 'estado', 'created_at')->whereHas('actividad.articulacion_proyecto.talentos.user', function ($query) use ($user) {
                    $query->where('id', $user);
                })->orderBy('id', 'DESC')->get();
                break;
            default:
                return abort('403');
                break;
        }

        if (request()->ajax()) {
            return datatables()->of($usoinfraestructura)
                ->editColumn('fecha', function ($data) {
                    return $data->fecha->isoFormat('LL');
                })
                ->editColumn('actividad', function ($data) {
                    return $data->actividad->codigo_actividad . ' - ' . $data->actividad->nombre;
                })
                ->editColumn('asesoria_directa', function ($data) {
                    if ($data->asesoria_directa == 0) {
                        return 'no registra';
                    }
                    return $data->asesoria_directa . '  horas';
                })
                ->editColumn('asesoria_indirecta', function ($data) {
                    if ($data->asesoria_indirecta == 0) {
                        return 'no registra';
                    }
                    return $data->asesoria_indirecta . '  horas';
                })
                ->addColumn('detail', function ($data) {

                    $button = '<a class="  btn tooltipped blue-grey m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Ver detalle" href="' . route("usoinfraestructura.show", $data->id) . '" ><i class="material-icons">info_outline</i></a>';

                    return $button;
                })
                ->addColumn('edit', function ($data) {

                    $button = '<a href="' . route("usoinfraestructura.edit", $data->id) . '" class=" btn tooltipped m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Editar"><i class="material-icons">edit</i></a>';

                    return $button;
                })
                ->rawColumns(['fecha', 'actividad', 'asesoria_directa', 'asesoria_indirecta', 'detail', 'edit'])
                ->make(true);
        }

        // return $usoinfraestructura;
        return view('usoinfraestructura.index', [
            'nodos' => Nodo::selectNodo()->pluck('nodos', 'id'),
        ]);

    }

    public function getUsoInfraestructuraForNodo(int $nodo)
    {

        $this->authorize('getUsoInfraestructuraForNodo', UsoInfraestructura::class);
        $relations          = $this->getDataIndex();
        $usoinfraestructura = $this->getUsoInfraestructuraRepository()->getUsoInfraestructuraForUser($relations)->select('id', 'actividad_id', 'tipo_usoinfraestructura', 'fecha', 'asesoria_directa', 'asesoria_indirecta', 'descripcion', 'estado', 'created_at')->whereHas('actividad.nodo', function ($query) use ($nodo) {
            $query->where('id', $nodo);
        })->get();

        if (request()->ajax()) {
            return datatables()->of($usoinfraestructura)
                ->editColumn('fecha', function ($data) {
                    return $data->fecha->isoFormat('LL');
                })
                ->editColumn('actividad', function ($data) {
                    return $data->actividad->codigo_actividad . ' - ' . $data->actividad->nombre;
                })
                ->editColumn('asesoria_directa', function ($data) {
                    if ($data->asesoria_directa == 0) {
                        return 'no registra';
                    }
                    return $data->asesoria_directa . '  horas';
                })
                ->editColumn('asesoria_indirecta', function ($data) {
                    if ($data->asesoria_indirecta == 0) {
                        return 'no registra';
                    }
                    return $data->asesoria_indirecta . '  horas';
                })
                ->addColumn('detail', function ($data) {

                    $button = '<a class="  btn tooltipped blue-grey m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Ver detalle" href="' . route("usoinfraestructura.show", $data->id) . '"><i class="material-icons">info_outline</i></a>';

                    return $button;
                })

                ->rawColumns(['fecha', 'actividad', 'asesoria_directa', 'asesoria_indirecta', 'detail'])
                ->make(true);
        } else {
            abort('403');
        }
    }

    private function getDataIndex()
    {
        return [
            'actividad'                                                                      => function ($query) {
                $query->select('id', 'gestor_id', 'nodo_id', 'codigo_actividad', 'nombre', 'fecha_inicio', 'fecha_cierre', 'created_at');
            },
            'actividad.nodo'                                                                 => function ($query) {
                $query->select('id', 'entidad_id', 'direccion', 'telefono');
            },
            'actividad.nodo.entidad'                                                         => function ($query) {
                $query->select('id', 'ciudad_id', 'nombre', 'email_entidad');
            },
            'actividad.nodo.entidad.ciudad.departamento',
            'actividad.articulacion_proyecto'                                                => function ($query) {
                $query->select('id', 'entidad_id', 'actividad_id', 'revisado_final', 'acta_inicio', 'actas_seguimiento', 'acta_cierre');
            },
            'actividad.articulacion_proyecto.talentos',
            'actividad.articulacion_proyecto.talentos.user'                                  => function ($query) {
                $query->select('id', 'documento', 'nombres', 'apellidos');
            },
            'actividad.articulacion_proyecto.proyecto'                                       => function ($query) {
                $query->select('id', 'articulacion_proyecto_id', 'sector_id', 'sublinea_id', 'areaconocimiento_id', 'estadoproyecto_id', 'tipoarticulacionproyecto_id', 'estadoprototipo_id', 'estado_aprobacion');
            },
            'actividad.articulacion_proyecto.proyecto.sector'                                => function ($query) {
                $query->select('id', 'nombre');
            },
            'actividad.articulacion_proyecto.proyecto.tipoproyecto'                          => function ($query) {
                $query->select('id', 'nombre');
            },
            'actividad.articulacion_proyecto.proyecto.areaconocimiento'                      => function ($query) {
                $query->select('id', 'nombre');
            },
            'actividad.articulacion_proyecto.proyecto.sublinea'                              => function ($query) {
                $query->select('id', 'nombre');
            },
            'actividad.articulacion_proyecto.proyecto.estadoproyecto'                        => function ($query) {
                $query->select('id', 'nombre');
            },
            'actividad.articulacion_proyecto.articulacion'                                   => function ($query) {
                $query->select('id', 'articulacion_proyecto_id', 'tipoarticulacion_id', 'tipo_articulacion', 'fecha_ejecucion', 'observaciones', 'estado');
            },
            'actividad.articulacion_proyecto.articulacion.tipoarticulacion'                  => function ($query) {
                $query->select('id', 'nombre', 'articulado_con');
            },

            'actividad.edt.entidades',
            'actividad.edt.entidades.empresa'                                                => function ($query) {
                $query->select('id', 'entidad_id', 'sector_id', 'nit', 'direccion');
            },
            'actividad.edt.entidades.empresa.sector'                                         => function ($query) {
                $query->select('id', 'nombre');
            },
            'actividad.edt.entidades.ciudad',
            'actividad.edt.entidades.ciudad.departamento',
            'actividad.edt.areaconocimiento'                                                 => function ($query) {
                $query->select('id', 'nombre');
            },
            'actividad.edt.tipoedt'                                                          => function ($query) {
                $query->select('id', 'nombre');
            },
            'actividad.gestor'                                                               => function ($query) {
                $query->select('id', 'user_id', 'nodo_id', 'lineatecnologica_id');
            },
            'actividad.gestor.nodo'                                                          => function ($query) {
                $query->select('id', 'entidad_id', 'direccion', 'telefono');
            },
            'actividad.gestor.nodo.entidad'                                                  => function ($query) {
                $query->select('id', 'ciudad_id', 'nombre', 'email_entidad');
            },
            'actividad.gestor.nodo.entidad.ciudad.departamento',
            'actividad.gestor.lineatecnologica'                                              => function ($query) {
                $query->select('id', 'nombre', 'abreviatura');
            },
            'actividad.gestor.user'                                                          => function ($query) {
                $query->select('id', 'documento', 'nombres', 'apellidos');
            },
            'actividad.articulacion_proyecto.actividad.gestor.lineatecnologica.laboratorios' => function ($query) {
                $query->select('id', 'nodo_id', 'lineatecnologica_id', 'nombre');
            },
            'actividad.articulacion_proyecto.actividad.gestor.lineatecnologica.lineastecnologicasnodos.equipos',
            'usotalentos',
            'usotalentos.user'                                                               => function ($query) {
                $query->select('id', 'documento', 'nombres', 'apellidos');
            },
            'usoequipos',
            'usoequipos.lineatecnologicanodo.nodo'                                                                => function ($query) {
                $query->select('id', 'entidad_id', 'direccion', 'telefono');
            },
            'usoequipos.lineatecnologicanodo.nodo.entidad'                                                        => function ($query) {
                $query->select('id', 'ciudad_id', 'nombre', 'email_entidad');
            },
            'usoequipos.lineatecnologicanodo.nodo.entidad.ciudad.departamento',
            'usoequipos.lineatecnologicanodo.lineatecnologica'                                               => function ($query) {
                $query->select('id', 'nombre', 'abreviatura');
            },
            'usolaboratorios',
            'usolaboratorios.nodo'                                                           => function ($query) {
                $query->select('id', 'entidad_id', 'direccion', 'telefono');
            },
            'usolaboratorios.nodo.entidad'                                                   => function ($query) {
                $query->select('id', 'ciudad_id', 'nombre', 'email_entidad');
            },
            'usolaboratorios.nodo.entidad.ciudad.departamento',
            'usolaboratorios.lineatecnologica'                                               => function ($query) {
                $query->select('id', 'nombre', 'abreviatura');
            },

        ];
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
        $date = Carbon\Carbon::now()->format('Y-m-d');

        if (Session::has('login_role') && Session::get('login_role') == User::IsGestor()) {
            $edt        = $this->getDataEdtForUser()->count();
            $sumasArray = [
                'articulaciones' => $artulaciones,
                'edt'            => $edt,
                'projects'       => $projects,
            ];
            $cantActividades = array_sum($sumasArray);

            $relations = [
                'user' => function($query){
                    $query->select('id', 'documento', 'nombres', 'apellidos');
                },
                'lineatecnologica' => function($query){
                    $query->select('id', 'nombre', 'abreviatura');
                },
            ];
            $user = auth()->user()->id;
            $nodo = auth()->user()->gestor->nodo->id;
            $gestores = $this->getGestorRepository()->getInfoGestor($relations)
            ->whereHas('user', function ($query) use($user){
                $query->where('id', '!=', $user)->where('estado', User::IsActive());
            })
            ->whereHas('nodo', function ($query) use($nodo){
                $query->where('id', $nodo );
            })->get();

            $nodo = auth()->user()->gestor->nodo->id;
            $lineastecnologicas = $this->getLineaTecnologicaRepository()->findLineasByIdNameForNodo($nodo);
            // return $lineas;
        

            return view('usoinfraestructura.create', [
                'gestores'            => $gestores,
                'lineastecnologicas'            => $lineastecnologicas,
                'authUser'            => auth()->user(),
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
                'authUser'            => auth()->user(),
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

        $relations          = $this->getDataIndex();
        $usoinfraestructura = $this->getUsoInfraestructuraRepository()->getUsoInfraestructuraForUser($relations)
            ->select('id', 'actividad_id', 'tipo_usoinfraestructura', 'fecha', 'asesoria_directa', 'asesoria_indirecta', 'descripcion', 'estado', 'created_at')
            ->findOrFail($id);

        $this->authorize('show', $usoinfraestructura);

        return view('usoinfraestructura.show', [
            'usoinfraestructura' => $usoinfraestructura,
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

        $relations          = $this->getDataIndex();
        $usoinfraestructura = $this->getUsoInfraestructuraRepository()->getUsoInfraestructuraForUser($relations)
            ->select('id', 'actividad_id', 'tipo_usoinfraestructura', 'fecha', 'asesoria_directa', 'asesoria_indirecta', 'descripcion', 'estado', 'created_at')
            ->findOrFail($id);

        $this->authorize('edit', $usoinfraestructura);

        $date = Carbon\Carbon::now()->format('Y-m-d');

        return view('usoinfraestructura.edit', [
            'usoinfraestructura' => $usoinfraestructura,
            'date'               => $date,
            'authUser'           => auth()->user(),
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
        $relations          = $this->getDataIndex();
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
                ->editColumn('tipoarticulacion', function ($data) {
                    return $data->tipoarticulacion->nombre;
                })
                ->rawColumns(['checkbox', 'codigo_actividad', 'nombre', 'tipoarticulacion'])->make(true);
        } else {
            abort('403');
        }

    }

    private function getDataArticulaciones()
    {
        $user = auth()->user()->documento;

        $estado = [
            Articulacion::IsInicio(),
            Articulacion::IsEjecucion(),
        ];

        $relations = [
            'tipoarticulacion'                => function ($query) {
                $query->select('id', 'nombre');
            },
            'articulacion_proyecto',
            'articulacion_proyecto.actividad' => function ($query) {
                $query->select('id', 'codigo_actividad', 'nombre', 'fecha_inicio');
            },
        ];

        if (Session::has('login_role') && Session::get('login_role') == User::IsGestor()) {

            return $this->getUsoIngraestructuraArtculacionRepository()->getArticulacionesForUser($relations)->whereHas('articulacion_proyecto.actividad.gestor.user', function ($query) use ($user) {
                $query->where('documento', $user);
            })->estadoOfArticulaciones($estado)->get();

        } else if (Session::has('login_role') && Session::get('login_role') == User::IsTalento()) {

            return $this->getUsoIngraestructuraArtculacionRepository()->getArticulacionesForUser($relations)->whereHas('articulacion_proyecto.talentos.user', function ($query) use ($user) {
                $query->where('documento', $user);
            })->estadoOfArticulaciones($estado)->where('tipo_articulacion', Articulacion::IsEmprendedor())->get();

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

        $estado = [
            'Inicio',
            'Planeación',
            'En ejecución',
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

            return $this->getUsoIngraestructuraProyectoRepository()->getProjectsForUser($relations, $estado)
                ->whereHas('articulacion_proyecto.actividad.gestor.user', function ($query) use ($user) {
                    $query->where('documento', $user);
                })->where('estado_aprobacion', Proyecto::IsAceptado())->get();

        } else if (Session::has('login_role') && Session::get('login_role') == User::IsTalento()) {

            return $this->getUsoIngraestructuraProyectoRepository()->getProjectsForUser($relations, $estado)->whereHas('articulacion_proyecto.talentos.user', function ($query) use ($user) {
                $query->where('documento', $user);
            })->where('estado_aprobacion', Proyecto::IsAceptado())->get();
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
            $relations = [
                'articulacion_proyecto'                                                => function ($query) {
                    $query->select('id', 'actividad_id');
                },
                'articulacion_proyecto.actividad'                                      => function ($query) {
                    $query->select('id', 'gestor_id', 'nodo_id', 'codigo_actividad', 'nombre');
                },
                'articulacion_proyecto.talentos.user'                                  => function ($query) {
                    $query->select('id', 'documento', 'nombres', 'apellidos');
                },
                'articulacion_proyecto.actividad.gestor'                               => function ($query) {
                    $query->select('id', 'user_id', 'nodo_id', 'lineatecnologica_id');
                },
                'articulacion_proyecto.actividad.gestor.user'                          => function ($query) {
                    $query->select('id', 'documento', 'nombres', 'apellidos');
                },
                'articulacion_proyecto.actividad.gestor.lineatecnologica'              => function ($query) {
                    $query->select('id', 'nombre', 'abreviatura');
                },
                'articulacion_proyecto.actividad.gestor.lineatecnologica.laboratorios' => function ($query) {
                    $query->select('id', 'nodo_id', 'lineatecnologica_id', 'nombre');
                },
                'articulacion_proyecto.actividad.gestor.lineatecnologica.lineastecnologicasnodos.equipos',
                'articulacion_proyecto.actividad.gestor.lineatecnologica.lineastecnologicasnodos.nodo.lineas',
            ];

            $estado = [
                'Inicio',
                'Planeación',
                'En ejecución',
            ];

            $proyectoTalento = $this->getUsoIngraestructuraProyectoRepository()->getProjectsForUser($relations, $estado)
                ->where('estado_aprobacion', Proyecto::IsAceptado())->where('id', $id)->get();

            return response()->json([
                'data' => $proyectoTalento,
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
            $estado = [
                Articulacion::IsInicio(),
                Articulacion::IsEjecucion(),
            ];

            $relations = [
                'tipoarticulacion'                                                     => function ($query) {
                    $query->select('id', 'nombre');
                },
                'articulacion_proyecto'                                                => function ($query) {
                    $query->select('id', 'actividad_id');
                },
                'articulacion_proyecto.actividad'                                      => function ($query) {
                    $query->select('id', 'gestor_id', 'nodo_id', 'codigo_actividad', 'nombre');
                },

                'articulacion_proyecto.talentos.user'                                  => function ($query) {
                    $query->select('id', 'documento', 'nombres', 'apellidos');
                },

                'articulacion_proyecto.actividad.gestor'                               => function ($query) {
                    $query->select('id', 'user_id', 'nodo_id', 'lineatecnologica_id');
                },
                'articulacion_proyecto.actividad.gestor.user'                          => function ($query) {
                    $query->select('id', 'documento', 'nombres', 'apellidos');
                },
                'articulacion_proyecto.actividad.gestor.lineatecnologica'              => function ($query) {
                    $query->select('id', 'nombre', 'abreviatura');
                },
                'articulacion_proyecto.actividad.gestor.lineatecnologica.laboratorios' => function ($query) {
                    $query->select('id', 'nodo_id', 'lineatecnologica_id', 'nombre');
                },
                'articulacion_proyecto.actividad.gestor.lineatecnologica.lineastecnologicasnodos.equipos',
            ];

            $artulaciones = $this->getUsoIngraestructuraArtculacionRepository()->getArticulacionesForUser($relations)
                ->estadoOfArticulaciones($estado)
                ->where('id', $id)->get();

            return response()->json([
                'data' => $artulaciones,
            ]);
        } else {
            abort('403');
        }

    }

    public function usoinfraestructuraEquipos()
    {
        if (request()->ajax()) {
            $equipos = null;
            if (Session::has('login_role') && Session::get('login_role') == User::IsGestor()) {

                $equipos = auth()->user()->gestor->lineatecnologica->lineastecnologicasnodos->each(function ($item, $key) {
                    $item->equipos;
                });

            } else if (Session::has('login_role') && Session::get('login_role') == User::IsTalento()) {
                $estado = [
                    Articulacion::IsInicio(),
                    Articulacion::IsEjecucion(),
                ];
                $relations = [
                    'tipoarticulacion'                                                => function ($query) {
                        $query->select('id', 'nombre');
                    },
                    'articulacion_proyecto'                                           => function ($query) {
                        $query->select('id', 'actividad_id');
                    },
                    'articulacion_proyecto.actividad'                                 => function ($query) {
                        $query->select('id', 'gestor_id', 'nodo_id', 'codigo_actividad', 'nombre');
                    },
                    'articulacion_proyecto.talentos.user'                             => function ($query) {
                        $query->select('id', 'documento', 'nombres', 'apellidos');
                    },
                    'articulacion_proyecto.actividad.gestor'                          => function ($query) {
                        $query->select('id', 'user_id', 'nodo_id', 'lineatecnologica_id');
                    },
                    'articulacion_proyecto.actividad.gestor.lineatecnologica'         => function ($query) {
                        $query->select('id', 'nombre', 'abreviatura');
                    },
                    'articulacion_proyecto.actividad.gestor.lineatecnologica.lineastecnologicasnodos.equipos',
                ];

                $user = auth()->user()->documento;

                $equipos = $this->getUsoIngraestructuraArtculacionRepository()->getArticulacionesForUser($relations)->estadoOfArticulaciones($estado)->where('tipo_articulacion', Articulacion::IsEmprendedor())
                    ->whereHas('articulacion_proyecto.talentos.user', function ($query) use ($user) {
                        $query->where('documento', $user);
                    })
                    ->get();

            }

            return response()->json([
                'data' => $equipos,
            ]);
        } else {
            abort('403');
        }

    }

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
     * Asigna un valor a $UsoInfraestructuraArticulacionRepository
     * @param object $UsoInfraestructuraArticulacionRepository
     * @return void
     * @author devjul
     */
    private function setUsoInfraestructuraRepository($UsoInfraestructuraRepository)
    {
        $this->UsoInfraestructuraRepository = $UsoInfraestructuraRepository;
    }

    /**
     * Retorna el valor de $UsoInfraestructuraEdtRepository
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

}
