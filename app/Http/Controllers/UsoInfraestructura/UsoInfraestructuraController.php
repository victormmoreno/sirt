<?php

namespace App\Http\Controllers\UsoInfraestructura;

use App\Http\Controllers\Controller;
use App\Models\Articulacion;
use App\Models\Edt;
use App\Models\Proyecto;
use App\Models\UsoInfraestructura;
use App\Repositories\Repository\ArticulacionRepository;
use App\Repositories\Repository\EdtRepository;
use App\Repositories\Repository\ProyectoRepository;
use App\User;
use Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UsoInfraestructuraController extends Controller
{

    private $UsoInfraestructuraEdtRepository;
    private $UsoInfraestructuraProyectoRepository;
    private $UsoInfraestructuraArticulacionRepository;

    public function __construct(
        ProyectoRepository $UsoInfraestructuraProyectoRepository,
        EdtRepository $UsoInfraestructuraEdtRepository,
        ArticulacionRepository $setUsoIngraestructuraArtculacionRepository
    ) {
        $this->middleware('role_session:Administrador|Dinamizador|Gestor|Talento');
        $this->setUsoIngraestructuraProyectoRepository($UsoInfraestructuraProyectoRepository);
        $this->setUsoIngraestructuraEdtRepository($UsoInfraestructuraEdtRepository);
        $this->setUsoIngraestructuraArtculacionRepository($setUsoIngraestructuraArtculacionRepository);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('index', UsoInfraestructura::class);
        return view('usoinfraestructura.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', UsoInfraestructura::class);

        $date = Carbon\Carbon::now()->format('Y-m-d');
        return view('usoinfraestructura.create', [
            'authUser' => auth()->user(),
            'date'     => $date,
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * retorna query con las articulaciones en fase Inicio, En ejecución por usuarios
     * @return collection
     * @author devjul
     */
    public function articulacionesForUser()
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

        $artulaciones = null;

        if (Session::has('login_role') && Session::get('login_role') == User::IsGestor()) {

            $artulaciones = $this->getUsoIngraestructuraArtculacionRepository()->getArticulacionesForUser($relations)->whereHas('articulacion_proyecto.actividad.gestor.user', function ($query) use ($user) {
                $query->where('documento', $user);
            })->estadoOfArticulaciones($estado)->get();

        } else if (Session::has('login_role') && Session::get('login_role') == User::IsTalento()) {

            $artulaciones = $this->getUsoIngraestructuraArtculacionRepository()->getArticulacionesForUser($relations)->whereHas('articulacion_proyecto.talentos.user', function ($query) use ($user) {
                $query->where('documento', $user);
            })->estadoOfArticulaciones($estado)->where('tipo_articulacion', Articulacion::IsEmprendedor())->get();

        }

        if (request()->ajax()) {

            return datatables()->of($artulaciones)
                ->addColumn('checkbox', function ($data) {
                    $checkbox = '
          <input type="radio" class="with-gap" name="txtarticulacion"
          onclick="usoInfraestructuraCreate.asociarArticulacionAUsoInfraestructura(' . $data->id . ', \'' . $data->articulacion_proyecto->actividad->codigo_actividad . '\', \'' . $data->articulacion_proyecto->actividad->nombre . '\')" id="radioButton' . $data->id . '"
          value="' . $data->id . '"/>
          <label for ="radioButton' . $data->id . '"></label>
          ';
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
        }

    }

    /**
     * retorna query con los proyectos en fase Inicio, Planeación, En ejecución por usuarios
     * @return object
     * @author devjul
     */
    public function projectsForUser()
    {
        $user = auth()->user()->documento;

        $estado = [
            'Inicio',
            'Planeación',
            'En ejecución',
        ];

        $relations = [
            'articulacion_proyecto',
            'articulacion_proyecto.actividad' => function ($query) {
                $query->select('id', 'codigo_actividad', 'nombre', 'fecha_inicio');
            },
        ];

        $projects = null;

        if (Session::has('login_role') && Session::get('login_role') == User::IsGestor()) {

            $projects = $this->getUsoIngraestructuraProyectoRepository()->getProjectsForUser($relations, $estado)
                ->whereHas('articulacion_proyecto.actividad.gestor.user', function ($query) use ($user) {
                    $query->where('documento', $user);
                })->where('estado_aprobacion', Proyecto::IsAceptado())->get();

        } else if (Session::has('login_role') && Session::get('login_role') == User::IsTalento()) {

            $projects = $this->getUsoIngraestructuraProyectoRepository()->getProjectsForUser($relations, $estado)->whereHas('articulacion_proyecto.talentos.user', function ($query) use ($user) {
                $query->where('documento', $user);
            })->where('estado_aprobacion', Proyecto::IsAceptado())->get();
        } else {
            abort('403');
        }

        if (request()->ajax()) {

            return datatables()->of($projects)
                ->addColumn('checkbox', function ($data) {
                    $checkbox = '
          <input type="radio" class="with-gap" name="txtproyecto"
          onclick="usoInfraestructuraCreate.asociarProyectoAUsoInfraestructura(' . $data->id . ', \'' . $data->articulacion_proyecto->actividad->codigo_actividad . '\', \'' . $data->articulacion_proyecto->actividad->nombre . '\')" id="radioButton' . $data->id . '"
          value="' . $data->id . '"/>
          <label for ="radioButton' . $data->id . '"></label>
          ';
                    return $checkbox;
                })->editColumn('codigo_actividad', function ($data) {
                return $data->articulacion_proyecto->actividad->codigo_actividad;
            })
                ->editColumn('nombre', function ($data) {
                    return $data->articulacion_proyecto->actividad->nombre;
                })
                ->rawColumns(['checkbox', 'codigo_actividad'])->make(true);
        }

    }

    /**
     * retorna query con las edt activas  por usuarios
     * @return collection
     * @author devjul
     */

    public function edtsForUser()
    {
        $user = auth()->user()->documento;

        $relations = [
            'actividad'  => function ($query) {
                $query->select('id', 'codigo_actividad', 'nombre', 'fecha_inicio');
            },
            'entidades' => function ($query) {
                $query->select('entidades.id', 'entidades.nombre');
            },
        ];

        if (Session::has('login_role') && Session::get('login_role') == User::IsGestor()) {

            $edt = $this->getUsoIngraestructuraEdtRepository()->findEdtByUser($relations)
                ->whereHas('actividad.gestor.user', function ($query) use ($user) {
                    $query->where('documento', $user);
                })->where('estado', Edt::IsActive())->get();

        }

    }

    /**
     * Asigna un valor a $proyectoRepository
     * @param object $UsoInfraestructuraProyectoRepository
     * @return void type
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

}
