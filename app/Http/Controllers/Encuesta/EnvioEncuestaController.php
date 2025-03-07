<?php

namespace App\Http\Controllers\Encuesta;

use App\Http\Controllers\Controller;
use App\Models\Proyecto;
use App\Models\Articulation;
use App\Models\EncuestaToken;

class EnvioEncuestaController extends Controller
{
    /**
     * enviar el link de la encuesta.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function enviarLinkEncuesta($modulo, $id)
    {
        $query = $this->obtenerInformacionModulo($modulo, $id);

        if(is_null($query)){
            return abort(404);
        }
        $query->setQuery($query);
        $response =  $query->enviarNotificacionEncuesta(
            $query->createToken()
        );
        return $response == EncuestaToken::ENVIAR_ENCUESTA
                    ? $this->enviarRespuestaLinkEncuesta()
                    : $this->enviarLinkEncuestaRespuestaFallida();
    }

    /**
     * obtener informacion del modulo a traves del id.
     *
     * @param  string $modulo
     * @param  int $id
     */
    protected function obtenerInformacionModulo($modulo, $id)  {
        $query = null;
        switch(ucfirst($modulo)){
            case class_basename(Proyecto::class):
                $query = Proyecto::query()
                ->select('id','codigo_proyecto as codigo', 'nombre')
                ->where('id', $id)
                ->firstOrFail();
                break;
            case 'Articulacion':
                $query = Articulation::query()
                ->select('id', 'code as codigo', 'name as nombre', 'start_date as fecha_inicio', 'end_date as fecha_cierre', 'created_by', 'articulation_stage_id')
                ->with([
                    'articulationstage' => function($query){
                        $query->select('id', 'code', 'name', 'start_date', 'end_date', 'interlocutor_talent_id');
                    },
                    'articulationstage.interlocutor' => function($query){
                        $query->select('id', 'documento', 'nombres', 'apellidos', 'email');
                    }
                ])
                ->where('id', $id)
                ->firstOrFail();
                break;
            default:
                $query = null;
                break;
        }
        return $query;
    }

    /**
     * obtener larespuesta al enviar el link de la encuesta.
     */
    protected function enviarRespuestaLinkEncuesta()
    {
        alert('Encuesta enviada', 'La encuesta se ha enviado al talento', 'success')->showConfirmButton('Ok', '#3085d6');
        return back();
    }

    /**
     * obtener la respuesta cuando falla el envio del link de la encuesta.
     */
    protected function enviarLinkEncuestaRespuestaFallida()
    {
        alert('Encuesta no enviada', 'La encuesta no se ha enviado, intentalo nuevamente', 'error')->showConfirmButton('Ok', '#3085d6');
        return back();
    }
}
