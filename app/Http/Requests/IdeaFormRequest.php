<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IdeaFormRequest extends FormRequest
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
            'txtnodo'            => 'required',
            'txtnombres'         => 'required|min:1|max:45|regex:/^([a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
            'txtapellidos'       => 'required|min:1|max:45|regex:/^([a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
            'txtcorreo'          => 'required|email|min:1|max:100',
            'txttelefono'        => 'required|digits_between:6,11|numeric',
            'txtnombre_proyecto' => 'required|min:1|max:200|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
            'pregunta1'          => 'required',
            'pregunta2'          => 'required',
            'pregunta3'          => 'required',
            'txtdescripcion'     => 'required|min:1|max:2000',
            'txtobjetivo'        => 'required|min:1|max:2000',
            'txtalcance'         => 'required|min:1|max:2000',
        ];
    }

    public function messages()
    {
        return $messages = [
            'txtnodo.required'                => 'El :attribute es obligatorio.',

            'txtnombres.required'             => 'Los :attribute son obligatorios.',
            'txtnombres.min'                  => 'Los :attribute deben ser minimo 1 caracter',
            'txtnombres.max'                  => 'Los :attribute deben ser máximo 45 caracteres',
            'txtnombres.regex'                => 'El formato del campo :attribute es incorrecto',

            'txtapellidos.required'           => 'Los :attribute son obligatorios.',
            'txtapellidos.min'                => 'Los :attribute deben ser minimo 1 caracter',
            'txtapellidos.max'                => 'Los :attribute deben ser máximo 45 caracteres',
            'txtapellidos.regex'              => 'El formato del campo :attribute es incorrecto',

            'txtcorreo.required'              => 'El :attribute es obligatorio.',
            'txtcorreo.min'                   => 'El :attribute debe ser minimo 1 caracter',
            'txtcorreo.max'                   => 'El :attribute debe ser máximo 100 caracteres',

            'txttelefono.required'            => 'El :attribute es obligatorio.',
            'txttelefono.numeric'             => 'El :attribute debe ser numérico',
            'txttelefono.min'                 => 'El :attribute debe ser minimo 6 caracteres',
            'txttelefono.max'                 => 'El :attribute debe ser máximo 11 caracteres',
            'txttelefono.digits_between'      => 'El :attribute debe tener entre 6 y 11 digitos',

            'txtnombre_proyecto.required'     => 'El :attribute es obligatorio.',
            'txtnombre_proyecto.min'          => 'El :attribute debe ser minimo 1 caracter',
            'txtnombre_proyecto.required.max' => 'El :attribute debe ser máximo 200 caracteres',
            'txtnombre_proyecto.regex'        => 'El formato del campo :attribute es incorrecto',

            'txtdescripcion.required'         => 'La :attribute es obligatoria.',
            'txtdescripcion.min'              => 'La :attribute debe ser minimo 1 caracter',
            'txtdescripcion.max'              => 'La :attribute debe ser máximo 2000 caracteres',

            'txtobjetivo.required'            => 'El :attribute es obligatorio.',
            'txtobjetivo.min'                 => 'El :attribute debe ser minimo 1 caracter',
            'txtobjetivo.max'                 => 'El :attribute debe ser máximo 2000 caracteres',

            'txtalcance.required'             => 'El :attribute es obligatorio.',
            'txtalcance.min'                  => 'El :attribute debe ser minimo 1 caracter',
            'txtalcance.max'                  => 'El :attribute debe ser máximo 2000 caracteres',

        ];
    }

    public function attributes()
    {
        return [
            'txtnodo'            => 'Nodo',
            'txtnombres'         => 'Nombres',
            'txtapellidos'       => 'Apellidos',
            'txtcorreo'          => 'Correo Electrónico',
            'txttelefono'        => 'Telefono',
            'txtnombre_proyecto' => 'Nombre de proyecto',
            'txtdescripcion'     => 'Descripcion',
            'txtobjetivo'        => 'Objetivo',
            'txtalcance'         => 'Alcance',
        ];
    }
}
