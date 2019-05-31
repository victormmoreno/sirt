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
            'txtabreviatura' => 'required|alpha|min:1|max:3|unique:lineastecnologicas,abreviatura,' . $this->route->parameter('linea'),
            'txtnombre'      => 'required|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/|min:1|max:45|unique:lineastecnologicas,nombre,' . $this->route->parameter('linea'),
            'txtdescripcion' => 'max:2000',
        ];
    }

    public function messages()
    {
        return $messages = [
            'txtabreviatura.required' => 'La :attribute es obligatoria.',
            'txtabreviatura.min'      => 'La :attribute debe ser minimo 1 caracter',
            'txtabreviatura.max'      => 'La :attribute debe ser máximo 3 caracteres',
            'txtabreviatura.alpha'    => 'El campo :attribute sólo debe contener letras',
            'txtabreviatura.unique'   => 'La :attribute ingresada ya está en uso',
            'txtnombre.required'      => 'El :attribute es obligatorio.',
            'txtnombre.min'           => 'El :attribute debe ser minimo 1 caracter',
            'txtnombre.max'           => 'El :attribute debe ser máximo 45 caracteres',
            'txtnombre.regex'         => 'Ea formato del campo :attribute es incorrecto',
            'txtnombre.unique'        => 'El :attribute ingresado ya está en uso',
            'txtdescripcion.max'      => 'La :attribute debe ser máximo 2000 caracteres',

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
