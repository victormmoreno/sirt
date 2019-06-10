<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EntrenamientoFormRequest extends FormRequest
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
      'txtfecha_sesion1'            => 'required|date_format:"Y-m-d"',
      'txtfecha_sesion2'         => 'required|date_format:"Y-m-d"',
    ];
  }
  public function messages()
  {
    return $messages = [
      // 'txtnodo_id.required'                => 'El :attribute es obligatorio.',

      'txtfecha_sesion1.required'             => 'La :attribute es obligatorios.',
      'txtfecha_sesion1.date_format'             => 'La :attribute no tiene un formato válido.',

      'txtfecha_sesion2.required'                  => 'La :attribute es obligatorios.',
      'txtfecha_sesion2.date_format'                  => 'La :attribute no tiene un formato válido.',
    ];
  }

  public function attributes()
  {
    return [
      'txtfecha_sesion1'            => 'Fecha de la Primera Sesión',
      'txtfecha_sesion2'         => 'Fecha de la Segunda Sesión',
    ];
  }
}
