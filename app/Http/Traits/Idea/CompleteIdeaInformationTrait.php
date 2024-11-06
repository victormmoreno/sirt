<?php

namespace App\Http\Traits\Idea;

use App\Models\{EstadoIdea, Sede, Idea};
use Illuminate\Http\Request;
use Carbon\Carbon;

trait CompleteIdeaInformationTrait
{
    public function buildStorageRecord(Request $request, Idea $idea = null) {
        return [
            'datos_idea' => [
                'fecha_acuerdo_no_confidencialidad' => [
                    'answer' => isset($request->check_acuerdo_no_confidencialidad) ? Carbon::now() : null,
                    'label' => 'Fecha de aceptación de acuerdo de no confidencialidad de la idea de proyecto'
                ],
                'nombre_proyecto' => [
                    'answer' => $request->txt_nombre_proyecto,
                    'label' => 'Nombre de la idea de proyecto'
                ],
                'descripcion' => [
                    'answer' => $request->txt_descripcion,
                    'label' => 'Describa de forma concisa y clara de que trata su idea de emprendimiento, ¿qué productos o servicios va a ofertar?'
                ],
                'producto_parecido' => [
                    'answer' => isset($request->check_producto_parecido) ? $request->txt_si_producto_parecido : 'No',
                    'label' => '¿Conoce una solución, producto, servicio o desarrollo parecido que actualmente esté disponible en el país o su región?'
                ],
                'reemplaza' => [
                    'answer' => isset($request->check_reemplaza) ? $request->txt_si_reemplaza : 'No',
                    'label' => '¿La solución, producto o servicio reemplaza a algún otro existente?'
                ],
                'producto_minimo_viable' => [
                    'answer' => isset($request->check_producto_minimo_viable) ? 1 : 0,
                    'label' => '¿Cuenta con producto mínimo viable?'
                ],
                'ha_realizado_pruebas' => [
                    'answer' => isset($request->check_ha_realizado_pruebas) ? 1 : 0,
                    'label' => '¿Ha realizado pruebas del producto o servicio con posibles clientes?'
                ],
                'pregunta1' => [
                    'answer' => $request->radio_pregunta1,
                    'label' => 'Estado actual la solución y/o idea de negocio'
                ],
                'modelo_negocio_definido' => [
                    'answer' => isset($request->check_modelo_negocio_definido) ? 1 : 0,
                    'label' => '¿Hay un modelo de negocio definido?'
                ],
                'quien_usa' => [
                    'answer' => $request->txt_quien_usa,
                    'label' => '¿Quién usará la solución, producto o servicio?'
                ],
                'necesidades' => [
                    'answer' => $request->txt_necesidades,
                    'label' => '¿Qué necesidades de los clientes satisfacemos?'
                ],
                'problema' => [
                    'answer' => $request->txt_problema,
                    'label' => '¿Qué problema de nuestros clientes (internos o externos) ayudamos a solucionar?'
                ],
                'tipo_packing' => [
                    'answer' => isset($request->check_packing) ? 1 : 0,
                    'label' => '¿El producto o servicio requiere algún tipo de empaque, embalaje o envase?'
                ],
                'estrategia_fijar_precio' => [
                    'answer' => isset($request->check_estrategia_fijar_precio) ? 1 : 0,
                    'label' => '¿Cuenta con una estrategia para fijar el precio de su producto o servicio?'
                ],
                'recursos_necesarios' => [
                    'answer' => isset($request->check_recursos_necesarios) ? 1 : 0,
                    'label' => '¿Cuenta con los recursos para la puesta en marcha del producto o servicio?'
                ],
                'ha_generado_ventas' => [
                    'answer' => isset($request->check_ha_generado_ventas) ? 1 : 0,
                    'label' => '¿El producto o servicio ha generado ventas?'
                ],
                'apoyo_requerido' => [
                    'answer' => $request->radio_apoyo_requerido,
                    'label' => '¿Ha identificado algún tipo de recurso y/o apoyo requerido para la escalabilidad de la idea?'
                ],
                'pregunta2' => [
                    'answer' => $request->radio_pregunta2,
                    'label' => '¿Cómo está conformado su equipo de trabajo?'
                ],
                'requisitos_legales' => [
                    'answer' => isset($request->check_requisitos_legales) ? $request->txt_si_requisitos_legales : 'No',
                    'label' => '¿Hay requisitos legales a considerar en los países en donde se va a vender?'
                ],
                'requiere_certificaciones' => [
                    'answer' => isset($request->check_requiere_certificaciones) ? $request->txt_si_requiere_certificaciones : 'No',
                    'label' => '¿La solución y/o idea de negocio requiere certificaciones o permisos especiales?'
                ],
                'pretende_forma_juridica' => [
                    'answer' => isset($request->check_forma_juridica) ? $request->txt_forma_juridica : 'No',
                    'label' => '¿Es de interés constituirse como persona natural o persona jurídica?'
                ],
                'link_video' => [
                    'answer' => $request->txt_link_video,
                    'label' => 'Link del video presentación de la idea de proyecto'
                ],
                'version_beta' => [
                    'answer' => $request->radio_version_beta,
                    'label' => '¿La solución, producto o servicio está aún en concepto o ya hay un prototipo o versión Beta?'
                ],
                'cantidad_prototipos' => [
                    'answer' => $request->txt_cantidad_prototipos,
                    'label' => '¿Cuáles y cuántos prototipos necesita desarrollar con la Red Tecnoparques?'
                ],
                'pregunta3' => [
                    'answer' => $request->radio_pregunta3,
                    'label' => '¿En qué categoría se clasifica su idea?'
                ],
                'convocatoria' => [
                    'answer' => isset($request->check_viene_convocatoria) ? $request->txt_convocatoria : 'No',
                    'label' => '¿Viene de una convocatoria?'
                ],
                'empresa' => [
                    'answer' => isset($request->check_aval_empresa) ? $request->txt_empresa : 'No',
                    'label' => '¿La idea está avalada por una entidad?'
                ],
            ],
            'nodo_id' => $request->slct_nodo,
            'estadoidea_id' => $idea == null ? EstadoIdea::where('nombre', '=', EstadoIdea::IsRegistro())->first()->id : $idea->estadoidea_id,
            // 'sede_id' => $this->buildSedeIdea($request),
            'sede_id' => $this->registrarEmpresaConIdea($request),
            'user_id' => $idea == null ? request()->user()->id : $idea->user_id,
            'codigo_idea' => $idea == null ? $this->buildCodigoIdea($request->slct_nodo) : $idea->codigo_idea
        ];
    }

