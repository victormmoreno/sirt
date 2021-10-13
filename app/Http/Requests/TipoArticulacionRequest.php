<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\TipoArticulacion;

class TipoArticulacionRequest extends FormRequest
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
            'txtnombre' => 'required|min:1|max:100',
            'txtdescripcion' => 'nullable|min:1|max:5000',
            'txtentidad' => 'nullable|min:1|max:100',
            // 'checkestado' =>'required',
            //'checkestado' => Rule::in([TipoArticulacion::mostrar(), TipoArticulacion::ocultar()]).'|required',
            'checknode' => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'txtnombre.required' => 'El campo nombre es obligatorio.',
            'txtnombre.min'    => 'El nombre debe ser de al menos :min caracter.',
            'txtnombre.max'    => 'El nombre no debe ser mayor a :max caracter(es)',
            'txtdescripcion.min'    => 'La descripción debe ser de al menos :min caracter.',
            'txtdescripcion.max'    => 'La descripción no debe ser mayor a :max caracter(es)',
            'txtentidad.min'    => 'La entidad debe ser de al menos :min caracter.',
            'txtentidad.max'    => 'La entidad no debe ser mayor a :max caracter(es)',
            'checkestado.required'    => 'Selecciona un estado',
            'checknode.required'    => 'Selecciona por lo menos un nodo',
        ];
    }
}
