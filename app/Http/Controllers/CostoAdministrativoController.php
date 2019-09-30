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
                $costos = $this->getCostoAdministrativoRepository()->getInfoCostoAdministrativoNodo()
                    ->where('nodo_costoadministrativo.anho', Carbon::now()->year)
                    ->where('nodos.id', $nodo)
                    ->get();
                return datatables()->of($costos)
                    ->addColumn('edit', function ($data) {
                        $button = '<a href="' . route("costoadministrativo.edit", $data->id) . '" class=" btn tooltipped m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Editar"><i class="material-icons">edit</i></a>';

                        return $button;
                    })
                    ->addColumn('costosadministrativospordia', function ($data) {
                        return '$ ' . number_format(round($data->valor / CostoAdministrativo::DIAS_AL_MES, 2));
                    })
                    ->addColumn('costosadministrativosporhora', function ($data) {
                        return '$ ' . number_format(round(($data->valor / CostoAdministrativo::DIAS_AL_MES) / CostoAdministrativo::HORAS_AL_DIA, 2));
                    })
                    ->editColumn('valor', function ($data) {
                        return '$ ' . number_format($data->valor);
                    })
                    ->editColumn('entidad', function ($data) {
                        return 'Tecnoparque Nodo ' . $data->entidad;
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
                $costos = $this->getCostoAdministrativoRepository()->getInfoCostoAdministrativoNodo()
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
                $costos = $this->getCostoAdministrativoRepository()->getInfoCostoAdministrativoNodo()
                    ->where('nodo_costoadministrativo.anho', Carbon::now()->year)
                    ->where('nodos.id', $nodo)
                    ->get();

                return datatables()->of($costos)
                    ->addColumn('edit', function ($data) {

                        $button = '<a href="' . route("costoadministrativo.edit", $data->id) . '" class=" btn tooltipped m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Editar"><i class="material-icons">edit</i></a>';

                        return $button;
                    })
                    ->editColumn('valor', function ($data) {
                        return '$ ' . number_format($data->valor);
                    })
                    ->addColumn('costosadministrativosporhora', function ($data) {
                        return '$ ' . number_format(round(($data->valor / CostoAdministrativo::DIAS_AL_MES) / CostoAdministrativo::HORAS_AL_DIA, 2));
                    })
                    ->addColumn('costosadministrativospordia', function ($data) {

                        return '$ ' . number_format(round($data->valor / CostoAdministrativo::DIAS_AL_MES, 2));
                    })
                    ->rawColumns(['edit', 'costosadministrativospordia', 'costosadministrativosporhora'])
                    ->make(true);
            } else {
                return response()->json(['data' => 'no response']);
            }

        } else {
            abort('403');
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

        $costoAdministrativo = $this->getCostoAdministrativoRepository()->getInfoCostoAdministrativo()
            ->where('nodo_costoadministrativo.anho', Carbon::now()->year)
            ->where('nodos.id', auth()->user()->dinamizador->nodo->id)
            ->findOrFail($id);

        $this->authorize('edit', $costoAdministrativo);

        return view('costoadministrativo.edit', [
            'costoadministrativo' => $costoAdministrativo,
        ]);

    }

    /**
     * Update the specified resource in storage.
     * @param  int  $id
     */
    public function update(Request $request, $id)
    {
        $costoAdministrativo = $this->getCostoAdministrativoRepository()->getInfoCostoAdministrativo()
            ->where('nodo_costoadministrativo.anho', Carbon::now()->year)
            ->where('nodos.id', auth()->user()->dinamizador->nodo->id)
            ->findOrFail($id);

        $this->authorize('update', $costoAdministrativo);

        $this->validateCostoAdministrativo($request);

        $responseCostoAdministrativo = $this->getCostoAdministrativoRepository()->update($request, $costoAdministrativo);

        if ($responseCostoAdministrativo == true) {
            
            alert()->success("El Costo Administrativo ha sido  modificado.", 'Modificación Exitosa', "success");
        } else {
            alert()->error("El Costo Administrativo ha sido  modificado.", 'Modificación Errónea', "error");
        }

        return redirect()->route('costoadministrativo.index');
    }

    /**
     * Validate the user costo administrativo request.
     *
     * 
     */
    protected function validateCostoAdministrativo(Request $request)
    {
        $this->validate($request, [
            'txtvalor' => 'required|numeric|between:0,999999999999.99',
        ], [
            'txtvalor.required' => 'El valor es obligatorio',
            'txtvalor.numeric'  => 'El valor es debe ser numérico',
            'txtvalor.between'  => 'El valor es debe estar entre 0 y 999999999999.99',
        ]);
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
