<?php

namespace App\Http\Controllers;

use App\Http\Requests\MantenimientoFormRequest;
use App\Models\EquipoMantenimiento;
use App\Models\Nodo;
use App\Repositories\Repository\LineaRepository;
use App\Repositories\Repository\MantenimientoRepository;
use App\User;
use Illuminate\Http\Request;
use Repositories\Repository\NodoRepository;

class MantenimientoController extends Controller
{

    public function __construct(MantenimientoRepository $mantenimientoRepository, LineaRepository $lineaRepository, NodoRepository $nodoRepository)
    {
        $this->mantenimientoRepository = $mantenimientoRepository;
        $this->lineaRepository         = $lineaRepository;
        $this->nodoRepository          = $nodoRepository;
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('index', EquipoMantenimiento::class);
        if (request()->ajax()) {

            if (session()->has('login_role') && session()->get('login_role') == User::IsDinamizador() || session()->get('login_role') == User::IsGestor()) {

                if (session()->has('login_role') && session()->get('login_role') == User::IsDinamizador()) {
                    $nodo           = auth()->user()->dinamizador->nodo->id;
                    $mantenimientos = $this->getMantenimientoRepository()->findInfoMantenimiento()
                        ->where('nodos.id', auth()->user()->dinamizador->nodo->id)
                        ->get();
                } elseif (session()->has('login_role') && session()->get('login_role') == User::IsGestor()) {
                    $linea          = auth()->user()->gestor->lineatecnologica->id;
                    $nodo           = auth()->user()->gestor->nodo->id;
                    $mantenimientos = $this->getMantenimientoRepository()->findInfoMantenimiento()
                        ->where('nodos.id', $nodo)
                        ->where('lineastecnologicas.id', $linea)
                        ->get();
                }

                return datatables()->of($mantenimientos)
                    ->addColumn('edit', function ($data) {
                        $button = '<a href="' . route("mantenimiento.edit", $data->id) . '" class=" btn tooltipped m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Editar"><i class="material-icons">edit</i></a>';

                        return $button;
                    })
                    ->addColumn('detail', function ($data) {
                        $button = '<a href="' . route("mantenimiento.show", $data->id) . '" class="btn tooltipped blue-grey m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Ver Detalle"><i class="material-icons">info_outline</i></a>';

                        return $button;
                    })

                    ->addColumn('valor_mantenimiento', function ($data) {
                        return '$ ' . number_format(round($data->valor_mantenimiento, 2));
                    })
                    ->editColumn('costo_adquisicion', function ($data) {
                        return '$ ' . number_format($data->costo_adquisicion);
                    })
                    ->editColumn('nombrelinea', function ($data) {
                        return $data->lineatecnologica_abreviatura . ' - ' . $data->lineatecnologica_nombre;
                    })

                    ->rawColumns(['edit', 'detail', 'nombrelinea', 'costo_adquisicion', 'valor_mantenimiento'])
                    ->make(true);
            } else {
                abort('403');
            }

        }
        switch (session()->get('login_role')) {
            case User::IsAdministrador():
                return view('mantenimiento.index', [
                    'nodos' => $this->getNodoRepository()->getSelectNodo(),
                ]);
                break;
            case User::IsDinamizador():
                return view('mantenimiento.index');
                break;
            case User::IsGestor():
                return view('mantenimiento.index');
                break;
            default:
                return abort('403');
                break;
        }

    }

