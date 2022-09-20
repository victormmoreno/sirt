<?php

namespace App\Http\Controllers\Articulation;

use App\Models\ArticulationSubtype;
use App\Models\ArticulationType;
use App\Models\Nodo;
use App\Repositories\Repository\Articulation\ArticulationSubtypeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Articulation\ArticulationSubtypeRequest;


class ArticulationSubtypeController extends Controller
{
    private $articulationSubtypeRepository;

    public function __construct(ArticulationSubtypeRepository $articulationSubtypeRepository)
    {
        $this->middleware(['auth']);
        $this->articulationSubtypeRepository = $articulationSubtypeRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->user()->can('index', ArticulationSubtype::class)) {
            $nodos = null;
            if($request->user()->can('listNodes', ArticulationSubtype::class))
            {
                $nodos = Nodo::query()->with('entidad')->get();
                $nodos = collect($nodos)->pluck('entidad.nombre', 'id');
            }
            if ($request->ajax()) {
                return $this->articulationSubtypeRepository->filterArtuculationSubtypes($request);
            }
            $articulationTypes = ArticulationType::all()->pluck('name', 'id');
            return view('articulation-subtype.index', compact('nodos', 'articulationTypes'));
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
        if (request()->user()->can('create', ArticulationSubtype::class))
        {
            $nodos = null;
            if(request()->user()->can('listNodes', ArticulationSubtype::class))
            {
                $nodos = Nodo::query()->with('entidad')->get();
                $nodos = collect($nodos)->pluck('entidad.nombre', 'id');
            }
            $articulationTypes = ArticulationType::all()->pluck('name', 'id');
            return view('articulation-subtype.create', compact('nodos', 'articulationTypes'));
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
        $req       = new ArticulationSubtypeRequest;
        $validator = Validator::make($request->all(), $req->rules(), $req->messages());
        if ($validator->fails()) {
            return response()->json([
                'fail'   => true,
                'errors' => $validator->errors(),
                'message' => null,
                'redirect_url' => null,
            ]);
        }
        $response = $this->articulationSubtypeRepository->store($request);
        if (!$response) {
            return response()->json([
                'fail'         => true,
                'errors'       => $this->articulationSubtypeRepository->getError(),
                'message' => null,
                'redirect_url' => null,
            ]);
        }
        return response()->json([
            'fail'         => false,
            'errors'       => null,
            'message' => "Registro extioso",
            'redirect_url' => url(route('tiposubarticulaciones.index')),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($articulationSubtype)
    {
        $articulationSubtype = ArticulationSubtype::query()
            ->with(['nodos.entidad', 'articulations'])
            ->findOrFail($articulationSubtype);

        return view('articulation-subtype.show', ['articulationSubtype' => $articulationSubtype]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($articulationSubtype)
    {
        if (request()->user()->can('create', ArticulationSubtype::class))
        {
            $nodos = null;
            $articulationSubtype = ArticulationSubtype::query()
                ->with('articulationtype')
                ->findOrFail($articulationSubtype);
            if(request()->user()->can('listNodes', ArticulationSubtype::class))
            {
                $nodos = Nodo::query()->with('entidad')->get();
                $nodos = collect($nodos)->pluck('entidad.nombre', 'id');
            }
            $articulationTypes = ArticulationType::all()->pluck('name', 'id');
            return view('articulation-subtype.edit', compact('nodos', 'articulationSubtype', 'articulationTypes'));
        }
        return redirect()->route('home');
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
        $articulationSubtype = ArticulationSubtype::findOrFail($id);
        $req       = new ArticulationSubtypeRequest;
        $validator = Validator::make($request->all(), $req->rules(), $req->messages());
        if ($validator->fails()) {
            return response()->json([
                'fail'   => true,
                'errors' => $validator->errors(),
                'message' => null,
                'redirect_url' => null,
            ]);
        }
        $response = $this->articulationSubtypeRepository->update($request, $articulationSubtype);
        if (!$response) {
            return response()->json([
                'fail'         => true,
                'errors'       => $this->articulationSubtypeRepository->getError(),
                'message' => null,
                'redirect_url' => null,
            ]);
        }
        return response()->json([
            'fail'         => false,
            'errors'       => null,
            'message' => "Actualización extiosa",
            'redirect_url' => url(route('tiposubarticulaciones.index')),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $articulationSubtype
     * @return \Illuminate\Http\Response
     */
    public function destroy($articulationSubtype)
    {
        $articulationSubtype = ArticulationSubtype::findOrFail($articulationSubtype);
        if(!$articulationSubtype->articulations->IsEmpty() ){
            return response()->json([
                'fail'         => true,
                'redirect_url' => route('tiposubarticulaciones.show', $articulationSubtype->id),
            ]);
        }
        $articulationSubtype->nodos()->detach();
        $articulationSubtype->delete();
        return response()->json([
            'fail'         => false,
            'redirect_url' => route('tiposubarticulaciones.index'),
        ]);
    }
}
