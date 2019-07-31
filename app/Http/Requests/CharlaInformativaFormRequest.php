<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CharlaInformativaFormRequest extends FormRequest
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
      'txtfecha' => 'required|date_format:"Y-m-d"',
      'txtnro_asistentes' => 'required|numeric|min:1',
      'txtencargado' => 'required|string|max:75',
      'txtobservacion' => 'max:1000'
    ];
  }

  /**
   * Mensajes personalizados para el formulario de charlas informativas
   * @return array
   */
  public function messages()
  {
    return $messages = [
      // Mensajes para el campo txtfecha
      'txtfecha.required' => 'La Fecha es obligatoria.',
      'txtfecha.date_format' => 'La Fecha no tiene un formato válido',
      // Mensajes para el campo txtnro_asistentes
      'txtnro_asistentes.required' => 'El Número de Asistentes es obligatorio.',
      'txtnro_asistentes.numeric' => 'El Número de Asistentes debe ser numérico.',
      'txtnro_asistentes.min' => 'El Número de Asistentes debe ser mayor o igual a 1.',
      // Mensajes para campo txtencargado
      'txtencargado.required' => 'El nombre del encargado es obligatorio.',
      'txtencargado.string' => 'El nombre del encargado debe ser caracter.',
      'txtencargado.max' => 'El nombre del encargado debe se rmáximo de 75 carácteres',
      // Mensajes para el campo txtobservacion
      'txtobservacion.max' => 'Las observaciones deben ser máximo de 1000 carácteres'
    ];
  }
}
