<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\User;

class MantenimientoFormRequest extends FormRequest
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
            'txtnodo_id'          => Rule::requiredIf(session()->get('login_role') == User::IsAdministrador()),
            'txtlineatecnologica' => 'required',
            'txtequipo'           => 'required',
            'txtanio'             => 'required|date_format:"Y"',
            'txtvalor'            => 'required|between:0,999999999999.99|numeric',
        ];
    }

    public function messages()
    {
        return $messages = [
            'txtnodo_id.required'          => 'El nodo es obligatorio.',
            'txtlineatecnologica.required' => 'La linea Tecnológica es obligatoria.',
            'txtequipo.required'           => 'El equipo es obligatorio.',
            'txtanio.required'             => 'El año de mantenimiento es obligatorio.',
            'txtanio.date_format'          => 'El año de mantenimiento no corresponde al formato de año.',
            'txtvalor.required'            => 'El valor del mantenimiento es obligatorio.',
            'txtvalor.between'             => 'El valor del mantenimiento tiene que estar entre 0 - 999999999999.99.',
            'txtvalor.numeric'             => 'El valor del mantenimiento debe ser numérico.',

        ];
    }

    public function attributes()
    {
        return [
            'txtlineatecnologica' => 'Linea Tecnológica',
            'txtequipo'      => 'equipo',
            'txtanio' => 'año mantenimiento',
            'txtvalor' => 'valor mantenimiento',
        ];
    }
}
