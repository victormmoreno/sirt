<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VisitanteFormRequest extends FormRequest
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
            'txtdocumento' => 'required|numeric|digits_between:7,15|unique:visitantes,documento,'.$this->route('id'),
            'txtnombres' => 'required|string|max:45',
            'txtapellidos' => 'required|string|max:45',
            'txtemail' => 'email|nullable|min:7|max:100',
            'txtcontacto' => 'digits_between:1,15|numeric|nullable',
            'txttipodocumento_id' => 'required',
            'txttipovisitante_id' => 'required'
        ];
    }

    /**
     * Mensajes personalizados para el formulario de visitante
     * @return array
     */
    public function messages()
    {
        return $messages = [
            // Mensajes para el campo txtdocumento
            'txtdocumento.required' => 'El Documento de Identidad es obligatorio.',
            'txtdocumento.digits_between' => 'El Documento de Identidad debe tener entre 7 y 15 carácteres carácteres.',
            'txtdocumento.unique' => 'El Documento de Identidad ya está registrado en la base de datos.',
            'txtdocumento.numeric' => 'El Documento de Identidad debe ser numérico.',
            // Mensajes para el campo txtnombres
            'txtnombres.required' => 'El nombre del visitante es obligatorio.',
            'txtnombres.string' => 'El nombre del visitante debe ser caracter.',
            'txtnombres.max' => 'El nombre del visitantes debe ser máximo de 45 carácteres.',
            // Mensajes para el campo txtapellidos
            'txtapellidos.required' => 'El apellido del visitante es obligatorio.',
            'txtapellidos.string' => 'El apellido del visitante debe ser caracter.',
            'txtapellidos.max' => 'El apellido del visitantes debe ser máximo de 45 carácteres.',
            // Mensajes para el campo txtemail
            'txtemail.email' => 'El email del visitante no tiene un formato válido.',
            'txtemail.min' => 'El email del visitante debe ser mínimo de 7 carácteres.',
            'txtemail.max' => 'El email del visitante debe ser máximo de 45 carácteres.',
            // Mensajes para el campo txtcontacto
            'txtcontacto.digits_between' => 'El contacto del vistitante debe tener entre 1 y 15 carácteres.',
            'txtcontacto.numeric' => 'El contacto del vistitante debe ser numérico.',
            // Mensajes para el campo txttipodocumento_id
            'txttipodocumento_id.required' => 'El Tipo de Documento es obligatorio.',
            // Mensajes para el campo txttipovisitante_id
            'txttipovisitante_id.required' => 'El Tipo de Visitante es obligatorio.'
        ];
    }
}
