<?php

namespace App\Http\Controllers;

use App\Http\Requests\MaterialesFormRequest;
use App\Models\CategoriaMaterial;
use App\Models\Material;
use App\Models\Medida;
use App\Models\Nodo;
use App\Models\Presentacion;
use App\Models\TipoMaterial;
use App\Repositories\Repository\LineaRepository;
use App\Repositories\Repository\MaterialRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Repositories\Repository\NodoRepository;

class MaterialController extends Controller
{

    private $materialRepository;
    private $lineaRepository;
    private $nodoRepository;

    public function __construct(MaterialRepository $materialRepository, LineaRepository $lineaRepository, NodoRepository $nodoRepository)
    {
        $this->materialRepository = $materialRepository;
        $this->lineaRepository    = $lineaRepository;
        $this->nodoRepository     = $nodoRepository;
        $this->middleware(['auth', 'role_session:Administrador|Dinamizador|Gestor|Talento']);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('index', Material::class);
        if (request()->ajax()) {

            if (session()->has('login_role') && session()->get('login_role') == User::IsDinamizador()) {
                $nodo       = auth()->user()->dinamizador->nodo->id;
                $materiales = $this->getMaterialRepository()->getInfoDataMateriales()
                    ->whereHas('nodo', function ($query) use ($nodo) {
                        $query->where('id', $nodo);
                    })->get();

            } elseif (session()->has('login_role') && session()->get('login_role') == User::IsGestor()) {

                $linea      = auth()->user()->gestor->lineatecnologica->id;
                $nodo       = auth()->user()->gestor->nodo->id;
                $materiales = $this->getMaterialRepository()->getInfoDataMateriales()
                    ->whereHas('nodo', function ($query) use ($nodo) {
                        $query->where('id', $nodo);
                    })
                    ->whereHas('lineatecnologica', function ($query) use ($linea) {
                        $query->where('id', $linea);
                    })->orderBy('nombre')->get();

                

            }
            return datatables()->of($materiales)
                    ->addColumn('edit', function ($data) {
                        $button = '<a href="' . route("material.edit", $data->id) . '" class=" btn tooltipped m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Editar"><i class="material-icons">edit</i></a>';

                        return $button;
                    })
                    ->addColumn('detail', function ($data) {
                        $button = '<a href="' . route("material.show", $data->id) . '" class="btn tooltipped blue-grey m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Ver Detalle"><i class="material-icons">info_outline</i></a>';

                        return $button;
                    })
                    ->addColumn('valor_unitario', function ($data) {
                        return '$ ' . number_format(round($data->valor_compra / $data->cantidad, 2));
                    })
                    ->editColumn('fecha', function ($data) {
                        return $data->fecha->isoFormat('LL');
                    })
                    ->editColumn('valor_compra', function ($data) {
                        return '$ ' . number_format($data->valor_compra);
                    })
                    ->editColumn('nombrelinea', function ($data) {
                        return $data->lineatecnologica->abreviatura . ' - ' . $data->lineatecnologica->nombre;
                    })
                    ->editColumn('presentacion', function ($data) {
                        return $data->presentacion->nombre;
                    })
                    ->editColumn('medida', function ($data) {
                        return $data->medida->nombre;
                    })

                    ->rawColumns(['edit','detail', 'nombrelinea', 'valor_unitario', 'valor_compra', 'presentacion','medida'])
                    ->make(true);

        }

        switch (Session::get('login_role')) {
            case User::IsAdministrador():
                return view('materiales.index', [
                    'nodos' => $this->getNodoRepository()->getSelectNodo(),
                ]);
                break;
            case User::IsDinamizador():
                return view('materiales.index');
                break;
            case User::IsGestor():
                return view('materiales.index');
                break;
            default:
                return abort('403');
                break;
        }
    }

