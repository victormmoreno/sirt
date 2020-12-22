<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'txtnombre_proyecto' => 'required|min:1|max:200|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_!@#$&()-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_!@#$&()-]*)*)+$/',
            'txtdescripcion'     => 'max:2000',
            'txtobjetivo'        => 'max:2000',
            'txtalcance'         => 'max:2000',
            'txtconvocatoria'   => 'required|in:0,1',
            'txtnombreconvocatoria'   => Rule::requiredIf(request()->txtconvocatoria == 1) . '|min:1|max:100|nullable',
            'txtavalempresa'   => 'required|in:0,1',
            'txtempresa'   => Rule::requiredIf(request()->txtavalempresa == 1) . '|min:1|max:100|nullable',
            'txtlinkvideo'       => ['nullable', 'url', 'max:1000'],
            'txtnit'       => Rule::requiredIf(isset(request()->bandera_empresa)). '|nullable|numeric|digits_between:9,9',
        ];
    }

    public function messages()
    {
        return $messages = [
            'txtnodo.required' => 'El nodo es obligatorio.',
            'txtnombre_proyecto.required' => 'El nombre de proyecto es obligatorio.',
            'txtnombre_proyecto.min' => 'El nombre de proyecto debe ser minimo 1 caracter',
            'txtnombre_proyecto.required.max' => 'El nombre de proyecto debe ser máximo 200 caracteres',
            'txtnombre_proyecto.regex' => 'El formato del campo nombre de proyecto es incorrecto',
            'txtdescripcion.min' => 'La descripcion debe ser minimo 1 caracter',
            'txtdescripcion.max' => 'La descripcion debe ser máximo 2000 caracteres',
            'txtobjetivo.min' => 'El objetivo debe ser minimo 1 caracter',
            'txtobjetivo.max' => 'El objetivo debe ser máximo 2000 caracteres',
            'txtalcance.min' => 'El alcance debe ser minimo 1 caracter',
            'txtalcance.max' => 'El alcance debe ser máximo 2000 caracteres',
            'txtservidorvideo.required' => 'El sevidor de video es obligatorio.',
            'txtconvocatoria.required' => 'El campo es obligatorio',
            'txtnombreconvocatoria.required' => 'El nombre de convocatoria es obligatorio',
            'txtnombreconvocatoria.min' => 'El nombre de convocatoria debe ser minimo 1 caracter',
            'txtnombreconvocatoria.max' => 'El nombre de convocatoria debe ser máximo 100 caracteres',
            'txavalempresa.required' => 'El campo es obligatorio',
            'txtempresa.required' => 'El nombre de la empresa es obligatorio',
            'txtempresa.min' => 'El nombre de la empresa debe ser minimo 1 caracter',
            'txtempresa.max' => 'El nombre de la empresa debe ser máximo 100 caracteres',
            'txtlinkvideo.required' => 'El link del video es obligatorio.',
            'txtlinkvideo.url' => 'El link es incorrecto',
            'txtlinkvideo.max' => 'El link debe ser máximo 1000 caracteres',
            'txtlinkvideo.regex' => 'El formato del campo link es incorrecto',
            'txtnit.required' => 'El nit de la empresa es obligatorio',
            'txtnit.numeric' => 'El nit de la empresa solo puede tener números',
            'txtnit.digits_between' => 'El nit de la empresa debe ser de 9 dígitos'
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
