<?php

namespace App\Repositories\Repository\Articulation;

use App\Models\ControlNotificaciones;
use App\Models\Movimiento;
use App\Notifications\Articulation\ArticulationStageNoApproveEndorsement;
use App\Notifications\Articulation\EndorsementStageArticulation;
use App\Notifications\Articulation\RequestFinalizeArticulation;
use App\Repositories\Repository\UserRepository\DinamizadorRepository;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\ArticulationStage;
use App\User;
use App\Models\Articulation;
use App\Models\Fase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;


class ArticulationRepository
{
    /**
     * variable to store errors
     * @var $strError
     */
    private $strError = null;

    /**
     * method to store errors
     * @return string
     */
    public function getError()
    {
        return $this->strError;
    }

    /**
     * store
     * @param Request $request
     * @return void
     */
    public function store(Request $request, ArticulationStage $accompaniment)
    {
        try {
            $accompaniment = $this->storeArticulation($request, $accompaniment);
            return [
                'data' => $accompaniment,
                'message' => '',
                'isCompleted' => true,
            ];
        } catch (\Exception $ex) {
            return [
                'data' => "",
                'message' => $ex->getMessage(),
                'isCompleted' => false,
            ];
        }
    }

    /**
     * store articulation
     * @param Request $request
     */
    public function storeArticulation(Request $request, ArticulationStage $accompaniment)
    {
        $articulation = $accompaniment->articulations()->create([
            'code' => $this->generateCode('A'),
            'name' => $request->name_articulation,
            'description' => $request->description_articulation,
            'start_date' => $request->start_date,
            'expected_end_date' => $request->expected_date,
            'entity' => $request->name_entity,
            'contact_name' => $request->name_contact,
            'email_entity' => $request->email,
            'summon_name' => $request->call_name,
            'objective' => $request->objective,
            'phase_id' => Fase::where('nombre', Articulation::START_PHASE)->first()->id,
            'articulation_subtype_id' => $request->articulation_subtype,
            'scope_id' => $request->scope_articulation,
            'created_by' => auth()->user()->id,
        ]);
        if ($request->filled('talents')) {
            $articulation->users()->sync($request->talents);
        }
        return $articulation;
    }


    /**
     * Genera un código para el acompañamiento
     * @param string $initial
     * @return string
     * @author devjul
     */
    private function generateCode($initial = null)
    {
        $year = Carbon::now()->isoFormat('YYYY');
        $node = sprintf("%02d", auth()->user()->articulador->id);
        $month = Carbon::now()->isoFormat('MM');
        $user = sprintf("%03d", auth()->user()->id);
        $model = Articulation::selectRaw('MAX(id+1) AS max')->get()->last();
        $model->max == null ? $model->max = 1 : $model->max = $model->max;
        $model->max = sprintf("%04d", $model->max);
        return "{$initial}{$year}-{$node}{$month}{$user}-{$model->max}";
    }

    /**
     * update start
     * @param Request $request
     * @return array
     */
    public function update(Request $request, Articulation $articulation)
    {
        try {
            $articulation->update([
                'name' => $request->name_articulation,
                'description' => $request->description_articulation,
                'start_date' => $request->start_date,
                'expected_end_date' => $request->expected_date,
                'entity' => $request->name_entity,
                'contact_name' => $request->name_contact,
                'email_entity' => $request->email,
                'summon_name' => $request->call_name,
                'objective' => $request->objective,
                'articulation_subtype_id' => $request->articulation_subtype,
                'scope_id' => $request->scope_articulation
            ]);
            if ($request->filled('talents')) {
                $articulation->users()->sync($request->talents);
            }
            return [
                'data' => $articulation,
                'message' => '',
                'isCompleted' => true,
            ];
        } catch (\Exception $ex) {
            return [
                'data' => "",
                'message' => $ex->getMessage(),
                'isCompleted' => false,
            ];
        }
    }

