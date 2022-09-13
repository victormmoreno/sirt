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
                $nodos = collect($nodos)->pluck('entidad.nombre', 'id');
            }
            return view('articulation.create', compact('nodos'));
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
        if ($request->user()->can('store', ArticulationStage::class)) {
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
                $response = $this->articulationStageRepository->store($request);
                if ($response["isCompleted"]) {
                    return response()->json([
                        'data' => [
                            'state' => 'success',
                            'url' => route('articulation-stage.show', $response['data']->id),
                            'status_code' => Response::HTTP_CREATED,
                            'errors' => [],
                        ],
                    ], Response::HTTP_CREATED);
                } else {
                    return response()->json([
                        'data' => [
                            'state' => 'danger',
                            'errors' => [],
                        ],
                    ]);
                }
            }
        }
    }

    public function edit(ArticulationStage $articulationStage)
    {
        return view('articulation.edit', compact('articulationStage'));
    }

    /**
     * Update the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
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
            if($response["isCompleted"]){
                return response()->json([
                    'data' => [
                        'state'   => 'success',
                        'url' => route(' articulation-stage.show', $response['data']->id),
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
     * Update file
     * @return \Illuminate\Http\Response
     */
    public function downloadFile(ArticulationStage $articulationStage)
    {
        return $this->articulationStageRepository->downloadFile($articulationStage);
    }

    /**
     * request phase approval
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function requestApproval(ArticulationStage $articulationStage)
    {
        if ($articulationStage->status == ArticulationStage::STATUS_CLOSE) {
            Alert::error('Acceso no permitido!', 'No puedes enviar solicitudes de aprobación!')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        $notification = $this->articulationStageRepository->notifyPhaseApproval($articulationStage);
        if ($notification['notificacion']) {
            Alert::success('Notificación Exitosa!', $notification['msg'])->showConfirmButton('Ok', '#3085d6');
        } else {
            Alert::error('Notificación Errónea!', $notification['msg'])->showConfirmButton('Ok', '#3085d6');
        }
        return back();
    }

    /**
     * Método que valida que un experto no pueda hacer operaciones sobre un proyecto que no está asesorando
     *
     * @param Model $model
     * @return bool
     * @author dum
     */
    private function validateAsesor(Model $model) {
        if ($model->asesor->user->id != auth()->user()->id) {
            Alert::error('Acceso no permitido!', 'No puedes ver/gestionar  que no estás asesorando!')->showConfirmButton('Ok', '#3085d6');
            return false;
        }
        return true;
    }



}
