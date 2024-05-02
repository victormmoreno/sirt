<?php

namespace App\Http\Controllers\Encuesta;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Proyecto;
use App\Models\Articulation;
use App\Models\Encuesta;

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
        //verificar si existe aun el token
        if(!$query->exists($token)){
            return abort(404);
        }
        return dd(['user'=> $user, 'model' => $query]);
        //elminiar el token
        //se debe eliminar un vez se envie la encuesta.
        //$query->deleteToken();

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


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!request()->user()->can('create', Encuesta::class)) {
            alert('No autorizado', 'No tienes permisos para crear encuestas!', 'warning')->showConfirmButton('Ok', '#3085d6');
            return back();
        }
        return view('encuestas.create');
    }
}
