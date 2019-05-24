<?php

namespace App\Repositories\Repository;

use App\Models\EstadoIdea;
use App\Models\Idea;
use App\Models\Nodo;
// use App\Repositories\Interface\IdeaInterface;
use Carbon\Carbon;

class IdeaRepository 
{

    public function getSelectNodo()
    {
        return Nodo::SelectNodo()->get();
    }

    public function Store($request)
    {
        $idea = Idea::create([
            "fecha"          => Carbon::now(),
            "nombrec"        => $request->input('txtnombres'),
            "apellidoc"      => $request->input('txtapellidos'),
            "correo"         => $request->input('txtcorreo'),
            "telefono"       => $request->input('txttelefono'),
            "nombreproyecto" => $request->input('txtnombreproyecto'),
            "aprendizsena"   => $request->input('txtaprendizsena') == 'on' ? $request['txtaprendizsena'] = 1 : $request['txtaprendizsena'] = 0,
            "pregunta1"      => $request->input('pregunta1'),
            "pregunta2"      => $request->input('pregunta2'),
            "pregunta3"      => $request->input('pregunta3'),
            "descripcion"    => $request->input('txtdescripcion'),
            "objetivo"       => $request->input('txtobjetivo'),
            "alcance"        => $request->input('txtalcance'),
            "tipoidea"       => Idea::IsEmprendedor(),
            "nodo_id"        => $request->input('txtnodo'),
            "estadoidea_id"  => EstadoIdea::FilterEstadoIdea('nombre', 'Inicio Emprendedor')->first()->id,
        ]);

        return $idea;
    }

    public function findByid($id)
    {

        return Idea::findOrFail($id);

    }

}
