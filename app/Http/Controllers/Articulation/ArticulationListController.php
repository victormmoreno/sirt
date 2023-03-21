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
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade as PDF;


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

    public function evidences(string $code)
    {
        $articulation = Articulation::query()->where('code',$code)->firstOrFail();
        if (request()->user()->can('uploadEvidences', [$articulation, "Inicio"]) || request()->user()->can('uploadEvidences', [$articulation, "Cierre"])) {
            return view('articulation.articulation-evidences', ['articulation' => $articulation]);
        }
        alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
            return redirect()->back();

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
                'data' => [
                    'fail' => true,
                    'errors' => $validator->errors(),
                ]
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

    public function downloadCertificate(string $phase, $code){
        $articulation = Articulation::query()
            ->select(
                'articulations.*', 'articulation_stages.code as articulation_stage_code',
                'articulation_stages.id as articulation_stages_id','articulation_stages.start_date as articulation_stages_start_date','articulation_stages.end_date as articulation_stages_end_date','articulation_stages.name as articulation_stages_name','articulation_stages.description as articulation_stages_description', 'articulation_stages.scope as articulation_stages_scope', 'articulation_stages.expected_results as articulation_stages_expected_results','fases.nombre as fase',
                'entidades.nombre as nodo', 'actividades.codigo_actividad as codigo_proyecto',
                'actividades.nombre as nombre_proyecto', 'interlocutor.documento', 'interlocutor.nombres',
                'interlocutor.apellidos', 'interlocutor.email'
            )
            ->selectRaw("if(articulationables.articulationable_type = 'App\\\Models\\\Proyecto', 'Proyecto', 'No registra') as articulation_type, if(articulation_stages.status = 1,'Abierta', 'Cerrada') as articulation_stages_status")
            ->leftJoin('articulation_stages', 'articulation_stages.id', '=', 'articulations.articulation_stage_id')
            ->join('nodos', 'nodos.id', '=', 'articulation_stages.node_id')
            ->join('entidades', 'entidades.id', '=', 'nodos.entidad_id')

            ->leftJoin('fases', 'fases.id', '=', 'articulations.phase_id')
            ->leftJoin('articulationables', function($q) {
                $q->on('articulationables.articulation_stage_id', '=', 'articulation_stages.id');
                $q->where('articulationables.articulationable_type', '=', 'App\Models\Proyecto');
            })
            ->leftJoin('proyectos', 'proyectos.id', '=', 'articulationables.articulationable_id')
            ->leftJoin('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'proyectos.articulacion_proyecto_id')
            ->leftJoin('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
            ->leftJoin('users as interlocutor', 'interlocutor.id', '=', 'articulation_stages.interlocutor_talent_id')
            ->where('articulations.code',$code)->firstOrFail();

        if (request()->user()->can('downloadCertificateStart', $articulation) && strtoupper($phase) == 'INICIO') {
            $pdf = PDF::loadView('pdf.articulation.articulation-start', compact('articulation'));
            return $pdf->download("Acta " .strtolower($phase) . " " .__("articulation"). " - " .$articulation->code.".pdf");
        }else if(request()->user()->can('downloadCertificateEnd', $articulation) && strtoupper($phase) == 'CIERRE'){
            $pdf = PDF::loadView('pdf.articulation.articulation-end', compact('articulation'));
            return $pdf->stream("Acta " .strtolower($phase) . " " .__("articulation"). " - " .$articulation->code.".pdf");
        }
        alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
        return redirect()->route('home');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $articulationState
     */
    public function destroy($articulation)
    {
        $articulation = Articulation::findOrFail($articulation);
        if (request()->user()->cannot('delete', $articulation)) {
            alert()->warning(__('Sorry, you are not authorized to access the page').' '. request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        if (isset($articulation->users)) {
            $articulation->users()->detach();
        }
        if (isset($articulation->archivomodel)) {
            foreach ($articulation->archivomodel as $archive){
                $filePath = str_replace('storage', 'public', $archive->ruta);
                Storage::delete($filePath);
                $archive->delete();
            }
        }

        if (isset($articulation->notifications)) {
            $articulation->notifications()->delete();
        }
        if (isset($articulation->traceability)) {
            $articulation->traceability()->delete();
        }
        $articulation->delete();
        return response()->json([
            'fail' => false,
            'redirect_url' => route('articulation-stage'),
        ]);
    }
}
