<?php

namespace App\Http\Controllers;

use App\Models\ActivationToken;

class ActivationTokenController extends Controller
{
    public function activate(ActivationToken $token)
    {
        // $token->user->update(['estado' => true]);

        // Auth::login($token->user);

        // $token->delete();
        //

        $token->user->activate();

        return redirect('home')->withInfo('Tu cuenta ha sido activada.');
    }
}
