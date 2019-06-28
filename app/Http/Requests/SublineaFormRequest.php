<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SublineaFormRequest extends FormRequest
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
            'txtnombre' => 'required|min:1|max:100|regex:/^([a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/|unique:sublineas,nombre,' . $this->route('sublinea'),
            'txtlinea'  => 'required',

        ];
    }

    public function messages()
    {
        return $messages = [
            'txtnombre.required' => 'El nombre es obligatorio.',
            'txtnombre.min'      => 'El nombre debe ser minimo 1 caracter',
            'txtnombre.max'      => 'El nombre debe ser máximo 100 caracteres',
            'txtnombre.regex'    => 'El formato del campo nombre es incorrecto',
            'txtnombre.unique'   => 'La sublinea ya ha sido registrada',
            'txtlinea.required'  => 'La linea es obligatoria.',
        ];
    }

    public function attributes()
    {
        return [
            'txtnombre' => 'nombre',
            'txtlinea'  => 'linea',
        ];
    }

}
