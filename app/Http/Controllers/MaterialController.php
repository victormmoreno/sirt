<?php

namespace App\Http\Controllers;

use App\Http\Requests\MaterialesFormRequest;
use App\Models\{CategoriaMaterial, Medida, Material, Presentacion, TipoMaterial};
use App\Repositories\Datatables\MaterialDatatables;
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
        $this->middleware(['auth', 'role_session:Administrador|Dinamizador|Gestor|Talento']);
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
    public function index(MaterialDatatables $materialDatatables)
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

            return $materialDatatables->indexDatatable($materiales);
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
                return abort(Response::HTTP_FORBIDDEN);
                break;
        }
    }

    /**
     * devolver datatables equipos por nodo.
     *
     * @param  int nodo
     * @return \Illuminate\Http\Response
     */
    public function getMaterialesPorNodo(MaterialDatatables $materialDatatables, $nodo)
    {
        $this->authorize('getMaterialesPorNodo', Material::class);

        if (request()->ajax()) {

            if (session()->has('login_role') && session()->get('login_role') == User::IsAdministrador()) {

                $materiales = $this->getMaterialRepository()->getInfoDataMateriales()
                    ->whereHas('nodo', function ($query) use ($nodo) {
                        $query->where('id', $nodo);
                    })->orderBy('nombre')->get();

                return $materialDatatables->getMaterialesPorNodoDatatable($materiales);
            } else {
                return response()->json(['data' => 'no response']);
            }
        }
        abort(Response::HTTP_FORBIDDEN);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Material::class);

        if (session()->has('login_role') && session()->get('login_role') == User::IsDinamizador()) {
            $nodo = auth()->user()->dinamizador->nodo->id;
        } elseif (session()->has('login_role') && session()->get('login_role') == User::IsGestor()) {
            $nodo = auth()->user()->gestor->nodo->id;
        }

        $lineastecnologicas = $this->getLineaTecnologicaRepository()->findLineasByIdNameForNodo($nodo);

        return view('materiales.create', [
            'lineastecnologicas'   => $lineastecnologicas,
            'categoriasMateriales' => CategoriaMaterial::selectAllCategoriasMateriales($orderBy = 'nombre')->get()->pluck('nombre', 'id'),
            'medidas'              => Medida::selectAllMedidas($orderBy = 'nombre')->get()->pluck('nombre', 'id'),
            'presentaciones'       => Presentacion::selectAllPresentaciones($orderBy = 'nombre')->get()->pluck('nombre', 'id'),
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
        $material = $this->getMaterialRepository()->getInfoDataMateriales()->findOrFail($id);
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

        if (session()->has('login_role') && session()->get('login_role') == User::IsDinamizador()) {
            $nodo = auth()->user()->dinamizador->nodo->id;
        } elseif (session()->has('login_role') && session()->get('login_role') == User::IsGestor()) {
            $nodo = auth()->user()->gestor->nodo->id;
        }

        $lineastecnologicas = $this->getLineaTecnologicaRepository()->findLineasByIdNameForNodo($nodo);

        return view('materiales.edit', [
            'material'             => $materiales,
            'lineastecnologicas'   => $lineastecnologicas,
            'categoriasMateriales' => CategoriaMaterial::selectAllCategoriasMateriales($orderBy = 'nombre')->get()->pluck('nombre', 'id'),
            'tiposmateriales'      => TipoMaterial::selectAllTiposMateriales($orderBy = 'nombre')->get()->pluck('nombre', 'id'),
            'medidas'              => Medida::selectAllMedidas($orderBy = 'nombre')->get()->pluck('nombre', 'id'),
            'presentaciones'       => Presentacion::selectAllPresentaciones($orderBy = 'nombre')->get()->pluck('nombre', 'id'),
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
                    'message' => 'no puedes elminiar el material de formación, está en en siendo utilizado en usos de infraestructura',
                ], Response::HTTP_IM_USED);
            }
            $material->delete();
            return response()->json([
                'status' => Response::HTTP_OK,
                'message' => 'el material fue eliminado',
                'route' => route('material.index')
            ], Response::HTTP_OK);
        }
        abort(Response::HTTP_FORBIDDEN);
    }
}
