<?php

namespace App\Http\Controllers\Encuesta;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Proyecto;
use App\Models\Articulation;

class EncuestaController extends Controller
{
    public function mostrarFormularioEncuesta(Request $request, $module = null, $id = null, $token = null)
    {
        $query = null;
        switch(ucfirst($module)){
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
                return;
                break;
        }

        $user = $query->interlocutor($query);
        if(!$query->exists($token)){
            return abort(404);
        }
        dd(['query' => $query, 'mensaje'=> 'bienvenido a la encuesta']);

    }
}
