<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entidad;
use App\Models\TipoArticulacion;
use App\Repositories\Repository\TipoArticulacionRepository;
use App\Http\Requests\TipoArticulacionRequest;
use Illuminate\Support\Facades\Validator;

class TipoArticulacionController extends Controller
{
    private $tipoArticulacionRepository;

    public function __construct(TipoArticulacionRepository $tipoArticulacionRepository)
    {
        $this->middleware(['auth', 'role_session:Administrador']);
        $this->tipoArticulacionRepository = $tipoArticulacionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (request()->ajax()) {
            return $this->tipoArticulacionRepository->filterSupports($request);;
        }
        $nodos = Entidad::has('nodo')->orderBy('nombre')->get()->pluck('nombre', 'nodo.id');
        return view('tipoarticulaciones.index', ['nodos' =>$nodos]);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $nodos = Entidad::has('nodo')->orderBy('nombre')->get()->pluck('nombre', 'nodo.id');
        return view('tipoarticulaciones.create', ['nodos' =>$nodos]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return var_dump($request->filled('checkestado')) ;
        $req       = new TipoArticulacionRequest;
        $validator = Validator::make($request->all(), $req->rules(), $req->messages());
        if ($validator->fails()) {
            return response()->json([
                'fail'   => true,
                'errors' => $validator->errors(),
                'redirect_url' => null,
            ]);
        }
        $result = $this->tipoArticulacionRepository->storeTypeArticulation($request);
        if (!$result) {
            return response()->json([
                'fail'         => true,
                'errors'       => $this->supportRepository->getError(),
                'redirect_url' => null,
            ]);
        }
        return response()->json([
            'fail'         => false,
            'errors'       => null,
            'redirect_url' => url(route('tipoarticulaciones.index')),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int   $typeArticulation
     * @return \Illuminate\Http\Response
     */
    public function show( $typeArticulation)
    {
        $typeArticulation = TipoArticulacion::findOrFail($typeArticulation);
        return view('tipoarticulaciones.show', ['typeArticulation' => $typeArticulation]);
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
}
