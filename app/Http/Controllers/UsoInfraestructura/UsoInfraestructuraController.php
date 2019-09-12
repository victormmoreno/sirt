<?php

namespace App\Http\Controllers\UsoInfraestructura;

use App\Http\Controllers\Controller;
use App\Models\Edt;
use App\Models\Proyecto;
use App\Models\UsoInfraestructura;
use App\Repositories\Repository\EdtRepository;
use Carbon;
use Illuminate\Http\Request;

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

        $date = Carbon\Carbon::now()->format('Y-m-d');
        $user = auth()->user()->documento;

        $proyectosPorGestor = Proyecto::with([
            'articulacion_proyecto',
            'articulacion_proyecto.talentos',
            'articulacion_proyecto.actividad',
            'articulacion_proyecto.actividad.gestor',
            'articulacion_proyecto.actividad.gestor.user',
        ])->whereHas('articulacion_proyecto.actividad.gestor.user', function ($query) use ($user) {
            $query->where('documento', $user);
        })->get();

        $edt = $this->edtRepostory->findEdtByUser([
            'actividad.gestor.user',
        ])->whereHas('actividad.gestor.user', function ($query) use ($user) {
            $query->where('documento', $user);
        })->where('estado', Edt::IsActive())->get();

        return $edt;

        $proyectosPorTalento = Proyecto::with([
            'articulacion_proyecto',
            'articulacion_proyecto.talentos.user',
        ])->whereHas('articulacion_proyecto.talentos.user', function ($query) use ($user) {
            $query->where('documento', $user);
        })->get();
        return $proyectosPorGestor;

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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
