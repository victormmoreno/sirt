<?php

namespace App\Repositories\Repository;

use Carbon\Carbon;
use App\Models\ArticulacionPbt;
use App\Models\Fase;
use App\User;
use App\Models\Movimiento;
use Illuminate\Support\Facades\{DB, Notification, Storage, Session};
use App\Notifications\ArticulacionPbt\{ArticulacionAprobarInicio, ArticulacionNoAprobarFase, ArticulacionAprobarInicioDinamizador, ArticulacionAprobarSuspendido, ArticulacionSuspendidaAprobada};
use App\Repositories\Repository\UserRepository\DinamizadorRepository;


class ArticulacionPbtRepository
{
    /**
     * registro de articulacion
     * @param Request
     * @return boolean
     * @author devjul
     */
    public function store($request)
    {
        DB::beginTransaction();
        try {
            $codigo_actividad = $this->generateCodeArticulacion();

            $articulacion = ArticulacionPbt::create([
                'asesor_id' => auth()->user()->id,
                'nodo_id' =>  $this->nodeArticulacion(),
                'codigo' => $codigo_actividad,
                'nombre' => request()->txtnombre_articulacion,
                'fecha_inicio' => request()->txtfecha_inicio,
                'tipo_vinculacion' =>request()->txttipovinculacion,
                'articulable_id' => $this->articulableId($request),
                'articulable_type' => $this->articulableModel($request),
                'fase_id' => Fase::IsInicio(),
                'tipo_articulacion_id' => request()->txt_tipo_articulacion,
                'alcance_articulacion_id' => request()->txt_alcance_articulacion,
                'entidad'=> request()->txtname_entidad,
                'nombre_contacto'=> request()->txtname_contact,
                'email_entidad'=> request()->txtemail,
                'nombre_convocatoria'=> request()->txtnombre_convocatoria,
                'fecha_esperada_finalizacion' => request()->txtfecha_esperada,
                'objetivo'=> request()->txtobjetivo,
            ]);

            $syncData = [];
            $syncData = $this->syncTalent($request);
            $articulacion->talentos()->sync($syncData, false);
            User::enableTalentsArticulacion($articulacion);
            DB::commit();
            return $articulacion;
        } catch (\Exception $e) {
            DB::rollback();
            return null;
        }
    }

    private function articulableId($request){
        if($request->txtpbt != null){
            return $request->txtpbt;
        }
        if($request->txtsede != null){
            return $request->txtsede;
        }
        return null;
    }

    private function articulableModel($request){
        if($request->txtpbt != null){
            return \App\Models\Proyecto::class;
        }
        if($request->txtsede != null){
            return \App\Models\Sede::class;
        }
        return null;
    }

    /**
     * Genera un código para la articulacion
     * @return string
     * @author devjul
     */
    private function generateCodeArticulacion()
    {
            $anho = Carbon::now()->isoFormat('YYYY');
            $tecnoparque = sprintf("%02d", $this->nodeArticulacion());
            $mes = Carbon::now()->isoFormat('MM');
            $articulador = sprintf("%03d", auth()->user()->articulador->id);
            $idArticulacion = ArticulacionPbt::selectRaw('MAX(id+1) AS max')->get()->last();
            $idArticulacion->max == null ? $idArticulacion->max = 1 : $idArticulacion->max = $idArticulacion->max;
            $idArticulacion->max = sprintf("%04d", $idArticulacion->max);
            return 'A' . $anho . '-' . $tecnoparque . $mes . $articulador . '-' . $idArticulacion->max;
    }

    /**
     * Método que retorna los el nodo del articulador
     * @return int
     * @author devjul
     */
    private function nodeArticulacion(){
        if(isset(auth()->user()->articulador)){
            return auth()->user()->articulador->nodo_id;
        }
        return;
    }

    /**
     * Método que retorna los talentos en un array, para usarlo junto a la funcion sync de laravel
     * @param \Illuminate\Http\Request  $request
     * @return array
     * @author devjul
     */
    private function syncTalent($request)
    {
        $syncData = array();
        foreach ($request->get('talentos') as $id => $value) {
        if ($value == request()->get('txttalento_interlocutor')) {
            $syncData[$id] = array('talento_lider' => 1, 'talento_id' => $value);
        } else {
            $syncData[$id] = array('talento_lider' => 0, 'talento_id' => $value);
        }
        }
        return $syncData;
    }

