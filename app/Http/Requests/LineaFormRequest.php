<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Routing\Route;

class LineaFormRequest extends FormRequest
{

    protected $route;

    public function __construct(Route $route)
    {
        $this->route = $route;
    }
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
            'txtabreviatura' => 'required|regex:/^([a-zA-ZñÑáéíóúÁÉÍÓÚ&_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ&_-]*)*)+$/|min:1|max:3|unique:lineastecnologicas,abreviatura,' . $this->route->parameter('linea'),
            'txtnombre'      => 'required|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ&_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ&_-]*)*)+$/|min:1|max:45|unique:lineastecnologicas,nombre,' . $this->route->parameter('linea'),
            'txtdescripcion' => 'nullable|max:2000',
        ];
    }

    public function messages()
    {
        return $messages = [
            'txtabreviatura.required' => 'La abreviatura es obligatoria.',
            'txtabreviatura.min'      => 'La abreviatura debe ser minimo 1 caracter',
            'txtabreviatura.max'      => 'La abreviatura debe ser máximo 3 caracteres',
            'txtabreviatura.regex'    => 'El campo abreviatura sólo debe contener letras o el carácter &',
            'txtabreviatura.unique'   => 'La abreviatura ingresada ya está en uso',
            'txtnombre.required'      => 'El nombre es obligatorio.',
            'txtnombre.min'           => 'El nombre debe ser minimo 1 caracter',
            'txtnombre.max'           => 'El nombre debe ser máximo 45 caracteres',
            'txtnombre.regex'         => 'El campo nombre sólo debe contener letras, números o el carácter &',
            'txtnombre.unique'        => 'El nombre ingresado ya está en uso',
            'txtdescripcion.max'      => 'La descripción debe ser máximo 2000 caracteres',

        ];
    }

    public function attributes()
    {
        return [
            'txtabreviatura' => 'abreviatura',
            'txtnombre'      => 'nombre',
            'txtdescripcion' => 'descripción',
        ];
    }
}
