<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use App\Repositories\Repository\MaterialRepository;
use App\Repositories\Repository\LineaRepository;
use Repositories\Repository\NodoRepository;
use Illuminate\Support\Facades\Session;
use App\User;
use App\Models\Medida;
use App\Models\TipoMaterial;
use App\Models\CategoriaMaterial;
use App\Models\Presentacion;
use App\Models\Nodo;
use App\Http\Requests\MaterialesFormRequest;

class MaterialController extends Controller
{

    private $materialRepository;
    private $lineaRepository;
    private $nodoRepository;

    public function __construct(MaterialRepository $materialRepository, LineaRepository $lineaRepository, NodoRepository $nodoRepository)
    {
        $this->materialRepository = $materialRepository;
        $this->lineaRepository  = $lineaRepository;
        $this->nodoRepository   = $nodoRepository;
        $this->middleware(['auth','role_session:Administrador|Dinamizador|Gestor|Talento']);
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('index', Material::class);

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
            }elseif(session()->has('login_role') && session()->get('login_role') == User::IsGestor()){
                $nodo = auth()->user()->gestor->nodo->id;
            }

            $lineastecnologicas = $this->getLineaTecnologicaRepository()->findLineasByIdNameForNodo($nodo);


            return view('materiales.create', [
                'lineastecnologicas' => $lineastecnologicas,
                'categoriasMateriales' =>  CategoriaMaterial::selectAllCategoriasMateriales($orderBy = 'nombre')->get()->pluck('nombre','id'),
                'tiposmateriales' => TipoMaterial::selectAllTiposMateriales($orderBy = 'nombre')->get()->pluck('nombre','id'),
                'medidas' => Medida::selectAllMedidas($orderBy = 'nombre')->get()->pluck('nombre','id'),
                'presentaciones' =>  Presentacion::selectAllPresentaciones($orderBy = 'nombre')->get()->pluck('nombre','id'),
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
