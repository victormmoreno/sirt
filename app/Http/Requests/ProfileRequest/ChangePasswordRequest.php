<?php

namespace App\Http\Requests\ProfileRequest;

use App\Rules\Users\StrongPassword;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class ChangePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'txtpassword'    => 'required|min:8|max:100|current_password',
            'txtnewpassword' => ['required', 'confirmed', 'min:8', 'max:100', new StrongPassword],
        ];
    }

    public function messages(): array
    {
        return [
            'txtpassword.required'         => 'La contraseña es obligatoria.',
            'txtpassword.min'              => 'La contraseña debe ser minimo 8 caracteres',
            'txtemail.max'                 => 'La contraseña debe ser máximo 100 caracteres',
            'txtpassword.current_password' => 'La contraseña ingresada no coincide con nuestros registros',

            'txtnewpassword.confirmed'     => 'Las nuevas contraseñas ingresadas no coiniciden.',
            'txtnewpassword.required'      => 'La nueva contraseña es obligatoria.',
            'txtnewpassword.min'           => 'La contraseña debe ser minimo 8 caracteres',
            'txtnewpassword.max'           => 'La contraseñ debe ser máximo 100 caracteres',
        ];
    }

    public function attributes(): array
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
    public function sanitize(): array
    {
        return $this->only('txtnewpassword');
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {

        $validator->after(function ($validator) {
            if (Hash::check($this->txtnewpassword, $this->user()->password)) {
                $validator->errors()->add('txtnewpassword', 'Esta contraseña ya fue ingresada anteriormente.');
            }
        });

        return;
    }

}
