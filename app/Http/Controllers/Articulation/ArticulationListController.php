<?php

namespace App\Http\Controllers\Articulation;

use App\Models\AlcanceArticulacion;
use App\Models\ArticulationType;
use App\Models\Fase;
use App\Repositories\Repository\Articulation\ArticulationRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Articulation;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Articulation\ArticulationClosingRequest;


class ArticulationListController extends Controller
{
    private $articulationRespository;

    public function __construct(ArticulationRepository $articulationRespository)
    {
        $this->articulationRespository = $articulationRespository;
        $this->middleware(['auth']);
    }

    /**
     * Display the specified resource.
     *
     * @param string $code
     * @return \Illuminate\Http\Response
     */
    public function show($code)
    {
        $articulation = Articulation::query()
            ->with(['articulationstage'])
            ->where('code', $code)->firstOrFail();
        if (request()->user()->cannot('show', $articulation))
        {
            alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        $traceability = Articulation::getTraceability($articulation)->get();
        $ult_traceability = Articulation::getTraceability($articulation)->get()->last();
        $ult_notificacion = $this->articulationRespository->retornarUltimaNotificacionPendiente($articulation);
        $rol_destinatario = $this->articulationRespository->verifyRecipientNotification($ult_notificacion);
        return view('articulation.show-articulation', compact('articulation', 'traceability', 'ult_traceability', 'ult_notificacion', 'rol_destinatario'));
    }

    /**
     * Display the specified resource.
     *
     * @param string $code
     * @param string $phase
     * @return \Illuminate\Http\Response
     */
    public function showPhase($code, $phase)
    {
        $articulation = Articulation::query()->with(['articulationstage'])->where('code', $code)->firstOrFail();
        switch (strtoupper($phase)) {
            case 'INICIO':
                if (request()->user()->cannot('showStart', $articulation))
                {
                    alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
                    return redirect()->route('home');
                }
                $scopes = AlcanceArticulacion::orderBy('name')->pluck('name', 'id');
                $articulationTypes = ArticulationType::query()
                    ->where('state', ArticulationType::mostrar())
                    ->orderBy('name')->pluck('name', 'id');
                return view('articulation.edit-articulation', compact('articulation', 'scopes', 'articulationTypes'));
                break;
            case 'EJECUCION':
                if (request()->user()->cannot('showExecution', $articulation))
                {
                    alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
                    return redirect()->route('home');
                }
                return view('articulation.edit-articulation-execution', compact('articulation'));
                break;
            case 'CIERRE':
                if (request()->user()->cannot('showClosing', $articulation))
                {
                    alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
                    return redirect()->route('home');
                }
                return view('articulation.edit-articulation-closing', compact('articulation'));
                break;
            default:
                alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
                return redirect()->route('home');
                break;
        }
    }

    /**
     * Display the specified resource.
     */
    public function changeNextPhase($code, $phase)
    {
        $articulation = Articulation::query()->with(['articulationstage'])->where('code', $code)->firstOrFail();
        if (request()->user()->cannot('changePhase', $articulation)) {
            alert()->warning(__('Sorry, you are not authorized to access the page') . ' ' . request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        switch (strtoupper($phase)) {
            case 'INICIO':
                return redirect()->route('articulations.show', $articulation);
                break;
            case 'EJECUCION':
                $articulation->update(['phase_id' => Fase::where('nombre', Articulation::IsEjecucion())->first()->id]);
                $comentario = 'desde inicio';
                $movimiento = \App\Models\Movimiento::IsCambiar();
                $articulation->createTraceability($movimiento, Session::get('login_role'), $comentario, strtolower($phase));
                return redirect()->route('articulations.show.phase', [$articulation, 'ejecucion']);
                break;
            case 'CIERRE':
                $articulation->update(['phase_id' => Fase::where('nombre', Articulation::IsCierre())->first()->id]);
                $comentario = 'desde ejecución';
                $movimiento = \App\Models\Movimiento::IsCambiar();
                $articulation->createTraceability($movimiento, Session::get('login_role'), $comentario, strtolower($phase));
                return redirect()->route('articulations.show.phase', [$articulation, 'cierre']);
                break;
            default:
                return redirect()->route('articulations.show', $articulation);
                break;
        }
    }

    public function changePreviusPhase($code, $phase)
    {
        $articulation = Articulation::query()->with(['articulationstage'])->where('code', $code)->firstOrFail();
        if (request()->user()->cannot('changePhase', $articulation)) {
            alert()->warning(__('Sorry, you are not authorized to access the page') . ' ' . request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        switch (strtoupper($phase)) {
            case 'INICIO':
                $articulation->update(['phase_id' => Fase::where('nombre', Articulation::IsInicio())->first()->id]);
                $comentario = 'desde ejecución';
                $movimiento = \App\Models\Movimiento::IsCambiar();
                $articulation->createTraceability($movimiento, Session::get('login_role'), $comentario, strtolower($phase));
                return redirect()->route('articulations.show', $articulation);
                break;
            case 'EJECUCION':
                $articulation->update(['phase_id' => Fase::where('nombre', Articulation::IsEjecucion())->first()->id]);
                $comentario = 'desde cierre';
                $movimiento = \App\Models\Movimiento::IsCambiar();
                $articulation->createTraceability($movimiento, Session::get('login_role'), $comentario, strtolower($phase));
                return redirect()->route('articulations.show', $articulation);
                break;
            case 'CIERRE':
                return redirect()->route('articulations.show.phase', [$articulation, 'ejecucion']);
                break;
            default:
                return redirect()->route('articulations.show', $articulation);
                break;
        }
    }


    public function updatePhaseExecute(Request $request, $code)
    {
        $articulation = Articulation::query()->where('code', $code)->firstOrFail();
        if (request()->user()->cannot('showExecution', $articulation)) {
            alert()->warning(__('Sorry, you are not authorized to access the page') . ' ' . request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        $response = $this->articulationRespository->updateEntregablesEjecucionRepository($request, $articulation);
        if ($response != null) {
            Alert::success('Modificación Exitosa!', 'Los entregables de la articulación en la fase de ejecución se han modificado!')->showConfirmButton('Ok', '#3085d6');
            return redirect()->route('articulations.show', $response);
        } else {
            Alert::error('Modificación Errónea!', 'Los entregables de la articulación en la fase de ejecución no se han modificado!')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
    }

    /**
     * Display the specified resource for change the interlocutor talent of an articulation stage.
     *
     * @param string $code
     * @return \Illuminate\Http\Response
     */
    public function changeTalents($code)
    {
        $articulation = Articulation::query()->where('code', $code)->firstOrFail();
        if (request()->user()->cannot('changeTalents', $articulation)) {
            alert()->warning(__('Sorry, you are not authorized to access the page') . ' ' . request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        return view('articulation.change-talents', compact('articulation'));
    }

    public function requestApproval($code)
    {
        $articulation = Articulation::query()->where('code', $code)->firstOrFail();
        if (request()->user()->cannot('requestApproval', $articulation)) {
            alert()->warning(__('Sorry, you are not authorized to access the page') . ' ' . request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        if ($articulation->phase->nombre == Articulation::IsFinalizado() || $articulation->phase->nombre == Articulation::IsSuspendido()) {
            alert()->warning(__('Sorry, you are not authorized to access the page') . ' ' . request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        $notification = $this->articulationRespository->notifyApprovalPhase($articulation);
        if ($notification['notificacion']) {
            Alert::success('Notificación Exitosa!', $notification['msg'])->showConfirmButton('Ok', '#3085d6');
        } else {
            Alert::error('Notificación Errónea!', $notification['msg'])->showConfirmButton('Ok', '#3085d6');
        }
        return back();
    }

    /**
     * method to change the interlocutor talent of an articulation stage
     *
     * @param \Illuminate\Http\Request $request
     * @param string $code
     */
    public function updateTalents(Request $request, $code)
    {
        $articulation = Articulation::query()->where('code', $code)->firstOrFail();
        if (request()->user()->cannot('changeTalents', $articulation)) {
            alert()->warning(__('Sorry, you are not authorized to access the page') . ' ' . request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        $validator = Validator::make($request->all(), [
            'talents' => 'required'
        ], [
            'talents' => 'Debes seleccionar por lo menos un talento participante'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'fail' => true,
                'errors' => $validator->errors(),
            ]);
        } else {
            $response = $this->articulationRespository->updateTalentsParticipants($request, $articulation);
            if ($response["isCompleted"]) {
                return response()->json([
                    'data' => [
                        'fail' => false,
                        'url' => route('articulations.show', $response['data']),
                        'status_code' => Response::HTTP_CREATED,
                        'errors' => [],
                    ],
                ], Response::HTTP_CREATED);
            } else {
                return response()->json([
                    'data' => [
                        'fail' => true,
                        'errors' => $this->articulationRespository->getError(),
                    ],
                ]);
            }
        }
    }

    public function updatePhaseClosing(Request $request, $code)
    {
        $articulation = Articulation::query()->where('code', $code)->firstOrFail();
        if (request()->user()->cannot('updatePhaseClosing', $articulation)) {
            alert()->warning(__('Sorry, you are not authorized to access the page') . ' ' . request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        $req = new ArticulationClosingRequest;
        $validator = Validator::make($request->all(), $req->rules(), $req->messages(), $req->attributes());
        if ($validator->fails()) {
            return response()->json([
                'data' => [
                    'fail' => true,
                    'errors' => $validator->errors(),
                ]
            ]);
        } else {
            $response = $this->articulationRespository->updateClosing($request, $articulation);
            if ($response["isCompleted"]) {
                return response()->json([
                    'data' => [
                        'fail' => false,
                        'url' => route('articulations.show', $response['data']),
                        'status_code' => Response::HTTP_CREATED,
                        'errors' => [],
                    ],
                ], Response::HTTP_CREATED);
            } else {
                return response()->json([
                    'data' => [
                        'fail' => true,
                        'errors' => $this->articulationRespository->getError(),
                    ],
                ]);
            }
        }
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function manageApprovall(Request $request, $id, string $phase = null)
    {
        $articulation = Articulation::findOrFail($id);
        if (request()->user()->cannot('showButtonAprobacion', $articulation)) {
            alert()->warning(__('Sorry, you are not authorized to access the page') . ' ' . request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        $update = $this->articulationRespository->manageEndorsement($request, $articulation, $phase);
        if ($update['state']) {
            Alert::success($update['title'], $update['mensaje'])->showConfirmButton('Ok', '#3085d6');
            return back();
        } else {
            Alert::error($update['title'], $update['mensaje'])->showConfirmButton('Ok', '#3085d6');
            return back();
        }
    }
}
