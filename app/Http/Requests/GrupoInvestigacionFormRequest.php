<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GrupoInvestigacionFormRequest extends FormRequest
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
      'txtcodigo_grupo' => 'required|min:4|max:15|regex:/([a-zA-ZñÑáéíóúÁÉÍÓÚ]){1,3}([0-9])/|unique:gruposinvestigacion,codigo_grupo,'.$this->route('id'),
      'txtnombre' => 'required|min:1|max:300|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
      'txtemail_entidad' => 'email|nullable|min:7|max:200',
      'txtclasificacionclociencias_id' => 'required',
      'txttipogrupo' => 'required',
      'txtinstitucion' => 'required|max:200|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
      'txtdepartamento' => 'required',
      'txtciudad_id' => 'required',
      'txtnombres_contacto' => 'nullable|regex:/^([a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/|min:10|max:60',
      'txtcorreo_contacto' => 'nullable|email|min:7|max:100',
      'txttelefono_contacto' => 'nullable|numeric|digits_between:7,11',
    ];
  }

  public function messages()
  {
    return $messages = [
      // Mensajes personalizados para el campo del código de grupo
      'txtcodigo_grupo.required' => 'El :attribute es obligatorio.',
      'txtcodigo_grupo.max' => 'El :attribute debe ser máximo 15 caracteres.',
      'txtcodigo_grupo.min' => 'El :attribute debe ser mínimo 4 caracteres.',
      'txtcodigo_grupo.regex' => 'El formato del campo :attribute no es correcto',
      'txtcodigo_grupo.unique' => 'El :attribute ya se encuentra registrado.',
      // Mensajes personalizados para el campo de nombre del grupo de investigación
      'txtnombre.required' => 'El :attribute es obligatorio.',
      'txtnombre.min' => 'El :attribute debe ser mínimo de 1 caracter.',
      'txtnombre.max' => 'El :attribute debe ser máximo de 300 caracteres.',
      'txtnombre.regex' => 'El formato del campo :attribute es incorrecto.',
      // Mensajes personalizados para el campo de email del grupo de investigación
      'txtemail_entidad.email' => 'El formato del campo :attribute es incorrecto.',
      'txtemail_entidad.min' => 'El :attribute debe ser minimo de 7 caracteres.',
      'txtemail_entidad.max' => 'El :attribute debe ser máximo de 200 caracteres.',
      // Mensajes personalizados para el campo de clasificacion de colciencias
      'txtclasificacionclociencias_id' => 'La :attribute es obligatoria.',
      // Mensajes personalizados para el campo de tipo de grupo de investigación
      'txttipogrupo' => 'El :attribute es obligatorio.',
      // Mensajes personalizados para el campo de institución del grupo de investigación
      'txtinstitucion.required' => 'La :attribute es obligatoria.',
      'txtinstitucion.max' => 'La :attribute debe ser máxima de 200 caracteres',
      'txtinstitucion.regex' => 'El formato del campo :attribute es incorrecto.',
      // Mensajes personalizados para el campo de departamento del grupo de investigación
      'txtdepartamento' => 'El :attribute es obligatorio.',
      // Mensajes personalizados para el campo de ciudad del grupo de investigación
      'txtciudad_id' => 'El :attribute es obligatorio.',
      // Mensajes personalizados para el campo de nombres del contacto
      'txtnombres_contacto.regex' => 'El formato del campo <b>:attribute</b> es incorrecto.',
      'txtnombres_contacto.min' => 'El :attribute debe ser mínimo de 10 caracteres.',
      'txtnombres_contacto.max' => 'El :attribute debe ser máximo de 60 caracteres.',
      // Mensajes personalizados paa el campo de email del contato
      'email_contacto.email' => 'El formato del campo :attribute es incorrecto.',
      'email_contacto.min' => 'El :attribute debe ser mínimo de 7 caracteres.',
      'email_contacto.max' => 'El :attribute debe ser máximo de 100 caracteres.',
      // Mensajes personalizados para el campo telefono del contacto
      'telefono_contacto.numeric' => 'El :attribute debe ser numérico',
      'telefono_contacto.digits_between' => 'El :attribute debe tener entre 7 y 11 digitos',
      ];
    }

    public function attributes()
    {
      return [
      'txtcodigo_grupo' => 'Código del Grupo de Investigación',
      'txtnombre' => 'Nombre del Grupo de Investigación',
      'txtemail_entidad' => 'Email del Grupo de Investigación',
      'txtclasificacionclociencias_id' => 'Clasificación de Colciencias',
      'txttipogrupo' => 'Tipo de Grupo de Investigación',
      'txtinstitucion' => 'Institución que avala',
      'txtdepartamento' => 'Departamento del Grupo de Investigación',
      'txtciudad_id' => 'Ciudad del Grupo de Investigación',
      'txtnombres_contacto' => 'Nombre del Contacto',
      'email_contacto' => 'Email del Contacto',
      'telefono_contacto' => 'Teléfono del Contacto',
      ];
    }
  }
