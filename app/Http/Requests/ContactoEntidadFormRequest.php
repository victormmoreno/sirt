<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactoEntidadFormRequest extends FormRequest
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
          'txtnombres_contactos.*' => 'required|regex:/^([a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/|min:10|max:60',
          'txtcorreo_contacto.*' => 'required|email|min:7|max:100',
          'txttelefono_contacto.*' => 'required|numeric|digits_between:7,11',
        ];
    }
    // $niceNames = [
    //   'txtnombres_contactos' => 'Nombres del Contacto',
    //   'txtcorreo_contacto' => 'Correo del Contacto',
    //   'txttelefono_contacto' => 'Teléfono del Contacto',
    // ];
    public function messages()
    {
      return $messages = [
        'txtnombres_contactos.*.regex' => 'Los Nombres del Contacto no tiene un formato válido.',
        'txtnombres_contactos.*.min' => 'Los Nombres del Contacto debe tener mínimo 10 caracteres.',
        'txtnombres_contactos.*.max' => 'Los Nombres del Contacto debe tener máximo de 60 caracteres.',

        'txtcorreo_contacto.*.email' => 'El Correo del Contacto no tiene un formato válido.',
        'txtcorreo_contacto.*.min' => 'El Correo del Contacto debe tener mínimo 7 caracteres.',
        'txtcorreo_contacto.*.max' => 'El Correo del Contacto no tiene un formato válido.',

        'txttelefono_contacto.*.numeric' => 'El Teléfono del Contacto debe ser numérico.',
        'txttelefono_contacto.*.digits_between' => 'El Teléfono del Contacto debe tener entre 7 y 11 dígitos.',
      ];
    }

    // Este método no está funcionando
    // public function attributes()
    // {
    //   return $attributes = [
    //         'txtnombres_contactos.*' => 'Nombres',
    //         'txtcorreo_contacto.*' => 'Correo',
    //         'txttelefono_contacto.*' => 'Teléfono',
    //       ];
    // }

}
