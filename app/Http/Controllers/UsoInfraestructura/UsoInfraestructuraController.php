<?php

namespace App\Http\Controllers\UsoInfraestructura;

use App\Http\Controllers\Controller;
use App\Models\Articulacion;
use App\Models\Edt;
use App\Models\UsoInfraestructura;
use App\Repositories\Repository\EdtRepository;
use Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UsoInfraestructuraController extends Controller
{

    protected $edtRepostory;
    public function __construct(EdtRepository $edtRepostory)
    {
        $this->middleware('role_session:Administrador|Dinamizador|Gestor|Talento');
        $this->edtRepostory = $edtRepostory;

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

        $user = auth()->user()->documento;

        $edt = $this->edtRepostory->findEdtByUser([
            'actividad.gestor.user',
        ])->whereHas('actividad.gestor.user', function ($query) use ($user) {
            $query->where('documento', $user);
        })->where('estado', Edt::IsActive())->get();

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

    /*=====  End of metodo para consultar las articulaciones por gestor  ======*/
    /**
     * retorna query con las articulaciones en fase Inicio, En ejecución por usuarios
     * @return collection
     * @author devjul
     */
    // public function articulacionesForUser()
    // {

    //     $user = auth()->user()->documento;

    //     $estado = [
    //         Articulacion::IsInicio(),
    //         Articulacion::IsEjecucion(),
    //     ];

    //     $relations = [
    //         'articulacion_proyecto',
    //         'articulacion_proyecto.actividad' => function ($query) {
    //             $query->select('id', 'codigo_actividad', 'nombre', 'fecha_inicio');
    //         },
    //     ];

    //     $artulaciones = null;

    //     if (Session::has('login_role') && Session::get('login_role') == User::IsGestor()) {

    //         return $this->articulacionRepository->getArticulacionesForUser($relations)->whereHas('articulacion_proyecto.actividad.gestor.user', function ($query) use ($user) {
    //             $query->where('documento', $user);
    //         })->estadoOfArticulaciones($estado)->get();

    //     } else if (Session::has('login_role') && Session::get('login_role') == User::IsTalento()) {

    //         return $this->articulacionRepository->getArticulacionesForUser($relations)->whereHas('articulacion_proyecto.talentos.user', function ($query) use ($user) {
    //             $query->where('documento', $user);
    //         })->estadoOfArticulaciones($estado)->get();

    //     }

    // }

    // /*========================================================================
    // =            metodo para consultar los proyectos de un ususario gestor talento         =
    // ========================================================================*/

    // public function getProjectsForUser(array $relations, array $estado = [])
    // {
    //     return Proyecto::estadoOfProjects($relations, $estado);
    // }

    /*=====  End of metodo para consultar los proyectos de un gestor o talento  ======*/
}
