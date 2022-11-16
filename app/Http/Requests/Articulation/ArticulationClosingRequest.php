<?php

namespace App\Http\Requests\Articulation;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ArticulationClosingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'postulation' => 'required',
            'justified_report'    =>  Rule::requiredIf(request()->postulation == "no" ) . '|nullable',
            'justification'    =>  Rule::requiredIf(request()->postulation == "no" ) . '|min:1|max:3500|nullable',
            'approval'    =>  Rule::requiredIf(request()->postulation == "yes" ) . '|nullable',
            'receive'    =>  Rule::requiredIf(request()->postulation == "yes" && request()->approval == "aprobado") . '|min:1|max:191|nullable',
            'received_date'    =>  Rule::requiredIf(request()->postulation == "yes" && request()->approval == "aprobado") . '|date|date_format:Y-m-d|nullable|after_or_equal:' . date('Y-m-d'),
            'approval_document'    =>   Rule::requiredIf(request()->postulation == "yes" && request()->approval == "aprobado") . '|nullable',
            'non_approval_document'    =>   Rule::requiredIf(request()->postulation == "yes" && request()->approval == "noaprobado") . '|nullable',
            'postulation_document'    =>   Rule::requiredIf(request()->postulation == "yes" && request()->approval == "noaprobado") . '|nullable',
            'report'    =>   Rule::requiredIf(request()->postulation == "yes" && request()->approval == "noaprobado") . '|min:1|max:3500|nullable',
            'learned_lessons'    =>   'required|min:1|max:3500',
        ];
    }

    public function messages()
    {
        return $messages = [
            'postulation.required' => 'El campo se realizó la postulación es obligatorio.',
            'justified_report.required' => 'El campo PDF justificativo firmado por el Talento es obligatorio.',
            'justification.required' => 'El campo justificación es obligatorio.',
            'justification.min'     => 'El campo justificación debe ser minimo 1 caracter',
            'justification.max'     => 'El campo justificación debe ser máximo 3500 caracteres',

            'approval.required' => 'El campo es obligatorio.',
            'receive.required' => 'El campo postulación es obligatorio.',
            'receive.min'     => 'El campo qué recibirá debe ser minimo 1 caracter',
            'receive.max'     => 'El campo qué recibirá debe ser máximo 191 caracteres',

            'received_date.required' => 'El campo cuando es obligatorio.',
            'received_date.date'            => 'El valor ingresado no es una fecha válida.',
            'received_date.after_or_equal' => 'El valor ingresado  debe ser una fecha posterior o igual a la actual',

            'approval_document.required' => 'El campo PDF de aprobación es obligatorio.',
            'postulation_document.required' => 'El campo PDF de documentos de postulación es obligatorio.',

            'non_approval_document.required' => 'El campo PDF de no aprobación es obligatorio.',

            'report.required' => 'El campo informe es obligatorio.',
            'report.min'     => 'El campo informe debe ser minimo 1 caracter',
            'report.max'     => 'El campo informe debe ser máximo 3500 caracteres',

            'learned_lessons.required' => 'El campo lecciones aprendidas es obligatorio.',
            'learned_lessons.min'     => 'El campo lecciones aprendidas debe ser minimo 1 caracter',
            'learned_lessons.max'     => 'El campo lecciones aprendidas debe ser máximo 3500 caracteres',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'learned_lessons' => 'lecciones aprendidas'
        ];
    }
}
