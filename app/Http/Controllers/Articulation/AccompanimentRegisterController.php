<?php

namespace App\Http\Controllers\Articulation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AlcanceArticulacion;
use App\Models\Accompaniment;
use App\Http\Requests\Accompaniment\AccompanimentRequests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

class AccompanimentRegisterController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $scopes = AlcanceArticulacion::orderBy('nombre')->pluck('nombre', 'id');
        return view('articulation.create', compact('scopes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $req = new AccompanimentRequests;
        $validator = Validator::make($request->all(), $req->rules(), $req->messages());
        if ($validator->fails()) {
            return response()->json([
                'data' => [
                    'state'   => 'danger',
                    'errors' => $validator->errors(),
                ]

            ]);
        } else {
            $accompaniment = Accompaniment::create([
                'accompaniment_type' => $request->accompaniment_type == 'empresa' ? \App\Models\PEmpresa::class : \App\Models\Proyecto::class,
                'code' => 'Aco24'. rand(1, 10000),
                'name' => $request->name_accompaniment,
                'description' => $request->description_accompaniment,
                'scope'  => $request->scope_accompaniment,
                'status' => Accompaniment::STATUS_OPEN,
                'start_date' => \Carbon\Carbon::now(),
                'confidentiality_format' => 1,
                'node_id' => auth()->user()->articulador->nodo->id,
                'interlocutor_talent_id' => $request->talent,
                'created_by' => auth()->user()->id
            ]);
            return response()->json([
                'data' => [
                    'state'   => 'success',
                    'url' => route('articulation.accompaniments.show', $accompaniment->id),
                    'status_code' => Response::HTTP_CREATED,
                    'errors' => [],
                ],
            ], Response::HTTP_CREATED);

        }
    }


}
