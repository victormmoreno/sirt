<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupportRequest extends FormRequest
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
            'cmbsolicitud' => 'required',
            'txtasunto' => 'required|min:1|max:200',
            'txtemail' => 'required|email|min:1|max:100',
            'txtmensaje' => 'required|min:1|max:60000',
            'filedocument' => 'max:50000|mimes:jpeg,png,jpg,docx,doc,pdf,xlsl,xlsx,xls',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'cmbsolicitud.required'    => 'El campo Tipo Solicitud es obligatorio.',
            'txtasunto.required'    => 'El campo Asunto es obligatorio.',
            'txtasunto.min'    => 'El tamaño del asunto debe ser de al menos :min caracter.',
            'txtasunto.max'    => 'El asunto no debe ser mayor a :max caracter(es)',
            'txtemail.required' => 'El campo correo electrónico es obligatorio.',
            'txtemail.min'    => 'El correo electrónico debe ser de al menos :min caracter.',
            'txtemail.max'    => 'El correo electrónico no debe ser mayor a :max caracter(es)',
            'txtemail.email'    => 'El correo electrónico no es un correo válido',
            'txtmensaje.required'      => 'El mensaje es obligatorio.',
            'txtmensaje.min'      => 'El mensaje debe ser de al menos :min caracter.',
            'txtmensaje.max'      => 'El mensaje no debe ser mayor a :max caracter(es).',
            'filedocument.max'      => 'El archivo no debe ser mayor que :max kilobytes.',
            'filedocument.mimes'      => 'El archivo debe ser un archivo con formato: :values.'
        ];
    }
}
