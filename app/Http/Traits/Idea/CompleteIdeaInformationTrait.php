<?php

namespace App\Http\Traits\Idea;

use App\Models\{EstadoIdea, Sede, Idea};
// use App\Notifications\User\CompleteTalentInformation;
// use App\Values\TalentStorageValues;
use Illuminate\Http\Request;
use Carbon\Carbon;
// use Illuminate\Support\Str;

trait CompleteIdeaInformationTrait
{
    public function buildStorageRecord(Request $request) {
        return [
            'datos_idea' => [
                'fecha_acuerdo_no_confidencialidad' => isset($request->check_acuerdo_no_confidencialidad) ? Carbon::now() : null,
                'nombre_proyecto' => $request->txt_nombre_proyecto,
                'descripcion' => $request->txt_descripcion,
                'producto_parecido' => isset($request->txt_producto_parecido) ? $request->txt_si_producto_parecido : 'No',
                'reemplaza' => isset($request->check_reemplaza) ? $request->txt_si_reemplaza : 'No',
                'producto_minimo_viable' => isset($request->check_producto_minimo_viable) ? 1 : 0,
                'ha_realizado_pruebas' => isset($request->check_ha_realizado_pruebas) ? 1 : 0,
                'pregunta1' => $request->radio_pregunta1,
                'modelo_negocio_definido' => isset($request->check_modelo_negocio_definido) ? 1 : 0,
                'quien_usa' => $request->txt_quien_usa,
                'necesidades' => $request->txt_necesidades,
                'problema' => $request->txt_problema,
                'tipo_packing' => isset($request->check_packing) ? 1 : 0,
                'estrategia_fijar_precio' => isset($request->check_estrategia_fijar_precio) ? 1 : 0,
                'recursos_necesarios' => isset($request->check_recursos_necesarios) ? 1 : 0,
                'ha_generado_ventas' => isset($request->check_ha_generado_ventas) ? 1 : 0,
                'apoyo_requerido' => $request->radio_apoyo_requerido,
                'pregunta2' => $request->radio_pregunta2,
                'requisitos_legales' => isset($request->check_requisitos_legales) ? $request->txt_si_requisitos_legales : 'No',
                'requiere_certificaciones' => isset($request->check_requiere_certificaciones) ? $request->txt_si_requiere_certificaciones : 'No',
                'pretende_forma_juridica' => isset($request->check_forma_juridica) ? 1 : 0,
                'link_video' => $request->txt_link_video,
                'version_beta' => $request->radio_version_beta,
                'cantidad_prototipos' => $request->txt_cantidad_prototipos,
                'pregunta3' => $request->radio_pregunta3,
                'convocatoria' => isset($request->check_viene_convocatoria) ? $request->txt_convocatoria : 'No',
                'empresa' => isset($request->check_aval_empresa) ? $request->txt_empresa : 'No',
            ],
            'nodo_id' => $request->slct_nodo,
            'estadoidea_id' => EstadoIdea::where('nombre', '=', EstadoIdea::IsRegistro())->first()->id,
            // 'sede_id' => $this->buildSedeIdea($request),
            'sede_id' => null,
            'codigo_idea' => $this->buildCodigoIdea($request->slct_nodo)
        ];
        // Este fragmento debe ir al final del registro en Contract/Idea/IdeaStorage
        // if ($request->input('txtlinkvideo') != null) {
        //     $idea->rutamodel()->create([
        //         'ruta' => $request->input('txtlinkvideo'),
        //     ]);
        // }
    }

    public function buildSedeIdea(Request $request) {
        $sede_id = null;
        if ($request->txtidea_empresa == 1) {
            $sede_detalle = Sede::find($request->input('txtsede_id'));
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