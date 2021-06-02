<?php

namespace App\Http\Requests\ArticulacionPbt;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class ArticulacionFaseCierreFormRequest extends FormRequest
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
            'txttipopostulacion' => 'required',
            // 'txtpdfjustificado'   =>  Rule::requiredIf(request()->txttipopostulacion == "no") .'|nullable',
            'txtjustificacion'    =>  Rule::requiredIf(request()->txttipopostulacion == "no" ) . '|min:1|max:3500|nullable',
            'txtaprobacion'    =>  Rule::requiredIf(request()->txttipopostulacion == "si" ) . '|nullable',
            'txtrecibira'    =>  Rule::requiredIf(request()->txttipopostulacion == "si" && request()->txtaprobacion == "aprobado") . '|min:1|max:191|nullable',
            'txtcuando'    =>  Rule::requiredIf(request()->txttipopostulacion == "si" && request()->txtaprobacion == "aprobado") . '|date|date_format:Y-m-d|nullable|after_or_equal:' . date('Y-m-d'),
            // 'txtpdfaprobacion'    =>  Rule::requiredIf(request()->txttipopostulacion == "si" && request()->txtaprobacion == "aprobado") . '|nullable',
            // 'txtdoc_postulacion1'    =>  Rule::requiredIf(request()->txttipopostulacion == "si" && request()->txtaprobacion == "aprobado") . '|nullable',
            // 'txtinforme'    =>  Rule::requiredIf(request()->txttipopostulacion == "si" && request()->txtaprobacion == "noaprobado") . '|nullable',
            // 'txtpdfnoaprobacion'    =>  Rule::requiredIf(request()->txttipopostulacion == "si" && request()->txtaprobacion == "noaprobado") . '|nullable',
            // 'txtdoc_postulacion'    =>  Rule::requiredIf(request()->txttipopostulacion == "si" && request()->txtaprobacion == "noaprobado") . '|nullable',
            'txtlecciones'    =>   'required|min:1|max:3500',
        ];
    }

    public function messages()
    {
        return $messages = [
        
            'txttipopostulacion.required' => 'El campo se realizó la postulación es obligatorio.',
            'txtpdfjustificado.required' => 'El campo PDF justificativo firmado por el Talento es obligatorio.',
            'txtjustificacion.required' => 'El campo justificación es obligatorio.',
            'txtjustificacion.min'     => 'El campo justificación debe ser minimo 1 caracter',
            'txtjustificacion.max'     => 'El campo justificación debe ser máximo 3500 caracteres',
            'txtjustificacion.required' => 'El tipo de articulación es obligatoria.',

            'txtaprobacion.required' => 'El campo postulación es obligatorio.',
            'txtrecibira.required' => 'El campo postulación es obligatorio.',
            'txtrecibira.min'     => 'El campo qué recibirá debe ser minimo 1 caracter',
            'txtrecibira.max'     => 'El campo qué recibirá debe ser máximo 191 caracteres',

            'txtcuando.required' => 'El campo cuando es obligatorio.',
            'txtcuando.date'            => 'El valor ingresado no es una fecha válida.',
            'txtcuando.after_or_equal' => 'El valor ingresado  debe ser una fecha posterior o igual a la actual',

            'txtpdfaprobacion.required' => 'El campo PDF de aprobación es obligatorio.',
            'txtdoc_postulacion1.required' => 'El campo PDF de documentos de postulación es obligatorio.',

            'txtpdfnoaprobacion.required' => 'El campo PDF de no aprobación es obligatorio.',
            'txtdoc_postulacion.required' => 'El campo PDF de documentos de postulación es obligatorio.',

            'txtlecciones.required' => 'El campo lecciones aprendidas es obligatorio.',
            'txtlecciones.min'     => 'El campo lecciones aprendidas debe ser minimo 1 caracter',
            'txtlecciones.max'     => 'El campo lecciones aprendidas debe ser máximo 3500 caracteres',
           
        ];
    }
}