<?php

namespace App\Http\Controllers\Accompaniment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Accompaniment\AccompanimentRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use App\Repositories\Repository\Accompaniment\AccompanimentRepository;

class AccompanimentRegisterController extends Controller
{
    private $accompanimentRepository;

    public function __construct(AccompanimentRepository $accompanimentRepository)
    {
        $this->accompanimentRepository = $accompanimentRepository;
        $this->middleware(['auth']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('articulation.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $req = new AccompanimentRequest;
        $validator = Validator::make($request->all(), $req->rules(), $req->messages());
        if ($validator->fails()) {
            return response()->json([
                'data' => [
                    'state'   => 'danger',
                    'errors' => $validator->errors(),
                ]
            ]);
        } else {

            $response = $this->accompanimentRepository->store($request);
            if($response["isCompleted"]){
                return response()->json([
                    'data' => [
                        'state'   => 'success',
                        'url' => route('accompaniments.show', $response['data']->id),
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
