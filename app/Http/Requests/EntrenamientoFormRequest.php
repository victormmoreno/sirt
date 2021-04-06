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
      'txtfecha_sesion1' => 'required|date_format:"Y-m-d"',
      'ideas_taller' => 'required',
    ];
  }
  public function messages()
  {
    return $messages = [
      'txtfecha_sesion1.required' => 'La fecha del taller es obligatoria.',
      'txtfecha_sesion1.date_format' => 'La fecha del taller no tiene un formato válido.',
      'ideas_taller.required' => 'Se requiere asociar por lo menos de una idea de proyecto',
    ];
  }

}
