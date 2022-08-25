<?php

namespace App\Http\Controllers\Articulation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Accompaniment\AccompanimentRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use App\Repositories\Repository\Accompaniment\AccompanimentRepository;
use Illuminate\Database\Eloquent\Model;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\ArticulationStage;


class ArticulationStageRegisterController extends Controller
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

    public function edit(ArticulationStage $accompaniment)
    {
        return view('articulation.edit', compact('accompaniment'));
    }

    /**
     * Update the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ArticulationStage $accompaniment)
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

            $response = $this->accompanimentRepository->update($request, $accompaniment);
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
    public function downloadFile(ArticulationStage $accompaniment)
    {
        return $this->accompanimentRepository->downloadFile($accompaniment);
    }

    /**
     * request phase approval
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function requestApproval(ArticulationStage $accompaniment)
    {
        if ($accompaniment->status == ArticulationStage::STATUS_CLOSE) {
            Alert::error('Acceso no permitido!', 'No puedes enviar solicitudes de aprobación!')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        $notification = $this->accompanimentRepository->notifyPhaseApproval($accompaniment);
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
