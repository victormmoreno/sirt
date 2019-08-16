<?php

namespace App\Http\Requests;

use App\Rules\CreateValidationForDomainRequest;
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
        $rules =  [
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
            'txtservidorvideo'   => 'required',
            'txtlinkvideo'       => ['required', 'url', new CreateValidationForDomainRequest],
            // 'txtlinkvideo'       => ['required', 'url'],
        ];

        // $rules->sometimes('txtlinkvideo', 'required', function ($input) {
        //     // return $input->games >= 100;
        //     dd($input);
        // });

        return $rules;
    }

    public function messages()
    {
        return $messages = [
            'txtnodo.required'                => 'El Nodo es obligatorio.',

            'txtnombres.required'             => 'Los Nombres son obligatorios.',
            'txtnombres.min'                  => 'Los Nombres deben ser minimo 1 caracter',
            'txtnombres.max'                  => 'Los Nombres deben ser máximo 45 caracteres',
            'txtnombres.regex'                => 'El formato del campo Nombres es incorrecto',

            'txtapellidos.required'           => 'Los Apellidos son obligatorios.',
            'txtapellidos.min'                => 'Los Apellidos deben ser minimo 1 caracter',
            'txtapellidos.max'                => 'Los Apellidos deben ser máximo 45 caracteres',
            'txtapellidos.regex'              => 'El formato del campo Apellidos es incorrecto',

            'txtcorreo.required'              => 'El Correo Electrónico es obligatorio.',
            'txtcorreo.min'                   => 'El Correo Electrónico debe ser minimo 1 caracter',
            'txtcorreo.max'                   => 'El Correo Electrónico debe ser máximo 100 caracteres',

            'txttelefono.required'            => 'El Telefono es obligatorio.',
            'txttelefono.numeric'             => 'El Telefono debe ser numérico',
            'txttelefono.min'                 => 'El Telefono debe ser minimo 6 caracteres',
            'txttelefono.max'                 => 'El Telefono debe ser máximo 11 caracteres',
            'txttelefono.digits_between'      => 'El Telefono debe tener entre 6 y 11 digitos',

            'txtnombre_proyecto.required'     => 'El Nombre de Proyecto es obligatorio.',
            'txtnombre_proyecto.min'          => 'El Nombre de Proyecto debe ser minimo 1 caracter',
            'txtnombre_proyecto.required.max' => 'El Nombre de Proyecto debe ser máximo 200 caracteres',
            'txtnombre_proyecto.regex'        => 'El formato del campo Nombre de Proyecto es incorrecto',

            'txtdescripcion.required'         => 'La Descripcion es obligatoria.',
            'txtdescripcion.min'              => 'La Descripcion debe ser minimo 1 caracter',
            'txtdescripcion.max'              => 'La Descripcion debe ser máximo 2000 caracteres',

            'txtobjetivo.required'            => 'El Objetivo es obligatorio.',
            'txtobjetivo.min'                 => 'El Objetivo debe ser minimo 1 caracter',
            'txtobjetivo.max'                 => 'El Objetivo debe ser máximo 2000 caracteres',

            'txtalcance.required'             => 'El Alcance es obligatorio.',
            'txtalcance.min'                  => 'El Alcance debe ser minimo 1 caracter',
            'txtalcance.max'                  => 'El Alcance debe ser máximo 2000 caracteres',

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
            'txtnombre_proyecto' => 'Nombre de Proyecto',
            'txtdescripcion'     => 'Descripcion',
            'txtobjetivo'        => 'Objetivo',
            'txtalcance'         => 'Alcance',
        ];
    }
}
