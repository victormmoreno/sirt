<?php

namespace App\Http\Controllers\Encuesta;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Encuesta\EncuestaResponder;
use App\Models\Proyecto;
use App\Models\Articulation;
use App\Models\Encuesta;
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

        $query->interlocutor($query);
        //verificar si existe aun el token
        if(!$query->exists($token)){
            return abort(404);
        }
        return view('encuestas.show', ['proyecto' => $query, 'token' => $token]);
        // return dd(['user'=> $user, 'model' => $query]);
        //elminiar el token
        //se debe eliminar un vez se envie la encuesta.
        //$query->deleteToken();
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
        $data = $this->getDataToStore($request);

        // $query = Proyecto::find($request->proyecto_id);
        // $query->interlocutor($query);
        // $query->deleteToken();
        // exit;
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
                'acompanamiento_comite' => $request->acompanamiento_comite,
                'desarrollo_comite' => $request->desarrollo_comite,
                'asignacion_experto' => $request->asignacion_experto,
                'inscripcion_plataforma' => $request->inscripcion_plataforma,
                'uso_plataforma' => $request->uso_plataforma,
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
     * @param Request $$request
     * @param array $data
     * @return array
     * @author dum
     **/
    public function store(Request $request, array $data)
    {
        $proyecto = Proyecto::find($request->proyecto_id);
        DB::beginTransaction();
        try {
            
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }
    
    /**
     **/
    public function show(Proyecto $id)
    {
        return view('encuestas.show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('encuestas.index');
    }

}