    /**
     * update closing
     * @param Request $request
     * @return array
     */
    public function updateClosing(Request $request, $articulation)
    {
        //try {
        $postulation = 0;
        $approval = 0;
        $justified_report = 0;
        $approval_document = 0;
        $postulation_document = 0;
        $non_approval_document = 0;

        if (isset($request->postulation) && $request->postulation == "yes") {
            $postulation = 1;
        }
        if (isset($request->approval) && $request->approval == "aprobado") {
            $approval = 1;
        }
        if (isset($request->justified_report)) {
            $justified_report = 1;
        }
        if (isset($request->approval_document)) {
            $approval_document = 1;
        }
        if (isset($request->postulation_document)) {
            $postulation_document = 1;
        }
        if (isset($request->non_approval_document)) {
            $non_approval_document = 1;
        }

        $articulation->update([
            'postulation' => $postulation,
            'approval' => $approval,
            'justification' => $request->justification,
            'justified_report' => $justified_report,
            'report' => $request->report,
            'receive' => $request->receive,
            'received_date' => $request->received_date,
            'approval_document' => $approval_document,
            'postulation_document' => $postulation_document,
            'non_approval_document' => $non_approval_document,
            'learned_lessons' => $request->learned_lessons,
        ]);
        return [
            'data' => $articulation,
            'message' => '',
            'isCompleted' => true,
        ];
        /*} catch (\Exception $ex) {
            return  [
                'data' => "",
                'message' => $ex->getMessage(),
                'isCompleted' => false,
            ];
        }*/
    }

    /**
     * Modifica los entregables de una articulacion en la fase de ejecución
     *
     * @param Request $request
     * @param int $id id de la articulacion
     * @return array
     * @author devjul
     */
    public function updateEntregablesEjecucionRepository($request, $articulation)
    {
        DB::beginTransaction();
        try {
            $tracing = 0;
            $announcement_document = 0;
            if (isset($request->tracing)) {
                $tracing = 1;
            }
            if (isset($request->announcement_document)) {
                $announcement_document = 1;
            }

            $articulation->update([
                'announcement_document' => $announcement_document,
                'tracing' => $tracing,
            ]);
            DB::commit();
            return $articulation;
        } catch (\Throwable $th) {
            DB::rollback();
            return null;
        }
    }

    /**
     * update talents participants
     * @param Request $request
     * @return array
     */
    public function updateTalentsParticipants(Request $request, Articulation $articulation)
    {
        try {
            if ($request->filled('talents')) {
                $articulation->users()->sync($request->talents);
            }
            return [
                'data' => $articulation,
                'message' => '',
                'isCompleted' => true,
            ];
        } catch (\Exception $ex) {
            return [
                'data' => "",
                'message' => $ex->getMessage(),
                'isCompleted' => false,
            ];
        }
    }

    /**
     * Retonar la última notificacion pendiente
     *
     * @param $articulation
     **/
    public function retornarUltimaNotificacionPendiente($articulation)
    {
        return $articulation->notifications()->where('fase_id', $articulation->phase_id)->whereNull('fecha_aceptacion')->get()->last();
    }

    public function verifyRecipientNotification($notificacion)
    {
        $rol = null;
        if ($notificacion == null) {
            $rol = User::IsDinamizador();
        } else {
            if ($notificacion->rol_receptor->name == User::IsDinamizador()) {
                $rol = User::IsDinamizador();
            } else {
                $rol = User::IsDinamizador();
            }
        }
        return $rol;
    }

