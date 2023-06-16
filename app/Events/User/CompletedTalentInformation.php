<?php

namespace App\Events\User;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class CompletedTalentInformation
{
    use SerializesModels;


    /**
     * The completed information talent.
     *
     * @var \App\Contracts\User\MustCompleteTalentInformation
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @param  \App\Contracts\User\MustCompleteTalentInformation  $user
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }
}
