<?php

namespace App\Http\Controllers\Nodo;

use App\Http\Controllers\Controller;
use App\Http\Requests\NodoFormRequest;
use App\Models\Nodo;
use App\Repositories\Repository\DepartamentoRepository;
use App\User;
use Illuminate\Http\Request;
use Repositories\Repository\NodoRepository;

class NodoController extends Controller
{

    public $nodoRepository;
    public $departamentoRepository;

    public function __construct(NodoRepository $nodoRepository, DepartamentoRepository $departamentoRepository)
    {
        $this->middleware('auth');
        $this->middleware('role_session:Administrador|Dinamizador|Gestor|Talento');
        $this->nodoRepository         = $nodoRepository;
        $this->departamentoRepository = $departamentoRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $this->authorize('index', Nodo::class);

        switch (session()->get('login_role')) {
            case User::IsAdministrador():
                if (request()->ajax()) {
                    return datatables()->of($this->nodoRepository->getAlltNodo())
                        ->addColumn('detail', function ($data) {
                            $button = '<a class="waves-effect waves-light btn tooltipped blue-grey m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Ver Lineas" onclick="" data-tooltip-id="b24478ad-402e-0583-7a3a-de01b3861e9a"><i class="material-icons">info_outline</i></a>';

                            return $button;
                        })
                        ->addColumn('edit', function ($data) {
                            $button = '<a href="' . route("nodo.edit", $data->id) . '" class="waves-effect waves-light btn tooltipped m-b-xs" data-position="bottom" data-delay="50" data-tooltip="Editar"><i class="material-icons">edit</i></a>';

                            return $button;
                        })
                        ->rawColumns(['detail', 'edit'])
                        ->make(true);

                }
                return view('nodos.index');

                break;
            case User::IsDinamizador():
                if (isset(auth()->user()->dinamizador)) {
                    $nodo = auth()->user()->dinamizador->nodo->id;

                    // return $this->nodoRepository->getTeamTecnoparque()->where('id', $nodo)->first();

                    return view('nodos.show', [
                        'nodo' => $this->nodoRepository->getTeamTecnoparque()->where('id', $nodo)->first(),
                    ]);

                }
                abort('403');

                break;
            case User::IsGestor():

                if (isset(auth()->user()->gestor)) {
                    $nodo = auth()->user()->gestor->nodo->id;

                    return $this->nodoRepository->getTeamTecnoparque()->where('id', $nodo)->get();

                    return view('nodos.show', [
                        'nodo' => $this->nodoRepository->getTeamTecnoparque()->where('id', $nodo)->get(),
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
            'lineas'        => $this->nodoRepository->getAllLineas(),
            'regionales'    => $this->nodoRepository->getAllRegionales(),
            'departamentos' => $this->departamentoRepository->getAllDepartamentos(),
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
        //metodo para guardad
        $nodoCreate = $this->nodoRepository->storeNodo($request);

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

        $nodo = $this->nodoRepository->findByid($id);
        // dd($nodo);
        return view('nodos.edit', [
            'entidad'       => $this->nodoRepository->findByid($id),
            'lineas'        => $this->nodoRepository->getAllLineas(),
            'regionales'    => $this->nodoRepository->getAllRegionales(),
            'departamentos' => $this->departamentoRepository->getAllDepartamentos(),
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

        $entidadNodo = $this->nodoRepository->findById($id);
        // dd($nodo);
        $nodoUdate = $this->nodoRepository->update($request, $entidadNodo);

        if ($nodoUdate == true) {

            alert()->success('Modificación Exitoso.', 'El nodo ha sido modificado satisfactoriamente');
        } else {
            alert()->error('Modificación Erróneo.', 'El nodo no se ha modificado.');
        }
        return redirect()->route('nodo.index');
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
}
