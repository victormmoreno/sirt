<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
Use App\User;

class UnregisteredUserVerificationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only('document_type', 'document');
    }

    /**
     * Manejar una solicitud de verificación de usuario no registrado para la aplicación.
     *
     * @return \Illuminate\Http\Response
     */
    public function verificationUser(Request $request)
    {
        $validator = Validator::make($this->credentials($request), [
            'document_type' => 'required',
            'document' => 'required|digits_between:6,11|numeric',
        ], [
            'document_type.required'    => 'El tipo de documento es obligatorio',
            'document.required'               => 'El número de documento es obligatorio.',
            'document.digits_between'         => 'El número de documento debe tener entre 6 y 11 digitos',
            'document.numeric'                => 'El número de documento debe ser numérico',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'fail'   => true,
                'errors' => $validator->errors(),
            ]);
        }
        $this->credentials($request);

        $user = User::withTrashed()->select('documento')
        ->where('documento',  $request->input('document'))->first();

        if(isset($user)){
            return response()->json([
                'data' => [
                    'user' => true,
                ]
            ]);

        }else{
            return response()->json([
                'data' => [
                    'user' => false,
                ]
            ]);
        }
    }
}
