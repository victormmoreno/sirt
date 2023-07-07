<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\Repository\UserRepository\UserRepository;
use App\Http\Traits\User\SearchUsers;

class SearchUserController extends Controller
{
    public $userRepository;

    use SearchUsers;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->middleware('auth');
    }
}
