<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ComiteAgendamientoFormRequest extends FormRequest
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
        'txtfechacomite_create' => 'required|date_format:"Y-m-d"',
      ];
    }

    public function messages()
    {
      return $messages = [
        'txtfechacomite_create.required' => 'La Fecha del Comité es obligatoria.',
        'txtfechacomite_create.date_format' => 'La Fecha del Comité no tiene un formato válido.',
      ];
    }

    public function attributes()
    {
      return [
        'txtfechacomite_create' => 'Fecha del Comité',
      ];
    }
}
