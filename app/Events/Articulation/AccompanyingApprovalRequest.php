<?php

namespace App\Events\Articulation;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AccompanyingApprovalRequest
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $notification;
    public $recipients;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($notification, $recipients)
    {
        $this->notification = $notification;
        $this->recipients = $recipients;
    }
}
