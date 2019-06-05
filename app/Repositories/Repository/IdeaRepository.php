<?php

namespace App\Repositories\Repository;

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

        // dd($request->all());
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
            "tipo_idea"           => Idea::IsEmprendedor(),

        ]);

        return $idea;
    }

    public function Update($request, $idea)
    {

        // dd($request->all());
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

    public function findByid($id)
    {

        return Idea::findOrFail($id);

    }

}
