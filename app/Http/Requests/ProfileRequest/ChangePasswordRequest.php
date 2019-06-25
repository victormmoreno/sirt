<?php

namespace App\Http\Requests\ProfileRequest;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'txtpassword' => 'required|min:8|max:100|current_password',
            'txtnewpassword' => 'confirmed|min:8|max:100'
        ];
    }

    public function messages()
    {
        return [
            'txtpassword.required'  => 'La contraseña es obligatoria.',
            'txtpassword.min'   => 'La contraseña debe ser minimo 8 caracteres',
            'txtemail.max'   => 'La contraseñ debe ser máximo 100 caracteres',
            'txtpassword.current_password' => 'La contraseña ingresada no coincide con nuestros registros',

            'txtnewpassword.confirmed' => 'Las nuevas contraseñas ingresadas no coiniciden.',
            'txtnewpassword.min'   => 'La contraseña debe ser minimo 8 caracteres',
            'txtnewpassword.max'   => 'La contraseñ debe ser máximo 100 caracteres',
        ];
    }

    public function attributes()
    {
        return [
            'txtpassword'    => 'contraseña',
            'txtnewpassword' => 'nueva contraseña',
        ];
    }
 
    /**
     * Get the sanitized input for the request.
     *
     * @return array
     */
    public function sanitize()
    {
        return $this->only('txtnewpassword');
    }

    
}
