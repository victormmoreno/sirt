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
            'password'    => 'required|min:8|max:100|current_password',
            'newpassword' => ['required', 'confirmed', 'min:8', 'max:100', new StrongPassword],
        ];
    }

    public function messages(): array
    {
        return [
            'password.required'         => 'La contraseña es obligatoria.',
            'password.min'              => 'La contraseña debe ser minimo 8 caracteres',
            'password.max'              => 'La contraseña debe ser máximo 100 caracteres',
            'password.current_password' => 'La contraseña ingresada no coincide con nuestros registros',
            'newpassword.confirmed'  => 'Las nuevas contraseñas ingresadas no coiniciden.',
            'newpassword.required'   => 'La nueva contraseña es obligatoria.',
            'newpassword.min'        => 'La contraseña debe ser minimo 8 caracteres',
            'newpassword.max'        => 'La contraseñ debe ser máximo 100 caracteres',
        ];
    }

    public function attributes(): array
    {
        return [
            'password'    => 'contraseña',
            'newpassword' => 'nueva contraseña',
        ];
    }

    /**
     * Get the sanitized input for the request.
     *
     * @return array
     */
    public function sanitize(): array
    {
        return $this->only('newpassword');
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
            if (Hash::check($this->newpassword, $this->user()->password)) {
                $validator->errors()->add('newpassword', 'Esta contraseña ya fue ingresada anteriormente.');
            }
        });
        return;
    }
}
