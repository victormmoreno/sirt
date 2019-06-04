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

    public function findByid($id)
    {

        return Idea::findOrFail($id);

    }

}
