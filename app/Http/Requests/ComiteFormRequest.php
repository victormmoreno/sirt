<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ComiteFormRequest extends FormRequest
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
        'txtfechacomite_create'            => 'required|date_format:"Y-m-d"',
        'txtobservacionescomite'         => 'max:1000',
      ];
    }

    public function messages()
    {
      return $messages = [
        'txtfechacomite_create.required'             => 'La :attribute es obligatoria.',
        'txtfechacomite_create.date_format'             => 'La :attribute no tiene un formato válido.',
        'txtobservacionescomite.max'                  => 'Las :attribute debe ser máximo 1000 caracteres',
      ];
    }

    public function attributes()
    {
      return [
        'txtfechacomite_create'            => 'Fecha del Comité',
        'txtobservacionescomite'         => 'Observaciones del Comité',
      ];
    }
}
