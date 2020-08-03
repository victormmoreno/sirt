<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
}
