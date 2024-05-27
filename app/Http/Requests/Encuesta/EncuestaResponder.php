<?php

namespace App\Http\Requests\Encuesta;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EncuestaResponder extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'estado_proyecto' => 'required',
            'afinidad_proyecto' => 'required',
            'infocenter_amabilidad' => Rule::requiredIf(isset(request()->conoce_infocenter)),
            'infocenter_conocimiento' => Rule::requiredIf(isset(request()->conoce_infocenter)),
            'dinamizador_amabilidad' => Rule::requiredIf(isset(request()->conoce_dinamizador)),
            'dinamizador_conocimiento' => Rule::requiredIf(isset(request()->conoce_dinamizador)),
            'articulador_amabilidad' => Rule::requiredIf(isset(request()->conoce_articulador)),
            'articulador_conocimiento' => Rule::requiredIf(isset(request()->conoce_articulador)),
            'disposicion_personal' => 'required',
            // Likert 1
            'acompanamiento_comite' => 'required',
            'desarrollo_comite' => 'required',
            'asignacion_experto' => 'required',
            'inscripcion_plataforma' => 'required',
            'uso_plataforma' => 'required',
            // Likert 2
            'conocimiento_experto' => 'required',
            'experto_ayuda_objetivos' => 'required',
            'experto_cumple_cronograma' => 'required',
            'experto_hace_seguimiento' => 'required',
            'experto_presenta_recursos' => 'required',
            'experto_entrega_documentos' => 'required',
            'experto_acompana' => 'required',
            // Likert 3
            'infraestructura_acorde_necesidades' => 'required',
            'infraestructura_disponibilidad' => 'required',
            'materiales_disponibilidad' => 'required',
            //
            'acompanamiento_articulador' => 'required',
            // Likert 4
            'articulacion_alcanza_proposito' => Rule::requiredIf(request()->acompanamiento_articulador == 'Sí lo necesitaba y recibí acompañamiento en mi proyecto' || request()->acompanamiento_articulador == 'Si lo necesitaba, pero no recibí atención por parte de articulador a pesar de solicitarlo'),
            'articulacion_fue_fundamental' => Rule::requiredIf(request()->acompanamiento_articulador == 'Sí lo necesitaba y recibí acompañamiento en mi proyecto' || request()->ampanamiento_articulador == 'Si lo necesitaba, pero no recibí atención por parte de articulador a pesar de solicitarlo'),
            'articulador_es_capaz' => Rule::requiredIf(request()->acompanamiento_articulador == 'Sí lo necesitaba y recibí acompañamiento en mi proyecto' || request()->ampanamiento_articulador == 'Si lo necesitaba, pero no recibí atención por parte de articulador a pesar de solicitarlo'),
            'articulador_hace_seguimiento' => Rule::requiredIf(request()->acompanamiento_articulador == 'Sí lo necesitaba y recibí acompañamiento en mi proyecto' || request()->ampanamiento_articulador == 'Si lo necesitaba, pero no recibí atención por parte de articulador a pesar de solicitarlo'),
            'articulador_presenta_recursos' => Rule::requiredIf(request()->acompanamiento_articulador == 'Sí lo necesitaba y recibí acompañamiento en mi proyecto' || request()->mpanamiento_articulador == 'Si lo necesitaba, pero no recibí atención por parte de articulador a pesar de solicitarlo'),
            'articulador_demuestra_acompanamiento' => Rule::requiredIf(request()->acompanamiento_articulador == 'Sí lo necesitaba y recibí acompañamiento en mi proyecto' || request()->ampanamiento_articulador == 'Si lo necesitaba, pero no recibí atención por parte de articulador a pesar de solicitarlo'),
            //
            'con_quien_comparte' => Rule::requiredIf(isset(request()->comparte_credenciales)),
            'motivo_compartir_credenciales' => Rule::requiredIf(isset(request()->comparte_credenciales)) . '|max:100',
            'motivo_no_logrado' => Rule::requiredIf(!isset(request()->alcanza_objetivos)) . '|max:100',
            'aspectos_a_mejorar' => 'required|max:100',
            'como_conoce_tecnoparque' => 'required',
            'uso_otros_servicios' => Rule::requiredIf(isset(request()->usa_otros_servicios)),
            'otros_servicios' => Rule::requiredIf(isset(request()->usa_otros_servicios) && request()->uso_otros_servicios == 'Otras'),
        ];
    }

    public function messages()
    {
        return [
            'estado_proyecto.required' => 'El estado del proyecto es obligatorio.',
            'afinidad_proyecto.required' => 'Debe elegir una opción más afín a las características de su proyecto.',
            'infocenter_amabilidad.required' => 'Debe puntuar la amabilidad con la cuál fue atendido por Infocenter.',
            'infocenter_conocimiento.required' => 'Debe puntuar el conocimiento demostrado por Infocenter.',
            'dinamizador_amabilidad.required' => 'Debe puntuar la amabilidad con la cuál fue atendido por Dinamizador@.',
            'dinamizador_conocimiento.required' => 'Debe puntuar el conocimiento demostrado por Dinamizador@.',
            'articulador_amabilidad.required' => 'Debe puntuar la amabilidad con la cuál fue atendido por Articulador@.',
            'articulador_conocimiento.required' => 'Debe puntuar el conocimiento demostrado por Articulador@.',
            'disposicion_personal.required' => 'Debe puntuar la disposición del talento humano del Tecnoparque en general para atender sus inquietudes.',
            // Likert 1
            'acompanamiento_comite.required' => 'Debe calificar si se sintió acompañado y asesorado para enfrentar el Comité de Ideas.',
            'desarrollo_comite.required' => 'Debe calificar si el Comité de Ideas se desarrolló oportunamente.',
            'asignacion_experto.required' => 'Debe calificar si la asignación del experto se dió de manera ágil luego del Comité de Ideas.',
            'inscripcion_plataforma.required' => 'Debe calificar si la inscripción en el sistema de información se hizo de manera sencilla.',
            'uso_plataforma.required' => 'Debe calificar si el sistema de información le pareció fácil e intuitivo de usar.',
            // Likert 2
            'conocimiento_experto.required' => 'Debe calificar si el experto demuestra conocimiento y experiencia en acompañamiento para el desarrollo de proyectos.',
            'experto_ayuda_objetivos.required' => 'Debe calificar si el acompañamiento del experto ayudó a lograr los objetivos propuestos.',
            'experto_cumple_cronograma.required' => 'Debe calificar si el experto cumple con el cronograma de las actividades planeadas y concertadas previamente.',
            'experto_hace_seguimiento.required' => 'Debe calificar si el experto realiza seguimiento a las actividades que me han sido asignadas como Talento.',
            'experto_presenta_recursos.required' => 'Debe calificar si el experto presenta recursos y ayudas para el desarrollo del proyecto.',
            'experto_entrega_documentos.required' => 'Debe calificar si el experto entrega documentos de seguimiento en el desarrollo del proyecto de manera oportuna y eficiente.',
            'experto_acompana.required' => 'Debe calificar si el experto demuestra calidad, responsabilidad, puntualidad y motivación en el acompañamiento del proyecto.',
            // Likert 3
            'infraestructura_acorde_necesidades.required' => 'Debe calificar si la infraestructura tecnológica del Tecnoparque es acorde a las necesidades de desarrollo del proyecto.',
            'infraestructura_disponibilidad.required' => 'Debe calificar si la disponibilidad física adecuada en el Tecnoparque para el desarrollo del proyecto.',
            'materiales_disponibilidad.required' => 'Debe calificar si los materiales utilizados estuvieron disponibles y me ayudaron en el logro del proyecto.',
            //
            'acompanamiento_articulador.required' => 'Debe indicar si recibió acompañamiento por parte del Articulador del Tecnoparque.',
            // Likert 4
            'articulacion_alcanza_proposito.required' => 'Debe indicar si la articulación realizada alcanzó el propósito que buscaba.',
            'articulacion_fue_fundamental.required' => 'Debe indicar si la articulación ha sido fundamental para darle mayor alcance al proyecto.',
            'articulador_es_capaz.required' => 'Debe indicar si el articulador demuestra conocimiento y experiencia frente a la convocatoria y/o actor articulado.',
            'articulador_hace_seguimiento.required' => 'Debe indicar si el articulador realiza seguimiento a las actividades que me han sido asignadas como Talento.',
            'articulador_presenta_recursos.required' => 'Debe indicar si el articulador presenta recursos y ayudas para el desarrollo de la articulación requerida',
            'articulador_demuestra_acompanamiento.required' => 'Debe indicar si el articulador demuestra calidad, responsabilidad, puntualidad y motivación en el acompañamiento del proyecto.',
            //
            'con_quien_comparte.required' => 'Debe indicar con quién tuvo que compartir su clave Tecnoparque.',
            'motivo_compartir_credenciales.required' => 'Debe indicar los motivo por lo que tuvo que compartir su clave Tecnoparque.',
            'motivo_compartir_credenciales.max' => 'Los motivos por lo que tuvo que compartir su clave Tecnoparque no deben ser mayores a :max carácteres',
            'motivo_no_logrado.required' => 'Debe indicar de manera breve el por qué no se logró alcanzar los objetivos previstos en el desarrollo y finalización de su proyecto',
            'motivo_no_logrado.max' => 'Los motivos del por qué no se logró alcanzar los objetivos previstos en el desarrollo y finalización de su proyecto no deben ser mayores a :max carácteres',
            'aspectos_a_mejorar.required' => 'Debe indicar si el Tecnoparque tiene aspectos a mejorar.',
            'aspectos_a_mejorar.max' => 'Los aspectos a mejorar del tecnoparque no deben ser mayores a :max carácteres',
            'como_conoce_tecnoparque.required' => 'Debe indicar como se enteró de la Red Tecnoparque Colombia',
            'uso_otros_servicios.required' => 'Debe indicar que otros servicios usó para el desarrollo del proyecto',
            'otros_servicios.required' => 'Debe indicar que otro servicios usó para el desarrollo del proyecto',
        ];
    }
}
