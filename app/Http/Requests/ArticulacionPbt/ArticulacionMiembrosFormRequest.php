<?php

namespace App\Http\Requests\ArticulacionPbt;

use Illuminate\Foundation\Http\FormRequest;


class ArticulacionMiembrosFormRequest extends FormRequest
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
         
            'talentos' => 'required',
            'txttalento_interlocutor'=>'required',
        ];
    }

    public function messages()
    {
        return $messages = [
                
            'txttalento_interlocutor.required'=>'Debe haber un interlocutor',
    
     
            'talentos.required' => 'Debe asociar por lo menos un talento a la articulación.'
           
        ];
    }
}