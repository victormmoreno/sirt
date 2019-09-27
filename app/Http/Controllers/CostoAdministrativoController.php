<?php

namespace App\Http\Controllers;

use App\Models\CostoAdministrativo;
use App\Models\Nodo;
use App\Repositories\Repository\CostoAdministrativoRepository;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Repositories\Repository\NodoRepository;

class CostoAdministrativoController extends Controller
{
    private $costoAdministrativoRepository;
    private $nodoRepository;

    public function __construct(CostoAdministrativoRepository $costoAdministrativoRepository, NodoRepository $nodoRepository)
    {
        $this->costoAdministrativoRepository = $costoAdministrativoRepository;
        $this->nodoRepository                = $nodoRepository;
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

                $nodo   = auth()->user()->dinamizador->nodo->id;
                $costos = $this->getCostoAdministrativoRepository()->getInfoCostoAdministrativo()
                    ->where('nodo_costoadministrativo.anho', Carbon::now()->year)
                    ->where('nodos.id', $nodo)
                    ->get();
                return datatables()->of($costos)
                    ->addColumn('edit', function ($data) {
                        $button = '<a href="' . route("costoadministrativo.edit", $data->id) . '" class=" btn tooltipped m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Editar"><i class="material-icons">edit</i></a>';

                        return $button;
                    })
                    ->addColumn('costosadministrativospordia', function ($data) {
                        return '$ '.number_format(round($data->valor/CostoAdministrativo::DIAS_AL_MES,2));
                    })
                    ->addColumn('costosadministrativosporhora', function ($data) {
                        return '$ '.number_format(round(($data->valor/CostoAdministrativo::DIAS_AL_MES)/CostoAdministrativo::HORAS_AL_DIA,2));
                    })
                    ->editColumn('valor', function($data){
                         return '$ '.number_format($data->valor);
                    })
                    ->editColumn('entidad', function($data){
                         return 'Tecnoparque Nodo '.$data->entidad;
                    })
                    ->rawColumns(['edit', 'costosadministrativospordia', 'costosadministrativosporhora'])
                    ->make(true);
            } else {
                abort('403');
            }

        }

        switch (Session::get('login_role')) {
            case User::IsAdministrador():
                return view('costoadministrativo.index', [
                    'nodos' => $this->getNodoRepository()->getSelectNodo(),
                ]);
                break;
            case User::IsDinamizador():
                $nodo = auth()->user()->dinamizador->nodo->id;
                // $costos = Nodo::findOrFail($nodo)->costoadministrativonodo()->wherePivot('anho', '=', Carbon::now()->year)->get();
                // $data = (CostoAdministrativo::HORAS_AL_DIA * CostoAdministrativo::DIAS_AL_MES);
                // return $data;
                $costos = $this->getCostoAdministrativoRepository()->getInfoCostoAdministrativo()
                    ->where('nodo_costoadministrativo.anho', Carbon::now()->year)
                    ->where('nodos.id', $nodo)
                    ->get();

                // return $costos;
                return view('costoadministrativo.index');
                break;
            default:
                return abort('403');
                break;
        }

    }
    /**
     * devolver datatables Costo Administrativo por nodo.
     *
     * @param  int nodo
     * @return \Illuminate\Http\Response
     */
    public function getCostoAdministrativoPorNodo($nodo)
    {

        if (request()->ajax()) {

            if (session()->has('login_role') && session()->get('login_role') == User::IsAdministrador()) {
                $costos = $this->getCostoAdministrativoRepository()->getInfoCostoAdministrativo()
                    ->where('nodo_costoadministrativo.anho', Carbon::now()->year)
                    ->where('nodos.id', $nodo)
                    ->get();

                return datatables()->of($costos)
                    ->addColumn('edit', function ($data) {

                        $button = '<a href="' . route("costoadministrativo.edit", $data->id) . '" class=" btn tooltipped m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Editar"><i class="material-icons">edit</i></a>';

                        return $button;
                    })
                    ->editColumn('valor', function($data){
                         return '$ '.$data->valor;
                    })
                    ->addColumn('costosadministrativospordia', function ($data) {

                        return '$ '.round($data->valor/CostoAdministrativo::DIAS_AL_MES,2);
                    })
                    ->rawColumns(['edit', 'costosadministrativospordia'])
                    ->make(true);
            } else {
                return response()->json(['data' => 'no response']);
            }

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
        $costo = CostoAdministrativo::findOrFail($id);
        $past = $costo->nodocostosadministrativos()
            ->wherePivot('anho', Carbon::now()->year)
            ->get();

        // return $past;
        // return CostoAdministrativo::with(['nodocostosadministrativos'])
        // // ->whereHas('nodocostosadministrativos', function($query){
        // //     $query->where('id',1);
        // // })
        // ->get();
        return CostoAdministrativo::select('nodos.id', 'entidades.slug', 'entidades.nombre as entidad', 'entidades.email_entidad', 'nodo_costoadministrativo.valor', 'nodo_costoadministrativo.anho', 'costos_administrativos.nombre as costoadministrativo')
            ->join('nodo_costoadministrativo', 'nodo_costoadministrativo.costo_administrativo_id', '=', 'costos_administrativos.id')
            ->join('nodos', 'nodos.id', '=', 'nodo_costoadministrativo.nodo_id')
            ->join('entidades', 'entidades.id', '=', 'nodos.entidad_id')
            ->where('nodo_costoadministrativo.anho', Carbon::now()->year)
            ->where('nodos.id',auth()->user()->dinamizador->nodo->id)

            ->findOrFail($id);
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
