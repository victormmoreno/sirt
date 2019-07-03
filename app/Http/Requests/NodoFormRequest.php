<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NodoFormRequest extends FormRequest
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
            'txtcentro'    => 'required',
            'txtregional'  => 'required',
            'txtlineas'    => 'required',
            'txtnombre'    => 'required|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/|min:1|max:100|unique:nodos,nombre,' . $this->route('nodo'),
            'txtdireccion' => 'required|min:1|max:2000',
        ];
    }

    public function messages()
    {
        return $messages = [
            'txtcentro.required'    => 'El centro de formacion es obligatorio.',
            'txtregional.required'  => 'La regional es obligatoria.',
            'txtlineas.required'    => 'Por favor selecciona al menos una linea',
            'txtnombre.required'    => 'El nombre es obligatorio.',
            'txtnombre.min'         => 'El nombre debe ser minimo 1 caracter',
            'txtnombre.max'         => 'El nombre debe ser máximo 100 caracteres',
            'txtnombre.regex'       => 'El formato del campo nombre es incorrecto',
            'txtnombre.unique'      => 'El nombre ya ha sido registrado',

            'txtdireccion.required' => 'La dirección es obligatoria.',
            'txtdireccion.min'      => 'La dirección debe ser minimo 1 caracter',
            'txtdireccion.max'      => 'La dirección debe ser máximo 2000 caracteres',

        ];
    }

    public function attributes()
    {
        return [
            'txtcentro'    => 'centro de formacion',
            'txtnombre'    => 'nombre',
            'txtnombre'    => 'nombre',
            'txtdireccion' => 'dirección',
            'txtlineas'    => 'linea',

        ];
    }
}
