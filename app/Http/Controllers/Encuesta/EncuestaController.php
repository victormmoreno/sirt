<?php

namespace App\Http\Controllers\Encuesta;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Encuesta\EncuestaResponder;
use App\Models\Proyecto;
use App\Models\Encuesta;
use App\Models\Movimiento;
use App\Models\ResultadoEncuesta;
use App\Models\Role;
use App\Notifications\Encuesta\EncuestaRespondida;
use App\User;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;
use DB;
use Validator;

class EncuestaController extends Controller
{
    public function mostrarFormularioEncuesta($module = null, $id = null, $token = null)
    {
        $query = null;
        switch(ucfirst($module)){
            case class_basename(Proyecto::class):
                $query = Proyecto::find($id);
                break;
            default:
                return abort(404);
                break;
        }

        $query->setQuery($query);
        //verificar si existe aun el token
        if(!$query->exists($token)){
            return abort(404);
        }
        return view('encuestas.show', ['proyecto' => $query, 'token' => $token]);
    }

    public function answers(Request $request) {
        $req = new EncuestaResponder();
        $validator = Validator::make($request->all(), $req->rules(), $req->messages());
        if ($validator->fails()) {
            return response()->json([
                'state'   => 'error_form',
                'errors' => $validator->errors(),
            ]);
        }
        DB::beginTransaction();
        try {
            $proyecto = Proyecto::find($request->proyecto_id);
            $proyecto->setQuery($proyecto);
            $data = $this->getDataToStore($request);
            $this->store($proyecto, $data);
            Notification::send($proyecto->asesor, new EncuestaRespondida($proyecto));
            // Falta el registro del historial
            $encuestado = $this->verificar_encuestado();
            $this->trazabilidad_encuesta_respondida($proyecto, $encuestado); 
            $proyecto->deleteToken();
            DB::commit();
            return response()->json([
                'state' => true,
                'title' => 'Registro exitoso',
                'msj' => 'Los resultados de la encuesta se han guardado', 
                'type' => 'success', 
                'url' => route('home')
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'state' => false,
                'title' => 'Registro erróneo',
                'msj' => 'Los resultados de la encuesta se no han guardado: ' . $th->getMessage(), 
                'type' => 'error'
            ]);
        }
    }

    /**
     * Verificar quien está respondió la encuesta de satisfacción
     *
     * @return string
     * @author dum
     **/
    private function verificar_encuestado()
    {
        $observacion = null;
        if (isset(auth()->user()->id)) {
            $observacion = 'El usuario ' . auth()->user()->nombres .' '. auth()->user()->apellidos . ' fue quién respondió la encuesta';
        }
        return $observacion;
    }

    /**
     * Registra la trazabilidad cuando se contesta la encuesta
     *
     * @param Proyecto $proyecto
     * @param string $encuestado
     * @return Model
     * @author dum
     **/
    private function trazabilidad_encuesta_respondida(Proyecto $proyecto, $encuestado)
    {
        return $proyecto->movimientos()->attach(Movimiento::where('movimiento', Movimiento::IsResponderEncuestaSatisfaccion())->first(), [
            'proyecto_id' => $proyecto->id,
            'user_id' => $proyecto->getUser()->id,
            'fase_id' => $proyecto->fase->id,
            'role_id' => Role::where('name', User::IsUsuario())->first()->id,
            'comentarios' => $encuestado
        ]);
    }
    
