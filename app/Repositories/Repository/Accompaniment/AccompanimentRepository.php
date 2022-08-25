<?php

namespace App\Repositories\Repository\Accompaniment;

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
use App\Models\Role;
use App\Notifications\Articulation\AccompanyingApprovalNotification;
use App\Events\Articulation\AccompanyingApprovalRequest;


class AccompanimentRepository
{

    /**
        * store
        * @param Request $request
        * @return void
    */
    public function store(Request $request)
    {
        try {
            $accompaniment = $this->storeAccompaniment($request);
            $this->validateAccompanimentType($request, $accompaniment);
            $this->storageFile( $request, $accompaniment );
            return  [
                'data' => $accompaniment,
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

    public function update(Request $request, ArticulationStage $accompaniment)
    {
        try {
            $accompaniment = $this->updateAccompaniment($request, $accompaniment);
            $this->validateAccompanimentType($request, $accompaniment);
            $this->updateFile( $request , $accompaniment );
            return  [
                'data' => $accompaniment,
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
        * store articulations
        * @param Request $request
    */
    public function storeAccompaniment(Request $request){
        $accompaniment = ArticulationStage::create([
            'accompaniment_type' => Proyecto::class,
            'code' => $this->generateCode('EA'),
            'name' => $request->name,
            'description' => $request->description,
            'scope'  => $request->scope,
            'status' => ArticulationStage::STATUS_OPEN,
            'start_date' => Carbon::now(),
            'confidentiality_format' => ArticulationStage::CONFIDENCIALITY_FORMAT_YES,
            'terms_verified_at' => Carbon::now(),
            'node_id' => auth()->user()->articulador->nodo->id,
            'interlocutor_talent_id' => $request->talent,
            'created_by' => auth()->user()->id
        ]);

        return $accompaniment;
    }

    /**
        * store articulations
        * @param Request $request
    */
    public function updateAccompaniment(Request $request, ArticulationStage $accompaniment){
        $accompaniment->update([
            'name' => $request->name,
            'description' => $request->description,
            'scope'  => $request->scope,
            'confidentiality_format' => ArticulationStage::CONFIDENCIALITY_FORMAT_YES,
            'terms_verified_at' => Carbon::now(),
            'interlocutor_talent_id' => $request->talent,
        ]);
        return $accompaniment;
    }

    /**
        * store articulations
        * @param Request $request
    */
    public function validateAccompanimentType(Request $request, ArticulationStage $accompaniment)
    {
        if($request->filled('projects')){
            $model = Proyecto::where('id', $request->projects)->first();
            $model->accompaniamentables()->sync([$accompaniment->id]);
        }
    }

    private function storageFile(Request $request, \Illuminate\Database\Eloquent\Model $model = null)
    {
        if($request->hasFile('confidency_format')){
            try {
                $fileName =  $model->code.'_' .$request->file('confidency_format')->getClientOriginalName();
                $node = sprintf('%02d',$model->node->id);
                $year = Carbon::parse($model->start_date)->isoFormat('YYYY');
                $module = class_basename($model);
                $route = "public/{$node}/{$year}/{$module}/{$model->createdBy->documento}/{$model->code}/formato";
                $fileUrl = $request->file('confidency_format')
                            ->storeAs($route, $fileName);
                $model->file()->create([
                    'ruta' => Storage::url($fileUrl),
                    'fase_id' => Fase::IS_INICIO
                ]);
                return $model;
            } catch (\Exception $ex) {
                return $ex->getMessage();
            }
        }
    }

    private function updateFile(Request $request, \Illuminate\Database\Eloquent\Model $model = null)
    {
        if($model){
            if ($request->hasFile('confidency_format')) {
                try {
                    $fileName =  $model->code.'_' .$request->file('confidency_format')->getClientOriginalName();
                    $node = sprintf('%02d',$model->node->id);
                    $year = Carbon::parse($model->start_date)->isoFormat('YYYY');
                    $module = class_basename($model);
                    $route = "public/{$node}/{$year}/{$module}/{$model->createdBy->documento}/{$model->code}/formato";
                    $fileUrl = $request->file('confidency_format') ->storeAs($route, $fileName);
                    if(isset($model->file)){
                        $filePath = str_replace('storage', 'public', $model->file->ruta);
                        Storage::delete($filePath);
                        $model->file()->update([
                            'ruta' => Storage::url($fileUrl)
                        ]);
                    }else{
                        $model->file()->create([
                            'ruta' => Storage::url($fileUrl),
                            'fase_id' => Fase::IS_INICIO
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
            $accompaniment = ArticulationStage::selectRaw('MAX(id+1) AS max')->get()->last();
            $accompaniment->max == null ? $accompaniment->max = 1 : $accompaniment->max = $accompaniment->max;
            $accompaniment->max = sprintf("%04d", $accompaniment->max);
            return "{$initial}{$year}-{$node}{$month}{$user}-{$accompaniment->max}";
    }

    /**
     * Método que elimina un archivo del servidor y su registro de la base de datos (RutaModel)
    * @param int id Id del archivo del entrenamiento que se usará para eliminarlo del almacenamiento y de la base de datos
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
    public function downloadFile(\App\Models\ArticulationStage $accompaniment)
    {
        try {
            $path = $this->existFile($accompaniment->file->ruta);
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

    public function updateInterlocutor(Request $request, ArticulationStage $accompaniment)
    {

        try {
            $accompaniment->update([
                'interlocutor_talent_id' => $request->talent,
            ]);
            return  [
                'data' => $accompaniment,
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
                $notificacion = $model->registerNotify($conf_envios['receptor'], $conf_envios['receptor_role'], null);
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
                $notificacion = $model->registerNotify($conf_envios['receptor'], $conf_envios['receptor_role']);
            }

            if ($conf_envios != false) {
                $msg = "Enviar notificacion " . __('articulation-stage');

                Notification::send($notificacion->receptor, new AccompanyingApprovalNotification($notificacion));
                // Enviar email
                event(new AccompanyingApprovalRequest($notificacion, $conf_envios['destinatarios']));
                // Registrar el historial
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

}