    public function registrarEmpresaConIdea($request)
    {
        $sede_id = null;
        if ($request->check_idea_empresa == 1) {
            $sede_detalle = Sede::find($request->input('txt_sede_id'));
            // $sede_detalle = Empresa::where('nit', $request->input('txtnit'))->first();
            if ($sede_detalle == null) {
                // Registro de una nueva empresa
                $empresa = $this->empresaRepository->store($request);
                $sede_id = $empresa['sede']->id;
            } else {
                // Actualizar el responsable de la empresa en caso de que no se encuentre asociada a ningún usuario
                if ($sede_detalle->empresa->user_id == null) {
                    $sede_detalle->empresa->update(['user_id' => auth()->user()->id]);
                }
                $sede_id = $sede_detalle->id;
            }
        }
        return $sede_id;
    }

    public function buildSedeIdea(Request $request) {
        $sede_id = null;
        if ($request->check_idea_empresa == 1) {
            $sede_detalle = Sede::find($request->input('txt_sede_id'));
            if ($sede_detalle == null) {
                // Registro de una nueva empresa
                $empresa = $this->empresaRepository->store($request);
                $sede_id = $empresa['sede']->id;
            }
        }
        return $sede_id;
    }

    public function buildCodigoIdea(string $nodo) {
        $anho = Carbon::now()->isoFormat('YYYY');
        $tecnoparque = sprintf("%02d", $nodo);
        $user = sprintf("%05d", request()->user()->id);
        $id = Idea::selectRaw('MAX(id+1) AS max')->get()->last();
        $id->max == null ? $id->max = 1 : $id->max = $id->max;
        $id->max = sprintf("%04d", $id->max);
        $codigo_idea = 'I' . $anho . '-' . $tecnoparque . $user . '-' . $id->max;
        return $codigo_idea;
    }

    public function buildResponse(array $data)
    {
        // return "<span class='card-title primary-text center'>Información Talento</span>
        //         <div class='server-load row'>
        //             <div class='server-stat col s6 m4 l3'>
        //                 <p>".$data['talento']['tipo_talento']."</p>
        //                 <span>Tipo Talento</span>
        //             </div>
        //         </div>";
    }
}