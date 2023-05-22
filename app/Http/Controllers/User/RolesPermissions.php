<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class RolesPermissions extends Controller
{
    public $userRepository;
    public function __construct()
    {
        $this->middleware('auth');
    }

    public static function changeRoleSession(Request $request)
    {

        session()->put('login_role', collect(auth()->user()->roles)->first()->name);
        if ($request->ajax()) {
            if (session()->has('login_role') && session()->get('login_role') == $request->get('role')) {
                $value = session()->get('login_role');
            } else {
                session()->put('login_role', $request->get('role'));
                $value = session()->get('login_role');
            }
        } else {
            $value = session()->get('login_role');
        }
        return response()->json([
            'role' => $value,
            'url'  => route('home'),
        ]);
    }

    public function tomar_control(Request $request, $id)
    {
        if (request()->user()->cannot('tomar_control', User::class)) {
            alert()->warning(__('Sorry, you are not authorized to access the page') . ' ' . request()->path())->toToast()->autoClose(10000);
            return redirect()->route('home');
        }
        session()->put('before_session', User::find($request->user()->id));
        $user = User::find($id);
        Auth::login($user);
        RolesPermissions::changeRoleSession($request);
        return redirect()->route('home');
    }

    public function dejar_control(Request $request)
    {
        Auth::login(session()->get('before_session'));
        $request->session()->forget('before_session');
        RolesPermissions::changeRoleSession($request);
        return redirect()->route('home');
    }

}
