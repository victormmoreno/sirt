<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Traits\User\CompletiesTalentInformation;

class CompletationInformationTalentController extends Controller
{

    use CompletiesTalentInformation;

    /**
     * Where to redirect users after completation information talent.
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
        $this->middleware('auth');
        //$this->middleware('signed')->only('complete'); //complete
        // $this->middleware('throttle:6,1')->only('verify', 'resend');
    }
}
