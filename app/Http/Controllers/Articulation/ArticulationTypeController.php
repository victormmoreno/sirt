<?php

namespace App\Http\Controllers\Articulation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Entidad;
use App\Models\ArticulationType;
use App\Repositories\Repository\Articulation\ArticulationTypeRepository;
use App\Http\Requests\ArticulationTypeRequest;
use Illuminate\Support\Facades\Validator;

class ArticulationTypeController extends Controller
{
    private $articulationTypeRepository;

    public function __construct(ArticulationTypeRepository $articulationTypeRepository)
    {
        $this->middleware(['auth']);
        $this->articulationTypeRepository = $articulationTypeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (request()->user()->can('index', ArticulationType::class)) {
            if (request()->ajax()) {
                return $this->articulationTypeRepository->filterSupports($request);
            }
            return view('articulation-type.index');
        }
        return redirect()->route('home');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (request()->user()->can('create', ArticulationType::class)) {
            return view('articulation-type.create');
        }
        return redirect()->route('home');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (request()->user()->can('create', ArticulationType::class)) {
            $req = new ArticulationTypeRequest;
            $validator = Validator::make($request->all(), $req->rules(), $req->messages());
            if ($validator->fails()) {
                return response()->json([
                    'fail' => true,
                    'errors' => $validator->errors(),
                    'message' => 'Estas ingresando mal los datos',
                    'redirect_url' => null,
                ]);
            }
            $result = $this->articulationTypeRepository->storeTypeArticulation($request);
            if (!$result) {
                return response()->json([
                    'fail' => true,
                    'errors' => $this->articulationTypeRepository->getError(),
                    'message' => 'Vuelve a intentarlo',
                    'redirect_url' => null,
                ]);
            }
            return response()->json([
                'fail' => false,
                'errors' => null,
                'message' => "Registro extioso",
                'redirect_url' => url(route('tipoarticulaciones.index')),
            ]);
        }return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  int   $typeArticulation
     * @return \Illuminate\Http\Response
     */
    public function show( $typeArticulation)
    {
        if (request()->user()->can('show', ArticulationType::class)) {
            $typeArticulation = ArticulationType::query()->with('articulationsubtypes')->findOrFail($typeArticulation);
            return view('articulation-type.show', ['typeArticulation' => $typeArticulation]);
        }
        return redirect()->route('home');
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
        $typeArticulation = ArticulationType::findOrFail($typeArticulation);
        return view('articulation-type.edit', ['typeArticulation' => $typeArticulation, 'nodos' => $nodos]);
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
        $typeArticulation = ArticulationType::findOrFail($typeArticulation);
        $req       = new ArticulationTypeRequest;
        $validator = Validator::make($request->all(), $req->rules(), $req->messages());
        if ($validator->fails()) {
            return response()->json([
                'fail' => true,
                'errors' => $validator->errors(),
                'message' => 'Estas ingresando mal los datos',
                'redirect_url' => null,
            ]);
        }
        $result = $this->articulationTypeRepository->updateTypeArticulation($request, $typeArticulation);
        if (!$result) {
            return response()->json([
                'fail'         => true,
                'errors'       => $this->articulationTypeRepository->getError(),
                'message' => 'Vuelve a intentarlo',
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
     * @param  int  $typeArticulation
     * @return \Illuminate\Http\Response
     */
    public function destroy($typeArticulation)
    {
        $typeArticulation = ArticulationType::findOrFail($typeArticulation);
        if($typeArticulation->articulationsubtypes->count() > 0 ){
            return response()->json([
                'fail'         => true,
                'redirect_url' => route('tipoarticulaciones.show', $typeArticulation->id),
            ]);
        }
        $typeArticulation->delete();
        return response()->json([
            'fail'         => false,
            'redirect_url' => route('tipoarticulaciones.index'),
        ]);
    }
}
