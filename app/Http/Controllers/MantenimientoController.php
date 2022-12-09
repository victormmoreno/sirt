<?php

namespace App\Http\Controllers;

use App\Http\Requests\MantenimientoFormRequest;
use App\Models\EquipoMantenimiento;
use App\Models\Nodo;
use App\Repositories\Repository\LineaRepository;
use App\Repositories\Repository\MantenimientoRepository;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Repositories\Repository\NodoRepository;

class MantenimientoController extends Controller
{

    public function __construct(MantenimientoRepository $mantenimientoRepository, LineaRepository $lineaRepository, NodoRepository $nodoRepository)
    {
        $this->mantenimientoRepository = $mantenimientoRepository;
        $this->lineaRepository = $lineaRepository;
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
        
        if(!request()->user()->can('index', EquipoMantenimiento::class)) {
            alert('No autorizado', 'No puedes ver la información de los equipos', 'error')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        if (request()->ajax()) {
            if (session()->has('login_role') && session()->get('login_role') == User::IsDinamizador() || session()->get('login_role') == User::IsExperto()) {
                if (session()->has('login_role') && session()->get('login_role') == User::IsDinamizador()) {
                    $nodo           = auth()->user()->dinamizador->nodo->id;
                    $mantenimientos = $this->getMantenimientoRepository()->findInfoMantenimiento()
                        ->whereHas('equipo.nodo', function($query) use($nodo){
                            $query->where('id',$nodo);
                        })
                        ->get();
                } elseif (session()->has('login_role') && session()->get('login_role') == User::IsExperto()) {
                    $linea          = auth()->user()->gestor->lineatecnologica->id;
                    $nodo           = auth()->user()->gestor->nodo->id;
                    $mantenimientos = $this->getMantenimientoRepository()->findInfoMantenimiento()
                        ->whereHas('equipo.nodo', function($query) use($nodo){
                            $query->where('id',$nodo);
                        })
                        ->whereHas('equipo.lineatecnologica', function($query) use($linea){
                            $query->where('id',$linea);
                        })
                        ->get();
                }
                // dd($mantenimientos);
                return datatables()->of($mantenimientos)
                    ->addColumn('edit', function ($data) {
                        $button = '<a href="' . route("mantenimiento.edit", $data->id) . '" class="btn bg-warning tooltipped m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Editar"><i class="material-icons">edit</i></a>';

                        return $button;
                    })
                    ->addColumn('detail', function ($data) {
                        $button = '<a href="' . route("mantenimiento.show", $data->id) . '" class="btn bg-info tooltipped blue-grey m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Ver Detalle"><i class="material-icons">info_outline</i></a>';

                        return $button;
                    })

                    ->addColumn('valor_mantenimiento', function ($data) {
                        return '$ ' . number_format(round($data->valor_mantenimiento, 2));
                    })
                    ->editColumn('costo_adquisicion', function ($data) {
                        return '$ ' . number_format($data->equipo->each(function ($item) {
                                        $item->costo_adquisicion;
                                }));
                    })
                    ->editColumn('lineatecnologica', function ($data) {
                        return $data->equipo->lineatecnologica->abreviatura.' - '.$data->equipo->lineatecnologica->nombre;
                    })
                    ->editColumn('equipo', function ($data) {
                        return $data->equipo->nombre;
                    })

                    ->rawColumns(['edit', 'detail', 'nombrelinea', 'costo_adquisicion', 'valor_mantenimiento', 'equipo_nombre'])
                    ->make(true);
            } else {
                abort('403');
            }

        }
        return view('mantenimiento.index', [
            'nodos' => $this->getNodoRepository()->getSelectNodo(),
        ]);

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
        if (request()->ajax()) {
            $nodo_id = null;
            if (session()->get('login_role') == User::IsActivador() || session()->get('login_role') == User::IsAdministrador()) {
                $nodo_id = $nodo;
            }
            if (session()->get('login_role') == User::IsDinamizador()) {
                $nodo_id = auth()->user()->dinamizador->nodo_id;
            }
            if (session()->get('login_role') == User::IsExperto()) {
                $nodo_id = auth()->user()->gestor->nodo_id;
            }
            
            $mantenimientos = $this->getMantenimientoRepository()->findInfoMantenimiento()
            ->whereHas('equipo.nodo', function($query) use ($nodo_id) {
                $query->where('id',$nodo_id);
            })->get();
            return datatables()->of($mantenimientos)
            ->addColumn('edit', function ($data) {
                if (auth()->user()->can('edit', $data)) {
                    $button = '<a href="' . route("mantenimiento.edit", $data->id) . '" class="btn bg-warning tooltipped m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Editar">
                    <i class="material-icons">edit</i>
                    </a>';
                } else {
                    $button = '<a disabled class=" btn tooltipped m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Editar">
                    <i class="material-icons">edit</i>
                    </a>';
                }
                return $button;
            })
            ->addColumn('detail', function ($data) {
                $button = '<a href="' . route("mantenimiento.show", $data->id) . '" class="btn bg-info tooltipped m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Ver Detalle"><i class="material-icons">info_outline</i></a>';

                return $button;
            })
            ->addColumn('valor_mantenimiento', function ($data) {
                return '$ ' . number_format(round($data->valor_mantenimiento, 2));
            })
            ->editColumn('costo_adquisicion', function ($data) {
                return '$ ' . number_format($data->equipo->each(function ($item) {
                    $item->costo_adquisicion;
                }));
            })
            ->editColumn('lineatecnologica', function ($data) {
                return $data->equipo->lineatecnologica->abreviatura.' - '.$data->equipo->lineatecnologica->nombre;

            })->editColumn('equipo', function ($data) {
                return $data->equipo->nombre;
            })->editColumn('nodo', function ($data) {
                return $data->equipo->nodo->entidad->nombre;
            })
            ->rawColumns(['edit', 'detail', 'nombrelinea', 'costo_adquisicion', 'valor_mantenimiento', 'equipo_nombre'])
            ->make(true);
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
        $nodos = $this->getNodoRepository()->getSelectNodo();
        $nodo = session()->get('login_role') == User::IsAdministrador() ? $nodos->first()->id : auth()->user()->dinamizador->nodo->id;
        $lineastecnologicas = $this->getLineaTecnologicaRepository()->getAllLineaNodo($nodo);
        
        return view('mantenimiento.create', [
            'lineastecnologicas' => $lineastecnologicas->lineas,
            'year' =>  Carbon::now()->isoFormat('YYYY'),
            'nodos' => $nodos,
            'nodo' => $nodo
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

        // $this->authorize('store', EquipoMantenimiento::class);
        $req = new MantenimientoFormRequest;
        $validator = Validator::make($request->all(), $req->rules(), $req->messages());
        if ($validator->fails()) {
            return response()->json([
                'state'   => 'error_form',
                'errors' => $validator->errors(),
            ]);
        } else {
            $result = $this->getMantenimientoRepository()->storeMantenimiento($request);
            if ($result['state']) {
                return response()->json(['state' => true, 'url' => route('mantenimiento.index'), 'msj' => $result['msj'], 'title' => $result['title']]);
            } else {
                return response()->json(['state' => false, 'msj' => $result['msj'], 'title' => $result['title']]);
            }
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
        $mantenimiento = $this->getMantenimientoRepository()->findInfoMantenimiento()->findOrFail($id);

        $this->authorize('show', $mantenimiento);
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
        $nodos = $this->getNodoRepository()->getSelectNodo();
        $nodo = session()->get('login_role') == User::IsAdministrador() ? $nodos->first()->id : auth()->user()->dinamizador->nodo->id;
        $lineastecnologicas = $this->getLineaTecnologicaRepository()->getAllLineaNodo($nodo);
        return view('mantenimiento.edit', [
            'year' =>  Carbon::now()->isoFormat('YYYY'),
            'lineastecnologicas' => $lineastecnologicas->lineas,
            'mantenimiento' => $mantenimiento,
            'nodos' => $nodos,
        ]);
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
        $mantenimiento = $this->getMantenimientoRepository()->findInfoMantenimiento()->findOrFail($id);
        $this->authorize('edit', $mantenimiento);
        
        $req = new MantenimientoFormRequest;
        $validator = Validator::make($request->all(), $req->rules(), $req->messages());
        if ($validator->fails()) {
            return response()->json([
                'state'   => 'error_form',
                'errors' => $validator->errors(),
            ]);
        } else {
            $result = $this->getMantenimientoRepository()->updateMantenimiento($request, $mantenimiento);
            if ($result['state']) {
                return response()->json(['state' => true, 'url' => route('mantenimiento.index'), 'msj' => $result['msj'], 'title' => $result['title']]);
            } else {
                return response()->json(['state' => false, 'msj' => $result['msj'], 'title' => $result['title']]);
            }
        }

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
