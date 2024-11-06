<?php

namespace App\Http\Controllers\Idea;

use App\Http\Controllers\Controller;
use App\Http\Traits\Idea\EnviarPostulacionIdeaTrait;
use App\Contracts\Idea\EnviarPostulacionIdea;
use App\Repositories\Repository\UserRepository\UserRepository;

class SendIdeaToNodoController extends Controller implements EnviarPostulacionIdea
{

    use EnviarPostulacionIdeaTrait;

    // public $userRepository;
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
    // public function __construct(UserRepository $userRepository)
    // {
    //     $this->middleware('auth');
    //     $this->userRepository = $userRepository;
    // }
}
