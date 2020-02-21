<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProyectoFaseCierreFormRequest extends FormRequest
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
            'trl_obtenido' => 'required',
            'txtconclusiones' => 'required|max:1000',
            'txttrl_prototipo' => 'required|max:300',
            'txttrl_pruebas' => 'required|max:300',
            'txttrl_modelo' => 'required|max:300',
            'txttrl_normatividad' => 'required|max:300'
        ];
    }

    public function messages()
    {
        return $messages = [
            'trl_obtenido.required' => 'El trl obtenido es obligatorio.',
            'txtconclusiones.required' => 'Las conclusiones y siguiente paso del proyecto es obligatorio.',
            'txtconclusiones.max' => 'Las conclusiones y siguiente paso del proyecto debe ser máximo de 1000 carácteres.',
            'txttrl_prototipo.required' => 'La evidencia de prototipo del proyecto es obligatoria.',
            'txttrl_prototipo.max' => 'La evidencia de prototipo del proyecto debe ser máximo de 300 carácteres.',
            'txttrl_pruebas.required' => 'La evidencia de pruebas del proyecto es obligatoria.',
            'txttrl_pruebas.max' => 'La evidencia de pruebas del proyecto debe ser máximo de 300 carácteres.',
            'txttrl_modelo.required' => 'La evidencia de modelo de negocio del proyecto es obligatoria.',
            'txttrl_modelo.max' => 'La evidencia de modelo de negocio del proyecto debe ser máximo de 300 carácteres.',
            'txttrl_normatividad.required' => 'La evidencia de normatividad del proyecto es obligatoria.',
            'txttrl_normatividad.max' => 'La evidencia de normatividad del proyecto debe ser máximo de 300 carácteres.'
        ];
    }
}
