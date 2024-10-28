<?php

namespace App\Http\Controllers\Idea;

use App\Http\Controllers\Controller;
use App\Http\Traits\Idea\StorageIdeaTrait;
use App\Repositories\Repository\UserRepository\UserRepository;

class StoreIdeaController extends Controller
{

    use StorageIdeaTrait;

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
