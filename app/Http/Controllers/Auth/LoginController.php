<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Cache;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Contracts\Auth\UserProvider;
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

    public $maxAttempts  = 3;
    public $decayMinutes = 3;

    /**
     * The user we last attempted to retrieve.
     *
     * @var \Illuminate\Contracts\Auth\Authenticatable
     */
    protected $lastAttempted;
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * The user provider implementation.
     *
     * @var \Illuminate\Contracts\Auth\UserProvider
     */
    protected $provider;


    /**
     * Create a new authentication guard.
     *
     * @param  string  $name
     * @param  \Illuminate\Contracts\Auth\UserProvider  $provider
     * @param  \Illuminate\Contracts\Session\Session  $session
     * @param  \Symfony\Component\HttpFoundation\Request|null  $request
     * @return void
     */
    public function __construct(UserProvider $provider)
    {
        $this->provider = $provider;
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
        if (
            method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)
        ) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            session()->put('login_role', collect(\Auth::user()->roles)->first()->name);
            alert()->info('Señor(a), ' . collect(auth()->user()->roles)->firstWhere('name', auth()->user()->roles->first()->name)->name . ' ' . auth()->user()->nombres . ' ' . auth()->user()->apellidos . ' bienvenido a ' . config('app.name'))->toToast();

            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        dd($this->provider->retrieveByCredentials($this->credentials($request)));
        return $this->guard()->attempt(
            $this->credentials($request), $request->filled('remember')
        );
    }

    // /**
    //  * Attempt to authenticate a user using the given credentials.
    //  *
    //  * @param  array  $credentials
    //  * @param  bool   $remember
    //  * @return bool
    //  */
    // public function attempt(array $credentials = [], $remember = false)
    // {
    //     $this->fireAttemptEvent($credentials, $remember);

    //     $this->lastAttempted = $user = $this->provider->retrieveByCredentials($credentials);

    //     // If an implementation of UserInterface was returned, we'll ask the provider
    //     // to validate the user against the given credentials, and if they are in
    //     // fact valid we'll log the users into the application and return true.
    //     if ($this->hasValidCredentials($user, $credentials)) {
    //         $this->login($user, $remember);

    //         return true;
    //     }

    //     // If the authentication attempt fails we will fire an event so that the user
    //     // may be notified of any suspicious attempts to access their account from
    //     // an unrecognized user. A developer may listen to this event as needed.
    //     $this->fireFailedEvent($user, $credentials);

    //     return false;
    // }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            $this->password() => 'required|string',
        ], [
            'email.required'    => 'El correo electrónico es obligatorio',
            'password.required' => 'La contraseña es obligatoria.',
        ]);
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
        return $request->only($this->username(), $this->password(), 'estado');

    }

    private function password()
    {
        return 'password';
    }


    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();
        return $this->loggedOut($request) ?: redirect('/');
    }

    protected function loggedOut(Request $request)
    {
        Session::flush();
        Cache::flush();
    }
}
