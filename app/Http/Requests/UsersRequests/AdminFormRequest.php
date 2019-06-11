<?php

namespace App\Http\Requests\UsersRequests;

use Illuminate\Foundation\Http\FormRequest;

class AdminFormRequest extends FormRequest
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
            'txttipo_documento'    => 'required',
            'txtdocumento'         => 'required|digits_between:6,11|numeric|unique:users,documento,'.$this->route('id'),
            'txtnombres'           => 'required|min:1|max:45|regex:/^([a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
            'txtapellidos'         => 'required|min:1|max:45|regex:/^([a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
            'txtfecha_nacimiento'  => 'required|date|date_format:Y-m-d|before_or_equal:' . date('Y-m-d'),
            'txtestrato'           => 'required',
            'txtemail'             => 'required|email|min:1|max:100,|unique:users,email,'.$this->route('id'),
            'txtdireccion'         => 'required|min:1|max:200',
            'txttelefono'          => 'digits_between:6,11|numeric',
            'txtcelular'           => 'digits_between:10,11|numeric',
            'txtgrado_escolaridad' => 'required',

        ];
    }

    public function messages()
    {
        return $messages = [
            'txttipo_documento.required'          => 'El :attribute es obligatorio.',

            'txtdocumento.required'               => 'El :attribute es obligatorio.',
            'txtdocumento.digits_between'         => 'El :attribute debe tener entre 6 y 11 digitos',
            'txtdocumento.numeric'                => 'El :attribute debe ser numérico',
            'txtdocumento.unique'                => 'El :attribute ya ha sido registrado',

            'txtnombres.required'                 => 'Los :attribute son obligatorios.',
            'txtnombres.min'                      => 'Los :attribute deben ser minimo 1 caracter',
            'txtnombres.max'                      => 'Los :attribute deben ser máximo 45 caracteres',
            'txtnombres.regex'                    => 'El formato del campo :attribute es incorrecto',

            'txtapellidos.required'               => 'Los :attribute son obligatorios.',
            'txtapellidos.min'                    => 'Los :attribute deben ser minimo 1 caracter',
            'txtapellidos.max'                    => 'Los :attribute deben ser máximo 45 caracteres',
            'txtapellidos.regex'                  => 'El formato del campo :attribute es incorrecto',

            'txtfecha_nacimiento.required'        => 'La :attribute es obligatoria.',
            'txtfecha_nacimiento.date'            => 'La :attribute no es una fecha válida.',
            'txtfecha_nacimiento.before_or_equal' => 'La :attribute  debe ser una fecha anterior o igual a 2019-06-11.',

            'txtestrato.required'                 => 'El :attribute es obligatorio.',

            'txtemail.required'                   => 'El :attribute es obligatorio.',
            'txtemail.min'                        => 'El :attribute debe ser minimo 1 caracter',
            'txtemail.max'                        => 'El :attribute debe ser máximo 100 caracteres',
            'txtemail.unique'                => 'El :attribute ya ha sido registrado',

            'txtdireccion.required'               => 'La :attribute es obligatoria.',
            'txtdireccion.min'                    => 'La :attribute debe ser minimo 1 caracter',
            'txtdireccion.max'                    => 'La :attribute debe ser máximo 200 caracteres',
            // 'txtdireccion.regex'                  => 'El formato del campo :attribute es incorrecto',

            'txttelefono.numeric'                 => 'El :attribute debe ser numérico',
            'txttelefono.digits_between'          => 'El :attribute debe tener entre 6 y 11 digitos',

            'txtcelular.numeric'                  => 'El :attribute debe ser numérico',
            'txtcelular.digits_between'           => 'El :attribute debe tener entre 10 y 11 digitos',

            'txtgenero.required'                  => 'El :attribute es obligatorio.',
            'txtgrado_escolaridad.required'       => 'El :attribute es obligatorio.',

        ];
    }

    public function attributes()
    {
        return [
            'txttipo_documento'    => 'tipo de documento',
            'txtdocumento'         => 'número de documento',
            'txtnombres'           => 'nombres',
            'txtapellidos'         => 'apellidos',
            'txtfecha_nacimiento'  => 'fecha de nacimiento',
            'txtestrato'           => 'estrato',
            'txtemail'             => 'correo electrónico',
            'txtdireccion'         => 'dirección',
            'txttelefono'          => 'telefono',
            'txtcelular'           => 'celular',
            'txtgenero'            => 'genero',
            'txtgrado_escolaridad' => 'grado de escolaridad',
        ];
    }
}
