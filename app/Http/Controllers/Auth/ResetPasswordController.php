<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Rules\Users\StrongPassword;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
     */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function credentials(Request $request)
    {
        $request['estado'] = true;
        return $request->only(
            'email', 'password', 'password_confirmation', 'token', 'estado'
        );
    }

    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'token'    => 'required',
            'email'    => ['required', 'email', 'min:1', 'max:100'],
            'password' => ['required','confirmed','min:8','max:100',new StrongPassword],
        ];
    }

    /**
     * Get the password reset validation error messages.
     *
     * @return array
     */
    protected function validationErrorMessages()
    {
        return [
            'email.required'     => 'El correo electrónico es obligatorio',
            'email.min'          => 'El correo electrónico debe ser minimo 1 caracter',
            'email.max'          => 'El correo electrónico debe ser máximo 100 caracteres',

            'password.required'  => 'La contraseña es obligatoria.',
            'password.confirmed' => 'Las contraseñas ingresadas no coiniciden.',
            'password.min'       => 'La contraseña debe ser minimo 8 caracteres',
            'password.max'       => 'La contraseña debe ser máximo 100 caracteres',
        ];
    }

    protected function resetPassword($user, $password)
    {
        $user->password = $password;

        $user->save();

        event(new PasswordReset($user));

        $this->guard()->logout();

        return redirect('login');
    }
}
