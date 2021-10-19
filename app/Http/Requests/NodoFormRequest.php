<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NodoFormRequest extends FormRequest
{

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            $nodo   = $this->txtnombre;
            $findme = ['Tecnoparque Nodo', 'tecnoparque nodo', 'nodo', 'Nodo', 'Tecnoparque', 'tecnoparque'];
            foreach ($findme as $value) {
                if (strpos($nodo, $value) !== false) {
                    $validator->errors()->add('txtnombre', "El nombre del nodo no puede contener la palabra {$value}");
                }
            }

        });

    }
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
            'txtdepartamento'  => 'required',
            'txtciudad'        => 'required',
            'txtcentro'        => 'required',
            'txtregional'      => 'required',
            'txtlineas'        => 'required',
            'txtnombre'        => 'required|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/|min:1|max:100|unique:entidades,nombre,' . $this->route('nodo'),
            'txtdireccion'     => 'required|min:1|max:2000',
            'txtemail_entidad' => 'required|email|min:1|max:100',
            'txttelefono'      => 'nullable|digits_between:6,7|numeric',
            'txtextension'     => 'nullable|numeric',
        ];
    }

    public function messages()
    {
        return $messages = [
            'txtdepartamento.required'   => 'El departamento es obligatorio.',
            'txtciudad.required'         => 'La ciudad es obligatoria.',
            'txtcentro.required'         => 'El centro de formacion es obligatorio.',
            'txtregional.required'       => 'La regional es obligatoria.',
            'txtlineas.required'         => 'Por favor selecciona al menos una linea tecnológica',
            'txtnombre.required'         => 'El nombre es obligatorio.',
            'txtnombre.min'              => 'El nombre debe ser minimo 1 caracter',
            'txtnombre.max'              => 'El nombre debe ser máximo 100 caracteres',
            'txtnombre.regex'            => 'El formato del campo nombre es incorrecto',
            'txtnombre.unique'           => 'El nombre ya ha sido registrado',

            'txtdireccion.required'      => 'La dirección es obligatoria.',
            'txtdireccion.min'           => 'La dirección debe ser minimo 1 caracter',
            'txtdireccion.max'           => 'La dirección debe ser máximo 2000 caracteres',

            'txtemail_entidad.required'  => 'El correo electrónico es obligatorio.',
            'txtemail_entidad.min'       => 'El correo electrónico debe ser minimo 1 caracter',
            'txtemail_entidad.email'       => 'El valor ingreaso no es un correo válido',
            'txtemail_entidad.max'       => 'El correo electrónico debe ser máximo 100 caracteres',

            'txttelefono.required'       => 'El teléfono es obligatorio.',
            'txttelefono.numeric'        => 'El teléfono debe ser numérico',
            'txttelefono.digits_between' => 'El teléfono debe tener entre 6 y 7 digitos',

            'txtextension.required'       => 'La extensión es obligatoria.',
            'txtextension.numeric'        => 'La extensión debe ser numérica.',

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