    /**
     * Modifica los valores iniciales de una articulacion
     *
     * @param Request request Request con los datos del formulario
     * @param int id - id de la articulacion
     * @return array
     * @author devjul
     */
    public function updateInicio($request, $id)
    {
        DB::beginTransaction();
        try {
            $articulacion = ArticulacionPbt::find($id);

            $articulacion->update([
                'asesor_id' => auth()->user()->id,
                'nodo_id' =>  $this->nodeArticulacion(),
                'nombre' => request()->txtnombre_articulacion,
                'fecha_inicio' => request()->txtfecha_inicio,
                'tipo_vinculacion' =>request()->txttipovinculacion,
                'articulable_id' => $this->articulableId($request),
                'articulable_type' => $this->articulableModel($request),
                'fase_id' => Fase::IsInicio(),
                'tipo_articulacion_id' => request()->txt_tipo_articulacion,
                'alcance_articulacion_id' => request()->txt_alcance_articulacion,
                'entidad'=> request()->txtname_entidad,
                'nombre_contacto'=> request()->txtname_contact,
                'email_entidad'=> request()->txtemail,
                'nombre_convocatoria'=> request()->txtnombre_convocatoria,
                'fecha_esperada_finalizacion' => request()->txtfecha_esperada,
                'objetivo'=> request()->txtobjetivo,
            ]);

            $syncData = [];
            $syncData = $this->syncTalent($request);
            $articulacion->talentos()->sync($syncData);

            User::enableTalentsArticulacion($articulacion);

            DB::commit();
            return $articulacion;
        } catch (\Exception $e) {
            DB::rollback();
            return null;
        }
    }

    /**
   * modifica los entregables de la fase de inicio de una articulación
   * @param Request $request
   * @param int $id id de la articulacion
   * @return array
   * @author devjul
   */
    public function updateEntregablesInicioArticulacon($request, $id)
    {
        DB::beginTransaction();
        try {
            $form_inicio = 0;

            if (isset($request->txtformulario_inicio)) {
                $form_inicio = 1;
            }

            $articulacion = ArticulacionPbt::find($id);

            $articulacion->update([
                'formulario_inicio' => $form_inicio
            ]);
            DB::commit();
            return $articulacion;
        } catch (\Exception $e) {
            DB::rollback();
            return null;
        }
    }

