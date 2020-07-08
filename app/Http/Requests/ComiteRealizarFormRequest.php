<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ComiteRealizarFormRequest extends FormRequest
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
            'txtestadoidea.*' => 'required',
            'txtobservacionescomite' => 'max:1000'
        ];
    }

    public function messages()
    {
        $messages = [];
      $messages = [
        'txtobservacionescomite.max' => 'Las observaciones del comité deben ser máximo 1000 carácteres.'
      ];

        // dd(request());
        // exit();
      foreach(request()->get('txtestadoidea') as $key => $val)
      {
        $messages['txtestadoidea.'.$key.'.required'] = 'El próximo estado de la idea de proyecto #'.($key+1).' es obligatorio.';
      }
      return $messages;
    }
}
