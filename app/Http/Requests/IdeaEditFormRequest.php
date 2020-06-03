<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IdeaEditFormRequest extends FormRequest
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
            'txtnodo_id' => 'required',
            'txtnombres_contacto' => 'required|min:1|max:45|regex:/^([a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
            'txtapellidos_contacto' => 'required|min:1|max:45|regex:/^([a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
            'txtcorreo_contacto' => 'required|email|min:1|max:100',
            'txttelefono_contacto' => 'required|digits_between:6,11|numeric',
            'txtnombre_proyecto' => 'required|min:1|max:200|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
            'txtdescripcion' => 'required|min:1|max:2000',
            'txtobjetivo' => 'required|min:1|max:2000',
            'txtalcance' => 'required|min:1|max:2000',
            'txtconvocatoria'   => 'required|in:0,1',
            'txtnombreconvocatoria'   => Rule::requiredIf(request()->txtconvocatoria == 1) . '|min:1|max:100|nullable',
        ];
    }

    public function messages()
    {
        return $messages = [
            'txtnodo_id.required' => 'El Nodo es obligatorio.',

            'txtnombres_contacto.required' => 'Los Nombres del Contacto son obligatorios.',
            'txtnombres_contacto.min' => 'Los Nombres del Contacto deben ser minimo 1 caracter',
            'txtnombres_contacto.max' => 'Los Nombres del Contacto deben ser máximo 45 caracteres',
            'txtnombres_contacto.regex' => 'El formato del campo Nombres del Contacto es incorrecto',

            'txtapellidos_contacto.required' => 'Los Apellidos del Contacto son obligatorios.',
            'txtapellidos_contacto.min' => 'Los Apellidos del Contacto deben ser minimo 1 caracter',
            'txtapellidos_contacto.max' => 'Los Apellidos del Contacto deben ser máximo 45 caracteres',
            'txtapellidos_contacto.regex' => 'El formato del campo Apellidos del Contacto es incorrecto',

            'txtcorreo_contacto.required' => 'El Correo del Contacto es obligatorio.',
            'txtcorreo_contacto.min' => 'El Correo del Contacto debe ser minimo 1 caracter',
            'txtcorreo_contacto.max' => 'El Correo del Contacto debe ser máximo 100 caracteres',

            'txttelefono_contacto.required' => 'El Teléfono del Contacto es obligatorio.',
            'txttelefono_contacto.numeric' => 'El Teléfono del Contacto debe ser numérico',
            'txttelefono_contacto.min' => 'El Teléfono del Contacto debe ser minimo 6 caracteres',
            'txttelefono_contacto.max' => 'El Teléfono del Contacto debe ser máximo 11 caracteres',
            'txttelefono_contacto.digits_between' => 'El Teléfono del Contacto debe tener entre 6 y 11 dígitos',

            'txtnombre_proyecto.required' => 'El Nombre del Proyecto es obligatorio.',
            'txtnombre_proyecto.min' => 'El Nombre del Proyecto debe ser minimo 1 caracter',
            'txtnombre_proyecto.required.max' => 'El Nombre del Proyecto debe ser máximo 200 caracteres',
            'txtnombre_proyecto.regex' => 'El formato del campo Nombre del Proyecto es incorrecto',

            'txtdescripcion.required' => 'La Descripción del Proyecto es obligatoria.',
            'txtdescripcion.min' => 'La Descripción del Proyecto debe ser minimo 1 caracter',
            'txtdescripcion.max' => 'La Descripción del Proyecto debe ser máximo 2000 caracteres',

            'txtobjetivo.required' => 'El Objetivo del Proyecto es obligatorio.',
            'txtobjetivo.min' => 'El Objetivo del Proyecto debe ser minimo 1 caracter',
            'txtobjetivo.max' => 'El Objetivo del Proyecto debe ser máximo 2000 caracteres',

            'txtalcance.required' => 'El Alcance del Proyecto es obligatorio.',
            'txtalcance.min' => 'El Alcance del Proyecto debe ser minimo 1 caracter',
            'txtalcance.max' => 'El Alcance del Proyecto debe ser máximo 2000 caracteres',

            'txtconvocatoria.required' => 'El campo es obligatorio',
            'txtnombreconvocatoria.required' => 'El nombre de convocatoria es obligatorio',
            'txtnombreconvocatoria.min'  => 'El nombre de convocatoria debe ser minimo 1 caracter',
            'txtnombreconvocatoria.max' => 'El nombre de convocatoria debe ser máximo 100 caracteres',

        ];
    }

    public function attributes()
    {
        return [
            'txtnodo_id' => 'Nodo',
            'txtnombres_contacto' => 'Nombre',
            'txtapellidos_contacto' => 'Apellido',
            'txtcorreo_contacto' => 'Correo Electrónico',
            'txttelefono_contacto' => 'Telefono',
            'txtnombre_proyecto' => 'Nombre de proyecto',
            'txtdescripcion' => 'Descripcion',
            'txtobjetivo' => 'Objetivo',
            'txtalcance' => 'Alcance',
        ];
    }
}
