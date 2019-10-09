<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'txtlineatecnologica' => 'required',
            'txtequipo'           => 'required',
            'txtvidautil'           => 'required|integer',
            'txthorasuso'           => 'required|between:0,9999999.99|numeric',
            'txtanio'             => 'required|date_format:"Y"',
            'txtvalor'            => 'required|between:0,999999999999.99|numeric',
        ];
    }

    public function messages()
    {
        return $messages = [
            'txtlineatecnologica.required' => 'La linea Tecnológica es obligatoria.',
            'txtequipo.required'           => 'El equipo es obligatorio.',

            'txtvidautil.required'           => 'La vida util del mantenimiento es obligatoria.',
            'txtvidautil.integer'           => 'La vida util del mantenimiento debe ser un número entero.',

            'txthorasuso.required'           => 'Las horas del uso al año son obligatorias.',
            'txthorasuso.between'           => 'Las horas del uso al año tienen que estar entre 0 - 9999999.99',
            'txthorasuso.numeric'             => 'Las horas del uso al año debe ser numéricas.',

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
