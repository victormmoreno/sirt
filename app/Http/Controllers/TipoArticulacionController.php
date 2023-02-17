<?php

namespace App\Http\Controllers;

use App\Models\ArticulacionPbt;
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
        $this->middleware(['auth', 'role_session:Administrador|Activador'])->except(['show']);
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
        // return $request->input('checknode');
        $req       = new TipoArticulacionRequest;
        $validator = Validator::make($request->all(), $req->rules(), $req->messages());
        if ($validator->fails()) {
            return response()->json([
                'fail'   => true,
                'errors' => $validator->errors(),
                'message' => null,
                'redirect_url' => null,
            ]);
        }
        $result = $this->tipoArticulacionRepository->storeTypeArticulation($request);
        if (!$result) {
            return response()->json([
                'fail'         => true,
                'errors'       => $this->tipoArticulacionRepository->getError(),
                'message' => null,
                'redirect_url' => null,
            ]);
        }
        return response()->json([
            'fail'         => false,
            'errors'       => null,
            'message' => "Registro extioso",
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
        if (request()->ajax()) {
            return response()->json([
                'data' => $typeArticulation
            ]);
        }
        if(request()->user()->cannot('show', $typeArticulation))
        {
            alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        return view('tipoarticulaciones.show', ['typeArticulation' => $typeArticulation]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $typeArticulation
     * @return \Illuminate\Http\Response
     */
    public function edit($typeArticulation)
    {
        $nodos = Entidad::has('nodo')->orderBy('nombre')->get()->pluck('nombre', 'nodo.id');
        $typeArticulation = TipoArticulacion::findOrFail($typeArticulation);
        return view('tipoarticulaciones.edit', ['typeArticulation' => $typeArticulation, 'nodos' => $nodos]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $typeArticulation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $typeArticulation)
    {
        $typeArticulation = TipoArticulacion::findOrFail($typeArticulation);
        $req       = new TipoArticulacionRequest;
        $validator = Validator::make($request->all(), $req->rules(), $req->messages());
        if ($validator->fails()) {
            return response()->json([
                'fail'   => true,
                'errors' => $validator->errors(),
                'message' => null,
                'redirect_url' => null,
            ]);
        }
        $result = $this->tipoArticulacionRepository->updateTypeArticulation($request, $typeArticulation);
        if (!$result) {
            return response()->json([
                'fail'         => true,
                'errors'       => $this->tipoArticulacionRepository->getError(),
                'message' => null,
                'redirect_url' => null,
            ]);
        }
        return response()->json([
            'fail'         => false,
            'errors'       => null,
            'message' => "Actualización Exitosa",
            'redirect_url' => url(route('tipoarticulaciones.index')),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($typeArticulation)
    {
        $typeArticulation = TipoArticulacion::findOrFail($typeArticulation);
        if($typeArticulation->articulacionespbt->count() > 0 ){
            return response()->json([
                'fail'         => true,
                'redirect_url' => route('tipoarticulaciones.show', $typeArticulation->id),
            ]);
        }
        $typeArticulation->nodos()->detach();
        $typeArticulation->delete();
        return response()->json([
            'fail'         => false,
            'redirect_url' => route('tipoarticulaciones.index'),
        ]);
    }

}
