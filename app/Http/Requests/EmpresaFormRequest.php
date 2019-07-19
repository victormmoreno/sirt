<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmpresaFormRequest extends FormRequest
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
      'nombre' => 'required|min:1|max:300|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
      'nit' => 'required|numeric|digits_between:6,45|unique:empresas,nit,'.$this->route('id'),
      'email_entidad' => 'email|nullable|min:7|max:200',
      'direccion' => 'max:100',
      'txtdepartamento' => 'required',
      'txtciudad_id' => 'required',
      'txtsector' => 'required',
    ];
  }

  public function messages()
  {
    return $messages = [
      'nombre.required' => 'El Nombre de la Empresa es obligatorio.',
      'nombre.min' => 'El Nombre de la Empresa debe ser mínimo de 1 caracter.',
      'nombre.max' => 'El Nombre de la Empresa debe ser máximo de 300 caracteres.',
      'nombre.regex' => 'El formate del campo Nombre de la Empresa es incorrecto.',

      'nit.required' => 'El Nit de la Empresa es obligatorio.',
      'nit.numeric' => 'El Nit de la Empresa debe ser numérico (Sin puntos ni número de verificación).',
      'nit.unique' => 'El Nit de la Empresa ya se encuentra registrado.',
      'nit.digits_between' => 'El Nit de la Empresa debe tener entre 6 y 45 digitos.',

      'email_entidad.email' => 'El formato del campo Email de la Empresa es incorrecto.',
      'email_entidad.min' => 'El Email de la Empresa debe ser minimo de 7 caracteres.',
      'email_entidad.max' => 'El Email de la Empresa debe ser máximo de 200 caracteres.',

      'direccion.required' => 'La Dirección de la Empresa es obligatoria.',
      'direccion.min' => 'La Dirección de la Empresa deben ser minimo de 1 caracter.',
      'direccion.max' => 'La Dirección de la Empresa deben ser máximo de 100 caracteres.',
      'direccion.regex' => 'El formato del campo Dirección de la Empresa es incorrecto.',

      'txtdepartamento' => 'El Departamento de la Empresa es obligatorio.',

      'txtciudad_id' => 'La Ciudad de la Empresa es obligatoria.',

      'txtsector' => 'El Sector de la Empresa es obligatorio.',
      ];
    }

    public function attributes()
    {
      return [
      'nombre' => 'Nombre de la Empresa',
      'nit' => 'Nit de la Empresa',
      'email_entidad' => 'Email de la Empresa',
      'direccion' => 'Dirección de la Empresa',
      'txtdepartamento' => 'Departamento de la Empresa',
      'txtciudad_id' => 'Ciudad de la Empresa',
      'txtsector' => 'Sector de la Empresa',
      ];
    }
  }
