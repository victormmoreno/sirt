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
      // 'nit' => Rule::requiredIf(auth()->user()->rol()->first()->nombre == 'Gestor'),
      'email_entidad' => 'email|nullable|min:7|max:200',
      'direccion' => 'required|min:1|max:100',
      'txtdepartamento' => 'required',
      'txtciudad_id' => 'required',
      'txtsector' => 'required',
    ];
  }

  public function messages()
  {
    return $messages = [
      //
      'nombre.required' => 'El :attribute es obligatorio.',
      'nombre.min' => 'El :attribute debe ser mínimo de 1 caracter.',
      'nombre.max' => 'El :attribute debe ser máximo de 300 caracteres.',
      'nombre.regex' => 'El formate del campo :attribute es incorrecto.',

      'nit.required' => 'El :attribute es obligatorio.',
      'nit.numeric' => 'El :attribute debe ser numérico (Sin puntos ni número de verificación).',
      'nit.unique' => 'El :attribute ya se encuentra registrado.',
      'nit.digits_between' => 'El :attribute debe tener entre 6 y 45 digitos.',

      'email_entidad.email' => 'El formato del campo :attribute es incorrecto.',
      'email_entidad.min' => 'El :attribute debe ser minimo de 7 caracteres.',
      'email_entidad.max' => 'El :attribute debe ser máximo de 200 caracteres.',

      'direccion.required' => 'La :attribute es obligatoria.',
      'direccion.min' => 'La :attribute deben ser minimo de 1 caracter.',
      'direccion.max' => 'La :attribute deben ser máximo de 100 caracteres.',
      'direccion.regex' => 'El formato del campo :attribute es incorrecto.',

      'txtdepartamento' => 'El :attribute es obligatorio.',

      'txtciudad_id' => 'La :attribute es obligatoria.',

      'txtsector' => 'El :attribute es obligatorio.',

      'nombre_contacto.regex' => 'El formato del campo :attribute es incorrecto.',
      'nombre_contacto.min' => 'El :attribute debe ser mínimo de 10 caracteres.',
      'nombre_contacto.max' => 'El :attribute debe ser máximo de 60 caracteres.',

      'email_contacto.email' => 'El formate del campo :attribute es incorrecto.',
      'email_contacto.min' => 'El :attribute debe ser mínimo de 7 caracteres.',
      'email_contacto.max' => 'El :attribute debe ser máximo de 100 caracteres.',

      'telefono_contacto.numeric' => 'El :attribute debe ser numérico',
      'telefono_contacto.digits_between' => 'El :attribute debe tener entre 7 y 11 digitos',
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
      'nombre_contacto' => 'Nombre del Contacto',
      'email_contacto' => 'Email del Contacto',
      'telefono_contacto' => 'Teléfono del Contacto',
      ];
    }
  }
