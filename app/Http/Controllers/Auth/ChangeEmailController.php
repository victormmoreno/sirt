<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Repository\UserRepository\UserRepository;
use App\User;

class ChangeEmailController extends Controller
{
    public $userRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->middleware('guest');
        $this->userRepository = $userRepository;
    }

    /**
     * mostrar formulario de solicitud de cambio de correo electrónico.
     *
     * @return \Illuminate\Http\Response
     */
    public function showEmailChangeRequestForm(){
        return view('auth.passwords.reset-email', [
            'tiposdocumentos'   => $this->userRepository->getAllTipoDocumento(),
        ]);
    }
    /**
     * cambiar correo electronico del usuario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function sendEmailChange(Request $request){

        $this->validateInputs($request);

        $response = $this->resetEmail(
            $this->credentials($request)
        );
        return is_null($response)
            ? $this->sendResetEmailFailedResponse($request, $response)
            : $this->ResetEmailResponse($request, $response);
    }

    /**
     * Validar el formulario para la solicitud dada.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateInputs(Request $request)
    {
        $request->validate([
            'type_document'=> 'required',
            'documento' => 'required|digits_between:6,11|numeric',
            'birthdate' => 'required|date|date_format:Y-m-d|before_or_equal:' . date('Y-m-d'),
            'email' => 'required|email|min:1|max:100|confirmed|unique:users,email,'
        ], [
            'type_document.required' => 'El tipo de documento es obligatorio',
            'documento.required'               => 'El número de documento es obligatorio.',
            'documento.digits_between'         => 'El número de documento debe tener entre 6 y 11 digitos',
            'documento.numeric'                => 'El número de documento debe ser numérico',
            'birthdate.required'        => 'La fecha de nacimiento es obligatoria.',
            'birthdate.date'            => 'La fecha de nacimiento no es una fecha válida.',
            'birthdate.before_or_equal' => 'La fecha de nacimiento  debe ser una fecha anterior o igual a la actual',
            'email.required'                   => 'El correo electrónico es obligatorio.',
            'email.min'                        => 'El correo electrónico debe ser minimo 1 caracter',
            'email.max'                        => 'El correo electrónico debe ser máximo 100 caracteres',
            'email.unique'                     => 'El correo electrónico ya ha sido registrado',
        ]);
    }

    /**
     * Obtenga las credenciales necesarias de la solicitud.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only(['type_document','documento', 'birthdate', 'email']);
    }

    /**
     * Restablecer correo electrónico.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function resetEmail(array $credentials)
    {
        $response = User::whereHas('tipoDocumento', function($q) use($credentials) {
            $q->where('id', $credentials["type_document"]);
        })
        ->where('documento',  $credentials["documento"])
        ->whereDate('fechanacimiento', $credentials["birthdate"])
        ->first();

        if (is_null($response)) {
            return back()
            ->with('error', trans('passwords.user'));
        }

        $response->email = $credentials["email"];
        $response->save();

        return $response;
    }

    /**
     * Get the response for a failed email reset.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetEmailFailedResponse(Request $request, $response)
    {
        return back()
            ->withInput($request->only(['type_document', 'documento']))
            ->with('error', trans('passwords.user'));
    }

    /**
     * Get the response for a successful email reset.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function ResetEmailResponse(Request $request, $response)
    {
        return back()->with('success', trans('passwords.resetEmail'));
    }

}
