<?php

namespace App\Repositories\Repository;

use App\Models\EstadoIdea;

use App\Models\Idea;
use App\Models\Nodo;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use App\Events\Idea\IdeaHasReceived;
use App\Events\Idea\IdeaSend;
use App\User;
use App\Notifications\Idea\IdeaReceived;

class IdeaRepository
{

    public function getSelectNodo()
    {
        return Nodo::SelectNodo()->get();
    }

    /**
     * Consulta si una idea de proyecto está en registrada en un csibt
     *
     * @param int id Id de la idea que se consultará para saber si está en un comité
     * @return Collection
     */
    public function consultarIdeaEnComite($id)
    {
        return Idea::select('ideas.id', 'ideas.nombre_proyecto', 'ideas.codigo_idea')
            ->join('comite_idea', 'comite_idea.idea_id', '=', 'ideas.id')
            ->join('comites', 'comites.id', '=', 'comite_idea.comite_id')
            ->where('ideas.id', $id)
            ->get()
            ->last();
    }

    /**
     * Función que genera el código de una idea de proyecto
     * @param int $tipo Indica que tipo de idea de proyecto es.
     * @param int $idnodo Indica a que nodo se va a registrar la idea.
     * @return string
     */
    private function generarCodigoIdea($tipo, $idnodo)
    {
        $anho                       = Carbon::now()->isoFormat('YYYY');
        $tecnoparque                = sprintf("%02d", $idnodo);
        $id                         = Idea::selectRaw('MAX(id+1) AS max')->get()->last();
        $id->max == null ? $id->max = 1 : $id->max = $id->max;
        $id->max                    = sprintf("%04d", $id->max);
        $codigo_idea                = 'I' . $anho . '-' . $tecnoparque . $tipo . '-' . $id->max;
        return $codigo_idea;
    }

    public function Store($request)
    {

        $codigo_idea = $this->generarCodigoIdea(Idea::IsEmprendedor(), $request->input('txtnodo'));

        $idea = Idea::create([
            "nodo_id"            => $request->input('txtnodo'),
            "nombres_contacto"   => $request->input('txtnombres'),
            "apellidos_contacto" => $request->input('txtapellidos'),
            "correo_contacto"    => $request->input('txtcorreo'),
            "telefono_contacto"  => $request->input('txttelefono'),
            "nombre_proyecto"    => $request->input('txtnombre_proyecto'),
            "codigo_idea"        => $codigo_idea,
            "aprendiz_sena"      => $request->input('txtaprendiz_sena') == 'on' ? $request['txtaprendiz_sena'] = 1 : $request['txtaprendiz_sena'] = 0,
            "pregunta1"          => $request->input('pregunta1'),
            "pregunta2"          => $request->input('pregunta2'),
            "pregunta3"          => $request->input('pregunta3'),
            "descripcion"        => $request->input('txtdescripcion'),
            "objetivo"           => $request->input('txtobjetivo'),
            "alcance"            => $request->input('txtalcance'),
            "viene_convocatoria" => $request->input('txtconvocatoria'),
            "convocatoria"       => $request->input('txtconvocatoria') == 1 ? $request->input('txtnombreconvocatoria') : null,
            "tipo_idea"          => Idea::IsEmprendedor(),
            "estadoidea_id"      => EstadoIdea::where('nombre', '=', EstadoIdea::IS_INICIO)->first()->id,
        ]);

        $idea->rutamodel()->create([
            'ruta' => $request->input('txtlinkvideo'),
        ]);

        event(new IdeaHasReceived($idea));

        $users = User::infoUserRole(['Infocenter'], ['infocenter', 'infocenter.nodo'])->whereHas(
            'infocenter.nodo',
            function ($query) use ($idea) {
                $query->where('id', $idea->nodo_id);
            }
        )->get();

        if (!$users->isEmpty()) {
            Notification::send($users, new IdeaReceived($idea));
        }

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
        //se anadieron los campos convocatoria
        $idea->viene_convocatoria = $request->input('txtconvocatoria');
        $idea->convocatoria       = $request->input('txtconvocatoria') == 1 ? $request->input('txtnombreconvocatoria') : null;

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
      WHEN '$estadoACambiar' = 'En Proyecto' THEN 7
      WHEN '$estadoACambiar' = 'No Aplica' THEN 8
      END
      ) WHERE id = $idIdea ");
    }

    public function findByid($id)
    {
        return Idea::findOrFail($id);
    }


    public function getIdeaWithRelations($idea)
    {
        return $idea->with([
            'nodo' => function ($query) {
                $query->select('id', 'direccion', 'entidad_id');
            },
            'nodo.entidad' => function ($query) {
                $query->select('id', 'nombre', 'ciudad_id');
            },
            'nodo.entidad.ciudad' => function ($query) {
                $query->select('id', 'nombre', 'departamento_id');
            },
            'nodo.entidad.ciudad.departamento' => function ($query) {
                $query->select('id', 'nombre');
            },
            'nodo.infocenter'
        ])->select('id', 'nodo_id', 'apellidos_contacto', 'nombres_contacto', 'correo_contacto', 'nombre_proyecto', 'codigo_idea', 'viene_convocatoria', 'convocatoria')->get();
    }
}
