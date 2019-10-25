<?php

namespace App\Http\Controllers\Nodo;

use App\Http\Controllers\Controller;
use App\Http\Requests\NodoFormRequest;
use App\Models\Nodo;
use App\Pdf\Nodo\NodoPdf;
use App\Repositories\Datatables\NodoDatatables;
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
            'role_session:Administrador|Dinamizador|Gestor|Talento',
        ]);
        $this->setNodoRepository($nodoRepository);
        $this->setDepartamentoRepository($departamentoRepository);
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
    public function index(NodoDatatables $nodoDatatables)
    {

        $this->authorize('index', Nodo::class);

        switch (session()->get('login_role')) {
            case User::IsAdministrador():
                if (request()->ajax()) {
                    return $nodoDatatables->indexDatatable($this->getNodoRepository()->getAlltNodo());
                }
                return view('nodos.index');

                break;
            case User::IsDinamizador():
                if (isset(auth()->user()->dinamizador)) {
                    $nodoAuth = auth()->user()->dinamizador->nodo->id;
                    $nodo = $this->getNodoRepository()->getTeamTecnoparque()->where('id', $nodoAuth)->first();

                    return view('nodos.show', [
                        'nodo' => $nodo,
                        'equipos' => $nodo->equipos()->with(['lineatecnologica'])->paginate(5),
                        'lineatecnologicas' => $nodo->lineas()->paginate(4),
                    ]);
                }
                abort('403');
                break;
            case User::IsGestor():

                if (isset(auth()->user()->gestor)) {
                    $nodoAuth = auth()->user()->gestor->nodo->id;
                    $nodo = $this->getNodoRepository()->getTeamTecnoparque()->where('id', $nodoAuth)->first();
                    return view('nodos.show', [
                        'nodo' => $nodo,
                        'equipos' => $nodo->equipos()->with(['lineatecnologica'])->paginate(5),
                        'lineatecnologicas' => $nodo->lineas()->paginate(4),
                    ]);
                }
                abort('403');
                break;
            default:
                abort('403');
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
        $this->authorize('create', Nodo::class);
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
        $this->authorize('store', Nodo::class);
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
        $this->authorize('show', $nodo);

        return view('nodos.show', [
            'nodo' => $nodo,
            'equipos' => $nodo->equipos()->with(['lineatecnologica'])->paginate(5),
            'lineatecnologicas' => $nodo->lineas()->paginate(4),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $nodo
     * @return \Illuminate\Http\Response
     */
    public function edit($nodo)
    {
        $this->authorize('edit', Nodo::class);
        $nodo = $this->getNodoRepository()->findNodoForShow($nodo);
        return view('nodos.edit', [
            'nodo'          => $nodo,
            'lineas'        => $this->getNodoRepository()->getAllLineas(),
            'regionales'    => $this->getNodoRepository()->getAllRegionales(),
            'departamentos' => $this->getDepartamentoRepository()->getAllDepartamentos(),
        ]);
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

        $this->authorize('update', Nodo::class);
        $nodo = $this->getNodoRepository()->findById($id);

        $nodoUpdate  = $this->getNodoRepository()->update($request, $nodo);

        if ($nodoUpdate == true) {

            alert()->success('Modificación Exitoso.', 'El nodo ha sido modificado satisfactoriamente');
        } else {
            alert()->error('Modificación Erróneo.', 'El nodo no se ha modificado.');
        }
        return redirect()->route('nodo.index');
    }

    public function pdfEquipoNodo(NodoPdf $nodoPdf)
    {
        return $nodoPdf->downloadPdfEquipoNodo();
    }

}
