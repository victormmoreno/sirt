<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Traits\User\CompletiesTalentInformation;
use App\Repositories\Repository\UserRepository\UserRepository;

class CompletationInformationTalentController extends Controller
{

    use CompletiesTalentInformation;

    public $userRepository;
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
    public function __construct(UserRepository $userRepository)
    {
        $this->middleware('auth');
        $this->userRepository = $userRepository;
    }
}