    /**
     * @param Articulation $articulation
     * @return array
     */
    public function notifyApprovalPhase(Articulation $articulation)
    {
        DB::beginTransaction();
        try {
            $movimiento = null;
            $comentario = "";
            $phase = $articulation->phase_id;
            $notificacion_fase_actual = $this->retornarUltimaNotificacionPendiente($articulation);
            $ult_traceability = Articulation::getTraceability($articulation)->get()->last();
            $msg = 'No se ha podido enviar la solicitud de aval, inténtalo nuevamente';
            $conf_envios = false;
            if ($notificacion_fase_actual == null) {
                $conf_envios = $this->settingsNotificationDynamizer($articulation);
                $movimiento = Movimiento::IsSolicitarDinamizador();
                $msg = 'Se le ha enviado una notificación al dinamizador para que avale la finalización de la articulación';
            } else {
                $conf_envios = $this->settingsNotificationDynamizer($articulation);
                $movimiento = Movimiento::IsSolicitarDinamizador();
                $msg = 'Se le ha enviado una notificación al dinamizador para que avale la finalización de la articulación';
            }

            $notificacion = $articulation->registerNotify($conf_envios['receptor'], $conf_envios['receptor_role'], $phase, $msg);
            if ($conf_envios != false) {
                Notification::send($notificacion->receptor, new RequestFinalizeArticulation($articulation, $notificacion));
                $articulation->createTraceability($movimiento, Session::get('login_role'), $movimiento, 'finalizar');
            }
            DB::commit();
            return [
                'notificacion' => true,
                'msg' => $msg,
                'notify' => $notificacion
            ];
        } catch (\Throwable $th) {
            DB::rollBack();
            return [
                'notificacion' => false,
                'msg' => 'Ha ocurrido un error ' . $th->getMessage()
            ];
        }
    }

    public function settingsNotificationDynamizer($articulation)
    {
        $dinamizadorRepository = new DinamizadorRepository;
        if (Session::get('login_role') != User::IsTalento())
            $destinatarios[] = auth()->user()->email;
        $dinamizador = $dinamizadorRepository->getAllDinamizadoresPorNodo($articulation->articulationstage->node_id)->get()->last();
        $destinatarios[] = $dinamizador->email;
        return [
            'receptor' => $dinamizador->id,
            'receptor_role' => User::IsDinamizador(),
            'tipo_movimiento' => Movimiento::IsSolicitarDinamizador(),
            'destinatarios' => $destinatarios
        ];
    }

    /**
     * Aprueba la fase según el rol y fase que se está aprobando
     *
     * @param $request
     * @param $id Id
     */
    public function manageEndorsement($request, $articulation, string $phase)
    {
        DB::beginTransaction();
        try {
            $comentario = null;
            $movimiento = null;
            $mensaje = null;
            $title = null;
            /*$asesores = User::InfoUserDatatable()
                ->Join('user_nodo', 'user_nodo.user_id', '=', 'users.id')
                ->role(User::IsArticulador())
                ->where('users.deleted_at' ,'!=', null)
                ->where('user_nodo.nodo_id', '=', $articulation->articulationstage->node_id)->get();*/
            $notificacion_act = ControlNotificaciones::find($request->control_notificacion_id);

            if ($request->decision == 'rechazado') {
                $title = 'Aprobación rechazada!';
                $mensaje = 'Se le han notificado al asesor los motivos por los cuales no se aprueba el aval de la articulación';
                $comentario = $request->motivosNoAprueba;
                $movimiento = Movimiento::IsNoAprobar();

                $articulation->createTraceability($movimiento,Session::get('login_role'),$comentario, $phase);

                //$regMovimiento = $articulation->traceability()->get()->last();

                //Notification::send($asesores, new ArticulationStageNoApproveEndorsement($articulation, $regMovimiento));
                $notificacion_act->update(['estado' => $notificacion_act->IsRechazado()]);

            } else {
                $title = 'Aprobación Exitosa!';
                $mensaje = 'Se ha aprobado el aval de esta etapa de articulación';
                $movimiento = Movimiento::IsAprobar();
                $notificacion_act->update(['fecha_aceptacion' => Carbon::now(), 'estado' => $notificacion_act->IsAceptado()]);
                $articulation->createTraceability($movimiento,Session::get('login_role'), $comentario, $phase);

                if ($articulation->phase_id == Fase::IsCierre()) {
                    $articulation->update([
                        'phase_id' => Fase::IsFinalizado(),
                        'end_date' => Carbon::now()
                    ]);
                }
            }
            DB::commit();
            return [
                'state' => true,
                'mensaje' => $mensaje,
                'title' => $title
            ];
        } catch (\Throwable $th) {
            DB::rollBack();
            return [
                'state' => false,
                'mensaje' => 'No se ha aprobado la finalización de la articulación',
                'title' => 'Aprobación errónea'
            ];
        }
    }
}
