<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ComiteAsignarFormRequest extends FormRequest
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
            'txtgestores.*' => 'required',
        ];
    }

    public function messages()
    {
        $messages = [];
    
        // dd(request());
        // exit();
      foreach(request()->get('txtgestores') as $key => $val)
      {
        $messages['txtgestores.'.$key.'.required'] = 'El experto a cargo de la idea de proyecto #'.($key+1).' es obligatorio.';
      }
      return $messages;
    }
}