    /**
     * emite una notificación via campana y email al talento para que apruebe la fase de inicio de una artuculación
     *
    * @param int $id Id de la articulacion
    * @return boolean
    * @author devjul
    */
    public function notificarAlTalento(int $id, string $fase)
    {
        DB::beginTransaction();
        try {
            $articulacion = ArticulacionPbt::findOrFail($id);
            $talentLider = $articulacion->talentos()->wherePivot('talento_lider', 1)->first();
            $user = $talentLider->user;
            $articulacion->registerHistoryArticulacion(Movimiento::IsSolicitarTalento(),Session::get('login_role'), null, "{$fase}");
            Notification::send($talentLider->user, new ArticulacionAprobarInicio($articulacion, strtolower($fase), $user));
            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
    }

    /**
     * Aprueba la fase según el rol y fase que se está aprobando
     *
     * @param $request
     * @param $id Id del proyecto
     * @param $fase Fase que se está aprobando
     */
    public function aprobacionFase($request, $id, $fase)
    {
        DB::beginTransaction();
        try {

            $comentario = null;
            $movimiento = null;
            $mensaje = null;
            $title = null;

            $articulacion = ArticulacionPbt::findOrFail($id);
            $dinamizadorRepository = new DinamizadorRepository;
            $dinamizadores = $dinamizadorRepository->getAllDinamizadoresPorNodo($articulacion->actividad->nodo_id)->get();
            $destinatarios = $dinamizadorRepository->getAllDinamizadorPorNodoArray($dinamizadores);
            array_push($destinatarios, ['email' => $articulacion->asesor->email]);
            $talento_lider = $articulacion->talentos()->wherePivot('talento_lider', 1)->first();
            $talento_lider = $talento_lider->user;

            if ($request->decision == 'rechazado') {
                $title = 'Aprobación rechazada!';
                $mensaje = 'Se le ha notificado al articulador los motivos por los cuales no se aprueba el cambio de fase de la articulación';
                $comentario = $request->motivosNoAprueba;
                $movimiento = Movimiento::IsNoAprobar();

                $articulacion->registerHistoryArticulacion($movimiento,Session::get('login_role'), $comentario, $fase);

                $regMovimiento = $articulacion->historial->last();


                Notification::send($articulacion->asesor, new ArticulacionNoAprobarFase($articulacion, $regMovimiento, strtolower($fase)));

            } else {
                $title = 'Aprobación Exitosa!';
                $mensaje = 'Se ha aprobado la fase de ' . $fase . ' de esta articulación';
                $movimiento = Movimiento::IsAprobar();

                $articulacion->registerHistoryArticulacion($movimiento,Session::get('login_role'), $comentario, $fase);
                $regMovimiento = $articulacion->historial->last();


                Notification::send([$articulacion->asesor, $dinamizadores], new ArticulacionAprobarInicioDinamizador($articulacion, $talento_lider, $regMovimiento,strtolower($fase)));

                if (Session::get('login_role') == User::IsDinamizador() && ($fase == "Inicio" || $fase == "inicio")) {

                    $articulacion->update([
                        'fase_id' => Fase::where('nombre', 'Ejecución')->first()->id
                    ]);
                }
                if (Session::get('login_role') == User::IsDinamizador() && ($fase == "Ejecución" || $fase == "ejecución"  || $fase == "ejecucion")) {

                    $articulacion->update([
                        'fase_id' => Fase::where('nombre', 'Cierre')->first()->id
                    ]);
                }
                if (Session::get('login_role') == User::IsDinamizador() && ($fase == "Cierre" || $fase == "cierre")) {

                    $articulacion->update([
                        'fase_id' => Fase::where('nombre', 'Finalizado')->first()->id,
                        'fecha_cierre' => Carbon::now()
                    ]);

                    $articulacion->registerHistoryArticulacion($movimiento,Session::get('login_role'), 'cerró', 'Finalizado');
                }
            }
            DB::commit();
            return [
                'state' => true,
                'mensaje' => $mensaje,
                'title' => $title,
                'data' => $articulacion
            ];
        } catch (\Throwable $th) {
            DB::rollBack();
            return [
                'state' => false,
                'mensaje' => 'No se ha aprobado la fase de inicio de la articulación',
                'title' => 'Aprobación errónea'
            ];
        }
    }

    /**
   * Modifica los entregables de una articulacion en la fase de ejecución
   *
   * @param Request $request
   * @param int $id id de la articulacion
   * @return array
   * @author devjul
   */
  public function updateEntregablesEjecucionRepository($request, $id)
  {
        DB::beginTransaction();
        try {
            $articulacion = ArticulacionPbt::findOrFail($id);

            $seguimiento = 0;
            $documento_convocatoria = 0;
            if (isset($request->txtseguimiento)) {
                $seguimiento = 1;
            }
            if (isset($request->txtdoc_convocatoria)) {
                $documento_convocatoria = 1;
            }

            $articulacion->update([
                'documento_convocatoria' => $documento_convocatoria,
                'seguimiento' => $seguimiento,
            ]);

            DB::commit();
            return $articulacion;
        } catch (\Throwable $th) {
            DB::rollback();
            return null;
        }
    }

    /**
     * Modifica los datos de cierre de una articulacion
     *
     * @param Request $request
     * @param int $id id de la articulacion
     * @return boolean
     * @author devjul
     */
    public function updateCierreArticulacion($request, $id)
    {
        DB::beginTransaction();
        try {
            $postulacion = 0;
            $aprobacion = 0;
            $pdfjustificativo = 0;
            $pdf_aprobacion = 0;
            $pdf_doc_postulacion = 0;
            $pdf_noaprobacion = 0;
            $articulacion = ArticulacionPbt::findOrFail($id);

            if (isset($request->txttipopostulacion) && $request->txttipopostulacion == "si") {
                    $postulacion = 1;
            }
            if (isset($request->txtaprobacion)  && $request->txtaprobacion == "aprobado") {
                    $aprobacion = 1;
            }
            if (isset($request->txtpdfjustificado)) {
                $pdfjustificativo = 1;
            }
            if (isset($request->txtpdfaprobacion)) {
                $pdf_aprobacion = 1;
            }
            if (isset($request->txtdoc_postulacion)) {
                $pdf_doc_postulacion = 1;
            }
            if (isset($request->txtpdfnoaprobacion)) {
                $pdf_noaprobacion = 1;
            }

            $articulacion->update([
                'postulacion' => $postulacion,
                'aprobacion' => $aprobacion,
                'justificacion' => $request->txtjustificacion,
                'informe_justificado' => $pdfjustificativo,
                'informe' => $request->txtinforme,
                'recibira' => $request->txtrecibira,
                'cuando' => $request->txtcuando,
                'pdf_aprobacion' => $pdf_aprobacion,
                'documento_postulacion' => $pdf_doc_postulacion,
                'pdf_noaprobacion' => $pdf_noaprobacion,
                'lecciones_aprendidas' => $request->txtlecciones,
            ]);

        DB::commit();
        return $articulacion;
        } catch (\Throwable $th) {
        DB::rollback();
        return null;
        }
    }

    /**
     * Notifica al dinamizador para que apruebe la suspension de la articulacion
     *
     * @param int $id de la articulacion
     * @return boolean
     * @author devjul
     */
    public function notificarAlDinamziador_Suspendido(int $id)
    {
        DB::beginTransaction();
        try {
            $dinamizadorRepository = new DinamizadorRepository;
            $articulacion = ArticulacionPbt::findOrFail($id);
            $dinamizadores = $dinamizadorRepository->getAllDinamizadoresPorNodo($articulacion->actividad->nodo_id)->get();
            Notification::send($dinamizadores, new ArticulacionAprobarSuspendido($articulacion));
            $articulacion->registerHistoryArticulacion(Movimiento::IsSolicitarDinamizador(),Session::get('login_role'), null, 'Suspender');
            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
    }

        /**
     * Suspende una articulacion
     * @param Request $request
     * @param int $id id de la articulacion
     * @return array
     * @author devjul
     **/
    public function suspenderArticulacion($request, $articulacion)
    {
        DB::beginTransaction();
        try {
            $articulacion->update([
                'fase_id' => Fase::where('nombre', 'Suspendido')->first()->id,
                'aprobacion_dinamizador_suspender' => 1,
                'fecha_cierre' => Carbon::now()->isoFormat('YYYY-MM-DD')
            ]);

            Notification::send(User::findOrFail($articulacion->asesor->id), new ArticulacionSuspendidaAprobada($articulacion));
            $articulacion->registerHistoryArticulacion(Movimiento::IsAprobar(),Session::get('login_role'), null, 'Suspensión');
            DB::commit();
            return $articulacion;
        } catch (\Throwable $th) {
            DB::rollBack();
            return null;
        }
    }

        /**
     * Reversa la fase de un proyecto
     *
     * @param ArticulacionPbt $articulacion ArticulacionPbt
     * @param string $fase Fase a la que se reversa el ArticulacionPbt
     * @return array
     * @author devjul
     **/
    public function reversarArticulacion(ArticulacionPbt $articulacion, string $fase)
    {
        DB::beginTransaction();
        try {
            $movimiento = Movimiento::IsReversar();
            $articulacion->registerHistoryArticulacion($movimiento,Session::get('login_role'), null, $fase);


            $articulacion->update([
                'fase_id' => Fase::where('nombre', $fase)->first()->id,
                'aprobacion_dinamizador_suspender' => 0
            ]);

            if ($fase == 'Inicio' || $fase == 'Planeación' || $fase == 'Ejecución') {
                $this->reversarAInicioPlaneacionEjecucion($articulacion);
            }
            DB::commit();
            return $articulacion;
        } catch (\Throwable $th) {
            DB::rollBack();
            return null;
        }
    }

        /**
     * Reversa una articulacion a la fase de inicio ó planeación
     *
     * @param ArticulacionPbt $articulacion
     * @return void
     * @author devjul
     **/
    private function reversarAInicioPlaneacionEjecucion(ArticulacionPbt $articulacion)
    {
        $articulacion->update([
            'aprobacion_dinamizador_ejecucion' => 0
        ]);

        $articulacion->actividad()->update([
            'aprobacion_dinamizador' => 0
        ]);
    }

    /**
     * Modifica los miembros de una articulacion
     *
     * @param Request request Request con los datos del formulario
     * @param int id - id de la articulacion
     * @return array
     * @author devjul
     */
    public function updateMiembros($request, $id)
    {
        DB::beginTransaction();
        try {
            $articulacion = ArticulacionPbt::find($id);

            $syncData = [];
            $syncData = $this->syncTalent($request);
            $articulacion->talentos()->sync($syncData);

            User::enableTalentsArticulacion($articulacion);

            DB::commit();
            return $articulacion;
        } catch (\Exception $e) {
            DB::rollback();
            return null;
        }
    }

    /**
    * Cambia el articulador de una articulacion
    *
    * @param Request $request
    * @param int $id id de la articulacion
    * @return response
    * @author devjul
    **/
    public function updateArticulador($request, $id)
    {
        DB::beginTransaction();
        try {
            $articulacion = ArticulacionPbt::find($id);
            $fase = Fase::where('id', $articulacion->fase_id)->first()->nombre;

            if ($articulacion->asesor_id != $request->txtgestor) {
                $articulacion->registerHistoryArticulacion(Movimiento::IsCambiar(),Session::get('login_role'), null, $fase);
            }
            $articulacion->update([
                'asesor_id' => $request->txtgestor
            ]);

            DB::commit();
            return $articulacion;
        } catch (\Throwable $th) {
            DB::rollBack();
            return null;
        }
    }

    /**
     * retorna query con las articulaciones en fase Inicio, En ejecución por usuarios
    * @return collection
    * @author devjul
    */
    public function getArticulacionesForUser(array $relations)
    {
        return ArticulacionPbt::articulacionesWithRelations($relations);
    }

}
