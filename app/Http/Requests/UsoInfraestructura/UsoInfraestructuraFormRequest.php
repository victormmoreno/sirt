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
            'txtfecha'                  => 'required|date_format:"Y-m-d"',
            'txtlinea'                  => 'required',

            'txttipousoinfraestructura' => 'required',
            'txtactividad'              => 'required',
            'txtdescripcion'            => 'nullable|max:2000',
            'txtasesoriadirecta'        => 'nullable|numeric|min:0|max:99|between:0,99.9',
            'txtasesoriaindirecta'      => 'nullable|numeric|min:0|max:99|between:0,99.9',

            'txttiempouso'      => 'nullable|numeric|min:0|max:99|between:0,99.9',
            'txtcantidad'      => 'nullable|numeric|min:0|max:99|between:0,99.9',
            

        ];
    }

    public function messages()
    {
        return $messages = [
            'txtfecha.required'                  => 'La fecha es obligatoria',
            'txtfecha.date_format'               => 'La fecha debe tener un formato de Y-m-d',
            'txtlinea.required'                  => 'La linea tecnológica es obligatoria',
            'txtgestor.required'                 => 'El gestor es obligatorio',
            'txttipousoinfraestructura.required' => 'por favor seleccione el tipo de uso de infraestructura',
            'txtactividad.required'              => 'El proyecto ó la articulación o la edt es obligatoria',
            'txtdescripcion.max'                 => 'La descripcion debe tener máximo 2000 caracteres',
            'txtasesoriadirecta.numeric'         => 'La asesoria directa debe ser un valor numérico',
            'txtasesoriadirecta.min'             => 'La asesoria directa debe ser un valor numérico igual o mayor a 0.',
            'txtasesoriadirecta.max'             => 'La asesoria directa debe ser un valor numérico igual o menor a 99.',
            'txtasesoriadirecta.between'         => 'La asesoria directa debe ser un valor numérico 0 y 99.9',
            'txtasesoriaindirecta.numeric'       => 'La asesoria directa debe ser un valor numérico',
            'txtasesoriaindirecta.min'           => 'La asesoria directa debe ser un valor numérico igual o mayor a 0.',
            'txtasesoriaindirecta.max'           => 'La asesoria directa debe ser un valor numérico igual o menor a 99.',
            'txtasesoriaindirecta.between'       => 'La asesoria directa debe ser un valor numérico entre 0 y 99.9',

            'txttiempouso.numeric'         => 'El tiempo de uso debe ser un valor numérico',
            'txttiempouso.min'             => 'El tiempo de uso debe ser un valor numérico igual o mayor a 0.',
            'txttiempouso.max'             => 'El tiempo de uso debe ser un valor numérico igual o menor a 99.',
            'txttiempouso.between'         => 'El tiempo de uso debe ser un valor numérico 0 y 99.9',

            'txtcantidad.numeric'         => 'La cantidad debe ser un valor numérico',
            'txtcantidad.min'             => 'La cantidad debe ser un valor numérico igual o mayor a 0.',
            'txtcantidad.max'             => 'La cantidad debe ser un valor numérico igual o menor a 99.',
            'txtcantidad.between'         => 'La cantidad debe ser un valor numérico 0 y 99.9',
        ];
    }
}
