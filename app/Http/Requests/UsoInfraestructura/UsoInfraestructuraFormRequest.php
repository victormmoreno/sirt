<?php

namespace App\Http\Requests\UsoInfraestructura;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UsoInfraestructuraFormRequest extends FormRequest
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
            'txtfecha' => 'required|date_format:"Y-m-d"',
            'txtlinea' => 'required',
            'txtgestor' => 'required',
            'txttipousoinfraestructura' => 'required',
            'txtproyecto' =>  Rule::requiredIf(request()->txttipousoinfraestructura == 0),
            'txtarticulacion' =>  Rule::requiredIf(request()->txttipousoinfraestructura == 1),
            'txtedt' =>  Rule::requiredIf(request()->txttipousoinfraestructura == 2),
            'txtdescripcion' => 'nullable|max:2000',
            'txtasesoriadirecta' => 'nullable|numeric|digits_between:1,4',
            'txtasesoriaindirecta' => 'nullable|numeric|digits_between:1,4',

        ];
    }

    public function messages()
    {
        return $messages = [
            'txtfecha.required' => 'La fecha es obligatoria',
            'txtfecha.date_format' => 'La fecha debe tener un formato de Y-m-d',
            'txtlinea.required' => 'La linea tecnológica es obligatoria',
            'txtgestor.required' => 'El gestor es obligatorio',
            'txttipousoinfraestructura.required' => 'por favor seleccione el tipo de uso de infraestructura',
            'txtproyecto.required' => 'Debe seleccionar un proyecto.',
            'txtarticulacion.required' => 'Debe seleccionar una articulación.',
            'txtedt.required' => 'Debe seleccionar una edt.',
            'txtdescripcion.max' => 'La descripcion debe tener máximo 2000 caracteres',
            'txtasesoriadirecta.numeric' => 'La asesoria directa debe ser un valor numérico',
            'txtasesoriadirecta.digits_between' => 'La asesoria directa debe ser un valor numérico entre 1 y 4 digitos',
            'txtasesoriaindirecta.numeric' => 'La asesoria directa debe ser un valor numérico',
            'txtasesoriaindirecta.digits_between' => 'La asesoria directa debe ser un valor numérico entre 1 y 4 digitos',
        ];
    }
}
