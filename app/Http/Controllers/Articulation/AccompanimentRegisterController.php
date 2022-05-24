<?php

namespace App\Http\Controllers\Articulation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AlcanceArticulacion;
use App\Models\Accompaniment;
use App\Http\Requests\Accompaniment\AccompanimentRequests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use App\Models\Actividad;

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
                'accompaniment_type' => $request->accompaniment_type == 'empresa' ? \App\Models\Sede::class : \App\Models\Proyecto::class,
                'code' => 'Aco24'. rand(1, 10000),
                'name' => $request->name_accompaniment,
                'description' => $request->description_accompaniment,
                'scope'  => $request->scope_accompaniment,
                'status' => Accompaniment::STATUS_OPEN,
                'start_date' => \Carbon\Carbon::now(),
                'confidentiality_format' => Accompaniment::CONFIDENCIALITY_FORMAT_YES,
                'terms_verified_at' => \Carbon\Carbon::now(),
                'node_id' => auth()->user()->articulador->nodo->id,
                'interlocutor_talent_id' => $request->talent,
                'created_by' => auth()->user()->id
            ]);

            if($request->accompaniment_type == 'pbt'){
                $model = \App\Models\Proyecto::where('id', $request->projects)->first();
                $model->accompaniamentables()->sync([$accompaniment->id]);
            }else if($request->accompaniment_type == 'empresa'){
                $model = \App\Models\Sede::where('id', $request->sedes)->first();
                $model->accompaniamentables()->sync([$accompaniment->id]);
            }
            return response()->json([
                'data' => [
                    'state'   => 'success',
                    'url' => route('accompaniments.show', $accompaniment->id),
                    'status_code' => Response::HTTP_CREATED,
                    'errors' => [],
                ],
            ], Response::HTTP_CREATED);

        }
    }


}
