<?php

namespace App\Http\Controllers\Articulation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Articulation;
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
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function create( $id )
    {
        $scopes = AlcanceArticulacion::orderBy('nombre')->pluck('nombre', 'id');
        $articulationStage= ArticulationStage::findOrFail( $id );
        return view('articulation.create-articulation', compact( 'scopes', 'articulationStage' ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, int $id)
    {
        $articulationStage = ArticulationStage::findOrFail($id);
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
                        'url' => route('articulations.show', $response['data']->id),
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

}
