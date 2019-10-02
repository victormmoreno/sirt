<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Laboratorio;
use App\Repositories\Repository\EquipoRepository;
use App\Repositories\Repository\LaboratorioRepository;
use App\User;
use Illuminate\Http\Request;

class EquipoController extends Controller
{

    public function __construct(EquipoRepository $equipoRepository, LaboratorioRepository $laboratorioRepository)
    {
        $this->equipoRepository      = $equipoRepository;
        $this->laboratorioRepository = $laboratorioRepository;
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('equipo.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Equipo::class);
        if (session()->has('login_role') && session()->get('login_role') == User::IsDinamizador()) {
            $nodoDinamizador = auth()->user()->dinamizador->nodo->id;

            $laboratorios = $this->getLaboratorioRepository()->pluckLaboratorioForNodo($nodoDinamizador)
                ->pluck('nombre', 'laboratorios.id');
            return view('equipo.create', [
                'laboratorios' => $laboratorios,
            ]);
        } else {
            abort('403');
        }

    }

    public function getEquipoPorCodigo($codigo_equipo)
    {
        $equipo = $this->getEquipoRepository()->getEquipoPorCodigo($codigo_equipo)->first();
        return response()->json([
            'equipo' => $equipo,
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
        return $request->all();
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

    /**
     * Asigna un valor a $equipoRepository
     * @param object $equipoRepository
     * @return void
     * @author devjul
     */
    private function setEquipoRepository($equipoRepository)
    {
        $this->equipoRepository = $equipoRepository;
    }

    /**
     * Retorna el valor de $equipoRepository
     * @return object
     * @author devjul
     */
    private function getEquipoRepository()
    {
        return $this->equipoRepository;
    }

    /**
     * Asigna un valor a $laboratorioRepository
     * @param object $laboratorioRepository
     * @return void
     * @author devjul
     */
    private function setLaboratorioRepository($laboratorioRepository)
    {
        $this->laboratorioRepository = $laboratorioRepository;
    }

    /**
     * Retorna el valor de $laboratorioRepository
     * @return object
     * @author devjul
     */
    private function getLaboratorioRepository()
    {
        return $this->laboratorioRepository;
    }
}
