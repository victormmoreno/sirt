<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;

class MaterialesFormRequest extends FormRequest
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
        if (session()->has('login_role') && session()->get('login_role') == User::IsDinamizador()) {
            return [
                'txtlineatecnologica' => 'required',
                'txttipomaterial'     => 'required',
                'txtcategoria'        => 'required|min:1|max:45',
                'txtpresentacion'     => 'required|min:1|max:45',
                'txtmedida'           => 'required|min:1|max:45',
                'txtfecha'            => 'required|date|date_format:Y-m-d|before_or_equal:' . date('Y-m-d'),
                'txtcantidad'         => 'numeric|required|digits_between:1,10|min:1',
                'txtnombre'           => 'required|min:1|max:1000',
                'txtvalorcompra'      => 'numeric|required|between:1,9999999999999999.99|min:1',
                'txthorasuso'         => 'numeric|required|digits_between:1,10|min:1',
                'txtmarca'            => 'required|min:1|max:45',
                'txtproveedor'        => 'required|min:1|max:45',
            ];
        } elseif (session()->has('login_role') && session()->get('login_role') == User::IsGestor()) {
            return [
                'txttipomaterial'     => 'required',
                'txtcategoria'        => 'required|min:1|max:45',
                'txtpresentacion'     => 'required|min:1|max:45',
                'txtmedida'           => 'required|min:1|max:45',
                'txtfecha'            => 'required|date|date_format:Y-m-d|before_or_equal:' . date('Y-m-d'),
                'txtcantidad'         => 'numeric|required|digits_between:1,10|min:1',
                'txtnombre'           => 'required|min:1|max:1000',
                'txtvalorcompra'      => 'numeric|required|between:1,9999999999999999.99|min:1',
                'txthorasuso'         => 'numeric|required|digits_between:1,10|min:1',
                'txtmarca'            => 'required|min:1|max:45',
                'txtproveedor'        => 'required|min:1|max:45',
            ];
        }
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'txtlineatecnologica.required' => 'La linea tecnológica es obligatoria.',
            'txttipomaterial.required'     => 'El tipo de material es obligatorio.',
            'txtcategoria.required'        => 'La Categoria del material es obligatorio.',
            'txtpresentacion.required'     => 'La presentación del material es obligatoria.',
            'txtmedida.required'           => 'La unidad de medida del material es obligatoria.',

            'txtfecha.required'        => 'La fecha de adquisición del material es obligatoria.',
            'txtfecha.date'            => 'La fecha de adquisición del materialno es una fecha válida.',
            'txtfecha.before_or_equal' => 'La fecha de adquisición del material debe ser una fecha anterior o igual a la fecha de hoy',

            'txtcantidad.required'         => 'La cantidad adquirida del material es obligatoria.',
            'txtcantidad.numeric'          => 'La cantidad adquirida del material debe ser un número entero.',
            'txtcantidad.digits_between'   => 'La cantidad adquirida del material debe tener entre 1 y 10 dígitos.',
            'txtcantidad.min'              => 'La cantidad adquirida del material debe ser de al menos 1.',

            'txtnombre.required'           => 'El nombre del material  es obligatorio.',
            'txtnombre.min'                => 'El nombre  del material debe contener al menos 1 caracter.',
            'txtnombre.max'                => 'El nombre del material debe ser máximo de 1000 caracteres.',

            'txtvalorcompra.required'      => 'El valor total del material es obligatorio.',
            'txtvalorcompra.numeric'       => 'El valor total del material debe ser un número entero.',
            'txtvalorcompra.between'       => 'El valor total del material debe tener entre 1 y 9999999999999999.99 dígitos.',
            'txtvalorcompra.min'           => 'El valor total del material debe ser de al menos 1.',

            'txthorasuso.required'         => 'La cantidad de horas promedio al año del material es obligatoria.',
            'txthorasuso.numeric'          => 'La cantidad de horas promedio al año del material debe ser un número entero.',
            'txthorasuso.digits_between'   => 'La cantidad de horas promedio al año del material debe tener entre 1 y 10 dígitos.',
            'txthorasuso.min'              => 'La cantidad de horas promedio al año del material debe ser de al menos 1.',

            'txtmarca.required'            => 'La marca del material es obligatorio.',
            'txtmarca.min'                 => 'La marca del material debe contener al menos 1 caracter.',
            'txtmarca.max'                 => 'La marca del material debe ser máximo de 45 caracteres.',

            'txtproveedor.required'        => 'El proveedor del material es obligatorio.',
            'txtproveedor.min'             => 'El proveedor del material debe contener al menos 1 caracter.',
            'txtproveedor.max'             => 'El proveedor del material debe ser máximo de 45 caracteres.',

        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'txtlineatecnologica' => 'linea tecnológica',
            'txttipomaterial'     => 'tipo material',
        ];
    }
}
