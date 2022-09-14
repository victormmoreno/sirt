<?php

namespace App\Http\Controllers\Articulation;

use App\Models\Nodo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Articulation\ArticulationStageRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use App\Repositories\Repository\Articulation\ArticulationStageRepository;
use Illuminate\Database\Eloquent\Model;
use RealRashid\SweetAlert\Facades\Alert;
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
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (request()->user()->can('create', ArticulationStage::class))
        {
            $nodos = null;
            if(request()->user()->can('listNodes', ArticulationStage::class))
            {
                $nodos = Nodo::query()->with('entidad')->get();
                $nodos = collect($nodos)->sortBy('entidad.nombre')->pluck('entidad.nombre', 'id');
            }
            return view('articulation.create-articulation-stage', compact('nodos'));
        }
        return redirect()->route('home');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        if ($request->user()->can('store', ArticulationStage::class)) {
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
                    'redirect_url' => url(route('articulation-stage.show', $response['data']->id)),
                ]);
            }
        }
    }

    public function edit($articulationStage)
    {
        $articulationStage = ArticulationStage::query()->findOrFail($articulationStage);
        if (request()->user()->can('update', $articulationStage))
        {
            $nodos = null;
            if(request()->user()->can('listNodes', ArticulationStage::class))
            {
                $nodos = Nodo::query()->with('entidad')->get();
                $nodos = collect($nodos)->sortBy('entidad.nombre')->pluck('entidad.nombre', 'id');
            }
            return view('articulation.edit-articulation-stage', compact('nodos', 'articulationStage'));
        }
        return redirect()->route('home');
    }

    /**
     * Update the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     */
    public function update(Request $request, ArticulationStage $articulationStage)
    {
        $req = new ArticulationStageRequest;
        $validator = Validator::make($request->all(), $req->rules(), $req->messages());
        if ($validator->fails()) {
            return response()->json([
                'data' => [
                    'state'   => 'danger',
                    'errors' => $validator->errors(),
                ]
            ]);
        } else {
            $response = $this->articulationStageRepository->update($request, $articulationStage);
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
                'message' => "Actualización extiosa",
                'redirect_url' => url(route('articulation-stage.show', $response['data']->id)),
            ]);
        }
    }


}
