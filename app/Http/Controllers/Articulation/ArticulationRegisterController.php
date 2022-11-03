<?php

namespace App\Http\Controllers\Articulation;

use App\Models\Articulation;
use App\Models\ArticulationType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ArticulationStage;
use App\Models\AlcanceArticulacion;
use Illuminate\Http\Response;
use App\Http\Requests\Articulation\ArticulationRequest;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Repository\Articulation\ArticulationRepository;

class ArticulationRegisterController extends Controller
{
    private $articulationRespository;

    public function __construct(ArticulationRepository $articulationRespository)
    {
        $this->articulationRespository = $articulationRespository;
        $this->middleware(['auth']);
    }
    /**
     * Show the form for creating a new resource.
     * @param string $code
     * @return \Illuminate\Http\Response
     */
    public function create($code)
    {
        $scopes = AlcanceArticulacion::orderBy('name')->pluck('name', 'id');
        $articulationStage= ArticulationStage::where('code', $code)->firstOrFail();
        $articulationTypes= ArticulationType::query()
            ->where('state', ArticulationType::mostrar())
            ->orderBy('name')->pluck('name', 'id');
        return view('articulation.create-articulation', compact( 'scopes', 'articulationStage', 'articulationTypes' ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $code
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, string $code)
    {
        $articulationStage = ArticulationStage::where('code', $code)->firstOrFail();
        $req = new ArticulationRequest;
        $validator = Validator::make($request->all(), $req->rules(), $req->messages());
        if ($validator->fails()) {
            return response()->json([
                'data' => [
                    'state'   => 'danger',
                    'errors' => $validator->errors(),
                ]
            ]);
        } else {

            $response = $this->articulationRespository->store($request, $articulationStage);
            if($response["isCompleted"]){
                return response()->json([
                    'data' => [
                        'state'   => 'success',
                        'url' => route('articulations.show', $response['data']),
                        'status_code' => Response::HTTP_CREATED,
                        'errors' => [],
                    ],
                ], Response::HTTP_CREATED);
            }else{
                return response()->json([
                    'data' => [
                        'state'   => 'danger',
                        'errors' => [],
                    ],
                ]);
            }
        }
    }

    /**
     * Update a resource.
     * @param  \Illuminate\Http\Request  $request
     */
    public function update(Request $request, $code)
    {
        $articulation = Articulation::query()->where('code', $code)->firstOrFail();
        $req = new ArticulationRequest;
        $validator = Validator::make($request->all(), $req->rules(), $req->messages());
        if ($validator->fails()) {
            return response()->json([
                'data' => [
                    'state' => 'danger',
                    'errors' => $validator->errors(),
                ]
            ]);
        } else {
            $response = $this->articulationRespository->update($request, $articulation);
            if($response["isCompleted"]){
                return response()->json([
                    'data' => [
                        'state'   => 'success',
                        'url' => route('articulations.show', $response['data']),
                        'status_code' => Response::HTTP_CREATED,
                        'errors' => [],
                    ],
                ], Response::HTTP_CREATED);
            }else{
                return response()->json([
                    'data' => [
                        'state'   => 'danger',
                        'errors' => $this->articulationStageRepository->getError(),
                    ],
                ]);
            }
        }
    }

}
