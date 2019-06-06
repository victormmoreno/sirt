<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IdeaEGIFormRequest extends FormRequest
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
             'txtnidcod'         => 'required|min:1|max:45|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
             'txtnombreempgi'       => 'required|min:1|max:45|regex:/^([a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
             'txttipo_idea'          => 'required',
             'txtnombre_proyecto' => 'required|min:1|max:200|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
         ];
     }

     public function messages()
     {
         return $messages = [
             'txtnidcod.required'             => 'El :attribute es obligatorio.',
             'txtnidcod.min'                  => 'El :attribute debe ser minimo 1 caracter',
             'txtnidcod.max'                  => 'El :attribute debe ser máximo 45 caracteres',
             'txtnidcod.regex'                => 'El formato del campo :attribute es incorrecto',

             'txtnombreempgi.required'           => 'Los :attribute son obligatorios.',
             'txtnombreempgi.min'                => 'Los :attribute deben ser minimo 1 caracter',
             'txtnombreempgi.max'                => 'Los :attribute deben ser máximo 45 caracteres',
             'txtnombreempgi.regex'              => 'El formato del campo :attribute es incorrecto',

             'txttipo_idea.required' => 'Seleccione con quién se registrará la idea',

         ];
     }

     public function attributes()
     {
         return [
             'txtnidcod'         => 'Nit de la Empresa / Código del Grupo de Investigación',
             'txtnombreempgi'       => 'Nombre de la Empresa / Nombre del Grupo de Investigación',
             'txtnombre_proyecto'       => 'Nombre de proyecto',
             'txttipo_idea' => 'Tipo de Idea'
         ];
     }
}
