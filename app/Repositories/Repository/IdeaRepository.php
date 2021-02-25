<?php

namespace App\Repositories\Repository;

use App\Models\{EstadoIdea, Idea, Nodo, Empresa, Entidad, Gestor};
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use App\Events\Idea\{IdeaHasReceived, IdeasWasAccepted, IdeasWasRejected};
use App\User;
use App\Notifications\Idea\{IdeaReceived, IdeaAceptadaParaComite};

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
     * El articulador aceptó la postulación de una idea de proyecto para que se presente en el comité
     *
     * @param Idea $idea Idea que se está aceptando para el comité
     * @return boolean
     * @author dum
     **/
    public function aceptarPostulacion($idea)
    {
        DB::beginTransaction();
        try {
            $idea->update(['estadoidea_id' => EstadoIdea::where('nombre', EstadoIdea::IsConvocado())->first()->id]);
            $infocenters = User::infoUserRole(['Infocenter'], ['infocenter', 'infocenter.nodo'])->whereHas(
                'infocenter.nodo',
                function ($query) use ($idea) {
                    $query->where('id', $idea->nodo_id);
                }
            )->get();
            $emails_infocenter = array();
            foreach ($infocenters as $key => $infocenter) {
                $emails_infocenter[$key+1] = $infocenter->email;
            }
            event(new IdeasWasAccepted($idea, $infocenters));

            if (!$infocenters->isEmpty()) {
                Notification::send($infocenters, new IdeaAceptadaParaComite($idea, auth()->user()));
            }
            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
    }

    /**
     * El articulador rechaza la postulación de la idea de proyecto en el nodo
     *
     * @param Idea $idea Idea que se está rechazando
     * @param Request $request
     * @return boolean
     * @author dum
     **/
    public function rechazarPostulacion(Idea $idea, $request)
    {
        DB::beginTransaction();
        try {
            // Crea un registro espejo de la idea de proyecto
            // dd($idea->rutamodel);
            $espejo = $idea->replicate();
            $espejo->codigo_idea = $this->generarCodigoIdea($idea->nodo_id);
            $espejo->estadoidea_id = EstadoIdea::where('nombre', EstadoIdea::IsRegistro())->first()->id;
            // dd($espejo->rutamodel);
            $espejo->push();
            if ($idea->rutamodel != null) {
                $espejo->rutamodel()->create([
                    'ruta' => $idea->rutamodel->ruta,
                ]);
            }
            // Cambiar el estado de la idea original a rechazado por el articulador
            $idea->update([
                'estadoidea_id' => EstadoIdea::where('nombre', EstadoIdea::IsRechazadoArticulador())->first()->id
            ]);
            // Envío de correo al talento y articulador con los motivos de porque se rechazó.
            event(new IdeasWasRejected($espejo, $request->txtmotivosRechazo));

            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
    }

    public function consultarIdeasDeProyecto()
    {
        return Idea::with(['estadoIdea', 'nodo', 'nodo.entidad']);
    }

    /**
     * Función que genera el código de una idea de proyecto
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

    /**
     * Asigna los valores de los campos que se registran dependiendo de un valor
     * 
     * @param Request $request
     * @author dum
     * @return array
     */
    private function valoresCondicionales($request)
    {
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
        $acuerdo_no_confidencialidad = 1;
        $fecha_acuerdo_no_confidencialidad = Carbon::now();

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

        if ($request->input('txtacuerdo_no_confidencialidad') === null) {
            $acuerdo_no_confidencialidad = 0;
            $fecha_acuerdo_no_confidencialidad = null;
        }

        if ($request->input('txtaval_empresa') === null) {
            $aval_empresa = 0;
            $empresa = null;
        }

        return [
            'producto_parecido' => $producto_parecido,
            'si_producto_parecido' => $si_producto_parecido,
            'reemplaza' => $reemplaza,
            'si_reemplaza' => $si_reemplaza,
            'packing' => $packing,
            'tipo_packing' => $tipo_packing,
            'requisitos_legales' => $requisitos_legales,
            'si_requisitos_legales' => $si_requisitos_legales,
            'requiere_certificaciones' => $requiere_certificaciones,
            'si_requiere_certificaciones' => $si_requiere_certificaciones,
            'recursos_necesarios' => $recursos_necesarios,
            'si_recursos_necesarios' => $si_recursos_necesarios,
            'viene_convocatoria' => $viene_convocatoria,
            'convocatoria' => $convocatoria,
            'aval_empresa' => $aval_empresa,
            'empresa' => $empresa,
            'acuerdo_no_confidencialidad' => $acuerdo_no_confidencialidad,
            'fecha_acuerdo_no_confidencialidad' => $fecha_acuerdo_no_confidencialidad
        ];
    }

    public function Store($request)
    {
        DB::beginTransaction();
        try {
            
            $valoresCondicionales = $this->valoresCondicionales($request);
            $empresa_id = null;
            // dd($request->input('txtnit_empresa'));
            if ($request->input('txtidea_empresa') == 1) {
                $empresa_detalle = Empresa::where('nit', $request->input('txtnit'))->first();
                if ($empresa_detalle == null) {
                    // Registro de una nueva empresa
                    $entidad = Entidad::create([
                        'ciudad_id'     => $request->input('txtciudad_id_empresa'),
                        'nombre'        => $request->input('txtnombre_empresa'),
                        'slug'          => str_slug($request->input('txtnombre_empresa') . str_random(7), '-'),
                        'email_entidad' => $request->input('txtemail_entidad'),
                        ]);
                        
                    $empresa = Empresa::create([
                        'entidad_id' => $entidad->id,
                        'sector_id'  => $request->input('txtsector_empresa'),
                        'nit'        => $request->input('txtnit_empresa'),
                        'direccion'  => $request->input('txtdireccion_empresa'),
                        'tipoempresa_id'  => $request->input('txttipoempresa_id_empresa'),
                        'tamanhoempresa_id'  => $request->input('txttamanhoempresa_id_empresa'),
                        'fecha_creacion'  => $request->input('txtfecha_creacion_empresa'),
                        'codigo_ciiu'  => $request->input('txtcodigo_ciiu_empresa'),
                        ]);
                        $empresa_id = $empresa->id;
                } else {
                        $empresa_id = $empresa_detalle->id;
                }
            }
            // dd($empresa_id);
        
            $codigo_idea = $this->generarCodigoIdea($request->input('txtnodo'));
        
            $idea = Idea::create([
                "nombre_proyecto" => $request->input('txtnombre_proyecto'),
                "descripcion" => $request->input('txtdescripcion'),
                "producto_parecido" => $valoresCondicionales['producto_parecido'],
                "si_producto_parecido" => $valoresCondicionales['si_producto_parecido'],
                "reemplaza" => $valoresCondicionales['reemplaza'],
                "si_reemplaza" => $valoresCondicionales['si_reemplaza'],
                "pregunta1" => $request->input('pregunta1'),
                "problema" => $request->input('txtproblema'),
                "necesidades" => $request->input('txtnecesidades'),
                "quien_compra" => $request->input('txtquien_compra'),
                "quien_usa" => $request->input('txtquien_usa'),
                "distribucion" => $request->input('txtdistribucion'),
                "quien_entrega" => $request->input('txtquien_entrega'),
                "packing" => $valoresCondicionales['packing'],
                "tipo_packing" => $valoresCondicionales['tipo_packing'],
                "medio_venta" => $request->input('txtmedio_venta'),
                "valor_clientes" => $request->input('txtvalor_clientes'),
                "pregunta2" => $request->input('pregunta2'),
                "requisitos_legales" => $valoresCondicionales['requisitos_legales'],
                "si_requisitos_legales" => $valoresCondicionales['si_requisitos_legales'],
                "requiere_certificaciones" => $valoresCondicionales['requiere_certificaciones'],
                "si_requiere_certificaciones" => $valoresCondicionales['si_requiere_certificaciones'],
                "forma_juridica" => $request->input('txtforma_juridica'),
                "version_beta" => $request->input('txtversion_beta'),
                "cantidad_prototipos" => $request->input('txtcantidad_prototipos'),
                "recursos_necesarios" => $valoresCondicionales['recursos_necesarios'],
                "si_recursos_necesarios" => $valoresCondicionales['si_recursos_necesarios'],
                "nodo_id" => $request->input('txtnodo'),
                "pregunta3" => $request->input('pregunta3'),
                "viene_convocatoria" => $valoresCondicionales['viene_convocatoria'],
                "convocatoria" => $valoresCondicionales['convocatoria'],
                "aval_empresa" => $valoresCondicionales['aval_empresa'],
                "empresa" => $valoresCondicionales['empresa'],
                "codigo_idea" => $codigo_idea,
                "tipo_idea" => Idea::IsEmprendedor(),
                "estadoidea_id" => EstadoIdea::where('nombre', '=', EstadoIdea::IsRegistro())->first()->id,
                "talento_id" => auth()->user()->talento->id,
                "empresa_id" => $empresa_id,
                "acuerdo_no_confidencialidad" => $valoresCondicionales['acuerdo_no_confidencialidad'],
                "fecha_acuerdo_no_confidencialidad" => $valoresCondicionales['fecha_acuerdo_no_confidencialidad']
            ]);
        
            if ($request->input('txtlinkvideo') != null) {
                $idea->rutamodel()->create([
                    'ruta' => $request->input('txtlinkvideo'),
                ]);
            }

            // event(new IdeaHasReceived($idea));
            // Busca los articuladores del nodo
            $users = User::infoUserRole(['Infocenter'], ['infocenter', 'infocenter.nodo'])->whereHas(
                'infocenter.nodo',
                function ($query) use ($idea) {
                    $query->where('id', $idea->nodo_id);
                }
            )->get();
            // Envia un correo a los articuladores del nodo
            // if (!$users->isEmpty()) {
            //     Notification::send($users, new IdeaReceived($idea));
            // }

            DB::commit();
            return true;
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return false;
        }

    }

    public function enviarIdeaAlNodo($request, $idea)
    {
        DB::beginTransaction();
        try {
            
            // Cambia el estado de la idea
            $idea->update(['estadoidea_id' => EstadoIdea::where('nombre', EstadoIdea::IsPostulado())->first()->id]);
            //Enviar correo al talento que inscribió la idea de proyecto
            event(new IdeaHasReceived($idea));
            // Busca los articuladores del nodo
            $users = User::infoUserRole(['Articulador'], ['gestor', 'gestor.nodo'])->whereHas(
                'gestor.nodo',
                function ($query) use ($idea) {
                    $query->where('id', $idea->nodo_id);
                }
            )->get();
            // Envia un correo a los articuladores del nodo
            if (!$users->isEmpty()) {
                Notification::send($users, new IdeaReceived($idea));
            }
            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
    }

    public function Update($request, $idea)
    {
        DB::beginTransaction();
        try {
            $valoresCondicionales = $this->valoresCondicionales($request);

            $empresa_id = null;
            // dd($request->input('txtnit_empresa'));
            if ($request->input('txtidea_empresa') == 1) {
                $empresa_detalle = Empresa::where('nit', $request->input('txtnit'))->first();
                if ($empresa_detalle == null) {
                    // Registro de una nueva empresa
                    $entidad = Entidad::create([
                        'ciudad_id'     => $request->input('txtciudad_id_empresa'),
                        'nombre'        => $request->input('txtnombre_empresa'),
                        'slug'          => str_slug($request->input('txtnombre_empresa') . str_random(7), '-'),
                        'email_entidad' => $request->input('txtemail_entidad'),
                        ]);
                        
                    $empresa = Empresa::create([
                        'entidad_id' => $entidad->id,
                        'sector_id'  => $request->input('txtsector_empresa'),
                        'nit'        => $request->input('txtnit_empresa'),
                        'direccion'  => $request->input('txtdireccion_empresa'),
                        'tipoempresa_id'  => $request->input('txttipoempresa_id_empresa'),
                        'tamanhoempresa_id'  => $request->input('txttamanhoempresa_id_empresa'),
                        'fecha_creacion'  => $request->input('txtfecha_creacion_empresa'),
                        'codigo_ciiu'  => $request->input('txtcodigo_ciiu_empresa'),
                        ]);
                        $empresa_id = $empresa->id;
                } else {
                        $empresa_id = $empresa_detalle->id;
                }
            }

            $idea->update([
                "nombre_proyecto" => $request->input('txtnombre_proyecto'),
                "descripcion" => $request->input('txtdescripcion'),
                "producto_parecido" => $valoresCondicionales['producto_parecido'],
                "si_producto_parecido" => $valoresCondicionales['si_producto_parecido'],
                "reemplaza" => $valoresCondicionales['reemplaza'],
                "si_reemplaza" => $valoresCondicionales['si_reemplaza'],
                "pregunta1" => $request->input('pregunta1'),
                "problema" => $request->input('txtproblema'),
                "necesidades" => $request->input('txtnecesidades'),
                "quien_compra" => $request->input('txtquien_compra'),
                "quien_usa" => $request->input('txtquien_usa'),
                "distribucion" => $request->input('txtdistribucion'),
                "quien_entrega" => $request->input('txtquien_entrega'),
                "packing" => $valoresCondicionales['packing'],
                "tipo_packing" => $valoresCondicionales['tipo_packing'],
                "medio_venta" => $request->input('txtmedio_venta'),
                "valor_clientes" => $request->input('txtvalor_clientes'),
                "pregunta2" => $request->input('pregunta2'),
                "requisitos_legales" => $valoresCondicionales['requisitos_legales'],
                "si_requisitos_legales" => $valoresCondicionales['si_requisitos_legales'],
                "requiere_certificaciones" => $valoresCondicionales['requiere_certificaciones'],
                "si_requiere_certificaciones" => $valoresCondicionales['si_requiere_certificaciones'],
                "forma_juridica" => $request->input('txtforma_juridica'),
                "version_beta" => $request->input('txtversion_beta'),
                "cantidad_prototipos" => $request->input('txtcantidad_prototipos'),
                "recursos_necesarios" => $valoresCondicionales['recursos_necesarios'],
                "si_recursos_necesarios" => $valoresCondicionales['si_recursos_necesarios'],
                "nodo_id" => $request->input('txtnodo'),
                "pregunta3" => $request->input('pregunta3'),
                "viene_convocatoria" => $valoresCondicionales['viene_convocatoria'],
                "convocatoria" => $valoresCondicionales['convocatoria'],
                "aval_empresa" => $valoresCondicionales['aval_empresa'],
                "empresa" => $valoresCondicionales['empresa'],
                "empresa_id" => $empresa_id,
                "acuerdo_no_confidencialidad" => $valoresCondicionales['acuerdo_no_confidencialidad'],
                "fecha_acuerdo_no_confidencialidad" => $valoresCondicionales['fecha_acuerdo_no_confidencialidad']
            ]);
            if ($request->input('txtlinkvideo') != null) {
                if ($idea->rutamodel == null) {
                    $idea->rutamodel()->create([
                        'ruta' => $request->input('txtlinkvideo'),
                    ]);
                } else {
                    $idea->rutamodel()->update([
                        'ruta' => $request->input('txtlinkvideo'),
                    ]);
                }
            }
            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollback();
            return false;
        }
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
        return Idea::find($id);
        // return Idea::where('id', $id)->first();
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
