<?php

namespace App\Repositories\Repository\Articulation;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Models\ArticulationStage;
use App\Models\Proyecto;
use App\Models\Fase;
use App\Models\ArchivoModel;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;
use App\Repositories\Repository\UserRepository\DinamizadorRepository;
use Illuminate\Support\Facades\Session;
use App\User;
use App\Models\Movimiento;
use App\Models\ControlNotificaciones;
use App\Notifications\Articulation\EndorsementStageArticulation;
use App\Events\Articulation\AccompanyingApprovalRequest;
use App\Notifications\Articulation\ArticulationStageNoApproveEndorsement;
use Illuminate\Support\Str;


class ArticulationStageRepository
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
     * method that returns the query with all the articulation stages and the articulations
     * @param Request $request
     */

    public function getListArticulacionStagesWithArticulations()
    {
        return ArticulationStage::query()
            ->join('nodos', 'nodos.id', '=', 'articulation_stages.node_id')
            ->join('entidades', 'entidades.id', '=', 'nodos.entidad_id')

            ->leftJoin('articulations', 'articulations.articulation_stage_id', '=', 'articulation_stages.id')
            ->leftJoin('fases', 'fases.id', '=', 'articulations.phase_id')
            ->leftJoin('articulation_subtypes', 'articulation_subtypes.id', '=', 'articulations.articulation_subtype_id')
            ->leftJoin('articulation_types', 'articulation_types.id', '=', 'articulation_subtypes.articulation_type_id')
            ->leftJoin('articulation_scopes', 'articulation_scopes.id', '=', 'articulations.scope_id')
            ->leftJoin('articulation_user', 'articulation_user.articulation_id', '=', 'articulations.id')
            ->leftJoin('users as participants', 'participants.id', '=', 'articulation_user.user_id')
            ->join('articulationables', function($q) {
                $q->on('articulationables.articulation_stage_id', '=', 'articulation_stages.id');
            })
            ->leftJoin('proyectos', 'proyectos.id', '=', 'articulationables.articulationable_id')
            ->leftJoin('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'proyectos.articulacion_proyecto_id')
            ->leftJoin('actividades', 'actividades.id', '=', 'articulacion_proyecto.actividad_id')
            ->leftJoin('users as interlocutor', 'interlocutor.id', '=', 'articulation_stages.interlocutor_talent_id')
            ->leftJoin('users as createdby', 'createdby.id', '=', 'articulation_stages.created_by')
            ->leftJoin('sedes', 'sedes.id', '=', 'articulationables.articulationable_id')
            ->leftJoin('empresas', 'empresas.id', '=', 'sedes.empresa_id')
            ->leftJoin('ideas', 'ideas.id', '=', 'articulationables.articulationable_id');
    }

    /**
     * method for storing the articulation stage
     * @param Request $request
     * @return void
    */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $articulationStage = $this->storeArticulationStage($request);
            $this->validateArticulationStageType($request, $articulationStage);
            $this->storageFile( $request, $articulationStage );
            DB::commit();
            return [
                'state' => true,
                'data' => $articulationStage
            ];
        } catch (\Exception $e) {
            $this->strError = $e->getMessage();
            DB::rollback();
            return [
                'state' => false,
                'data' => null
            ];
        }
    }

    /**
     * method to validate the type of articulation stage
     * @param Request $request
     * @param $articulationStage
     */
    private function validateArticulationStageType(Request $request, $articulationStage)
    {
        if($request->filled('projects')){
            $project = Proyecto::where('id', $request->projects)->first();
            $articulationStage->projects()->sync([
                'articulationable_id' => $project->id
            ]);
        }
    }

    /**
     * method to store the confidentiality format
     * @param Request $request
     * @param $model
     */
    private function storageFile(Request $request, \Illuminate\Database\Eloquent\Model $model = null)
    {
        if($request->hasFile('confidency_format')){
            try {

                $fileName =  $model->code.'_' .$request->file('confidency_format')->getClientOriginalName();
                $node = sprintf('%02d',$model->node->id);
                $year = Carbon::parse($model->start_date)->isoFormat('YYYY');
                $module = class_basename($model);
                $route = "public/{$node}/{$year}/".Str::slug(__('articulation-stage'))."/{$model->code}";
                $fileUrl = $request->file('confidency_format')
                    ->storeAs($route, $fileName);
                $model->archivomodel()->create([
                    'ruta' => Storage::url($fileUrl)
                ]);
                return $model;
            } catch (\Exception $ex) {
                return $ex->getMessage();
            }
        }
    }

    /**
        * store articulations
        * @param Request $request
    */
    public function storeArticulationStage(Request $request){
        return ArticulationStage::create([
            'code' => $this->generateCode('EA'),
            'name' => $request->name,
            'description' => $request->description,
            'scope'  => $request->scope,
            'status' => ArticulationStage::STATUS_CLOSE,
            'start_date' => Carbon::now(),
            'confidentiality_format' => ArticulationStage::CONFIDENCIALITY_FORMAT_YES,
            'terms_verified_at' => Carbon::now(),
            'node_id' => request()->user()->can('listNodes', ArticulationStage::class) ? $request->node : auth()->user()->articulador->nodo->id,
            'interlocutor_talent_id' => $request->talent,
            'created_by' => auth()->user()->id
        ]);
    }
    /**
     * update articulations
     * @param Request $request
     */
    public function update($request, $articulationStage)
    {
        DB::beginTransaction();
        try {
            $articulationStage = $this->updateArticulationStage($request, $articulationStage);
            $this->validateArticulationStageType($request, $articulationStage);
            $this->updateFile( $request , $articulationStage);
            DB::commit();
            return [
                'state' => true,
                'data' => $articulationStage
            ];
        } catch (\Exception $e) {
            $this->strError = $e->getMessage();
            DB::rollback();
            return [
                'state' => false,
                'data' => null
            ];
        }
    }
    /**
        * update articulations state
        * @param Request $request
    */
    public function updateArticulationStage(Request $request, ArticulationStage $articulationStage){
        $articulationStage->update([
            'name' => $request->name,
            'description' => $request->description,
            'scope'  => $request->scope,
            'confidentiality_format' => ArticulationStage::CONFIDENCIALITY_FORMAT_YES,
            'terms_verified_at' => Carbon::now(),
            'interlocutor_talent_id' => $request->talent,
            'node_id' => request()->user()->can('listNodes', ArticulationStage::class) ? $request->node : (isset(auth()->user()->articulador->nodo) ? auth()->user()->articulador->nodo->id : 1),
        ]);
        return $articulationStage;
    }


    private function updateFile(Request $request, $model = null)
    {
        if($model){
            if ($request->hasFile('confidency_format')) {
                try {
                    $fileName =  $model->code.'_' .$request->file('confidency_format')->getClientOriginalName();
                    $node = sprintf('%02d',$model->node->id);
                    $year = Carbon::parse($model->start_date)->isoFormat('YYYY');
                    $module = class_basename($model);
                    $route = "public/{$node}/{$year}/".Str::slug(__('articulation-stage'))."/{$model->code}";
                    $fileUrl = $request->file('confidency_format') ->storeAs($route, $fileName);
                    if(isset($model->archivomodel)){
                        $filePath = str_replace('storage', 'public', $model->archivomodel->ruta);
                        Storage::delete($filePath);
                        $model->archivomodel()->update([
                            'ruta' => Storage::url($fileUrl)
                        ]);
                    }else{
                        $model->archivomodel()->create([
                            'ruta' => Storage::url($fileUrl)
                        ]);
                    }

                    return $model;
                }catch (\Exception $ex) {
                    return $ex->getMessage();
                }
            }
            return $model;
        }

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
            $articulationStage = ArticulationStage::selectRaw('MAX(id+1) AS max')->get()->last();
            $articulationStage->max == null ? $articulationStage->max = 1 : $articulationStage->max = $articulationStage->max;
            $articulationStage->max = sprintf("%04d", $articulationStage->max);
            return "{$initial}{$year}-{$node}{$month}{$user}-{$articulationStage->max}";
    }

    /**
     * Método que elimina un archivo del servidor y su registro de la base de datos (RutaModel)
    * @param int
    * @return Response
    */
    public function destroyFile($file)
    {
        try {
            $file = ArchivoModel::find($file);
            $file->delete();
            $filePath = str_replace('storage', 'public', $file->ruta);
            Storage::delete($filePath);
            return true;
        }catch (\Exception $ex) {
            return false;
        }
    }


    /**
     * Update file
     * @return \Illuminate\Http\Response
     */
    public function downloadFile($articulationStage)
    {
        try {
            $path = $this->existFile($articulationStage->archivomodel->ruta);
            return Storage::response($path);
        } catch (\Exception $e) {
            return abort(404, $e->getMessage());
        }
    }

    private function existFile($path){
        if(!isset($path)){
            throw new \Exception('El archivo no existe');
        }
        return  $path = str_replace('storage', 'public', $path);
    }

    /**
     * Update los miembros de una etapa.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function updateInterlocutor(Request $request, $articulationStage)
    {
        try {
            $articulationStage->update([
                'interlocutor_talent_id' => $request->talent,
            ]);
            $articulationStage->createTraceability(Movimiento::IsCambiarInterlocutor(),Session::get('login_role'), Movimiento::IsCambiarInterlocutor());
            return  [
                'data' => $articulationStage,
                'message' => '',
                'isCompleted' => true,
            ];
        } catch (\Exception $ex) {
            return  [
                'data' => "",
                'message' => $ex->getMessage(),
                'isCompleted' => false,
            ];
        }
    }

    /**
     * Notifica al dinamizador para que apruebe el proyecto en la fase de inicio
     *
     * @param Model $model Model
     * @return array
     * @author dum
     */
    public function notifyPhaseApproval(\Illuminate\Database\Eloquent\Model $model)
    {
        DB::beginTransaction();
        try {
            $notificacion_fase_actual = $model->notifications()->whereNull('fecha_aceptacion')->get()->last();
            // $msg = 'No se ha podido enviar la solicitud de aprobación, inténtalo nuevamente';
            $conf_envios = false;
            if ($model->status == ArticulationStage::STATUS_CLOSE) {
                $conf_envios = $this->configurationNotificationDynamizer($model);
                $msg = 'Se le ha enviado una notificación al dinamizador para que apruebe el cierre!';
                $notificacion = $model->registerNotify($conf_envios['receptor'], $conf_envios['receptor_role'], null, 'cerrar' );
            } else {
                if ($notificacion_fase_actual == null) {
                    $conf_envios = $this->configurationNotificationTalent($model);
                    $msg = "Se le ha enviado una notificación al talento interlocutor para que apruebe la ". __('articulation-stage');
                } else {
                    if ($notificacion_fase_actual->rol_receptor->name == User::IsTalento()) {
                        $conf_envios = $this->configurationNotificationTalent($model);
                        $msg = 'Se le ha enviado una notificación al talento interlocutor para que apruebe la '. __('articulation-stage');
                    } else {
                        $conf_envios = $this->configurationNotificationDynamizer($model);
                        $msg = "Se le ha enviado una notificación al dinamizador para que apruebe la" . __('articulation-stage');
                    }
                }
                // Registra el control de la notificación
                $notificacion = $model->registerNotify($conf_envios['receptor'], $conf_envios['receptor_role'], null, 'cerrar');
            }

            if ($conf_envios != false) {
                $msg = "Enviar notificacion " . __('articulation-stage');
                event(new AccompanyingApprovalRequest($notificacion, $conf_envios['destinatarios']));
                $model->createTraceability($conf_envios['tipo_movimiento'],$conf_envios['tipo_movimiento'], null);
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

    public function configurationNotificationDynamizer($model)
    {
        $dinamizadorRepository = new DinamizadorRepository;
        if (Session::get('login_role') != User::IsTalento())
            $recipients[] = auth()->user()->email;
            $dinamizador = $dinamizadorRepository->getAllDinamizadoresPorNodo($model->node_id)->get()->last();
            $recipients[] = $dinamizador->email;
        return [
            'receptor' => $dinamizador->id,
            'receptor_role' => User::IsDinamizador(),
            'tipo_movimiento' => Movimiento::IsSolicitarDinamizador(),
            'destinatarios' => $recipients
        ];
    }

    /**
     * Genera la información el talento al que se le enviarán las notificaciones de solicitud de aprobación de fase
     *
     * @param Proyecto $model
     * @return array
     * @author dum
     */
    public function configurationNotificationTalent($model)
    {
        $interlocutor = $model->interlocutor;
        $recipients[] = $interlocutor->email;
        if (Session::get('login_role') != User::IsTalento())
            $recipients[] = auth()->user()->email;

        return [
            'receptor' => $interlocutor->id,
            'receptor_role' => User::IsTalento(),
            'tipo_movimiento' => Movimiento::IsSolicitarTalento(),
            'destinatarios' => $recipients
        ];
    }

    /**
     * Retonar la última notificacion pendiente
     *
     * @param $articulationState
     **/
    public function retornarUltimaNotificacionPendiente($articulationState)
    {
        if($articulationState->endorsement == ArticulationStage::ENDORSEMENT_YES){
            $status = "cerrar";
        }else{
            $status = "abrir";
        }
        if($articulationState->status == ArticulationStage::STATUS_OPEN){
            return $articulationState->notifications()->where('estado', \App\Models\ControlNotificaciones::IsPendiente())->get()->last();
        }else{
            return $articulationState->notifications()->whereNull('fecha_aceptacion')->get()->last();
        }
    }

    public function verifyRecipientNotification($notificacion)
    {
        $rol = null;
        if ($notificacion == null) {
            $rol = User::IsTalento();
        } else {
            if ($notificacion->rol_receptor->name == User::IsTalento()) {
                $rol = User::IsTalento();
            } else {
                $rol = User::IsDinamizador();
            }
        }
        return $rol;
    }

    public function verifyRemitenteNotification($notificacion)
    {
        $rol = null;
        if ($notificacion == null) {
            $rol = User::IsTalento();
        } else {
            if ($notificacion->rol_remitente->name == User::IsTalento()) {
                $rol = User::IsTalento();
            } else {
                $rol = User::IsDinamizador();
            }
        }
        return $rol;
    }

    /**
     * @param ArticulationStage $articulationStage
     * @return array
     */
    public function notifyApprovalEndorsement(ArticulationStage $articulationStage, string $fase = null)
    {
        DB::beginTransaction();
        try {
            $movimiento = null;
            $comentario = "";
            $notificacion_fase_actual = $this->retornarUltimaNotificacionPendiente($articulationStage);
            $ult_traceability = ArticulationStage::getTraceability($articulationStage)->get()->last();
            $msg = 'No se ha podido enviar la solicitud de aval, inténtalo nuevamente';
            $conf_envios = false;
            if ($notificacion_fase_actual == null) {
                $conf_envios = $this->settingsNotificationTalent($articulationStage);
                $movimiento = Movimiento::IsSolicitarTalento();
                $msg = 'Se le ha enviado una notificación al talento interlocutor para que avale el ' . $articulationStage->present()->articulationStageEndorsementApproval();
            }
            else {
                if ($notificacion_fase_actual->rol_receptor->name == User::IsTalento()) {
                    $conf_envios = $this->settingsNotificationTalent($articulationStage);
                    $movimiento = Movimiento::IsSolicitarTalento();
                    $msg = 'Se le ha enviado una notificación al talento interlocutor para que avale el ' . $articulationStage->present()->articulationStageEndorsementApproval();
                }
                else {
                    if(isset($ult_traceability) && $ult_traceability->movimiento == Movimiento::IsAprobar() && $ult_traceability->rol == \App\User::IsDinamizador()){
                        $conf_envios = $this->settingsNotificationTalent($articulationStage);
                        $movimiento = Movimiento::IsSolicitarTalento();
                        $msg = 'Se le ha enviado una notificación al talento interlocutor para que avale el ' . $articulationStage->present()->articulationStageEndorsementApproval();
                    }else{
                        $conf_envios = $this->settingsNotificationDynamizer($articulationStage);
                        $movimiento = Movimiento::IsSolicitarDinamizador();
                        $msg = 'Se le ha enviado una notificación al dinamizador para que avale ' . $articulationStage->present()->articulationStageEndorsementApproval();
                    }

                }
            }
            $notificacion = $articulationStage->registerNotify($conf_envios['receptor'], $conf_envios['receptor_role'], null, $fase);
            if ($conf_envios != false) {
                Notification::send($notificacion->receptor, new EndorsementStageArticulation($articulationStage, $notificacion));
                $articulationStage->createTraceability($movimiento,Session::get('login_role'), $movimiento,$fase);
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

    /**
     * Genera la información el talento al que se le enviarán las notificaciones de solicitud de aprobación de fase
     *
     * @param ArticulationStage $articulationStage
     * @return array
     */
    private function settingsNotificationTalent($articulationStage)
    {

        $destinatarios[] = $articulationStage->interlocutor->email;
        if (Session::get('login_role') != User::IsTalento())
            $destinatarios[] = auth()->user()->email;

        return [
            'receptor' => $articulationStage->interlocutor->id,
            'receptor_role' => User::IsTalento(),
            'tipo_movimiento' => Movimiento::IsSolicitarTalento(),
            'destinatarios' => $destinatarios
        ];
    }

    public function settingsNotificationDynamizer($articulationStage)
    {
        $dinamizadorRepository = new DinamizadorRepository;
        if (Session::get('login_role') != User::IsTalento())
            $destinatarios[] = auth()->user()->email;
            $dinamizador = $dinamizadorRepository->getAllDinamizadoresPorNodo($articulationStage->node_id)->get()->last();
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
    public function manageEndorsement($request, $articulationStage, string $phase)
    {
        DB::beginTransaction();
        try {
            $comentario = null;
            $movimiento = null;
            $mensaje = null;
            $title = null;
            $dinamizadorRepository = new DinamizadorRepository;
            $dinamizadores = $dinamizadorRepository->getAllDinamizadoresPorNodo($articulationStage->node_id)->get();
            $asesores = User::InfoUserDatatable()
                ->Join('user_nodo', 'user_nodo.user_id', '=', 'users.id')
                ->role(User::IsArticulador())
                ->where('users.deleted_at' ,'!=', null)
                ->where('user_nodo.nodo_id', '=', $articulationStage->node_id)->get();
            $talento_lider = $articulationStage->interlocutor;
            $notificacion_act = ControlNotificaciones::find($request->control_notificacion_id);
            if($articulationStage->status == ArticulationStage::STATUS_OPEN){
                $phase = 'cerrar';
            }else{
                $phase = 'abrir';
            }
            if ($request->decision == 'rechazado') {
                $title = 'Aprobación rechazada!';
                $mensaje = 'Se le han notificado al asesor los motivos por los cuales no se aprueba el aval de la etapa de articulación';
                $comentario = $request->motivosNoAprueba;
                $movimiento = Movimiento::IsNoAprobar();

                $articulationStage->createTraceability($movimiento,Session::get('login_role'),$comentario, $phase);

                $regMovimiento = $articulationStage->traceability()->get()->last();

                Notification::send($asesores, new ArticulationStageNoApproveEndorsement($articulationStage, $regMovimiento));
                $notificacion_act->update(['estado' => $notificacion_act->IsRechazado()]);

            } else {
                $title = 'Aprobación Exitosa!';
                $mensaje = 'Se ha aprobado el aval de esta etapa de articulación';
                $movimiento = Movimiento::IsAprobar();
                $regMovimiento = $articulationStage->traceability()->get()->last();
                $notificacion_act->update(['fecha_aceptacion' => Carbon::now(), 'estado' => $notificacion_act->IsAceptado()]);
                $articulationStage->createTraceability($movimiento,Session::get('login_role'), $comentario, $phase);
                if (Session::get('login_role') == User::IsTalento()) {
                    $notificacion = $articulationStage->registerNotify($dinamizadores->last()->id, User::IsDinamizador(), null, $phase);
                    Notification::send($dinamizadores, new EndorsementStageArticulation($articulationStage, $notificacion));
                } else {
                    if ($articulationStage->endorsement == ArticulationStage::ENDORSEMENT_NO) {
                        $articulationStage->update([
                            'endorsement' => ArticulationStage::ENDORSEMENT_YES,
                            'status' => ArticulationStage::STATUS_OPEN
                        ]);
                    }
                    else if ($articulationStage->endorsement == ArticulationStage::ENDORSEMENT_YES) {
                        $articulationStage->update([
                            'endorsement' => ArticulationStage::ENDORSEMENT_NO,
                            'status' => ArticulationStage::STATUS_CLOSE
                        ]);
                    }
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
                'mensaje' => $th->getMessage(),
                'title' => 'Aprobación errónea'
            ];
        }
    }

    public function updateStatus($articulationStage)
    {
        DB::beginTransaction();
        try {
            $articulationStage->update([
                'status' => ($articulationStage->status == 0) ? 1 : 0,
                'endorsement' => ($articulationStage->endorsement == 0) ? 1 : 0,
            ]);
            DB::commit();
            return [
                'state' => true,
                'data' => $articulationStage
            ];
        } catch (\Exception $e) {
            $this->strError = $e->getMessage();
            DB::rollback();
            return [
                'state' => false,
                'data' => null
            ];
        }
    }
}