    /**
     * devolver datatables equipos por nodo.
     *
     * @param  int nodo
     * @return \Illuminate\Http\Response
     */
    public function getMaterialesPorNodo($nodo)
    {
        $this->authorize('getMaterialesPorNodo', Material::class);

        if (request()->ajax()) {

            if (session()->has('login_role') && session()->get('login_role') == User::IsAdministrador()) {

                $materiales = $this->getMaterialRepository()->getInfoDataMateriales()
                                ->whereHas('nodo', function ($query) use ($nodo) {
                                    $query->where('id', $nodo);
                                })->orderBy('nombre')->get();

                return datatables()->of($materiales)
                    ->addColumn('edit', function ($data) {
                        $button = '<a href="' . route("material.edit", $data->id) . '" class=" btn tooltipped m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Editar"><i class="material-icons">edit</i></a>';

                        return $button;
                    })
                    ->addColumn('detail', function ($data) {
                        $button = '<a href="' . route("material.show", $data->id) . '" class="btn tooltipped blue-grey m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Ver Detalle"><i class="material-icons">info_outline</i></a>';

                        return $button;
                    })
                    ->addColumn('valor_unitario', function ($data) {
                        return '$ ' . number_format(round($data->valor_compra / $data->cantidad, 2));
                    })
                    ->editColumn('fecha', function ($data) {
                        return $data->fecha->isoFormat('LL');
                    })
                    ->editColumn('valor_compra', function ($data) {
                        return '$ ' . number_format($data->valor_compra);
                    })
                    ->editColumn('nombrelinea', function ($data) {
                        return $data->lineatecnologica->abreviatura . ' - ' . $data->lineatecnologica->nombre;
                    })
                    ->editColumn('presentacion', function ($data) {
                        return $data->presentacion->nombre;
                    })
                    ->editColumn('medida', function ($data) {
                        return $data->medida->nombre;
                    })


                    ->rawColumns(['edit','detail', 'nombrelinea', 'valor_unitario', 'valor_compra', 'presentacion','medida'])
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
        $this->authorize('create', Material::class);

        if (session()->has('login_role') && session()->get('login_role') == User::IsDinamizador() || session()->has('login_role') && session()->get('login_role') == User::IsGestor()) {

            if (session()->has('login_role') && session()->get('login_role') == User::IsDinamizador()) {
                $nodo = auth()->user()->dinamizador->nodo->id;
            } elseif (session()->has('login_role') && session()->get('login_role') == User::IsGestor()) {
                $nodo = auth()->user()->gestor->nodo->id;
            }

            $lineastecnologicas = $this->getLineaTecnologicaRepository()->findLineasByIdNameForNodo($nodo);

            return view('materiales.create', [
                'lineastecnologicas'   => $lineastecnologicas,
                'categoriasMateriales' => CategoriaMaterial::selectAllCategoriasMateriales($orderBy = 'nombre')->get()->pluck('nombre', 'id'),
                'tiposmateriales'      => TipoMaterial::selectAllTiposMateriales($orderBy = 'nombre')->get()->pluck('nombre', 'id'),
                'medidas'              => Medida::selectAllMedidas($orderBy = 'nombre')->get()->pluck('nombre', 'id'),
                'presentaciones'       => Presentacion::selectAllPresentaciones($orderBy = 'nombre')->get()->pluck('nombre', 'id'),
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
    public function store(MaterialesFormRequest $request)
    {
        $this->authorize('store', Material::class);

        $materialStore = $this->getMaterialRepository()->store($request);
        if ($materialStore === true) {

            alert()->success('Registro Exitoso.', 'El Material de Formación ha sido creado satisfactoriamente');
        } else {
            alert()->error('Registro Erróneo.', 'El Material de Formación no se ha creado.');
        }
        return redirect()->route('material.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $material= $this->getMaterialRepository()->getInfoDataMateriales()->findOrFail($id);
        $this->authorize('show', $material);

        return view('materiales.show', [
            'material' => $material,
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
        $materiales = $this->getMaterialRepository()->getInfoDataMateriales()->findOrFail($id);
        $this->authorize('edit', $materiales);
        if (session()->has('login_role') && session()->get('login_role') == User::IsDinamizador() || session()->has('login_role') && session()->get('login_role') == User::IsGestor()) {

            if (session()->has('login_role') && session()->get('login_role') == User::IsDinamizador()) {
                $nodo = auth()->user()->dinamizador->nodo->id;
            } elseif (session()->has('login_role') && session()->get('login_role') == User::IsGestor()) {
                $nodo = auth()->user()->gestor->nodo->id;
            }

            $lineastecnologicas = $this->getLineaTecnologicaRepository()->findLineasByIdNameForNodo($nodo);

            return view('materiales.edit', [
                'material' => $materiales,
                'lineastecnologicas'   => $lineastecnologicas,
                'categoriasMateriales' => CategoriaMaterial::selectAllCategoriasMateriales($orderBy = 'nombre')->get()->pluck('nombre', 'id'),
                'tiposmateriales'      => TipoMaterial::selectAllTiposMateriales($orderBy = 'nombre')->get()->pluck('nombre', 'id'),
                'medidas'              => Medida::selectAllMedidas($orderBy = 'nombre')->get()->pluck('nombre', 'id'),
                'presentaciones'       => Presentacion::selectAllPresentaciones($orderBy = 'nombre')->get()->pluck('nombre', 'id'),
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
    public function update(MaterialesFormRequest $request, $id)
    {
        $material = $this->getMaterialRepository()->getInfoDataMateriales()->findOrFail($id);
        $this->authorize('edit', $material);
        $materialUpdate = $this->getMaterialRepository()->updateMaterial($request, $material);
        if ($materialUpdate == true) {

            alert()->success("El equipo ha sido  modificado.", 'Modificación Exitosa', "success");
        } else {
            alert()->error("El equipo no ha sido  modificado.", 'Modificación Errónea', "error");
        }

        return redirect()->route('material.index');
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
     * Asigna un valor a $materialRepository
     * @param object $materialRepository
     * @return void
     * @author devjul
     */
    private function setMaterialRepository($materialRepository)
    {
        $this->materialRepository = $materialRepository;
    }

    /**
     * Retorna el valor de $materialRepostory
     * @return object
     * @author devjul
     */
    private function getMaterialRepository()
    {
        return $this->materialRepository;
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
