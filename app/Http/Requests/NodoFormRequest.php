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
            'txtlineas'  => 'required',
            'txtnombre'    => 'required|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/|min:1|max:100|unique:nodos,nombre,' . $this->route('nodo'),
            'txtdireccion' => 'required|min:1|max:2000',
        ];
    }

    public function messages()
    {
        return $messages = [
            'txtcentro.required'    => 'El :attribute es obligatorio.',
            'txtregional.required'    => 'El :attribute es obligatorio.',
            'txtlineas.required'  => 'Por favor selecciona al menos una linea',

            'txtnombre.required'    => 'El :attribute es obligatorio.',
            'txtnombre.min'         => 'El :attribute debe ser minimo 1 caracter',
            'txtnombre.max'         => 'El :attribute debe ser máximo 100 caracteres',
            'txtnombre.regex'       => 'El formato del campo :attribute es incorrecto',
            'txtnombre.unique'      => 'El :attribute ya ha sido registrado',

            'txtdireccion.required' => 'La :attribute es obligatoria.',
            'txtdireccion.min'      => 'La :attribute debe ser minimo 1 caracter',
            'txtdireccion.max'      => 'La :attribute debe ser máximo 2000 caracteres',

        ];
    }

    public function attributes()
    {
        return [
            'txtcentro'    => 'centro de formacion',
            'txtnombre'    => 'nombre',
            'txtnombre'    => 'nombre',
            'txtdireccion' => 'dirección',
            'txtlineas' => 'linea',

        ];
    }
}
