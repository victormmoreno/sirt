<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
     */
    use AuthenticatesUsers;


    public $maxAttempts = 3;
    public $decayMinutes = 3;
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {

        $request['estado'] = true;
        return $request->only($this->username(), 'password', 'estado');
        // dd($request->only($this->username(), 'password', 'estado'));
        // // $credentials           = $request->only($this->username(), 'password');
        // // $credentials['estado'] = 1;

        // // return $credentials;
        // //

        // return ['email' => $request->{$this->username()}, 'password' => $request->password, 'estado' => true];
    }
}
