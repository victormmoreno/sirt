<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Visitante;

class IngresoVisitanteFormRequest extends FormRequest
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
      'txtdocumento' => 'required|numeric|digits_between:7,15',
      'txtnombres' => Rule::requiredIf(Visitante::where('documento', request()->txtdocumento)->first() === null). '|string|max:45|nullable',
      'txtapellidos' => Rule::requiredIf(Visitante::where('documento', request()->txtdocumento)->first() === null). '|string|max:45|nullable',
      'txtemail' => 'email|nullable|min:7|max:100',
      'txtcontacto' => 'digits_between:1,15|numeric|nullable',
      'txttipodocumento_id' => Rule::requiredIf(Visitante::where('documento', request()->txtdocumento)->first() === null),
      'txttipovisitante_id' => Rule::requiredIf(Visitante::where('documento', request()->txtdocumento)->first() === null),
      'txtfecha_ingreso' => 'required|date_format:"Y-m-d"',
      'txthora_entrada' => 'required|date_format:"H:i"',
      'txthora_salida' => 'required|date_format:"H:i"',
      'txtservicio_id' => 'required',
      'txtdescripcion' => 'max:2000',
      ];
  }

  /**
   * Mensajes personalizados para el formulario de ingresos de visitantes
   * @return array
   */
  public function messages()
  {
    return $messages = [
      // Mensajes para el campo txtdocumento
      'txtdocumento.required' => 'El Documento de Identidad es obligatorio.',
      'txtdocumento.digits_between' => 'El Documento de Identidad debe tener entre 7 y 15 carácteres carácteres.',
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
      'txttipovisitante_id.required' => 'El Tipo de Visitante es obligatorio.',
      // Mensajes ara el campo txtfecha_ingreso
      'txtfecha_ingreso.required' => 'La Fecha de Ingreso es obligatoria.',
      'txtfecha_ingreso.date_format' => 'El Formato de la Fecha de Ingreso es incorrecto.',
      // Mensajes para el campo txthora_entrada
      'txthora_entrada.required' => 'La Hora de Ingreso es obligatoria.',
      'txthora_entrada.date_format' => 'El Formato de la Hora de Ingreso es incorrecto.',
      // Mensajes para el campo txthora_salida
      'txthora_salida.required' => 'La Hora de Salida es obligatoria.',
      'txthora_salida.date_format' => 'El Formato de la Hora de Salida es incorrecto.',
      // Mensajes para el campo txtservicio_id
      'txtservicio_id.required' => 'El Servicio es obligatorio.',
      // Mensajes para el campo txtdescripcion
      'txtdescripcion.max' => 'La Descripcion del Ingreso debe ser máximo de 2000 carácteres.',
    ];
  }
}
