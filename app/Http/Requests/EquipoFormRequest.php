<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\User;

class EquipoFormRequest extends FormRequest
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
            'txtnodo_id'          => Rule::requiredIf(session()->get('login_role') == User::IsAdministrador()),
            'txtlineatecnologica' => 'required',
            'txtreferencia'       => 'required|min:1|max:45',
            'txtnombre'           => 'required|min:1|max:45',
            'txtmarca'            => 'required|min:1|max:45|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ._-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ._-]*)*)+$/',
            'txtcostoadquisicion' => 'required|between:0,999999999999.99|numeric',
            'txtvida_util'        => 'required|integer|min:1',
            'txtaniocompra'       => 'required|date_format:"Y"',
            'txthorasuso'       => 'required|integer|min:1',
        ];
    }

    public function messages()
    {
        return $messages = [
            'txtnodo_id.required' => 'El nodo es obligatorio.',
            'txtlineatecnologica.required' => 'La Linea Tecnológica es obligatoria.',
            'txtreferencia.required'       => 'La referencia del equipo es obligatoria.',
            'txtreferencia.min'            => 'La referencia del equipo debe ser minimo 1 caracter',
            'txtreferencia.max'            => 'La referencia del equipo  debe ser máximo 45 caracteres',

            'txtnombre.required'           => 'El nombre de equipo es obligatorio.',
            'txtnombre.min'                => 'El nombre de equipo debe ser minimo 1 caracter',
            'txtnombre.max'                => 'El nombre de equipo debe ser máximo 45 caracteres',
            'txtnombre.regex'              => 'El formato del campo nombre de equipo es incorrecto',

            'txtmarca.required'            => 'La marca del equipo es obligatoria.',
            'txtmarca.min'                 => 'La marca del equipo debe ser minimo 1 caracter',
            'txtmarca.max'                 => 'La marca del equipo  debe ser máximo 45 caracteres',
            'txtmarca.regex'               => 'El formato del campo marca del equipo es incorrecto',

            'txtcostoadquisicion.required' => 'El valor del costo de Adquisición es obligatorio.',
            'txtcostoadquisicion.between'  => 'El valor del costo de Adquisición tiene que estar entre 0 - 999999999999.99.',
            'txtcostoadquisicion.numeric'  => 'El valor del costo de Adquisición debe ser numérico.',

            'txtvida_util.required'        => 'La vida util es obligatoria.',
            'txtvida_util.min'             => 'La vida util debe ser minimo 1 caracter',
            'txtvida_util.max'             => 'La vida util  debe ser máximo 4 caracteres',
            'txtvida_util.integer'         => 'La vida util debe ser un número entero.',

            'txthorasuso.required'        => 'El promedio de horas de uso al año es obligatorio.',
            'txthorasuso.min'             => 'El promedio de horas de uso al año debe ser minimo 1 caracter',
            'txthorasuso.max'             => 'El promedio de horas de uso al año  debe ser máximo 4 caracteres',
            'txthorasuso.integer'         => 'El promedio de horas de uso al año debe ser un número entero.',

            'txtaniocompra.required'       => 'El año de compra es obligatorio.',
            'txtaniocompra.date_format'    => 'El año de compra no corresponde al formato de año.',

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
