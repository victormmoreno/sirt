<?php

namespace App\Events\User;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class UserHasNewPasswordGenerated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $password;
    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user, $password, $message = null)
    {
        $this->user = $user;
        $this->password = $password;
        $this->message = $message;
    }
}
