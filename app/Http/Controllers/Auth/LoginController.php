<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Cache;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Session;

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
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            session()->put('login_role', collect(\Auth::user()->roles)->first()->name);
            alert()->info('Señor(a), '.collect(auth()->user()->roles)->firstWhere('name', 'Administrador')->name.' '.auth()->user()->nombres. ' '. auth()->user()->apellidos. ' bienvenido a '. config('app.name'))->toToast();
            
            return $this->sendLoginResponse($request);

        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
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

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        // Session::flush();

        // return redirect()->route('/');
        
        return $this->loggedOut($request) ?: redirect('/');
    }

    protected function loggedOut(Request $request)
    {
        // $request->session()->flush();
        Session::flush();
        Cache::flush();
    }
}
