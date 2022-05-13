<?php

namespace App\Http\Controllers\Articulation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccompanimentRegisterController extends Controller
{
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

        // $req = new ArticulacionFaseInicioFormRequest;
        // $validator = Validator::make($request->all(), $req->rules(), $req->messages());
        // if ($validator->fails()) {
        //     return response()->json([
        //         'state'   => 'error_form',
        //         'errors' => $validator->errors(),
        //     ]);
        // } else {
        //     $response = $this->getArticulacionRepository()->store($request);
        //     if ($response != null) {
        //         return response()->json([
        //             'data' => $response,
        //             'url' => route('articulaciones.show', $response->id),
        //             'status_code' => Response::HTTP_CREATED,
        //         ], Response::HTTP_CREATED);
        //     } else {
        //         return response()->json(['status_code' => Response::HTTP_NOT_FOUND]);
        //     }
        // }
    }


}
