<?php

namespace App\Http\Controllers;

use App\Models\ActivationToken;

class ActivationTokenController extends Controller
{
    public function activate(ActivationToken $token)
    {
       
        $token->user->activate();

        return redirect('home')->withInfo('Tu cuenta ha sido activada.');
    }
}
