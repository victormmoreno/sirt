<?php

namespace App\Http\Controllers;

use App\Http\Requests\NodoFormRequest;
use Illuminate\Http\Request;
use Repositories\Repository\NodoRepository;

class NodoController extends Controller
{

    public $nodoRepository;

    public function __construct(NodoRepository $nodoRepository)
    {
        $this->middleware('auth');
        $this->nodoRepository = $nodoRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // dd($this->nodoRepository->getAlltNodo());
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
                ->rawColumns(['detail','edit'])
                ->make(true);
        }
        return view('nodos.administrador.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('nodos.administrador.create',[
            'lineas' => $this->nodoRepository->getAllLineas(),
            'regionales' => $this->nodoRepository->getAllRegionales(),
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
        //metodo para guardad
        $nodoCreate = $this->nodoRepository->create($request);
 
        if ($nodoCreate != null) {
          
            alert()->success('Registro Exitoso.', 'El nodo ha sido creado satisfactoriamente');
        }else{
            alert()->error('Registro Erróneo.','El nodo no se ha creado.');
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
        // $nodo = $this->nodoRepository->findByid($id);
        return view('nodos.administrador.edit',[
            'nodo' => $this->nodoRepository->findByid($id),
            'lineas' => $this->nodoRepository->getAllLineas(),
            'regionales' => $this->nodoRepository->getAllRegionales(),
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
        dd($request->all());
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
