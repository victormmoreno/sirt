<?php

namespace App\Repositories\Repository;

use App\Models\EstadoIdea;
use Illuminate\Support\Facades\DB;
use App\Models\Idea;
use App\Models\Nodo;

class IdeaRepository
{

    public function getSelectNodo()
    {
        return Nodo::SelectNodo()->get();
    }

    public function Store($request)
    {

        $idea = Idea::create([
            "nodo_id"            => $request->input('txtnodo'),
            "nombres_contacto"   => $request->input('txtnombres'),
            "apellidos_contacto" => $request->input('txtapellidos'),
            "correo_contacto"    => $request->input('txtcorreo'),
            "telefono_contacto"  => $request->input('txttelefono'),
            "nombre_proyecto"    => $request->input('txtnombre_proyecto'),
            "aprendiz_sena"      => $request->input('txtaprendiz_sena') == 'on' ? $request['txtaprendiz_sena'] = 1 : $request['txtaprendiz_sena'] = 0,
            "pregunta1"          => $request->input('pregunta1'),
            "pregunta2"          => $request->input('pregunta2'),
            "pregunta3"          => $request->input('pregunta3'),
            "descripcion"        => $request->input('txtdescripcion'),
            "objetivo"           => $request->input('txtobjetivo'),
            "alcance"            => $request->input('txtalcance'),
            "tipo_idea"          => Idea::IsEmprendedor(),
            "estadoidea_id"      => EstadoIdea::where('nombre', '=', EstadoIdea::IS_INICIO)->first()->id,


        ]);

        return $idea;
    }

    public function StoreIdeaEmpGI($request)
    {

        // dd($request->all());
        $idea = Idea::create([
          "nodo_id"            => auth()->user()->infocenter->nodo_id,
          "nombres_contacto"   => $request->input('txtnidcod'),
          "apellidos_contacto" => $request->input('txtnombreempgi'),
          "nombre_proyecto"    => $request->input('txtnombre_proyecto'),
          "tipo_idea"    => $request->txttipo_idea[1],
          "estadoidea_id" => 1,
        ]);

        return $idea;
    }

    public function Update($request, $idea)
    {

        $idea->nodo_id            = $request->input('txtnodo_id');
        $idea->nombres_contacto   = $request->input('txtnombres_contacto');
        $idea->apellidos_contacto = $request->input('txtapellidos_contacto');
        $idea->correo_contacto    = $request->input('txtcorreo_contacto');
        $idea->telefono_contacto  = $request->input('txttelefono_contacto');
        $idea->nombre_proyecto    = $request->input('txtnombre_proyecto');
        $idea->descripcion        = $request->input('txtdescripcion');
        $idea->objetivo           = $request->input('txtobjetivo');
        $idea->alcance            = $request->input('txtalcance');

        $idea = $idea->update();
        return $idea;
    }


    // Cambiar el estado de una idea según el parametro que se le envia, (el parametro es el NOMBRE DEL ESTADO DE IDEAS)
    public function updateEstadoIdea($idIdea, $estadoACambiar)
    {
      return DB::update("UPDATE ideas SET estadoidea_id = (
        CASE
        WHEN '$estadoACambiar' = 'Inicio' THEN 1
        WHEN '$estadoACambiar' = 'Convocado' THEN 2
        WHEN '$estadoACambiar' = 'Admitido' THEN 3
        WHEN '$estadoACambiar' = 'No Admitido' THEN 4
        WHEN '$estadoACambiar' = 'No Convocado' THEN 5
        WHEN '$estadoACambiar' = 'Inhabilitado' THEN 6
        END
      ) WHERE id = $idIdea ");
    }

    public function findByid($id)
    {

        return Idea::findOrFail($id);

    }

}