    /**
     * devolver datatables mantenimientos de equipos por nodo.
     *
     * @param  int nodo
     * @return \Illuminate\Http\Response
     * @author devjul
     */
    public function getMantenimientosEquiposPorNodo($nodo)
    {
        $mantenimientos = $this->getMantenimientoRepository()->findInfoMantenimiento()
                    ->where('lineastecnologicas_nodos.nodo_id', $nodo)
                    ->dd();
                // $mantenimientos = Nodo::with(['lineas','lineas.equipos.equiposmantenimientos'])
                // ->where('id', $nodo)
                // ->get();
        // ->sortByDesc('lineas.equipos.equiposmantenimientos.created_at');
        // 4
            return $mantenimientos;
         // return $mantenimientos->each(function ($item, $key) {
         //         $item->each(function ($item2, $key2) {
         //                echo $item2;
         //            });
         //    });
        
        if (request()->ajax()) {
            

            if (session()->has('login_role') && session()->get('login_role') == User::IsAdministrador()) {

                // $mantenimientos = $this->getMantenimientoRepository()->findInfoMantenimiento()
                //     ->where('lineastecnologicas_nodos.nodo_id', $nodo)
                //     ->get();
                // $mantenimientos = Nodo::with(['lineas','lineas.equipos.equiposmantenimientos'])
                // ->where('id', $nodo)
                // ->get();

                return datatables()->of($mantenimientos)
                    ->addColumn('edit', function ($data) {
                        $button = '<a href="' . route("mantenimiento.edit", $data->id) . '" class=" btn tooltipped m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Editar"><i class="material-icons">edit</i></a>';

                        return $button;
                    })
                    ->addColumn('detail', function ($data) {
                        $button = '<a href="' . route("mantenimiento.show", $data->id) . '" class="btn tooltipped blue-grey m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Ver Detalle"><i class="material-icons">info_outline</i></a>';

                        return $button;
                    })

                    ->addColumn('valor_mantenimiento', function ($data) {
                        return '$ ' . number_format(round($data->valor_mantenimiento, 2));
                    })
                    ->editColumn('costo_adquisicion', function ($data) {
                        return '$ ' . number_format($data->costo_adquisicion);
                    })
                    ->editColumn('nombrelinea', function ($data) {
                        return $data->lineatecnologica_abreviatura . ' - ' . $data->lineatecnologica_nombre;
                    })

                    ->rawColumns(['edit', 'detail', 'nombrelinea', 'costo_adquisicion', 'valor_mantenimiento'])
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
        $this->authorize('create', EquipoMantenimiento::class);
        if (session()->has('login_role') && session()->get('login_role') == User::IsDinamizador()) {
            $nodoDinamizador = auth()->user()->dinamizador->nodo->id;

            $lineastecnologicas = $this->getLineaTecnologicaRepository()->findLineasByIdNameForNodo($nodoDinamizador);
            return view('mantenimiento.create', [
                'lineastecnologicas' => $lineastecnologicas,
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
    public function store(MantenimientoFormRequest $request)
    {
        $this->authorize('store', EquipoMantenimiento::class);
        $mantenimientoCreate = $this->getMantenimientoRepository()->storeMantenimiento($request);
        if ($mantenimientoCreate === true) {

            alert()->success('Registro Exitoso.', 'El mantenimiento ha sido creado satisfactoriamente');
        } else {
            alert()->error('Registro Erróneo.', 'El mantenimiento no se ha creado.');
        }
        return redirect()->route('mantenimiento.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mantenimiento = $this->getMantenimientoRepository()->findInfoMantenimiento()->findOrFail($id);
        $this->authorize('show', $mantenimiento);
        // return $mantenimiento;
        return view('mantenimiento.show', [
            'mantenimiento' => $mantenimiento,
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
        $mantenimiento = $this->getMantenimientoRepository()->findInfoMantenimiento()->findOrFail($id);
        $this->authorize('edit', $mantenimiento);
        if (session()->has('login_role') && session()->get('login_role') == User::IsDinamizador()) {
            $nodoDinamizador    = auth()->user()->dinamizador->nodo->id;
            $lineastecnologicas = $this->getLineaTecnologicaRepository()->findLineasByIdNameForNodo($nodoDinamizador);
            // return $mantenimiento ;
            return view('mantenimiento.edit', [
                'lineastecnologicas' => $lineastecnologicas,
                'mantenimiento'      => $mantenimiento,
            ]);
        } else {
            abort('403');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MantenimientoFormRequest $request, $id)
    {
        $mantenimiento = $this->getMantenimientoRepository()->findInfoMantenimiento()->findOrFail($id);
        $this->authorize('update', $mantenimiento);
        $mantenimientoUpdate = $this->getMantenimientoRepository()->updateMantenimiento($request, $mantenimiento);
        if ($mantenimientoUpdate == true) {

            alert()->success("El mantenimiento ha sido  modificado.", 'Modificación Exitosa', "success");
        } else {
            alert()->error("El mantenimiento no ha sido  modificado.", 'Modificación Errónea', "error");
        }

        return redirect()->route('mantenimiento.index');

    }

    /**
     * Asigna un valor a $mantenimientoRepository
     * @param object $mantenimientoRepository
     * @return void
     * @author devjul
     */
    private function setMantenimientoRepository($mantenimientoRepository)
    {
        $this->mantenimientoRepository = $mantenimientoRepository;
    }

    /**
     * Retorna el valor de $mantenimientoRepository
     * @return object
     * @author devjul
     */
    private function getMantenimientoRepository()
    {
        return $this->mantenimientoRepository;
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
