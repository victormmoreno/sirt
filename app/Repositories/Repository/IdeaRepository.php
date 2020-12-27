<?php

namespace App\Repositories\Repository;

use App\Models\{EstadoIdea, Idea, Nodo};

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use App\Events\Idea\IdeaHasReceived;
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

    public function consultarIdeasDeProyecto()
    {
        return Idea::with(['estadoIdea']);
    }

    /**
     * Función que genera el código de una idea de proyecto
     * @param int $tipo Indica que tipo de idea de proyecto es.
     * @param int $idnodo Indica a que nodo se va a registrar la idea.
     * @return string
     */
    public function generarCodigoIdea($idnodo)
    {
        $anho = Carbon::now()->isoFormat('YYYY');
        $tecnoparque = sprintf("%02d", $idnodo);
        $user = sprintf("%05d", auth()->user()->id);
        $id = Idea::selectRaw('MAX(id+1) AS max')->get()->last();
        $id->max == null ? $id->max = 1 : $id->max = $id->max;
        $id->max = sprintf("%04d", $id->max);
        $codigo_idea = 'I' . $anho . '-' . $tecnoparque . $user . '-' . $id->max;
        return $codigo_idea;
    }

    public function Store($request)
    {
        DB::beginTransaction();
        try {
            $producto_parecido = 1;
            $si_producto_parecido = $request->input('txtsi_producto_parecido');
            $reemplaza = 1;
            $si_reemplaza = $request->input('txtsi_reemplaza');
            $packing = 1;
            $tipo_packing = $request->input('txttipo_packing');
            $requisitos_legales = 1;
            $si_requisitos_legales = $request->input('txtsi_requisitos_legales');
            $requiere_certificaciones = 1;
            $si_requiere_certificaciones = $request->input('txtsi_requiere_certificaciones');
            $recursos_necesarios = 1;
            $si_recursos_necesarios = $request->input('txtsi_recursos_necesarios');
            $viene_convocatoria = 1;
            $convocatoria = $request->input('txtconvocatoria');
            $aval_empresa = 1;
            $empresa = $request->input('empresa');

            if ($request->input('txtproducto_parecido') === null) {
                $producto_parecido = 0;
                $si_producto_parecido = null;
            }

            if ($request->input('txtreemplaza') === null) {
                $reemplaza = 0;
                $si_reemplaza = null;
            }

            if ($request->input('txtpacking') === null) {
                $packing = 0;
                $tipo_packing = null;
            }

            if ($request->input('txtrequisitos_legales') === null) {
                $requisitos_legales = 0;
                $si_requisitos_legales = null;
            }

            if ($request->input('txtrequiere_certificaciones') === null) {
                $requiere_certificaciones = 0;
                $si_requiere_certificaciones = null;
            }

            if ($request->input('txtrecursos_necesarios') === null) {
                $recursos_necesarios = 0;
                $si_recursos_necesarios = null;
            }

            if ($request->input('txtviene_convocatoria') === null) {
                $viene_convocatoria = 0;
                $convocatoria = null;
            }

            if ($request->input('txtaval_empresa') === null) {
                $aval_empresa = 0;
                $empresa = null;
            }

            $codigo_idea = $this->generarCodigoIdea($request->input('txtnodo'));

            $idea = Idea::create([
                "nombre_proyecto" => $request->input('txtnombre_proyecto'),
                "descripcion" => $request->input('txtdescripcion'),
                "producto_parecido" => $producto_parecido,
                "si_producto_parecido" => $si_producto_parecido,
                "reemplaza" => $reemplaza,
                "si_reemplaza" => $si_reemplaza,
                "pregunta1" => $request->input('pregunta1'),
                "problema" => $request->input('txtproblema'),
                "necesidades" => $request->input('txtnecesidades'),
                "quien_compra" => $request->input('txtquien_compra'),
                "quien_usa" => $request->input('txtquien_usa'),
                "distribucion" => $request->input('txtdistribucion'),
                "quien_entrega" => $request->input('txtquien_entrega'),
                "packing" => $packing,
                "tipo_packing" => $tipo_packing,
                "medio_venta" => $request->input('txtmedio_venta'),
                "valor_clientes" => $request->input('txtvalor_clientes'),
                "pregunta2" => $request->input('pregunta2'),
                "requisitos_legales" => $requisitos_legales,
                "si_requisitos_legales" => $si_requisitos_legales,
                "requiere_certificaciones" => $requiere_certificaciones,
                "si_requiere_certificaciones" => $si_requiere_certificaciones,
                "forma_juridica" => $request->input('txtforma_juridica'),
                "version_beta" => $request->input('txtversion_beta'),
                "cantidad_prototipos" => $request->input('txtcantidad_prototipos'),
                "recursos_necesarios" => $recursos_necesarios,
                "si_recursos_necesarios" => $si_recursos_necesarios,
                "nodo_id" => $request->input('txtnodo'),
                "pregunta3" => $request->input('pregunta3'),
                "viene_convocatoria" => $viene_convocatoria,
                "convocatoria" => $convocatoria,
                "aval_empresa" => $aval_empresa,
                "empresa" => $empresa,
                "codigo_idea" => $codigo_idea,
                "tipo_idea" => Idea::IsEmprendedor(),
                "estadoidea_id" => EstadoIdea::where('nombre', '=', EstadoIdea::IsInscrito())->first()->id,
                "talento_id" => auth()->user()->talento->id
            ]);

            $idea->rutamodel()->create([
                'ruta' => $request->input('txtlinkvideo'),
            ]);

            DB::commit();
            return true;
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return false;
        }

    }

    public function Update($request, $idea)
    {

        $idea->nodo_id            = $request->input('txtnodo');
        $idea->nombres_contacto   = $request->input('txtnombres');
        $idea->apellidos_contacto = $request->input('txtapellidos');
        $idea->correo_contacto    = $request->input('txtcorreo');
        $idea->telefono_contacto  = $request->input('txttelefono');
        $idea->nombre_proyecto    = $request->input('txtnombre_proyecto');
        $idea->aprendiz_sena      = $request->input('txtaprendiz_sena') == 'on' ? $request['txtaprendiz_sena'] = 1 : $request['txtaprendiz_sena'] = 0;
        $idea->pregunta1          = $request->input('pregunta1');
        $idea->pregunta2          = $request->input('pregunta2');
        $idea->pregunta3          = $request->input('pregunta3');
        $idea->descripcion        = $request->input('txtdescripcion');
        $idea->objetivo           = $request->input('txtobjetivo');
        $idea->alcance            = $request->input('txtalcance');
        $idea->viene_convocatoria = $request->input('txtconvocatoria');
        $idea->convocatoria       = $request->input('txtconvocatoria') == 1 ? $request->input('txtnombreconvocatoria') : null;
        $idea->aval_empresa = $request->input('txtavalempresa');
        $idea->empresa       = $request->input('txtavalempresa') == 1 ? $request->input('txtempresa') : null;

        $idea = $idea->update();
        return $idea;
    }

    // Cambiar el estado de una idea según el parametro que se le envia, (el parametro es el NOMBRE DEL ESTADO DE IDEAS)
    public function updateEstadoIdea($idIdea, $estadoACambiar)
    {
        return DB::update("UPDATE ideas SET estadoidea_id = (
      CASE
      WHEN '$estadoACambiar' = 'Inscrito' THEN 1
      WHEN '$estadoACambiar' = 'Convocado' THEN 2
      WHEN '$estadoACambiar' = 'Admitido' THEN 3
      WHEN '$estadoACambiar' = 'No Admitido' THEN 4
      WHEN '$estadoACambiar' = 'No Convocado' THEN 5
      WHEN '$estadoACambiar' = 'Inhabilitado' THEN 6
      WHEN '$estadoACambiar' = 'En Proyecto' THEN 7
      WHEN '$estadoACambiar' = 'No Aplica' THEN 8
      WHEN '$estadoACambiar' = 'Programado' THEN 9
      WHEN '$estadoACambiar' = 'Reprogramado' THEN 10
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
