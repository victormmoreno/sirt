<?php

namespace App\Http\Controllers;

use App\Models\CostoAdministrativo;
use App\Models\Nodo;
use App\User;
use Carbon\Carbon;
use App\Repositories\Repository\CostoAdministrativoRepository;
use Repositories\Repository\NodoRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CostoAdministrativoController extends Controller
{
    private $costoAdministrativoRepository;
    private $nodoRepository;

    public function __construct(CostoAdministrativoRepository $costoAdministrativoRepository,  NodoRepository $nodoRepository)
    {
        $this->costoAdministrativoRepository = $costoAdministrativoRepository;
        $this->nodoRepository = $nodoRepository;
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

        if (request()->ajax()) {
             
            if (session()->has('login_role') && session()->get('login_role') == User::IsDinamizador()) {

                $nodo = auth()->user()->dinamizador->nodo->id;
                $costos = Nodo::findOrFail($nodo)->costoadministrativonodo()->wherePivot('anho', '=', Carbon::now()->year)->get();
                return datatables()->of($costos)
                    
                   

                    ->addColumn('edit', function ($data) {

                        $button = '<a href="' . route("laboratorio.edit", $data->id) . '" class=" btn tooltipped m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Editar"><i class="material-icons">edit</i></a>';

                        return $button;
                    })
                    ->rawColumns(['materiales', 'estado', 'lineatecnologica', 'participacion_costos', 'edit'])
                    ->make(true);
            }

        }

        switch (Session::get('login_role')) {
            case User::IsAdministrador():
                return view('costoadministrativo.index',[
                    'nodos' => $this->getNodoRepository()->getSelectNodo(),
                ]);
                break;
            case User::IsDinamizador():
               $nodo = auth()->user()->dinamizador->nodo->id;
                // $costos = Nodo::findOrFail($nodo)->costoadministrativonodo()->wherePivot('anho', '=', Carbon::now()->year)->get();
               $costos = Nodo::findOrFail($nodo)->with(['entidad', 'costoadministrativonodo'])->whereHas('costoadministrativonodo', function($query){
                    $query->where('costoadministrativonodo.anho') = Carbon::now()->year;
               });
                return $costos;
                return view('costoadministrativo.index');
                break;
            default:
                return abort('403');
                break;
        }
        
        
    }
     /**
     * devolver datatables laboratorio por nodo.
     *
     * @param  int nodo
     * @return \Illuminate\Http\Response
     */
    public function getCostoAdministrativoPorNodo($nodo)
    {

        if (request()->ajax()) {
            return datatables()->of($this->laboratorioRepository->findLaboratorioForNodo($nodo))
                

                ->addColumn('edit', function ($data) {

                    $button = '<a href="' . route("laboratorio.edit", $data->id) . '" class=" btn tooltipped m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Editar"><i class="material-icons">edit</i></a>';

                    return $button;
                })
                ->rawColumns(['edit'])
                ->make(true);
        }
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


    /**
     * Asigna un valor a $nodoRepository
     * @param object $nodoRepository
     * @return void
     * @author devjul
     */
    private function setNodoRepository($nodoRepository)
    {
        $this->nodoRepository = $nodoRepository;
    }

    /**
     * Retorna el valor de $nodoRepository
     * @return object
     * @author devjul
     */
    private function getNodoRepository()
    {
        return $this->nodoRepository;
    }
}
