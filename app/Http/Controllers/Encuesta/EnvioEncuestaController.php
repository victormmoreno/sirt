<?php

namespace App\Http\Controllers\Encuesta;

use App\Http\Controllers\Controller;
use App\Models\Proyecto;
use App\Models\Articulation;
use App\Models\EncuestaToken;


class EnvioEncuestaController extends Controller
{

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function enviarLinkEncuesta($modulo, $id)
    {
        $query = $this->obtenerInformacionModulo($modulo, $id);
        if(is_null($query)){
            return abort(404);
        }
        $user = $query->interlocutor($query);
        if (is_null($user)) {
            return abort(404);
        }

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
     * Get the response for a successful password reset link.
     *
     */
    protected function enviarRespuestaLinkEncuesta()
    {
        alert('Encuesta enviada', 'La encuesta se ha enviado al talento', 'success')->showConfirmButton('Ok', '#3085d6');
        return back();
    }

    /**
     * Get the response for a failed password reset link.
     *
     */
    protected function enviarLinkEncuestaRespuestaFallida()
    {
        alert('Encuesta no enviada', 'La encuesta no se ha enviado, intentalo nuevamente', 'error')->showConfirmButton('Ok', '#3085d6');
        return back();
    }
}