    /**
     * Retorna el array para guardar en la base de datos
     *
     * @param Request $request
     * @return array
     * @author dum
     **/
    private function getDataToStore(Request $request)
    {
        return [
            'resultados' => [
                'estado_proyecto' => $request->estado_proyecto,
                'afinidad_proyecto' => $request->afinidad_proyecto,
                'infocenter' => [
                    'conoce_infocenter' => isset(request()->conoce_infocenter) ? 'Si' : 'No',
                    'infocenter_amabilidad' => isset(request()->conoce_infocenter) ? $request->infocenter_amabilidad : 'No aplica',
                    'infocenter_conocimiento' => isset(request()->conoce_infocenter) ? $request->infocenter_conocimiento : 'No aplica',
                ],
                'dinamizador' => [
                    'conoce_dinamizador' => isset(request()->conoce_dinamizador) ? 'Si' : 'No',
                    'dinamizador_amabilidad' => isset(request()->conoce_dinamizador) ? $request->dinamizador_amabilidad : 'No aplica',
                    'dinamizador_conocimiento' => isset(request()->conoce_dinamizador) ? $request->dinamizador_conocimiento : 'No aplica',
                ],
                'articulador' => [
                    'conoce_articulador' => isset(request()->conoce_articulador) ? 'Si' : 'No',
                    'articulador_amabilidad' => isset(request()->conoce_articulador) ? $request->articulador_amabilidad : 'No aplica',
                    'articulador_conocimiento' => isset(request()->conoce_articulador) ? $request->articulador_conocimiento : 'No aplica',
                ],
                'dispocision_personal' => $request->dispocision_personal,
                'experiencia_proceso_atencion' => [
                    'acompanamiento_comite' => $request->acompanamiento_comite,
                    'desarrollo_comite' => $request->desarrollo_comite,
                    'asignacion_experto' => $request->asignacion_experto,
                    'inscripcion_plataforma' => $request->inscripcion_plataforma,
                    'uso_plataforma' => $request->uso_plataforma,
                ],
                'calificacion_experto' => [
                    'conocimiento_experto' => $request->conocimiento_experto,
                    'experto_ayuda_objetivos' => $request->experto_ayuda_objetivos,
                    'experto_cumple_cronograma' => $request->experto_cumple_cronograma,
                    'experto_hace_seguimiento' => $request->experto_hace_seguimiento,
                    'experto_presenta_recursos' => $request->experto_presenta_recursos,
                    'experto_entrega_documentos' => $request->experto_entrega_documentos,
                    'experto_acompana' => $request->experto_acompana,
                ],
                'calificacion_infraestructura' => [
                    'infraestructura_acorde_necesidades' => $request->infraestructura_acorde_necesidades,
                    'infraestructura_disponibilidad' => $request->infraestructura_disponibilidad,
                    'materiales_disponibilidad' => $request->materiales_disponibilidad,
                ],
                'acompanamiento_articlacion' => [
                    'acompanamiento_articulador' => $request->acompanamiento_articulador,
                    'articulacion_alcanza_proposito' => isset($request->articulacion_alcanza_proposito) ? $request->articulacion_alcanza_proposito : 'No aplica',
                    'articulacion_fue_fundamental' => isset($request->articulacion_fue_fundamental) ? $request->articulacion_fue_fundamental : 'No aplica',
                    'articulador_es_capaz' => isset($request->articulador_es_capaz) ? $request->articulador_es_capaz : 'No aplica',
                    'articulador_hace_seguimiento' => isset($request->articulador_hace_seguimiento) ? $request->articulador_hace_seguimiento : 'No aplica',
                    'articulador_presenta_recursos' => isset($request->articulador_presenta_recursos) ? $request->articulador_presenta_recursos : 'No aplica',
                    'articulador_demuestra_acompanamiento' => isset($request->articulador_demuestra_acompanamiento) ? $request->articulador_demuestra_acompanamiento : 'No aplica',
                ],
                'usuario_compartido' => [
                    'comparte_credenciales' => isset($request->comparte_credenciales) ? 'Si' : 'No',
                    'con_quien_comparte' => isset($request->comparte_credenciales) ? $request->con_quien_comparte : 'No aplica',
                    'motivo_compartir_credenciales' => isset($request->comparte_credenciales) ? $request->motivo_compartir_credenciales : 'No aplica',
                ],
                'objetivos_proyecto' => [
                    'alcanza_objetivos' => !isset(request()->alcanza_objetivos) ? 'Si' : 'No',
                    'motivo_no_logrado' => !isset(request()->alcanza_objetivos) ? $request->motivo_no_logrado : 'No alica',
                ],
                'aspectos_a_mejorar' => $request->aspectos_a_mejorar,
                'como_conoce_tecnoparque' => $request->como_conoce_tecnoparque,
                'otros_servicios_sena' => [
                    'usa_otros_servicios' => isset(request()->usa_otros_servicios) ? 'Si' : 'No',
                    'uso_otros_servicios' => isset(request()->usa_otros_servicios) ? $request->uso_otros_servicios : 'No aplica',
                    'otros_servicios' => isset(request()->usa_otros_servicios) ? $request->otros_servicios : 'No aplica',
                ]
            ]
        ];
    }

    /**
     * Almacena las respuestas de la encuesta
     *
     * @param Proyecto $proyecto
     * @param array $data
     * @return array
     * @author dum
     **/
    public function store(Proyecto $proyecto, array $data)
    {
        return $proyecto->resultadosEncuesta()->create([
            'user_id' => $proyecto->getUser()->id,
            'resultados' => $data,
            'fecha_envio' => $proyecto->encuestaToken->created_at,
            'fecha_respuesta' => Carbon::now()
        ]);
    }
}
