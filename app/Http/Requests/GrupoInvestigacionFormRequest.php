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
      // 'txtnombres_contacto' => 'nullable|regex:/^([a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/|min:10|max:60',
      // 'txtcorreo_contacto' => 'nullable|email|min:7|max:100',
      // 'txttelefono_contacto' => 'nullable|numeric|digits_between:7,11',
    ];
  }

  public function messages()
  {
    return $messages = [
      // Mensajes personalizados para el campo del código de grupo
      'txtcodigo_grupo.required' => 'El Código del Grupo de Investigación es obligatorio.',
      'txtcodigo_grupo.max' => 'El Código del Grupo de Investigación debe ser máximo 15 caracteres.',
      'txtcodigo_grupo.min' => 'El Código del Grupo de Investigación debe ser mínimo 4 caracteres.',
      'txtcodigo_grupo.regex' => 'El formato del campo Código del Grupo de Investigación no es correcto',
      'txtcodigo_grupo.unique' => 'El Código del Grupo de Investigación ya se encuentra registrado.',
      // Mensajes personalizados para el campo de nombre del grupo de investigación
      'txtnombre.required' => 'El Nombre del Grupo de Investigación es obligatorio.',
      'txtnombre.min' => 'El Nombre del Grupo de Investigación debe ser mínimo de 1 caracter.',
      'txtnombre.max' => 'El Nombre del Grupo de Investigación debe ser máximo de 300 caracteres.',
      'txtnombre.regex' => 'El formato del campo Nombre del Grupo de Investigación es incorrecto.',
      // Mensajes personalizados para el campo de email del grupo de investigación
      'txtemail_entidad.email' => 'El formato del campo Email del Grupo de Investigación es incorrecto.',
      'txtemail_entidad.min' => 'El Email del Grupo de Investigación debe ser minimo de 7 caracteres.',
      'txtemail_entidad.max' => 'El Email del Grupo de Investigación debe ser máximo de 200 caracteres.',
      // Mensajes personalizados para el campo de clasificacion de colciencias
      'txtclasificacionclociencias_id' => 'La Clasificación de Colciencias es obligatoria.',
      // Mensajes personalizados para el campo de tipo de grupo de investigación
      'txttipogrupo' => 'El Tipo de Grupo de Investigación es obligatorio.',
      // Mensajes personalizados para el campo de institución del grupo de investigación
      'txtinstitucion.required' => 'La Institución que avala es obligatoria.',
      'txtinstitucion.max' => 'La Institución que avala debe ser máxima de 200 caracteres',
      'txtinstitucion.regex' => 'El formato del campo Institución que avala es incorrecto.',
      // Mensajes personalizados para el campo de departamento del grupo de investigación
      'txtdepartamento' => 'El Departamento del Grupo de Investigación es obligatorio.',
      // Mensajes personalizados para el campo de ciudad del grupo de investigación
      'txtciudad_id' => 'La Ciudad del Grupo de Investigación es obligatoria.',
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
      // 'txtnombres_contacto' => 'Nombre del Contacto',
      // 'email_contacto' => 'Email del Contacto',
      // 'telefono_contacto' => 'Teléfono del Contacto',
      ];
    }
  }
