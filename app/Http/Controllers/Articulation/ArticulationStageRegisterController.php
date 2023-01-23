<?php

namespace App\Http\Controllers\Articulation;

use App\Models\ArticulationType;
use App\Models\Nodo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Articulation\ArticulationStageRequest;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Repository\Articulation\ArticulationStageRepository;
use App\Models\ArticulationStage;

class ArticulationStageRegisterController extends Controller
{
    private $articulationStageRepository;

    public function __construct(ArticulationStageRepository $articulationStageRepository)
    {
        $this->articulationStageRepository = $articulationStageRepository;
        $this->middleware(['auth']);
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (request()->user()->cannot('create', ArticulationStage::class))
        {
            alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        $nodos = null;
        if(request()->user()->can('listNodes', ArticulationStage::class))
        {
            $nodos = Nodo::query()->with('entidad')->get();
            $nodos = collect($nodos)->sortBy('entidad.nombre')->pluck('entidad.nombre', 'id');
        }
        return view('articulation.create-articulation-stage', compact('nodos'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function store(Request $request)
    {
        if ($request->ajax() && $request->user()->cannot('create', ArticulationStage::class)) {
            alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        $req = new ArticulationStageRequest;
        $validator = Validator::make($request->all(), $req->rules(), $req->messages());
        if ($validator->fails()) {
            return response()->json([
                'fail'   => true,
                'errors' => $validator->errors(),
                'message' => null,
                'redirect_url' => null,
            ]);
        } else {
            $response = $this->articulationStageRepository->store($request);
            if (!$response['state']) {
                return response()->json([
                    'fail'         => true,
                    'errors'       => $this->articulationStageRepository->getError(),
                    'message' => null,
                    'redirect_url' => null,
                ]);
            }
            return response()->json([
                'fail'         => false,
                'errors'       => null,
                'message' => "Registro extioso",
                'redirect_url' => url(route('articulation-stage.show', $response['data'])),
            ]);
        }
    }

    /**
     * Show the form for editing a resource.
     * @param  string $code
     * @return \Illuminate\Http\Response
     */
    public function edit($code)
    {
        $articulationStage = ArticulationStage::query()
            ->with([
                'createdBy',
                'projects.articulacion_proyecto.actividad',
                'interlocutor'
            ])->where('code',$code)->firstOrFail();
        if (request()->user()->cannot('update', $articulationStage))
        {
            alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        $nodos = null;
        if(request()->user()->can('listNodes', ArticulationStage::class))
        {
            $nodos = Nodo::query()->with('entidad')->get();
            $nodos = collect($nodos)->sortBy('entidad.nombre')->pluck('entidad.nombre', 'id');
        }
        $articulationTypes= ArticulationType::query()
            ->with('articulationsubtypes')
            ->where('articulation_types.state', ArticulationType::mostrar())
            ->orderBy('name')->get();
        return view('articulation.edit-articulation-stage', compact('nodos', 'articulationStage', 'articulationTypes'));
    }

    /**
     * Update a resource.
     * @param  \Illuminate\Http\Request  $request
     */
    public function update(Request $request, $code)
    {
        $articulationStage = ArticulationStage::query()->where('code',$code)->firstOrFail();
        if (request()->user()->cannot('update', $articulationStage)) {
            alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        $req = new ArticulationStageRequest;
        $validator = Validator::make($request->all(), $req->rules(), $req->messages());
        if ($validator->fails()) {
            return response()->json([
                'data' => [
                    'state' => 'danger',
                    'errors' => $validator->errors(),
                ]
            ]);
        } else {
            $response = $this->articulationStageRepository->update($request, $articulationStage);
            if (!$response['state']) {
                return response()->json([
                    'fail' => true,
                    'errors' => $this->articulationStageRepository->getError(),
                    'message' => null,
                    'redirect_url' => null,
                ]);
            }
            return response()->json([
                'data' => $response['data'],
                'fail' => false,
                'errors' => null,
                'message' => "Actualización extiosa",
                'redirect_url' => url(route('articulation-stage.show', $response['data'])),
            ]);
        }

    }
}
