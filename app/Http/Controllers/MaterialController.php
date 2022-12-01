<?php

namespace App\Http\Controllers;

use App\Http\Requests\MaterialesFormRequest;
use App\Models\{CategoriaMaterial, Medida, Material, Presentacion, TipoMaterial};
use App\Datatables\MaterialDatatable;
use App\Repositories\Repository\{LineaRepository, MaterialRepository};
use App\User;
use Illuminate\Support\Facades\Session;
use Repositories\Repository\NodoRepository;
use Illuminate\Http\Response;

class MaterialController extends Controller
{

    private $materialRepository;
    private $lineaRepository;
    private $nodoRepository;

    public function __construct(MaterialRepository $materialRepository, LineaRepository $lineaRepository, NodoRepository $nodoRepository)
    {
        $this->middleware(['auth', 'role_session:Activador|Dinamizador|Articulador|Experto|Talento|'.User::IsApoyoTecnico()]);
        $this->setMaterialRepository($materialRepository);
        $this->setLineaTecnologicaRepository($lineaRepository);
        $this->setNodoRepository($nodoRepository);
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(MaterialDatatable $materialDatatable)
    {
        $this->authorize('index', Material::class);
        if (request()->ajax()) {
            if (session()->has('login_role') && session()->get('login_role') == User::IsDinamizador()) {
                $nodo       = auth()->user()->dinamizador->nodo->id;
                $materiales = $this->getMaterialRepository()->getInfoDataMateriales()
                    ->whereHas('nodo', function ($query) use ($nodo) {
                        $query->where('id', $nodo);
                    })->get();
            } elseif (session()->has('login_role') && session()->get('login_role') == User::IsExperto()) {

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
            return $materialDatatable->indexDatatable($materiales);
        }
        return view('materiales.index', [
            'nodos' => $this->getNodoRepository()->getSelectNodo(),
        ]);

    }

    /**
     * devolver datatables equipos por nodo.
     *
     * @param  int nodo
     * @return \Illuminate\Http\Response
     */
    public function getMaterialesPorNodo(MaterialDatatable $materialDatatable, $nodo)
    {
        $this->authorize('getMaterialesPorNodo', Material::class);
        if (session()->get('login_role') == User::IsDinamizador()) {
            $nodo = auth()->user()->dinamizador->nodo->id;
        } elseif (session()->get('login_role') == User::IsExperto()) {
            $nodo = auth()->user()->gestor->nodo->id;
        } else {
            $nodo = $nodo;
        }
        $materiales = $this->getMaterialRepository()->getInfoDataMateriales()
            ->whereHas('nodo', function ($query) use ($nodo) {
                $query->where('id', $nodo);
            })->orderBy('nombre')->get();

        return $materialDatatable->getMaterialesPorNodoDatatable($materiales);

    }

    /**
     * Muestra el formulario para importar materiales de formación
     * 
     * @return Response
     * @author dum
     */
    public function importar()
    {
        if(!request()->user()->can('import', Material::class)) {
            alert('No autorizado', 'No puedes importar materiales de este nodo', 'error')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        return view('materiales.import');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $this->authorize('create', Material::class);
        $nodos = $this->getNodoRepository()->getSelectNodo();
        if (session()->get('login_role') == User::IsDinamizador()) {
            $nodo = auth()->user()->dinamizador->nodo->id;
        } elseif (session()->get('login_role') == User::IsExperto()) {
            $nodo = auth()->user()->gestor->nodo->id;
        } else {
            $nodo = $nodos->first()->id;
        }

        $lineastecnologicas = $this->getLineaTecnologicaRepository()->getAllLineaNodo($nodo);
        return view('materiales.create', [
            'lineastecnologicas'   => $lineastecnologicas,
            'categoriasMateriales' => CategoriaMaterial::selectAllCategoriasMateriales($orderBy = 'nombre')->get()->pluck('nombre', 'id'),
            'medidas'              => Medida::selectAllMedidas($orderBy = 'nombre')->get()->pluck('nombre', 'id'),
            'presentaciones'       => Presentacion::selectAllPresentaciones($orderBy = 'nombre')->get()->pluck('nombre', 'id'),
            'nodos'                => $nodos
        ]);
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
        if ($materialStore) {

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
        $material = $this->getMaterialRepository()->getInfoDataMateriales()->findOrFail($id);

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
        $nodos = $this->getNodoRepository()->getSelectNodo();

        $lineastecnologicas = $this->getLineaTecnologicaRepository()->getAllLineaNodo($materiales->lineatecnologica_id);
        return view('materiales.edit', [
            'material'             => $materiales,
            'lineastecnologicas'   => $lineastecnologicas->lineas,
            'categoriasMateriales' => CategoriaMaterial::selectAllCategoriasMateriales($orderBy = 'nombre')->get()->pluck('nombre', 'id'),
            'tiposmateriales'      => TipoMaterial::selectAllTiposMateriales($orderBy = 'nombre')->get()->pluck('nombre', 'id'),
            'medidas'              => Medida::selectAllMedidas($orderBy = 'nombre')->get()->pluck('nombre', 'id'),
            'presentaciones'       => Presentacion::selectAllPresentaciones($orderBy = 'nombre')->get()->pluck('nombre', 'id'),
            'nodos'                => $nodos
        ]);
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

    public function getMaterial($id)
    {
        if (request()->ajax()) {
            $material = $this->getMaterialRepository()->getInfoDataMateriales()->find($id);
            if ($material != null) {
                return response()->json([
                    'material' => $material,
                    'message' => 'success'
                ]);
            } else {
                return response()->json([
                    'material' => null,
                    'message' => 'error'
                ]);
            }
        }
        abort(Response::HTTP_FORBIDDEN);
    }

    public function destroy(int $id)
    {
        if (request()->ajax()) {
            $material = Material::findOrFail($id);

            $cantidadUso = $material->usoinfraestructuramaterial->count();

            $this->authorize('destroy', $material);

            if ($cantidadUso > 0) {
                return response()->json([
                    'material' => $material,
                    'status' => Response::HTTP_IM_USED,
                    'message' => 'No puedes eliminar el material de formación, está en en siendo utilizado en usos de infraestructura',
                ], Response::HTTP_IM_USED);
            }
            $material->delete();
            return response()->json([
                'status' => Response::HTTP_OK,
                'message' => 'El material fue eliminado',
                'route' => route('material.index')
            ], Response::HTTP_OK);
        }
        abort(Response::HTTP_FORBIDDEN);
    }
}
