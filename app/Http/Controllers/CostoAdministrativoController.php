<?php

namespace App\Http\Controllers;

use App\Models\CostoAdministrativo;
use App\Models\Nodo;
use App\User;
use Carbon\Carbon;
use App\Repositories\Repository\CostoAdministrativoRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CostoAdministrativoController extends Controller
{
    private $costoAdministrativoRepository;

    public function __construct(CostoAdministrativoRepository $costoAdministrativoRepository)
    {
        $this->costoAdministrativoRepository = $costoAdministrativoRepository;
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->authorize('index', CostoAdministrativo::class);

        switch (Session::get('login_role')) {
            case User::IsAdministrador():
                return view('costoadministrativo.index');
                break;
            case User::IsDinamizador():
                $nodo = auth()->user()->dinamizador->nodo->id;
                $costos = Nodo::findOrFail($nodo)->costoadministrativonodo()->wherePivot('anho', '=', Carbon::now()->addYears(4)->year)->get();
                return $costos;
                // return view('costoadministrativo.index');
                break;
            default:
                return abort('403');
                break;
        }
        
        
        // $costos = Nodo::findOrFail($nodo)->costoadministrativonodo()->get();
        // return $costos;

        
        
        // $costos = CostoAdministrativo::with([
        //     'nodocostosadministrativos',
        //     'nodocostosadministrativos.entidad',
        //     'nodocostosadministrativos.entidad.nodo',
        // ])->whereHas('nodocostosadministrativos.entidad.nodo', function($query) use($nodo){
        //     $query->where('nodos.id', '=',$nodo);
        // })->where('id',1)->first();
        
        // return $costos;
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

    /**
     * Asigna un valor a $costoAdministrativoRepository
     * @param object $costoAdministrativoRepository
     * @return void
     * @author devjul
     */
    private function setCostoAdministrativoRepository($costoAdministrativoRepository)
    {
        $this->costoAdministrativoRepository = $costoAdministrativoRepository;
    }

    /**
     * Retorna el valor de $costoAdministrativoRepository
     * @return object
     * @author devjul
     */
    private function getCostoAdministrativoRepository()
    {
        return $this->costoAdministrativoRepository;
    }
}
