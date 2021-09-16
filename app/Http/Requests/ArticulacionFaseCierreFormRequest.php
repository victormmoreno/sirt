<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticulacionFaseCierreFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'txtconclusiones' => 'required|max:1000',
            'txtsiguientes_investigaciones' => 'required|max:1000'
        ];
    }

    public function messages()
    {
        return $messages = [
            'txtconclusiones.required' => 'Las conclusiones de la articulación son obligatorias.',
            'txtconclusiones.max' => 'Las conclusiones de la articulación debe ser máximo de 1000 carácteres.',

            'txtsiguientes_investigaciones.required' => 'El siguiente paso de la articulación es obligatorio.',
            'txtsiguientes_investigaciones.max' => 'El siguiente paso de la articulación debe ser máximo de 1000 carácteres.',
        ];
    }

}
