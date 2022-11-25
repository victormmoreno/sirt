<?php

namespace App\Http\Controllers\Nodo;

use App\Http\Controllers\Controller;
use App\Http\Requests\NodoFormRequest;
use App\Models\Nodo;
use App\Datatables\NodoDatatable;
use App\Repositories\Repository\DepartamentoRepository;
use App\User;
use Illuminate\Http\Request;
use Repositories\Repository\NodoRepository;

class NodoController extends Controller
{
    private $nodoRepository;
    private $departamentoRepository;

    public function __construct(NodoRepository $nodoRepository, DepartamentoRepository $departamentoRepository)
    {
        $this->middleware('auth');
        $this->middleware([
            'auth',
        ]);
        $this->setNodoRepository($nodoRepository);
        $this->setDepartamentoRepository($departamentoRepository);
    }

    public function nodo_pagination(Request $request)
    {
        $nodos_g = Nodo::SelectNodo()->paginate(6);
        return view('indicadores.componentes.nodo_pagination', compact('nodos_g'))->render();
    }

    /**
     * setter: Asigna un valor a $nodoRepository
     * @param object $nodoRepository
     * @return void
     * @author devjul
     */
    private function setNodoRepository($nodoRepository)
    {
        $this->nodoRepository = $nodoRepository;
    }

    /**
     * getter: Retorna el valor de $nodoRepository
     * @return object
     * @author devjul
     */
    private function getNodoRepository()
    {
        return $this->nodoRepository;
    }

    /**
     * setter: Asigna un valor a $departamentoRepository
     * @param object $departamentoRepository
     * @return void
     * @author devjul
     */
    private function setDepartamentoRepository($departamentoRepository)
    {
        $this->departamentoRepository = $departamentoRepository;
    }

    /**
     * getter: Retorna el valor de $departamentoRepository
     * @return object
     * @author devjul
     */
    private function getDepartamentoRepository()
    {
        return $this->departamentoRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(NodoDatatable $nodoDatatable)
    {
        if(request()->user()->cannot('index', Nodo::class))
        {
            alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
            return redirect()->back();
        }
        if (session()->get('login_role') == User::IsActivador() || session()->get('login_role') == User::IsAdministrador()) {
            if (request()->ajax()) {
                return $nodoDatatable->indexDatatable($this->getNodoRepository()->getAlltNodo());
            }
            return view('nodos.index');
        } else {
            $nodoAuth = request()->user()->getNodoUser();
            $nodo     = $this->getNodoRepository()->getTeamTecnoparque()
                ->where('nodos.id', $nodoAuth)
                ->first();
            return view('nodos.show', [
                'nodo'              => $nodo,
                'equipos'           => $nodo->equipos()->with(['lineatecnologica'])->paginate(5),
                'lineatecnologicas' => $nodo->lineas()->paginate(4),
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(request()->user()->cannot('create', Nodo::class))
        {
            alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
            return redirect()->back();
        }
        return view('nodos.create', [
            'lineas'        => $this->getNodoRepository()->getAllLineas(),
            'regionales'    => $this->getNodoRepository()->getAllRegionales(),
            'departamentos' => $this->getDepartamentoRepository()->getAllDepartamentos(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NodoFormRequest $request)
    {
        if(request()->user()->cannot('create', Nodo::class))
        {
            alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
            return redirect()->back();
        }
        $nodoCreate = $this->getNodoRepository()->storeNodo($request);

        if ($nodoCreate === true) {
            alert()->success('Registro Exitoso.', 'El nodo ha sido creado satisfactoriamente');
        } else {
            alert()->error('Registro Erróneo.', 'El nodo no se ha creado.');
        }
        return redirect()->route('nodo.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $nodo
     * @return \Illuminate\Http\Response
     */
    public function show($nodo)
    {
        $nodo = $this->getNodoRepository()->findNodoForShow($nodo);
        if(request()->user()->can('create', $nodo))
        {
            return view('nodos.show', [
                'nodo'              => $nodo,
                'equipos'           => $nodo->equipos()->with(['lineatecnologica'])->paginate(5),
                'lineatecnologicas' => $nodo->lineas()->paginate(4),
            ]);
        }
        alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $nodo
     * @return \Illuminate\Http\Response
     */
    public function edit($nodo)
    {
        $nodo = $this->getNodoRepository()->findNodoForShow($nodo);
        if(request()->user()->can('create', $nodo)) {
            return view('nodos.edit', [
                'nodo' => $nodo,
                'lineas' => $this->getNodoRepository()->getAllLineas(),
                'regionales' => $this->getNodoRepository()->getAllRegionales(),
                'departamentos' => $this->getDepartamentoRepository()->getAllDepartamentos(),
            ]);
        }
        alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(NodoFormRequest $request, $id)
    {
        $this->authorize('edit', Nodo::class);
        $nodo = $this->getNodoRepository()->findById($id);
        $nodoUpdate = $this->getNodoRepository()->Update($request, $nodo);
        if ($nodoUpdate == true) {
            alert()->success('Modificación Exitoso.', 'El nodo ha sido modificado satisfactoriamente');
        } else {
            alert()->error('Modificación Erróneo.', 'El nodo no se ha modificado.');
        }
        return redirect()->route('nodo.index');
    }
}
