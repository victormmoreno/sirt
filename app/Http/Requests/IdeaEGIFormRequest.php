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
             'txtnidcod' => 'required|min:1|max:45|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
             'txtnombreempgi' => 'required|min:1|max:45|regex:/^([a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
             'txttipo_idea' => 'required',
             'txtnombre_proyecto' => 'required|min:1|max:200|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
         ];
     }

     public function messages()
     {
         return $messages = [
             'txtnidcod.required' => 'El Nit de la Empresa / Código del Grupo de Investigación es obligatorio.',
             'txtnidcod.min' => 'El Nit de la Empresa / Código del Grupo de Investigación debe ser minimo 1 caracter',
             'txtnidcod.max' => 'El Nit de la Empresa / Código del Grupo de Investigación debe ser máximo 45 caracteres',
             'txtnidcod.regex' => 'El formato del campo Nit de la Empresa / Código del Grupo de Investigación es incorrecto',

             'txtnombreempgi.required' => 'Los Nombre de la Empresa / Nombre del Grupo de Investigación son obligatorios.',
             'txtnombreempgi.min' => 'Los Nombre de la Empresa / Nombre del Grupo de Investigación deben ser minimo 1 caracter',
             'txtnombreempgi.max' => 'Los Nombre de la Empresa / Nombre del Grupo de Investigación deben ser máximo 45 caracteres',
             'txtnombreempgi.regex' => 'El formato del campo Nombre de la Empresa / Nombre del Grupo de Investigación es incorrecto',

             'txtnombre_proyecto.required' => 'El Nombre de la Idea de Proyecto es obligatorio.',
             'txtnombre_proyecto.min' => 'El Nombre de la Idea de Proyecto debe ser mínimo 1 carácter.',
             'txtnombre_proyecto.max' => 'El Nombre de la Idea de Proyecto debe ser máximo 200 carácteres.',
             'txtnombre_proyecto.regex' => 'El Nombre de la Idea de Proyecto no tiene un formato válido.',

             'txttipo_idea.required' => 'Seleccione con quién se registrará la idea',

         ];
     }

     public function attributes()
     {
         return [
             'txtnidcod' => 'Nit de la Empresa / Código del Grupo de Investigación',
             'txtnombreempgi' => 'Nombre de la Empresa / Nombre del Grupo de Investigación',
             'txtnombre_proyecto' => 'Nombre de proyecto',
             'txttipo_idea' => 'Tipo de Idea'
         ];
     }
}
